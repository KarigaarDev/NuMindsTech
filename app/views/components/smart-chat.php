<?php
// app/views/components/smart-chat.php
?>
<div x-data="smartChat()" 
     class="fixed bottom-4 right-4 md:bottom-8 md:right-8 z-[100] font-sans"
     @click.away="isOpen = false"
     x-cloak>
    
    <!-- 🗨️ Floating Chat Bubble -->
    <button @click="isOpen = !isOpen; hasUnread = false"
            class="group relative w-14 h-14 md:w-16 md:h-16 bg-brand-primary rounded-full shadow-2xl shadow-brand-primary/40 flex items-center justify-center transition-all duration-500 hover:scale-105 active:scale-95 z-20 overflow-hidden border border-white/10">
        
        <!-- Premium Gradient Pulse -->
        <span class="absolute inset-0 bg-gradient-to-tr from-brand-primary to-brand-accent animate-pulse opacity-80 group-hover:opacity-100 transition-opacity"></span>
        <span class="absolute inset-[2px] bg-brand-primary rounded-full"></span>
        
        <!-- Icons -->
        <span x-show="!isOpen" class="relative z-10 flex items-center justify-center">
            <i class="fa-solid fa-comment-dots text-white text-xl md:text-2xl transition-transform group-hover:rotate-12 group-hover:scale-110"></i>
        </span>
        <span x-show="isOpen" class="relative z-10 flex items-center justify-center">
            <i class="fa-solid fa-xmark text-white text-xl md:text-2xl transition-all duration-300"></i>
        </span>

        <!-- Online badge -->
        <span class="absolute top-0 right-0 w-3.5 h-3.5 bg-emerald-500 rounded-full border-2 border-white dark:border-[#0f172a] shadow-sm z-30"></span>
        
        <!-- Unread badge -->
        <span x-show="hasUnread" 
              class="absolute -top-1 -right-1 w-4 h-4 bg-rose-500 rounded-full border-2 border-white animate-bounce shadow-sm z-40"></span>
    </button>

    <!-- 💻 Chat Window (Premium Overhaul) -->
    <div x-show="isOpen"
         x-transition:enter="transition ease-out duration-300 transform origin-bottom-right"
         x-transition:enter-start="opacity-0 translate-y-10 scale-90"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200 transform origin-bottom-right"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 translate-y-10 scale-90"
         class="absolute bottom-20 right-0 w-[calc(100vw-2rem)] md:w-[400px] h-[600px] max-h-[80vh] bg-white dark:bg-[#0f172a] rounded-3xl shadow-[0_20px_50px_-12px_rgba(0,0,0,0.25)] border border-slate-200/60 dark:border-white/10 overflow-hidden flex flex-col backdrop-blur-2xl">
         
         <!-- Header -->
        <div class="px-6 py-5 bg-white dark:bg-[#0f172a] border-b border-slate-100 dark:border-white/5 relative z-10">
            <div class="flex items-center gap-4">
                <div class="relative">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center border border-brand-primary/20 bg-brand-primary/10 overflow-hidden">
                        <img src="<?= url('public/assets/nimmiAvatar.png') ?>" class="w-full h-full object-cover">
                    </div>
                    <span class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-emerald-500 border-2 border-white dark:border-[#0f172a] rounded-full z-10"></span>
                </div>

                <div>
                    <h3 class="font-display font-bold text-base tracking-tight text-heading dark:text-white" x-text="config.identity.name">AI Agent</h3>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 font-medium tracking-wide" x-text="config.identity.role">Strategist</p>
                </div>
                <div class="ml-auto flex items-center gap-2">
                    <button @click="resetChat()" title="Start Over" class="w-8 h-8 rounded-full bg-slate-100 dark:bg-white/5 flex items-center justify-center text-slate-500 hover:text-brand-primary dark:hover:text-white transition-colors">
                        <i class="fa-solid fa-rotate-right text-xs"></i>
                    </button>
                    <button @click="isOpen = false" class="w-8 h-8 rounded-full bg-slate-100 dark:bg-white/5 flex items-center justify-center text-slate-500 hover:text-heading dark:hover:text-white transition-colors">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </button>
                </div>
            </div>

        </div>

        <!-- Messages Area -->
        <div id="messageArea" class="flex-1 overflow-y-auto p-5 md:p-6 space-y-6 bg-slate-50/50 dark:bg-black/20 scroll-smooth custom-scrollbar">
            <template x-for="(msg, index) in messages" :key="index">
                <div class="flex flex-col gap-2">
                    <!-- Message Bubble -->
                    <div :class="msg.type === 'bot' ? 'flex justify-start items-end gap-2.5' : 'flex justify-end'">
                        
                        <!-- Bot Avatar -->
                        <template x-if="msg.type === 'bot'">
                            <div class="w-7 h-7 rounded-full bg-brand-primary/10 flex items-center justify-center flex-shrink-0 mb-1 border border-brand-primary/20 overflow-hidden">
                                <img src="<?= url('public/assets/nimmiAvatar.png') ?>" class="w-full h-full object-cover">
                            </div>
                        </template>
                        
                        <div :class="msg.type === 'bot' 
                                ? 'bg-white dark:bg-[#1e293b] text-slate-700 dark:text-slate-200 rounded-[1.5rem] rounded-bl-md border border-slate-200/50 dark:border-white/5 shadow-sm' 
                                : 'bg-gradient-to-r from-brand-primary to-brand-accent text-white rounded-[1.5rem] rounded-br-md shadow-md'"
                             class="max-w-[85%] px-5 py-3.5 text-[13px] leading-relaxed transition-all duration-300 relative group">
                            
                            <span x-html="msg.text" class="block font-medium"></span>
                        </div>
                    </div>

                    <!-- Stateful Suggestions (Rendered inline below the bot message) -->
                    <template x-if="msg.type === 'bot' && msg.suggestions && msg.suggestions.length > 0">
                        <div class="pl-9 flex flex-wrap gap-2 mt-1">
                            <template x-for="sug in msg.suggestions" :key="sug.label">
                                <button @click="handleAction(sug.action, sug.target || sug.label)" 
                                        class="px-4 py-2 bg-white dark:bg-[#1e293b] hover:bg-brand-primary hover:text-white dark:hover:bg-brand-primary transition-all duration-300 rounded-xl border border-slate-200 dark:border-white/10 text-[11px] font-bold text-brand-primary dark:text-white shadow-sm flex items-center gap-1.5 active:scale-95">
                                    <span x-text="sug.label"></span>
                                    <template x-if="sug.action === 'whatsapp'">
                                        <i class="fa-brands fa-whatsapp text-emerald-500"></i>
                                    </template>
                                </button>
                            </template>
                        </div>
                    </template>
                </div>
            </template>
            
            <!-- Typing Indicator -->
            <div x-show="isTyping" class="flex justify-start gap-2.5 items-end">
                <div class="w-7 h-7 rounded-full bg-brand-primary/5 flex items-center justify-center flex-shrink-0 overflow-hidden">
                    <img src="<?= url('public/assets/nimmiAvatar.png') ?>" class="w-full h-full object-cover opacity-80">
                </div>
                <div class="bg-white dark:bg-[#1e293b] px-5 py-4 rounded-[1.5rem] rounded-bl-md flex gap-1.5 items-center border border-slate-200/50 dark:border-white/5 shadow-sm">
                    <span class="w-1.5 h-1.5 bg-brand-primary/40 rounded-full animate-bounce"></span>
                    <span class="w-1.5 h-1.5 bg-brand-primary/40 rounded-full animate-bounce" style="animation-delay: 0.15s"></span>
                    <span class="w-1.5 h-1.5 bg-brand-primary/40 rounded-full animate-bounce" style="animation-delay: 0.3s"></span>
                </div>
            </div>
        </div>

        <!-- Sticky Input Area -->
        <div class="p-4 md:p-5 bg-white dark:bg-[#0f172a] border-t border-slate-100 dark:border-white/5 relative z-10">
            <div class="relative flex items-center">
                <input type="text" 
                       x-model="userInput" 
                       @keyup.enter="sendMessage()"
                       placeholder="Message NuMinds AI..."
                       class="w-full bg-slate-100 dark:bg-black/40 pl-5 pr-14 py-3.5 rounded-2xl border border-transparent focus:border-brand-primary/30 focus:bg-white dark:focus:bg-[#1e293b] focus:ring-4 focus:ring-brand-primary/5 text-[13px] font-medium placeholder:text-slate-400 dark:placeholder:text-slate-500 transition-all outline-none">
                
                <button @click="sendMessage()"
                        class="absolute right-1.5 w-10 h-10 bg-brand-primary text-white rounded-xl flex items-center justify-center hover:bg-brand-accent active:scale-95 transition-all shadow-md">
                    <i class="fa-solid fa-arrow-up"></i>
                </button>
            </div>
            <div class="flex items-center justify-center gap-1.5 mt-3 opacity-40">
                <i class="fa-solid fa-lock text-[8px] text-slate-500"></i>
                <p class="text-[9px] text-slate-500 font-bold uppercase tracking-widest">End-to-End Encrypted</p>
            </div>
        </div>
    </div>
</div>

<script>
function smartChat() {
    return {
        isOpen: false,
        hasUnread: true,
        isTyping: false,
        userInput: '',
        config: <?= (file_exists(__DIR__ . '/../../../public/assets/data/business_context.json')) 
                    ? file_get_contents(__DIR__ . '/../../../public/assets/data/business_context.json') 
                    : '{ "identity": {"name": "NuMinds AI", "role": "Strategist"}, "welcome": {"text": "Hello! How can I help?", "suggestions": []}, "nodes": [], "fallback": {"text": "I am offline right now.", "suggestions": []} }' ?>,
        messages: [],
        
        init() {
            this.resetChat();
        },

        resetChat() {
            this.messages = [];
            this.isTyping = true;
            this.userInput = '';
            
            setTimeout(() => {
                if (!this.config || !this.config.welcome) return;
                this.messages.push({ 
                    type: 'bot', 
                    text: this.config.welcome.text,
                    suggestions: this.config.welcome.suggestions || []
                });
                this.isTyping = false;
            }, 500);
        },

        async sendMessage(text = null) {

            const input = text || this.userInput.trim();
            if (!input) return;

            // Immediately clear all suggestions from previous messages to lock the flow
            this.messages.forEach(m => m.suggestions = []);

            this.messages.push({ type: 'user', text: input });
            this.userInput = '';
            
            this.isTyping = true;
            this.scrollToBottom();

            // AI-Style processing delay
            setTimeout(() => {
                const responseObj = this.findResponse(input);
                this.messages.push({ 
                    type: 'bot', 
                    text: responseObj.text, 
                    suggestions: responseObj.suggestions || []
                });
                this.isTyping = false;
                this.scrollToBottom();
            }, 1000 + Math.random() * 500); // Dynamic delay for realism
        },

        findResponse(input) {
            const query = input.toLowerCase();
            let bestMatch = null;
            let maxKeywords = 0;
            
            if(!this.config.nodes) return this.config.fallback;

            for (const item of this.config.nodes) {
                const matchedKeywords = item.match.filter(k => query.includes(k.toLowerCase()));
                if (matchedKeywords.length > maxKeywords) {
                    maxKeywords = matchedKeywords.length;
                    bestMatch = item;
                }
            }
            
            return bestMatch || this.config.fallback;
        },

        handleAction(action, targetStr = null) {
            // Lock UI
            this.messages.forEach(m => m.suggestions = []);

            if (action === 'goto_node') {
                const node = this.config.nodes.find(n => n.id === targetStr);
                if (node) {
                    this.messages.push({ type: 'user', text: targetStr.replace('node_', '').toUpperCase() });
                    this.isTyping = true;
                    this.scrollToBottom();
                    
                    setTimeout(() => {
                        this.messages.push({ 
                            type: 'bot', 
                            text: node.text, 
                            suggestions: node.suggestions || []
                        });
                        this.isTyping = false;
                        this.scrollToBottom();
                    }, 800);
                } else {
                    this.sendMessage(targetStr);
                }
            } else if (action === 'send_msg') {
                this.sendMessage(targetStr);
            } else if (action === 'reset') {
                this.resetChat();
            } else if (action === 'whatsapp') {
                const phone = this.config.identity.whatsapp || '919999999999';
                window.open(`https://wa.me/${phone}?text=Hi NuMinds, I was talking to your AI Agent and I would like to consult about replacing my digital systems.`, '_blank');
                this.resetChat();
            } else if (action === 'open_estimator') {
                window.location.href = '<?= url("estimator.php") ?>';
                this.isOpen = false;
            } else if (action === 'scroll_to_services') {
                window.location.href = '<?= url("services.php") ?>';
                this.isOpen = false;
            } else if (action === 'scroll_to_portfolio') {
                window.location.href = '<?= url("works.php") ?>';
                this.isOpen = false;
            } else if (action === 'open_lead_modal') {
                // Dispatch event instead of modifying strict scope
                window.dispatchEvent(new CustomEvent('open-modal'));
                this.isOpen = false;
            } else {
                // Fallback catch-all if action is missing but clicked
                if(targetStr) this.sendMessage(targetStr);
            }
        },


        scrollToBottom() {
            setTimeout(() => {
                const el = document.getElementById('messageArea');
                if(el) el.scrollTop = el.scrollHeight;
            }, 50);
        }
    }
}
</script>
