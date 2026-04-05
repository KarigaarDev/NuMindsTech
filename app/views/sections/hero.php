<section class="relative min-h-screen flex items-center overflow-hidden 
bg-gradient-to-br from-brand-tech via-white to-blue-50 
dark:from-brand-dark dark:via-brand-secondary dark:to-black">

    <!-- ================= BACKGROUND ================= -->
    <div class="absolute inset-0 overflow-hidden z-0">

        <!-- Glow Effects -->
        <div class="absolute -top-40 -left-40 w-[300px] sm:w-[400px] h-[300px] sm:h-[400px] 
                    bg-brand-primary/20 rounded-full blur-3xl animate-pulse z-0"></div>

        <div class="absolute bottom-0 right-0 w-[250px] sm:w-[350px] h-[250px] sm:h-[350px] 
                    bg-brand-accent/20 rounded-full blur-3xl animate-pulse z-0"></div>

        <!-- Desktop Image -->
        <div class="hidden md:block absolute inset-0 bg-no-repeat z-[1]"
             style="background-image: url('public/assets/bulb-hero.png'); 
                    background-size: 55%; 
                    background-position: right bottom;">
        </div>

        <!-- Mobile Image -->
        <div class="md:hidden absolute inset-0 bg-no-repeat opacity-90 z-[1]"
             style="background-image: url('public/assets/bulb-hero.png'); 
                    background-size: 95%; 
                    background-position: right bottom;">
        </div>

        <!-- Subtle Grid -->
        <div class="absolute inset-0 opacity-[0.03] z-0
            bg-[linear-gradient(to_right,#000_1px,transparent_1px),linear-gradient(to_bottom,#000_1px,transparent_1px)] 
            bg-[size:40px_40px]"></div>

    </div>

    <!-- ================= CONTENT ================= -->
    <div class="relative z-10 max-w-6xl mx-auto px-5 sm:px-6 text-center">

        <!-- Badge -->
        <div class="inline-flex items-center gap-2 px-4 py-2 mb-6
                    rounded-full backdrop-blur-xl border 
                    border-black/10 dark:border-white/10
                    bg-white/60 dark:bg-white/5 shadow-sm animate-fade-in">

            <span class="w-2 h-2 rounded-full bg-brand-accent animate-ping"></span>

            <span class="text-[10px] font-bold uppercase tracking-[0.2em] 
                         text-heading dark:text-inverse">
                50+ Global Organizations Trust NuMinds Tech
            </span>
        </div>

        <!-- Heading -->
        <h1 class="font-display text-3xl sm:text-5xl md:text-6xl lg:text-7xl 
                   font-extrabold mb-5 sm:mb-6 leading-[1.15] tracking-tight 
                   text-heading dark:text-inverse animate-fade-up">

            Smart Websites & Apps<br>

            <span class="relative inline-block italic">

                <span class="bg-gradient-to-r from-brand-primary via-brand-accent to-brand-primary 
                             bg-[length:200%_auto] animate-gradient 
                             bg-clip-text text-transparent">
                    Made Simple.
                </span>

                <span class="absolute -bottom-2 left-0 w-full h-[6px] 
                             bg-gradient-to-r from-brand-primary to-brand-accent 
                             blur-md opacity-40"></span>
            </span>
        </h1>

        <!-- Description -->
        <p class="text-sm sm:text-base md:text-lg max-w-xl sm:max-w-2xl 
                  mx-auto mb-8 sm:mb-10 leading-relaxed 
                  text-body dark:text-muted animate-fade-up delay-100">

            We architect intelligent digital systems that simplify operations 
            for schools, agencies, and enterprises.
        </p>

        <!-- CTA -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-5 animate-fade-up delay-200">

            <!-- Primary -->
            <button @click="modalOpen = true"
                class="group relative w-full sm:w-auto px-6 sm:px-8 py-3 sm:py-4 rounded-xl 
                       font-display font-bold text-xs sm:text-sm uppercase tracking-widest 
                       text-white overflow-hidden shadow-xl">

                <span class="absolute inset-0 bg-gradient-to-r 
                             from-brand-primary to-brand-accent 
                             group-hover:scale-110 transition duration-500"></span>

                <span class="relative z-10 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i>
                    Let’s Talk
                </span>
            </button>

            <!-- Secondary -->
            <a href="#solutions"
               class="group w-full sm:w-auto px-6 sm:px-8 py-3 sm:py-4 rounded-xl 
                      font-display font-bold text-xs sm:text-sm uppercase tracking-widest
                      backdrop-blur-xl bg-white/50 dark:bg-white/5
                      border border-black/10 dark:border-white/20
                      hover:bg-white/80 dark:hover:bg-white/10
                      transition-all duration-300">

                <span class="flex items-center justify-center gap-2">
                    <i class="fa-solid fa-eye group-hover:scale-110 transition"></i>
                    See Our Work
                </span>
            </a>

        </div>

    </div>
</section>
<style>@keyframes fadeUp {
    from { opacity: 0; transform: translateY(25px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.animate-fade-up {
    animation: fadeUp 0.8s ease forwards;
}

.animate-fade-in {
    animation: fadeIn 0.8s ease forwards;
}

.animate-gradient {
    background-size: 200% auto;
    animation: gradientMove 4s linear infinite;
}

@keyframes gradientMove {
    0% { background-position: 0% center; }
    100% { background-position: 200% center; }
}</style>