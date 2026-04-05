<section class="relative min-h-screen flex items-center overflow-hidden bg-brand-tech dark:bg-brand-dark pt-6 pb-16 sm:pt-10 sm:pb-20 md:pt-32 md:pb-32">

    <!-- ================= BACKGROUND ================= -->
    <div class="absolute inset-0 -z-10 overflow-hidden z-0">

        <!-- Desktop -->
        <div class="hidden md:block absolute inset-0 bg-fixed bg-center bg-no-repeat"
             style="background-image: url('public/assets/bulb-hero.png'); background-size: 60%; background-position: right bottom;">
        </div>

        <!-- Mobile -->
        <div class="md:hidden absolute inset-0 bg-center bg-no-repeat opacity-90"
             style="background-image: url('public/assets/bulb-hero.png'); background-size: 90%; background-position: right bottom;">
        </div>

    </div>

    <!-- ================= CONTENT ================= -->
    <div class="relative z-10 max-w-6xl mx-auto px-5 sm:px-6 text-center">

        <!-- Badge -->
        <div class="inline-flex items-center gap-2 px-3 py-1.5 sm:px-4 sm:py-2 
                    bg-brand-primary/5 dark:bg-brand-navy 
                    border border-brand-accent/30 dark:border-white/10 
                    rounded-full mb-6 sm:mb-8 backdrop-blur-sm shadow-sm">

            <div class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-brand-accent animate-pulse"></div>

            <span class="text-[9px] sm:text-[10px] font-bold uppercase tracking-[0.15em] sm:tracking-[0.2em] text-heading dark:text-inverse">
                50+ Global Organizations Trust NuMinds Tech
            </span>
        </div>

        <!-- Heading -->
        <h1 class="font-display text-3xl sm:text-4xl md:text-6xl lg:text-7xl font-extrabold mb-6 sm:mb-8 leading-[1.15] tracking-tight text-heading dark:text-inverse">
            Smart Websites & Apps<br>
            <span class="bg-gradient-to-r from-brand-primary via-brand-accent to-brand-primary bg-[length:200%_auto] animate-gradient bg-clip-text text-transparent italic">
                Made Simple.
            </span>
        </h1>

        <!-- Description -->
        <p class="text-sm sm:text-base md:text-lg max-w-xl sm:max-w-2xl mx-auto mb-8 sm:mb-12 leading-relaxed text-body dark:text-muted">
            We architect intelligent digital systems that simplify operations for schools, agencies, and enterprises.
        </p>

        <!-- Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-6">

            <button @click="modalOpen = true"
                class="w-full sm:w-auto btn-primary px-6 sm:px-10 py-3 sm:py-5 rounded-xl 
                       font-display font-bold text-[11px] sm:text-sm 
                       uppercase tracking-widest 
                       shadow-xl hover:scale-105 transition-all duration-300">
                <i class="fa-solid fa-paper-plane mr-2"></i>
                Let’s Talk
            </button>

            <a href="#solutions"
               class="w-full sm:w-auto px-6 sm:px-10 py-3 sm:py-5 rounded-xl 
                      font-display font-bold text-[11px] sm:text-sm 
                      uppercase tracking-widest
                      bg-white/10 backdrop-blur-lg
                      border border-black/10 dark:border-white/20
                      hover:bg-white/20
                      transition-all duration-300">
                <i class="fa-solid fa-eye mr-2"></i>
                See Our Work
            </a>

        </div>

    </div>
</section>