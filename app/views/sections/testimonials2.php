<!-- TESTIMONIALS (Premium Slider) -->
<section id="testimonials" class="py-20 md:py-32 bg-white dark:bg-brand-dark relative overflow-hidden">

    <div class="max-w-7xl mx-auto px-5 md:px-8 relative z-10">

        <!-- HEADER -->
        <div class="mb-14 md:mb-16">
            <div class="flex flex-col md:flex-row items-center justify-between gap-8 md:gap-14 text-center md:text-left">
                
                <div class="flex-1">
                    <h2 class="text-xs font-bold uppercase tracking-[0.4em] text-brand-primary mb-3">
                        Real Feedback
                    </h2>

                    <h3 class="font-display text-3xl md:text-4xl font-black text-heading dark:text-inverse tracking-tight leading-tight">
                        What people 
                        <span class="text-brand-accent italic">say about us</span>
                    </h3>
                </div>

                <!-- Right Side: Stats + Navigation -->
                <div class="flex flex-col items-center md:items-end gap-6">
                    <!-- Stats -->
                    <div class="flex flex-col items-center md:items-end">
                        <div class="flex gap-1 text-amber-400 mb-1 text-sm">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-muted whitespace-nowrap">
                            4.9/5 from happy clients
                        </p>
                    </div>

                    <!-- Navigation -->
                    <div class="flex items-center gap-2">
                        <button class="review-prev w-10 h-10 rounded-full border border-slate-200 dark:border-white/10 flex items-center justify-center text-muted hover:text-brand-primary hover:border-brand-primary transition-all group backdrop-blur-sm">
                            <i class="fa-solid fa-arrow-left text-xs transition-transform group-hover:-translate-x-1"></i>
                        </button>
                        <button class="review-next w-10 h-10 rounded-full border border-slate-200 dark:border-white/10 flex items-center justify-center text-muted hover:text-brand-primary hover:border-brand-primary transition-all group backdrop-blur-sm">
                            <i class="fa-solid fa-arrow-right text-xs transition-transform group-hover:translate-x-1"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- 🔥 SWIPER SLIDER -->
        <?php if (empty($testimonials)): ?>
            <div class="text-center py-20 text-muted text-xs font-bold uppercase tracking-widest bg-slate-50 dark:bg-white/5 rounded-3xl">
                New reviews coming soon...
            </div>
        <?php else: ?>
            <div class="relative">
                <div class="swiper reviewsSwiper overflow-visible">
                    <div class="swiper-wrapper">

                        <?php foreach($testimonials as $t): ?>
                        <div class="swiper-slide h-auto">
                            <div class="bg-white dark:bg-brand-navy/60 backdrop-blur-md 
                                        p-6 md:p-8 rounded-[2rem] border border-slate-100 dark:border-white/5
                                        shadow-sm hover:shadow-xl hover:-translate-y-2 
                                        transition-all duration-500 group h-full flex flex-col justify-between">

                                <div>
                                    <!-- TOP -->
                                    <div class="flex items-start justify-between mb-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-white dark:border-brand-primary/20 shadow-md">
                                                <?php if ($t['avatar']): ?>
                                                    <img src="<?= url('public/uploads/' . $t['avatar']) ?>" class="w-full h-full object-cover">
                                                <?php else: ?>
                                                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($t['client_name']) ?>&background=2563eb&color=fff" class="w-full h-full object-cover">
                                                <?php endif; ?>
                                            </div>
                                            <div>
                                                <h4 class="text-sm font-bold text-heading dark:text-white tracking-tight">
                                                    <?= e($t['client_name']) ?>
                                                </h4>
                                                <p class="text-[9px] text-brand-primary uppercase font-bold tracking-widest">
                                                    <?= e($t['client_position'] ?? 'Client') ?>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="text-brand-primary/10 dark:text-white/5 group-hover:text-brand-accent/20 transition-colors">
                                            <i class="fa-solid fa-quote-right text-4xl"></i>
                                        </div>
                                    </div>

                                    <!-- REVIEW -->
                                    <p class="text-[13px] text-body dark:text-slate-300 leading-relaxed italic mb-6">
                                        "<?= e($t['content']) ?>"
                                    </p>
                                </div>

                                <!-- BOTTOM -->
                                <div class="flex items-center justify-between mt-auto">
                                    <div class="flex items-center gap-2">
                                        <div class="w-5 h-5 bg-green-500 text-white rounded-full flex items-center justify-center text-[10px] shadow-lg shadow-green-500/20">
                                            <i class="fa-solid fa-check"></i>
                                        </div>
                                        <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">
                                            Verified System
                                        </span>
                                    </div>
                                    <div class="flex text-amber-400 text-[11px] gap-0.5">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <!-- 🔥 SLIDER INITIALIZATION -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            new Swiper('.reviewsSwiper', {
                slidesPerView: 1,
                spaceBetween: 20,
                loop: true,
                speed: 1000,
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },
                navigation: {
                    nextEl: '.review-next',
                    prevEl: '.review-prev',
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 24,
                    },
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 30,
                    },
                },
            });
        });
    </script>

</section>