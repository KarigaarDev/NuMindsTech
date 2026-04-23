<?php
// public/index.php

// ensure errors are captured in our project log and optionally shown
require_once __DIR__ . '/../app/core/Env.php';
Env::load();

// PHP error configuration
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/../storage/logs/php-errors.log');
if (Env::get('APP_DEBUG', false)):
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
endif;

require_once '../app/config/db.php';
require_once '../app/core/helpers.php';
Auth::startSession();

date_default_timezone_set('Asia/Kolkata');

// Prepare Site (Handled by helpers.php if $pdo is set)

$homeItems = $pdo->query(
    "SELECT * FROM portfolio_items WHERE status = 'published' ORDER BY display_order ASC, created_at DESC LIMIT 4"
)->fetchAll(PDO::FETCH_ASSOC);

$clients = $pdo->query("SELECT * FROM clients ORDER BY sort_order ASC, id ASC")->fetchAll(PDO::FETCH_ASSOC);

$testimonials = [];
if (setting('show_testimonials', '1') === '1') {
    $testimonials = $pdo->query("SELECT * FROM testimonials WHERE status = 'active' ORDER BY display_order ASC")->fetchAll(PDO::FETCH_ASSOC);
}

$title = setting('site_title', 'Numinds Tech');
$description = setting('site_description', 'Building simple digital systems.');

require '../app/views/header.php';
?>

<!-- HERO SECTION -->
<?php if (setting('show_hero', '1') === '1'): ?>
    <?php require '../app/views/sections/hero.php'; ?>
<?php endif; ?>

<!-- STATS STRIP -->
<?php if (setting('show_stats', '1') === '1'): ?>
<section class="relative z-20 -mt-10 sm:-mt-12 md:-mt-16">
    <div class="max-w-5xl mx-auto px-5 sm:px-6">

        <div class="bg-white dark:bg-brand-navy 
                    border border-slate-100 dark:border-white/10 
                    p-6 sm:p-8 md:p-12 
                    rounded-3xl md:rounded-[2.5rem] 
                    shadow-xl md:shadow-2xl">

            <!-- GRID -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-y-8 sm:gap-y-10 md:gap-6 text-center">

                <!-- Stat -->
                <div>
                    <div class="text-2xl sm:text-3xl md:text-5xl font-display font-extrabold text-heading dark:text-inverse mb-1 sm:mb-2 tracking-tight">
                        60+
                    </div>
                    <div class="text-[9px] sm:text-[10px] uppercase font-bold text-brand-accent tracking-[0.15em] sm:tracking-[0.2em]">
                        Organizations Served
                    </div>
                </div>

                <!-- Stat -->
                <div>
                    <div class="text-2xl sm:text-3xl md:text-5xl font-display font-extrabold text-heading dark:text-inverse mb-1 sm:mb-2 tracking-tight">
                        25+
                    </div>
                    <div class="text-[9px] sm:text-[10px] uppercase font-bold text-brand-primary tracking-[0.15em] sm:tracking-[0.2em]">
                        Ongoing Partnerships
                    </div>
                </div>

                <!-- Stat -->
                <div>
                    <div class="text-2xl sm:text-3xl md:text-5xl font-display font-extrabold text-heading dark:text-inverse mb-1 sm:mb-2 tracking-tight">
                        5+
                    </div>
                    <div class="text-[9px] sm:text-[10px] uppercase font-bold text-slate-400 tracking-[0.15em] sm:tracking-[0.2em]">
                        Years of Excellence
                    </div>
                </div>

                <!-- Stat -->
                <div>
                    <div class="text-2xl sm:text-3xl md:text-5xl font-display font-extrabold text-heading dark:text-inverse mb-1 sm:mb-2 tracking-tight">
                        100%
                    </div>
                    <div class="text-[9px] sm:text-[10px] uppercase font-bold text-slate-400 tracking-[0.15em] sm:tracking-[0.2em]">
                        On-Time Delivery
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>
<?php endif; ?>

<!-- PROBLEM → SOLUTION SECTION -->
<?php if (setting('show_problems', '1') === '1'): ?>
    <?php require '../app/views/sections/problems.php'; ?>
<?php endif; ?>

<!-- EXPERTISE & PROCESS -> Moved to services.php for better UX -->


