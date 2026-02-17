<?php
// public/index.php
session_start();
date_default_timezone_set('Asia/Kolkata');
require_once '../app/config/db.php';
require_once '../app/core/helpers.php';

// Prepare Site (Handled by helpers.php if $pdo is set)

$homeItems = $pdo->query(
    "SELECT * FROM portfolio_items WHERE status = 'published' ORDER BY display_order ASC, created_at DESC LIMIT 4"
)->fetchAll(PDO::FETCH_ASSOC);

$clients = $pdo->query("SELECT * FROM clients ORDER BY sort_order ASC, id ASC")->fetchAll(PDO::FETCH_ASSOC);

$title = setting('site_title', 'Numinds Tech');
$description = setting('site_description', 'Building simple digital systems.');

require '../app/views/header.php';
?>

<!-- HERO SECTION -->
<section class="relative min-h-screen flex items-center overflow-hidden bg-brand-secondary pt-20">
    <!-- Background Patterns -->
    <div class="absolute inset-0 opacity-5">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid)" />
        </svg>
    </div>

    <div class="max-w-7xl mx-auto px-8 relative z-10 w-full">
        <div class="grid lg:grid-cols-2 gap-20 items-center">
            <div class="text-white">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/5 border border-white/10 rounded-full mb-8 backdrop-blur-sm">
                    <div class="w-2 h-2 rounded-full bg-brand-accent animate-pulse"></div>
                    <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-cyan-100/60">Now servicing 50+ organizations</span>
                </div>
                
                <h1 class="font-display text-5xl md:text-7xl font-extrabold mb-8 leading-[1.1] tracking-tight">
                    Clean Tech. <br/>
                    <span class="text-brand-accent">Simple Systems.</span>
                </h1>
                
                <p class="text-lg md:text-xl text-slate-400 mb-12 leading-relaxed max-w-xl">
                    We build high-performance, secure digital tools for organizations that value clarity and trust above artificial hype.
                </p>
                
                <div class="flex flex-col sm:flex-row items-center gap-6">
                    <button @click="modalOpen = true" class="w-full sm:w-auto btn-primary px-10 py-5 rounded-xl font-display font-bold text-sm uppercase tracking-widest shadow-xl shadow-brand-primary/20 transition-all text-center">
                        Start your Project
                    </button>
                    <a href="#solutions" class="w-full sm:w-auto bg-white/5 hover:bg-white/10 text-white border border-white/10 px-10 py-5 rounded-xl font-display font-bold text-sm uppercase tracking-widest transition-all text-center backdrop-blur-sm">
                        View Portfolio
                    </a>
                </div>
            </div>

            <div class="hidden lg:block">
                <div class="relative group">
                    <div class="relative bg-brand-navy p-2 border border-white/10 rounded-3xl overflow-hidden shadow-2xl">
                        <img src="<?= url('assets/hero-bg.png') ?>" alt="Numinds interface" class="w-full h-auto rounded-2xl opacity-90 group-hover:opacity-100 group-hover:scale-[1.02] transition-all duration-700">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- STATS STRIP -->
<section class="relative z-20 -mt-16">
    <div class="max-w-5xl mx-auto px-8">
        <div class="bg-white dark:bg-[#0c1222] border border-slate-100 dark:border-white/10 p-10 md:p-12 rounded-[2.5rem] shadow-2xl flex flex-wrap justify-around gap-12 text-center">
            <div class="flex-1 min-w-[120px]">
                <div class="text-4xl md:text-5xl font-display font-extrabold text-brand-secondary dark:text-white mb-2 tracking-tight">60+</div>
                <div class="text-[10px] uppercase font-bold text-brand-accent tracking-[0.2em]">Projects Deployed</div>
            </div>
            <div class="w-px h-16 bg-slate-100 dark:bg-white/5 hidden md:block"></div>
            <div class="flex-1 min-w-[120px]">
                <div class="text-4xl md:text-5xl font-display font-extrabold text-brand-secondary dark:text-white mb-2 tracking-tight">25+</div>
                <div class="text-[10px] uppercase font-bold text-brand-primary tracking-[0.2em]">Active Partners</div>
            </div>
            <div class="w-px h-16 bg-slate-100 dark:bg-white/5 hidden md:block"></div>
            <div class="flex-1 min-w-[120px]">
                <div class="text-4xl md:text-5xl font-display font-extrabold text-brand-secondary dark:text-white mb-2 tracking-tight">4K</div>
                <div class="text-[10px] uppercase font-bold text-slate-400 tracking-[0.2em]">Coffee Cups Taken</div>
            </div>
            <div class="w-px h-16 bg-slate-100 dark:bg-white/5 hidden md:block"></div>
            <div class="flex-1 min-w-[120px]">
                <div class="text-4xl md:text-5xl font-display font-extrabold text-brand-secondary dark:text-white mb-2 tracking-tight">100%</div>
                <div class="text-[10px] uppercase font-bold text-slate-400 tracking-[0.2em]">Delivery Rate</div>
            </div>
        </div>
    </div>
