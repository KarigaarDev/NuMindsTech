<?php
// app/core/Maintenance.php

if (!function_exists('checkMaintenance')) {
    function checkMaintenance($pdo) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Always allow admins
        require_once __DIR__ . '/Auth.php';
        if (Auth::check()) {
            return;
        }

        // Use setting() helper which now includes site_flags
        $maintenance = setting('maintenance_mode');

        if ($maintenance === '1') {
            // If we are already on maintenance page, don't redirect
            if (strpos($_SERVER['PHP_SELF'], 'maintenance.php') === false && strpos($_SERVER['PHP_SELF'], 'login.php') === false) {
                header("Location: " . url('maintenance'));
                exit;
            }
        }
    }
}
