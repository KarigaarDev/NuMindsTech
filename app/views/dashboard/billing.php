<?php
use UI\Component;
?>
<div class="space-y-10 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <h2 class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-primary mb-3">Financial Overview</h2>
            <h1 class="font-display text-4xl font-extrabold text-brand-secondary dark:text-white mb-2 tracking-tight">Billing & Invoices</h1>
            <p class="text-slate-500 dark:text-slate-400 font-medium italic">Monitor your digital investments and account standing.</p>
        </div>
        
        <div class="flex gap-4">
            <div class="px-6 py-3 rounded-2xl bg-white dark:bg-brand-navy border border-slate-100 dark:border-white/5 flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-500 flex items-center justify-center">
                    <i class="fa-solid fa-file-invoice-dollar text-lg"></i>
                </div>
                <div>
                    <p class="text-[8px] font-bold uppercase tracking-widest text-slate-400">Next Payment</p>
                    <p class="text-sm font-bold dark:text-white">Feb 28, 2026</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Invoice Table -->
    <?= Component::card('
        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-left border-separate border-spacing-y-4">
                <thead>
                    <tr class="text-[9px] font-bold uppercase tracking-[0.2em] text-slate-400">
                        <th class="px-6 pb-2">Invoice #</th>
                        <th class="px-6 pb-2">Amount</th>
                        <th class="px-6 pb-2">Due Date</th>
                        <th class="px-6 pb-2">Status</th>
                        <th class="px-6 pb-2 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="space-y-4">
                    ' . (count($invoices) > 0 ? array_reduce($invoices, function($carry, $inv) {
                        $statusType = [
                            'paid' => 'success',
                            'unpaid' => 'warning',
                            'overdue' => 'danger',
                            'cancelled' => 'neutral'
                        ][$inv['status']] ?? 'neutral';

                        return $carry . '
                        <tr class="bg-slate-50 dark:bg-brand-secondary/30 rounded-2xl hover:bg-slate-100 dark:hover:bg-brand-secondary/50 transition-colors group">
                            <td class="px-6 py-5 first:rounded-l-2xl">
                                <span class="font-display font-bold text-brand-secondary dark:text-white">' . e($inv['invoice_number']) . '</span>
                            </td>
                            <td class="px-6 py-5">
                                <span class="font-display font-black text-brand-primary">$' . number_format($inv['amount'], 2) . '</span>
                            </td>
                            <td class="px-6 py-5">
                                <span class="text-xs font-medium text-slate-500 dark:text-slate-400">' . date('M d, Y', strtotime($inv['due_date'])) . '</span>
                            </td>
                            <td class="px-6 py-5">
                                ' . Component::badge(strtoupper($inv['status']), $statusType) . '
                            </td>
                            <td class="px-6 py-5 last:rounded-r-2xl text-right">
                                <button class="w-10 h-10 rounded-xl bg-white dark:bg-brand-navy border border-slate-200 dark:border-white/10 text-slate-400 hover:text-brand-primary hover:border-brand-primary/50 transition-all">
                                    <i class="fa-solid fa-download"></i>
                                </button>
                            </td>
                        </tr>';
                    }, '') : '<tr><td colspan="5" class="py-20 text-center text-slate-400 font-medium">No invoices found.</td></tr>') . '
                </tbody>
            </table>
        </div>
    ', 'Payment History', 'fa-receipt') ?>

    <!-- Helpful Tips -->
    <div class="grid md:grid-cols-2 gap-8">
        <div class="p-8 rounded-[2.5rem] bg-brand-primary/5 border border-brand-primary/10 flex gap-6">
            <div class="w-14 h-14 rounded-3xl bg-brand-primary/20 text-brand-primary flex items-center justify-center shrink-0">
                <i class="fa-solid fa-shield-check text-2xl"></i>
            </div>
            <div>
                <h4 class="font-display font-bold text-brand-secondary dark:text-white mb-2">Automated Billing</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed font-medium">Enable automatic credit card payments to ensure uninterrupted service across your digital assets.</p>
            </div>
        </div>
        <div class="p-8 rounded-[2.5rem] bg-amber-500/5 border border-amber-500/10 flex gap-6">
            <div class="w-14 h-14 rounded-3xl bg-amber-500/20 text-amber-500 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-headset text-2xl"></i>
            </div>
            <div>
                <h4 class="font-display font-bold text-brand-secondary dark:text-white mb-2">Billing Support</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed font-medium">Questions about an invoice? Our finance team is available 24/7 to clarify your subscription details.</p>
            </div>
        </div>
    </div>
</div>