<!-- CLIENTS / PARTNERS -->
<?php if (!empty($clients)): ?>
<section id="clients" class="py-20 sm:py-24 md:py-32 bg-white dark:bg-brand-dark relative overflow-hidden">

    <!-- GRID BACKGROUND -->
    <div class="absolute inset-0 opacity-[0.03] pointer-events-none"
        style="background-image: linear-gradient(to right, #00000010 1px, transparent 1px), linear-gradient(to bottom, #00000010 1px, transparent 1px); background-size: 40px 40px;">
    </div>

    <div class="max-w-7xl mx-auto px-5 sm:px-6 md:px-8 relative z-10">

        <!-- HEADER -->
        <div class="mb-12 sm:mb-16 md:mb-20">
            <div class="flex flex-col md:flex-row items-center justify-between gap-8 text-center md:text-left">
                <div>
                    <h2 class="text-[11px] font-bold uppercase tracking-[0.4em] text-brand-primary mb-3">
                        Trusted Networks
                    </h2>

                    <h3 class="font-display text-2xl sm:text-3xl md:text-5xl font-black text-heading dark:text-inverse tracking-tight leading-tight">
                        Partnering with 
                        <span class="bg-gradient-to-r from-brand-primary via-brand-accent to-brand-primary bg-[length:200%_auto] animate-gradient bg-clip-text text-transparent italic">
                            ambitious brands
                        </span>
                    </h3>
                </div>

                <!-- Slider Navigation -->
                <div class="flex items-center gap-3">
                    <button class="client-prev w-12 h-12 rounded-full border border-slate-200 dark:border-white/10 flex items-center justify-center text-muted hover:text-brand-primary hover:border-brand-primary transition-all group backdrop-blur-sm">
                        <i class="fa-solid fa-arrow-left transition-transform group-hover:-translate-x-1"></i>
                    </button>
                    <button class="client-next w-12 h-12 rounded-full border border-slate-200 dark:border-white/10 flex items-center justify-center text-muted hover:text-brand-primary hover:border-brand-primary transition-all group backdrop-blur-sm">
                        <i class="fa-solid fa-arrow-right transition-transform group-hover:translate-x-1"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- 🔥 SWIPER CAROUSEL -->
        <div class="relative">
            <div class="swiper clientsSwiper relative py-4">
                
                <!-- GRADIENT FADES -->
                <div class="pointer-events-none absolute left-0 top-0 h-full w-12 md:w-32 bg-gradient-to-r from-white dark:from-brand-dark to-transparent z-10"></div>
                <div class="pointer-events-none absolute right-0 top-0 h-full w-12 md:w-32 bg-gradient-to-l from-white dark:from-brand-dark to-transparent z-10"></div>

                <div class="swiper-wrapper items-center">

                <?php 
                // Merge multiple times to ensure seamless loop for marquee effect
                $loopClients = array_merge($clients, $clients, $clients); 
                foreach($loopClients as $c): 
                ?>

                    <div class="swiper-slide !w-auto">
                        <!-- LOGO ITEM -->
                        <div class="w-[110px] sm:w-[150px] md:w-[200px] px-2 sm:px-3">
                            <div class="h-[70px] sm:h-[100px] md:h-[130px] flex items-center justify-center
                                rounded-2xl sm:rounded-3xl 
                                bg-white/60 dark:bg-brand-navy/60 backdrop-blur-md
                                border border-slate-200/70 dark:border-white/10
                                shadow-sm hover:shadow-2xl hover:shadow-brand-primary/15
                                transition-all duration-500 
                                hover:-translate-y-2 group p-4 sm:p-6">

                                <img 
                                    src="<?= url('public/uploads/clients/' . $c['logo']) ?>" 
                                    alt="<?= e($c['name']) ?>" 
                                    class="max-h-[45px] sm:max-h-[65px] md:max-h-[75px] w-full object-contain 
                                    grayscale-[30%] opacity-90 brightness-[0.9] dark:brightness-100
                                    transition duration-500 
                                    group-hover:grayscale-0 group-hover:opacity-100 group-hover:scale-110 group-hover:brightness-100"
                                >

                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>

                </div>
            </div>
        </div>
    </div>

    <!-- 🔥 SLIDER INITIALIZATION -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            new Swiper('.clientsSwiper', {
                slidesPerView: 'auto',
                spaceBetween: 0,
                loop: true,
                speed: 1000,
                autoplay: {
                    delay: 2000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },
                navigation: {
                    nextEl: '.client-next',
                    prevEl: '.client-prev',
                },
            });
        });
    </script>

</section>
<?php endif; ?>

