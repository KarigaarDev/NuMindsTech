<?php
if (isset($pdo)) {
    getSiteSettings($pdo);
}
require_once __DIR__ . '../../../core/helpers.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'NuMinds Console' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Fonts are now loaded dynamically via tailwind.php -->
    
    <!-- Icons: FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Charts: Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script src="https://cdn.tailwindcss.com"></script>
    <?php require __DIR__ . '/../../config/tailwind.php'; ?>
    <?php require_once __DIR__ . '/../../core/ui-components.php'; ?>
    <?php if ($thumb = setting('site_thumbnail')): ?>
    <link rel="shortcut icon" href="<?= url('/public/uploads/' . $thumb) ?>" type="image/png">
    <?php endif; ?>
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
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
    <style>
        <?php if (setting('show_grid_bg', '1') === '1'): ?>
        /* Global Grid Background for Admin Content/Main */
        main {
            position: relative;
        }
        main::before {
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
        .dark main::before {
            background-image: 
                linear-gradient(to right, rgba(255, 255, 255, 0.05) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
        }
        
        /* Ensure main content is above the grid */
        main > div {
            position: relative;
            z-index: 10;
        }
        <?php endif; ?>
    </style>
</head>

<body class="bg-slate-50 dark:bg-brand-secondary text-slate-900 dark:text-slate-200 font-sans antialiased transition-colors duration-300">

<div class="flex h-screen overflow-hidden">

    <!-- Mobile Sidebar Overlays -->
    <div id="mobileOverlay" class="fixed inset-0 bg-brand-secondary/90 z-40 hidden md:hidden transition-opacity" onclick="toggleSidebar()"></div>

    <!-- Sidebar Wrapper -->
    <div id="sidebarWrapper" class="fixed md:static inset-y-0 left-0 z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out border-r border-white/5 shadow-2xl md:shadow-none">
        <?php require 'sidebar.php'; ?>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        <!-- Topbar (Mobile Only Header) -->
        <header class="md:hidden flex items-center justify-between bg-brand-secondary border-b border-white/5 px-6 py-4">
            <div class="flex items-center gap-3">
                <?php if ($logo = setting('site_thumbnail')): ?>
                    <img src="<?= url('public/uploads/' . $logo) ?>" class="w-8 h-8 object-contain">
                <?php else: ?>
                    <div class="w-8 h-8 rounded-lg bg-brand-primary flex items-center justify-center text-white font-display font-extrabold text-sm">
                        N
                    </div>
                <?php endif; ?>
                <span class="font-display font-bold text-white tracking-tight">NuMinds <span class="text-brand-accent">Tech</span></span>
            </div>
            <div class="flex items-center gap-4">
                <button onclick="toggleSidebar()" class="text-white bg-white/5 w-10 h-10 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-bars-staggered"></i>
                </button>
            </div>
        </header>

        <!-- Main Scrollable Area -->
        <main class="flex-1 overflow-y-auto p-8 md:p-12 scroll-smooth">
            <div class="max-w-6xl mx-auto">
                <?php 
                // Use the view content captured by the controller
                if (isset($viewContent)) {
                    echo $viewContent;
                } else {
                    // Fallback for direct layout.php access
                    $page = basename($_SERVER['PHP_SELF'], '.php');
                    $file = __DIR__ . "/{$page}.php";
                    
                    if (file_exists($file)) {
                        require $file;
                    } else {
                        require 'home.php';
                    }
                }
                ?>
            </div>
        </main>

    </div>
</div>


<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebarWrapper');
        const overlay = document.getElementById('mobileOverlay');
        
        if (sidebar.classList.contains('-translate-x-full')) {
            // Open
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        } else {
            // Close
            sidebar.classList.add('-translate-x-full');
            setTimeout(() => {
                overlay.classList.add('hidden');
            }, 300); // Wait for transition
        }
    }
</script>

</body>
</html>
