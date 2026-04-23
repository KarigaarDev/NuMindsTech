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
    
    <!-- Fonts are now loaded dynamically via tailwind.php -->

    
    <!-- Icons: FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind Configuration -->
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
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php require __DIR__ . '/../config/tailwind.php'; ?>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Swiper (Client logos slider) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <script defer src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

    <style>
        /* Modal Transitions */
        [x-cloak] { display: none !important; }

        /* Premium Scroll Progress Bar */
        #scroll-progress {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            background: linear-gradient(to right, var(--brand-primary), var(--brand-accent));
            z-index: 9999;
            width: 0%;
            transition: width 0.1s ease-out;
        }

        /* Custom Premium Cursor */
        #custom-cursor {
            width: 12px;
            height: 12px;
            background: var(--brand-primary);
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            z-index: 10000;
            transition: transform 0.1s ease-out, opacity 0.3s ease;
            mix-blend-mode: difference;
            opacity: 0;
        }
        #custom-cursor-outline {
            width: 40px;
            height: 40px;
            border: 1px solid var(--brand-primary);
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            z-index: 10000;
            transition: transform 0.2s ease-out, opacity 0.3s ease;
            opacity: 0;
        }

        <?php if (setting('show_grid_bg', '1') === '1'): ?>

        /* Global Grid Background for Sections */
        section {
            position: relative;
        }
        section::before {
            content: '';
            position: absolute;
            inset: 0;
            pointer-events: none;
            background-image: 
                linear-gradient(to right, rgba(128, 128, 128, 0.08) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(128, 128, 128, 0.08) 1px, transparent 1px);
            background-size: 40px 40px;
            background-attachment: fixed;
            z-index: 0;
        }
        .dark section::before {
            background-image: 
                linear-gradient(to right, rgba(255, 255, 255, 0.05) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
        }
        <?php endif; ?>
    </style>

</head>

<body x-data="{ modalOpen: false }" 
@open-modal.window="modalOpen = true"
class="bg-white text-heading 
       dark:bg-brand-dark dark:text-inverse 
       font-sans antialiased 
       selection:bg-brand-accent selection:text-white 
       transition-colors duration-500">

<?php include __DIR__ . '/components/preloader.php'; ?>


<!-- Premium UI Elements -->
<div id="scroll-progress"></div>
<div id="custom-cursor" class="hidden md:block"></div>
<div id="custom-cursor-outline" class="hidden md:block"></div>

<script>
    // 💡 Scroll Progress Logic
    window.addEventListener('scroll', () => {
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        document.getElementById("scroll-progress").style.width = scrolled + "%";
    });

    // 💡 Premium Trailing Cursor Logic
    const cursor = document.getElementById('custom-cursor');
    const outline = document.getElementById('custom-cursor-outline');
    
    if (window.innerWidth > 768) {
        window.addEventListener('mousemove', (e) => {
            cursor.style.opacity = "1";
            outline.style.opacity = "1";
            
            const x = e.clientX;
            const y = e.clientY;
            
            cursor.style.transform = `translate3d(${x - 6}px, ${y - 6}px, 0)`;
            outline.style.transform = `translate3d(${x - 20}px, ${y - 20}px, 0)`;
        });

        // Hover scales
        document.querySelectorAll('a, button, [role="button"]').forEach(el => {
            el.addEventListener('mouseenter', () => outline.style.transform += ' scale(1.5)');
            el.addEventListener('mouseleave', () => outline.style.transform = outline.style.transform.replace(' scale(1.5)', ''));
        });
    }

    // 💡 Scroll Reveal Logic
    const revealCallback = (entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('reveal-active');
            }
        });
    };

    const revealObserver = new IntersectionObserver(revealCallback, { threshold: 0.1 });
    window.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('section').forEach(section => {
            section.classList.add('reveal-init');
            revealObserver.observe(section);
        });
    });
</script>

<style>
    /* Reveal Animation Classes */
    .reveal-init {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s cubic-bezier(0.2, 1, 0.3, 1);
    }
    .reveal-active {
        opacity: 1 !important;
        transform: translateY(0) !important;
    }
</style>



