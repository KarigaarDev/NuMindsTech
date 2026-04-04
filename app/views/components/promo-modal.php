<?php
$promoActive = setting('promo_active', '0') === '1';
if (!$promoActive) return;

$promoTitle = setting('promo_title', 'Exclusive Offer');
$promoText = setting('promo_text', 'Sign up today and accelerate your business growth.');
$promoImage = setting('promo_image', '');

// Optional image logic
$imgSrc = $promoImage ? url('public/uploads/' . $promoImage) : url('public/images/hero-bg.jpg'); // Adjust default
?>

<!-- Promo Lead Magnet Modal (Alpine.js State) -->
<div x-data="{ 
        promoOpen: false, 
        init() {
            // Check if user has closed it in the last 24 hours
            const closedAt = localStorage.getItem('promoClosedAt');
            const now = new Date().getTime();
            
            // Only show if it hasn't been closed in the last 24h
            if (!closedAt || now - closedAt > 86400000) {
                setTimeout(() => {
                    this.promoOpen = true;
                }, 3000); // 3 second delay
            }
        },
        closePromo() {
            this.promoOpen = false;
            localStorage.setItem('promoClosedAt', new Date().getTime());
        }
    }" 
    @keydown.escape.window="closePromo" 
    class="relative z-[100]"
>
    <!-- Backdrop overlay -->
    <div x-show="promoOpen" 
         x-transition:enter="transition ease-out duration-500" 
         x-transition:enter-start="opacity-0 backdrop-blur-none" 
         x-transition:enter-end="opacity-100 backdrop-blur-md" 
         x-transition:leave="transition ease-in duration-300" 
         x-transition:leave-start="opacity-100 backdrop-blur-md" 
         x-transition:leave-end="opacity-0 backdrop-blur-none" 
         class="fixed inset-0 bg-brand-secondary/80 dark:bg-brand-dark/90 cursor-pointer"
         @click="closePromo"
         style="display: none;"></div>

    <!-- Modal Panel -->
    <div x-show="promoOpen" 
         x-transition:enter="transition ease-out duration-500 delay-100" 
         x-transition:enter-start="opacity-0 translate-y-12 scale-95" 
         x-transition:enter-end="opacity-100 translate-y-0 scale-100" 
         x-transition:leave="transition ease-in duration-300" 
         x-transition:leave-start="opacity-100 translate-y-0 scale-100" 
         x-transition:leave-end="opacity-0 translate-y-12 scale-95" 
         class="fixed inset-0 overflow-y-auto pointer-events-none"
         style="display: none;">
         
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative w-full max-w-4xl bg-white dark:bg-brand-navy rounded-[2rem] shadow-[0_30px_60px_-15px_rgba(0,0,0,0.5)] overflow-hidden pointer-events-auto border border-white/20 dark:border-white/10 flex flex-col md:flex-row">
                
                <!-- Close Button -->
                <button @click="closePromo" class="absolute top-4 right-4 z-20 w-10 h-10 bg-black/10 dark:bg-white/10 hover:bg-black/20 dark:hover:bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-slate-800 dark:text-white transition-all">
                    <i class="fa-solid fa-xmark"></i>
                </button>

                <!-- Left Split: Image/Graphic -->
                <div class="w-full md:w-1/2 relative min-h-[250px] md:min-h-full overflow-hidden bg-brand-secondary">
                    <?php if ($promoImage): ?>
                        <img src="<?= e($imgSrc) ?>" class="absolute inset-0 w-full h-full object-cover opacity-80 mix-blend-overlay">
                    <?php else: ?>
                        <!-- Gradient Fallback -->
                        <div class="absolute inset-0 bg-gradient-to-br from-brand-primary to-brand-accent opacity-90"></div>
                        <div class="absolute inset-0 bg-[url('<?= url('public/images/grid.svg') ?>')] opacity-20 mix-blend-overlay"></div>
                    <?php endif; ?>
                    
                    <div class="absolute inset-0 p-10 flex flex-col justify-end bg-gradient-to-t from-brand-secondary via-transparent to-transparent">
                        <div class="text-white">
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md border border-white/30 text-[10px] font-bold tracking-widest uppercase mb-4">
                                <i class="fa-solid fa-gift text-brand-accent"></i> Special Offer
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Right Split: Content & Form -->
                <div class="w-full md:w-1/2 p-10 md:p-14 flex flex-col justify-center">
                    <h2 class="font-display font-extrabold text-3xl md:text-4xl text-heading dark:text-inverse mb-4 leading-tight">
                        <?= e($promoTitle) ?>
                    </h2>
                    <p class="text-slate-500 dark:text-slate-400 font-medium mb-8">
                        <?= e($promoText) ?>
                    </p>

                    <form action="<?= url('submit-lead.php') ?>" method="POST" class="space-y-4">
                        <?= csrf_field() ?>
                        <input type="hidden" name="service_type" value="[PROMO LEAD]">
                        <input type="hidden" name="redirect_url" value="<?= e($_SERVER['REQUEST_URI']) ?>">

                        <div class="space-y-4">
                            <div>
                                <input type="text" name="name" required placeholder="Your full name" class="w-full bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl px-5 py-4 focus:outline-none focus:border-brand-primary focus:ring-1 focus:ring-brand-primary transition-all dark:text-white placeholder:text-slate-400">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <input type="email" name="email" required placeholder="Business email" class="w-full bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl px-5 py-4 focus:outline-none focus:border-brand-primary focus:ring-1 focus:ring-brand-primary transition-all dark:text-white placeholder:text-slate-400">
                                </div>
                                <div>
                                    <input type="tel" name="phone" required placeholder="Phone number" class="w-full bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl px-5 py-4 focus:outline-none focus:border-brand-primary focus:ring-1 focus:ring-brand-primary transition-all dark:text-white placeholder:text-slate-400">
                                </div>
                            </div>
                            <div>
                                <textarea name="message" required placeholder="One-liner about your project needs..." rows="2" class="w-full bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl px-5 py-4 focus:outline-none focus:border-brand-primary focus:ring-1 focus:ring-brand-primary transition-all dark:text-white placeholder:text-slate-400 resize-none"></textarea>
                            </div>
                        </div>

                        <button type="submit" class="w-full btn-primary px-8 py-5 rounded-xl font-display font-bold text-sm uppercase tracking-widest shadow-xl flex justify-center items-center gap-3 mt-4 hover:scale-[1.02] transition-all">
                            Claim Offer <i class="fa-solid fa-arrow-right"></i>
                        </button>
                        
                        <p class="text-center text-[10px] font-medium text-slate-400 mt-4">
                            By claiming, you agree to our <a href="<?= url('public/privacy.php') ?>" class="underline hover:text-brand-primary">Privacy Policy</a>
                        </p>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
