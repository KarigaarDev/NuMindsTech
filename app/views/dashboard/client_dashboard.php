<?php
use UI\Component;

$site_headers = ['Platform', 'Connectivity', 'Status', 'Plan'];
$site_rows = [];

foreach ($websites as $site) {
    $statusType = $site['status'] === 'active' ? 'success' : 'neutral';
    $site_rows[] = [
        '<div class="flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-brand-primary/10 flex items-center justify-center text-brand-primary border border-brand-primary/20">
                <i class="fa-solid fa-globe"></i>
            </div>
            <div>
                <p class="font-display font-bold text-brand-secondary dark:text-white text-base leading-tight">' . e($site['site_name']) . '</p>
                <p class="text-[10px] text-slate-500 font-medium">Digital Infrastructure</p>
            </div>
        </div>',
        '<a href="' . e($site['site_url']) . '" target="_blank" class="text-brand-primary text-xs font-bold hover:underline">' . e($site['site_url']) . '</a>',
        Component::badge(ucfirst($site['status']), $statusType),
        Component::badge(strtoupper($site['plan']), 'info')
    ];
}

$service_headers = ['Operational Service', 'Category', 'Status', 'Expiry'];
$service_rows = [];

foreach ($services as $service) {
    $statusType = $service['status'] === 'active' ? 'success' : 'warning';
    $service_rows[] = [
        '<p class="font-display font-bold text-brand-secondary dark:text-white text-base">' . e($service['service_name']) . '</p>',
        '<p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">' . e($service['service_type']) . '</p>',
        Component::badge(ucfirst($service['status']), $statusType),
        '<p class="text-[10px] text-slate-500 font-medium">' . ($service['expiry_date'] ? date('M d, Y', strtotime($service['expiry_date'])) : 'Perpetual') . '</p>'
    ];
}
?>

<div class="animate-in fade-in slide-in-from-bottom-4 duration-500">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
        <div>
            <h2 class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-primary mb-3">Client Console</h2>
            <h1 class="font-display text-4xl font-extrabold text-brand-secondary dark:text-white mb-2 tracking-tight">Active Infrastructure</h1>
            <p class="text-slate-500 dark:text-slate-400 font-medium">Monitoring and managing your digital ecosystems with NuMinds Tech.</p>
        </div>
        
        <div class="flex gap-4">
            <?= Component::statsCard(count($websites), 'Sites Online', 'fa-globe', 'brand-primary') ?>
            <?= Component::statsCard(count($services), 'Active Services', 'fa-receipt', 'brand-accent') ?>
        </div>
    </div>

    <div class="space-y-12">
        <!-- WEBSITES SECTION -->
        <section>
            <div class="flex items-center gap-3 mb-6">
                <div class="w-8 h-8 rounded-lg bg-brand-primary/10 flex items-center justify-center text-brand-primary">
                    <i class="fa-solid fa-server text-sm"></i>
                </div>
                <h3 class="font-display font-bold text-xl dark:text-white tracking-tight">Web Properties</h3>
            </div>
            
            <?php if (count($websites)): ?>
                <?= Component::table($site_headers, $site_rows) ?>
            <?php else: ?>
                <?= Component::card('<p class="text-slate-500 py-4 text-center">No active websites found in your registry.</p>') ?>
            <?php endif; ?>
        </section>

        <!-- SERVICES SECTION -->
        <section>
            <div class="flex items-center gap-3 mb-6">
                <div class="w-8 h-8 rounded-lg bg-brand-accent/10 flex items-center justify-center text-brand-accent">
                    <i class="fa-solid fa-bolt text-sm"></i>
                </div>
                <h3 class="font-display font-bold text-xl dark:text-white tracking-tight">Service Contracts</h3>
            </div>
            
            <?php if (count($services)): ?>
                <?= Component::table($service_headers, $service_rows) ?>
            <?php else: ?>
                <?= Component::card('<p class="text-slate-500 py-4 text-center">No active services currently provisioned.</p>') ?>
            <?php endif; ?>
        </section>

        <!-- SUPPORT TICKET MOCK -->
        <section class="mt-16">
            <?= Component::card('
                <div class="flex flex-col md:flex-row items-center gap-8">
                    <div class="w-20 h-20 bg-brand-primary/10 rounded-[2rem] flex items-center justify-center text-brand-primary text-3xl shrink-0">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <div class="flex-1 text-center md:text-left">
                        <h4 class="font-display font-bold text-2xl dark:text-white mb-2">Need Direct Assistance?</h4>
                        <p class="text-slate-500 dark:text-slate-400 font-medium leading-relaxed max-w-xl">
                            Our technical optimization team is ready to support your infrastructure expansions or troubleshoot any operational issues.
                        </p>
                    </div>
                    <div class="shrink-0">
                        '.Component::button('Open Support Ticket', 'button', 'primary', 'onclick="alert(\'Support system integration coming soon!\')"').'
                    </div>
                </div>
            ', '', '', 'bg-slate-50 dark:bg-brand-navy/30 border-dashed') ?>
        </section>
    </div>
</div>
