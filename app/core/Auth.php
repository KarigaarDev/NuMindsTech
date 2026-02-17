<?php

if (!class_exists('Auth')) {
class Auth
{
    public static function check()
    {
        return isset($_SESSION['user_id']);
    }

    public static function userId()
    {
        return $_SESSION['user_id'] ?? null;
    }

    public static function role()
    {
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
}
}
