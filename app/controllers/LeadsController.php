<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../core/Recaptcha.php';
require_once __DIR__ . '/../core/Email.php';

/**
 * LeadsController
 * Handles lead management operations
 */
class LeadsController extends BaseController {

    /**
     * Display all leads with pagination
     */
    public function index() {
        $this->requireAuth();
        $this->requireAdmin();

        // Get pagination parameters
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage = isset($_GET['per_page']) ? max(1, min(100, (int)$_GET['per_page'])) : 20;

        // Get total lead count
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM leads");
        $totalLeads = $stmt->fetchColumn();

        // Create paginator
        $paginator = new Paginator($totalLeads, $perPage, $page);

        // Get paginated leads (ordered by newest first)
        $leads = $this->getPaginatedLeads($paginator->offset(), $paginator->limit());

        $this->render('dashboard/leads', [
            'title' => 'Leads',
            'leads' => $leads,
            'paginator' => $paginator
        ]);
    }

    /**
     * Display single lead details
     */
    public function show($leadId) {
        $this->requireAuth();
        $this->requireAdmin();

        $lead = $this->getLead($leadId);
        if (!$lead) {
            http_response_code(404);
            die('Lead not found');
        }

        $this->render('dashboard/lead-view', [
            'title' => 'Lead Details',
            'lead' => $lead
        ]);
    }

    /**
     * Create a new lead (from public form)
     */
    public function store($data) {
        // CSRF verification should be done before calling this
        Csrf::verify();

        // Check rate limiting (max 3 submissions per IP per hour)
        $rateLimiter = new RateLimiter('lead_submit', 3, 3600);
        if ($rateLimiter->isLimited()) {
            Logger::security('RATE_LIMIT_EXCEEDED', 'Lead submission rate limit exceeded', [
                'ip_address' => $_SERVER['REMOTE_ADDR']
            ]);
            http_response_code(429);
            die('You have submitted too many leads. ' . $rateLimiter->getWaitMessage());
        }

        // Validate input
        $rules = [
            'name' => 'required|min:2|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|phone',
            'message' => 'required|min:10|max:5000|spam_terms|max_links:2',
            'service_type' => 'max:100',
            'contact_method' => 'max:50',
            'contact_time' => 'max:100',
            'website_url' => 'honeypot'
        ];

        // Check submission timer (must be at least 3 seconds)
        $startTime = isset($data['submission_start']) ? (int)$data['submission_start'] : 0;
        $now = time();
        if ($startTime > 0 && ($now - $startTime) < 3) {
            Logger::security('BOT_SUBMISSION_DETECTED', 'Submission too fast (possible bot)', [
                'ip_address' => $_SERVER['REMOTE_ADDR'],
                'time_taken' => $now - $startTime
            ]);
            http_response_code(422);
            die(json_encode(['success' => false, 'message' => 'Try again after some time']));
        }

        if (!Validator::validate($data, $rules)) {
            Logger::security('VALIDATION_FAILED', 'Lead form validation failed', [
                'errors' => Validator::errors(),
                'ip_address' => $_SERVER['REMOTE_ADDR']
            ]);
            http_response_code(422);
            die(json_encode(['success' => false, 'errors' => Validator::errors()]));
        }

        // ✅ Phase 2: reCAPTCHA Verification
        $recaptchaToken = $data['g-recaptcha-response'] ?? null;
        Recaptcha::setSecret(setting('recaptcha_secret_key'));
        if (!Recaptcha::verify($recaptchaToken)) {
            if (!empty(setting('recaptcha_secret_key'))) {
                Logger::security('RECAPTCHA_FAILED', 'reCAPTCHA verification failed', [
                    'ip_address' => $_SERVER['REMOTE_ADDR']
                ]);
                http_response_code(422);
                die(json_encode(['success' => false, 'message' => 'Security verification failed. Please try again.']));
            }
        }

        // Sanitize inputs
        $name = Validator::sanitizeString($data['name']);
        $email = Validator::sanitizeEmail($data['email']);
        $phone = Validator::sanitizeString($data['phone']);
        $serviceType = Validator::sanitizeString($data['service_type'] ?? '');
        $contactMethod = Validator::sanitizeString($data['contact_method'] ?? 'Call');
        $contactTime = Validator::sanitizeString($data['contact_time'] ?? '');
        $message = Validator::sanitizeString($data['message']);

        // Insert lead
        $stmt = $this->pdo->prepare("
            INSERT INTO leads
            (name, phone, email, service_type, contact_method, contact_time, message, ip_address)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $name,
            $phone,
            $email,
            $serviceType,
            $contactMethod,
            $contactTime,
            $message,
            $_SERVER['REMOTE_ADDR']
        ]);

