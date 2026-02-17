<?php
// public/portfolio.php
session_start();
require_once '../app/config/db.php';
require_once '../app/core/helpers.php';

Auth::requireLogin();
Auth::requireAdmin();

$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    Csrf::verify();
    
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $client_name = $_POST['client_name'] ?? '';
    $category = $_POST['category'] ?? 'Web Design';
    $tags = $_POST['tags'] ?? '';
    $project_url = $_POST['project_url'] ?? null;
    $completion_date = $_POST['completion_date'] ?? null;
    $status = $_POST['status'] ?? 'published';
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $display_order = $_POST['display_order'] ?? 0;
    
    // Handle image upload
    $featured_image = null;
    if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $filename = $_FILES['featured_image']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed) && $_FILES['featured_image']['size'] < 5000000) {
            $newname = uniqid() . '.' . $ext;
            $destination = '../public/uploads/' . $newname;
            
            if (move_uploaded_file($_FILES['featured_image']['tmp_name'], $destination)) {
                $featured_image = $newname;
            }
        }
    }
    
    if ($action === 'create') {
        $stmt = $pdo->prepare("INSERT INTO portfolio_items (title, description, client_name, featured_image, category, tags, project_url, completion_date, status, is_featured, display_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $description, $client_name, $featured_image, $category, $tags, $project_url, $completion_date, $status, $is_featured, $display_order]);
        
        $_SESSION['success'] = 'Portfolio item created successfully!';
        redirect('portfolio');
    } elseif ($action === 'update' && $id) {
        // If no new image uploaded, keep existing
        if (!$featured_image) {
            $stmt = $pdo->prepare("UPDATE portfolio_items SET title=?, description=?, client_name=?, category=?, tags=?, project_url=?, completion_date=?, status=?, is_featured=?, display_order=? WHERE id=?");
            $stmt->execute([$title, $description, $client_name, $category, $tags, $project_url, $completion_date, $status, $is_featured, $display_order, $id]);
        } else {
            // Delete old image
            $old = $pdo->query("SELECT featured_image FROM portfolio_items WHERE id=$id")->fetchColumn();
            if ($old && file_exists("../public/uploads/$old")) {
                unlink("../public/uploads/$old");
            }
            
            $stmt = $pdo->prepare("UPDATE portfolio_items SET title=?, description=?, client_name=?, featured_image=?, category=?, tags=?, project_url=?, completion_date=?, status=?, is_featured=?, display_order=? WHERE id=?");
            $stmt->execute([$title, $description, $client_name, $featured_image, $category, $tags, $project_url, $completion_date, $status, $is_featured, $display_order, $id]);
        }
        
        $_SESSION['success'] = 'Portfolio item updated successfully!';
        redirect('portfolio');
    }
}

// Fetch data for list/edit
if ($action === 'list') {
    $items = $pdo->query("SELECT * FROM portfolio_items ORDER BY display_order ASC, created_at DESC")->fetchAll();
    $title = 'Portfolio Management';
    $viewPath = '../app/views/dashboard/portfolio.php';
} elseif (in_array($action, ['create', 'edit'])) {
    $item = null;
    if ($action === 'edit' && $id) {
        $stmt = $pdo->prepare("SELECT * FROM portfolio_items WHERE id = ?");
        $stmt->execute([$id]);
        $item = $stmt->fetch();
    }
    $title = $action === 'create' ? 'Add Portfolio Item' : 'Edit Portfolio Item';
    $viewPath = '../app/views/dashboard/portfolio-form.php';
}

// Capture view content using output buffering
ob_start();
require $viewPath;
$viewContent = ob_get_clean();

require '../app/views/dashboard/layout.php';
