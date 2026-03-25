<?php
use UI\Component;
?>
<div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-6 relative z-10">
    <div>
        <h2 class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-primary mb-3">Aesthetic Control</h2>
        <h1 class="font-display text-4xl font-extrabold text-heading dark:text-inverse tracking-tight">Theme Engine</h1>
        <p class="text-slate-500 dark:text-slate-400 font-medium mt-2">Create and switch between custom brand identities effortlessly.</p>
    </div>
    
    <div class="flex gap-4">
        <a href="<?= url('admin/themes.php?action=create') ?>" class="btn-primary px-8 py-3 rounded-xl font-display font-bold text-xs uppercase tracking-widest shadow-xl flex items-center gap-2 transform hover:scale-105 transition-all">
            <i class="fa-solid fa-wand-magic-sparkles"></i> Create Theme
        </a>
    </div>
</div>

<?php if (isset($_SESSION['success'])): ?>
    <div class="mb-8 relative z-10">
        <?= Component::badge($_SESSION['success'], 'success') ?>
        <?php unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="mb-8 relative z-10">
        <?= Component::badge($_SESSION['error'], 'danger') ?>
        <?php unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 relative z-10">
    <?php foreach ($themes as $t): ?>
        <div class="bg-white dark:bg-brand-navy rounded-[2rem] border <?= $t['is_active'] ? 'border-brand-primary border-2 shadow-2xl shadow-brand-primary/20' : 'border-slate-100 dark:border-white/5 shadow-sm' ?> p-8 transition-all hover:-translate-y-1">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <?php if ($t['is_active']): ?>
                        <div class="w-10 h-10 rounded-xl bg-brand-primary text-white flex items-center justify-center shadow-lg shadow-brand-primary/30">
                            <i class="fa-solid fa-check"></i>
                        </div>
                    <?php else: ?>
                        <div class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-white/5 text-slate-400 flex items-center justify-center">
                            <i class="fa-solid fa-palette"></i>
                        </div>
                    <?php endif; ?>
                    <div>
                        <h3 class="font-display font-bold text-heading dark:text-white text-lg"><?= e($t['name']) ?></h3>
                        <p class="text-[9px] font-bold uppercase tracking-widest <?= $t['is_active'] ? 'text-brand-primary' : 'text-slate-400' ?>">
                            <?= $t['is_active'] ? 'Active System Theme' : 'Saved Preset' ?>
                        </p>
                    </div>
                </div>
                
                <div class="flex gap-2">
                    <a href="<?= url('admin/themes.php?action=edit&id=' . $t['id']) ?>" title="Edit Theme" class="w-8 h-8 rounded-lg bg-slate-50 dark:bg-white/5 text-slate-400 hover:text-brand-primary flex items-center justify-center transition-colors">
                        <i class="fa-solid fa-pen-to-square text-sm"></i>
                    </a>
                    <?php if (!$t['is_active']): ?>
                        <a href="<?= url('admin/themes.php?action=delete&id=' . $t['id']) ?>" title="Delete" onclick="return confirm('Delete this theme?')" class="w-8 h-8 rounded-lg bg-slate-50 dark:bg-white/5 text-slate-400 hover:text-rose-500 flex items-center justify-center transition-colors">
                            <i class="fa-solid fa-trash text-sm"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Color Palette Preview -->
            <div class="mb-6 space-y-4">
                <div class="flex justify-between items-end">
                    <div>
                        <p class="text-[9px] font-bold uppercase tracking-widest text-slate-400 mb-2">Light Mode</p>
                        <div class="flex gap-2">
                            <div class="w-6 h-6 rounded-full shadow-sm" style="background: <?= e($t['light_primary']) ?>;"></div>
                            <div class="w-6 h-6 rounded-full shadow-sm" style="background: <?= e($t['light_accent']) ?>;"></div>
                            <div class="w-6 h-6 rounded-full shadow-sm border border-slate-200" style="background: <?= e($t['light_secondary']) ?>;"></div>
                        </div>
                    </div>
                    <button class="px-4 py-1.5 rounded-lg text-[10px] font-bold shadow-md" style="background: <?= e($t['light_btn_bg']) ?>; color: <?= e($t['light_btn_text']) ?>;">CTA Preview</button>
                </div>
                <div class="flex justify-between items-end">
                    <div>
                        <p class="text-[9px] font-bold uppercase tracking-widest text-slate-400 mb-2">Dark Mode</p>
                        <div class="flex gap-2">
                            <div class="w-6 h-6 rounded-full shadow-sm" style="background: <?= e($t['dark_primary']) ?>;"></div>
                            <div class="w-6 h-6 rounded-full shadow-sm" style="background: <?= e($t['dark_accent']) ?>;"></div>
                            <div class="w-6 h-6 rounded-full shadow-sm border border-slate-700" style="background: <?= e($t['dark_secondary']) ?>;"></div>
                        </div>
                    </div>
                    <button class="px-4 py-1.5 rounded-lg text-[10px] font-bold shadow-md" style="background: <?= e($t['dark_btn_bg']) ?>; color: <?= e($t['dark_btn_text']) ?>;">CTA Preview</button>
                </div>
            </div>

            <div class="flex items-center justify-between border-t border-slate-100 dark:border-white/5 pt-6">
                <div class="text-[10px] font-medium text-slate-500 dark:text-slate-400">
                    <span style="font-family: '<?= e($t['font_sans']) ?>', sans-serif">Sans</span> & 
                    <span style="font-family: '<?= e($t['font_display']) ?>', sans-serif" class="font-bold">Display</span>
                </div>
                
                <?php if (!$t['is_active']): ?>
                    <form method="post" action="<?= url('admin/themes.php?action=activate&id=' . $t['id']) ?>">
                        <?= csrf_field() ?>
                        <button type="submit" class="text-[10px] font-bold uppercase tracking-widest text-brand-primary hover:text-brand-accent transition-colors flex items-center gap-1">
                            Activate <i class="fa-solid fa-power-off"></i>
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
