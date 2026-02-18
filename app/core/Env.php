<?php
/**
 * Environment Manager
 * Loads and manages environment variables from .env file
 */
class Env {
    private static $loaded = false;
    private static $vars = [];

    public static function load() {
        if (self::$loaded) {
            return;
        }

        $env_file = __DIR__ . '/../../.env';
        
        if (!file_exists($env_file)) {
            error_log("Warning: .env file not found at: $env_file");
            return;
        }

        $env_vars = @parse_ini_file($env_file);
        
        if ($env_vars === false) {
            error_log("Error: Failed to parse .env file");
            return;
        }

        foreach ($env_vars as $key => $value) {
            putenv("$key=$value");
            self::$vars[$key] = $value;
        }

        self::$loaded = true;
    }

    public static function get($key, $default = null) {
        $value = getenv($key);
        return ($value !== false) ? $value : $default;
    }
}

// Load environment on include
Env::load();
