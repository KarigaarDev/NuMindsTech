<?php
require_once __DIR__ . '/BaseController.php';

/**
 * ProfileController
 * Handles user profile management (view and update)
 */
class ProfileController extends BaseController {

    /**
     * Display profile page
     */
    public function index() {
        $this->requireAuth();

        $user = $this->getCurrentUser();
        if (!$user) {
            redirect('logout');
        }

        $this->render('dashboard/profile', [
            'title' => 'My Profile',
            'user' => $user
        ]);
    }

    /**
     * Update profile information
     */
    public function update($data) {
        $this->requireAuth();
        Csrf::verify();

        $rules = [
            'name' => 'required|min:2|max:255',
            'email' => 'required|email|max:255'
        ];

        if (!Validator::validate($data, $rules)) {
            $_SESSION['flash_errors'] = Validator::errors();
            $_SESSION['flash_old'] = $data;
            redirect('profile');
        }

        // Check if email is already taken by another user
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $stmt->execute([$data['email'], $this->userId]);
        if ($stmt->fetch()) {
            $_SESSION['flash_error'] = 'This email is already registered to another account.';
            $_SESSION['flash_old'] = $data;
            redirect('profile');
        }

        $stmt = $this->pdo->prepare("
            UPDATE users 
            SET name = ?, email = ?, updated_at = NOW() 
            WHERE id = ?
        ");
        $stmt->execute([
            Validator::sanitizeString($data['name']),
            Validator::sanitizeEmail($data['email']),
            $this->userId
        ]);

        Logger::adminAction($this->userId, 'UPDATE_PROFILE', 'User updated their own profile information', [
            'name' => $data['name'],
            'email' => $data['email']
        ]);
        $_SESSION['flash_success'] = 'Profile updated successfully.';
        redirect('profile');
    }

    /**
     * Update user password
     */
    public function updatePassword($data) {
        $this->requireAuth();
        Csrf::verify();

        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|match:new_password'
        ];

        if (!Validator::validate($data, $rules)) {
            $_SESSION['flash_errors'] = Validator::errors();
            redirect('profile');
        }

        // Verify current password
        $user = $this->getCurrentUser();
        if (!password_verify($data['current_password'], $user['password'])) {
            $_SESSION['flash_error'] = 'The current password you entered is incorrect.';
            redirect('profile');
        }

        // Hash and update new password
        $hashedPassword = password_hash($data['new_password'], PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("UPDATE users SET password = ?, updated_at = NOW() WHERE id = ?");
        $stmt->execute([$hashedPassword, $this->userId]);

        Logger::security('PASSWORD_CHANGED', 'User changed their password', ['user_id' => $this->userId]);
        $_SESSION['flash_success'] = 'Password changed successfully.';
        redirect('profile');
    }
}
