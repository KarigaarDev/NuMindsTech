<!-- FAQ SECTION -->
<section id="faq" class="py-20 md:py-32 bg-white dark:bg-brand-dark">
    <div class="max-w-4xl mx-auto px-5 md:px-8">

        <!-- HEADER -->
        <div class="text-center mb-16 md:mb-20">
            <h2 class="text-xs font-bold uppercase tracking-[0.3em] text-brand-primary mb-4">
                Common Questions
            </h2>

            <h3 class="font-display text-3xl sm:text-4xl md:text-5xl font-black text-heading dark:text-inverse tracking-tight">
                Got 
                <span class="text-brand-accent italic">Questions?</span>
            </h3>
        </div>

        <!-- FAQ LIST -->
        <div class="space-y-4" x-data="{ open: null }">

            <!-- ITEM -->
            <div class="rounded-2xl overflow-hidden border border-slate-200 dark:border-white/10 
                        bg-white/70 dark:bg-brand-navy/50 backdrop-blur-md shadow-sm">

                <button 
                    @click="open = open === 1 ? null : 1"
                    class="w-full px-5 md:px-8 py-5 flex items-center justify-between text-left
                           hover:bg-slate-50 dark:hover:bg-white/5 transition"
                >
                    <h4 class="font-semibold text-base md:text-lg text-heading dark:text-inverse">
                        How long will my project take?
                    </h4>
                    <i class="fa-solid fa-chevron-down text-brand-primary transition-transform"
                       :class="{ 'rotate-180': open === 1 }"></i>
                </button>

                <div x-show="open === 1" x-collapse
                    class="px-5 md:px-8 pb-6 text-sm text-body dark:text-muted">
                    <p>It depends on what you need:</p>
                    <ul class="mt-2 space-y-1">
                        <li>• Simple website: 2–4 weeks</li>
                        <li>• Dashboard: 4–8 weeks</li>
                        <li>• Big project: 8+ weeks</li>
                    </ul>
                    <p class="mt-3">We will give you a clear timeline before we start.</p>
                </div>
            </div>

            <!-- ITEM -->
            <div class="rounded-2xl overflow-hidden border border-slate-200 dark:border-white/10 bg-white/70 dark:bg-brand-navy/50 backdrop-blur-md shadow-sm">
                <button @click="open = open === 2 ? null : 2"
                    class="w-full px-5 md:px-8 py-5 flex justify-between items-center">
                    <h4 class="font-semibold text-base md:text-lg text-heading dark:text-inverse">
                        Can I change things later?
                    </h4>
                    <i class="fa-solid fa-chevron-down text-brand-primary transition-transform"
                       :class="{ 'rotate-180': open === 2 }"></i>
                </button>
                <div x-show="open === 2" x-collapse class="px-5 md:px-8 pb-6 text-sm text-body dark:text-muted">
                    <p>Yes, of course.</p>
                    <p class="mt-2">Small changes are easy. Big changes may need more time and cost.</p>
                    <p class="mt-2">We will always tell you before anything changes.</p>
                </div>
            </div>

            <!-- ITEM -->
            <div class="rounded-2xl overflow-hidden border border-slate-200 dark:border-white/10 bg-white/70 dark:bg-brand-navy/50 backdrop-blur-md shadow-sm">
                <button @click="open = open === 3 ? null : 3"
                    class="w-full px-5 md:px-8 py-5 flex justify-between items-center">
                    <h4 class="font-semibold text-base md:text-lg text-heading dark:text-inverse">
                        Will you help after launch?
                    </h4>
                    <i class="fa-solid fa-chevron-down text-brand-primary transition-transform"
                       :class="{ 'rotate-180': open === 3 }"></i>
                </button>
                <div x-show="open === 3" x-collapse class="px-5 md:px-8 pb-6 text-sm text-body dark:text-muted">
                    <p>Yes.</p>
                    <p class="mt-2">We give 30 days free support.</p>
                    <p class="mt-2">After that, you can choose monthly support if you want.</p>
                </div>
            </div>

            <!-- ITEM -->
            <div class="rounded-2xl overflow-hidden border border-slate-200 dark:border-white/10 bg-white/70 dark:bg-brand-navy/50 backdrop-blur-md shadow-sm">
                <button @click="open = open === 4 ? null : 4"
                    class="w-full px-5 md:px-8 py-5 flex justify-between items-center">
                    <h4 class="font-semibold text-base md:text-lg text-heading dark:text-inverse">
                        Do I own my website?
                    </h4>
                    <i class="fa-solid fa-chevron-down text-brand-primary transition-transform"
                       :class="{ 'rotate-180': open === 4 }"></i>
                </button>
                <div x-show="open === 4" x-collapse class="px-5 md:px-8 pb-6 text-sm text-body dark:text-muted">
                    <p>Yes. 100% yours.</p>
                    <p class="mt-2">You can use it, change it, or give it to another team anytime.</p>
                </div>
            </div>

            <!-- ITEM -->
            <div class="rounded-2xl overflow-hidden border border-slate-200 dark:border-white/10 bg-white/70 dark:bg-brand-navy/50 backdrop-blur-md shadow-sm">
                <button @click="open = open === 5 ? null : 5"
                    class="w-full px-5 md:px-8 py-5 flex justify-between items-center">
                    <h4 class="font-semibold text-base md:text-lg text-heading dark:text-inverse">
                        What tools do you use?
                    </h4>
                    <i class="fa-solid fa-chevron-down text-brand-primary transition-transform"
                       :class="{ 'rotate-180': open === 5 }"></i>
                </button>
                <div x-show="open === 5" x-collapse class="px-5 md:px-8 pb-6 text-sm text-body dark:text-muted">
                    <p>We use simple, strong tools that work fast.</p>
                    <p class="mt-2">We can also use your preferred tools if needed.</p>
                </div>
            </div>

            <!-- ITEM -->
            <div class="rounded-2xl overflow-hidden border border-slate-200 dark:border-white/10 bg-white/70 dark:bg-brand-navy/50 backdrop-blur-md shadow-sm">
                <button @click="open = open === 6 ? null : 6"
                    class="w-full px-5 md:px-8 py-5 flex justify-between items-center">
                    <h4 class="font-semibold text-base md:text-lg text-heading dark:text-inverse">
                        Is my data safe?
                    </h4>
                    <i class="fa-solid fa-chevron-down text-brand-primary transition-transform"
                       :class="{ 'rotate-180': open === 6 }"></i>
                </button>
                <div x-show="open === 6" x-collapse class="px-5 md:px-8 pb-6 text-sm text-body dark:text-muted">
                    <p>Yes.</p>
                    <p class="mt-2">We use secure systems and regular backups.</p>
                    <p class="mt-2">Your data stays safe.</p>
                </div>
            </div>

            <!-- ITEM -->
            <div class="rounded-2xl overflow-hidden border border-slate-200 dark:border-white/10 bg-white/70 dark:bg-brand-navy/50 backdrop-blur-md shadow-sm">
                <button @click="open = open === 7 ? null : 7"
                    class="w-full px-5 md:px-8 py-5 flex justify-between items-center">
                    <h4 class="font-semibold text-base md:text-lg text-heading dark:text-inverse">
                        Can it connect with my tools?
                    </h4>
                    <i class="fa-solid fa-chevron-down text-brand-primary transition-transform"
                       :class="{ 'rotate-180': open === 7 }"></i>
                </button>
                <div x-show="open === 7" x-collapse class="px-5 md:px-8 pb-6 text-sm text-body dark:text-muted">
                    <p>Yes.</p>
                    <p class="mt-2">We can connect payments, email, and other tools you use.</p>
                </div>
            </div>

            <!-- ITEM -->
            <div class="rounded-2xl overflow-hidden border border-slate-200 dark:border-white/10 bg-white/70 dark:bg-brand-navy/50 backdrop-blur-md shadow-sm">
                <button @click="open = open === 8 ? null : 8"
                    class="w-full px-5 md:px-8 py-5 flex justify-between items-center">
                    <h4 class="font-semibold text-base md:text-lg text-heading dark:text-inverse">
                        How do we start?
                    </h4>
                    <i class="fa-solid fa-chevron-down text-brand-primary transition-transform"
                       :class="{ 'rotate-180': open === 8 }"></i>
                </button>
                <div x-show="open === 8" x-collapse class="px-5 md:px-8 pb-6 text-sm text-body dark:text-muted">
                    <p>Simple:</p>
                    <p class="mt-2">1. Book a call</p>
                    <p>2. We talk for 15 mins</p>
                    <p>3. We send a plan</p>
                    <p>4. We start work</p>
                </div>
            </div>

        </div>

        <!-- CTA -->
        <div class="mt-16 md:mt-20 rounded-3xl p-8 md:p-12 text-center 
            bg-gradient-to-r from-brand-primary/10 via-brand-accent/10 to-brand-primary/10
            border border-brand-primary/20 shadow-lg">

            <h3 class="font-display text-xl md:text-2xl font-bold text-heading dark:text-inverse mb-4">
                Still not sure?
            </h3>

            <p class="text-sm md:text-base text-body dark:text-muted mb-6">
                Let’s talk. No pressure.
            </p>

            <button @click="modalOpen = true"
                class="px-8 py-4 rounded-xl text-white font-bold text-sm uppercase tracking-wide
                bg-gradient-to-r from-brand-primary to-brand-accent
                shadow-md hover:scale-105 transition">

                <i class="fa-solid fa-comments mr-2"></i>
                Talk to Us
            </button>

        </div>

    </div>
</section>