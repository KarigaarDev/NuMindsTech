<section class="relative min-h-screen flex items-center overflow-hidden bg-brand-tech dark:bg-brand-dark pt-20 pb-20 md:pt-32 md:pb-32">

    <!-- ================= BACKGROUND ================= -->
    <div class="absolute inset-0 -z-10 overflow-hidden z-0">

        <!-- Desktop Parallax -->
        <div class="hidden md:block absolute inset-0 bg-fixed bg-center bg-no-repeat z-10 "
             style="background-image: url('public/assets/bulb-hero.png'); background-size: 65%; background-position: right bottom;">
        </div>

        <!-- Mobile (no bg-fixed for smooth scrolling) -->
        <div class="md:hidden absolute inset-0 bg-center bg-no-repeat z-10"
             style="background-image: url('public/assets/bulb-hero.png'); right-0 bottom-0;">
        </div>

        <!-- Overlay -->
        <!-- <div class="absolute inset-0 bg-black/55"></div> -->
    </div>

    <!-- ================= CONTENT ================= -->
    <div class="relative z-10 max-w-6xl mx-auto px-6 text-center">

        <div class="inline-flex items-center gap-2 px-4 py-2 
                            bg-brand-red/10 dark:bg-brand-secondary 
                            border border-brand-accent dark:border-brand-red/20 
                            rounded-full mb-8 backdrop-blur-sm">
                    <div class="w-2 h-2 rounded-full bg-brand-accent animate-pulse"></div>
                    <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-heading dark:text-inverse">
                        Now servicing 50+ organizations
                    </span>
                </div>
       <h1 class="font-display text-5xl md:text-7xl font-extrabold mb-8 leading-[1.1] tracking-tight text-heading dark:text-inverse">
            Clean Tech. <br>
            <span class="text-brand-accent">Simple Systems.</span>
        </h1>

        <p class="text-lg md:text-xl max-w-2xl mx-auto mb-12 leading-relaxed text-body">
            We build secure, high-performance digital systems for modern
            organizations that value clarity over complexity.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-6">

            <button @click="modalOpen = true"
                class="btn-primary px-10 py-5 rounded-xl 
                       font-display font-bold text-sm 
                       uppercase tracking-widest 
                       shadow-xl hover:scale-105 transition-all duration-300">
                <i class="fa-solid fa-paper-plane mr-2"></i>
                Start Your Project
            </button>

            <a href="#solutions"
               class="px-10 py-5 rounded-xl 
                      font-display font-bold text-sm 
                      uppercase tracking-widest
                      bg-white/10 backdrop-blur-lg
                      border border-black/10 dark:border-white/20
                      hover:bg-white/20
                      transition-all duration-300">
                <i class="fa-solid fa-eye mr-2"></i>
                View Portfolio
            </a>

        </div>
    </div>
</section>
