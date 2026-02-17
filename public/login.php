<?php
session_start();
date_default_timezone_set('Asia/Kolkata');
require_once '../app/config/db.php';
require_once '../app/core/helpers.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    Csrf::verify();

    // Check rate limiting (max 5 login attempts per hour)
    $rateLimiter = new RateLimiter('login', 5, 3600);
    if ($rateLimiter->isLimited()) {
        Logger::security('LOGIN_RATE_LIMIT_EXCEEDED', 'Too many login attempts', [
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'email' => $_POST['email'] ?? 'unknown'
        ]);
        $error = 'Too many login attempts. ' . $rateLimiter->getWaitMessage();
    } else {
        // Validate input
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ];

        if (!Validator::validate($_POST, $rules)) {
            Logger::security('LOGIN_VALIDATION_FAILED', 'Login form validation failed', [
                'ip_address' => $_SERVER['REMOTE_ADDR'],
                'errors' => Validator::errors()
            ]);
            $error = 'Invalid login details';
        } else {
            // Sanitize input
            $email = Validator::sanitizeEmail($_POST['email']);
            $password = $_POST['password'];

            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['role'] = $user['role'] ?? 'admin';

                // Update login telemetry
                $stmt = $pdo->prepare("UPDATE users SET last_login = NOW(), login_ip = ? WHERE id = ?");
                $stmt->execute([$_SERVER['REMOTE_ADDR'], $user['id']]);

                // Log successful login
                Logger::info('User login successful', [
                    'user_id' => $user['id'],
                    'email' => $email,
                    'ip_address' => $_SERVER['REMOTE_ADDR']
                ]);

                // Role-based redirection
                if ($user['role'] === 'client') {
                    redirect('client-dashboard');
                } else {
                    redirect('dashboard');
                }
                exit;
            } else {
                // Record the attempt for rate limiting
                $rateLimiter->recordAttempt();

                Logger::security('LOGIN_FAILED', 'Invalid login attempt', [
                    'email' => $email,
                    'ip_address' => $_SERVER['REMOTE_ADDR']
                ]);

                $error = 'Invalid login details';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign In | NuMinds Tech</title>
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
    </style>
</head>
<body class="bg-brand-secondary font-sans h-screen flex items-center justify-center p-6 text-slate-300 overflow-hidden relative">

<!-- Background Grid -->
<div class="absolute inset-0 opacity-5 pointer-events-none">
    <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="0.5"/>
            </pattern>
        </defs>
        <rect width="100%" height="100%" fill="url(#grid)" />
    </svg>
</div>

<div class="w-full max-w-md relative z-10">
    <div class="bg-brand-navy border border-white/5 p-10 md:p-14 rounded-[2.5rem] shadow-2xl">
        
        <!-- Header -->
        <div class="text-center mb-12">
            <a href="<?= url('') ?>" class="inline-flex flex-col items-center gap-4 group">
                <div class="w-14 h-14 rounded-2xl bg-brand-primary flex items-center justify-center shadow-lg shadow-brand-primary/20">
                    <span class="font-display font-extrabold text-white text-2xl">N</span>
                </div>
                <div class="space-y-1">
                    <h1 class="font-display text-2xl font-bold text-white tracking-tight">NuMinds <span class="text-brand-accent">Tech</span></h1>
                    <p class="text-[9px] uppercase tracking-[0.4em] font-bold text-slate-500">Management Console</p>
                </div>
            </a>
        </div>

        <!-- Error Message -->
        <?php if ($error): ?>
            <div class="bg-red-500/10 border border-red-500/20 p-4 rounded-xl mb-8 flex items-center gap-3 animate-in fade-in slide-in-from-top-2">
                <i class="fa-solid fa-circle-exclamation text-red-400"></i>
                <p class="text-[10px] text-red-200 font-bold uppercase tracking-widest"><?= $error ?></p>
            </div>
        <?php endif; ?>

        <form method="post" class="space-y-10">
            <?= csrf_field() ?>
            
            <div class="space-y-3">
                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.3em]">Authorized Email</label>
                <div class="relative">
                    <i class="fa-solid fa-envelope absolute left-0 top-1/2 -translate-y-1/2 text-slate-700"></i>
                    <input name="email" type="email" required placeholder="admin@numindstech.com"
                           class="w-full bg-transparent border-b-2 border-slate-800 py-3 pl-8 focus:outline-none focus:border-brand-primary transition-all text-sm text-white placeholder:text-slate-700">
                </div>
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.3em]">Secure Password</label>
                <div class="relative">
                    <i class="fa-solid fa-lock absolute left-0 top-1/2 -translate-y-1/2 text-slate-700"></i>
                    <input name="password" type="password" required placeholder="••••••••"
                           class="w-full bg-transparent border-b-2 border-slate-800 py-3 pl-8 focus:outline-none focus:border-brand-primary transition-all text-sm text-white placeholder:text-slate-700">
                </div>
            </div>

            <button class="w-full bg-brand-primary text-white font-display font-extrabold py-6 rounded-2xl text-[11px] uppercase tracking-[0.3em] shadow-xl shadow-brand-primary/20 hover:bg-brand-primary/90 transition-all flex items-center justify-center gap-3 group">
                Establish Session
                <i class="fa-solid fa-key text-[10px] group-hover:rotate-12 transition-transform"></i>
            </button>
        </form>

        <div class="text-center pt-12">
            <a href="<?= url('') ?>" class="text-[10px] font-bold text-slate-500 uppercase tracking-widest hover:text-brand-accent transition-colors flex items-center justify-center gap-2">
                <i class="fa-solid fa-arrow-left"></i>
                Public Interface
            </a>
        </div>
    </div>
</div>

</body>
</html>

