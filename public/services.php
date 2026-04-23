<?php
// public/services.php

require_once __DIR__ . '/../app/core/Env.php';
Env::load();
require_once '../app/config/db.php';
require_once '../app/core/helpers.php';
Auth::startSession();

$title = 'Our Services & Process - NuMinds Tech';
$description = 'Discover how we build high-performance digital systems with our 4-phase lightweight process.';

require '../app/views/header.php';
?>

<!-- PAGE HEADER -->
<section class="pt-32 pb-20 md:pt-40 md:pb-28 bg-[color-mix(in_srgb,var(--brand-primary)_80%,white)] dark:bg-brand-dark relative overflow-hidden">
    <!-- Decorative Circle -->
    <div class="absolute -top-40 -right-40 w-96 h-96 bg-brand-accent/20 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-6 md:px-8 relative z-10 text-center">
        <h1 class="font-display text-4xl md:text-6xl font-extrabold text-heading dark:text-inverse tracking-tight uppercase leading-tight mb-6">
            OUR <span class="bg-gradient-to-r from-brand-primary via-brand-accent to-brand-primary bg-[length:200%_auto] animate-gradient bg-clip-text text-transparent italic">EXPERTISE</span>
        </h1>
        <p class="text-base md:text-lg text-body dark:text-muted max-w-2xl mx-auto font-medium">
            We specialize in crafting lightweight, scalable, and ultra-fast digital systems required by ambitious organizations to outpace the competition.
        </p>
    </div>
</section>

<!-- THE SERVICES SECTION -->
<section class="py-20 md:py-28 bg-white dark:bg-brand-dark relative z-20 -mt-10 rounded-t-[3rem]">
    <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8">
        <!-- 🔲 Subtle Grid Background -->
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none rounded-t-[3rem]"
             style="background-image: linear-gradient(to right, #00000010 1px, transparent 1px), linear-gradient(to bottom, #00000010 1px, transparent 1px); background-size: 40px 40px;">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 relative z-10">
            <?php 
            $services = [
                ['icon' => 'fa-laptop-code', 'title' => 'Business Websites', 'desc' => 'High-performance digital profiles for schools, NGOs, and corporations. We engineer sites that load instantly and capture leads.', 'color' => 'brand-primary'],
                ['icon' => 'fa-cart-shopping', 'title' => 'E-commerce Architecture', 'desc' => 'Scalable online stores with seamless payment systems. Built to handle massive traffic and secure transactions without breaking a sweat.', 'color' => 'brand-accent'],
                ['icon' => 'fa-gears', 'title' => 'Custom Web Applications', 'desc' => 'Tailored internal dashboards and software tools built specifically for your workflow. Say goodbye to bloated, off-the-shelf software.', 'color' => 'brand-primary'],
                ['icon' => 'fa-rocket', 'title' => 'Performance SEO & Speed', 'desc' => 'Ensuring your brand stands out in digital noise. We optimize everything from server response times to semantic HTML structure.', 'color' => 'brand-accent'],
            ];

            foreach($services as $s): ?>
            
            <div class="flex gap-6 p-6 md:p-8 bg-slate-50 dark:bg-brand-navy border border-slate-100 dark:border-white/5 rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 group">
                <div class="w-16 h-16 rounded-2xl bg-white dark:bg-brand-secondary flex-shrink-0 shadow-sm flex items-center justify-center text-[<?= $s['color'] ?>] border border-slate-100 dark:border-white/5 group-hover:scale-110 transition-transform duration-500">
                    <i class="fa-solid <?= $s['icon'] ?> text-2xl text-brand-primary"></i>
                </div>
                <div>
                    <h3 class="font-display font-bold text-xl text-heading dark:text-inverse mb-3 group-hover:text-brand-primary transition-colors"><?= $s['title'] ?></h3>
                    <p class="text-sm text-body dark:text-muted leading-relaxed"><?= $s['desc'] ?></p>
                </div>
            </div>

            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- PROCESS SECTION -->
<?php require __DIR__ . '/../app/views/sections/process.php'; ?>

<!-- FAQ SECTION -->
<?php require __DIR__ . '/../app/views/sections/faq.php'; ?>

<!-- CALL TO ACTION -->
<section class="py-24 bg-brand-primary dark:bg-brand-secondary text-center">
    <div class="max-w-4xl mx-auto px-6">
        <h2 class="font-display text-3xl md:text-5xl font-black text-white mb-8 tracking-tight">Ready to build something extraordinary?</h2>
        <a href="<?= url('estimator.php') ?>" class="inline-flex items-center gap-3 bg-white text-brand-primary px-8 py-4 rounded-xl font-bold uppercase tracking-widest hover:scale-105 transition-transform shadow-xl">
            <i class="fa-solid fa-calculator"></i> Custom Project Estimate
        </a>
    </div>
</section>

<?php require '../app/views/footer.php'; ?>
