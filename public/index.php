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

session_start();
date_default_timezone_set('Asia/Kolkata');
require_once '../app/config/db.php';
require_once '../app/core/helpers.php';

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
<section class="relative z-20 -mt-16">
    <div class="max-w-5xl mx-auto px-8">
        <div class="bg-white dark:bg-brand-navy border border-slate-100 dark:border-white/10 p-10 md:p-12 rounded-[2.5rem] shadow-2xl flex flex-wrap justify-around gap-12 text-center">
            
            <div class="flex-1 min-w-[120px]">
                <div class="text-4xl md:text-5xl font-display font-extrabold text-heading dark:text-inverse mb-2 tracking-tight">60+</div>
                <div class="text-[10px] uppercase font-bold text-brand-accent tracking-[0.2em]">
                    Businesses Helped
                </div>
            </div>

            <div class="w-px h-16 bg-slate-100 dark:bg-white/5 hidden md:block"></div>

            <div class="flex-1 min-w-[120px]">
                <div class="text-4xl md:text-5xl font-display font-extrabold text-heading dark:text-inverse mb-2 tracking-tight">25+</div>
                <div class="text-[10px] uppercase font-bold text-brand-primary tracking-[0.2em]">
                    Ongoing Partnerships
                </div>
            </div>

            <div class="w-px h-16 bg-slate-100 dark:bg-white/5 hidden md:block"></div>

            <div class="flex-1 min-w-[120px]">
                <div class="text-4xl md:text-5xl font-display font-extrabold text-heading dark:text-inverse mb-2 tracking-tight">5+</div>
                <div class="text-[10px] uppercase font-bold text-slate-400 tracking-[0.2em]">
                    Years Building Systems
                </div>
            </div>

            <div class="w-px h-16 bg-slate-100 dark:bg-white/5 hidden md:block"></div>

            <div class="flex-1 min-w-[120px]">
                <div class="text-4xl md:text-5xl font-display font-extrabold text-heading dark:text-inverse mb-2 tracking-tight">100%</div>
                <div class="text-[10px] uppercase font-bold text-slate-400 tracking-[0.2em]">
                    Projects Delivered On Time
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

<!-- THINGS WE ARE GOOD AT -->
<?php if (setting('show_services', '1') === '1'): ?>
<section id="services" class="py-20 md:py-28 bg-white dark:bg-brand-dark relative overflow-hidden">

    <!-- 🔲 Subtle Grid Background -->
    <div class="absolute inset-0 opacity-[0.03] pointer-events-none"
         style="background-image: linear-gradient(to right, #00000010 1px, transparent 1px), linear-gradient(to bottom, #00000010 1px, transparent 1px); background-size: 40px 40px;">
    </div>

    <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 relative z-10">

        <!-- Heading -->
        <div class="text-center mb-16 md:mb-20">
            <h2 class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-primary mb-4">
                Our Expertise
            </h2>

            <h3 class="font-display text-3xl sm:text-4xl md:text-5xl font-extrabold text-heading dark:text-inverse tracking-tight uppercase leading-tight">
                Expertise 
                <span class="bg-gradient-to-r from-brand-primary via-brand-accent to-brand-primary bg-[length:200%_auto] animate-gradient bg-clip-text text-transparent italic">
                    Beyond Excellence
                </span> 🎯
            </h3>

            <p class="text-sm sm:text-base text-muted mt-4 italic">
                Over 4+ Years of Innovative Solutions
            </p>
        </div>

        <!-- 🔥 Responsive Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">

            <?php 
            $services = [
                ['icon' => 'fa-laptop-code', 'title' => 'Business Websites', 'desc' => 'High-performance digital profiles for schools and organizations.', 'color' => 'brand-primary'],
                ['icon' => 'fa-cart-shopping', 'title' => 'E-commerce', 'desc' => 'Scalable online stores with seamless payment systems.', 'color' => 'brand-accent'],
                ['icon' => 'fa-gears', 'title' => 'Custom Web Apps', 'desc' => 'Tailored internal dashboards built for your workflow.', 'color' => 'brand-primary'],
                ['icon' => 'fa-rocket', 'title' => 'SEO & Speed', 'desc' => 'Ensuring your brand stands out in digital noise.', 'color' => 'brand-accent'],
            ];

            foreach($services as $s): ?>

            <div class="group relative p-5 sm:p-7 
                        bg-white/70 dark:bg-brand-navy/60 backdrop-blur-md
                        border border-slate-200 dark:border-white/10
                        rounded-2xl sm:rounded-3xl
                        shadow-md hover:shadow-2xl hover:shadow-<?= $s['color'] ?>/20
                        transition-all duration-500 hover:-translate-y-2">

                <!-- Icon -->
                <div class="w-12 h-12 sm:w-14 sm:h-14 
                            bg-white dark:bg-brand-secondary 
                            rounded-xl sm:rounded-2xl 
                            flex items-center justify-center 
                            text-<?= $s['color'] ?> 
                            mb-5 sm:mb-6 
                            shadow-sm group-hover:shadow-<?= $s['color'] ?>/20 
                            transition-all duration-300">

                    <i class="fa-solid <?= $s['icon'] ?> text-lg sm:text-2xl"></i>
                </div>

                <!-- Title -->
                <h3 class="font-display text-sm sm:text-lg font-bold mb-2 sm:mb-3 
                           text-heading dark:text-white 
                           group-hover:text-<?= $s['color'] ?> transition-colors">
                    <?= $s['title'] ?>
                </h3>

                <!-- Description -->
                <p class="text-[11px] sm:text-xs text-body dark:text-muted leading-relaxed font-medium mb-4 sm:mb-6">
                    <?= $s['desc'] ?>
                </p>

                <!-- CTA -->
                <button @click="modalOpen = true" 
                        class="inline-flex items-center gap-2 
                               text-[10px] font-bold uppercase tracking-widest 
                               text-<?= $s['color'] ?> 
                               bg-<?= $s['color'] ?>/10 
                               px-3 py-2 rounded-lg
                               hover:bg-<?= $s['color'] ?> hover:text-white
                               transition-all duration-300">

                    Connect 
                    <i class="fa-solid fa-arrow-right text-[10px] transition-transform group-hover:translate-x-1"></i>
                </button>

            </div>

            <?php endforeach; ?>

        </div>

    </div>
