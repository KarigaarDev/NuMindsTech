<header class="bg-brand-secondary border-b border-white/5 px-8 py-5 flex items-center justify-between transition-colors">

    <button id="toggleSidebar"
            class="md:hidden text-2xl text-white">
        ☰
    </button>

    <h1 class="text-[10px] font-bold border-l-2 border-brand-primary pl-4 uppercase tracking-[0.2em] text-white">
        <?= $title ?? 'Management Console' ?>
    </h1>

    <div class="flex items-center gap-3">
        <div class="w-1.5 h-1.5 rounded-full bg-brand-accent"></div>
        <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400">
            System <span class="text-brand-accent">Active</span>
        </div>
    </div>

</header>

<script>
document.getElementById('toggleSidebar')?.addEventListener('click', () => {
    // Mobile sidebar toggle is handled in layout.php via global toggleSidebar()
    if (typeof toggleSidebar === 'function') {
        toggleSidebar();
    }
});
</script>
