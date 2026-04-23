<?php
// app/views/components/preloader.php
// Debug: Setting is '<?= setting('show_preloader', '0') ?>'
if (setting('show_preloader', '0') != '1') return;
?>

<div id="premium-preloader" class="fixed inset-0 z-[10000] flex items-center justify-center bg-white dark:bg-brand-dark transition-all duration-1000 ease-in-out">
    <!-- Grid Background -->
    <div class="absolute inset-0 opacity-[0.03] dark:opacity-5 pointer-events-none overflow-hidden">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="grid-preloader" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="currentColor" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid-preloader)" />
        </svg>
    </div>

    <div class="relative flex flex-col items-center">
        <!-- Logo Animation Container -->
        <div class="relative w-24 h-24 mb-6 preloader-logo-container">
            <!-- Animated Background Circles -->
            <div class="absolute inset-0 rounded-full bg-brand-primary/10 animate-ping duration-[3s]"></div>
            <div class="absolute inset-0 rounded-full border border-brand-primary/20 animate-pulse duration-[2s]"></div>
            
            <!-- Logo Content -->
            <div class="relative w-full h-full flex items-center justify-center">
                <?php if ($logo = setting('site_thumbnail')): ?>
                    <img src="<?= url('public/uploads/' . $logo) ?>" class="w-16 h-16 object-contain relative z-10 animate-bounce-slow">
                <?php else: ?>
                    <div class="w-16 h-16 bg-brand-primary rounded-2xl rotate-3 shadow-2xl shadow-brand-primary/40 flex items-center justify-center border border-white/10 animate-bounce-slow">
                        <span class="font-display font-extrabold text-white text-3xl">N</span>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Progress Circle -->
            <svg class="absolute -inset-4 w-[calc(100%+32px)] h-[calc(100%+32px)] -rotate-90">
                <circle 
                    cx="50%" cy="50%" r="48%" 
                    fill="none" 
                    stroke="currentColor" 
                    stroke-width="1" 
                    class="text-slate-100 dark:text-white/5"
                />
                <circle 
                    id="preloader-progress-circle"
                    cx="50%" cy="50%" r="48%" 
                    fill="none" 
                    stroke="var(--brand-primary)" 
                    stroke-width="2" 
                    stroke-dasharray="300" 
                    stroke-dashoffset="300"
                    stroke-linecap="round"
                    class="transition-all duration-300 ease-out"
                />
            </svg>
        </div>

        <!-- Text Content -->
        <div class="text-center overflow-hidden">
            <h2 class="font-display font-bold text-xl text-brand-navy dark:text-white tracking-tight mb-1 preloader-text-reveal">
                <?= setting('site_title', 'Numinds Tech') ?>
            </h2>
            <div class="h-[1px] w-0 bg-gradient-to-right from-transparent via-brand-primary to-transparent mx-auto preloader-line-grow"></div>
            <p class="text-[10px] uppercase tracking-[0.4em] font-bold text-slate-400 mt-2 opacity-0 preloader-subtext-fade">
                Initializing Systems
            </p>
        </div>
    </div>
</div>

<style>
    @keyframes bounce-slow {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    .animate-bounce-slow {
        animation: bounce-slow 3s ease-in-out infinite;
    }

    .preloader-text-reveal {
        animation: textReveal 1s cubic-bezier(0.77, 0, 0.175, 1) forwards;
        transform: translateY(100%);
    }

    .preloader-line-grow {
        animation: lineGrow 1.5s ease-in-out forwards;
        animation-delay: 0.5s;
    }

    .preloader-subtext-fade {
        animation: fadeIn 1s ease-out forwards;
        animation-delay: 1s;
    }

    @keyframes textReveal {
        to { transform: translateY(0); }
    }

    @keyframes lineGrow {
        to { width: 100%; }
    }

    @keyframes fadeIn {
        to { opacity: 1; }
    }

    body.preloader-active {
        overflow: hidden;
    }

    #premium-preloader.fade-out {
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transform: scale(1.1);
    }
</style>

<script>
    document.body.classList.add('preloader-active');
    
    const finishLoading = () => {
        const circle = document.getElementById('preloader-progress-circle');
        if (circle) {
           circle.style.strokeDashoffset = "0";
        }

        setTimeout(() => {
            const preloader = document.getElementById('premium-preloader');
            if (preloader) {
                preloader.classList.add('fade-out');
                document.body.classList.remove('preloader-active');
            }
        }, 1500); // Minimum view time for premium feel
    };

    if (document.readyState === 'complete') {
        finishLoading();
    } else {
        window.addEventListener('load', finishLoading);
    }

    // Fallback if load event takes too long
    setTimeout(() => {
        const preloader = document.getElementById('premium-preloader');
        if (preloader && !preloader.classList.contains('fade-out')) {
            preloader.classList.add('fade-out');
            document.body.classList.remove('preloader-active');
        }
    }, 5000);
</script>
