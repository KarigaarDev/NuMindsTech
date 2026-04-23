<?php
// app/controllers/TestimonialsController.php
require_once __DIR__ . '/BaseController.php';

class TestimonialsController extends BaseController {

    public function index($action = 'list', $id = null) {
        $this->requireAuth();
        $this->requireAdmin();

        if ($action === 'list') {
            $stmt = $this->pdo->query("SELECT * FROM testimonials ORDER BY display_order ASC, created_at DESC");
            $testimonials = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $this->render('dashboard/testimonials', [
                'title' => 'Testimonials',
                'testimonials' => $testimonials
            ]);
        } elseif (in_array($action, ['create', 'edit'])) {
            $testimonial = null;
            if ($action === 'edit' && $id) {
                $stmt = $this->pdo->prepare("SELECT * FROM testimonials WHERE id = ?");
                $stmt->execute([$id]);
                $testimonial = $stmt->fetch(PDO::FETCH_ASSOC);
            }
            
            $this->render('dashboard/testimonial-form', [
                'title' => ($action === 'create' ? 'Add' : 'Edit') . ' Testimonial',
                'testimonial' => $testimonial,
                'action' => $action
            ]);
        }
    }

    public function store($data) {
        $this->requireAuth();
        $this->requireAdmin();
        Csrf::verify();

        $name = Validator::sanitizeString($data['client_name']);
        $position = Validator::sanitizeString($data['client_position'] ?? '');
        $content = Validator::sanitizeString($data['content']);
        $order = (int)($data['display_order'] ?? 0);
        $status = $data['status'] === 'active' ? 'active' : 'hidden';

        $avatar = null;
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $upload = $_FILES['avatar'];
            $allowedMimes = ['image/png','image/jpeg','image/webp'];
            $allowedExts = ['png','jpg','jpeg','webp'];

            if (!Validator::validateFile($upload, $allowedMimes, $allowedExts)) {
                return false; // Or handle error appropriately
            }

            $ext = strtolower(pathinfo($upload['name'], PATHINFO_EXTENSION));
            $newName = 'testimonial_' . time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
            if (move_uploaded_file($upload['tmp_name'], __DIR__ . '/../../public/uploads/' . $newName)) {
                $avatar = $newName;
            }
        }

        $stmt = $this->pdo->prepare("INSERT INTO testimonials (client_name, client_position, content, status, display_order, avatar) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $position, $content, $status, $order, $avatar]);

        Logger::adminAction($this->userId, 'CREATE_TESTIMONIAL', "Added testimonial from $name");
        return $this->pdo->lastInsertId();
    }

    public function update($id, $data) {
        $this->requireAuth();
        $this->requireAdmin();
        Csrf::verify();

        $name = Validator::sanitizeString($data['client_name']);
        $position = Validator::sanitizeString($data['client_position'] ?? '');
        $content = Validator::sanitizeString($data['content']);
        $order = (int)($data['display_order'] ?? 0);
        $status = $data['status'] === 'active' ? 'active' : 'hidden';

        // Check if an existing testimonial is being updated
        $stmt = $this->pdo->prepare("SELECT avatar FROM testimonials WHERE id = ?");
        $stmt->execute([$id]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);
        $avatar = $existing['avatar'] ?? null;

        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $upload = $_FILES['avatar'];
            $allowedMimes = ['image/png','image/jpeg','image/webp'];
            $allowedExts = ['png','jpg','jpeg','webp'];

            if (!Validator::validateFile($upload, $allowedMimes, $allowedExts)) {
                return false; // Or handle error appropriately
            }

            $ext = strtolower(pathinfo($upload['name'], PATHINFO_EXTENSION));
            $newName = 'testimonial_' . time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
            if (move_uploaded_file($upload['tmp_name'], __DIR__ . '/../../public/uploads/' . $newName)) {
                $avatar = $newName;
                
                // Optionally delete the old file to save space
                if ($existing['avatar'] && file_exists(__DIR__ . '/../../public/uploads/' . $existing['avatar'])) {
                    @unlink(__DIR__ . '/../../public/uploads/' . $existing['avatar']);
                }
            }
        }

        $stmt = $this->pdo->prepare("UPDATE testimonials SET client_name = ?, client_position = ?, content = ?, status = ?, display_order = ?, avatar = ? WHERE id = ?");
        $stmt->execute([$name, $position, $content, $status, $order, $avatar, $id]);

        Logger::adminAction($this->userId, 'UPDATE_TESTIMONIAL', "Updated testimonial for $name");
        return true;
    }

    public function delete($id) {
        $this->requireAuth();
        $this->requireAdmin();
        Csrf::verify();

        $stmt = $this->pdo->prepare("DELETE FROM testimonials WHERE id = ?");
        $stmt->execute([$id]);

        Logger::adminAction($this->userId, 'DELETE_TESTIMONIAL', "Deleted testimonial #$id");
        return true;
    }
}
