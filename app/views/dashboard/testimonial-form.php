<?php
use UI\Component;
?>

<div class="animate-in fade-in slide-in-from-bottom-4 duration-500">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
        <div>
            <h2 class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-primary mb-3">Content Forge</h2>
            <h1 class="font-display text-4xl font-extrabold text-brand-secondary dark:text-white mb-2 tracking-tight">
                <?= $testimonial ? 'Edit Praise' : 'New Testimonial' ?>
            </h1>
            <p class="text-slate-500 dark:text-slate-400 font-medium italic">Shape the stories that build trust with your audience.</p>
        </div>
        
        <a href="<?= url('admin/testimonials') ?>" class="inline-flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-slate-400 hover:text-brand-primary transition-colors group">
            <i class="fa-solid fa-arrow-left transition-transform group-hover:-translate-x-1"></i>
            Back to List
        </a>
    </div>

    <!-- Form -->
    <div class="max-w-4xl">
        <?= Component::card('
            <form method="POST" action="' . url('admin/testimonials') . '" enctype="multipart/form-data" class="space-y-8">
                ' . csrf_field() . '
                ' . ($testimonial ? '<input type="hidden" name="id" value="' . $testimonial['id'] . '">' : '') . '
                
                <div class="grid md:grid-cols-2 gap-10">
                    ' . Component::input('client_name', 'Client Name', $testimonial['client_name'] ?? '', 'text', 'e.g. John Doe') . '
                    ' . Component::input('client_position', 'Position / Company', $testimonial['client_position'] ?? '', 'text', 'e.g. CEO, TechCorp') . '
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400">Client Photo (Avatar)</label>
                    <div class="flex items-center gap-6">
                        ' . (isset($testimonial['avatar']) && $testimonial['avatar'] ? '<img src="'.url('public/uploads/'.$testimonial['avatar']).'" class="w-16 h-16 rounded-full object-cover border border-slate-200 dark:border-white/10">' : '<div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-white/5 flex items-center justify-center text-slate-400"><i class="fa-solid fa-user text-xl"></i></div>') . '
                        <input type="file" name="avatar" accept="image/*" class="text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-brand-primary/10 file:text-brand-primary hover:file:bg-brand-primary/20">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400">The Praise (Content)</label>
                    <textarea name="content" rows="5" required class="w-full bg-slate-50 dark:bg-brand-secondary/50 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-brand-primary/50 transition-colors dark:text-white font-medium resize-none" placeholder="What did they say about your work?">' . e($testimonial['content'] ?? '') . '</textarea>
                </div>

                <div class="grid md:grid-cols-2 gap-10">
                    ' . Component::input('display_order', 'Sort Order', $testimonial['display_order'] ?? '0', 'number', '0') . '
                    <div class="space-y-2">
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400">Visibility Status</label>
                        <select name="status" class="w-full bg-slate-50 dark:bg-brand-secondary/50 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-brand-primary/50 transition-colors dark:text-white font-medium">
                            <option value="active" ' . (($testimonial['status'] ?? 'active') === 'active' ? 'selected' : '') . '>Active & Visible</option>
                            <option value="hidden" ' . (($testimonial['status'] ?? '') === 'hidden' ? 'selected' : '') . '>Hidden / Archived</option>
                        </select>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 dark:border-white/5 flex justify-end">
                    ' . Component::button($testimonial ? 'Update Testimonial' : 'Publish Testimonial', 'submit', 'primary', 'class="px-12"') . '
                </div>
            </form>
        ', 'Testimonial Details', 'fa-quote-right') ?>
    </div>
</div>
