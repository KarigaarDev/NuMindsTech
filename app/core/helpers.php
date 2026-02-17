<?php
if (!function_exists('e')) {
    function e($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('redirect')) {
    function redirect($path) {
        $config = require __DIR__ . '/../config/app.php';
        header("Location: {$config['base_url']}/{$path}");
        exit;
    }
}
if (!function_exists('url')) {
    function url($path = '') {
        $config = require __DIR__ . '/../config/app.php';
        return rtrim($config['base_url'], '/') . '/' . ltrim($path, '/');
    }
}

require_once __DIR__ . '/Auth.php';
require_once __DIR__ . '/Settings.php';
require_once __DIR__ . '/Csrf.php';
require_once __DIR__ . '/Maintenance.php';
require_once __DIR__ . '/Validator.php';
require_once __DIR__ . '/RateLimiter.php';
require_once __DIR__ . '/Logger.php';
require_once __DIR__ . '/Paginator.php';
require_once __DIR__ . '/ui-components.php';

if (!function_exists('csrf_field')) {
    function csrf_field() {
        return Csrf::field();
    }
}

// Global Initialization
if (isset($pdo)) {
    getSiteSettings($pdo);
    checkMaintenance($pdo);
}