<?php
// public/estimator.php

require_once __DIR__ . '/../app/core/Env.php';
Env::load();
require_once '../app/config/db.php';
require_once '../app/core/helpers.php';
Auth::startSession();

$title = 'Project Estimator - NuMinds Tech';
$description = 'Calculate an instant, ballpark cost estimate for your next digital system, website, or mobile app.';

require '../app/views/header.php';
?>

<!-- PAGE HEADER -->
<section class="pt-32 pb-4 md:pt-40 md:pb-10 bg-white dark:bg-brand-dark relative overflow-hidden">
    <!-- Decorative Grid -->
    <div class="absolute inset-0 opacity-[0.03] pointer-events-none"
         style="background-image: linear-gradient(to right, #00000010 1px, transparent 1px), linear-gradient(to bottom, #00000010 1px, transparent 1px); background-size: 40px 40px;">
    </div>

    <div class="max-w-4xl mx-auto px-6 relative z-10 text-center">
        <h1 class="font-display text-4xl md:text-5xl font-extrabold text-heading dark:text-inverse tracking-tight uppercase leading-tight mb-4">
            System <span class="text-brand-primary italic">Blueprint</span>
        </h1>
        <p class="text-sm md:text-base text-body dark:text-muted max-w-xl mx-auto font-medium">
            Select your requirements below for an instant, ballpark estimate of your project timeline and investment.
        </p>
    </div>
</section>

<!-- ESTIMATOR COMPONENT -->
<div class="py-10">
    <?php require __DIR__ . '/../app/views/components/project-estimator.php'; ?>
</div>

<!-- FAQ SECTION MINI -->
<?php require __DIR__ . '/../app/views/sections/faq.php'; ?>

<?php require '../app/views/footer.php'; ?>
