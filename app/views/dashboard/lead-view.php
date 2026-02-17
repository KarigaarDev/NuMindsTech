<?php if (isset($_GET['updated'])): ?>
<div class="mb-6 bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-400 p-4 rounded-xl flex items-center gap-3 border border-green-100 dark:border-green-800 animate-in fade-in slide-in-from-top-4 duration-500">
    <i class="fa-solid fa-circle-check text-lg"></i>
    <span class="font-medium">Lead successfully updated!</span>
</div>
<?php endif; ?>

<!-- Header with Back Link -->
<div class="mb-8">
<!-- Header with Back Link -->
<div class="mb-12">
    <a href="<?= url('admin/leads') ?>" class="inline-flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-slate-500 hover:text-brand-primary transition-colors mb-6">
        <i class="fa-solid fa-chevron-left"></i> Registry
    </a>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-4 mb-2">
                <h1 class="font-display text-4xl font-extrabold text-brand-secondary dark:text-white tracking-tight"><?= e($lead['name']) ?></h1>
                <span class="px-3 py-1 rounded-lg text-[10px] font-bold bg-brand-primary/10 text-brand-primary border border-brand-primary/20">
                    ID: #<?= $lead['id'] ?>
                </span>
            </div>
            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 flex items-center gap-2">
                <i class="fa-regular fa-clock text-brand-primary"></i> 
                Inscribed on <?= date('F j, Y \a\t g:i A', strtotime($lead['created_at'])) ?>
            </p>
        </div>
        
        <div class="flex items-center gap-3">
            <a href="mailto:<?= e($lead['email']) ?>" class="bg-white dark:bg-brand-navy border border-slate-100 dark:border-white/5 text-slate-700 dark:text-slate-300 px-6 py-3 rounded-xl font-bold text-[10px] uppercase tracking-widest hover:border-brand-primary/30 transition-all shadow-sm">
                <i class="fa-solid fa-envelope mr-2 text-brand-primary"></i> Email
            </a>
            <?php if(!empty($lead['phone'])): ?>
            <a href="tel:<?= e($lead['phone']) ?>" class="bg-white dark:bg-brand-navy border border-slate-100 dark:border-white/5 text-slate-700 dark:text-slate-300 px-6 py-3 rounded-xl font-bold text-[10px] uppercase tracking-widest hover:border-brand-accent/30 transition-all shadow-sm">
                <i class="fa-solid fa-phone mr-2 text-brand-accent"></i> Call
            </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-10">
    
    <!-- Left Column: Details -->
    <div class="lg:col-span-2 space-y-10">
        
        <!-- Contact Info Card -->
        <div class="bg-white dark:bg-brand-navy rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-white/5 p-10 transition-colors">
            <h3 class="font-display text-xl font-bold text-brand-secondary dark:text-white mb-8 flex items-center gap-3">
                <i class="fa-regular fa-address-card text-brand-primary"></i> Communication Matrix
            </h3>
            
            <div class="grid sm:grid-cols-2 gap-8">
                <div class="p-6 rounded-2xl bg-slate-50 dark:bg-brand-dark/50 border border-slate-100 dark:border-white/5">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Electronic Mail</label>
                    <div class="font-bold text-brand-navy dark:text-slate-200 break-all"><?= e($lead['email'] ?: 'N/A') ?></div>
                </div>
                <div class="p-6 rounded-2xl bg-slate-50 dark:bg-brand-dark/50 border border-slate-100 dark:border-white/5">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Mobile Connection</label>
                    <div class="font-bold text-brand-navy dark:text-slate-200"><?= e($lead['phone'] ?: 'N/A') ?></div>
                </div>
                <div class="p-6 rounded-2xl bg-slate-50 dark:bg-brand-dark/50 border border-slate-100 dark:border-white/5">
                     <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">System Interest</label>
                     <div class="font-bold text-brand-primary flex items-center gap-2">
                         <i class="fa-solid fa-microchip"></i> <?= e($lead['service_type'] ?: 'General Inquiry') ?>
                     </div>
                </div>
                <div class="p-6 rounded-2xl bg-slate-50 dark:bg-brand-dark/50 border border-slate-100 dark:border-white/5">
                     <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Interaction Preference</label>
                     <div class="font-bold text-brand-navy dark:text-slate-200">
                         <?= e($lead['contact_method'] ?? 'Any') ?> 
                         <span class="text-slate-400 font-medium ml-2">@ <?= e($lead['contact_time'] ?? 'Any Time') ?></span>
                     </div>
                </div>
            </div>
        </div>

        <!-- Message Body -->
        <div class="bg-white dark:bg-brand-navy rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-white/5 p-10 transition-colors">
            <h3 class="font-display text-xl font-bold text-brand-secondary dark:text-white mb-6 flex items-center gap-3">
                <i class="fa-regular fa-comment-dots text-brand-accent"></i> Mission Overview
            </h3>
            <div class="bg-slate-50 dark:bg-brand-dark/50 p-8 rounded-2xl border border-slate-100 dark:border-white/5 text-slate-600 dark:text-slate-300 leading-relaxed whitespace-pre-line font-medium">
                <?= e($lead['message'] ?: 'No message content provided.') ?>
            </div>
        </div>

    </div>

    <!-- Right Column: Actions \u0026 Remarks -->
    <div class="space-y-10">
        
        <!-- Status Card -->
        <div class="bg-white dark:bg-brand-navy rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-white/5 p-10">
            <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-6">Current Lifecycle</h3>
            <div class="mb-10">
                 <span class="inline-flex items-center px-6 py-3 rounded-xl text-[10px] font-bold uppercase tracking-widest w-full justify-center
                    <?= $lead['status'] === 'New' ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/20' : 
                       ($lead['status'] === 'Contacted' ? 'bg-brand-accent text-brand-secondary shadow-lg shadow-brand-accent/20' : 'bg-slate-800 text-slate-400 border border-white/10') ?>">
                    <?= e($lead['status']) ?>
                </span>
            </div>
            
            <form action="<?= url('admin/lead-remark') ?>" method="POST" class="space-y-8">
                <?= csrf_field() ?>
                <input type="hidden" name="id" value="<?= $lead['id'] ?>">
                
                <div>
                    <h3 class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-3">Update Status</h3>
                    <select name="status" class="w-full bg-slate-50 dark:bg-brand-dark border-b-2 border-slate-200 dark:border-white/5 text-slate-700 dark:text-slate-200 p-4 focus:border-brand-primary focus:outline-none transition-all appearance-none cursor-pointer font-medium">
                        <option value="New" <?= $lead['status'] == 'New' ? 'selected' : '' ?>>New / Active</option>
                        <option value="Contacted" <?= $lead['status'] == 'Contacted' ? 'selected' : '' ?>>Contacted</option>
                        <option value="InProgress" <?= $lead['status'] == 'InProgress' ? 'selected' : '' ?>>In Progress</option>
                        <option value="Converted" <?= $lead['status'] == 'Converted' ? 'selected' : '' ?>>Converted</option>
                        <option value="Closed" <?= $lead['status'] == 'Closed' ? 'selected' : '' ?>>Closed</option>
                    </select>
                </div>

                <div>
                    <h3 class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-3">Internal Remarks</h3>
                    <textarea name="remarks" rows="6" 
                        class="w-full bg-brand-primary/[0.03] border-2 border-brand-primary/10 text-slate-700 dark:text-slate-300 p-6 rounded-2xl focus:border-brand-primary focus:outline-none placeholder:text-slate-400 transition-all resize-none font-medium"
                        placeholder="Establish internal notes..."><?= e($lead['remarks']) ?></textarea>
                </div>
                
                <button class="w-full bg-brand-primary text-white font-display font-extrabold py-5 rounded-2xl hover:shadow-2xl hover:shadow-brand-primary/40 transition-all text-[11px] uppercase tracking-[0.2em] active:scale-[0.98]">
                    Commit Updates
                </button>
            </form>
        </div>

    </div>
</div>


    </div>
</div>
