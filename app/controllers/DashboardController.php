<?php
// app/controllers/DashboardController.php
require_once __DIR__ . '/BaseController.php';

class DashboardController extends BaseController {

    public function index() {
        $this->requireAuth();
        $this->requireAdmin();

        // Basic Stats
        $stats = [
            'total_items' => $this->pdo->query("SELECT COUNT(*) FROM portfolio_items")->fetchColumn(),
            'total_leads' => $this->pdo->query("SELECT COUNT(*) FROM leads")->fetchColumn(),
            'new_leads' => $this->pdo->query("SELECT COUNT(*) FROM leads WHERE status = 'new'")->fetchColumn()
        ];

        // Lead Status Distribution for Chart
        $statusStmt = $this->pdo->query("SELECT status, COUNT(*) as count FROM leads GROUP BY status");
        $statusData = $statusStmt->fetchAll(PDO::FETCH_KEY_PAIR);

        // Fill missing statuses
        $allStatuses = ['new' => 0, 'contacted' => 0, 'converted' => 0, 'lost' => 0];
        $chartData = array_merge($allStatuses, $statusData);

        // Lead Timeline (last 14 days)
        $timelineStmt = $this->pdo->query("
            SELECT DATE(created_at) as date, COUNT(*) as count 
            FROM leads 
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 14 DAY) 
            GROUP BY DATE(created_at) 
            ORDER BY date ASC
        ");
        $timeline = $timelineStmt->fetchAll(PDO::FETCH_ASSOC);

        // Activities
        $leadsStmt = $this->pdo->query("SELECT 'lead' as type, name, email, created_at FROM leads ORDER BY created_at DESC LIMIT 5");
        $itemsStmt = $this->pdo->query("SELECT 'item' as type, title as name, 'Portfolio' as email, created_at FROM portfolio_items ORDER BY created_at DESC LIMIT 5");
        
        $activities = array_merge($leadsStmt->fetchAll(PDO::FETCH_ASSOC), $itemsStmt->fetchAll(PDO::FETCH_ASSOC));
        usort($activities, function($a, $b) { return strtotime($b['created_at']) - strtotime($a['created_at']); });
        $activities = array_slice($activities, 0, 5);

        $this->render('dashboard/home', [
            'title' => 'Console Home',
            'stats' => $stats,
            'activities' => $activities,
            'chartData' => $chartData,
            'timeline' => $timeline
        ]);
    }
}
