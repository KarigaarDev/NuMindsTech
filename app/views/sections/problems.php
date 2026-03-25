<!-- PROBLEM → SOLUTION SECTION -->
<section class="py-20 md:py-32 bg-white dark:bg-brand-dark">
    <div class="max-w-7xl mx-auto px-8">
        
        <!-- Heading -->
        <div class="text-center mb-20">
            <h2 class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-primary mb-4">
                Common Problems
            </h2>
            <h3 class="font-display text-4xl md:text-5xl font-extrabold text-heading dark:text-inverse tracking-tight">
                Why many organizations <span class="text-brand-accent">feel stuck online</span>
            </h3>
        </div>

        <div class="grid md:grid-cols-2 gap-12 items-center mb-24">
            
            <!-- Left: Problems -->
            <div class="space-y-6">
                <h3 class="font-display text-3xl font-bold text-heading dark:text-inverse mb-6">
                    do you have this problem?
                </h3>
                <div class="flex gap-4">
                    <div class="flex items-center justify-center h-10 w-10 rounded-lg bg-red-100 dark:bg-red-900/20 text-red-600">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </div>
                    <div>
                        <h4 class="font-display font-bold text-lg text-heading dark:text-inverse mb-2">
                            Slow & Outdated Websites
                        </h4>
                        <p class="text-sm text-body dark:text-muted">
                            Visitors leave before your page loads. You lose trust before the first click.
                        </p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="flex items-center justify-center h-10 w-10 rounded-lg bg-red-100 dark:bg-red-900/20 text-red-600">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </div>
                    <div>
                        <h4 class="font-display font-bold text-lg text-heading dark:text-inverse mb-2">
                            Too Many Tools, No Connection
                        </h4>
                        <p class="text-sm text-body dark:text-muted">
                            Your data lives in different apps. Your team wastes time switching between them.
                        </p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="flex items-center justify-center h-10 w-10 rounded-lg bg-red-100 dark:bg-red-900/20 text-red-600">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </div>
                    <div>
                        <h4 class="font-display font-bold text-lg text-heading dark:text-inverse mb-2">
                            Unreliable & Unsafe Systems
                        </h4>
                        <p class="text-sm text-body dark:text-muted">
                            Downtime, hacks, and data loss can damage your reputation.
                        </p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="flex items-center justify-center h-10 w-10 rounded-lg bg-red-100 dark:bg-red-900/20 text-red-600">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </div>
                    <div>
                        <h4 class="font-display font-bold text-lg text-heading dark:text-inverse mb-2">
                            Paying for Features You Don’t Use
                        </h4>
                        <p class="text-sm text-body dark:text-muted">
                            Big platforms are expensive and complicated.
                        </p>
                    </div>
                </div>

            </div>

            <!-- Right: Solutions -->
            <div class="space-y-6">
                <h3 class="font-display text-3xl font-bold text-heading dark:text-inverse mb-6">
                    Or do you want this instead?
                </h3>
                <div class="flex gap-4">
                    <div class="flex items-center justify-center h-10 w-10 rounded-lg bg-brand-accent dark:bg-brand-primary/20 text-brand-primary">
                        <i class="fa-solid fa-check text-lg"></i>
                    </div>
                    <div>
                        <h4 class="font-display font-bold text-lg text-heading dark:text-inverse mb-2">
                            Fast, Modern Websites
                        </h4>
                        <p class="text-sm text-body dark:text-muted">
                            Clean design. Quick loading. Built to keep visitors engaged.
                        </p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="flex items-center justify-center h-10 w-10 rounded-lg bg-brand-accent dark:bg-brand-primary/20 text-brand-primary">
                        <i class="fa-solid fa-check text-lg"></i>
                    </div>
                    <div>
                        <h4 class="font-display font-bold text-lg text-heading dark:text-inverse mb-2">
                            One Simple Dashboard
                        </h4>
                        <p class="text-sm text-body dark:text-muted">
                            Everything in one place. Easy for your team to manage.
                        </p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="flex items-center justify-center h-10 w-10 rounded-lg bg-brand-accent dark:bg-brand-primary/20 text-brand-primary">
                        <i class="fa-solid fa-check text-lg"></i>
                    </div>
                    <div>
                        <h4 class="font-display font-bold text-lg text-heading dark:text-inverse mb-2">
                            Safe & Reliable Systems
                        </h4>
                        <p class="text-sm text-body dark:text-muted">
                            Secure data, regular backups, and systems you can trust.
                        </p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="flex items-center justify-center h-10 w-10 rounded-lg bg-brand-accent dark:bg-brand-primary/20 text-brand-primary">
                        <i class="fa-solid fa-check text-lg"></i>
                    </div>
                    <div>
                        <h4 class="font-display font-bold text-lg text-heading dark:text-inverse mb-2">
                            Built Only for What You Need
                        </h4>
                        <p class="text-sm text-body dark:text-muted">
                            No extra features. No unnecessary cost.
                        </p>
                    </div>
                </div>

            </div>
        </div>

        <!-- CTA -->
        <div class="bg-brand-primary/5 dark:bg-brand-primary/10 border border-brand-primary/20 rounded-[2.5rem] p-12 text-center">
            <h3 class="font-display text-2xl md:text-3xl font-bold text-heading dark:text-inverse mb-6">
                Sound familiar?
            </h3>
            <p class="text-body dark:text-muted mb-8 max-w-2xl mx-auto">
                Let’s talk for 15 minutes and see if we can simplify your systems.
            </p>
            <button @click="modalOpen = true" class="btn-primary px-10 py-4 rounded-xl font-display font-bold text-sm uppercase tracking-widest shadow-lg hover:scale-105 transition-all">
                <i class="fa-solid fa-comments mr-2"></i>
                Book a Free Call
            </button>
        </div>

    </div>
</section>