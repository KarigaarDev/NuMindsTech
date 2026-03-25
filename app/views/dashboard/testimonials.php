<?php
use UI\Component;
?>
<div class="animate-in fade-in slide-in-from-bottom-4 duration-500">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
        <div>
            <h2 class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-primary mb-3">Content Hub</h2>
            <h1 class="font-display text-4xl font-extrabold text-brand-secondary dark:text-white mb-2 tracking-tight">Client Praises</h1>
            <p class="text-slate-500 dark:text-slate-400 font-medium italic">Manage and feature the best words from your partners.</p>
        </div>
        
        <a href="<?= url('admin/testimonials?action=create') ?>" class="inline-flex items-center gap-3 px-8 py-4 bg-brand-primary hover:bg-brand-primary/90 text-white rounded-2xl font-display font-bold text-xs uppercase tracking-widest transition-all shadow-lg shadow-brand-primary/20">
            <i class="fa-solid fa-plus"></i> Add Testimonial
        </a>
    </div>

    <!-- Testimonials Grid -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
        <?php foreach ($testimonials as $t): ?>
            <div class="group relative bg-white dark:bg-brand-navy p-8 rounded-[2rem] border border-slate-100 dark:border-white/5 shadow-sm hover:shadow-2xl hover:shadow-brand-primary/10 transition-all duration-500 flex flex-col">
                <div class="flex items-start justify-between mb-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-slate-50 dark:border-white/10 shadow-sm bg-slate-100 dark:bg-brand-secondary flex items-center justify-center font-display font-bold text-brand-primary">
                            <?= substr($t['client_name'], 0, 1) ?>
                        </div>
                        <div>
                            <h4 class="font-display font-bold text-sm text-heading dark:text-white"><?= e($t['client_name']) ?></h4>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest"><?= e($t['client_position'] ?: 'Verified Partner') ?></p>
                        </div>
                    </div>
                    <?= \UI\Component::badge($t['status'] === 'active' ? 'LIVE' : 'HIDDEN', $t['status'] === 'active' ? 'success' : 'neutral') ?>
                </div>

                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed font-medium italic flex-1">
                    "<?= e($t['content']) ?>"
                </p>

                <div class="mt-8 pt-6 border-t border-slate-50 dark:border-white/5 flex items-center gap-3">
                    <a href="<?= url('admin/testimonials?action=edit&id=' . $t['id']) ?>" class="flex-1 text-center px-4 py-2.5 bg-slate-50 dark:bg-brand-secondary hover:bg-brand-primary/10 text-brand-primary rounded-xl font-bold text-[10px] uppercase tracking-widest transition-all">
                        <i class="fa-solid fa-pen"></i> Edit
                    </a>
                    <form method="POST" action="<?= url('admin/testimonials-delete') ?>" class="flex-1" onsubmit="return confirm('Delete this testimonial?')">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= $t['id'] ?>">
                        <button type="submit" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-brand-secondary hover:bg-red-500/10 text-red-500 rounded-xl font-bold text-[10px] uppercase tracking-widest transition-all">
                            <i class="fa-solid fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if (empty($testimonials)): ?>
        <div class="py-20 text-center bg-white dark:bg-brand-navy rounded-[2.5rem] border border-dashed border-slate-200 dark:border-white/10">
            <div class="w-16 h-16 bg-slate-50 dark:bg-brand-secondary rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300">
                <i class="fa-solid fa-quote-left text-2xl"></i>
            </div>
            <h3 class="font-display font-bold text-xl dark:text-white mb-2">No Testimonials Found</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm">You haven't added any client praises yet.</p>
        </div>
    <?php endif; ?>
</div>
