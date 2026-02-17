<?php
use UI\Component;
?>
<div class="animate-in fade-in slide-in-from-bottom-4 duration-500">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
        <div>
            <h2 class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-primary mb-3">Solution Catalog</h2>
            <h1 class="font-display text-4xl font-extrabold text-brand-secondary dark:text-white mb-2 tracking-tight">Portfolio Management</h1>
            <p class="text-slate-500 dark:text-slate-400 font-medium">Project your expertise. Add or remove showcased technical solutions.</p>
        </div>
    </div>

    <!-- ADD FORM -->
    <div class="mb-16">
        <?= Component::card('
            <form method="post" enctype="multipart/form-data" class="space-y-8">
                ' . csrf_field() . '
                
                <div class="grid md:grid-cols-2 gap-10">
                    ' . Component::input('title', 'Solution Designation / Title', '', 'text', 'e.g. Institutional Management Core') . '

                    <div class="space-y-3">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.3em]">Visual Asset / Image</label>
                        <div class="relative group/file">
                             <input type="file" name="image" class="block w-full text-xs text-slate-500 dark:text-slate-400
                              file:mr-6 file:py-3 file:px-6
                              file:rounded-xl file:border-0
                              file:text-[10px] file:font-bold file:uppercase file:tracking-[0.1em]
                              file:bg-brand-primary/10 file:text-brand-primary
                              hover:file:bg-brand-primary/20
                              transition-all cursor-pointer border-b-2 border-slate-200 dark:border-white/10 py-1
                            ">
                        </div>
                    </div>
                </div>

                <div class="space-y-2 mb-6">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400">Mission Overview / Description</label>
                    <textarea name="description" rows="4" placeholder="Brief technical overview of the solution..." class="w-full bg-slate-50 dark:bg-brand-secondary/50 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-brand-primary/50 transition-colors dark:text-white font-medium resize-none"></textarea>
                </div>

                <div class="flex justify-end pt-4">
                    ' . Component::button('Deploy to Catalog', 'submit', 'primary', 'name="save"') . '
                </div>
            </form>
        ', 'Inscribe New Solution', 'fa-plus') ?>
    </div>

    <!-- LIST -->
    <div class="mb-10">
        <h3 class="font-display text-2xl font-bold text-brand-navy dark:text-white mb-2 tracking-tight">Active Artifacts</h3>
        <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-slate-400">Currently displayed on the public interface</p>
    </div>
    
    <?php if (count($items)): ?>
        <div class="grid md:grid-cols-3 gap-8 pb-20">
            <?php foreach ($items as $item): ?>
                <div class="bg-white dark:bg-brand-navy rounded-[2.5rem] p-6 border border-slate-100 dark:border-white/5 transition-all duration-500 hover:shadow-xl hover:shadow-brand-primary/5 hover:-translate-y-1 group">
                    <div class="aspect-video rounded-3xl overflow-hidden bg-slate-100 dark:bg-brand-dark/50 relative mb-8">
                        <?php if ($item['image']): ?>
                            <img src="<?= url('uploads/'.$item['image']) ?>"
                                 class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center text-slate-300 dark:text-slate-600">
                                <i class="fa-regular fa-image text-3xl"></i>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Actions Overlay -->
                        <div class="absolute inset-x-0 bottom-0 p-4 translate-y-full group-hover:translate-y-0 transition-transform bg-gradient-to-t from-brand-secondary/90 to-transparent flex justify-end">
                             <form method="post" action="<?= url('admin/item-delete') ?>"
                                  onsubmit="return confirm('Confirm deletion of this artifact?');">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                <button class="w-10 h-10 rounded-xl bg-white/10 backdrop-blur-md text-white hover:bg-red-500 hover:text-white flex items-center justify-center transition-all border border-white/20 active:scale-90" title="Delete">
                                    <i class="fa-solid fa-trash-can text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div>
                        <h3 class="font-display font-bold text-lg text-brand-secondary dark:text-white mb-3 truncate group-hover:text-brand-primary transition-colors" title="<?= e($item['title']) ?>">
                            <?= e($item['title']) ?>
                        </h3>
                        <p class="text-slate-500 dark:text-slate-400 text-[11px] font-medium leading-relaxed line-clamp-3">
                            <?= e($item['description']) ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <?= Component::card('
            <div class="text-center py-12">
                <div class="w-20 h-20 bg-slate-50 dark:bg-white/5 rounded-3xl flex items-center justify-center mx-auto mb-6 text-slate-300 dark:text-slate-700 text-3xl">
                    <i class="fa-solid fa-box-archive"></i>
                </div>
                <p class="text-slate-500 dark:text-slate-400 font-bold text-[10px] uppercase tracking-[0.3em]">Catalog Empty</p>
                <p class="text-slate-400 dark:text-slate-500 text-xs mt-2">New solutions added above will appear here.</p>
            </div>
        ', '', '') ?>
    <?php endif; ?>
</div>
