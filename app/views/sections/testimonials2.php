<!-- TESTIMONIALS (Minimal Google Review Style) -->
<section id="testimonials" class="py-24 bg-white dark:bg-brand-dark relative overflow-hidden">

    <div class="max-w-7xl mx-auto px-8 relative z-10">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-8 text-center md:text-left">
            <div>
                <h2 class="text-[10px] font-bold uppercase tracking-[0.4em] text-brand-primary mb-4">Customer Trust</h2>
                <h3 class="font-display text-4xl font-extrabold text-heading dark:text-inverse tracking-tight">
                    What our clients <span class="text-brand-accent italic">actually say</span>
                </h3>
            </div>
            <div class="flex flex-col items-center md:items-end">
                <div class="flex gap-1 text-sm text-amber-400 mb-2">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                </div>
                <p class="text-[10px] font-bold uppercase tracking-widest text-muted">4.9/5 Rating across 60+ projects</p>
            </div>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if (empty($testimonials)): ?>
                <div class="lg:col-span-3 text-center py-12 text-muted uppercase tracking-widest text-[10px] font-bold">
                    New reviews coming soon...
                </div>
            <?php else: ?>
                <?php foreach($testimonials as $t): ?>
                <div class="bg-white dark:bg-brand-navy p-8 rounded-2xl border border-slate-100 dark:border-white/5 transition-all duration-500 hover:border-brand-primary/30 group shadow-sm">
                    <div class="flex items-start justify-between mb-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-white dark:border-white/10 shadow-sm">
                                <?php if ($t['avatar']): ?>
                                    <img src="<?= url('public/uploads/' . $t['avatar']) ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($t['client_name']) ?>&background=2563eb&color=fff" class="w-full h-full object-cover">
                                <?php endif; ?>
                            </div>
                            <div>
                                <h4 class="font-display font-bold text-sm text-heading dark:text-white"><?= e($t['client_name']) ?></h4>
                                <p class="text-[9px] font-bold text-muted uppercase tracking-widest"><?= e($t['client_position'] ?? 'Verified Client') ?></p>
                            </div>
                        </div>
                        <div class="flex gap-0.5 text-[10px] text-amber-400">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                    </div>
                    <p class="text-xs text-body dark:text-muted leading-relaxed font-medium italic">
                        "<?= e($t['content']) ?>"
                    </p>
                    <div class="mt-6 flex items-center gap-2">
                        <div class="w-4 h-4 bg-emerald-500/10 text-emerald-500 rounded-full flex items-center justify-center text-[8px]">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <span class="text-[8px] font-bold uppercase tracking-widest text-emerald-500">Verified Partner</span>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
