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
<section id="services" class="py-32 bg-white dark:bg-brand-dark overflow-hidden">
    <div class="max-w-7xl mx-auto px-8">
        <div class="text-center mb-20">
            <h2 class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-primary mb-4">Our Expertise</h2>
            <h3 class="font-display text-4xl md:text-5xl font-extrabold text-heading dark:text-inverse tracking-tight uppercase">
                Expertise <span class="text-brand-accent">Beyond Excellence</span> 🎯<br/>
                <span class="text-lg font-medium text-muted mt-4 block lowercase italic">Over 4+ Years of Innovative Solutions</span>
            </h3>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Service cards -->
            <?php 
            $services = [
                ['icon' => 'fa-laptop-code', 'title' => 'Business Websites', 'desc' => 'High-performance digital profiles for schools and organizations.', 'color' => 'brand-primary'],
                ['icon' => 'fa-cart-shopping', 'title' => 'E-commerce', 'desc' => 'Scalable online stores with seamless payment systems.', 'color' => 'brand-accent'],
                ['icon' => 'fa-gears', 'title' => 'Custom Web Apps', 'desc' => 'Tailored internal dashboards built for your workflow.', 'color' => 'brand-primary'],
                ['icon' => 'fa-rocket', 'title' => 'SEO & Speed', 'desc' => 'Ensuring your brand stands out in digital noise.', 'color' => 'brand-accent'],
            ];
            foreach($services as $s): ?>
            <div class="group p-8 bg-white dark:bg-brand-navy border border-slate-100 dark:border-white/5 rounded-3xl hover:border-<?= $s['color'] ?>/40 transition-all duration-500 hover:-translate-y-2">
                <div class="w-14 h-14 bg-white dark:bg-brand-secondary rounded-2xl flex items-center justify-center text-<?= $s['color'] ?> mb-8 shadow-sm group-hover:shadow-<?= $s['color'] ?>/20 transition-all">
                    <i class="fa-solid <?= $s['icon'] ?> text-2xl"></i>
                </div>
                <h3 class="font-display text-lg font-bold mb-4 dark:text-white group-hover:text-<?= $s['color'] ?> transition-colors"><?= $s['title'] ?></h3>
                <p class="text-xs text-body dark:text-muted leading-relaxed font-medium mb-8"><?= $s['desc'] ?></p>
                <button @click="modalOpen = true" class="text-[10px] font-bold uppercase tracking-widest text-<?= $s['color'] ?> flex items-center gap-2 group/link">
                    Connect now <i class="fa-solid fa-arrow-right group-hover/link:translate-x-1 transition-transform"></i>
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
<?php if (!empty($clients)): ?>
<section id="clients" class="py-20 bg-white dark:bg-brand-dark">
    <div class="max-w-7xl mx-auto px-8 relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-[10px] font-bold uppercase tracking-[0.4em] text-brand-primary mb-4">Trusted Networks</h2>
            <h3 class="font-display text-3xl md:text-4xl font-extrabold text-heading dark:text-inverse tracking-tight">
                Partnering with <span class="text-brand-accent">Ambitious Organizations</span>
            </h3>
        </div>

        <div class="swiper clientSwiper py-12">
            <div class="swiper-wrapper items-center">
                <?php foreach($clients as $c): ?>
                    <div class="swiper-slide px-4">
                        <?php if (!empty($c['link'])): ?><a href="<?= e($c['link']) ?>" target="_blank" class="block"><?php endif; ?>
                        <div class="aspect-square w-full max-w-[120px] mx-auto bg-white dark:bg-brand-navy rounded-2xl border border-slate-100 dark:border-white/5 flex items-center justify-center p-6 grayscale hover:grayscale-0 transition-all duration-500 hover:shadow-xl hover:shadow-brand-primary/5 hover:-translate-y-2 group shadow-sm">
                            <img src="<?= url('public/uploads/clients/' . $c['logo']) ?>" alt="<?= e($c['name']) ?>" class="w-full h-full object-contain transition-transform duration-500 group-hover:scale-110">
                        </div>
                        <?php if (!empty($c['link'])): ?></a><?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function(){
                if (typeof Swiper !== 'undefined') {
                    new Swiper('.clientSwiper', {
                        loop: true,
                        autoplay: { delay: 2000, disableOnInteraction: false },
                        slidesPerView: 2,
                        spaceBetween: 20,
                        breakpoints: {
                            640: { slidesPerView: 3 },
                            1024: { slidesPerView: 5 },
                            1280: { slidesPerView: 6 }
                        }
                    });
                }
            });
        </script>
    </div>
