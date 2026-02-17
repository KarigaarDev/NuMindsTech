<?php
// public/users.php
session_start();
require '../app/config/db.php';
require '../app/core/helpers.php';

Auth::requireLogin();

$message = '';
$error = '';

// ADD USER
if (isset($_POST['add_user'])) {
    Csrf::verify();
    
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($name) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $role = $_POST['role'] ?? 'admin';
        $status = $_POST['status'] ?? 'active';
        try {
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())");
            $stmt->execute([$name, $email, $hashed, $role, $status]);
            $message = "User added successfully.";
        } catch (PDOException $e) {
            $error = "Email already exists or database error.";
        }
    }
}

// EDIT USER
if (isset($_POST['edit_user'])) {
    Csrf::verify();
    $id = $_POST['id'];
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $role = $_POST['role'] ?? 'admin';
    $status = $_POST['status'] ?? 'active';
    $password = $_POST['password'] ?? '';

    if (empty($name) || empty($email)) {
        $error = "Name and Email are required.";
    } else {
        try {
            if (!empty($password)) {
                $hashed = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, password = ?, role = ?, status = ?, updated_at = NOW() WHERE id = ?");
                $stmt->execute([$name, $email, $hashed, $role, $status, $id]);
            } else {
                $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, role = ?, status = ?, updated_at = NOW() WHERE id = ?");
                $stmt->execute([$name, $email, $role, $status, $id]);
            }
            $message = "User updated successfully.";
        } catch (PDOException $e) {
            $error = "Update failed or Email already exists.";
        }
    }
}

// DELETE USER
if (isset($_POST['delete_user'])) {
    Csrf::verify();
    $id = $_POST['id'];

    if ($id == Auth::userId()) {
        $error = "You cannot delete yourself.";
    } else {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $message = "User deleted successfully.";
    }
}

// FETCH USER FOR EDIT
$editingUser = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $editingUser = $stmt->fetch();
}

// FETCH USERS WITH PAGINATION
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$perPage = 20;

// Get total user count
$stmt = $pdo->query("SELECT COUNT(*) FROM users");
$totalUsers = $stmt->fetchColumn();

// Create paginator
$paginator = new Paginator($totalUsers, $perPage, $page);

// Get paginated users
// Note: LIMIT/OFFSET cannot be parameterized in prepared statements for MariaDB
$limit = (int)$paginator->limit();
$offset = (int)$paginator->offset();
$stmt = $pdo->query("
    SELECT id, name, email, role, status, last_login, created_at, login_ip 
    FROM users 
    ORDER BY created_at DESC 
    LIMIT $limit OFFSET $offset
");
$users = $stmt->fetchAll();

$title = 'User Management';

require '../app/views/dashboard/layout.php';
