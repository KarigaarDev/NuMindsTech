<!-- TESTIMONIALS (Simple + Premium) -->
<section id="testimonials" class="py-20 md:py-28 bg-white dark:bg-brand-dark relative overflow-hidden">

    <div class="max-w-7xl mx-auto px-5 md:px-8 relative z-10">

        <!-- HEADER -->
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-14 md:mb-16 gap-6 text-center md:text-left">

            <div>
                <h2 class="text-xs font-bold uppercase tracking-[0.4em] text-brand-primary mb-3">
                    Real Feedback
                </h2>

                <h3 class="font-display text-3xl md:text-4xl font-black text-heading dark:text-inverse tracking-tight leading-tight">
                    What people 
                    <span class="text-brand-accent italic">say about us</span>
                </h3>
            </div>

            <div class="flex flex-col items-center md:items-end">
                <div class="flex gap-1 text-amber-400 mb-1 text-sm">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                </div>
                <p class="text-[10px] font-bold uppercase tracking-widest text-muted">
                    4.9/5 from happy clients
                </p>
            </div>

        </div>

        <!-- GRID (2 on mobile, 3 on desktop) -->
        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">

            <?php if (empty($testimonials)): ?>
                <div class="col-span-2 lg:col-span-3 text-center py-10 text-muted text-xs font-bold uppercase tracking-widest">
                    New reviews coming soon...
                </div>
            <?php else: ?>
                <?php foreach($testimonials as $t): ?>

                <div class="bg-white/80 dark:bg-brand-navy/60 backdrop-blur-md 
                            p-5 md:p-7 rounded-2xl border border-slate-100 dark:border-white/5
                            shadow-sm hover:shadow-lg hover:-translate-y-1 
                            transition-all duration-300 group">

                    <!-- TOP -->
                    <div class="flex items-start justify-between mb-4">

                        <div class="flex items-center gap-3">

                            <div class="w-10 h-10 rounded-full overflow-hidden border border-white/20 shadow-sm">
                                <?php if ($t['avatar']): ?>
                                    <img src="<?= url('public/uploads/' . $t['avatar']) ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($t['client_name']) ?>&background=2563eb&color=fff" class="w-full h-full object-cover">
                                <?php endif; ?>
                            </div>

                            <div>
                                <h4 class="text-sm font-semibold text-heading dark:text-white">
                                    <?= e($t['client_name']) ?>
                                </h4>
                                <p class="text-[9px] text-muted uppercase tracking-widest">
                                    <?= e($t['client_position'] ?? 'Client') ?>
                                </p>
                            </div>

                        </div>

                        <div class="flex text-amber-400 text-[10px]">
                            ★★★★★
                        </div>

                    </div>

                    <!-- REVIEW -->
                    <p class="text-xs text-body dark:text-muted leading-relaxed italic">
                        "<?= e($t['content']) ?>"
                    </p>

                    <!-- VERIFIED -->
                    <div class="mt-4 flex items-center gap-2">
                        <div class="w-4 h-4 bg-green-100 dark:bg-green-900/20 text-green-600 rounded-full flex items-center justify-center text-[8px]">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <span class="text-[9px] font-semibold text-green-600 uppercase tracking-widest">
                            Trusted Partner
                        </span>
                    </div>

                </div>

                <?php endforeach; ?>
            <?php endif; ?>

        </div>

    </div>
</section>