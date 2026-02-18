<?php
/**
 * Production Configuration Checks
 * Verify all deployment requirements are met
 */

class DeploymentCheck {
    
    public static function verify() {
        $issues = [];
        $warnings = [];
        
        // Check PHP version
        if (version_compare(PHP_VERSION, '7.4.0') < 0) {
            $issues[] = "PHP 7.4+ required (Current: " . PHP_VERSION . ")";
        }
        
        // Check .env file exists
        if (!file_exists(__DIR__ . '/../../.env')) {
            $issues[] = ".env file not found";
        }
        
        // Check writable directories
        $dirs = [
            'storage/logs' => __DIR__ . '/../../storage/logs',
            'public/uploads' => __DIR__ . '/../../public/uploads'
        ];
        
        foreach ($dirs as $name => $path) {
            if (!is_dir($path)) {
                $issues[] = "Directory not found: $name";
            } elseif (!is_writable($path)) {
                $issues[] = "Directory not writable: $name";
            }
        }
        
        // Check database connection
        try {
            require __DIR__ . '/db.php';
            // Test connection
            $test = $pdo->query("SELECT 1");
        } catch (Exception $e) {
            $issues[] = "Database connection failed: " . $e->getMessage();
        }
        
        // Warnings for production
        if (Env::get('APP_ENV') === 'development') {
            $warnings[] = "APP_ENV is set to development (should be 'production' on live server)";
        }
        
        if (!file_exists(__DIR__ . '/../../.htaccess')) {
            $warnings[] = ".htaccess file not found (may cause routing issues on Apache)";
        }
        
        return [
            'success' => empty($issues),
            'issues' => $issues,
            'warnings' => $warnings
        ];
    }
    
    public static function display() {
        $result = self::verify();
        
        echo "\n=== DEPLOYMENT CHECKLIST ===\n\n";
        
        if (empty($result['issues'])) {
            echo "✓ All critical checks passed!\n\n";
        } else {
            echo "✗ CRITICAL ISSUES FOUND:\n";
            foreach ($result['issues'] as $issue) {
                echo "  - $issue\n";
            }
            echo "\n";
        }
        
        if (!empty($result['warnings'])) {
            echo "⚠ WARNINGS:\n";
            foreach ($result['warnings'] as $warning) {
                echo "  - $warning\n";
            }
            echo "\n";
        }
        
        return $result['success'];
    }
}

// Auto-check on first load if in production
if (php_sapi_name() !== 'cli' && Env::get('APP_ENV') === 'production') {
    $check = DeploymentCheck::verify();
    if (!$check['success']) {
        error_log("Deployment check failed: " . json_encode($check['issues']));
        if (php_sapi_name() === 'cli') {
            DeploymentCheck::display();
        }
    }
}
