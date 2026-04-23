<?php
require_once '../app/config/db.php';
require_once '../app/core/helpers.php';
Auth::startSession();

date_default_timezone_set('Asia/Kolkata');

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
                Logger::security('LOGIN_SUCCESSFUL', 'User successfully established a session', [
                    'user_id' => $user['id'],
                    'email' => $email,
                    'role' => $user['role'] ?? 'admin'
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
    <title>Sign In | NuMinds Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Fonts: Outfit & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons: FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <?php require __DIR__ . '/../app/config/tailwind.php'; ?>
    
    <style>
        [x-cloak] { display: none !important; }
        
        body {
            background: radial-gradient(circle at top right, #1b2434, #050b14);
        }

        .glow-orb {
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.15;
            z-index: 0;
            pointer-events: none;
            animation: float 20s infinite alternate;
        }

        @keyframes float {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(100px, 50px) scale(1.1); }
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .input-group:focus-within label {
            color: #2563eb;
            transform: translateY(-2px);
        }

        .premium-input {
            background: rgba(255, 255, 255, 0.02);
            border-bottom: 2px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .premium-input:focus {
            border-bottom-color: #2563eb;
            background: rgba(37, 99, 235, 0.03);
            box-shadow: 0 10px 15px -10px rgba(37, 99, 235, 0.1);
        }

        .btn-premium {
            background: linear-gradient(135deg, #2563eb, #1e40af);
            transition: all 0.3s ease;
        }

        .btn-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.4);
        }
    </style>
</head>
<body class="font-sans h-screen flex items-center justify-center p-6 text-slate-300 overflow-hidden relative" x-data="{ showPass: false }">

<!-- Animated Background Elements -->
<div class="glow-orb bg-brand-primary" style="top: -100px; left: -100px;"></div>
<div class="glow-orb bg-brand-accent" style="bottom: -150px; right: -50px; animation-delay: -5s;"></div>

<!-- Background Grid Overlay -->
<div class="absolute inset-0 opacity-[0.03] pointer-events-none">
    <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <pattern id="grid" width="60" height="60" patternUnits="userSpaceOnUse">
                <path d="M 60 0 L 0 0 0 60" fill="none" stroke="white" stroke-width="0.5"/>
            </pattern>
        </defs>
        <rect width="100%" height="100%" fill="url(#grid)" />
    </svg>
</div>

<div class="w-full max-w-[440px] relative z-10 animate-in fade-in zoom-in-95 duration-700">
    <div class="glass-card p-10 md:p-14 rounded-[3rem]">
        
        <!-- Header -->
        <div class="text-center mb-16">
            <a href="<?= url('') ?>" class="inline-flex flex-col items-center gap-6 group">
                <div class="relative">
                    <div class="absolute inset-0 bg-brand-primary blur-2xl opacity-20 group-hover:opacity-40 transition-opacity"></div>
                    <div class="w-16 h-16 rounded-2xl bg-brand-primary flex items-center justify-center shadow-2xl relative z-10">
                        <span class="font-display font-black text-white text-3xl">N</span>
                    </div>
                </div>
                <div class="space-y-2">
                    <h1 class="font-display text-3xl font-bold text-white tracking-tight">NuMinds <span class="text-brand-accent">Console</span></h1>
                    <div class="flex items-center justify-center gap-2">
                        <span class="h-px w-4 bg-slate-700"></span>
                        <p class="text-[9px] uppercase tracking-[0.4em] font-bold text-slate-500">Secure Access Point</p>
                        <span class="h-px w-4 bg-slate-700"></span>
                    </div>
                </div>
            </a>
        </div>

        <!-- Error Message -->
        <?php if ($error): ?>
            <div class="bg-red-500/5 border border-red-500/10 p-4 rounded-2xl mb-10 flex items-center gap-3 animate-in fade-in slide-in-from-top-4 duration-500" x-data="{ show: true }" x-show="show" x-transition>
                <div class="w-8 h-8 rounded-lg bg-red-500/10 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-triangle-exclamation text-red-500 text-sm"></i>
                </div>
                <p class="text-[10px] text-red-200/80 font-bold uppercase tracking-widest leading-relaxed flex-1"><?= $error ?></p>
                <button @click="show = false" class="text-red-500/50 hover:text-red-500 transition-colors">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
        <?php endif; ?>

        <form method="post" class="space-y-12">
            <?= csrf_field() ?>
            
            <div class="space-y-4 input-group">
                <div class="flex justify-between items-center">
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.3em] transition-all">Identity</label>
                    <i class="fa-solid fa-at text-[10px] text-slate-700"></i>
                </div>
                <div class="relative">
                    <input name="email" type="email" required placeholder="admin@numinds.tech"
                           class="premium-input w-full py-4 focus:outline-none text-sm text-white placeholder:text-slate-700 tracking-wide">
                </div>
            </div>

            <div class="space-y-4 input-group">
                <div class="flex justify-between items-center">
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.3em] transition-all">Secret key</label>
                    <button type="button" @click="showPass = !showPass" class="text-slate-700 hover:text-brand-primary transition-colors">
                        <i class="fa-solid" :class="showPass ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                </div>
                <div class="relative">
                    <input name="password" :type="showPass ? 'text' : 'password'" required placeholder="••••••••"
                           class="premium-input w-full py-4 focus:outline-none text-sm text-white placeholder:text-slate-700 tracking-[0.3em]">
                </div>
            </div>

            <div class="flex justify-end">
                <a href="<?= url('public/forgot-password.php') ?>" class="text-[10px] font-bold text-brand-primary uppercase tracking-widest hover:text-brand-accent transition-colors">
                    Lost access?
                </a>
            </div>

            <button class="btn-premium w-full text-white font-display font-extrabold py-6 rounded-2xl text-[11px] uppercase tracking-[0.4em] shadow-2xl flex items-center justify-center gap-3 group overflow-hidden relative">
                <span class="relative z-10 flex items-center gap-3">
                    Establish Session
                    <i class="fa-solid fa-arrow-right-to-bracket text-[10px] group-hover:translate-x-1 transition-transform"></i>
                </span>
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
            </button>

        </form>

        <div class="text-center pt-16">
            <a href="<?= url('') ?>" class="group inline-flex items-center gap-3 text-[10px] font-bold text-slate-500 uppercase tracking-widest hover:text-brand-accent transition-all">
                <i class="fa-solid fa-chevron-left group-hover:-translate-x-1 transition-transform"></i>
                Return to Public Site
            </a>
        </div>
    </div>
</div>

</body>
</html>

