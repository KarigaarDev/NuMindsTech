<?php
// app/core/Settings.php

if (!function_exists('getSiteSettings')) {
    function getSiteSettings($pdo, $forceRefresh = false) {
        if (!$forceRefresh && isset($GLOBALS['siteSettings'])) {
            return $GLOBALS['siteSettings'];
        }

        if ($forceRefresh) {
            unset($GLOBALS['siteSettings']);
        }

        $settings = [];

        // Fetch from settings table
        $stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }

        // Fetch from site_flags table
        $stmt = $pdo->query("SELECT flag_key, flag_value FROM site_flags");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $settings[$row['flag_key']] = (string)$row['flag_value'];
        }

        $GLOBALS['siteSettings'] = $settings;
        return $settings;
    }
}

// Global short-helper
if (!function_exists('setting')) {
    function setting($key, $default = '') {
        return $GLOBALS['siteSettings'][$key] ?? $default;
    }
}
