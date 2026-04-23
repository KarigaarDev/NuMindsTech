<?php
// app/views/dashboard/profile.php
?>
<div class="space-y-10 pb-20">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h2 class="text-[10px] font-bold uppercase tracking-[0.4em] text-brand-primary mb-4">Account Settings</h2>
            <h3 class="font-display text-3xl md:text-5xl font-extrabold text-brand-secondary dark:text-inverse tracking-tight">
                Manage your <span class="bg-gradient-to-r from-brand-primary via-brand-accent to-brand-primary bg-[length:200%_auto] animate-gradient bg-clip-text text-transparent italic">profile</span> 👤
            </h3>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-4 max-w-xl">
                Update your personal information and security credentials to keep your account secure and up to date.
            </p>
        </div>
    </div>

    <!-- Feedback Messages -->
    <?php if (isset($_SESSION['flash_success'])): ?>
        <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-500 px-6 py-4 rounded-2xl flex items-center gap-4">
            <i class="fa-solid fa-circle-check"></i>
            <span class="text-sm font-bold uppercase tracking-widest"><?= $_SESSION['flash_success']; unset($_SESSION['flash_success']); ?></span>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['flash_error'])): ?>
        <div class="bg-rose-500/10 border border-rose-500/20 text-rose-500 px-6 py-4 rounded-2xl flex items-center gap-4">
            <i class="fa-solid fa-circle-exclamation"></i>
            <span class="text-sm font-bold uppercase tracking-widest"><?= $_SESSION['flash_error']; unset($_SESSION['flash_error']); ?></span>
        </div>
    <?php endif; ?>

    <div class="grid lg:grid-cols-12 gap-10">
        
        <!-- Left: Personal Info -->
        <div class="lg:col-span-7 space-y-10">
            <div class="bg-white dark:bg-white/5 border border-slate-100 dark:border-white/10 rounded-[2.5rem] p-8 md:p-12 shadow-xl shadow-slate-200/50 dark:shadow-none relative overflow-hidden">
                <div class="relative z-10">
                    <div class="flex items-center gap-4 mb-10">
                        <div class="w-12 h-12 rounded-2xl bg-brand-primary/10 flex items-center justify-center text-brand-primary">
                            <i class="fa-solid fa-user text-xl"></i>
                        </div>
                        <h4 class="font-display font-bold text-xl text-brand-secondary dark:text-white">Personal Information</h4>
                    </div>

                    <form action="<?= url('profile?action=update') ?>" method="POST" class="space-y-8">
                        <?= csrf_field() ?>
                        
                        <div class="grid md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400 px-4">Full Name</label>
                                <input type="text" name="name" value="<?= e($user['name']) ?>" required
                                    class="w-full bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-2xl px-6 py-4 text-sm focus:outline-none focus:border-brand-primary dark:text-white transition-all">
                                <?php if (isset($_SESSION['flash_errors']['name'])): ?>
                                    <p class="text-[10px] text-rose-500 font-bold uppercase px-4"><?= $_SESSION['flash_errors']['name'][0] ?></p>
                                <?php endif; ?>
                            </div>

                            <div class="space-y-2">
                                <label class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400 px-4">Email Address</label>
                                <input type="email" name="email" value="<?= e($user['email']) ?>" required
                                    class="w-full bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-2xl px-6 py-4 text-sm focus:outline-none focus:border-brand-primary dark:text-white transition-all">
                                <?php if (isset($_SESSION['flash_errors']['email'])): ?>
                                    <p class="text-[10px] text-rose-500 font-bold uppercase px-4"><?= $_SESSION['flash_errors']['email'][0] ?></p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="flex justify-end pt-4">
                            <button type="submit" class="bg-brand-primary text-white px-10 py-4 rounded-2xl font-bold uppercase tracking-widest text-[10px] shadow-lg shadow-brand-primary/25 hover:scale-105 transition-all">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right: Security -->
        <div class="lg:col-span-5 space-y-10">
            <div class="bg-white dark:bg-white/5 border border-slate-100 dark:border-white/10 rounded-[2.5rem] p-8 md:p-12 shadow-xl shadow-slate-200/50 dark:shadow-none relative overflow-hidden">
                <div class="relative z-10">
                    <div class="flex items-center gap-4 mb-10">
                        <div class="w-12 h-12 rounded-2xl bg-brand-accent/10 flex items-center justify-center text-brand-accent">
                            <i class="fa-solid fa-shield-halved text-xl"></i>
                        </div>
                        <h4 class="font-display font-bold text-xl text-brand-secondary dark:text-white">Security</h4>
                    </div>

                    <form action="<?= url('profile?action=password') ?>" method="POST" class="space-y-6">
                        <?= csrf_field() ?>

                        <div class="space-y-2">
                            <label class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400 px-4">Current Password</label>
                            <input type="password" name="current_password" required
                                class="w-full bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-2xl px-6 py-4 text-sm focus:outline-none focus:border-brand-primary dark:text-white transition-all">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400 px-4">New Password</label>
                            <input type="password" name="new_password" required
                                class="w-full bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-2xl px-6 py-4 text-sm focus:outline-none focus:border-brand-primary dark:text-white transition-all">
                            <?php if (isset($_SESSION['flash_errors']['new_password'])): ?>
                                <p class="text-[10px] text-rose-500 font-bold uppercase px-4"><?= $_SESSION['flash_errors']['new_password'][0] ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400 px-4">Confirm New Password</label>
                            <input type="password" name="confirm_password" required
                                class="w-full bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-2xl px-6 py-4 text-sm focus:outline-none focus:border-brand-primary dark:text-white transition-all">
                        </div>

                        <div class="flex justify-end pt-4">
                            <button type="submit" class="w-full bg-brand-secondary dark:bg-brand-primary text-white px-10 py-4 rounded-2xl font-bold uppercase tracking-widest text-[10px] shadow-lg hover:scale-105 transition-all">
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Quick Stats/Role Card -->
            <div class="bg-gradient-to-br from-brand-primary to-brand-accent p-8 md:p-10 rounded-[2.5rem] shadow-xl shadow-brand-primary/20 text-white">
                <div class="flex items-center justify-between mb-6">
                    <span class="text-[10px] font-bold uppercase tracking-[0.3em] opacity-80">Account Type</span>
                    <span class="bg-white/20 backdrop-blur-md text-[10px] font-bold uppercase tracking-widest px-4 py-1.5 rounded-full border border-white/30">
                        <?= ucfirst(Auth::role()) ?>
                    </span>
                </div>
                <div class="space-y-1">
                    <p class="text-2xl font-display font-extrabold leading-tight">NuMinds <span class="italic font-bold opacity-80">Tech</span> Partner</p>
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] opacity-60">Member since <?= date('M Y', strtotime($user['created_at'])) ?></p>
                </div>
            </div>
        </div>

    </div>

</div>

<?php 
// Clean up flash errors
unset($_SESSION['flash_errors']);
unset($_SESSION['flash_old']);
?>