</section>
<?php endif; ?>

<!-- PROCESS TIMELINE SECTION -->
<?php if (setting('show_process', '1') === '1'): ?>
    <?php require '../app/views/sections/process.php'; ?>
<?php endif; ?>

<!-- CLIENTS / PARTNERS -->
<!-- CLIENTS / PARTNERS -->
<?php if (!empty($clients)): ?>
<section id="clients" class="py-24 md:py-32 bg-white dark:bg-brand-dark relative overflow-hidden">

    <!-- GRID BACKGROUND -->
    <div class="absolute inset-0 opacity-[0.04] pointer-events-none"
        style="background-image: linear-gradient(to right, #00000010 1px, transparent 1px), linear-gradient(to bottom, #00000010 1px, transparent 1px); background-size: 40px 40px;">
    </div>

    <div class="max-w-7xl mx-auto px-6 md:px-8 relative z-10">

        <!-- HEADER -->
        <div class="text-center mb-20 md:mb-24">
            <h2 class="text-xs font-bold uppercase tracking-[0.4em] text-brand-primary mb-4">
                Trusted Networks
            </h2>

            <h3 class="font-display text-3xl sm:text-4xl md:text-5xl font-black text-heading dark:text-inverse tracking-tight leading-tight">
                Partnering with 
                <span class="bg-gradient-to-r from-brand-primary via-brand-accent to-brand-primary bg-[length:200%_auto] animate-gradient bg-clip-text text-transparent italic">
                    ambitious brands
                </span>
            </h3>
        </div>

        <?php 
        // Duplicate for seamless loop
        $loopClients = array_merge($clients, $clients); 
        ?>

        <!-- 🔥 MARQUEE WRAPPER -->
        <div class="relative overflow-hidden">

            <!-- GRADIENT FADE (LEFT RIGHT) -->
            <div class="pointer-events-none absolute left-0 top-0 h-full w-20 bg-gradient-to-r from-white dark:from-brand-dark to-transparent z-10"></div>
            <div class="pointer-events-none absolute right-0 top-0 h-full w-20 bg-gradient-to-l from-white dark:from-brand-dark to-transparent z-10"></div>

            <!-- SCROLL TRACK -->
            <div class="flex gap-6 md:gap-10 animate-marquee w-max">

                <?php foreach($loopClients as $c): ?>
                    
                    <?php if (!empty($c['link'])): ?>
                        <a href="<?= e($c['link']) ?>" target="_blank" class="group">
                    <?php endif; ?>

                    <div class="flex-shrink-0 w-[120px] sm:w-[140px] md:w-[160px]">

                        <div class="h-[100px] md:h-[120px] flex items-center justify-center
                            rounded-2xl md:rounded-3xl 
                            bg-white/70 dark:bg-brand-navy/60 backdrop-blur-md
                            border border-slate-200 dark:border-white/10
                            shadow-sm hover:shadow-xl hover:shadow-brand-primary/10
                            transition-all duration-500 
                            hover:-translate-y-2 group">

                            <img 
                                src="<?= url('public/uploads/clients/' . $c['logo']) ?>" 
                                alt="<?= e($c['name']) ?>" 
                                class="max-h-[40px] md:max-h-[50px] object-contain 
                                grayscale opacity-70 
                                transition duration-500 
                                group-hover:grayscale-0 group-hover:opacity-100 group-hover:scale-110"
                            >

                        </div>

                    </div>

                    <?php if (!empty($c['link'])): ?>
                        </a>
                    <?php endif; ?>

                <?php endforeach; ?>

            </div>

        </div>

    </div>

    <!-- 🔥 MARQUEE ANIMATION -->
    <style>
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        .animate-marquee {
            animation: marquee 25s linear infinite;
        }

        /* Pause on hover (premium feel) */
        .animate-marquee:hover {
            animation-play-state: paused;
        }
    </style>

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
        <div class="text-center mb-20 md:mb-28">
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

        <?php if (empty($homeItems)): ?>

            <!-- EMPTY STATE -->
            <div class="text-center py-20 text-muted uppercase tracking-widest text-[10px] font-bold">
                Works coming soon...
            </div>

        <?php else: ?>

        <!-- PREMIUM GRID -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-10 mb-16">

            <?php foreach($homeItems as $item): 
                $slug = str_replace([' ', '/', '\\'], '-', strtolower($item['title']));
            ?>

            <a href="<?= url('portfolio/' . $slug) ?>" class="group block">

                <div class="rounded-2xl md:rounded-3xl overflow-hidden 
                            bg-white/70 dark:bg-brand-navy/60 backdrop-blur-md
                            border border-slate-200 dark:border-white/10
                            shadow-md hover:shadow-2xl hover:shadow-brand-primary/20
                            transition-all duration-500 hover:-translate-y-2">

                    <!-- IMAGE BLOCK -->
                    <div class="p-3 md:p-4">
                        <div class="rounded-xl overflow-hidden bg-black/5 dark:bg-black/20">

                            <img 
                                src="<?= url('public/uploads/') . $item['featured_image'] ?>" 
                                alt="<?= e($item['title']) ?>" 
                                class="w-full h-auto object-contain 
                                transition duration-700 group-hover:scale-105"
                            >

                        </div>
                    </div>

                    <!-- CONTENT -->
                    <div class="px-4 pb-5 md:px-5 md:pb-6">

                        <p class="text-[9px] md:text-[10px] font-bold uppercase tracking-[0.25em] text-brand-accent mb-2">
                            <?= e($item['category']) ?>
                        </p>

                        <h5 class="font-display font-bold text-heading dark:text-inverse text-sm md:text-base leading-tight">
                            <?= e($item['title']) ?>
                        </h5>

                    </div>

                </div>

            </a>

            <?php endforeach; ?>

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
</section>
<?php endif; ?>

