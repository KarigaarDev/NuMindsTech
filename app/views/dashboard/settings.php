<?php
use UI\Component;
?>
<div x-data="{ activeTab: 'general' }">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
        <div>
            <h2 class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-primary mb-3">Core Configuration</h2>
            <h1 class="font-display text-4xl font-extrabold text-brand-secondary dark:text-white mb-2 tracking-tight">Platform Settings</h1>
            <p class="text-slate-500 dark:text-slate-400 font-medium">Configure your digital presence and system behavior.</p>
        </div>
        
        <?php if ($message): ?>
            <?= Component::badge($message, 'success') ?>
        <?php endif; ?>
    </div>

    <!-- Tabs Navigation -->
    <div class="flex gap-2 mb-10 overflow-x-auto no-scrollbar">
        <button @click="activeTab = 'general'" :class="activeTab === 'general' ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/20' : 'bg-white dark:bg-brand-navy dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-white/5'" class="px-8 py-4 rounded-xl font-display font-bold text-[10px] uppercase tracking-widest transition-all border border-slate-100 dark:border-white/5 flex items-center gap-2 whitespace-nowrap">
            <i class="fa-solid fa-globe"></i> General
        </button>
        <button @click="activeTab = 'layout'" :class="activeTab === 'layout' ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/20' : 'bg-white dark:bg-brand-navy dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-white/5'" class="px-8 py-4 rounded-xl font-display font-bold text-[10px] uppercase tracking-widest transition-all border border-slate-100 dark:border-white/5 flex items-center gap-2 whitespace-nowrap">
            <i class="fa-solid fa-layer-group"></i> Layout
        </button>
        <button @click="activeTab = 'social'" :class="activeTab === 'social' ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/20' : 'bg-white dark:bg-brand-navy dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-white/5'" class="px-8 py-4 rounded-xl font-display font-bold text-[10px] uppercase tracking-widest transition-all border border-slate-100 dark:border-white/5 flex items-center gap-2 whitespace-nowrap">
            <i class="fa-solid fa-share-nodes"></i> Social
        </button>
        <button @click="activeTab = 'contact'" :class="activeTab === 'contact' ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/20' : 'bg-white dark:bg-brand-navy dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-white/5'" class="px-8 py-4 rounded-xl font-display font-bold text-[10px] uppercase tracking-widest transition-all border border-slate-100 dark:border-white/5 flex items-center gap-2 whitespace-nowrap">
            <i class="fa-solid fa-address-book"></i> Contact
        </button>
    </div>

    <form method="post" enctype="multipart/form-data" class="space-y-8 pb-20">
        <?= csrf_field() ?>

        <!-- GENERAL SETTINGS -->
        <div x-show="activeTab === 'general'" class="animate-in fade-in slide-in-from-bottom-4 duration-500">
            <?= Component::card('
                <div class="grid gap-10">
                    <div class="grid md:grid-cols-2 gap-10">
                        ' . Component::input('site_title', 'Application Title', $settings['site_title'] ?? '', 'text', 'Numinds Tech') . '
                        
                        <div class="space-y-4">
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400">Media Assets</label>
                            <div class="grid grid-cols-2 gap-4">
                                <!-- Logo Upload -->
                                <div class="relative group">
                                    <div class="aspect-square rounded-2xl bg-slate-50 dark:bg-white/5 border border-dashed border-slate-200 dark:border-white/10 flex flex-col items-center justify-center p-4 transition-all hover:border-brand-primary/50 overflow-hidden">
                                        ' . (isset($settings['site_logo']) ? '<img src="'.url('public/uploads/'.$settings['site_logo']).'" class="w-full h-full object-contain mb-2">' : '<i class="fa-solid fa-image text-slate-300 dark:text-slate-700 text-2xl mb-2"></i>') . '
                                        <span class="text-[8px] font-bold uppercase tracking-widest text-slate-400 group-hover:text-brand-primary">Logo</span>
                                        <input type="file" name="site_logo" class="absolute inset-0 opacity-0 cursor-pointer">
                                    </div>
                                </div>
                                <!-- Thumbnail Upload -->
                                <div class="relative group">
                                    <div class="aspect-square rounded-2xl bg-slate-50 dark:bg-white/5 border border-dashed border-slate-200 dark:border-white/10 flex flex-col items-center justify-center p-4 transition-all hover:border-brand-primary/50 overflow-hidden">
                                        ' . (isset($settings['site_thumbnail']) ? '<img src="'.url('public/uploads/'.$settings['site_thumbnail']).'" class="w-full h-full object-cover mb-2">' : '<i class="fa-solid fa-rectangle-ad text-slate-300 dark:text-slate-700 text-2xl mb-2"></i>') . '
                                        <span class="text-[8px] font-bold uppercase tracking-widest text-slate-400 group-hover:text-brand-primary">Thumb</span>
                                        <input type="file" name="site_thumbnail" class="absolute inset-0 opacity-0 cursor-pointer">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-2 mb-6">
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400">SEO Meta Description</label>
                        <textarea name="site_description" rows="3" class="w-full bg-slate-50 dark:bg-brand-secondary/50 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-brand-primary/50 transition-colors dark:text-white font-medium resize-none">' . e($settings['site_description'] ?? '') . '</textarea>
                    </div>

                    <div class="p-8 rounded-[2rem] bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10">
                        <div class="flex items-center justify-between">
                            <div class="flex gap-4 items-center">
                                <div class="w-12 h-12 rounded-2xl bg-brand-primary/10 text-brand-primary flex items-center justify-center border border-brand-primary/20">
                                    <i class="fa-solid fa-power-off"></i>
                                </div>
                                <div>
                                    <h4 class="font-display font-bold text-brand-secondary dark:text-white text-base">Maintenance Mode</h4>
                                    <p class="text-[10px] text-slate-500 dark:text-slate-400 font-medium tracking-wide">Restrict public access during updates.</p>
                                </div>
                            </div>
                            ' . Component::checkbox('maintenance_mode', 'Active', ($settings['maintenance_mode'] ?? '0') === '1') . '
                        </div>
                    </div>
                </div>
            ', 'Core Identity', 'fa-display') ?>
        </div>

        <!-- LAYOUT SETTINGS -->
        <div x-show="activeTab === 'layout'" class="animate-in fade-in slide-in-from-bottom-4 duration-500">
            <?= Component::card('
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                    ' . Component::checkbox('show_hero', 'Show Hero Section', ($settings['show_hero'] ?? '1') === '1') . '
                    ' . Component::checkbox('show_stats', 'Show Stats Counter', ($settings['show_stats'] ?? '1') === '1') . '
                    ' . Component::checkbox('show_problems', 'Show Our Approach (Problems)', ($settings['show_problems'] ?? '1') === '1') . '
                    ' . Component::checkbox('show_services', 'Show Services Grid', ($settings['show_services'] ?? '1') === '1') . '
                    ' . Component::checkbox('show_process', 'Show Our Process Step', ($settings['show_process'] ?? '1') === '1') . '
                    ' . Component::checkbox('show_portfolio', 'Show Portfolio Showcase', ($settings['show_portfolio'] ?? '1') === '1') . '
                    ' . Component::checkbox('show_testimonials', 'Show Client Praises', ($settings['show_testimonials'] ?? '1') === '1') . '
                    ' . Component::checkbox('show_blogs', 'Show Dev Diaries (Blog)', ($settings['show_blogs'] ?? '1') === '1') . '
                    ' . Component::checkbox('show_cta', 'Show Final CTA Section', ($settings['show_cta'] ?? '1') === '1') . '
                    ' . Component::checkbox('show_grid_bg', 'Global Grid Background', ($settings['show_grid_bg'] ?? '1') === '1') . '
                </div>
            ', 'Homepage Visibility Control', 'fa-layer-group') ?>
        </div>

        <!-- SOCIAL LINKS -->
        <div x-show="activeTab === 'social'" class="animate-in fade-in slide-in-from-bottom-4 duration-500">
            <?= Component::card('
                <div class="grid md:grid-cols-2 gap-x-8 gap-y-2">
                    ' . Component::input('facebook_url', 'Facebook URL', $settings['facebook_url'] ?? '', 'url', 'https://facebook.com/...') . '
                    ' . Component::input('twitter_url', 'Twitter / X URL', $settings['twitter_url'] ?? '', 'url', 'https://x.com/...') . '
                    ' . Component::input('instagram_url', 'Instagram URL', $settings['instagram_url'] ?? '', 'url', 'https://instagram.com/...') . '
                    ' . Component::input('linkedin_url', 'LinkedIn Profile', $settings['linkedin_url'] ?? '', 'url', 'https://linkedin.com/in/...') . '
                    ' . Component::input('whatsapp_number', 'WhatsApp Number', $settings['whatsapp_number'] ?? '', 'text', '+1234567890') . '
                </div>
            ', 'Social Integration', 'fa-share-nodes') ?>
        </div>

        <!-- CONTACT INFO -->
        <div x-show="activeTab === 'contact'" class="animate-in fade-in slide-in-from-bottom-4 duration-500">
            <?= Component::card('
                <div class="grid gap-6">
                    <div class="grid md:grid-cols-2 gap-8">
                        ' . Component::input('contact_email', 'Official Email', $settings['contact_email'] ?? '', 'email', 'hello@numinds.tech') . '
                        ' . Component::input('contact_phone', 'Public Phone', $settings['contact_phone'] ?? '', 'tel', '+1 234 567 890') . '
                    </div>
                    <div class="space-y-2 mb-6">
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400">HQ Address</label>
                        <textarea name="contact_address" rows="3" class="w-full bg-slate-50 dark:bg-brand-secondary/50 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-brand-primary/50 transition-colors dark:text-white font-medium resize-none">' . e($settings['contact_address'] ?? '') . '</textarea>
                    </div>
                </div>
            ', 'Strategic Locations', 'fa-map-location-dot') ?>
        </div>

        <!-- Submit Button Overlay -->
        <div class="fixed bottom-10 right-10 z-50">
            <?= Component::button('Commit Platform Update', 'submit', 'primary', 'name="save_settings"') ?>
        </div>
    </form>
</div>
