<?php
if (!class_exists('Csrf')) {
    class Csrf {
        public static function token() {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            if (empty($_SESSION['csrf_token'])) {
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            }
            return $_SESSION['csrf_token'];
        }

        public static function field() {
            $token = self::token();
            return '<input type="hidden" name="csrf_token" value="' . $token . '">';
        }

        public static function verify() {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                    http_response_code(419);
                    die('CSRF validation failed. Please go back, refresh the page, and try again.');
                }
            }
        }
    }
}
