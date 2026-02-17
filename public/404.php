<?php
require_once __DIR__ . '/../app/config/db.php';
require_once __DIR__ . '/../app/core/helpers.php';

// Prepare Site (Handled by helpers.php if $pdo is set)
// This ensures we have site_title, etc. if needed
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>404 - Page Not Found | <?= setting('site_title', 'NuMinds Tech') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Outfit:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'], display: ['Outfit', 'sans-serif'] },
                    colors: { brand: { primary: '#2563eb', secondary: '#0f172a', navy: '#1e293b', accent: '#06b6d4' } }
                }
            }
        }
    </script>
</head>
<body class="bg-brand-secondary text-white font-sans overflow-hidden h-screen flex items-center justify-center p-8">
    
    <!-- Background Grid -->
    <div class="absolute inset-0 opacity-10 pointer-exists-none">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid)" />
        </svg>
    </div>

    <div class="max-w-xl text-center relative z-10">
        <div class="relative inline-block mb-10">
            <div class="text-[12rem] font-display font-extrabold leading-none opacity-5 select-none">404</div>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="w-24 h-24 bg-brand-primary/20 text-brand-primary rounded-[2.5rem] flex items-center justify-center border border-brand-primary/30 shadow-2xl shadow-brand-primary/10 rotate-12">
                    <i class="fa-solid fa-compass-slash text-4xl animate-bounce"></i>
                </div>
            </div>
        </div>
        
        <h1 class="font-display text-5xl font-extrabold mb-6 tracking-tight">Signal <span class="text-brand-primary">Lost</span> In Space</h1>
        <p class="text-slate-400 text-lg leading-relaxed mb-12">
            The page you are looking for has been moved or exists in an alternate dimension. Let's get you back on course.
        </p>
        
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="<?= url('') ?>" class="w-full sm:w-auto px-10 py-4 bg-brand-primary hover:bg-brand-primary/90 text-white rounded-2xl font-display font-bold text-[11px] uppercase tracking-widest transition-all shadow-lg shadow-brand-primary/20 hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2">
                <i class="fa-solid fa-house"></i> Return Home
            </a>
            <a href="javascript:history.back()" class="w-full sm:w-auto px-10 py-4 bg-white/5 hover:bg-white/10 text-white rounded-2xl font-display font-bold text-[11px] uppercase tracking-widest transition-all border border-white/10 flex items-center justify-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Go Back
            </a>
        </div>
    </div>

    <!-- Floating UI Decorations -->
    <div class="absolute top-[10%] left-[10%] w-32 h-32 bg-brand-primary/10 rounded-full blur-[60px] animate-pulse"></div>
    <div class="absolute bottom-[10%] right-[10%] w-32 h-32 bg-brand-accent/10 rounded-full blur-[60px] animate-pulse"></div>

</body>
</html>
