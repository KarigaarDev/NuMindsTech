<section class="relative min-h-screen flex items-center overflow-hidden bg-brand-tech dark:bg-brand-dark pt-20 pb-20 md:pt-32 md:pb-32">

    <!-- Diagonal Image Background -->
    <div class="absolute inset-0 z-0 pointer-events-none">
        <div class="absolute inset-0 bg-brand-tech dark:bg-brand-dark"></div>

        <!-- Diagonal image container -->
        <div class="absolute inset-0">
            <div class="absolute right-0 top-0 h-full w-2/3 
                        clip-diagonal overflow-hidden">
                <img src="<?= url('assets/bulb-hero.png') ?>" 
                     alt="Innovation and Ideas"
                     class="w-full h-full object-cover">
            </div>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="max-w-7xl mx-auto px-8 relative z-10 w-full">
        <div class="grid lg:grid-cols-2 gap-20 items-center">

            <div>
                <div class="inline-flex items-center gap-2 px-4 py-2 
                            bg-brand-red/10 dark:bg-brand-secondary 
                            border border-brand-red/20 
                            rounded-full mb-8 backdrop-blur-sm">
                    <div class="w-2 h-2 rounded-full bg-brand-accent animate-pulse"></div>
                    <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-heading dark:text-inverse">
                        Now servicing 60+ organizations
                    </span>

                </div>
                
                <h1 class="font-display text-5xl md:text-7xl font-extrabold mb-8 leading-[1.1] tracking-tight text-heading dark:text-inverse">
                    Clean Tech. <br/>
                    <span class="text-brand-accent">Simple Systems.</span>
                </h1>
                
                <p class="text-lg md:text-xl text-body mb-12 leading-relaxed max-w-xl">
                    We build high-performance, secure digital tools for organizations 
                    that value clarity and trust above artificial hype.
                </p>
                
                <div class="flex flex-col sm:flex-row items-center gap-6">
                    <button @click="modalOpen = true"
                        class="btn-primary px-10 py-5 rounded-xl font-display font-bold text-sm uppercase tracking-widest shadow-xl hover:scale-105 transition-all">
                        Start your Project
                    </button>

                    <a href="#solutions"
                       class="px-10 py-5 rounded-xl font-display font-bold text-sm uppercase tracking-widest
                              bg-white/5 hover:bg-white/10
                              border border-black/10 dark:border-white/20
                              text-heading dark:text-inverse
                              transition-all backdrop-blur-sm">
                        View Portfolio
                    </a>
                </div>
            </div>

            <div class="hidden lg:block"></div>
        </div>
    </div>
</section>
