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

        $stmt = $this->pdo->prepare("INSERT INTO testimonials (client_name, client_position, content, status, display_order) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $position, $content, $status, $order]);

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

        $stmt = $this->pdo->prepare("UPDATE testimonials SET client_name = ?, client_position = ?, content = ?, status = ?, display_order = ? WHERE id = ?");
        $stmt->execute([$name, $position, $content, $status, $order, $id]);

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
