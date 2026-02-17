<?php
use UI\Component;

// Display success message
if (isset($_SESSION['success'])) {
    echo '<div class="mb-8 p-6 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl text-emerald-600 dark:text-emerald-400 font-medium animate-in fade-in slide-in-from-top-4 duration-500">' . e($_SESSION['success']) . '</div>';
    unset($_SESSION['success']);
}
?>

<div class="space-y-10 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <h2 class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-primary mb-3">Content Management</h2>
            <h1 class="font-display text-4xl font-extrabold text-brand-secondary dark:text-white mb-2 tracking-tight">Portfolio Projects</h1>
            <p class="text-slate-500 dark:text-slate-400 font-medium italic">Manage your showcase of work and case studies.</p>
        </div>
        
        <a href="<?= url('portfolio?action=create') ?>" class="inline-flex items-center gap-3 px-8 py-4 bg-brand-primary hover:bg-brand-primary/90 text-white rounded-2xl font-display font-bold text-xs uppercase tracking-widest transition-all shadow-lg shadow-brand-primary/20 hover:-translate-y-0.5">
            <i class="fa-solid fa-plus"></i> Add New Project
        </a>
    </div>

    <!-- Portfolio Grid -->
    <?php if (count($items) > 0): ?>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($items as $item): ?>
                <div class="group relative bg-white dark:bg-brand-navy rounded-[2rem] overflow-hidden border border-slate-100 dark:border-white/5 shadow-sm hover:shadow-2xl hover:shadow-brand-primary/10 transition-all duration-500">
                    <!-- Featured Image -->
                    <div class="aspect-[4/3] bg-slate-100 dark:bg-brand-secondary overflow-hidden">
                        <?php if ($item['featured_image']): ?>
                            <img src="<?= url('public/uploads/' . $item['featured_image']) ?>" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700 group-hover:scale-110" alt="<?= e($item['title']) ?>">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center text-slate-300 dark:text-slate-700">
                                <i class="fa-solid fa-image text-6xl"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Content -->
                    <div class="p-6 space-y-4">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1">
                                <h3 class="font-display font-bold text-lg text-brand-secondary dark:text-white mb-1 line-clamp-1"><?= e($item['title']) ?></h3>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-brand-accent"><?= e($item['category']) ?></p>
                            </div>
                            <?= Component::badge($item['status'] === 'published' ? 'LIVE' : 'DRAFT', $item['status'] === 'published' ? 'success' : 'neutral') ?>
                        </div>
                        
                        <?php if ($item['client_name']): ?>
                            <p class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-2">
                                <i class="fa-solid fa-user text-brand-primary"></i> <?= e($item['client_name']) ?>
                            </p>
                        <?php endif; ?>
                        
                        <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 leading-relaxed"><?= e($item['description']) ?></p>
                        
                        <!-- Actions -->
                        <div class="flex items-center gap-3 pt-4 border-t border-slate-100 dark:border-white/5">
                            <a href="<?= url('portfolio?action=edit&id=' . $item['id']) ?>" class="flex-1 text-center px-4 py-2.5 bg-slate-50 dark:bg-brand-secondary hover:bg-brand-primary/10 dark:hover:bg-brand-primary/10 text-brand-primary rounded-xl font-bold text-[10px] uppercase tracking-widest transition-all">
                                <i class="fa-solid fa-pen"></i> Edit
                            </a>
                            <form method="POST" action="<?= url('portfolio-delete?id=' . $item['id']) ?>" class="flex-1" onsubmit="return confirm('Delete this portfolio item?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-brand-secondary hover:bg-red-500/10 dark:hover:bg-red-500/10 text-red-500 rounded-xl font-bold text-[10px] uppercase tracking-widest transition-all">
                                    <i class="fa-solid fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <?= Component::card('
            <div class="py-20 text-center">
                <div class="w-20 h-20 bg-slate-100 dark:bg-brand-secondary rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fa-solid fa-briefcase text-3xl text-slate-300 dark:text-slate-700"></i>
                </div>
                <h3 class="font-display font-bold text-xl dark:text-white mb-2">No Portfolio Items Yet</h3>
                <p class="text-slate-500 dark:text-slate-400 mb-8">Start showcasing your work by adding your first project.</p>
                <a href="' . url('portfolio?action=create') . '" class="inline-flex items-center gap-2 px-6 py-3 bg-brand-primary text-white rounded-xl font-bold text-xs uppercase tracking-widest">
                    <i class="fa-solid fa-plus"></i> Add Project
                </a>
            </div>
        ', '', '', 'border-dashed') ?>
    <?php endif; ?>
</div>
