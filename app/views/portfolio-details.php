<section class="py-24 bg-white dark:bg-brand-dark min-h-screen relative overflow-hidden">
    <!-- Grid Background -->
    <div class="absolute inset-0 opacity-[0.03] dark:opacity-10 pointer-events-none">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="grid-details" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="currentColor" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid-details)" />
        </svg>
    </div>

    <div class="max-w-7xl mx-auto px-8 relative z-10">
        <!-- Breadcrumbs / Back -->
        <a href="<?= url('') ?>#solutions" class="inline-flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-slate-400 hover:text-brand-primary transition-colors mb-12 group">
            <i class="fa-solid fa-arrow-left transition-transform group-hover:-translate-x-1"></i>
            Back to Showcase
        </a>

        <div class="grid lg:grid-cols-2 gap-20">
            <!-- Asset Column -->
            <div class="space-y-8">
                <div class="aspect-[4/3] rounded-[2.5rem] overflow-hidden bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/10 shadow-2xl">
                    <?php if ($item['featured_image']): ?>
                        <img src="<?= url('public/uploads/' . $item['featured_image']) ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center text-slate-300 dark:text-slate-700">
                            <i class="fa-solid fa-image text-8xl"></i>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Content Column -->
            <div class="py-6">
                <div class="flex items-center gap-3 mb-6">
                    <span class="px-4 py-1.5 rounded-full bg-brand-primary/10 text-brand-primary text-[10px] font-bold uppercase tracking-widest border border-brand-primary/20">
                        <?= e($item['category']) ?>
                    </span>
                    <?php if ($item['is_featured']): ?>
                        <span class="px-4 py-1.5 rounded-full bg-amber-500/10 text-amber-500 text-[10px] font-bold uppercase tracking-widest border border-amber-500/20">
                             <i class="fa-solid fa-star mr-1"></i> Featured
                        </span>
                    <?php endif; ?>
                </div>

                <h1 class="font-display text-5xl font-extrabold text-heading dark:text-white mb-8 tracking-tight leading-tight">
                    <?= e($item['title']) ?>
                </h1>

                <div class="prose prose-slate dark:prose-invert max-w-none text-slate-500 dark:text-slate-400 leading-relaxed mb-12">
                    <?= nl2br(e($item['description'])) ?>
                </div>

                <!-- Meta Details -->
                <div class="grid grid-cols-2 gap-8 border-t border-slate-100 dark:border-white/5 pt-12">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2">Client</p>
                        <p class="font-display font-bold text-lg dark:text-white"><?= e($item['client_name'] ?: 'Internal Project') ?></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2">Completion</p>
                        <p class="font-display font-bold text-lg dark:text-white"><?= $item['completion_date'] ? date('M Y', strtotime($item['completion_date'])) : 'Ongoing' ?></p>
                    </div>
                </div>

                <div class="mt-16 flex flex-wrap gap-4">
                    <?php if ($item['project_url']): ?>
                        <a href="<?= e($item['project_url']) ?>" target="_blank" class="px-10 py-4 bg-brand-primary text-white rounded-2xl font-display font-bold text-[11px] uppercase tracking-widest transition-all shadow-lg shadow-brand-primary/20 hover:-translate-y-1 flex items-center gap-3">
                            Launch Project <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                        </a>
                    <?php endif; ?>
                    <button @click="modalOpen = true" class="px-10 py-4 bg-white/5 hover:bg-white/10 text-brand-secondary dark:text-white rounded-2xl font-display font-bold text-[11px] uppercase tracking-widest transition-all border border-slate-200 dark:border-white/10 flex items-center gap-3">
                        Request Similar <i class="fa-solid fa-bolt text-brand-accent"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
