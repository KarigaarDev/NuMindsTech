</main>

<footer class="bg-brand-tech dark:bg-brand-dark text-heading dark:text-inverse border-t border-white/5 py-24 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-8 flex flex-col md:flex-row justify-between items-start gap-16">
        
        <div class="max-w-sm">
            <a href="<?= url('') ?>" class="flex items-center gap-3 mb-8">
                <div class="w-8 h-8 rounded bg-brand-primary flex items-center justify-center text-white font-bold">N</div>
                <span class="font-display font-bold text-xl text-heading dark:text-inverse tracking-tight">NuMinds <span class="text-brand-accent italic">Tech</span></span>
            </a>
            <p class="text-sm leading-relaxed mb-8 text-body dark:text-muted">
                <?= setting('site_description', 'Building simple, high-performance digital systems for organizations that value clarity and trust.') ?>
            </p>
            <div class="flex gap-4">
                <?php if ($fb = setting('facebook_url')): ?>
                <a href="<?= e($fb) ?>" target="_blank" class="w-10 h-10 rounded-lg bg-brand-primary flex items-center justify-center text-white hover:bg-brand-accent transition-all duration-300 ease-out hover:scale-110 shadow-lg shadow-brand-primary/20">
                    <i class="fa-brands fa-facebook-f"></i>
                </a>
                <?php endif; ?>
                <?php if ($tw = setting('twitter_url')): ?>
                <a href="<?= e($tw) ?>" target="_blank" class="w-10 h-10 rounded-lg bg-brand-primary/10 border border-brand-primary/20 flex items-center justify-center text-brand-primary hover:bg-brand-primary hover:text-white transition-all duration-300 ease-out hover:scale-110">
                    <i class="fa-brands fa-x-twitter"></i>
                </a>
                <?php endif; ?>
                <?php if ($ig = setting('instagram_url')): ?>
                <a href="<?= e($ig) ?>" target="_blank" class="w-10 h-10 rounded-lg bg-brand-primary flex items-center justify-center text-white hover:bg-brand-accent transition-all duration-300 ease-out hover:scale-110 shadow-lg shadow-brand-primary/20">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <?php endif; ?>
                <?php if ($li = setting('linkedin_url')): ?>
                <a href="<?= e($li) ?>" target="_blank" class="w-10 h-10 rounded-lg bg-brand-primary flex items-center justify-center text-white hover:bg-brand-accent transition-all duration-300 ease-out hover:scale-110 shadow-lg shadow-brand-primary/20">
                    <i class="fa-brands fa-linkedin-in"></i>
                </a>
                <?php endif; ?>
                <?php if ($wa = setting('whatsapp_number')): ?>
                <a href="https://wa.me/<?= e(str_replace(['+', ' '], '', $wa)) ?>" target="_blank" class="w-10 h-10 rounded-lg bg-emerald-500 flex items-center justify-center text-white hover:bg-emerald-600 transition-all duration-300 ease-out hover:scale-110 shadow-lg shadow-emerald-500/20">
                    <i class="fa-brands fa-whatsapp"></i>
                </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-20">
            <div>
                <h4 class="font-display font-bold uppercase tracking-[0.2em] text-[10px] text-muted mb-8">Company</h4>
                <ul class="space-y-4 text-xs font-bold uppercase tracking-widest text-heading">
                    <li><a href="<?= url('') ?>" class="hover:text-brand-accent transition-colors">Home</a></li>
                    <li><a href="#services" class="hover:text-brand-accent transition-colors">Services</a></li>
                    <li><a href="#solutions" class="hover:text-brand-accent transition-colors">Portfolio</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-display font-bold uppercase tracking-[0.2em] text-[10px] text-muted mb-8">Connect</h4>
                <ul class="space-y-4 text-xs font-bold uppercase tracking-widest text-heading">
                    <li><button @click="modalOpen = true" class="hover:text-brand-accent transition-colors text-left">CONSULT</button></li>
                    <!-- <li><a href="<?= url('login') ?>" class="hover:text-brand-accent transition-colors">Staff</a></li> -->
                    <li><a href="<?= url('public/terms.php') ?>" class="hover:text-brand-accent transition-colors">Terms & Conditions</a></li>
                    <li><a href="<?= url('public/privacy.php') ?>" class="hover:text-brand-accent transition-colors">Privacy Policy</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-8 pt-8 mt-8 border-t border-brand-primary/10 dark:border-white/5 flex flex-col md:flex-row justify-between items-center text-[12px] font-bold uppercase tracking-[0.2em] gap-6 text-muted">
        <p>© <?= date('Y') ?> NuMinds Tech ❤️. All Rights Reserved.</p>
        <div class="flex gap-8">
            <span class="opacity-50">Clarity</span>
            <span class="opacity-50">Control</span>
            <span class="opacity-50">Trust</span>
        </div>
    </div>
</footer>

<?php require_once __DIR__ . '/lead-modal.php'; ?>
<?php require_once __DIR__ . '/components/promo-modal.php'; ?>

</body>
</html>

