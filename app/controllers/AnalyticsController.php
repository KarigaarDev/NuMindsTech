<?php
// app/controllers/AnalyticsController.php
require_once __DIR__ . '/BaseController.php';

class AnalyticsController extends BaseController {

    public function index() {
        $this->requireAuth();
        $this->requireAdmin();

        // Basic Stats
        $stats = [
            'total_pageviews' => $this->pdo->query("SELECT COUNT(*) FROM site_analytics")->fetchColumn(),
            'unique_visitors' => $this->pdo->query("SELECT COUNT(DISTINCT ip_address) FROM site_analytics")->fetchColumn(),
            'referrals' => $this->pdo->query("SELECT COUNT(*) FROM site_analytics WHERE ref_code IS NOT NULL")->fetchColumn()
        ];

        // Pageviews over last 14 days
        $timelineStmt = $this->pdo->query("
            SELECT DATE(created_at) as date, COUNT(*) as views 
            FROM site_analytics 
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 14 DAY) 
            GROUP BY DATE(created_at) 
            ORDER BY date ASC
        ");
        $timeline = $timelineStmt->fetchAll(PDO::FETCH_ASSOC);

        // Top Referrers
        $refStmt = $this->pdo->query("
            SELECT ref_code, COUNT(*) as count 
            FROM site_analytics 
            WHERE ref_code IS NOT NULL 
            GROUP BY ref_code 
            ORDER BY count DESC 
            LIMIT 10
        ");
        $referrals = $refStmt->fetchAll(PDO::FETCH_ASSOC);

        // Top Pages
        $pagesStmt = $this->pdo->query("
            SELECT page_url, COUNT(*) as views 
            FROM site_analytics 
            GROUP BY page_url 
            ORDER BY views DESC 
            LIMIT 10
        ");
        $topPages = $pagesStmt->fetchAll(PDO::FETCH_ASSOC);

        $this->render('dashboard/analytics', [
            'title' => 'Web Analytics',
            'stats' => $stats,
            'timeline' => $timeline,
            'referrals' => $referrals,
            'topPages' => $topPages
        ]);
    }
}