</section>


<!-- THINGS WE ARE GOOD AT -->
<section id="services" class="py-32 bg-white dark:bg-brand-dark overflow-hidden">
    <div class="max-w-7xl mx-auto px-8">
        <div class="text-center mb-20">
            <h2 class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-primary mb-4">Our Expertise</h2>
            <h3 class="font-display text-4xl md:text-5xl font-extrabold text-brand-secondary dark:text-white tracking-tight">
                THINGS THAT <span class="text-brand-accent">WE ARE GOOD AT</span> 🎯<br/>
                <span class="text-lg font-medium text-slate-400 mt-4 block">doing this for 4+ years</span>
            </h3>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Service cards (existing logic maintained with standard primary button) -->
            <?php 
            $services = [
                ['icon' => 'fa-laptop-code', 'title' => 'Business Websites', 'desc' => 'High-performance digital profiles for schools and organizations.', 'color' => 'brand-primary'],
                ['icon' => 'fa-cart-shopping', 'title' => 'E-commerce', 'desc' => 'Scalable online stores with seamless payment systems.', 'color' => 'brand-accent'],
                ['icon' => 'fa-gears', 'title' => 'Custom Web Apps', 'desc' => 'Tailored internal dashboards built for your workflow.', 'color' => 'brand-primary'],
                ['icon' => 'fa-rocket', 'title' => 'SEO & Speed', 'desc' => 'Ensuring your brand stands out in digital noise.', 'color' => 'brand-accent'],
            ];
            foreach($services as $s): ?>
            <div class="group p-8 bg-slate-50 dark:bg-[#0c1222] border border-slate-100 dark:border-white/5 rounded-3xl hover:border-<?= $s['color'] ?>/40 transition-all duration-500 hover:-translate-y-2">
                <div class="w-14 h-14 bg-white dark:bg-brand-secondary rounded-2xl flex items-center justify-center text-<?= $s['color'] ?> mb-8 shadow-sm group-hover:shadow-<?= $s['color'] ?>/20 transition-all">
                    <i class="fa-solid <?= $s['icon'] ?> text-2xl"></i>
                </div>
                <h3 class="font-display text-lg font-bold mb-4 dark:text-white group-hover:text-<?= $s['color'] ?> transition-colors"><?= $s['title'] ?></h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed font-medium mb-8"><?= $s['desc'] ?></p>
                <button @click="modalOpen = true" class="text-[10px] font-bold uppercase tracking-widest text-<?= $s['color'] ?> flex items-center gap-2 group/link">
                    Connect now <i class="fa-solid fa-arrow-right group-hover/link:translate-x-1 transition-transform"></i>
                </button>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<!-- CLIENTS / PARTNERS -->
<?php if (!empty($clients)): ?>
<section id="clients" class="py-20 bg-white dark:bg-brand-dark">
    <div class="max-w-7xl mx-auto px-8">
        <div class="text-center mb-8">
            <h2 class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-primary mb-4">Trusted By</h2>
            <h3 class="font-display text-3xl md:text-4xl font-extrabold text-brand-secondary dark:text-white tracking-tight">
                Organizations that trust our work
            </h3>
        </div>

        <div class="swiper my-8">
            <div class="swiper-wrapper items-center">
                <?php foreach($clients as $c): ?>
                    <div class="swiper-slide flex items-center justify-center p-6">
                        <?php if (!empty($c['link'])): ?><a href="<?= e($c['link']) ?>" target="_blank" class="block"><?php endif; ?>
                        <div class="w-40 h-20 flex items-center justify-center">
                            <img src="<?= url('public/uploads/clients/' . $c['logo']) ?>" alt="<?= e($c['name']) ?>" class="max-h-12 object-contain grayscale opacity-80 hover:opacity-100 transition-all">
                        </div>
                        <?php if (!empty($c['link'])): ?></a><?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function(){
                if (typeof Swiper !== 'undefined') {
                    new Swiper('.swiper', {
                        loop: true,
                        autoplay: { delay: 2200, disableOnInteraction: false },
                        slidesPerView: 5,
                        spaceBetween: 20,
                        breakpoints: {
                            320: { slidesPerView: 2 },
                            640: { slidesPerView: 3 },
                            1024: { slidesPerView: 5 }
                        }
                    });
                }
            });
        </script>
    </div>
