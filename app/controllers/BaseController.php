<?php
/**
 * Base Controller Class
 * Provides common functionality for all controllers
 */
abstract class BaseController {
    protected $pdo;
    protected $userId;
    protected $userRole;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        if (Auth::check()) {
            $this->userId = Auth::userId();
            $this->userRole = Auth::role();
        }
    }

    /**
     * Get current user data
     */
    protected function getCurrentUser() {
        if (!Auth::check()) {
            return null;
        }

        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$this->userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Check if user has admin access
     */
    protected function requireAdmin() {
        if (!Auth::isAdmin()) {
            http_response_code(403);
            die('Access Denied');
        }
    }

    /**
     * Check if user is authenticated
     */
    protected function requireAuth() {
        if (!Auth::check()) {
            redirect('login');
        }
    }

    /**
     * Render view with data
     * 
     * @param string $view Path to view file (relative to app/views/)
     * @param array $data Data to pass to view
     * @param bool $useLayout Whether to wrap in dashboard layout
     */
    protected function render($view, $data = [], $useLayout = true) {
        extract($data);
        
        // Make PDO available to views if needed
        $pdo = $this->pdo;
        
        if ($useLayout && strpos($view, 'dashboard/') === 0) {
            // For dashboard views, use the layout wrapper
            // Capture the view content
            ob_start();
            require __DIR__ . '/../views/' . $view . '.php';
            $viewContent = ob_get_clean();
            
            // Now render the layout with the view content
            require __DIR__ . '/../views/dashboard/layout.php';
        } else {
            // For non-dashboard views, render directly
            require __DIR__ . '/../views/' . $view . '.php';
        }
    }
}
