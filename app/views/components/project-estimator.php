<?php
// app/views/components/project-estimator.php
?>
<section id="estimator" class="py-24 md:py-32 bg-slate-50 dark:bg-brand-dark relative overflow-hidden">
    
    <!-- 📐 Architectural Draft Background -->
    <div class="absolute inset-0 opacity-[0.03] pointer-events-none"
         style="background-image: radial-gradient(#000 0.5px, transparent 0.5px); background-size: 20px 20px;">
    </div>

    <div class="max-w-5xl mx-auto px-6 relative z-10" 
         x-data="projectEstimator()">
        
        <!-- Header -->
        <div class="text-center mb-16">
            <h2 class="text-[10px] font-bold uppercase tracking-[0.4em] text-brand-primary mb-4">Precision Planning</h2>
            <h3 class="font-display text-3xl md:text-5xl font-extrabold text-heading dark:text-inverse tracking-tight mb-6">
                Build your <span class="bg-gradient-to-r from-brand-primary via-brand-accent to-brand-primary bg-[length:200%_auto] animate-gradient bg-clip-text text-transparent italic">System Blueprint.</span>
            </h3>
            <p class="text-sm md:text-base text-muted max-w-2xl mx-auto leading-relaxed">
                Select your requirements below to get an instant strategy recommendation and a ballpark budget estimate.
            </p>
        </div>

        <div class="grid lg:grid-cols-3 gap-8 items-start">
            
            <!-- 🛠️ Step 1: Services -->
            <div class="lg:col-span-2 space-y-10">
                
                <div class="space-y-6">
                    <label class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-400">01. Choose Service</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <template x-for="s in services" :key="s.id">
                            <button @click="selectedService = s"
                                    :class="selectedService.id === s.id ? 'bg-brand-primary text-white scale-105 shadow-xl shadow-brand-primary/20 p-6' : 'bg-white dark:bg-brand-navy dark:text-white border border-black/5 dark:border-white/5 p-5'"
                                    class="rounded-2xl transition-all duration-300 text-left group flex flex-col justify-between h-32">
                                <i :class="s.icon" class="text-xl mb-auto"></i>
                                <span class="text-[11px] font-bold uppercase tracking-widest leading-tight" x-text="s.title"></span>
                            </button>
                        </template>
                    </div>
                </div>

                <div class="space-y-6">
                    <label class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-400">02. Scale & Complexity</label>
                    <div class="bg-white dark:bg-brand-navy p-8 rounded-3xl border border-black/5 dark:border-white/5">
                        <input type="range" min="1" max="10" x-model="complexity" 
                               class="w-full h-2 bg-slate-100 dark:bg-brand-dark rounded-lg appearance-none cursor-pointer accent-brand-primary mb-6">
                        <div class="flex justify-between text-[10px] font-bold uppercase tracking-[0.2em] text-muted">
                            <span>Minimal (Landing)</span>
                            <span>Standard</span>
                            <span>Enterprise</span>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <label class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-400">03. Priority Level</label>
                    <div class="flex flex-wrap gap-4">
                        <template x-for="p in priorities" :key="p.id">
                            <button @click="priority = p"
                                    :class="priority.id === p.id ? 'bg-brand-accent text-white border-transparent' : 'bg-white dark:bg-brand-navy dark:text-white border border-black/5'"
                                    class="px-6 py-3 rounded-xl text-[10px] font-bold uppercase tracking-widest border transition-all"
                                    x-text="p.title"></button>
                        </template>
                    </div>
                </div>

            </div>

            <!-- 📊 Result Card -->
            <div class="sticky top-32">
                <div class="bg-white dark:bg-brand-navy rounded-[2.5rem] p-8 shadow-2xl shadow-indigo-500/10 border border-brand-primary/10 overflow-hidden relative">
                    <!-- Accent bar -->
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-brand-primary to-brand-accent"></div>
                    
                    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-8">
                        <h4 class="text-[10px] font-black uppercase tracking-[0.4em] text-brand-primary">Estimated Proposal</h4>
                        
                        <!-- Currency Toggle -->
                        <div class="flex bg-slate-100 dark:bg-brand-dark p-1 rounded-lg w-fit">
                            <button @click="currency = 'INR'"
                                    :class="currency === 'INR' ? 'bg-white dark:bg-brand-navy shadow-sm text-brand-primary' : 'text-slate-400 hover:text-heading dark:hover:text-white'"
                                    class="px-3 py-1 text-[9px] font-bold uppercase rounded-md transition-all">
                                INR ₹
                            </button>
                            <button @click="currency = 'USD'"
                                    :class="currency === 'USD' ? 'bg-white dark:bg-brand-navy shadow-sm text-brand-primary' : 'text-slate-400 hover:text-heading dark:hover:text-white'"
                                    class="px-3 py-1 text-[9px] font-bold uppercase rounded-md transition-all">
                                USD $
                            </button>
                        </div>
                    </div>
                    
                    <div class="space-y-6 mb-10">
                        <div>
                            <p class="text-[9px] uppercase font-bold text-muted mb-1">Target Strategy</p>
                            <p class="text-sm font-bold text-heading dark:text-inverse" x-text="selectedService.title"></p>
                        </div>
                        <div>
                            <p class="text-[9px] uppercase font-bold text-muted mb-1">Complexity Multiplier</p>
                            <p class="text-sm font-bold text-heading dark:text-inverse" x-text="complexity + 'x Scale'"></p>
                        </div>
                        <div>
                            <p class="text-[9px] uppercase font-bold text-muted mb-1">Estimated Ballpark</p>
                            <p class="text-3xl font-display font-black text-brand-primary tracking-tight">
                                <span x-text="currency === 'INR' ? '₹' : '$'"></span><span x-text="calculateTotal()"></span>
                                <span class="text-xs font-bold text-muted ml-1">+</span>
                            </p>
                        </div>
                    </div>

                    <button @click="openLeadModal()"
                            class="w-full bg-brand-primary text-white py-5 rounded-2xl font-display font-bold text-xs uppercase tracking-widest shadow-xl shadow-brand-primary/20 hover:scale-[1.02] active:scale-100 transition-all">
                        Validate Proposal <i class="fa-solid fa-arrow-right ml-2 text-[10px]"></i>
                    </button>

                    <p class="text-[9px] text-center text-muted mt-6 font-medium italic">
                        *Non-binding estimate. Accurate quote requires discovery.
                    </p>
                </div>
            </div>

        </div>

    </div>