</section>
<?php endif; ?>

<!-- PORTFOLIO / SHOWCASE -->
<section id="solutions" class="py-32 bg-slate-50 dark:bg-brand-secondary" 
         x-data="{ 
            items: <?= json_encode($homeItems) ?>, 
            page: 1, 
            hasMore: <?= count($homeItems) >= 4 ? 'true' : 'false' ?>, 
            loading: false,
            async loadMore() {
                this.loading = true;
                this.page++;
                try {
                    const res = await fetch('<?= url('public/api/items.php') ?>?page=' + this.page);
                    const data = await res.json();
                    if (data.success) {
                        this.items = [...this.items, ...data.items];
                        this.hasMore = data.has_more;
                    }
                } catch (e) {
                    console.error('Portfolio load failed');
                } finally {
                    this.loading = false;
                }
            }
         }">
    <div class="max-w-7xl mx-auto px-8">
        <div class="text-center mb-24">
            <h2 class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-primary mb-4">Case Studies</h2>
            <h3 class="font-display text-4xl md:text-5xl font-extrabold text-brand-secondary dark:text-white tracking-tight">
                WEBSITES THAT MAKE<br/>
                <span class="text-brand-accent italic">your brand unique</span> ✨
            </h3>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-8 mb-20">
            <template x-for="item in items" :key="item.id">
                <div class="group relative aspect-[4/5] rounded-[2rem] overflow-hidden bg-white dark:bg-brand-navy border border-slate-100 dark:border-white/5 shadow-sm transition-all duration-700 hover:-translate-y-2 hover:shadow-2xl hover:shadow-brand-primary/10">
                    <img :src="'<?= url('public/uploads/') ?>' + item.featured_image" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700 group-hover:scale-110">
                    <div class="absolute inset-x-0 bottom-0 bg-brand-secondary/90 p-6 md:p-8 opacity-0 group-hover:opacity-100 transition-all duration-500 translate-y-4 group-hover:translate-y-0">
                        <h4 class="font-display font-bold text-white text-base mb-1" x-text="item.title"></h4>
                        <p class="text-[9px] font-bold uppercase tracking-widest text-brand-accent" x-text="item.category"></p>
                    </div>
                </div>
            </template>
        </div>
        
        <div class="text-center" x-show="hasMore">
            <button @click="loadMore()" :disabled="loading" 
                    class="inline-flex items-center gap-4 btn-primary px-10 py-5 rounded-2xl font-display font-bold text-xs uppercase tracking-[0.2em] shadow-xl shadow-brand-primary/20 transition-all active:scale-95 disabled:opacity-50">
                <span x-text="loading ? 'SYNCING DATA...' : 'VIEW MORE WORKS'"></span>
                <i class="fa-solid fa-arrow-right" :class="loading ? 'animate-spin' : ''"></i>
            </button>
        </div>
    </div>
</section>

<!-- DESIGN & DEV DIARIES -->
<section class="py-32 bg-white dark:bg-brand-dark relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-8 relative z-10">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-20 gap-8">
            <div>
                <h2 class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-primary mb-4">Focused Blogs</h2>
                <h3 class="font-display text-4xl md:text-5xl font-extrabold text-brand-secondary dark:text-white tracking-tight">
                    DESIGN & <span class="text-brand-accent italic">DEV DIARIES</span> ❤️
                </h3>
            </div>
            <button @click="modalOpen = true" class="bg-slate-50 dark:bg-brand-secondary border border-slate-100 dark:border-white/10 px-8 py-4 rounded-xl font-bold text-[10px] uppercase tracking-widest text-slate-500 hover:text-brand-primary transition-all">
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
                <div class="aspect-[16/10] rounded-2xl overflow-hidden bg-slate-100 dark:bg-brand-secondary border border-slate-100 dark:border-white/5">
                    <img src="<?= url($b['img']) ?>" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700 group-hover:scale-105">
                </div>
                <h4 class="font-display font-bold text-sm text-brand-secondary dark:text-slate-200 group-hover:text-brand-primary transition-colors pr-4"><?= $b['title'] ?></h4>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- TESTIMONIALS -->
