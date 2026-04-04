<?php
require_once __DIR__ . '/../app/core/Env.php';
Env::load();
session_start();
date_default_timezone_set('Asia/Kolkata');
require_once '../app/config/db.php';
require_once '../app/core/helpers.php';

$title = "Privacy Policy - " . setting('site_title', 'Numinds Tech');
require '../app/views/header.php';
?>

<section class="relative pt-32 pb-20 bg-brand-tech dark:bg-brand-dark overflow-hidden min-h-[50vh]">
    <div class="max-w-4xl mx-auto px-8 relative z-10">
        <h1 class="font-display text-4xl md:text-5xl font-extrabold text-heading dark:text-inverse tracking-tight mb-8 text-center">
            Privacy <span class="text-brand-primary italic">Policy</span>
        </h1>
        
        <div class="bg-white dark:bg-brand-secondary border border-slate-100 dark:border-white/5 shadow-xl rounded-[2.5rem] p-10 md:p-16 space-y-8 text-text-body">
            <p class="text-sm tracking-widest uppercase font-bold text-slate-400">Last Updated: <?= date('F j, Y') ?></p>
            
            <div class="space-y-4">
                <h2 class="text-xl font-display font-bold text-heading dark:text-inverse">1. Information We Collect</h2>
                <p>We collect information you provide directly to us, such as when you request a quote, fill out a form, or communicate with us. This may include your name, email address, phone number, and project details.</p>
                <p>We also automatically collect certain information about your device and usage of our website through cookies and analytics tools, including IP address, browser type, and pages visited.</p>
            </div>

            <div class="space-y-4">
                <h2 class="text-xl font-display font-bold text-heading dark:text-inverse">2. How We Use Your Information</h2>
                <p>We use the information we collect to:</p>
                <ul class="list-disc pl-5 space-y-2">
                    <li>Provide, maintain, and improve our services.</li>
                    <li>Communicate with you regarding projects, inquiries, and technical support.</li>
                    <li>Analyze website traffic to improve user experience using analytics.</li>
                    <li>Send promotional communications (only with explicit consent).</li>
                </ul>
            </div>

            <div class="space-y-4">
                <h2 class="text-xl font-display font-bold text-heading dark:text-inverse">3. Data Sharing and Security</h2>
                <p>We do not sell, trade, or rent your personal identification information to others. We may share generic aggregated demographic information not linked to any personal identification information with our business partners.</p>
                <p>We adopt industry-standard data collection, storage, processing practices, and security measures to protect against unauthorized access or alteration of your personal information.</p>
            </div>

            <div class="space-y-4">
                <h2 class="text-xl font-display font-bold text-heading dark:text-inverse">4. Your Data Rights</h2>
                <p>You have the right to request access to the personal data we hold about you, request corrections to any inaccurate data, or request the deletion of your data. Please contact us to exercise these rights.</p>
            </div>
            
            <div class="bg-slate-50 dark:bg-brand-navy p-6 rounded-xl border border-slate-200 dark:border-white/10 mt-8">
                <p class="text-sm font-bold text-heading dark:text-inverse mb-2">Questions about this policy?</p>
                <p class="text-sm">Contact our data protection team directly via our main contact channels.</p>
            </div>
        </div>
    </div>
</section>

<?php require '../app/views/footer.php'; ?>
