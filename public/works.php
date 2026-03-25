<?php
// public/works.php
require_once __DIR__ . '/../app/core/Env.php';
Env::load();

session_start();
date_default_timezone_set('Asia/Kolkata');
require_once '../app/config/db.php';
require_once '../app/core/helpers.php';

// Prepare Site
$title = "Our Portfolio - " . setting('site_title', 'Numinds Tech');
$description = 'Browse our complete catalog of digital solutions.';

// Fetch All Published Portfolio Items
$items = $pdo->query("SELECT * FROM portfolio_items WHERE status = 'published' ORDER BY display_order ASC, created_at DESC")->fetchAll(PDO::FETCH_ASSOC);

require '../app/views/header.php';
?>

<!-- PORTFOLIO HEADER -->
<section class="relative pt-32 pb-20 bg-brand-tech dark:bg-brand-dark overflow-hidden">
    <div class="max-w-7xl mx-auto px-8 relative z-10 text-center">
        <h2 class="text-[10px] font-bold uppercase tracking-[0.4em] text-brand-primary mb-4">Our Complete Catalog</h2>
        <h1 class="font-display text-5xl md:text-7xl font-extrabold text-heading dark:text-inverse tracking-tight mb-8">
            Digital <span class="bg-gradient-to-r from-brand-primary via-brand-accent to-brand-primary bg-[length:200%_auto] animate-gradient bg-clip-text text-transparent italic">Masterpieces</span>
        </h1>
        <p class="text-slate-500 dark:text-slate-400 font-medium max-w-2xl mx-auto text-lg">
            Explore our extensive library of custom web applications, performance-driven websites, and tailored digital solutions.
        </p>
    </div>
</section>

<!-- PORTFOLIO GRID -->
<section class="py-20 bg-white dark:bg-brand-secondary min-h-[50vh]">
    <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 relative z-10">
        <?php if (empty($items)): ?>
            <div class="text-center py-20 text-muted uppercase tracking-widest text-[10px] font-bold">
                Works coming soon...
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-8">
                <?php foreach($items as $item): 
                    $slug = str_replace([' ', '/', '\\'], '-', strtolower($item['title']));
                ?>
                    <a href="<?= url('portfolio/' . $slug) ?>" class="group flex flex-col relative rounded-2xl overflow-hidden bg-slate-50 dark:bg-brand-navy border border-slate-100 dark:border-white/5 shadow-sm hover:shadow-2xl hover:shadow-brand-primary/10 transition-all duration-500 hover:-translate-y-2">
                        <div class="relative aspect-[4/5] overflow-hidden">
                            <img src="<?= url('public/uploads/') . $item['featured_image'] ?>" alt="<?= e($item['title']) ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-4 sm:p-6 translate-y-6 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500">
                                <i class="fa-solid fa-arrow-up-right-from-square text-white mb-2 shadow-sm"></i>
                            </div>
                        </div>
                        <div class="p-5 flex-1 flex flex-col justify-center">
                            <p class="text-[9px] font-bold uppercase tracking-[0.2em] text-brand-accent mb-1"><?= e($item['category']) ?></p>
                            <h5 class="font-display font-bold text-heading dark:text-inverse text-base leading-tight"><?= e($item['title']) ?></h5>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- CTA -->
<section class="py-20 bg-brand-tech dark:bg-brand-dark">
    <div class="max-w-4xl mx-auto px-8 relative z-10 text-center">
        <h3 class="font-display text-3xl font-extrabold text-heading dark:text-inverse mb-6">Want something similar tailored for you?</h3>
        <button @click="modalOpen = true" class="btn-primary px-10 py-4 rounded-xl font-display font-bold text-xs uppercase tracking-widest shadow-lg hover:scale-105 transition-all">
            <i class="fa-solid fa-paper-plane mr-2"></i> Discuss Your Project
        </button>
    </div>
</section>

<?php require '../app/views/footer.php'; ?>