<header class="fixed w-full top-0 z-50 glass-nav transition-all duration-300 border-b border-white/5">
    <!-- Global Grid Background -->
    <div class="absolute inset-0 opacity-[0.03] dark:opacity-5 pointer-events-none -z-10 overflow-hidden">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="grid-header" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="currentColor" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid-header)" />
        </svg>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

        <!-- Logo -->
        <a href="<?= url('') ?>" class="flex items-center gap-3 group">
            <div class="relative w-9 h-9 flex items-center justify-center">
                <?php if ($logo = setting('site_thumbnail')): ?>
                    <img src="<?= url('public/uploads/' . $logo) ?>" class="w-9 h-9 object-contain relative z-10 transition-transform group-hover:scale-110">
                <?php else: ?>
                    <div class="absolute inset-0 bg-brand-primary rounded-xl rotate-3 group-hover:rotate-6 transition-transform shadow-lg shadow-brand-primary/20"></div>
                    <div class="absolute inset-0 bg-brand-secondary/50 dark:bg-brand-dark rounded-xl -rotate-3 group-hover:-rotate-6 transition-transform border border-white/5"></div>
                    <span class="relative font-display font-extrabold text-white text-xl">N</span>
                <?php endif; ?>
            </div>
            <div class="flex flex-col leading-none">
                <span class="font-display font-bold text-lg text-brand-navy dark:text-white tracking-tight">
                    <?php if (setting('site_title')): ?>
                        <?= e(setting('site_title')) ?>
                    <?php else: ?>
                        NuMinds <span class="text-brand-accent italic">Tech</span>
                    <?php endif; ?>
                </span>
                <span class="text-[9px] uppercase tracking-[0.4em] font-bold text-muted">Intelligent Digital Systems</span>
            </div>
        </a>

        <!-- Desktop Menu -->
        <nav class="hidden md:flex items-center space-x-10 text-[11px] font-bold uppercase tracking-widest">
            
            <div class="flex items-center gap-6 mr-4 border-r border-slate-200 dark:border-white/10 pr-6">
                <a href="<?= url('') ?>" class="text-heading hover:text-brand-primary transition-colors">Home</a>
                <a href="<?= url('services.php') ?>" class="text-heading hover:text-brand-primary transition-colors">Services & Process</a>
                <a href="<?= url('works.php') ?>" class="text-heading hover:text-brand-primary transition-colors">Portfolio</a>
                <a href="<?= url('index.php#testimonials') ?>" class="text-heading hover:text-brand-primary transition-colors">Reviews</a>
            </div>

            <!-- Social Links in Header -->
            <div class="flex items-center gap-4 text-slate-400/50">
                <?php if ($fb = setting('facebook_url')): ?>
                    <a href="<?= e($fb) ?>" target="_blank" data-track="SOCIAL" data-label="Facebook (Header)" class="hover:text-brand-primary transition-colors"><i class="fa-brands fa-facebook-f text-sm"></i></a>
                <?php endif; ?>
                <?php if ($li = setting('linkedin_url')): ?>
                    <a href="<?= e($li) ?>" target="_blank" data-track="SOCIAL" data-label="LinkedIn (Header)" class="hover:text-brand-primary transition-colors"><i class="fa-brands fa-linkedin-in text-sm"></i></a>
                <?php endif; ?>
                <?php if ($ig = setting('instagram_url')): ?>
                    <a href="<?= e($ig) ?>" target="_blank" class="hover:text-brand-primary transition-colors"><i class="fa-brands fa-instagram text-sm"></i></a>
                <?php endif; ?>
                <?php if ($wa = setting('whatsapp_number')): ?>
                    <a href="https://wa.me/<?= e(str_replace(['+', ' '], '', $wa)) ?>" target="_blank" data-track="SOCIAL" data-label="WhatsApp (Header)" class="hover:text-emerald-500 transition-colors"><i class="fa-brands fa-whatsapp text-sm"></i></a>
                <?php endif; ?>
            </div>
            
            <!-- Dark Mode Toggle -->
           <button onclick="toggleTheme()" 
                class="w-9 h-9 rounded-xl flex items-center justify-center 
                       bg-slate-50/50 dark:bg-white/5 border border-slate-100 dark:border-white/10
                       hover:scale-105 transition-all duration-300">
                <i class="fa-solid fa-moon dark:hidden text-brand-navy"></i>
                <i class="fa-solid fa-sun hidden dark:inline text-brand-accent"></i>
            </button>

            <?php if (Auth::check()): ?>
                <a href="<?= url('dashboard') ?>" class="text-brand-primary">Console</a>
                <a href="<?= url('logout') ?>" class="text-rose-500 transition-colors">Sign Out</a>
            <?php else: ?>
                <div class="flex items-center gap-3">
                    <?php if (setting('show_estimator', '1') === '1'): ?>
                        <a href="<?= url('estimator.php') ?>" class="text-brand-accent hover:text-brand-primary transition-colors pr-2 border-r border-slate-200 dark:border-white/10">Estimator</a>
                    <?php endif; ?>
                    <button @click="modalOpen = true" data-track="CTA" data-label="Header_Connect_Now" class="bg-brand-primary text-white px-6 py-3 rounded-xl shadow-xl shadow-brand-primary/20 hover:bg-brand-primary/90 transition-all transform hover:-translate-y-0.5 active:translate-y-0 uppercase tracking-widest text-[10px]">
                        Connect Now
                    </button>
                </div>
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
<div id="mobileMenu" class="hidden md:hidden border-t dark:border-slate-800 bg-white dark:bg-brand-dark absolute w-full shadow-2xl transition-all duration-300">
        <!-- Grid Background inside mobile menu -->
        <div class="absolute inset-0 opacity-[0.03] dark:opacity-10 pointer-events-none -z-10 overflow-hidden">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <rect width="100%" height="100%" fill="url(#grid-header)" />
            </svg>
        </div>
        
        <nav class="flex flex-col px-8 py-10 space-y-6 text-[11px] font-bold uppercase tracking-[0.2em]">
            <a href="<?= url('') ?>" class="text-heading hover:text-brand-primary transition-colors">Home</a>
            <a href="<?= url('services.php') ?>" class="text-heading hover:text-brand-primary transition-colors">Services & Process</a>
            <a href="<?= url('works.php') ?>" class="text-heading hover:text-brand-primary transition-colors">Portfolio</a>
            <?php if (setting('show_estimator', '1') === '1'): ?>
                <a href="<?= url('estimator.php') ?>" class="text-brand-accent hover:text-brand-primary transition-colors">Project Estimator</a>
            <?php endif; ?>
            <a href="<?= url('index.php#testimonials') ?>" class="text-heading hover:text-brand-primary transition-colors">Reviews</a>

            
            <div class="pt-6 border-t dark:border-slate-800 space-y-6">
                <!-- Social Links in Mobile -->
                <div class="flex items-center gap-6 text-slate-400">
                    <?php if ($fb = setting('facebook_url')): ?>
                        <a href="<?= e($fb) ?>" target="_blank" class="hover:text-brand-primary transition-colors"><i class="fa-brands fa-facebook-f text-lg"></i></a>
                    <?php endif; ?>
                    <?php if ($li = setting('linkedin_url')): ?>
                        <a href="<?= e($li) ?>" target="_blank" class="hover:text-brand-primary transition-colors"><i class="fa-brands fa-linkedin-in text-lg"></i></a>
                    <?php endif; ?>
                    <?php if ($wa = setting('whatsapp_number')): ?>
                        <a href="https://wa.me/<?= e(str_replace(['+', ' '], '', $wa)) ?>" target="_blank" class="hover:text-emerald-500 transition-colors"><i class="fa-brands fa-whatsapp text-lg"></i></a>
                    <?php endif; ?>
                </div>

                <?php if (Auth::check()): ?>
                    <a href="<?= url('dashboard') ?>" class="block text-brand-primary">Console Dashboard</a>
                    <a href="<?= url('logout') ?>" class="block text-rose-500">Sign Out</a>
                <?php else: ?>
                    <button @click="modalOpen = true" class="inline-block w-full text-center bg-brand-primary text-white py-4 rounded-xl shadow-lg shadow-brand-primary/20">
                        Get in Touch
                    </button>
                <?php endif; ?>
            </div>
        </nav>
    </div>
</header>
<!-- Spacer for fixed header -->
<div class="<?= (Auth::check() && setting('maintenance_mode') === '1') 
    ? 'h-[105px]' 
    : 'h-[73px]' ?>">
</div>
<script>
const btn = document.getElementById('menuBtn');
if (btn) {
    btn.onclick = () => {
        document.getElementById('mobileMenu').classList.toggle('hidden');
    };
}
</script>


<main>
