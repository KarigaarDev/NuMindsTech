</main>

<footer class="bg-brand-navy dark:bg-brand-dark text-slate-400 border-t border-white/5 py-24 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-8 flex flex-col md:flex-row justify-between items-start gap-16">
        
        <div class="max-w-sm">
            <a href="<?= url('') ?>" class="flex items-center gap-3 mb-8">
                <div class="w-8 h-8 rounded bg-brand-primary flex items-center justify-center text-white font-bold">N</div>
                <span class="font-display font-bold text-xl text-white tracking-tight">NuMinds <span class="text-brand-accent">Tech</span></span>
            </a>
            <p class="text-sm leading-relaxed mb-8">
                <?= setting('site_description', 'Building simple, high-performance digital systems for organizations that value clarity and trust.') ?>
            </p>
            <div class="flex gap-4">
                <?php if ($fb = setting('social_facebook')): ?>
                <a href="<?= e($fb) ?>" target="_blank" class="w-10 h-10 rounded-lg bg-white/5 flex items-center justify-center hover:bg-brand-primary hover:text-white transition-all">
                    <i class="fa-brands fa-facebook-f"></i>
                </a>
                <?php endif; ?>
                <?php if ($li = setting('social_linkedin')): ?>
                <a href="<?= e($li) ?>" target="_blank" class="w-10 h-10 rounded-lg bg-white/5 flex items-center justify-center hover:bg-brand-primary hover:text-white transition-all">
                    <i class="fa-brands fa-linkedin-in"></i>
                </a>
                <?php endif; ?>
                <?php if ($ig = setting('social_instagram')): ?>
                <a href="<?= e($ig) ?>" target="_blank" class="w-10 h-10 rounded-lg bg-white/5 flex items-center justify-center hover:bg-brand-primary hover:text-white transition-all">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-20">
            <div>
                <h4 class="font-display font-bold uppercase tracking-[0.2em] text-[10px] text-white/40 mb-8">Company</h4>
                <ul class="space-y-4 text-xs font-bold uppercase tracking-widest">
                    <li><a href="<?= url('') ?>" class="hover:text-brand-cyan transition-colors">Home</a></li>
                    <li><a href="#services" class="hover:text-brand-cyan transition-colors">Services</a></li>
                    <li><a href="#solutions" class="hover:text-brand-cyan transition-colors">Portfolio</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-display font-bold uppercase tracking-[0.2em] text-[10px] text-white/40 mb-8">Connect</h4>
                <ul class="space-y-4 text-xs font-bold uppercase tracking-widest">
                    <li><button @click="modalOpen = true" class="hover:text-brand-cyan transition-colors text-left">Consult</button></li>
                    <li><a href="<?= url('login') ?>" class="hover:text-brand-cyan transition-colors">Staff</a></li>
                    <li><a href="#" class="hover:text-brand-cyan transition-colors">Legal</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-8 pt-16 mt-16 border-t border-white/5 flex flex-col md:flex-row justify-between items-center text-[10px] font-bold uppercase tracking-[0.2em] gap-6">
        <p>© <?= date('Y') ?> NuMinds Tech. All Rights Reserved.</p>
        <div class="flex gap-8">
            <span class="text-white/20">Clarity</span>
            <span class="text-white/20">Control</span>
            <span class="text-white/20">Trust</span>
        </div>
    </div>
</footer>

<?php require_once __DIR__ . '/lead-modal.php'; ?>

</body>
</html>

