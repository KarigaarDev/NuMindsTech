<?php
require_once __DIR__ . '/BaseController.php';

class ThemeController extends BaseController {

    public function __construct($pdo) {
        parent::__construct($pdo);
        $this->pdo = $pdo;
        Auth::requireLogin();
        Auth::requireAdmin();
    }

    public function index() {
        $action = $_GET['action'] ?? 'list';
        $id = $_GET['id'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Csrf::verify();
            $this->handlePost($action, $id);
        }

        if ($action === 'list') {
            $themes = $this->pdo->query("SELECT * FROM themes ORDER BY is_active DESC, updated_at DESC")->fetchAll(PDO::FETCH_ASSOC);
            $this->render('dashboard/themes', [
                'title' => 'Theme Engine',
                'themes' => $themes
            ]);
        } elseif (in_array($action, ['create', 'edit'])) {
            $theme = null;
            if ($action === 'edit' && $id) {
                $stmt = $this->pdo->prepare("SELECT * FROM themes WHERE id = ?");
                $stmt->execute([$id]);
                $theme = $stmt->fetch(PDO::FETCH_ASSOC);
            }
            $this->render('dashboard/theme-form', [
                'title' => $action === 'create' ? 'Create Theme' : 'Edit Theme',
                'theme' => $theme
            ]);
        } elseif ($action === 'activate' && $id) {
            $this->pdo->beginTransaction();
            $this->pdo->exec("UPDATE themes SET is_active = 0");
            $stmt = $this->pdo->prepare("UPDATE themes SET is_active = 1 WHERE id = ?");
            $stmt->execute([$id]);
            $this->pdo->commit();
            $_SESSION['success'] = 'Theme activated successfully!';
            redirect('admin/themes.php');
        } elseif ($action === 'delete' && $id) {
            $this->pdo->beginTransaction();
            $stmt = $this->pdo->prepare("SELECT is_active FROM themes WHERE id = ?");
            $stmt->execute([$id]);
            $isActive = $stmt->fetchColumn();
            
            if ($isActive) {
                $_SESSION['error'] = 'Cannot delete the active theme.';
            } else {
                $stmt = $this->pdo->prepare("DELETE FROM themes WHERE id = ?");
                $stmt->execute([$id]);
                $_SESSION['success'] = 'Theme deleted successfully!';
            }
            $this->pdo->commit();
            redirect('admin/themes.php');
        }
    }

    private function handlePost($action, $id) {
        $name = $_POST['name'] ?? 'Custom Theme';
        $font_sans = $_POST['font_sans'] ?? 'Inter';
        $font_display = $_POST['font_display'] ?? 'Outfit';

        // Extract light tokens
        $light_primary = $_POST['light_primary'] ?? '#085ae6';
        $light_accent = $_POST['light_accent'] ?? '#f1501a';
        $light_secondary = $_POST['light_secondary'] ?? '#1b2434';
        $light_dark = $_POST['light_dark'] ?? '#f4f6f9';
        $light_navy = $_POST['light_navy'] ?? '#34455f';
        $light_teal = $_POST['light_teal'] ?? '#14b8a6';
        $light_tech = $_POST['light_tech'] ?? '#f4f6f9';
        $light_text_heading = $_POST['light_text_heading'] ?? '#0f172a';
        $light_text_body = $_POST['light_text_body'] ?? '#64748b';
        $light_text_muted = $_POST['light_text_muted'] ?? '#94a3b8';
        $light_text_inverse = $_POST['light_text_inverse'] ?? '#ffffff';
        $light_btn_bg = $_POST['light_btn_bg'] ?? '#085ae6';
        $light_btn_text = $_POST['light_btn_text'] ?? '#ffffff';

        // Extract dark tokens
        $dark_primary = $_POST['dark_primary'] ?? '#3b82f6';
        $dark_accent = $_POST['dark_accent'] ?? '#fd5d26';
        $dark_secondary = $_POST['dark_secondary'] ?? '#050b14';
        $dark_dark = $_POST['dark_dark'] ?? '#050b14';
        $dark_navy = $_POST['dark_navy'] ?? '#0f172a';
        $dark_teal = $_POST['dark_teal'] ?? '#2dd4bf';
        $dark_tech = $_POST['dark_tech'] ?? '#0f172a';
        $dark_text_heading = $_POST['dark_text_heading'] ?? '#ffffff';
        $dark_text_body = $_POST['dark_text_body'] ?? '#94a3b8';
        $dark_text_muted = $_POST['dark_text_muted'] ?? '#64748b';
        $dark_text_inverse = $_POST['dark_text_inverse'] ?? '#ffffff';
        $dark_btn_bg = $_POST['dark_btn_bg'] ?? '#3b82f6';
        $dark_btn_text = $_POST['dark_btn_text'] ?? '#ffffff';

        $sql = "SET name=?, font_sans=?, font_display=?,
                light_primary=?, light_accent=?, light_secondary=?, light_dark=?, light_navy=?, light_teal=?, light_tech=?, light_text_heading=?, light_text_body=?, light_text_muted=?, light_text_inverse=?, light_btn_bg=?, light_btn_text=?,
                dark_primary=?, dark_accent=?, dark_secondary=?, dark_dark=?, dark_navy=?, dark_teal=?, dark_tech=?, dark_text_heading=?, dark_text_body=?, dark_text_muted=?, dark_text_inverse=?, dark_btn_bg=?, dark_btn_text=?";
        
        $params = [
            $name, $font_sans, $font_display,
            $light_primary, $light_accent, $light_secondary, $light_dark, $light_navy, $light_teal, $light_tech, $light_text_heading, $light_text_body, $light_text_muted, $light_text_inverse, $light_btn_bg, $light_btn_text,
            $dark_primary, $dark_accent, $dark_secondary, $dark_dark, $dark_navy, $dark_teal, $dark_tech, $dark_text_heading, $dark_text_body, $dark_text_muted, $dark_text_inverse, $dark_btn_bg, $dark_btn_text
        ];

        if ($action === 'create') {
            $stmt = $this->pdo->prepare("INSERT INTO themes $sql");
            $stmt->execute($params);
            
            $newId = $this->pdo->lastInsertId();
            if (isset($_POST['activate_now'])) {
                $this->pdo->exec("UPDATE themes SET is_active = 0");
                $this->pdo->exec("UPDATE themes SET is_active = 1 WHERE id = $newId");
            }
            
            $_SESSION['success'] = 'Theme created successfully!';
        } elseif ($action === 'edit' && $id) {
            $stmt = $this->pdo->prepare("UPDATE themes $sql WHERE id=?");
            $params[] = $id;
            $stmt->execute($params);
            $_SESSION['success'] = 'Theme updated successfully!';
        }

        redirect('admin/themes.php');
    }
}
