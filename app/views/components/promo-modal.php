<?php
$promoActive = setting('promo_active', '0') === '1';
if (!$promoActive) return;

$promoTitle = setting('promo_title', 'Exclusive Offer');
$promoText = setting('promo_text', 'Sign up today and accelerate your business growth.');
$promoImage = setting('promo_image', '');

$imgSrc = $promoImage ? url('public/uploads/' . $promoImage) : url('public/images/hero-bg.jpg');
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div 
x-data="{ 
    promoOpen: false,
    loading: false,

    init() {
        const closedAt = localStorage.getItem('promoClosedAt');
        const now = new Date().getTime();

        if (!closedAt || now - closedAt > 86400000) {
            setTimeout(() => this.promoOpen = true, 2000);
        }
    },

    closePromo() {
        this.promoOpen = false;
        localStorage.setItem('promoClosedAt', new Date().getTime());
    },

    async submitForm(e) {
        e.preventDefault();
        if (this.loading) return;

        this.loading = true;

        const form = e.target;
        const formData = new FormData(form);

        try {
            const res = await fetch(form.action, {
                method: 'POST',
                body: formData
            });

            const data = await res.json();

            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Submitted successfully',
                    showConfirmButton: false,
                    timer: 3000
                });

                form.reset();

                setTimeout(() => {
                    this.closePromo();
                }, 3000);

            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Something went wrong'
                });
            }

        } catch (err) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Network issue'
            });
        }

        this.loading = false;
    }
}" 

class="relative z-[100]"
@keydown.escape.window="closePromo"
>

<!-- BACKDROP -->
<div x-show="promoOpen"
     x-transition.opacity
     class="fixed inset-0 bg-black/60 backdrop-blur-sm"
     @click="closePromo"
     style="display:none;">
</div>

<!-- MODAL WRAPPER -->
<div x-show="promoOpen"
     x-transition
     class="fixed inset-0 flex items-end md:items-center justify-center px-16 md:p-6"
     style="display:none;">

<!-- MODAL -->
<div class="w-full md:max-w-5xl bg-white dark:bg-brand-navy 
            rounded-t-3xl md:rounded-3xl shadow-2xl 
            flex flex-col md:flex-row 
           ">


<!-- IMAGE -->
<div class="w-full md:w-1/2 h-44 md:h-auto relative flex-shrink-0">

    <img src="<?= e($imgSrc) ?>"
         class="absolute inset-0 w-full h-full object-cover">

    <div class="absolute inset-0 bg-gradient-to-t md:bg-gradient-to-r from-black/70 to-transparent"></div>

    <!-- CLOSE BUTTON (FIXED POSITION) -->
    <button @click="closePromo"
        class="absolute top-2 right-2 md:top-4 md:right-4 z-30
        w-11 h-11 md:w-12 md:h-12
        bg-black/50 hover:bg-black/70
        text-white rounded-full
        flex items-center justify-center
        backdrop-blur-md transition-all
        hover:scale-110 active:scale-95">

        <i class="fa-solid fa-xmark text-lg"></i>
    </button>

</div>
<!-- CONTENT -->
<div class="w-full md:w-1/2">

<!-- SCROLL AREA -->
<div class="p-4 sm:p-6 md:p-10">

<h2 class="text-xl sm:text-2xl md:text-3xl font-bold mb-2">
<?= e($promoTitle) ?>
</h2>

<p class="text-sm text-gray-500 mb-5">
<?= e($promoText) ?>
</p>

<form action="<?= url('submit-lead.php') ?>"
      method="POST"
      @submit="submitForm"
      class="space-y-3">

<?= csrf_field() ?>

<input type="hidden" name="service_type" value="[PROMO LEAD]">

<input type="text" name="name" required
placeholder="Full Name"
class="w-full border text-black rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-brand-primary">

<div class="grid grid-cols-1 sm:grid-cols-2 gap-3">

<input type="email" name="email" required
placeholder="Email"
class="w-full border text-black rounded-xl px-4 py-3 text-sm">

<input type="tel" name="phone" required
placeholder="Phone"
class="w-full border   text-black rounded-xl px-4 py-3 text-sm">

</div>

<textarea name="message" required rows="2"
placeholder="Tell us your need..."
class="w-full border text-black rounded-xl px-4 py-3 text-sm resize-none"></textarea>

</div>

<!-- STICKY BUTTON (MOBILE MAGIC) -->
<div class="p-4 border-t bg-white dark:bg-brand-navy">

<button type="submit"
:disabled="loading"
class="w-full bg-brand-primary text-white py-4 rounded-xl font-semibold flex justify-center items-center">

<span x-show="!loading">Claim Offer →</span>
<span x-show="loading">Sending...</span>

</button>

<p class="text-[10px] text-center text-gray-400 mt-2">
We respect your privacy
</p>

</div>

</form>

</div>
</div>

</div>
</div>