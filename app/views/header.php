<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../core/helpers.php';

// Site Prepared by helpers.php

// Maintenance Banner for Admins
if (Auth::check() && setting('maintenance_mode') === '1'): ?>
    <div class="fixed top-0 left-0 w-full bg-brand-primary text-white text-[10px] font-bold uppercase tracking-[0.2em] py-2 px-6 z-[60] flex items-center justify-between border-b border-white/10">
        <div class="flex items-center gap-3">
            <span class="flex h-2 w-2 relative">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
            </span>
            <span>Maintenance Mode Active (Public Access Restricted)</span>
        </div>
        <a href="<?= url('settings') ?>" class="hover:underline opacity-80 hover:opacity-100">Configure Settings</a>
    </div>
    <style> .glass-nav { top: 32px !important; } .h-\[73px\] { height: 105px !important; } </style>
<?php endif; ?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <title><?= setting('site_title', 'Numinds Tech | Clean Digital Systems') ?></title>
    <meta name="description" content="<?= setting('site_description', 'We build simple, clean, and secure digital systems for real-world organizations.') ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Open Graph Metadata -->
    <meta property="og:title" content="<?= setting('site_title') ?>">
    <meta property="og:description" content="<?= setting('site_description') ?>">
    <?php if ($thumb = setting('site_thumbnail')): ?>
    <meta property="og:image" content="<?= url('public/uploads/' . $thumb) ?>">
    <link rel="shortcut icon" href="<?= url('public/uploads/' . $thumb) ?>" type="image/png">
    <?php endif; ?>
    
    <!-- Fonts: Outfit & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">

    
    <!-- Icons: FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <?php require __DIR__ . '/../config/tailwind.php'; ?>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Swiper (Client logos slider) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <script defer src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
         <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* Modal Transitions */
        [x-cloak] { display: none !important; }
    </style>
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }

        function toggleTheme() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark')
                localStorage.theme = 'light'
            } else {
                document.documentElement.classList.add('dark')
                localStorage.theme = 'dark'
            }
        }
    </script>
</head>

<body x-data="{ modalOpen: false }" class="bg-white text-slate-900 dark:bg-brand-dark dark:text-slate-200 font-sans antialiased selection:bg-brand-cyan selection:text-brand-navy transition-colors duration-300">

<header class="fixed w-full top-0 z-50 glass-nav transition-all duration-300">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

        <!-- Logo -->
        <a href="<?= url('') ?>" class="flex items-center gap-3 group">
            <div class="relative w-9 h-9 flex items-center justify-center">
                <?php if ($logo = setting('site_thumbnail')): ?>
                    <img src="<?= url('public/uploads/' . $logo) ?>" class="w-9 h-9 object-contain relative z-10">
                <?php else: ?>
                    <div class="absolute inset-0 bg-gradient-to-br from-brand-cyan to-brand-teal rounded-lg rotate-3 group-hover:rotate-6 transition-transform"></div>
                    <div class="absolute inset-0 bg-brand-navy dark:bg-brand-dark rounded-lg -rotate-3 group-hover:-rotate-6 transition-transform"></div>
                    <span class="relative font-display font-extrabold text-white text-xl">N</span>
                <?php endif; ?>
            </div>
            <div class="flex flex-col leading-none">
                <span class="font-display font-bold text-lg text-brand-navy dark:text-white tracking-tight">
                    <?php if (setting('site_title')): ?>
                        <?= e(setting('site_title')) ?>
                    <?php else: ?>
                        NuMinds <span class="text-brand-cyan">Tech</span>
                    <?php endif; ?>
                </span>
                <span class="text-[9px] uppercase tracking-[0.3em] font-bold text-slate-400">Simple Digital Systems</span>
            </div>
        </a>

        <!-- Desktop Menu -->
        <nav class="hidden md:flex items-center space-x-10 text-[11px] font-bold uppercase tracking-widest">
            <a href="<?= url('') ?>" class="text-slate-500 hover:text-brand-cyan dark:text-slate-400 dark:hover:text-white transition-colors">Home</a>
            <a href="#services" class="text-slate-500 hover:text-brand-cyan dark:text-slate-400 dark:hover:text-white transition-colors">Services</a>
            <a href="#solutions" class="text-slate-500 hover:text-brand-cyan dark:text-slate-400 dark:hover:text-white transition-colors">Portfolio</a>
            
            <!-- Dark Mode Toggle -->
            <button onclick="toggleTheme()" class="w-8 h-8 rounded-full flex items-center justify-center text-slate-400 hover:text-brand-cyan transition-colors">
                <i class="fa-solid fa-moon dark:hidden"></i>
                <i class="fa-solid fa-sun hidden dark:inline"></i>
            </button>

            <?php if (Auth::check()): ?>
                <a href="<?= url('dashboard') ?>" class="text-brand-teal">Console</a>
                <a href="<?= url('logout') ?>" class="text-red-500">Sign Out</a>
            <?php else: ?>
                <button @click="modalOpen = true" class="btn-primary text-white px-7 py-3 rounded-full shadow-lg shadow-brand-primary/20 hover:shadow-brand-primary/30 transition-all transform hover:-translate-y-0.5 active:translate-y-0 uppercase tracking-widest">
                    Get in Touch
                </button>
            <?php endif; ?>
        </nav>


        <!-- Mobile Button -->
        <div class="flex items-center gap-4 md:hidden">
            <button onclick="toggleTheme()" class="text-slate-400">
                <i class="fa-solid fa-moon dark:hidden"></i>
                <i class="fa-solid fa-sun hidden dark:inline"></i>
            </button>
            <button id="menuBtn" class="text-brand-navy dark:text-white text-2xl">
                <i class="fa-solid fa-bars-staggered"></i>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="hidden md:hidden border-t dark:border-slate-800 bg-white dark:bg-brand-dark absolute w-full shadow-2xl">
        <nav class="flex flex-col px-8 py-10 space-y-6 text-sm font-bold uppercase tracking-widest">
            <a href="<?= url('') ?>" class="text-slate-600 dark:text-slate-300">Home</a>
            <a href="#services" class="text-slate-600 dark:text-slate-300">Services</a>
            <a href="#solutions" class="text-slate-600 dark:text-slate-300">Portfolio</a>
            
            <div class="pt-6 border-t dark:border-slate-800">
            <?php if (Auth::check()): ?>
                <a href="<?= url('dashboard') ?>" class="block mb-4 text-brand-teal">Console</a>
                <a href="<?= url('logout') ?>" class="text-red-500">Sign Out</a>
            <?php else: ?>
                <button @click="modalOpen = true" class="inline-block w-full text-center btn-primary text-white py-4 rounded-xl shadow-lg shadow-brand-primary/20">
                    Contact Us
                </button>
            <?php endif; ?>
            </div>
        </nav>
    </div>
</header>
<!-- Spacer for fixed header -->
<div class="h-[73px]"></div>
<script>
const btn = document.getElementById('menuBtn');
if (btn) {
    btn.onclick = () => {
        document.getElementById('mobileMenu').classList.toggle('hidden');
    };
}
</script>


<main>
