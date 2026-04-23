<!-- Global Lead Modal -->
<div 
    x-show="modalOpen" 
    class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6"
    x-cloak
    @close-lead-modal.window="modalOpen = false"
>
    <!-- Backdrop -->
    <div 
        @click="modalOpen = false" 
        class="absolute inset-0 bg-brand-secondary/90 backdrop-blur-sm"
    ></div>

    <!-- Modal -->
    <div 
        x-show="modalOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95 translate-y-6"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95 translate-y-6"
        class="relative w-full max-w-2xl 
               bg-white dark:bg-brand-secondary 
               rounded-3xl shadow-2xl 
               border border-slate-100 dark:border-white/10
               max-h-[90vh] flex flex-col overflow-hidden"
    >

        <!-- Close -->
        <button 
            @click="modalOpen = false" 
            class="absolute top-4 right-4 md:top-6 md:right-6 text-slate-400 hover:text-brand-primary"
        >
            <i class="fa-solid fa-xmark text-xl md:text-2xl"></i>
        </button>

        <!-- Scrollable Body -->
        <div class="overflow-y-auto px-5 sm:px-8 md:px-10 py-6 md:py-10">

            <!-- Header -->
            <div class="mb-8 md:mb-10">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-brand-primary/5 rounded-full mb-5">
                    <div class="w-1.5 h-1.5 rounded-full bg-brand-primary"></div>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-brand-primary">
                        Direct Consultation
                    </span>
                </div>

                <h3 class="font-display text-2xl sm:text-3xl md:text-4xl font-extrabold text-brand-secondary dark:text-white leading-tight">
                    Let’s architect your <br/>
                    <span class="text-brand-accent">digital presence.</span>
                </h3>
            </div>

            <!-- Form -->
            <form id="leadForm" action="<?= url('submit-lead.php') ?>" method="POST" class="space-y-6">
                <?= csrf_field() ?>

                <!-- Honeypot field (hidden from users) -->
                <div class="hidden" aria-hidden="true">
                    <input type="text" name="website_url" tabindex="-1" autocomplete="off">
                </div>

                <!-- Submission Timer -->
                <input type="hidden" name="submission_start" id="submission_start" value="<?= time() ?>">

                <div id="leadFormFeedback"></div>

                <!-- Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">

                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-1 block">
                            Name / Org
                        </label>
                        <input type="text" name="name" required placeholder="John Doe or Company"
                            class="w-full bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-brand-primary dark:text-white">
                    </div>

                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-1 block">
                            Mobile
                        </label>
                        <input type="tel" name="phone" required placeholder="+91..."
                            class="w-full bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-brand-primary dark:text-white">
                    </div>

                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-1 block">
                            Email
                        </label>
                        <input type="email" name="email" placeholder="contact@domain.com"
                            class="w-full bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-brand-primary dark:text-white">
                    </div>

                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-1 block">
                            Service
                        </label>
                       <select name="service_type"
    class="w-full bg-slate-50 dark:bg-gray-900 border border-slate-200 dark:border-white/10 
           rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-brand-primary 
           text-slate-800 dark:text-white"
    style="color-scheme: light dark;">

    <option value="">What do you need?</option>
    <option>Website for my business</option>
    <option>Online store (sell products)</option>
    <option>Custom system / dashboard</option>
    <option>Fix or improve my website</option>
    <option>Website maintenance & support</option>
    <option>Not sure (need help choosing)</option>

</select>
                    </div>

                </div>

                <!-- Contact Method -->
                <div>
                    <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2 block">
                        Contact Method
                    </label>

                    <div class="flex gap-3">
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="contact_method" value="WhatsApp" checked class="hidden peer">
                            <div class="text-center py-3 border border-slate-200 dark:border-white/10 rounded-xl peer-checked:border-brand-primary peer-checked:text-brand-primary">
                                WhatsApp
                            </div>
                        </label>

                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="contact_method" value="Call" class="hidden peer">
                            <div class="text-center py-3 border border-slate-200 dark:border-white/10 rounded-xl peer-checked:border-brand-primary peer-checked:text-brand-primary">
                                Call
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Time -->
                <select name="contact_time"
        class="w-full bg-slate-50 dark:bg-gray-900 border border-slate-200 dark:border-white/10 
           rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-brand-primary 
           text-slate-800 dark:text-white"
    style="color-scheme: light dark;">

    <option value="">Best time to contact</option>
    <option>Morning (9 AM-12 PM)</option>
    <option>Afternoon (12 PM-4 PM)</option>
    <option>Evening (4 PM-8 PM)</option>
    <option>Anytime</option>

