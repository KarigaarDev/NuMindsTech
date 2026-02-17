<?php
use UI\Component;

$headers = ['Identity', 'Access Control', 'Status', 'Activity', 'Actions'];
$rows = [];

foreach ($users as $user) {
    $statusType = $user['status'] === 'active' ? 'success' : 'neutral';
    $roleType = $user['role'] === 'admin' ? 'primary' : 'secondary';
    
    $rows[] = [
        '<div class="flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-brand-primary/10 flex items-center justify-center text-brand-primary font-bold text-sm border border-brand-primary/20">
                ' . strtoupper(substr($user['name'], 0, 1)) . '
            </div>
            <div>
                <p class="font-display font-bold text-brand-secondary dark:text-white text-base leading-tight">' . e($user['name']) . '</p>
                <p class="text-[10px] text-slate-500 font-medium">' . e($user['email']) . '</p>
            </div>
        </div>',
        '<div class="space-y-1">
            ' . Component::badge(strtoupper($user['role']), 'neutral') . '
            ' . ($user['id'] == Auth::userId() ? '<br>' . Component::badge('Self', 'success') : '') . '
        </div>',
        Component::badge(ucfirst($user['status']), $statusType),
        '<div>
            <p class="text-[10px] text-slate-400 dark:text-slate-600 font-bold uppercase tracking-widest mb-1">Created: ' . date('M d, Y', strtotime($user['created_at'])) . '</p>
            <p class="text-[10px] text-slate-500 font-medium">' . ($user['last_login'] ? 'Active: ' . date('M d, H:i', strtotime($user['last_login'])) . ' <span class="text-slate-400 opacity-50">(' . e($user['login_ip'] ?? 'Local') . ')</span>' : 'Never active') . '</p>
        </div>',
        '<div class="flex justify-end gap-2">
            <a href="' . url('users?edit=' . $user['id']) . '" class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-white/5 text-slate-500 hover:bg-brand-primary hover:text-white transition-all flex items-center justify-center border border-slate-200 dark:border-white/10">
                <i class="fa-solid fa-pen-to-square text-sm"></i>
            </a>
            ' . ($user['id'] != Auth::userId() ? '
            <form method="post" onsubmit="return confirm(\'Revoke access for this administrator?\');">
                ' . csrf_field() . '
                <input type="hidden" name="id" value="' . $user['id'] . '">
                <button name="delete_user" class="w-10 h-10 rounded-xl bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white transition-all flex items-center justify-center border border-red-500/10">
                    <i class="fa-solid fa-trash-can text-sm"></i>
                </button>
            </form>' : '') . '
        </div>'
    ];
}
?>

<div class="animate-in fade-in slide-in-from-bottom-4 duration-500">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
        <div>
            <h2 class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-primary mb-3">Identity Center</h2>
            <h1 class="font-display text-4xl font-extrabold text-brand-secondary dark:text-white mb-2 tracking-tight">User Management</h1>
            <p class="text-slate-500 dark:text-slate-400 font-medium">Manage administrative access and user credentials.</p>
        </div>
        
        <div class="flex flex-col items-end gap-3">
             <?php if ($message): ?>
                <?= Component::badge($message, 'success') ?>
            <?php endif; ?>
            <?php if ($error): ?>
                <?= Component::badge($error, 'danger') ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-12">
        
        <!-- USER FORM (ADD/EDIT) -->
        <div class="lg:col-span-1">
            <div class="sticky top-12">
                <?php if ($editingUser): ?>
                    <?= Component::card('
                        <form method="post" class="space-y-6">
                            ' . csrf_field() . '
                            <input type="hidden" name="id" value="' . $editingUser['id'] . '">
                            ' . Component::input('name', 'Full Name', $editingUser['name'], 'text', 'Display Name') . '
                            ' . Component::input('email', 'Email Address', $editingUser['email'], 'email', 'admin@domain.com') . '
                            ' . Component::input('password', 'Set New Password', '', 'password', 'Leave blank to keep current') . '
                            
                            <div class="grid grid-cols-2 gap-4">
                                ' . Component::select('role', 'Account Role', ['admin' => 'Administrator', 'editor' => 'Editor'], $editingUser['role']) . '
                                ' . Component::select('status', 'Status', ['active' => 'Active', 'suspended' => 'Suspended'], $editingUser['status']) . '
                            </div>

                            <div class="pt-4 flex flex-col gap-3">
                                ' . Component::button('Apply Variations', 'submit', 'primary', 'name="edit_user" class="w-full"') . '
                                <a href="' . url('users') . '" class="text-center text-[10px] font-bold uppercase tracking-widest text-slate-500 hover:text-brand-navy dark:hover:text-white transition-colors">Abort Modifications</a>
                            </div>
                        </form>
                    ', 'Edit Member', 'fa-user-pen') ?>
                <?php else: ?>
                    <?= Component::card('
                        <form method="post" class="space-y-6">
                            ' . csrf_field() . '
                            ' . Component::input('name', 'Full Name', '', 'text', 'Display Name') . '
                            ' . Component::input('email', 'Email Address', '', 'email', 'admin@domain.com') . '
                            ' . Component::input('password', 'Secure Password', '', 'password', '••••••••') . '
                            
                            <div class="grid grid-cols-2 gap-4">
                                ' . Component::select('role', 'Account Role', ['admin' => 'Administrator', 'editor' => 'Editor'], 'admin') . '
                                ' . Component::select('status', 'Status', ['active' => 'Active', 'suspended' => 'Suspended'], 'active') . '
                            </div>

                            <div class="pt-4">
                                ' . Component::button('Provision Account', 'submit', 'primary', 'name="add_user" class="w-full"') . '
                            </div>
                        </form>
                    ', 'New Admin', 'fa-user-plus') ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- USERS LIST -->
        <div class="lg:col-span-2">
            <?= Component::table($headers, $rows) ?>
        </div>
    </div>
</div>
