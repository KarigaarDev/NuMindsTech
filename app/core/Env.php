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

        // Try parse_ini_file first (fast), but fall back to a tolerant parser
        $env_vars = @parse_ini_file($env_file);

        if ($env_vars !== false && is_array($env_vars)) {
            foreach ($env_vars as $key => $value) {
                putenv("$key=$value");
                self::$vars[$key] = $value;
            }
            self::$loaded = true;
            return;
        }

        // Fallback parser: support common .env styles (export prefix, quoted values,
        // comments with #, values containing =, etc.). This is more forgiving than parse_ini_file.
        $content = @file_get_contents($env_file);
        if ($content === false) {
            error_log("Error: Failed to read .env file at: $env_file");
            return;
        }

        $lines = preg_split('/\r\n|\n|\r/', $content);
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || strpos($line, '#') === 0 || strpos($line, ';') === 0) {
                continue;
            }

            // remove optional `export ` prefix
            if (stripos($line, 'export ') === 0) {
                $line = substr($line, 7);
            }

            // Split on the first '=' only
            $pos = strpos($line, '=');
            if ($pos === false) {
                continue;
            }

            $key = trim(substr($line, 0, $pos));
            $value = trim(substr($line, $pos + 1));

            // strip surrounding quotes if present
            if ((strlen($value) >= 2) && (($value[0] === '"' && $value[strlen($value)-1] === '"') || ($value[0] === "'" && $value[strlen($value)-1] === "'"))) {
                $value = substr($value, 1, -1);
            }

            // Convert literal booleans/null to strings that getenv will return (keep as-is)
            putenv("$key=$value");
            self::$vars[$key] = $value;
        }

        self::$loaded = true;

        self::$loaded = true;
    }

    public static function get($key, $default = null) {
        $value = getenv($key);
        return ($value !== false) ? $value : $default;
    }
}

// Load environment on include
Env::load();
