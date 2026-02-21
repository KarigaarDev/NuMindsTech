<!-- Global Lead Modal -->
<div 
    x-show="modalOpen" 
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-[100] overflow-y-auto" 
    x-cloak
>
    <!-- Backdrop -->
    <div 
        @click="modalOpen = false" 
        class="fixed inset-0 bg-brand-secondary/95 transition-opacity"
    ></div>

    <!-- Modal Content -->
    <div class="flex min-h-full items-center justify-center p-4 sm:p-6 text-center">
        <div 
            x-show="modalOpen"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 scale-95 translate-y-8"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-8"
            class="relative w-full max-w-2xl transform overflow-hidden rounded-[2.5rem] bg-white dark:bg-brand-secondary p-8 md:p-12 text-left shadow-2xl transition-all border border-slate-100 dark:border-white/10"
        >
            <!-- Close Button -->
            <button 
                @click="modalOpen = false" 
                class="absolute top-8 right-8 text-slate-400 hover:text-brand-primary transition-colors"
            >
                <i class="fa-solid fa-xmark text-2xl"></i>
            </button>

            <!-- Header -->
            <div class="mb-10">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-brand-primary/5 rounded-full mb-6">
                    <div class="w-1.5 h-1.5 rounded-full bg-brand-primary"></div>
                    <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-brand-primary">Direct Consultation</span>
                </div>
                <h3 class="font-display text-3xl md:text-4xl font-extrabold text-brand-secondary dark:text-white tracking-tight leading-tight">
                    Let's architect your <br/><span class="text-brand-accent">digital presence.</span>
                </h3>
            </div>

            <!-- Form -->
            <form id="leadForm" action="<?= url('submit-lead.php') ?>" method="POST" class="space-y-8">
                <?= csrf_field() ?>
                <div id="leadFormFeedback" class="text-sm"></div>
                
                <div class="grid md:grid-cols-2 gap-x-8 gap-y-8">
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Full Name / Org</label>
                        <input type="text" name="name" required placeholder="John Doe or Acme Inc"
                               class="w-full bg-slate-50 dark:bg-white/5 border border-slate-100 dark:border-white/10 rounded-xl px-5 py-4 focus:outline-none focus:border-brand-primary dark:text-white transition-all placeholder:text-slate-300 dark:placeholder:text-slate-700 font-medium">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Mobile Connection</label>
                        <input type="tel" name="phone" required placeholder="+91 0000 000 000"
                               class="w-full bg-slate-50 dark:bg-white/5 border border-slate-100 dark:border-white/10 rounded-xl px-5 py-4 focus:outline-none focus:border-brand-primary dark:text-white transition-all placeholder:text-slate-300 dark:placeholder:text-slate-700 font-medium">
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-x-8 gap-y-8">
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Email Address</label>
                        <input type="email" name="email" placeholder="contact@domain.com"
                               class="w-full bg-slate-50 dark:bg-white/5 border border-slate-100 dark:border-white/10 rounded-xl px-5 py-4 focus:outline-none focus:border-brand-primary dark:text-white transition-all placeholder:text-slate-300 dark:placeholder:text-slate-700 font-medium">
                    </div>
                    <div class="space-y-2 text-left">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">System Interest</label>
                        <select name="service_type" class="w-full bg-slate-50 dark:bg-white/5 border border-slate-100 dark:border-white/10 rounded-xl px-5 py-4 focus:outline-none focus:border-brand-primary text-brand-secondary dark:text-white transition-all cursor-pointer font-medium appearance-none" style="color-scheme: dark;">
                            <option value="Website Development" class="text-slate-900">Informational Website</option>
                            <option value="Dashboard / Web App" class="text-slate-900">Internal Control Tool</option>
                            <option value="Maintenance" class="text-slate-900">Maintenance & Support</option>
                        </select>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-x-8 gap-y-8">
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Contact Preference</label>
                        <div class="flex gap-2">
                            <label class="flex-1">
                                <input type="radio" name="contact_method" value="WhatsApp" checked class="hidden peer">
                                <div class="w-full text-center py-3.5 border border-slate-100 dark:border-white/10 rounded-xl peer-checked:bg-brand-primary/10 peer-checked:border-brand-primary peer-checked:text-brand-primary cursor-pointer hover:bg-slate-50 dark:hover:bg-white/5 transition-all text-[10px] font-bold uppercase tracking-widest">WhatsApp</div>
                            </label>
                            <label class="flex-1">
                                <input type="radio" name="contact_method" value="Call" class="hidden peer">
                                <div class="w-full text-center py-3.5 border border-slate-100 dark:border-white/10 rounded-xl peer-checked:bg-brand-primary/10 peer-checked:border-brand-primary peer-checked:text-brand-primary cursor-pointer hover:bg-slate-50 dark:hover:bg-white/5 transition-all text-[10px] font-bold uppercase tracking-widest">Phone Call</div>
                            </label>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Preferred Timing</label>
                        <input type="text" name="contact_time" placeholder="e.g. Morning 10-12"
                               class="w-full bg-slate-50 dark:bg-white/5 border border-slate-100 dark:border-white/10 rounded-xl px-5 py-4 focus:outline-none focus:border-brand-primary dark:text-white transition-all placeholder:text-slate-300 dark:placeholder:text-slate-700 font-medium">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Mission Brief</label>
                    <textarea name="message" rows="3" placeholder="Briefly describe your goals..."
                               class="w-full bg-slate-50 dark:bg-white/5 border border-slate-100 dark:border-white/10 rounded-2xl px-5 py-4 focus:outline-none focus:border-brand-primary dark:text-white transition-all resize-none font-medium"></textarea>
                </div>
                
                <button id="leadFormSubmit" class="w-full btn-primary font-display font-extrabold py-5 rounded-2xl text-[11px] uppercase tracking-[0.3em] shadow-xl shadow-brand-primary/20 transition-all flex items-center justify-center gap-4">
                    <span id="leadFormSubmitText">Send Request</span>
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
    var form = document.getElementById('leadForm');
    var feedback = document.getElementById('leadFormFeedback');
    var submitBtn = document.getElementById('leadFormSubmit');
    var submitText = document.getElementById('leadFormSubmitText');

    function showErrors(errors){
        var html = '<div class="bg-red-50 border border-red-200 text-red-800 p-3 rounded mb-4">';
        html += '<ul class="list-disc pl-5">';
        for(var k in errors){
            if (Array.isArray(errors[k])){
                errors[k].forEach(function(msg){ html += '<li>'+msg+'</li>'; });
            } else {
                html += '<li>'+errors[k]+'</li>';
            }
        }
        html += '</ul></div>';
        feedback.innerHTML = html;
    }

    function showSuccess(message){
        feedback.innerHTML = '<div class="bg-green-50 border border-green-200 text-green-800 p-3 rounded mb-4">'+message+'</div>';
    }

    form.addEventListener('submit', function(e){
        e.preventDefault();
        feedback.innerHTML = '';
        submitBtn.disabled = true;
        submitText.textContent = 'Sending...';

        var formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: formData,
            credentials: 'same-origin'
        }).then(function(resp){
            if (resp.status === 422){
                return resp.json().then(function(json){ throw { type: 'validation', data: json }; });
            }
            if (!resp.ok){
                throw { type: 'error', status: resp.status };
            }
            return resp.json();
        }).then(function(json){
            if (json.success){
                showSuccess(json.message || 'Thanks — we will contact you soon.');
                form.reset();
            } else {
                showErrors({ general: json.message || 'Submission failed' });
            }
        }).catch(function(err){
            if (err.type === 'validation' && err.data && err.data.errors){
                showErrors(err.data.errors);
            } else {
                showErrors({ general: 'An unexpected error occurred. Please try again later.' });
            }
        }).finally(function(){
            submitBtn.disabled = false;
            submitText.textContent = 'Send Request';
        });
    });
});
</script>

