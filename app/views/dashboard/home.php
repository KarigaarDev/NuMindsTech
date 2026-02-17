<?php
use UI\Component;

// Use data passed from controller - no need to query $pdo directly
$totalItems = $stats['total_items'] ?? 0;
$totalLeads = $stats['total_leads'] ?? 0;

// Activities are already prepared from controller
// $activities variable contains merged lead and item activities

// Define a simple 'e' function if it doesn't exist (for HTML escaping)
if (!function_exists('e')) {
    function e($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}

$feedHtml = '<div class="space-y-6">';
if (empty($activities)) {
    $feedHtml .= '
        <div class="text-center py-12">
            <div class="w-20 h-20 bg-slate-50 dark:bg-white/5 rounded-3xl flex items-center justify-center mx-auto mb-8 text-slate-300 dark:text-slate-700 text-3xl">
                <i class="fa-solid fa-bolt-lightning animate-pulse"></i>
            </div>
            <h3 class="font-display text-xl font-bold text-brand-secondary dark:text-white mb-3">Activity Stream</h3>
            <p class="text-slate-500 dark:text-slate-400 max-w-sm mx-auto text-sm leading-relaxed">
                No recent activity detected. New leads and portfolio updates will be streamed here.
            </p>
        </div>';
} else {
    foreach ($activities as $act) {
        $icon = $act['type'] === 'lead' ? 'fa-user-plus text-emerald-500' : 'fa-layer-group text-brand-primary';
        $label = $act['type'] === 'lead' ? 'New Lead' : 'Artifact Added';
        $time = date('M d, H:i', strtotime($act['created_at']));
        
        $feedHtml .= '
        <div class="flex items-center gap-6 p-4 rounded-2xl hover:bg-slate-50 dark:hover:bg-white/5 transition-colors group">
            <div class="w-12 h-12 rounded-xl bg-white dark:bg-brand-navy border border-slate-100 dark:border-white/10 flex items-center justify-center text-lg shadow-sm">
                <i class="fa-solid ' . $icon . '"></i>
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between mb-1">
                    <h4 class="font-display font-bold text-brand-secondary dark:text-white truncate">'.e($act['name']).'</h4>
                    <span class="text-[9px] font-bold uppercase tracking-widest text-slate-400">'.$time.'</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-[9px] font-bold uppercase tracking-widest px-2 py-0.5 rounded bg-slate-100 dark:bg-white/5 text-slate-500">'.$label.'</span>
                    <span class="text-xs text-slate-400 truncate">'.e($act['email'] === 'Portfolio' ? 'Solution Catalog' : $act['email']).'</span>
                </div>
            </div>
            <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 opacity-0 group-hover:opacity-100 transition-all"></i>
        </div>';
    }
}
$feedHtml .= '</div>';
?>

<!-- Header -->
<div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
    <div>
        <h2 class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-primary mb-3">Management Overview</h2>
        <h1 class="font-display text-4xl font-extrabold text-brand-secondary dark:text-white mb-2 tracking-tight">
            Welcome back, <?= htmlspecialchars($_SESSION['name']) ?>
        </h1>
        <p class="text-slate-500 dark:text-slate-400 font-medium">System status is <span class="text-brand-accent italic font-bold">operational</span>. All nodes are connected.</p>
    </div>
    
    <div class="flex items-center gap-3 text-[10px] font-bold uppercase tracking-widest text-slate-500 bg-white dark:bg-brand-navy px-6 py-4 rounded-2xl border border-slate-100 dark:border-white/5 shadow-sm">
        <i class="fa-regular fa-calendar-check text-brand-primary"></i>
        <span><?= date('l, F j, Y') ?></span>
    </div>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
    <?= Component::statsCard($totalItems, 'Live Solutions', 'fa-layer-group', 'brand-primary') ?>
    <?= Component::statsCard($totalLeads, 'Recent Leads', 'fa-users-viewfinder', 'accent') ?>
    
    <div class="flex items-center justify-center p-8 bg-white dark:bg-brand-navy border border-slate-100 dark:border-white/5 rounded-3xl transition-all duration-500 hover:shadow-md">
        <div class="text-center">
            <h3 class="text-[10px] font-bold uppercase tracking-[0.4em] text-slate-400 mb-4">Platform Mode</h3>
            <?= Component::badge('Standard Control', 'success') ?>
        </div>
    </div>
</div>

<!-- Main Area -->
<div class="grid lg:grid-cols-1 gap-8">
    <?= Component::card($feedHtml, 'System Feed', 'fa-rss', 'lg:col-span-1') ?>
</div>
