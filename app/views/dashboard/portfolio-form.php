<?php
use UI\Component;

$isEdit = isset($item) && $item;
$formAction = $isEdit ? "portfolio?action=update&id={$item['id']}" : 'portfolio?action=create';
?>

<div class="space-y-10 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <!-- Header -->
    <div class="flex items-center gap-4 mb-8">
        <a href="<?= url('portfolio') ?>" class="w-12 h-12 rounded-xl bg-slate-100 dark:bg-brand-secondary flex items-center justify-center text-slate-400 hover:text-brand-primary transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h2 class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-primary mb-1">Portfolio Management</h2>
            <h1 class="font-display text-3xl font-extrabold text-brand-secondary dark:text-white tracking-tight"><?= $isEdit ? 'Edit Project' : 'Add New Project' ?></h1>
        </div>
    </div>

    <!-- Form -->
    <form method="POST" action="<?= url($formAction) ?>" enctype="multipart/form-data" class="space-y-8">
        <?= csrf_field() ?>
        
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="md:col-span-2 space-y-8">
                <?= Component::card('
                    <div class="space-y-6">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400 mb-3">Project Title *</label>
                            ' . Component::input('title', '', $isEdit ? $item['title'] : '', 'text', 'Enter project name...') . '
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400 mb-3">Description</label>
                            <textarea name="description" rows="6" class="w-full px-6 py-4 bg-slate-50 dark:bg-brand-secondary border border-slate-100 dark:border-white/5 rounded-2xl text-brand-secondary dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-primary/20 transition-all font-medium" placeholder="Describe the project, technologies used, and key features...">' . ($isEdit ? e($item['description']) : '') . '</textarea>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400 mb-3">Client Name</label>
                            ' . Component::input('client_name', '', $isEdit ? $item['client_name'] : '', 'text', 'e.g., Acme Corporation') . '
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400 mb-3">Project URL</label>
                                ' . Component::input('project_url', '', $isEdit ? $item['project_url'] : '', 'url', 'https://example.com') . '
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400 mb-3">Completion Date</label>
                                ' . Component::input('completion_date', '', $isEdit ? $item['completion_date'] : '', 'date') . '
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400 mb-3">Tags (comma-separated)</label>
                            ' . Component::input('tags', '', $isEdit ? $item['tags'] : '', 'text', 'e.g., PHP, MySQL, Responsive') . '
                        </div>
                    </div>
                ', 'Project Details', 'fa-info-circle') ?>
                
                <?= Component::card('
                    <div class="space-y-6">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400 mb-3">Featured Image</label>
                            <input type="file" name="featured_image" accept="image/jpeg,image/png,image/webp" class="w-full px-6 py-4 bg-slate-50 dark:bg-brand-secondary border border-slate-100 dark:border-white/5 rounded-2xl text-brand-secondary dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:uppercase file:tracking-widest file:bg-brand-primary file:text-white hover:file:bg-brand-primary/90 transition-all">
                            <p class="text-[10px] text-slate-400 mt-2 font-medium">Recommended: 1200x900px, JPG/PNG/WebP, Max 5MB</p>
                        </div>
                        
                        ' . ($isEdit && $item['featured_image'] ? '
                        <div class="p-4 bg-slate-50 dark:bg-brand-secondary rounded-2xl border border-slate-100 dark:border-white/5">
                            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400 mb-3">Current Image</p>
                            <img src="' . url('public/uploads/' . $item['featured_image']) . '" class="w-full h-48 object-cover rounded-xl" alt="Current">
                        </div>
                        ' : '') . '
                    </div>
                ', 'Media', 'fa-image') ?>
            </div>
            
            <!-- Sidebar -->
            <div class="space-y-8">
                <?= Component::card('
                    <div class="space-y-6">
                        <div>
                            ' . Component::select('category', 'Category', [
                                'Web Design' => 'Web Design',
                                'E-commerce' => 'E-commerce',
                                'Custom Apps' => 'Custom Apps',
                                'Mobile Apps' => 'Mobile Apps',
                                'SEO & Marketing' => 'SEO & Marketing'
                            ], $isEdit ? $item['category'] : 'Web Design') . '
                        </div>
                        
                        <div>
                            ' . Component::select('status', 'Status', [
                                'draft' => 'Draft',
                                'published' => 'Published'
                            ], $isEdit ? $item['status'] : 'published') . '
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400 mb-3">Display Order</label>
                            ' . Component::input('display_order', '', $isEdit ? $item['display_order'] : '0', 'number', '0') . '
                            <p class="text-[10px] text-slate-400 mt-2 font-medium">Lower numbers appear first</p>
                        </div>
                        
                        <div class="pt-4 border-t border-slate-100 dark:border-white/5">
                            ' . Component::checkbox('is_featured', 'Featured Project', $isEdit ? $item['is_featured'] : false) . '
                            <p class="text-[10px] text-slate-400 mt-2 font-medium">Highlight on homepage</p>
                        </div>
                    </div>
                ', 'Settings', 'fa-cog') ?>
                
                <div class="space-y-4">
                    <?= Component::button($isEdit ? 'Update Project' : 'Create Project', 'submit', 'primary', 'class="w-full"') ?>
                    <a href="<?= url('portfolio') ?>" class="block text-center px-6 py-4 bg-slate-100 dark:bg-brand-secondary hover:bg-slate-200 dark:hover:bg-brand-navy text-slate-600 dark:text-slate-400 rounded-2xl font-display font-bold text-xs uppercase tracking-widest transition-all">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
