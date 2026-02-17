<?php
use UI\Component;

$headers = ['Inquiry Details', 'Service Type', 'Status', 'Registry Date', 'Actions'];
$rows = [];

foreach ($leads as $lead) {
    $statusType = match($lead['status']) {
        'New' => 'success',
        'Contacted' => 'info',
        default => 'neutral'
    };
    
    $rows[] = [
        '<div>
            <div class="font-bold text-brand-secondary dark:text-white mb-1">' . e($lead['name']) . '</div>
            <div class="text-[10px] font-medium text-slate-500 dark:text-slate-400">' . e($lead['email']) . ' | ' . e($lead['phone']) . '</div>
        </div>',
        '<span class="text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">' . e($lead['service_type']) . '</span>',
        Component::badge($lead['status'], $statusType),
        '<span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">' . date('d M Y', strtotime($lead['created_at'])) . '</span>',
        '<div class="flex justify-end">
            <a href="' . url('admin/lead-view?id=' . $lead['id']) . '" 
               class="inline-flex items-center justify-center w-10 h-10 bg-white dark:bg-brand-secondary border border-slate-200 dark:border-white/10 text-slate-400 hover:text-brand-primary hover:border-brand-primary transition-all rounded-xl shadow-sm">
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>'
    ];
}
?>

<div class="animate-in fade-in slide-in-from-bottom-4 duration-500">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
        <div>
            <h2 class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-primary mb-3">Registry Overview</h2>
            <h1 class="font-display text-4xl font-extrabold text-brand-secondary dark:text-white mb-2 tracking-tight">Leads Registry</h1>
            <p class="text-slate-500 dark:text-slate-400 font-medium">Manage and track all incoming institutional inquiries.</p>
        </div>
        <div class="hidden md:block">
            <button onclick="window.print()" class="text-slate-400 hover:text-brand-primary font-bold text-[10px] uppercase tracking-widest flex items-center gap-2 transition-colors">
                <i class="fa-solid fa-print"></i> Print Records
            </button>
        </div>
    </div>

    <?php if (count($leads)): ?>
        <?= Component::table($headers, $rows) ?>
        
        <div class="mt-8 flex items-center justify-between px-8 py-5 bg-white dark:bg-brand-navy rounded-2xl border border-slate-100 dark:border-white/5 text-[10px] font-bold uppercase tracking-widest text-slate-500 shadow-sm">
            <span>Total records: <span class="text-brand-primary"><?= count($leads) ?></span></span>
            <span class="flex items-center gap-2">
                <i class="fa-solid fa-circle text-[6px] text-emerald-500 animate-pulse"></i> Live Sync
            </span>
        </div>
    <?php else: ?>
        <div class="bg-white dark:bg-brand-navy/30 rounded-[2.5rem] border border-slate-100 dark:border-white/5 p-20 text-center shadow-sm">
            <div class="w-16 h-16 bg-slate-50 dark:bg-white/5 rounded-2xl flex items-center justify-center mx-auto mb-6 text-slate-300 dark:text-slate-700 text-2xl">
                <i class="fa-regular fa-folder-open"></i>
            </div>
            <h3 class="text-lg font-bold text-brand-secondary dark:text-white mb-1">No leads found</h3>
            <p class="text-slate-500 dark:text-slate-400 text-xs font-medium">New inquiries will appear here automatically.</p>
        </div>
    <?php endif; ?>
</div>