<!-- DESIGN & DEV DIARIES -->
<?php if (setting('show_blogs', '1') === '1'): ?>
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

<!-- FAQ SECTION -->
<?php require '../app/views/sections/faq.php'; ?>

<!-- CALL TO ACTION FINAL -->
<?php if (setting('show_cta', '1') === '1'): ?>
<section class="py-32 bg-[color-mix(in_srgb,var(--brand-primary)_80%,white)] dark:bg-brand-dark relative overflow-hidden bg-scroll bg-no-repeat bg-right-bottom bg-[length:15rem] md:bg-[length:22rem] lg:bg-[length:30rem]" style="background-image: url('<?= url('assets/phone.png') ?>');">
    <div class="max-w-7xl mx-auto px-8 relative z-10 text-center">
        <h4 class="text-[10px] font-bold uppercase tracking-[0.4em] text-white/60 mb-8">YOUR WEBSITE IS THE FIRST THING THEY NOTICE.</h4>
         <h3 class="font-display text-4xl md:text-5xl font-extrabold text-heading dark:text-inverse tracking-tight mb-12">
            make it <span class="bg-gradient-to-r from-brand-primary via-brand-accent to-brand-primary bg-[length:200%_auto] animate-gradient bg-clip-text text-transparent italic">unforgettable!</span>
        </h3>
        
        <button @click="modalOpen = true" class="w-full sm:w-auto bg-button-primary text-button-primaryText hover:bg-button-primaryHover px-10 py-5 rounded-xl font-display font-bold text-sm uppercase tracking-widest shadow-xl transition-all duration-300 ease-out hover:scale-105 active:scale-100 text-center">
            <i class="fa-solid fa-comment-dots mr-4"></i> GET STARTED
        </button>
    </div>
</section>
<?php endif; ?>

<?php require '../app/views/footer.php'; ?>