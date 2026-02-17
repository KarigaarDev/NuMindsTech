<?php
require_once __DIR__ . '/BaseController.php';

/**
 * Simple image resize helper (lightweight, no external deps)
 * Falls back to copying if GD is unavailable
 */
function resizeImage($sourcePath, $destPath, $maxWidth = 300, $maxHeight = 150) {
    if (!extension_loaded('gd')) {
        // GD not available, just copy the file
        copy($sourcePath, $destPath);
        return true;
    }

    $info = @getimagesize($sourcePath);
    if (!$info) {
        copy($sourcePath, $destPath);
        return true;
    }

    list($width, $height, $type) = $info;
    
    $ratio = min($maxWidth / $width, $maxHeight / $height);
    if ($ratio >= 1) {
        copy($sourcePath, $destPath);
        return true;
    }

    $newWidth = (int)($width * $ratio);
    $newHeight = (int)($height * $ratio);

    $image = null;
    if ($type === IMAGETYPE_JPEG) {
        $image = @imagecreatefromjpeg($sourcePath);
    } elseif ($type === IMAGETYPE_PNG) {
        $image = @imagecreatefrompng($sourcePath);
    } elseif ($type === IMAGETYPE_WEBP) {
        $image = @imagecreatefromwebp($sourcePath);
    } else {
        copy($sourcePath, $destPath);
        return true;
    }

    if (!$image) {
        copy($sourcePath, $destPath);
        return true;
    }

    $resized = @imagecreatetruecolor($newWidth, $newHeight);
    if (!$resized) {
        imagedestroy($image);
        copy($sourcePath, $destPath);
        return true;
    }

    if ($type === IMAGETYPE_PNG || $type === IMAGETYPE_WEBP) {
        @imagecolortransparent($resized, @imagecolorallocatealpha($resized, 0, 0, 0, 127));
        @imagesavealpha($resized, true);
    }

    @imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    if ($type === IMAGETYPE_JPEG) {
        @imagejpeg($resized, $destPath, 85);
    } elseif ($type === IMAGETYPE_PNG) {
        @imagepng($resized, $destPath, 7);
    } elseif ($type === IMAGETYPE_WEBP) {
        @imagewebp($resized, $destPath, 80);
    }

    @imagedestroy($image);
    @imagedestroy($resized);
    return true;
}

class ClientsController extends BaseController {

    public function index() {
        $this->requireAuth();
        $this->requireAdmin();

        // Ensure table exists (simple prod-safe create-if-not-exists)
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS clients (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) DEFAULT '',
            logo VARCHAR(255) NOT NULL,
            link VARCHAR(255) DEFAULT '',
            sort_order INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        $stmt = $this->pdo->query("SELECT * FROM clients ORDER BY sort_order ASC, id ASC");
        $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // If editing a specific client, fetch it to prefill the form
        $editClient = null;
        if (isset($_GET['edit'])) {
            $editId = (int) $_GET['edit'];
            $editClient = $this->getClient($editId);
        }

        $this->render('dashboard/clients', [
            'title' => 'Clients',
            'clients' => $clients,
            'editClient' => $editClient
        ]);
    }

