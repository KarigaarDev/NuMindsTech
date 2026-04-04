<?php

class Analytics {
    public static function track($pdo) {
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
            // Silently fail if tracking fails
            error_log("Analytics tracking failed: " . $e->getMessage());
        }
    }
}
