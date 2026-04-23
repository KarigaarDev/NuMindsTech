<?php
use UI\Component;

$totalViews = $stats['total_pageviews'] ?? 0;
$uniqueVisitors = $stats['unique_visitors'] ?? 0;
$totalReferrals = $stats['referrals'] ?? 0;

if (!function_exists('e')) {
    function e($string) { return htmlspecialchars((string)$string, ENT_QUOTES, 'UTF-8'); }
}
?>

<!-- Header -->
<div class="mb-12">
    <h2 class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-primary mb-3">Prod-Level Monitoring</h2>
    <h1 class="font-display text-4xl font-extrabold text-brand-secondary dark:text-white mb-2 tracking-tight">
        Traffic Analytics
    </h1>
    <p class="text-slate-500 dark:text-slate-400 font-medium">Track page views, user engagement, and referral sources.</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
    <?= Component::statsCard($totalViews, 'Total Pageviews', 'fa-eye', 'brand-primary') ?>
    <?= Component::statsCard($uniqueVisitors, 'Unique IPs', 'fa-users', 'emerald-500') ?>
    <?= Component::statsCard($totalReferrals, 'Link Referrals', 'fa-link', 'accent') ?>
</div>

<!-- Analytics Area -->
<div class="grid lg:grid-cols-3 gap-8 mb-12">
    <!-- Traffic Chart -->
    <div class="lg:col-span-2 bg-white dark:bg-brand-navy p-10 rounded-[2.5rem] border border-slate-100 dark:border-white/5 shadow-sm">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h3 class="font-display text-xl font-bold dark:text-white">Traffic Growth</h3>
                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Past 14 Days Pageviews</p>
            </div>
            <i class="fa-solid fa-chart-area text-brand-primary"></i>
        </div>
        <canvas id="trafficChart" height="150"></canvas>
    </div>

    <!-- Referrers Panel -->
    <div class="bg-white dark:bg-brand-navy p-10 rounded-[2.5rem] border border-slate-100 dark:border-white/5 shadow-sm">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h3 class="font-display text-xl font-bold dark:text-white">Referral Sources</h3>
                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Top Promotion Links</p>
            </div>
            <i class="fa-solid fa-bullhorn text-brand-accent"></i>
        </div>
        
        <?php if (empty($referrals)): ?>
            <p class="text-slate-500 text-sm italic">No referral traffic detected yet.</p>
        <?php else: ?>
            <ul class="space-y-4">
                <?php foreach ($referrals as $ref): ?>
                    <li class="flex items-center justify-between p-4 rounded-xl bg-slate-50 dark:bg-white/5">
                        <span class="font-bold text-sm text-brand-secondary dark:text-white"><?= e($ref['ref_code']) ?></span>
                        <span class="text-xs font-bold bg-brand-primary/10 text-brand-primary px-3 py-1 rounded-full"><?= number_format($ref['count']) ?> visits</span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>

<!-- Interaction Analytics -->
<div class="grid lg:grid-cols-2 gap-8 mb-12">
    <!-- Social Media Performance -->
    <div class="bg-white dark:bg-brand-navy p-10 rounded-[2.5rem] border border-slate-100 dark:border-white/5 shadow-sm">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h3 class="font-display text-xl font-bold dark:text-white">Social Engagement</h3>
                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Icon Click Distribution</p>
            </div>
            <i class="fa-solid fa-share-nodes text-brand-primary"></i>
        </div>
        
        <?php if (empty($topSocial)): ?>
            <p class="text-slate-500 text-sm italic">No social media clicks recorded yet.</p>
        <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($topSocial as $social): ?>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-slate-600 dark:text-slate-400"><?= e($social['platform']) ?></span>
                        <div class="flex items-center gap-3 flex-1 px-8">
                            <div class="flex-1 h-2 bg-slate-100 dark:bg-white/5 rounded-full overflow-hidden">
                                <div class="h-full bg-brand-primary rounded-full" style="width: <?= min(100, ($social['count'] / max(1, $topSocial[0]['count'])) * 100) ?>%"></div>
                            </div>
                        </div>
                        <span class="text-sm font-bold text-brand-secondary dark:text-white"><?= number_format($social['count']) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- CTA Performance -->
    <div class="bg-white dark:bg-brand-navy p-10 rounded-[2.5rem] border border-slate-100 dark:border-white/5 shadow-sm">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h3 class="font-display text-xl font-bold dark:text-white">CTA Performance</h3>
                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">High-Intent Interactions</p>
            </div>
            <i class="fa-solid fa-hand-pointer text-brand-accent"></i>
        </div>
        
        <?php if (empty($topCtas)): ?>
            <p class="text-slate-500 text-sm italic">No button interactions recorded yet.</p>
        <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($topCtas as $cta): ?>
                    <div class="flex items-center justify-between p-4 rounded-xl border border-slate-100 dark:border-white/5 bg-slate-50/50 dark:bg-white/5">
                        <div class="flex items-center gap-4">
                            <div class="w-8 h-8 rounded-lg bg-brand-accent/10 flex items-center justify-center text-brand-accent">
                                <i class="fa-solid fa-bolt text-xs"></i>
                            </div>
                            <span class="text-xs font-bold uppercase tracking-widest text-slate-600 dark:text-slate-300"><?= e($cta['label']) ?></span>
                        </div>
                        <span class="text-sm font-black text-brand-secondary dark:text-white"><?= number_format($cta['count']) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Top Pages Table -->
<div class="bg-white dark:bg-brand-navy rounded-[2.5rem] border border-slate-100 dark:border-white/5 shadow-sm overflow-hidden mb-12 p-10">
    <div class="mb-8">
         <h3 class="font-display text-xl font-bold dark:text-white">Content Performance</h3>
         <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Pageview Demographics</p>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="text-[10px] font-bold uppercase tracking-widest text-slate-400 border-b border-slate-100 dark:border-white/10">
                    <th class="pb-4 px-4 font-bold">Page Path</th>
                    <th class="pb-4 px-4 font-bold text-right">Engagement</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                <?php foreach ($topPages as $page): ?>
                <tr class="hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                    <td class="py-4 px-4 text-sm font-medium text-slate-700 dark:text-slate-300"><?= e($page['page_url']) ?></td>
                    <td class="py-4 px-4 text-sm font-bold text-brand-secondary dark:text-white text-right"><?= number_format($page['views']) ?> views</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Traffic Growth Chart
    const trafficCtx = document.getElementById('trafficChart');
    if (trafficCtx) {
        new Chart(trafficCtx.getContext('2d'), {
            type: 'line',
            data: {
                labels: <?= json_encode(array_column($timeline, 'date')) ?>,
                datasets: [{
                    label: 'Pageviews',
                    data: <?= json_encode(array_column($timeline, 'views')) ?>,
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 4,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#10b981',
                    pointBorderWidth: 2
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { display: false }, ticks: { font: { size: 10, weight: 'bold' } } },
                    x: { grid: { display: false }, ticks: { font: { size: 10, weight: 'bold' } } }
                }
            }
        });
    }
});
</script>