<!-- PORTFOLIO / SHOWCASE -->
<?php if (setting('show_portfolio', '1') === '1'): ?>
<section id="solutions" class="py-20 md:py-32 bg-brand-tech dark:bg-brand-secondary relative overflow-hidden">

    <!-- GRID BACKGROUND -->
    <div class="absolute inset-0 opacity-[0.04] pointer-events-none"
        style="background-image: linear-gradient(to right, #ffffff10 1px, transparent 1px), linear-gradient(to bottom, #ffffff10 1px, transparent 1px); background-size: 40px 40px;">
    </div>

    <div class="max-w-7xl mx-auto px-6 md:px-8 relative z-10">
        
        <!-- HEADER -->
        <div class="mb-16 md:mb-24">
            <div class="text-center md:text-left">
                <h2 class="text-xs font-bold uppercase tracking-[0.4em] text-brand-primary mb-4">
                    Case Studies
                </h2>

                <h3 class="font-display text-3xl sm:text-4xl md:text-6xl font-black text-heading dark:text-inverse tracking-tight leading-tight">
                    WEBSITES THAT MAKE <br class="hidden md:block"/>
                    <span class="bg-gradient-to-r from-brand-primary via-brand-accent to-brand-primary bg-[length:200%_auto] animate-gradient bg-clip-text text-transparent italic">
                        your brand unique
                    </span>
                </h3>
            </div>
        </div>

        <?php if (empty($homeItems)): ?>

            <!-- EMPTY STATE -->
            <div class="text-center py-20 text-muted uppercase tracking-widest text-[10px] font-bold">
                Works coming soon...
            </div>

        <?php else: ?>

        <!-- PREMIUM SLIDER -->
        <div class="swiper portfolioSwiper mb-16 px-4 md:px-0">
            <div class="swiper-wrapper">

                <?php foreach($homeItems as $item): 
                    $slug = str_replace([' ', '/', '\\'], '-', strtolower($item['title']));
                ?>

                <div class="swiper-slide h-auto">
                    <a href="<?= url('portfolio/' . $slug) ?>" class="group block h-full">

                        <div class="rounded-2xl md:rounded-[2.5rem] overflow-hidden 
                                    bg-white/70 dark:bg-brand-navy/60 backdrop-blur-md
                                    border border-slate-200 dark:border-white/10
                                    shadow-md hover:shadow-2xl hover:shadow-brand-primary/20
                                    transition-all duration-500 hover:-translate-y-2 h-full flex flex-col">

                            <!-- IMAGE BLOCK -->
                            <div class="p-3 md:p-4">
                                <div class="rounded-2xl overflow-hidden bg-black/5 dark:bg-black/20 aspect-[16/10] relative">
                                    <img 
                                        src="<?= url('public/uploads/') . $item['featured_image'] ?>" 
                                        alt="<?= e($item['title']) ?>" 
                                        class="w-full h-full object-cover 
                                        transition duration-700 group-hover:scale-105"
                                    >
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                </div>
                            </div>

                            <!-- CONTENT -->
                            <div class="px-5 pb-6 md:px-8 md:pb-8 mt-auto">

                                <p class="text-[9px] md:text-[10px] font-bold uppercase tracking-[0.3em] text-brand-accent mb-2">
                                    <?= e($item['category']) ?>
                                </p>

                                <h5 class="font-display font-bold text-heading dark:text-inverse text-base md:text-xl leading-tight">
                                    <?= e($item['title']) ?>
                                </h5>

                            </div>

                        </div>

                    </a>
                </div>

                <?php endforeach; ?>

            </div>
        </div>

        <!-- SLIDER NAVIGATION (Mobile: Below, Desktop: Absolute top) -->
        <div class="flex items-center justify-center md:justify-start gap-3 mt-10 mb-12 md:my-0 md:absolute md:top-0 md:right-8 md:translate-y-4">
            <button class="portfolio-prev w-12 h-12 rounded-full border border-white/20 dark:border-white/10 flex items-center justify-center text-white/50 hover:text-brand-primary hover:border-brand-primary transition-all group backdrop-blur-md">
                <i class="fa-solid fa-arrow-left transition-transform group-hover:-translate-x-1"></i>
            </button>
            <button class="portfolio-next w-12 h-12 rounded-full border border-white/20 dark:border-white/10 flex items-center justify-center text-white/50 hover:text-brand-primary hover:border-brand-primary transition-all group backdrop-blur-md">
                <i class="fa-solid fa-arrow-right transition-transform group-hover:translate-x-1"></i>
            </button>
        </div>

        <!-- CTA -->
        <?php if (count($homeItems) >= 4): ?>
        <div class="text-center">
            <a href="<?= url('works.php') ?>" 
               class="inline-block w-full sm:w-auto px-10 py-5 rounded-xl 
               font-display font-bold text-sm uppercase tracking-widest text-white 
               bg-gradient-to-r from-brand-primary to-brand-accent 
               shadow-lg hover:shadow-2xl hover:shadow-brand-primary/40 
               transition duration-300 hover:scale-105">

                VIEW MORE WORKS 
                <i class="fa-solid fa-arrow-right ml-2"></i>
            </a>
        </div>
        <?php endif; ?>

        <?php endif; ?>

    </div>

    <!-- 🔥 SLIDER INITIALIZATION -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            new Swiper('.portfolioSwiper', {
                slidesPerView: 1.1,
                spaceBetween: 16,
                loop: true,
                speed: 800,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },
                navigation: {
                    nextEl: '.portfolio-next',
                    prevEl: '.portfolio-prev',
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2.1,
                        spaceBetween: 24,
                    },
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 32,
                    },
                    1280: {
                        slidesPerView: 4,
                        spaceBetween: 40,
                    }
                }
            });
        });
    </script>
