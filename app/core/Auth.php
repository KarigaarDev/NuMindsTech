<?php

if (!class_exists('Auth')) {
class Auth
{
    /**
     * Initialize session with secure parameters and check for timeouts
     */
    public static function startSession() {
        if (session_status() === PHP_SESSION_NONE) {
            // Secure cookie parameters
            $secure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
            $httponly = true;
            $samesite = 'Lax';
            
            session_set_cookie_params([
                'lifetime' => 0, // Session cookie
                'path' => '/',
                'domain' => '',
                'secure' => $secure,
                'httponly' => $httponly,
                'samesite' => $samesite
            ]);

            session_start();
        }

        // Check for session timeout (1 hour)
        $timeout = 3600; 
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
            session_unset();
            session_destroy();
            return false;
        }
        
        // Update activity timestamp for logged in users
        if (isset($_SESSION['user_id'])) {
            $_SESSION['last_activity'] = time();
        }
        
        return true;
    }

    public static function check()
    {
        return self::startSession() && isset($_SESSION['user_id']);
    }

    public static function userId()
    {
        self::startSession();
        return $_SESSION['user_id'] ?? null;
    }

    public static function role()
    {
        self::startSession();
        return $_SESSION['role'] ?? 'guest';
    }

    public static function isAdmin()
    {
        return self::role() === 'admin' || self::role() === 'editor';
    }

    public static function isClient()
    {
        return self::role() === 'client';
    }

    public static function requireLogin()
    {
        if (!self::check()) {
            redirect('login');
        }
    }

    public static function requireAdmin()
    {
        self::requireLogin();
        if (!self::isAdmin()) {
            redirect('dashboard');
        }
    }

    /**
     * Generate a password reset token and send email
     */
    public static function requestPasswordReset($pdo, $email) {
        // 1. Check if user exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user) {
            // Return true anyway to prevent email enumeration
            return true;
        }

        // 2. Generate token
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // 3. Store token
        $stmt = $pdo->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE token = VALUES(token), expires_at = VALUES(expires_at)");
        $stmt->execute([$email, $token, $expires]);

        // 4. Send Email
        $resetLink = url("public/reset-password.php?token=$token");
        $subject = "Reset Your Password - Numinds Tech";
        $content = "
            <p>Hello,</p>
            <p>We received a request to reset your password for your Numinds Tech account.</p>
            <p>Click the button below to choose a new password. This link will expire in 1 hour.</p>
            <a href='$resetLink' class='btn'>Reset Password</a>
            <p style='margin-top:20px; font-size:12px; color:#999;'>If you didn't request this, you can safely ignore this email.</p>
        ";
        
        Logger::security('PASSWORD_RESET_REQUESTED', 'User requested a password reset link', ['email' => $email]);
        
        return Email::send($email, $subject, $content);
    }

    /**
     * Verify if a reset token is valid
     */
    public static function verifyResetToken($pdo, $token) {
        $stmt = $pdo->prepare("SELECT email FROM password_resets WHERE token = ? AND expires_at > NOW() LIMIT 1");
        $stmt->execute([$token]);
        return $stmt->fetchColumn();
    }

    /**
     * Reset password using a valid token
     */
    public static function resetPassword($pdo, $token, $newPassword) {
        $email = self::verifyResetToken($pdo, $token);
        if (!$email) return false;

        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $pdo->beginTransaction();
        try {
            // Update user
            $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
            $stmt->execute([$hashedPassword, $email]);

            // Delete token
            $stmt = $pdo->prepare("DELETE FROM password_resets WHERE email = ?");
            $stmt->execute([$email]);

            $pdo->commit();
            Logger::security('PASSWORD_RESET_COMPLETED', 'User successfully reset their password via token', ['email' => $email]);
            return true;
        } catch (Exception $e) {
            $pdo->rollBack();
            return false;
        }
    }
}
}