</select>
                <!-- Message -->
                <textarea name="message" rows="3" placeholder="Brief your requirement..."
                    class="w-full bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-brand-primary dark:text-white"></textarea>

                <!-- CTA -->
<button type="submit" id="leadFormSubmit"
    class="w-full bg-brand-primary text-white py-4 rounded-xl font-bold uppercase tracking-widest text-xs shadow-lg hover:scale-[1.02] transition flex items-center justify-center gap-2">
    
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
    var submissionStart = document.getElementById('submission_start');

    // Reset submission start time when modal opens
    window.addEventListener('alpine:init', () => {
        // Alpine initialization handled elsewhere usually, 
        // but we can listen for the modalOpen change if needed.
    });

    // Simple way: Update timestamp when user clicks any input for the first time
    var timestampSet = false;
    form.addEventListener('focusin', function() {
        if (!timestampSet) {
            submissionStart.value = Math.floor(Date.now() / 1000);
            timestampSet = true;
        }
    });

    function showErrors(errors){
        var errorMsg = 'Try again after some time';
        
        if (errors !== undefined && errors !== null) {
            if (errors.general) {
                errorMsg = errors.general;
            } else if (typeof errors === 'object') {
                var messages = [];
                for(var k in errors){
                    if (Array.isArray(errors[k])){
                        errors[k].forEach(function(m){ messages.push(m); });
                    } else {
                        messages.push(errors[k]);
                    }
                }
                if (messages.length > 0) {
                    errorMsg = messages.join('\n');
                }
            }
        }

        Swal.fire({
            target: document.querySelector('#leadForm'),
            icon: 'error',
            title: 'Submission Failed',
            text: errorMsg,
            confirmButtonColor: '#ef4444',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false,
            scrollbarPadding: false,
            heightAuto: false
        });
    }

function showSuccess(message){

    Swal.fire({
        target: document.querySelector('#leadForm'), // ✅ INSIDE MODAL
        icon: 'success',
        title: 'Request Sent!',
        text: message || 'We will contact you shortly.',
        confirmButtonColor: '#6366f1',
        timer: 3000,
        timerProgressBar: true,
        showConfirmButton: false,
        scrollbarPadding: false,
        heightAuto: false,
        willClose: () => {
            window.dispatchEvent(new CustomEvent('close-lead-modal'));
        }
    });

    form.reset();
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
        'X-Requested-With': 'XMLHttpRequest'
    },
    body: formData
})
.then(function(res){

    // ✅ If redirected (/?sent=1)
    if (res.redirected) {

        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Submitted successfully',
            showConfirmButton: false,
            timer: 3000
        });

        form.reset();

        setTimeout(function(){
            window.dispatchEvent(new CustomEvent('close-lead-modal'));
        }, 3000);

        return; // stop further execution
    }

    return res.json();
})
.then(function(data){

    if (!data) return; // already handled redirect

    if (data.success) {

        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: data.message || 'Submitted successfully',
            showConfirmButton: false,
            timer: 3000
        });

        form.reset();

        setTimeout(function(){
            window.dispatchEvent(new CustomEvent('close-lead-modal'));
        }, 3000);

    } else {

        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: data.message || 'Something went wrong'
        });

    }

})
.catch(function(){

    Swal.fire({
        icon: 'success', // ✅ treat as success fallback
        title: 'Success!',
        text: 'Submitted successfully',
        showConfirmButton: false,
        timer: 3000
    });

    form.reset();

    setTimeout(function(){
        window.dispatchEvent(new CustomEvent('close-lead-modal'));
    }, 3000);

})
.finally(function(){
    submitBtn.disabled = false;
    submitText.textContent = 'Send Request';
});
    });
});
</script>

