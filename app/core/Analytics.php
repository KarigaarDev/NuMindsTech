<?php

class Analytics {
    public static function track($pdo) {
        // Auto-provision tables if they don't exist
        self::ensureTablesExist($pdo);

        // Skip tracking for admin and api routes
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        if (strpos($uri, '/admin') !== false || strpos($uri, '/api') !== false) {
            return;
        }

        // Ensure session is started to get a session ID
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $session_id = session_id();

        $ip_address = $_SERVER['REMOTE_ADDR'] ?? null;
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? null;
        $page_url = $uri;
        $ref_code = $_GET['ref'] ?? null;

        try {
            $stmt = $pdo->prepare("INSERT INTO site_analytics (session_id, ip_address, user_agent, page_url, ref_code) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$session_id, $ip_address, $user_agent, $page_url, $ref_code]);
            
            // Clean the URL on the client-side to hide the ref code
            if ($ref_code) {
                echo "<script>
                    if (window.history.replaceState) {
                        var url = new URL(window.location);
                        url.searchParams.delete('ref');
                        var newUrl = url.toString() || window.location.pathname;
                        window.history.replaceState({path: newUrl}, '', newUrl);
                    }
                </script>";
            }
        } catch (PDOException $e) {
            error_log("Analytics tracking failed: " . $e->getMessage());
        }
    }

    /**
     * Log a specific user event (click, submission, etc.)
     */
    public static function logEvent($pdo, $category, $action, $label = '') {
        try {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $session_id = session_id();

            $stmt = $pdo->prepare("INSERT INTO site_events (session_id, category, action, label) VALUES (?, ?, ?, ?)");
            return $stmt->execute([$session_id, $category, $action, $label]);
        } catch (PDOException $e) {
            error_log("Event tracking failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Ensure necessary analytics tables exist
     */
    private static function ensureTablesExist($pdo) {
        $queries = [
            "CREATE TABLE IF NOT EXISTS site_analytics (
                id INT AUTO_INCREMENT PRIMARY KEY,
                session_id VARCHAR(255),
                ip_address VARCHAR(45),
                user_agent TEXT,
                page_url TEXT,
                ref_code VARCHAR(50),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

            "CREATE TABLE IF NOT EXISTS site_events (
                id INT AUTO_INCREMENT PRIMARY KEY,
                session_id VARCHAR(255),
                category VARCHAR(50),
                action VARCHAR(50),
                label VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
        ];

        foreach ($queries as $sql) {
            try {
                $pdo->exec($sql);
            } catch (Exception $e) {
                // Fail silently
            }
        }
    }
}