</section>

<script>
function projectEstimator() {
    return {
        currency: 'INR',
        exchangeRate: 83, // Approx conversion 1 USD = 83 INR
        selectedService: { id: 1, title: 'Starter Website', base: 120, icon: 'fa-solid fa-laptop-code' },
        complexity: 3,
        priority: { id: 1, title: 'Standard (4-6 weeks)', multiplier: 1 },
        services: [
            { id: 1, title: 'Starter Website', base: 120, icon: 'fa-solid fa-laptop-code' },
            { id: 2, title: 'E-commerce Shop', base: 350, icon: 'fa-solid fa-cart-shopping' },
            { id: 3, title: 'Custom Web App', base: 650, icon: 'fa-solid fa-gears' },
            { id: 4, title: 'Mobile App', base: 950, icon: 'fa-solid fa-mobile-screen' },
            { id: 5, title: 'Brand Identity', base: 100, icon: 'fa-solid fa-chess-knight' },
            { id: 6, title: 'SEO Strategy', base: 150, icon: 'fa-solid fa-rocket' },
        ],
        priorities: [
            { id: 1, title: 'Standard (4-6 weeks)', multiplier: 1 },
            { id: 2, title: 'Expedited (2-3 weeks)', multiplier: 1.5 },
            { id: 3, title: 'Rush (Emergency)', multiplier: 2.2 },
        ],
        calculateTotal() {
            let base = this.selectedService.base;
            let scale = Math.max(1, (this.complexity / 2));
            let total = base * scale * this.priority.multiplier;
            
            if (this.currency === 'INR') {
                total = total * this.exchangeRate;
                // Round to nearest 1000 for INR
                total = Math.ceil(total / 1000) * 1000;
            } else {
                // Round to nearest 100 for USD
                total = Math.ceil(total / 100) * 100;
            }
            
            return total.toLocaleString();
        },
        openLeadModal() {
            // Trigger global lead modal via global event
            window.dispatchEvent(new CustomEvent('open-modal'));
            console.log('User interested in:', this.selectedService.title, 'Estimate:', this.calculateTotal());
        }
    }
}
</script>
