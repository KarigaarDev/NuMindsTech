<?php
$current = basename($_SERVER['PHP_SELF'], '.php');
?>
<aside class="w-72 glass-sidebar h-full flex flex-col transition-all">
    
    <!-- Branding -->
    <div class="p-10 pb-6">
        <?php if (setting('maintenance_mode') === '1'): ?>
            <div class="absolute top-4 right-4 animate-pulse">
                <span class="bg-rose-500/10 text-rose-500 text-[8px] font-bold uppercase tracking-widest px-3 py-1 rounded-full border border-rose-500/20">
                    Maintenance Active
                </span>
            </div>
        <?php endif; ?>
        <a href="<?= url('') ?>" class="flex items-center gap-4 group">
            <div class="relative w-10 h-10 flex items-center justify-center">
                <?php if ($logo = setting('site_thumbnail')): ?>
                    <img src="<?= url('public/uploads/' . $logo) ?>" class="w-10 h-10 object-contain relative z-10 transition-transform group-hover:scale-110">
                <?php else: ?>
                    <div class="absolute inset-0 bg-brand-primary rounded-xl rotate-3 group-hover:rotate-6 transition-transform shadow-lg shadow-brand-primary/20"></div>
                    <div class="absolute inset-0 bg-brand-secondary rounded-xl -rotate-3 group-hover:-rotate-6 transition-transform"></div>
                    <span class="relative font-display font-extrabold text-white text-xl">N</span>
                <?php endif; ?>
            </div>
            <div class="flex flex-col leading-none">
                <span class="font-display font-bold text-lg text-white tracking-tight">
                    <?php if (setting('site_title')): ?>
                        <?= e(setting('site_title')) ?>
                    <?php else: ?>
                        NuMinds <span class="text-brand-accent italic">Tech</span>
                    <?php endif; ?>
                </span>
                <span class="text-[8px] uppercase tracking-[0.4em] font-bold text-slate-500 mt-1">Console</span>
            </div>
        </a>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-8 py-10 space-y-2 overflow-y-auto no-scrollbar">
        
        <?php if (Auth::isAdmin()): ?>
            <p class="px-4 text-[9px] font-bold text-slate-600 uppercase tracking-[0.4em] mb-4">Main</p>
            
            <a href="<?= url('dashboard') ?>" 
               class="flex items-center gap-4 px-5 py-4 text-[10px] font-bold uppercase tracking-[0.2em] transition-all rounded-2xl <?= $current === 'dashboard' ? 'bg-brand-primary text-white shadow-xl shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-white/5' ?>">
                <i class="fa-solid fa-gauge-high w-5 text-center text-sm"></i>
                Overview
            </a>

            <a href="<?= url('admin/analytics.php') ?>" 
               class="flex items-center gap-4 px-5 py-4 text-[10px] font-bold uppercase tracking-[0.2em] transition-all rounded-2xl <?= $current === 'analytics' ? 'bg-brand-primary text-white shadow-xl shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-white/5' ?>">
                <i class="fa-solid fa-chart-line w-5 text-center text-sm"></i>
                Analytics
            </a>

            <a href="<?= url('items') ?>" 
               class="flex items-center gap-4 px-5 py-4 text-[10px] font-bold uppercase tracking-[0.2em] transition-all rounded-2xl <?= $current === 'items' ? 'bg-brand-primary text-white shadow-xl shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-white/5' ?>">
                <i class="fa-solid fa-briefcase w-5 text-center text-sm"></i>
                Items
            </a>
            
            <a href="<?= url('portfolio') ?>" 
               class="flex items-center gap-4 px-5 py-4 text-[10px] font-bold uppercase tracking-[0.2em] transition-all rounded-2xl <?= $current === 'portfolio' ? 'bg-brand-primary text-white shadow-xl shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-white/5' ?>">
                <i class="fa-solid fa-images w-5 text-center text-sm"></i>
                Portfolio
            </a>

            <a href="<?= url('admin/clients.php') ?>" 
               class="flex items-center gap-4 px-5 py-4 text-[10px] font-bold uppercase tracking-[0.2em] transition-all rounded-2xl <?= $current === 'clients' ? 'bg-brand-primary text-white shadow-xl shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-white/5' ?>">
                <i class="fa-solid fa-handshake w-5 text-center text-sm"></i>
                Clients
            </a>

            <a href="<?= url('admin/leads') ?>" 
               class="flex items-center gap-4 px-5 py-4 text-[10px] font-bold uppercase tracking-[0.2em] transition-all rounded-2xl <?= in_array($current, ['leads', 'lead-view']) ? 'bg-brand-primary text-white shadow-xl shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-white/5' ?>">
                <i class="fa-solid fa-envelope-open-text w-5 text-center text-sm"></i>
                Leads
            </a>

            <a href="<?= url('admin/testimonials') ?>" 
               class="flex items-center gap-4 px-5 py-4 text-[10px] font-bold uppercase tracking-[0.2em] transition-all rounded-2xl <?= $current === 'testimonials' ? 'bg-brand-primary text-white shadow-xl shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-white/5' ?>">
                <i class="fa-solid fa-comment-dots w-5 text-center text-sm"></i>
                Testimonials
            </a>

            <p class="px-4 text-[9px] font-bold text-slate-600 uppercase tracking-[0.4em] mt-10 mb-4">System</p>

            <a href="<?= url('users') ?>" 
               class="flex items-center gap-4 px-5 py-4 text-[10px] font-bold uppercase tracking-[0.2em] transition-all rounded-2xl <?= $current === 'users' ? 'bg-brand-primary text-white shadow-xl shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-white/5' ?>">
                <i class="fa-solid fa-user-gear w-5 text-center text-sm"></i>
                Team
            </a>

            <a href="<?= url('admin/themes.php') ?>" 
               class="flex items-center gap-4 px-5 py-4 text-[10px] font-bold uppercase tracking-[0.2em] transition-all rounded-2xl <?= $current === 'themes' ? 'bg-brand-primary text-white shadow-xl shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-white/5' ?>">
                <i class="fa-solid fa-paintbrush w-5 text-center text-sm"></i>
                Appearance
            </a>

            <a href="<?= url('admin/logs.php') ?>" 
               class="flex items-center gap-4 px-5 py-4 text-[10px] font-bold uppercase tracking-[0.2em] transition-all rounded-2xl <?= $current === 'logs' ? 'bg-brand-primary text-white shadow-xl shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-white/5' ?>">
                <i class="fa-solid fa-list-check w-5 text-center text-sm"></i>
                Audit Logs
            </a>

            <a href="<?= url('settings') ?>" 
               class="flex items-center gap-4 px-5 py-4 text-[10px] font-bold uppercase tracking-[0.2em] transition-all rounded-2xl <?= $current === 'settings' ? 'bg-brand-primary text-white shadow-xl shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-white/5' ?>">
                <i class="fa-solid fa-gear w-5 text-center text-sm"></i>
                Settings
            </a>

        <?php else: ?>
            <p class="px-4 text-[9px] font-bold text-slate-600 uppercase tracking-[0.4em] mb-4">Account</p>
            
            <a href="<?= url('client-dashboard') ?>" 
               class="flex items-center gap-4 px-5 py-4 text-[10px] font-bold uppercase tracking-[0.2em] transition-all rounded-2xl <?= $current === 'client-dashboard' ? 'bg-brand-primary text-white shadow-xl shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-white/5' ?>">
                <i class="fa-solid fa-shapes w-5 text-center text-sm"></i>
                My Portal
            </a>
            
            <a href="<?= url('billing') ?>" 
               class="flex items-center gap-4 px-5 py-4 text-[10px] font-bold uppercase tracking-[0.2em] transition-all rounded-2xl <?= $current === 'billing' ? 'bg-brand-primary text-white shadow-xl shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-white/5' ?>">
                <i class="fa-solid fa-file-invoice-dollar w-5 text-center text-sm"></i>
                Billing
            </a>
        <?php endif; ?>

    </nav>

    <!-- Footer -->
    <div class="p-8 space-y-4">
        <button onclick="toggleTheme()" class="w-full flex items-center justify-between px-5 py-4 rounded-2xl bg-white/5 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400 hover:text-brand-accent transition-all group">
             <span class="flex items-center gap-3">
                <i class="fa-solid fa-moon group-hover:rotate-12 transition-transform"></i>
                Appearance
             </span>
             <i class="fa-solid fa-chevron-right text-[8px] opacity-0 group-hover:opacity-100 transition-all"></i>
        </button>

        <a href="<?= url('profile') ?>" 
           class="w-full flex items-center justify-between px-5 py-4 rounded-2xl bg-white/5 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400 hover:text-white transition-all group <?= $current === 'profile' ? 'bg-brand-primary !text-white' : '' ?>">
             <span class="flex items-center gap-3">
                <i class="fa-solid fa-user-circle group-hover:rotate-12 transition-transform"></i>
                My Profile
             </span>
             <i class="fa-solid fa-chevron-right text-[8px] opacity-0 group-hover:opacity-100 transition-all"></i>
        </a>

        <a href="<?= url('logout') ?>" 
           class="flex items-center gap-4 px-5 py-4 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500 hover:text-rose-400 transition-all group rounded-2xl hover:bg-rose-500/5">
            <i class="fa-solid fa-arrow-right-from-bracket w-5 text-center text-sm group-hover:translate-x-1 transition-transform"></i>
            Sign Out
        </a>
    </div>
</aside>