<section class="py-32 bg-slate-50 dark:bg-brand-secondary/30 overflow-hidden relative">
    <div class="max-w-7xl mx-auto px-8 relative z-10">
        <div class="text-center mb-24">
            <h2 class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-accent mb-4">Testimonials</h2>
            <h3 class="font-display text-4xl md:text-5xl font-extrabold text-brand-secondary dark:text-white tracking-tight">
                STRAIGHT FROM <span class="text-brand-primary">OUR CLIENTS</span> ❤️
            </h3>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <!-- Testimonial 1 -->
            <div class="bg-white dark:bg-brand-navy p-10 rounded-[2.5rem] border border-slate-100 dark:border-white/5 relative group hover:border-brand-primary/30 transition-all duration-500 shadow-sm">
                <div class="absolute -top-12 left-1/2 -translate-x-1/2 p-2 bg-white dark:bg-brand-secondary rounded-full shadow-xl">
                    <img src="https://ui-avatars.com/api/?name=Ali+Saif&background=2563eb&color=fff" class="w-20 h-20 rounded-full grayscale group-hover:grayscale-0 transition-all">
                </div>
                <div class="mt-12 text-center">
                    <h4 class="font-display font-bold text-lg dark:text-white mb-1">Ali Saif</h4>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-brand-accent">CEO, EduStream</span>
                    <div class="my-8 text-slate-200 dark:text-slate-800 text-3xl">
                        <i class="fa-solid fa-quote-left"></i>
                    </div>
                    <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed font-semibold">
                        "The system Numinds built for our campus is exceptionally reliable. Clarity and control were exactly what we needed."
                    </p>
                </div>
            </div>
            <!-- Testimonial 2 -->
            <div class="bg-white dark:bg-brand-navy p-10 rounded-[2.5rem] border border-slate-100 dark:border-white/5 relative group hover:border-brand-accent/30 transition-all duration-500 shadow-sm">
                <div class="absolute -top-12 left-1/2 -translate-x-1/2 p-2 bg-white dark:bg-brand-secondary rounded-full shadow-xl">
                    <img src="https://ui-avatars.com/api/?name=Zubair+Adil&background=06b6d4&color=fff" class="w-20 h-20 rounded-full grayscale group-hover:grayscale-0 transition-all">
                </div>
                <div class="mt-12 text-center">
                    <h4 class="font-display font-bold text-lg dark:text-white mb-1">Zubair Adil</h4>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-brand-accent">Director, Al-Noor NGO</span>
                    <div class="my-8 text-slate-200 dark:text-slate-800 text-3xl">
                        <i class="fa-solid fa-quote-left"></i>
                    </div>
                    <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed font-semibold">
                        "Finally, a tech partner who understands values. Their clean-code approach has made our data management effortless."
                    </p>
                </div>
            </div>
            <!-- Testimonial 3 -->
            <div class="bg-white dark:bg-brand-navy p-10 rounded-[2.5rem] border border-slate-100 dark:border-white/5 relative group hover:border-brand-primary/30 transition-all duration-500 shadow-sm">
                <div class="absolute -top-12 left-1/2 -translate-x-1/2 p-2 bg-white dark:bg-brand-secondary rounded-full shadow-xl">
                    <img src="https://ui-avatars.com/api/?name=Irfan+K&background=2563eb&color=fff" class="w-20 h-20 rounded-full grayscale group-hover:grayscale-0 transition-all">
                </div>
                <div class="mt-12 text-center">
                    <h4 class="font-display font-bold text-lg dark:text-white mb-1">Irfan K.</h4>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-brand-accent">Founder, Stylofur</span>
                    <div class="my-8 text-slate-200 dark:text-slate-800 text-3xl">
                        <i class="fa-solid fa-quote-left"></i>
                    </div>
                    <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed font-semibold">
                        "High performance and no bloat. Our e-commerce conversion rates soared after we implemented the custom solution."
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CALL TO ACTION FINAL -->
<section class="py-32 bg-brand-secondary relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-8 relative z-10 text-center">
        <h4 class="text-[10px] font-bold uppercase tracking-[0.4em] text-slate-400 mb-8">YOUR WEBSITE IS THE FIRST THING THEY NOTICE.</h4>
        <h3 class="font-display text-4xl md:text-6xl font-extrabold text-white mb-12 tracking-tight">
            make it <span class="text-brand-accent italic">unforgettable!</span>
        </h3>
        
        <button @click="modalOpen = true" class="btn-primary font-display font-extrabold px-16 py-6 rounded-2xl text-[11px] uppercase tracking-[0.3em] shadow-2xl shadow-brand-primary/20 hover:scale-105 transition-all">
            <i class="fa-solid fa-comment-dots mr-4"></i> GET STARTED
        </button>
    </div>
</section>


<?php require '../app/views/footer.php'; ?>