</section>
<?php endif; ?>

<!-- DESIGN & DEV DIARIES (Hidden until real articles are ready) -->
<?php if (false && setting('show_blogs', '1') === '1'): ?>
<section class="py-32 bg-white dark:bg-brand-dark relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-8 relative z-10">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-20 gap-8">
            <div>
                <h2 class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-primary mb-4">Focused Blogs</h2>
                <h3 class="font-display text-4xl md:text-5xl font-extrabold text-heading dark:text-inverse tracking-tight">
                    DESIGN & <span class="text-brand-accent italic">DEV DIARIES</span> ❤️
                </h3>
            </div>
            <button @click="modalOpen = true" class="bg-white dark:bg-brand-secondary border border-slate-100 dark:border-white/10 px-8 py-4 rounded-xl font-bold text-[10px] uppercase tracking-widest text-muted hover:text-brand-primary transition-all">
                Explore All Articles
            </button>
        </div>

        <div class="grid md:grid-cols-4 gap-6">
            <?php 
            $blogs = [
                ['title' => 'Designing for clean and minimal UX', 'img' => 'assets/blog-coding.png'],
                ['title' => 'Why clean code matters for scaling', 'img' => 'assets/hero-bg.png'],
                ['title' => 'A check on how fast our systems run', 'img' => 'uploads/school-dashboard.png'],
                ['title' => 'Design tips for modern tech brands', 'img' => 'uploads/ngo-website.png'],
            ];
            foreach($blogs as $b): ?>
            <div class="group space-y-4">
                <div class="aspect-[16/10] rounded-2xl overflow-hidden bg-white dark:bg-brand-secondary border border-slate-100 dark:border-white/5">
                    <img src="<?= url($b['img']) ?>" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700 group-hover:scale-105">
                </div>
                <h4 class="font-display font-bold text-sm text-heading dark:text-inverse group-hover:text-brand-primary transition-colors pr-4"><?= $b['title'] ?></h4>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- TESTIMONIALS SECTION -->
<?php if (setting('show_testimonials', '1') === '1'): ?>
    <?php require '../app/views/sections/testimonials2.php'; ?>
<?php endif; ?>

<!-- FAQ & ESTIMATOR -> Moved to dedicated pages -->

<!-- CALL TO ACTION FINAL -->

<?php if (setting('show_cta', '1') === '1'): ?>
<section class="py-32 bg-[color-mix(in_srgb,var(--brand-primary)_80%,white)] dark:bg-brand-dark relative overflow-hidden bg-scroll bg-no-repeat bg-right-bottom bg-[length:15rem] md:bg-[length:22rem] lg:bg-[length:30rem]" style="background-image: url('<?= url('assets/phone.png') ?>');">
    <div class="max-w-7xl mx-auto px-8 relative z-10 text-center">
        <h2 class="text-xs font-bold uppercase tracking-[0.4em] text-brand-primary mb-3">
                    YOUR WEBSITE IS Your Brand Identity.
                </h2>
         <h3 class="font-display text-4xl md:text-5xl font-extrabold text-heading dark:text-inverse tracking-tight mb-12">
            scale your <span class="bg-gradient-to-r from-brand-primary via-brand-accent to-brand-primary bg-[length:200%_auto] animate-gradient bg-clip-text text-transparent italic">digital presence.</span>
        </h3>
        
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <button @click="modalOpen = true" class="w-full sm:w-auto bg-button-primary text-button-primaryText hover:bg-button-primaryHover px-10 py-5 rounded-xl font-display font-bold text-sm uppercase tracking-widest shadow-xl transition-all duration-300 ease-out hover:scale-105 active:scale-100 text-center">
                <i class="fa-solid fa-chart-line mr-3"></i> GET SYSTEM AUDIT
            </button>
            <a href="<?= url('estimator.php') ?>" class="w-full sm:w-auto bg-white dark:bg-brand-navy text-brand-primary dark:text-white border border-brand-primary/20 dark:border-white/10 hover:bg-slate-50 dark:hover:bg-brand-secondary px-10 py-5 rounded-xl font-display font-bold text-sm uppercase tracking-widest shadow-lg transition-all duration-300 transform hover:scale-105">
                <i class="fa-solid fa-calculator mr-3"></i> ESTIMATE PROJECT
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<?php require '../app/views/footer.php'; ?>