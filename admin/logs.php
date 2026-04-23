<?php
require_once '../app/config/db.php';
require_once '../app/core/helpers.php';

Auth::startSession();
Auth::requireLogin();
Auth::requireAdmin();

// Auto-provision table if missing
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS admin_actions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NULL,
        action_type VARCHAR(255) NOT NULL,
        details TEXT,
        ip_address VARCHAR(45),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
} catch (PDOException $e) {
    // If we can't create it, we'll see the error later anyway
}

// Fetch filter parameters
$type = $_GET['type'] ?? '';
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$perPage = 50;
$offset = ($page - 1) * $perPage;

// Base query
$sql = "SELECT al.*, u.name as user_name 
        FROM admin_actions al 
        LEFT JOIN users u ON al.user_id = u.id";
$params = [];

if (!empty($type)) {
    $sql .= " WHERE al.action_type = ?";
    $params[] = $type;
}

$sql .= " ORDER BY al.created_at DESC LIMIT $perPage OFFSET $offset";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get unique types for filter
$types = $pdo->query("SELECT DISTINCT action_type FROM admin_actions ORDER BY action_type ASC")->fetchAll(PDO::FETCH_COLUMN);

$title = 'Audit Logs';

// Capture view content
ob_start();
?>
<div class="space-y-8">
    <div class="flex items-end justify-between">
        <div>
            <h2 class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-primary mb-3">System Monitoring</h2>
            <h1 class="font-display text-4xl font-extrabold text-brand-secondary dark:text-white mb-2 tracking-tight">Audit Logs</h1>
            <p class="text-slate-500 dark:text-slate-400 font-medium text-sm">Review administrative actions and security events.</p>
        </div>

        <div class="flex gap-4">
            <select onchange="window.location.href='?type=' + this.value" class="bg-white dark:bg-brand-navy border border-slate-200 dark:border-white/5 rounded-xl px-4 py-2 text-[10px] font-bold uppercase tracking-widest focus:outline-none">
                <option value="">All Events</option>
                <?php foreach ($types as $t): ?>
                    <option value="<?= $t ?>" <?= $type === $t ? 'selected' : '' ?>><?= str_replace('_', ' ', $t) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="bg-white dark:bg-brand-navy rounded-[2.5rem] border border-slate-100 dark:border-white/5 overflow-hidden shadow-xl shadow-slate-200/50 dark:shadow-none">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-white/5">
                        <th class="px-8 py-6 text-[9px] font-bold text-slate-400 uppercase tracking-[0.2em]">Timestamp</th>
                        <th class="px-8 py-6 text-[9px] font-bold text-slate-400 uppercase tracking-[0.2em]">User</th>
                        <th class="px-8 py-6 text-[9px] font-bold text-slate-400 uppercase tracking-[0.2em]">Action</th>
                        <th class="px-8 py-6 text-[9px] font-bold text-slate-400 uppercase tracking-[0.2em]">Details</th>
                        <th class="px-8 py-6 text-[9px] font-bold text-slate-400 uppercase tracking-[0.2em]">IP Address</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                    <?php if (empty($logs)): ?>
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center text-slate-400 text-xs font-medium">No logs found matching your criteria.</td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach ($logs as $log): ?>
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-white/5 transition-colors group">
                            <td class="px-8 py-5 whitespace-nowrap">
                                <span class="text-[11px] font-bold text-slate-800 dark:text-white"><?= date('M d, H:i:s', strtotime($log['created_at'])) ?></span>
                            </td>
                            <td class="px-8 py-5">
                                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400"><?= e($log['user_name'] ?? 'System') ?></span>
                            </td>
                            <td class="px-8 py-5">
                                <span class="px-3 py-1 rounded-full text-[8px] font-bold uppercase tracking-widest 
                                    <?= str_contains($log['action_type'], 'DELETE') ? 'bg-rose-500/10 text-rose-500' : 'bg-brand-primary/10 text-brand-primary' ?>">
                                    <?= str_replace('_', ' ', $log['action_type']) ?>
                                </span>
                            </td>
                            <td class="px-8 py-5">
                                <p class="text-xs text-slate-600 dark:text-slate-400 max-w-xs truncate" title="<?= e($log['details']) ?>"><?= e($log['details']) ?></p>
                            </td>
                            <td class="px-8 py-5">
                                <code class="text-[10px] bg-slate-100 dark:bg-white/5 px-2 py-1 rounded text-slate-500"><?= e($log['ip_address'] ?? '0.0.0.0') ?></code>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
$viewContent = ob_get_clean();
require '../app/views/dashboard/layout.php';
