<?php
require_once __DIR__ . '/../app/core/Env.php';
Env::load();
session_start();
date_default_timezone_set('Asia/Kolkata');
require_once '../app/config/db.php';
require_once '../app/core/helpers.php';

$title = "Terms of Service - " . setting('site_title', 'Numinds Tech');
require '../app/views/header.php';
?>

<section class="relative pt-32 pb-20 bg-brand-tech dark:bg-brand-dark overflow-hidden min-h-[50vh]">
    <div class="max-w-4xl mx-auto px-8 relative z-10">
        <h1 class="font-display text-4xl md:text-5xl font-extrabold text-heading dark:text-inverse tracking-tight mb-8 text-center">
            Terms of <span class="text-brand-primary italic">Service</span>
        </h1>
        
        <div class="bg-white dark:bg-brand-secondary border border-slate-100 dark:border-white/5 shadow-xl rounded-[2.5rem] p-10 md:p-16 space-y-8 text-text-body">
            <p class="text-sm tracking-widest uppercase font-bold text-slate-400">Last Updated: <?= date('F j, Y') ?></p>
            
            <div class="space-y-4">
                <h2 class="text-xl font-display font-bold text-heading dark:text-inverse">1. Acceptance of Terms</h2>
                <p>By accessing and using this website, you accept and agree to be bound by the terms and provision of this agreement. If you do not agree to abide by these terms, please do not use this service.</p>
            </div>

            <div class="space-y-4">
                <h2 class="text-xl font-display font-bold text-heading dark:text-inverse">2. Services and Deliverables</h2>
                <p>We provide full-stack web development, UI/UX design, and digital agency services. The scope, timelines, and deliverables of each project will be outlined in a separate Statement of Work (SOW) or invoice.</p>
                <p>While we strive for excellence, we cannot guarantee completely error-free code or uninterpretable uptime for hosted services run by third-party providers.</p>
            </div>

            <div class="space-y-4">
                <h2 class="text-xl font-display font-bold text-heading dark:text-inverse">3. Intellectual Property Rights</h2>
                <p>Upon final payment, full intellectual property rights to the custom source code and designs specifically created for your project transfer to you, the client.</p>
                <p>We reserve the right to display completed, non-confidential elements of the project in our portfolio, marketing materials, and case studies unless explicitly forbidden via an NDA.</p>
            </div>

            <div class="space-y-4">
                <h2 class="text-xl font-display font-bold text-heading dark:text-inverse">4. Payments and Refunds</h2>
                <p>Payments must be structured exactly as outlined in the initial project invoice. Standard protocol requires an initial deposit to commence work.</p>
                <p>Due to the custom nature of software development and consulting time mapped to the project, deposits are strictly non-refundable once the discovery and structural phases have begun.</p>
            </div>

            <div class="space-y-4">
                <h2 class="text-xl font-display font-bold text-heading dark:text-inverse">5. Limitation of Liability</h2>
                <p>In no event shall the agency be liable for any indirect, punitive, special, incidental, or consequential damages (including loss of business, revenue, profits, use, or data) arising out of or in connection with our services.</p>
            </div>
            
        </div>
    </div>
</section>

<?php require '../app/views/footer.php'; ?>