</section>
<?php endif; ?>

<!-- PORTFOLIO / SHOWCASE -->
<?php if (setting('show_portfolio', '1') === '1'): ?>
<section id="solutions" class="py-20 md:py-28 bg-brand-tech dark:bg-brand-secondary">
    <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8">
        
        <!-- Section Heading -->
        <div class="text-center mb-16 md:mb-20">
            <h2 class="text-xs font-bold uppercase tracking-[0.3em] text-brand-primary mb-4">
                Case Studies
            </h2>
            <h3 class="font-display text-3xl sm:text-4xl md:text-5xl font-extrabold text-heading dark:text-inverse tracking-tight leading-tight uppercase">
                WEBSITES THAT MAKE<br class="hidden sm:block"/>
                <span class="bg-gradient-to-r from-brand-primary via-brand-accent to-brand-primary bg-[length:200%_auto] animate-gradient bg-clip-text text-transparent italic">your brand unique</span>
            </h3>
        </div>

        <!-- Portfolio Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6 md:gap-8 mb-16">
            
            <?php foreach($homeItems as $item): 
                $slug = str_replace([' ', '/', '\\'], '-', strtolower($item['title']));
            ?>
                <a href="<?= url('portfolio/' . $slug) ?>" class="group relative rounded-2xl overflow-hidden bg-white dark:bg-brand-navy border border-slate-100 dark:border-white/5 shadow-sm hover:shadow-2xl hover:shadow-brand-primary/10 transition-all duration-500 hover:-translate-y-2">
                    <div class="relative aspect-[4/5] overflow-hidden">
                        <img src="<?= url('public/uploads/') . $item['featured_image'] ?>" alt="<?= e($item['title']) ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4 sm:p-6 translate-y-6 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500">
                            <h5 class="font-display font-bold text-inverse text-sm sm:text-base mb-1 transform group-hover:translate-y-0 translate-y-2 transition-transform duration-500"><?= e($item['title']) ?></h5>
                            <p class="text-[10px] font-bold uppercase tracking-widest text-brand-accent"><?= e($item['category']) ?></p>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

        <?php if (count($homeItems) >= 4): ?>
            <div class="text-center">
                <a href="<?= url('works.php') ?>" class="inline-block w-full sm:w-auto btn-primary px-10 py-5 rounded-xl font-display font-bold text-sm uppercase tracking-widest shadow-xl shadow-brand-primary/20 transition-all text-center hover:scale-105">
                    VIEW MORE WORKS <i class="fa-solid fa-arrow-right ml-2"></i>
                </a>
            </div>
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
<section class="py-32 bg-[color-mix(in_srgb,var(--brand-primary)_80%,white)] dark:bg-brand-dark relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-8 relative z-10 text-center">
        <h4 class="text-[10px] font-bold uppercase tracking-[0.4em] text-white/60 mb-8">YOUR WEBSITE IS THE FIRST THING THEY NOTICE.</h4>
        <h3 class="font-display text-4xl md:text-6xl font-extrabold text-white mb-12 tracking-tight">
            make it <span class="bg-gradient-to-r from-brand-primary via-brand-accent to-brand-primary bg-[length:200%_auto] animate-gradient bg-clip-text text-transparent italic">unforgettable!</span>
        </h3>
        
        <button @click="modalOpen = true" class="w-full sm:w-auto bg-button-primary text-button-primaryText hover:bg-button-primaryHover px-10 py-5 rounded-xl font-display font-bold text-sm uppercase tracking-widest shadow-xl transition-all duration-300 ease-out hover:scale-105 active:scale-100 text-center">
            <i class="fa-solid fa-comment-dots mr-4"></i> GET STARTED
        </button>
    </div>
</section>
<?php endif; ?>

<?php require '../app/views/footer.php'; ?>