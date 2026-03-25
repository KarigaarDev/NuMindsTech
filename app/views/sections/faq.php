<!-- FAQ SECTION -->
<section class="py-20 md:py-32 bg-white dark:bg-brand-dark">
    <div class="max-w-4xl mx-auto px-8">
        <div class="text-center mb-20">
            <h2 class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-primary mb-4">Common Questions</h2>
            <h3 class="font-display text-4xl md:text-5xl font-extrabold text-heading dark:text-inverse tracking-tight">
                Frequently Asked <span class="text-brand-accent">Questions</span>
            </h3>
        </div>

        <div class="space-y-6" x-data="{ open: null }">
            <!-- FAQ Item 1 -->
            <div class="border border-slate-200 dark:border-white/10 rounded-2xl overflow-hidden">
                <button 
                    @click="open = open === 1 ? null : 1"
                    class="w-full px-8 py-6 flex items-center justify-between bg-white dark:bg-brand-secondary hover:bg-slate-50 dark:hover:bg-white/5 transition-all"
                >
                    <h4 class="font-display font-bold text-lg text-heading dark:text-inverse text-left">
                        How long does a typical project take?
                    </h4>
                    <i class="fa-solid fa-chevron-down text-brand-primary transition-transform" :class="{ 'rotate-180': open === 1 }"></i>
                </button>
                <div x-show="open === 1" class="px-8 py-6 bg-slate-50 dark:bg-white/2.5 border-t border-slate-200 dark:border-white/10 text-body dark:text-muted">
                    <p class="mb-4">It depends on complexity:</p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li><strong>Simple branding site:</strong> 3-4 weeks</li>
                        <li><strong>Dashboard/internal tool:</strong> 6-10 weeks</li>
                        <li><strong>Full e-commerce/platform:</strong> 12+ weeks</li>
                    </ul>
                    <p class="mt-4">We finalize exact timeline after the Discovery phase. You get a fixed promise—no scope creep.</p>
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="border border-slate-200 dark:border-white/10 rounded-2xl overflow-hidden">
                <button 
                    @click="open = open === 2 ? null : 2"
                    class="w-full px-8 py-6 flex items-center justify-between bg-white dark:bg-brand-secondary hover:bg-slate-50 dark:hover:bg-white/5 transition-all"
                >
                    <h4 class="font-display font-bold text-lg text-heading dark:text-inverse text-left">
                        What if we need to change things mid-project?
                    </h4>
                    <i class="fa-solid fa-chevron-down text-brand-primary transition-transform" :class="{ 'rotate-180': open === 2 }"></i>
                </button>
                <div x-show="open === 2" class="px-8 py-6 bg-slate-50 dark:bg-white/2.5 border-t border-slate-200 dark:border-white/10 text-slate-600 dark:text-slate-400">
                    <p class="mb-4">That's totally normal. We have a change request process:</p>
                    <ul class="list-disc pl-5 space-y-2">
                        <li><strong>Minor tweaks (UI/copy):</strong> Included during active sprints</li>
                        <li><strong>Medium changes (new feature):</strong> Discussed impact on timeline & budget, then added</li>
                        <li><strong>Major scope changes:</strong> We re-negotiate timeline & cost upfront</li>
                    </ul>
                    <p class="mt-4">Transparency first. No surprise bills.</p>
                </div>
            </div>

            <!-- FAQ Item 3 -->
            <div class="border border-slate-200 dark:border-white/10 rounded-2xl overflow-hidden">
                <button 
                    @click="open = open === 3 ? null : 3"
                    class="w-full px-8 py-6 flex items-center justify-between bg-white dark:bg-brand-secondary hover:bg-slate-50 dark:hover:bg-white/5 transition-all"
                >
                    <h4 class="font-display font-bold text-lg text-heading dark:text-inverse text-left">
                        Do you provide ongoing support after launch?
                    </h4>
                    <i class="fa-solid fa-chevron-down text-brand-primary transition-transform" :class="{ 'rotate-180': open === 3 }"></i>
                </button>
                <div x-show="open === 3" class="px-8 py-6 bg-slate-50 dark:bg-white/2.5 border-t border-slate-200 dark:border-white/10 text-slate-600 dark:text-slate-400">
                    <p class="mb-4"><strong>Included:</strong> 30 days of free bug-fix support after launch.</p>
                    <p class="mb-4"><strong>Beyond that:</strong> We offer flexible hourly support or maintenance retainers (typically ₹10K–₹50K/month depending on size).</p>
                    <p>Most clients stay on a retainer to get priority response times and quarterly feature improvements.</p>
                </div>
            </div>

            <!-- FAQ Item 4 -->
            <div class="border border-slate-200 dark:border-white/10 rounded-2xl overflow-hidden">
                <button 
                    @click="open = open === 4 ? null : 4"
                    class="w-full px-8 py-6 flex items-center justify-between bg-white dark:bg-brand-secondary hover:bg-slate-50 dark:hover:bg-white/5 transition-all"
                >
                    <h4 class="font-display font-bold text-lg text-heading dark:text-inverse text-left">
                        Who owns the code after launch? Can we hire another team?
                    </h4>
                    <i class="fa-solid fa-chevron-down text-brand-primary transition-transform" :class="{ 'rotate-180': open === 4 }"></i>
                </button>
                <div x-show="open === 4" class="px-8 py-6 bg-slate-50 dark:bg-white/2.5 border-t border-slate-200 dark:border-white/10 text-slate-600 dark:text-slate-400">
                    <p class="mb-4"><strong>You do.</strong> Complete ownership of code, database, and infrastructure.</p>
                    <p class="mb-4">We document everything thoroughly so any competent developer can continue work. We also offer a smooth handoff meeting to explain the architecture.</p>
                    <p>No vendor lock-in. You're 100% in control.</p>
                </div>
            </div>

            <!-- FAQ Item 5 -->
            <div class="border border-slate-200 dark:border-white/10 rounded-2xl overflow-hidden">
                <button 
                    @click="open = open === 5 ? null : 5"
                    class="w-full px-8 py-6 flex items-center justify-between bg-white dark:bg-brand-secondary hover:bg-slate-50 dark:hover:bg-white/5 transition-all"
                >
                    <h4 class="font-display font-bold text-lg text-heading dark:text-inverse text-left">
                        What tech stack do you use? Can we use our own?
                    </h4>
                    <i class="fa-solid fa-chevron-down text-brand-primary transition-transform" :class="{ 'rotate-180': open === 5 }"></i>
                </button>
                <div x-show="open === 5" class="px-8 py-6 bg-slate-50 dark:bg-white/2.5 border-t border-slate-200 dark:border-white/10 text-slate-600 dark:text-slate-400">
                    <p class="mb-4"><strong>Our default stack:</strong> PHP/Laravel, React/Vue, MySQL, AWS — battle-tested, lean, scalable.</p>
                    <p class="mb-4"><strong>Flexible:</strong> If you need Node.js, Python, .NET, TypeScript, etc., we can work with it. We choose based on your project needs, not preferences.</p>
                    <p>We always recommend the leanest tech for your goals. Simpler = fewer bugs, faster development, easier maintenance.</p>
                </div>
            </div>

            <!-- FAQ Item 6 -->
            <div class="border border-slate-200 dark:border-white/10 rounded-2xl overflow-hidden">
                <button 
                    @click="open = open === 6 ? null : 6"
                    class="w-full px-8 py-6 flex items-center justify-between bg-white dark:bg-brand-secondary hover:bg-slate-50 dark:hover:bg-white/5 transition-all"
                >
                    <h4 class="font-display font-bold text-lg text-heading dark:text-inverse text-left">
                        How do you guarantee quality & security?
                    </h4>
                    <i class="fa-solid fa-chevron-down text-brand-primary transition-transform" :class="{ 'rotate-180': open === 6 }"></i>
                </button>
                <div x-show="open === 6" class="px-8 py-6 bg-slate-50 dark:bg-white/2.5 border-t border-slate-200 dark:border-white/10 text-slate-600 dark:text-slate-400">
                    <p class="mb-4"><strong>Quality:</strong></p>
                    <ul class="list-disc pl-5 space-y-1 mb-4">
                        <li>Code reviews on every commit</li>
                        <li>Automated testing (unit + integration)</li>
                        <li>Staging environment mirrors production</li>
                        <li>Pre-launch security audit</li>
                    </ul>
                    <p><strong>Post-launch:</strong> 24/7 monitoring, automatic backups, incident response protocol.</p>
                </div>
            </div>

            <!-- FAQ Item 7 -->
            <div class="border border-slate-200 dark:border-white/10 rounded-2xl overflow-hidden">
                <button 
                    @click="open = open === 7 ? null : 7"
                    class="w-full px-8 py-6 flex items-center justify-between bg-white dark:bg-brand-secondary hover:bg-slate-50 dark:hover:bg-white/5 transition-all"
                >
                    <h4 class="font-display font-bold text-lg text-heading dark:text-inverse text-left">
                        What about integrations with our existing tools?
                    </h4>
                    <i class="fa-solid fa-chevron-down text-brand-primary transition-transform" :class="{ 'rotate-180': open === 7 }"></i>
                </button>
                <div x-show="open === 7" class="px-8 py-6 bg-slate-50 dark:bg-white/2.5 border-t border-slate-200 dark:border-white/10 text-slate-600 dark:text-slate-400">
                    <p class="mb-4">We integrate with most popular platforms:</p>
                    <ul class="list-disc pl-5 space-y-1">
                        <li>Payment gateways (Razorpay, Stripe, PayPal)</li>
                        <li>Email/CRM (Gmail, Outlook, HubSpot, Salesforce)</li>
                        <li>Analytics (Google Analytics, Mixpanel)</li>
                        <li>Cloud storage (AWS S3, Google Cloud)</li>
                        <li>Custom APIs (if you need them)</li>
                    </ul>
                    <p class="mt-4">During Discovery, we map out all integrations. Most are straightforward API connections.</p>
                </div>
            </div>

            <!-- FAQ Item 8 -->
            <div class="border border-slate-200 dark:border-white/10 rounded-2xl overflow-hidden">
                <button 
                    @click="open = open === 8 ? null : 8"
                    class="w-full px-8 py-6 flex items-center justify-between bg-white dark:bg-brand-secondary hover:bg-slate-50 dark:hover:bg-white/5 transition-all"
                >
                    <h4 class="font-display font-bold text-lg text-heading dark:text-inverse text-left">
                        How do we get started? What's the next step?
                    </h4>
                    <i class="fa-solid fa-chevron-down text-brand-primary transition-transform" :class="{ 'rotate-180': open === 8 }"></i>
                </button>
                <div x-show="open === 8" class="px-8 py-6 bg-slate-50 dark:bg-white/2.5 border-t border-slate-200 dark:border-white/10 text-slate-600 dark:text-slate-400">
                    <p class="mb-4"><strong>Step 1:</strong> Fill out our brief form (5 mins) — tell us about your project, goals, and budget.</p>
                    <p class="mb-4"><strong>Step 2:</strong> We'll schedule a 15-minute exploratory call to see if we're a fit.</p>
                    <p class="mb-4"><strong>Step 3:</strong> If there's mutual interest, we'll send a proposal with timeline, deliverables, and cost.</p>
                    <p><strong>Step 4:</strong> Sign the contract and we kick off Discovery the same week.</p>
                    <p class="mt-4">No pressure, no sales pitch. Just a conversation.</p>
                </div>
            </div>
        </div>

        <!-- Final CTA -->
        <div class="mt-20 bg-brand-primary/5 dark:bg-brand-primary/10 border border-brand-primary/20 rounded-2xl p-10 text-center">
            <h3 class="font-display text-2xl font-bold text-heading dark:text-inverse mb-4">
                Still have questions?
            </h3>
            <p class="text-body dark:text-muted mb-6">
                Let's chat. No obligation. No sales pressure.
            </p>
            <button @click="modalOpen = true" class="btn-primary px-8 py-4 rounded-xl font-display font-bold text-sm uppercase tracking-widest hover:scale-105 transition-all">
                <i class="fa-solid fa-calendar mr-2"></i>
                Schedule a Call
            </button>
        </div>
    </div>
</section>
