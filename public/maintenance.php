<?php
require '../app/config/db.php';
require '../app/core/helpers.php';

// Prepare Site
getSiteSettings($pdo);

// Check if maintenance is actually on
if (setting('maintenance_mode') !== '1') {
    redirect('');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Scheduled Maintenance | NuMinds Tech</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Outfit:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'], display: ['Outfit', 'sans-serif'] },
                    colors: { brand: { primary: '#2563eb', secondary: '#0f172a', navy: '#1e293b' } }
                }
            }
        }
    </script>
</head>
<body class="bg-brand-secondary text-white font-sans overflow-hidden h-screen flex items-center justify-center p-8">
    
    <!-- Background Grid -->
    <div class="absolute inset-0 opacity-10 pointer-events-none">
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
            <div class="text-[12rem] font-display font-extrabold leading-none opacity-5 select-none">OFF</div>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="w-24 h-24 bg-brand-primary/20 text-brand-primary rounded-[2.5rem] flex items-center justify-center border border-brand-primary/30 shadow-2xl shadow-brand-primary/10 -rotate-12">
                    <i class="fa-solid fa-screwdriver-wrench text-4xl animate-pulse"></i>
                </div>
            </div>
        </div>
        
        <h1 class="font-display text-5xl font-extrabold mb-6 tracking-tight">System <span class="text-brand-primary">Optimization</span></h1>
        <p class="text-slate-400 text-lg leading-relaxed mb-12">
            We are currently refining our digital infrastructure to bring you a more powerful experience. Public access is temporarily restricted.
        </p>
        
        <div class="p-8 bg-brand-navy/50 border border-white/5 rounded-[2.5rem] inline-flex items-center gap-6 shadow-xl">
            <div class="text-left leading-tight">
                <p class="text-[9px] font-bold uppercase tracking-[0.3em] text-brand-primary mb-1">Administrative Node</p>
                <p class="text-sm font-bold text-white tracking-tight">Authorized Personnel Only</p>
            </div>
            <a href="<?= url('login') ?>" class="px-7 py-3.5 bg-white/5 hover:bg-white/10 rounded-xl transition-all font-display font-bold text-[10px] uppercase tracking-widest border border-white/10 flex items-center gap-2">
                <i class="fa-solid fa-shield-halved text-brand-primary"></i> Team Login
            </a>
        </div>
    </div>

    <!-- Floating Atoms -->
    <div class="absolute top-1/4 left-1/4 w-2 h-2 bg-brand-primary rounded-full blur-[1px] opacity-20"></div>
    <div class="absolute bottom-1/4 right-1/4 w-3 h-3 bg-brand-accent rounded-full blur-[2px] opacity-20"></div>

</body>
</html>
