<?php
require_once __DIR__ . '/BaseController.php';

/**
 * DashboardController
 * Handles admin/user dashboard operations
 */
class DashboardController extends BaseController {

    /**
     * Display users list with pagination
     */
    public function users() {
        $this->requireAuth();
        $this->requireAdmin();

        // Get pagination parameters
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage = isset($_GET['per_page']) ? max(1, min(100, (int)$_GET['per_page'])) : 20;

        // Get total user count
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM users");
        $totalUsers = $stmt->fetchColumn();

        // Create paginator
        $paginator = new Paginator($totalUsers, $perPage, $page);

        // Get paginated users
        $users = $this->getPaginatedUsers($paginator->offset(), $paginator->limit());

        $this->render('dashboard/users', [
            'title' => 'Team Members',
            'users' => $users,
            'paginator' => $paginator
        ]);
    }

    /**
     * Get paginated users
     */
    private function getPaginatedUsers($offset, $limit) {
        // Cast to integers (LIMIT/OFFSET cannot be parameterized in prepared statements)
        $offset = (int)$offset;
        $limit = (int)$limit;
        $stmt = $this->pdo->query("
            SELECT id, name, email, role, status, created_at, last_login, login_ip
            FROM users
            ORDER BY created_at DESC
            LIMIT $limit OFFSET $offset
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Display admin dashboard overview
     */
    public function overview() {
        $this->requireAuth();
        $this->requireAdmin();

        // Fetch dashboard statistics
        $stats = [
            'total_users' => $this->getTotalUsers(),
            'total_portfolio_items' => $this->getTotalPortfolioItems(),
            'total_leads' => $this->getTotalLeads(),
            'total_services' => $this->getTotalServices(),
            'total_items' => $this->getTotalItems(),
        ];

        // Fetch recent leads
        $recentLeads = $this->getRecentLeads(5);

        // Fetch recent items
        $recentItems = $this->getRecentItems(3);

        // Fetch recent activities (merged and sorted)
        $recentLeadsForActivity = $this->getRecentLeadsForActivity(3);
        $recentItemsForActivity = $this->getRecentItemsForActivity(3);
        $activities = $this->mergeAndSortActivities($recentLeadsForActivity, $recentItemsForActivity, 5);

        $this->render('dashboard/home', [
            'title' => 'Dashboard',
            'stats' => $stats,
            'recentLeads' => $recentLeads,
            'recentItems' => $recentItems,
            'activities' => $activities
        ]);
    }

    /**
     * Get total number of users
     */
    private function getTotalUsers() {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM users");
        return $stmt->fetchColumn();
    }

    /**
     * Get total number of portfolio items
     */
    private function getTotalPortfolioItems() {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM portfolio_items WHERE status = 'published'");
        return $stmt->fetchColumn();
    }

    /**
     * Get total leads
     */
    private function getTotalLeads() {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM leads");
        return $stmt->fetchColumn();
    }

    /**
     * Get total services
     */
    private function getTotalServices() {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM client_services WHERE status = 'active'");
        return $stmt->fetchColumn();
    }

    /**
     * Get recent leads
     */
    private function getRecentLeads($limit = 5) {
        // Cast limit to integer (LIMIT cannot be parameterized in prepared statements)
        $limit = (int)$limit;
        $stmt = $this->pdo->query("
            SELECT * FROM leads
            ORDER BY created_at DESC
            LIMIT $limit
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get total items count
     */
    private function getTotalItems() {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM items");
        return $stmt->fetchColumn();
    }

    /**
     * Get recent items
     */
    private function getRecentItems($limit = 3) {
        $limit = (int)$limit;
        $stmt = $this->pdo->query("
            SELECT id, title, created_at FROM items
            ORDER BY created_at DESC
            LIMIT $limit
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get recent leads for activity feed
     */
    private function getRecentLeadsForActivity($limit = 3) {
        $limit = (int)$limit;
        $stmt = $this->pdo->query("
            SELECT name, email, created_at, 'lead' as type FROM leads
            ORDER BY created_at DESC
            LIMIT $limit
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get recent items for activity feed
     */
    private function getRecentItemsForActivity($limit = 3) {
        $limit = (int)$limit;
        $stmt = $this->pdo->query("
            SELECT title as name, 'Portfolio' as email, created_at, 'item' as type FROM items
            ORDER BY created_at DESC
            LIMIT $limit
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Merge and sort activities from different sources
     */
    private function mergeAndSortActivities($leads, $items, $limit = 5) {
        $activities = array_merge($leads, $items);
        usort($activities, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });
        return array_slice($activities, 0, $limit);
    }
}