        $leadId = $this->pdo->lastInsertId();

        // ✅ Phase 3: Email Notification
        Email::notifyNewLead([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'project_detail' => $message
        ]);

        // Record the attempt for rate limiting
        $rateLimiter->recordAttempt();

        // Log the submission
        Logger::info('Lead submitted', [
            'name' => $name,
            'email' => $email,
            'ip_address' => $_SERVER['REMOTE_ADDR']
        ]);

        return $leadId;
    }

    /**
     * Update lead status
     */
    public function updateStatus($leadId, $status) {
        $this->requireAuth();
        $this->requireAdmin();

        $allowedStatuses = ['new', 'contacted', 'converted', 'lost'];
        if (!in_array($status, $allowedStatuses)) {
            http_response_code(400);
            die('Invalid status');
        }

        $stmt = $this->pdo->prepare("UPDATE leads SET status = ? WHERE id = ?");
        $result = $stmt->execute([$status, $leadId]);

        Logger::adminAction($this->userId, 'UPDATE_LEAD_STATUS', "Moved lead #$leadId to $status", [
            'lead_id' => $leadId,
            'status' => $status
        ]);

        return $result;
    }

    /**
     * Add remark to lead
     */
    public function addRemark($leadId, $remark) {
        $this->requireAuth();
        $this->requireAdmin();

        $stmt = $this->pdo->prepare("
            UPDATE leads
            SET remarks = ?
            WHERE id = ?
        ");

        $result = $stmt->execute([$remark, $leadId]);

        // Log the admin action
        Logger::adminAction($this->userId, 'UPDATE_LEAD_REMARK', 'Added remark to lead #' . $leadId, [
            'lead_id' => $leadId,
            'remark' => substr($remark, 0, 100) // Log first 100 chars
        ]);

        return $result;
    }

    /**
     * Get paginated leads
     */
    private function getPaginatedLeads($offset, $limit) {
        // Cast to integers (LIMIT/OFFSET cannot be parameterized in prepared statements)
        $offset = (int)$offset;
        $limit = (int)$limit;
        $stmt = $this->pdo->query("
            SELECT * FROM leads
            ORDER BY created_at DESC
            LIMIT $limit OFFSET $offset
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get all leads (without pagination)
     */
    private function getAllLeads() {
        $stmt = $this->pdo->query("
            SELECT * FROM leads
            ORDER BY created_at DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get single lead
     */
    private function getLead($leadId) {
        $stmt = $this->pdo->prepare("
            SELECT * FROM leads
            WHERE id = ?
        ");
        $stmt->execute([$leadId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Search leads by keyword
     */
    public function search($keyword) {
        $this->requireAuth();
        $this->requireAdmin();

        $keyword = '%' . $keyword . '%';
        $stmt = $this->pdo->prepare("
            SELECT * FROM leads
            WHERE name LIKE ? OR email LIKE ? OR phone LIKE ?
            ORDER BY created_at DESC
        ");
        $stmt->execute([$keyword, $keyword, $keyword]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Delete lead
     */
    public function delete($leadId) {
        $this->requireAuth();
        $this->requireAdmin();

        Csrf::verify();

        $id = (int)$leadId;

        $stmt = $this->pdo->prepare("DELETE FROM leads WHERE id = ?");
        $result = $stmt->execute([$id]);

        Logger::adminAction($this->userId, 'DELETE_LEAD', "Deleted lead #$id", [
            'lead_id' => $id
        ]);

        return $result;
    }
}
