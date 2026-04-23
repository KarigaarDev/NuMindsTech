<?php
require_once '../app/config/db.php';
require_once '../app/core/helpers.php';
require_once '../app/core/Email.php';

Auth::startSession();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    Csrf::verify();
    
    $email = trim($_POST['email'] ?? '');
    
    if (empty($email)) {
        $error = 'Please enter your email address.';
    } else {
        if (Auth::requestPasswordReset($pdo, $email)) {
            $success = 'If an account exists with this email, you will receive a reset link shortly.';
        } else {
            $error = 'Failed to process request. Please try again later.';
        }
    }
}

$title = 'Forgot Password';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?> | NuMinds Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Fonts: Outfit & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons: FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <?php require __DIR__ . '/../app/config/tailwind.php'; ?>
    
    <style>
        body { background: radial-gradient(circle at top right, #1b2434, #050b14); }
        .glow-orb { position: absolute; width: 400px; height: 400px; border-radius: 50%; filter: blur(80px); opacity: 0.15; z-index: 0; pointer-events: none; animation: float 20s infinite alternate; }
        @keyframes float { 0% { transform: translate(0, 0) scale(1); } 100% { transform: translate(100px, 50px) scale(1.1); } }
        .glass-card { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.08); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); }
        .premium-input { background: rgba(255, 255, 255, 0.02); border-bottom: 2px solid rgba(255, 255, 255, 0.05); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .premium-input:focus { border-bottom-color: #2563eb; background: rgba(37, 99, 235, 0.03); }
        .btn-premium { background: linear-gradient(135deg, #2563eb, #1e40af); transition: all 0.3s ease; }
        .btn-premium:hover { transform: translateY(-2px); box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.4); }
    </style>
</head>
<body class="font-sans h-screen flex items-center justify-center p-6 text-slate-300 overflow-hidden relative">

<!-- Animated Background Elements -->
<div class="glow-orb bg-brand-primary" style="top: -100px; left: -100px;"></div>
<div class="glow-orb bg-brand-accent" style="bottom: -150px; right: -50px; animation-delay: -5s;"></div>

<div class="w-full max-w-[440px] relative z-10 animate-in fade-in zoom-in-95 duration-700">
    <div class="glass-card p-10 md:p-14 rounded-[3rem]">
        
        <!-- Header -->
        <div class="text-center mb-16">
            <h1 class="font-display text-3xl font-bold text-white tracking-tight mb-2">Access <span class="text-brand-accent">Recovery</span></h1>
            <p class="text-[9px] uppercase tracking-[0.4em] font-bold text-slate-500">Restore your identity</p>
        </div>

        <?php if ($error): ?>
            <div class="bg-red-500/5 border border-red-500/10 p-4 rounded-2xl mb-10 flex items-center gap-3">
                <i class="fa-solid fa-triangle-exclamation text-red-500 text-sm"></i>
                <p class="text-[10px] text-red-200/80 font-bold uppercase tracking-widest"><?= $error ?></p>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="bg-emerald-500/5 border border-emerald-500/10 p-6 rounded-3xl mb-10">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/20 flex items-center justify-center">
                        <i class="fa-solid fa-check text-emerald-500"></i>
                    </div>
                    <p class="text-[11px] font-bold text-emerald-200 uppercase tracking-widest leading-relaxed">System Response Generated</p>
                </div>
                <p class="text-sm text-slate-400 mb-8"><?= $success ?></p>
                <a href="<?= url('public/login.php') ?>" class="btn-premium block text-center text-white font-display font-extrabold py-4 rounded-2xl text-[10px] uppercase tracking-[0.3em]">
                    Back to Terminal
                </a>
            </div>
        <?php else: ?>
            <form method="post" class="space-y-12">
                <?= csrf_field() ?>
                
                <div class="space-y-4">
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.3em]">Registered Email</label>
                    <div class="relative">
                        <i class="fa-solid fa-envelope absolute left-0 top-1/2 -translate-y-1/2 text-slate-700"></i>
                        <input name="email" type="email" required placeholder="admin@numinds.tech"
                               class="premium-input w-full py-4 pl-8 focus:outline-none text-sm text-white placeholder:text-slate-700 tracking-wide">
                    </div>
                </div>

                <button class="btn-premium w-full text-white font-display font-extrabold py-6 rounded-2xl text-[11px] uppercase tracking-[0.4em] shadow-2xl flex items-center justify-center gap-3 group">
                    Send Link
                    <i class="fa-solid fa-paper-plane text-[10px] group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform"></i>
                </button>

                <div class="text-center pt-8">
                    <a href="<?= url('public/login.php') ?>" class="text-[10px] font-bold text-slate-500 uppercase tracking-widest hover:text-brand-accent transition-all">
                        <i class="fa-solid fa-chevron-left mr-2"></i> Return to Login
                    </a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