    private function getClient($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM clients WHERE id = ? LIMIT 1");
        $stmt->execute([(int)$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data, $files) {
        $this->requireAuth();
        $this->requireAdmin();

        Csrf::verify();

        $id = (int)$id;
        $client = $this->getClient($id);
        if (!$client) {
            $_SESSION['flash_error'] = 'Client not found.';
            redirect('admin/clients.php');
        }

        $name = isset($data['name']) ? trim($data['name']) : '';
        $link = isset($data['link']) ? trim($data['link']) : '';
        $sort = isset($data['sort_order']) ? (int)$data['sort_order'] : 0;

        // If a new logo was uploaded, process it
        if (!empty($files['logo']['name'])) {
            $upload = $files['logo'];
            if ($upload['error'] === UPLOAD_ERR_OK) {
                $allowed = ['image/png','image/jpeg','image/svg+xml','image/webp'];
                if (!in_array($upload['type'], $allowed)) {
                    $_SESSION['flash_error'] = 'Invalid file type for logo.';
                    redirect('admin/clients.php?edit=' . $id);
                }

                $ext = pathinfo($upload['name'], PATHINFO_EXTENSION);
                $filename = 'client_' . time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
                $destDir = __DIR__ . '/../../public/uploads/clients';
                if (!is_dir($destDir)) { @mkdir($destDir, 0755, true); }
                $dest = $destDir . '/' . $filename;
                if (move_uploaded_file($upload['tmp_name'], $dest)) {
                    // Resize & optimize
                    @resizeImage($dest, $dest, 300, 150);
                    
                    // remove old file
                    if (!empty($client['logo']) && file_exists($destDir . '/' . $client['logo'])) {
                        @unlink($destDir . '/' . $client['logo']);
                    }
                    $logoToSave = $filename;
                } else {
                    $_SESSION['flash_error'] = 'Failed to move uploaded file.';
                    redirect('admin/clients.php?edit=' . $id);
                }
            } else {
                $_SESSION['flash_error'] = 'Upload error code: ' . $upload['error'];
                redirect('admin/clients.php?edit=' . $id);
            }
        } else {
            $logoToSave = $client['logo'];
        }

        $stmt = $this->pdo->prepare("UPDATE clients SET name = ?, logo = ?, link = ?, sort_order = ? WHERE id = ?");
        $stmt->execute([$name, $logoToSave, $link, $sort, $id]);

        Logger::adminAction($this->userId, 'UPDATE_CLIENT', 'Updated client #' . $id, ['name' => $name]);
        $_SESSION['flash_success'] = 'Client updated successfully.';
        redirect('admin/clients.php');
    }

    public function delete($id) {
        $this->requireAuth();
        $this->requireAdmin();

        Csrf::verify();

        $id = (int)$id;
        $client = $this->getClient($id);
        if (!$client) {
            $_SESSION['flash_error'] = 'Client not found.';
            redirect('admin/clients.php');
        }

        $destDir = __DIR__ . '/../../public/uploads/clients';
        if (!empty($client['logo']) && file_exists($destDir . '/' . $client['logo'])) {
            @unlink($destDir . '/' . $client['logo']);
        }

        $stmt = $this->pdo->prepare("DELETE FROM clients WHERE id = ?");
        $stmt->execute([$id]);

        Logger::adminAction($this->userId, 'DELETE_CLIENT', 'Deleted client #' . $id, ['name' => $client['name']]);
        $_SESSION['flash_success'] = 'Client removed.';
        redirect('admin/clients.php');
    }

    public function reorder($ids) {
        $this->requireAuth();
        $this->requireAdmin();

        if (!is_array($ids) || empty($ids)) {
            http_response_code(400);
            die(json_encode(['success' => false, 'message' => 'Invalid IDs']));
        }

        try {
            foreach ($ids as $index => $id) {
                $id = (int)$id;
                $stmt = $this->pdo->prepare("UPDATE clients SET sort_order = ? WHERE id = ?");
                $stmt->execute([$index, $id]);
            }
            echo json_encode(['success' => true, 'message' => 'Order updated']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Reorder failed']);
        }
    }

    public function store($data, $files) {
        $this->requireAuth();
        $this->requireAdmin();

        Csrf::verify();

        // Basic validation
        $name = isset($data['name']) ? trim($data['name']) : '';
        $link = isset($data['link']) ? trim($data['link']) : '';
        $sort = isset($data['sort_order']) ? (int)$data['sort_order'] : 0;

        if (empty($files['logo']['name'])) {
            $_SESSION['flash_error'] = 'Please select a logo to upload.';
            redirect('admin/clients.php');
        }

        $upload = $files['logo'];
        if ($upload['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['flash_error'] = 'Upload failed with error code ' . $upload['error'];
            redirect('admin/clients.php');
        }

        $allowed = ['image/png','image/jpeg','image/svg+xml','image/webp'];
        if (!in_array($upload['type'], $allowed)) {
            $_SESSION['flash_error'] = 'Invalid file type. Allowed: PNG, JPG, SVG, WEBP.';
            redirect('admin/clients.php');
        }

        $ext = pathinfo($upload['name'], PATHINFO_EXTENSION);
        $filename = 'client_' . time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;

        $destDir = __DIR__ . '/../../public/uploads/clients';
        if (!is_dir($destDir)) {
            @mkdir($destDir, 0755, true);
        }

        $dest = $destDir . '/' . $filename;
        if (!move_uploaded_file($upload['tmp_name'], $dest)) {
            $_SESSION['flash_error'] = 'Failed to move uploaded file.';
            redirect('admin/clients.php');
        }

        // Resize & optimize
        @resizeImage($dest, $dest, 300, 150);

        $stmt = $this->pdo->prepare("INSERT INTO clients (name, logo, link, sort_order) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $filename, $link, $sort]);

        Logger::adminAction($this->userId, 'CREATE_CLIENT', 'Added client logo: ' . $filename, ['name' => $name]);

        $_SESSION['flash_success'] = 'Client logo uploaded successfully.';
        redirect('admin/clients.php');
    }
}
