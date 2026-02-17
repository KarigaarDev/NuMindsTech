<?php
require_once __DIR__ . '/BaseController.php';

/**
 * ClientPortalController
 * Handles client portal operations
 */
class ClientPortalController extends BaseController {

    /**
     * Display client dashboard
     */
    public function index() {
        $this->requireAuth();

        // Ensure only clients can access (or admins masquerading)
        if ($this->userRole !== 'client' && !Auth::isAdmin()) {
            redirect('dashboard');
        }

        // Fetch client websites
        $websites = $this->getClientWebsites($this->userId);

        // Fetch client services
        $services = $this->getClientServices($this->userId);

        $this->render('dashboard/client_dashboard', [
            'title' => 'Client Console',
            'websites' => $websites,
            'services' => $services,
            'userId' => $this->userId
        ]);
    }

    /**
     * Get client websites
     */
    private function getClientWebsites($userId) {
        $stmt = $this->pdo->prepare("
            SELECT * FROM client_websites
            WHERE user_id = ?
            ORDER BY created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get client services
     */
    private function getClientServices($userId) {
        $stmt = $this->pdo->prepare("
            SELECT * FROM client_services
            WHERE user_id = ?
            ORDER BY expiry_date ASC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get client invoices
     */
    public function getClientInvoices($userId) {
        $stmt = $this->pdo->prepare("
            SELECT * FROM invoices
            WHERE user_id = ?
            ORDER BY created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
