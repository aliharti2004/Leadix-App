<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - LeadiX</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #0a0a0a;
            color: white;
            overflow-x: hidden;
        }

        /* Particle Background */
        .sparkle-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .sparkle {
            position: absolute;
            background: #ff7300;
            border-radius: 50%;
            opacity: 0;
            box-shadow: 0 0 20px rgba(255, 115, 0, 1), 0 0 40px rgba(255, 115, 0, 0.5);
            animation: sparkle-float var(--duration) ease-out infinite;
        }

        @keyframes sparkle-float {
            0% {
                transform: translate(0, 0) scale(0.3);
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            50% {
                opacity: 0.8;
            }

            90% {
                opacity: 0.3;
            }

            100% {
                transform: translate(var(--end-x), var(--end-y)) scale(1);
                opacity: 0;
            }
        }

        /* Logo Animation */
        .logo-float {
            animation: logoFloat 3s ease-in-out infinite;
        }

        @keyframes logoFloat {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        /* Card Glassmorphism */
        .glass-card {
            background: rgba(20, 20, 20, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Input Focus */
        input:focus {
            border-color: rgba(255, 115, 0, 0.5);
            outline: none;
            box-shadow: 0 0 0 3px rgba(255, 115, 0, 0.1);
        }

        /* Button Animation */
        .btn-gradient {
            background: linear-gradient(135deg, #ff7300 0%, #ff9500 100%);
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(255, 115, 0, 0.4);
        }
    </style>
</head>

<body class="antialiased">

    <!-- Particle Background -->
    <div class="sparkle-container" id="sparkles"></div>

    <!-- Main Content -->
    <div class="relative min-h-screen flex items-center justify-center px-6 py-12 z-10">
        <div class="w-full max-w-md">
            <!-- Logo -->
            <div class="text-center mb-8">
                <img src="/images/leadix-logo-new.png" alt="LeadiX" class="h-16 w-auto mx-auto logo-float">
            </div>

            <!-- Login Card -->
            <div class="glass-card rounded-2xl p-8 shadow-2xl">
                <h2 class="text-3xl font-black text-white text-center mb-2">Welcome Back</h2>
                <p class="text-gray-400 text-center mb-8">Enter your credentials to access your dashboard</p>

                <form method="POST" action="<?php echo e(route('login')); ?>">
                    <?php echo csrf_field(); ?>

                    <!-- Email -->
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-semibold text-gray-300 mb-2">Email Address</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-500" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus
                                placeholder="name@company.com"
                                class="w-full pl-10 pr-4 py-3 bg-gray-900/50 border border-gray-700 rounded-lg text-white placeholder-gray-500 transition">
                        </div>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-500"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Password -->
                    <div class="mb-6">
                        <label for="password" class="block text-sm font-semibold text-gray-300 mb-2">Password</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-500" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <input id="password" type="password" name="password" required placeholder="••••••••"
                                class="w-full pl-10 pr-4 py-3 bg-gray-900/50 border border-gray-700 rounded-lg text-white placeholder-gray-500 transition">
                        </div>
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-500"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Remember & Forgot -->
                    <div class="flex items-center justify-between mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember"
                                class="w-4 h-4 rounded border-gray-700 bg-gray-900 text-orange-500 focus:ring-orange-500 focus:ring-offset-0">
                            <span class="ml-2 text-sm text-gray-400">Remember me</span>
                        </label>
                        <?php if(Route::has('password.request')): ?>
                            <a href="<?php echo e(route('password.request')); ?>"
                                class="text-sm text-orange-500 hover:text-orange-400 transition">
                                Forgot Password?
                            </a>
                        <?php endif; ?>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full btn-gradient text-white font-bold py-3 px-6 rounded-lg shadow-lg flex items-center justify-center gap-2 mb-6">
                        Log In
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </button>

                    <!-- Divider -->
                    <div class="relative mb-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-700"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-gray-900/50 text-gray-500">Or continue with</span>
                        </div>
                    </div>

                    <!-- Social Login -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <button type="button"
                            class="flex items-center justify-center gap-2 px-4 py-3 bg-gray-900/50 border border-gray-700 rounded-lg text-gray-300 hover:bg-gray-800 hover:border-gray-600 transition">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                                    fill="#4285F4" />
                                <path
                                    d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                                    fill="#34A853" />
                                <path
                                    d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                                    fill="#FBBC05" />
                                <path
                                    d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                                    fill="#EA4335" />
                            </svg>
                            Google
                        </button>
                        <button type="button"
                            class="flex items-center justify-center gap-2 px-4 py-3 bg-gray-900/50 border border-gray-700 rounded-lg text-gray-300 hover:bg-gray-800 hover:border-gray-600 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2C6.477 2 2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879V14.89h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.989C18.343 21.129 22 16.99 22 12c0-5.523-4.477-10-10-10z" />
                            </svg>
                            SSO
                        </button>
                    </div>
                </form>

                <!-- Register Link -->
                <p class="text-center text-sm text-gray-400">
                    Don't have an account?
                    <a href="<?php echo e(route('register')); ?>"
                        class="text-orange-500 hover:text-orange-400 font-semibold transition">
                        Register Here
                    </a>
                </p>
            </div>

            <!-- Footer -->
            <p class="text-center text-xs text-gray-600 mt-8">
                © <?php echo e(date('Y')); ?> LeadiX Inc. Revenue Pipeline & Cashflow Control
            </p>
        </div>
    </div>

    <!-- Particle Script -->
    <script>
        const sparkleContainer = document.getElementById('sparkles');
        const sparkleCount = 100;

        for (let i = 0; i < sparkleCount; i++) {
            const sparkle = document.createElement('div');
            sparkle.classList.add('sparkle');

            const size = Math.random() * 6 + 2;
            const angle = (Math.PI * 2 * i) / sparkleCount + (Math.random() * 0.5);
            const burstDistance = Math.random() * 60 + 40;

            const endX = Math.cos(angle) * burstDistance;
            const endY = Math.sin(angle) * burstDistance;

            const duration = Math.random() * 4 + 3;
            const delay = Math.random() * 4;

            sparkle.style.width = `${size}px`;
            sparkle.style.height = `${size}px`;
            sparkle.style.left = `50%`;
            sparkle.style.top = `50%`;
            sparkle.style.setProperty('--end-x', `${endX}vh`);
            sparkle.style.setProperty('--end-y', `${endY}vh`);
            sparkle.style.setProperty('--duration', `${duration}s`);
            sparkle.style.animationDelay = `-${delay}s`;

            sparkleContainer.appendChild(sparkle);
        }
    </script>
</body>

</html><?php /**PATH C:\Users\dell\.gemini\antigravity\scratch\leadix-app\resources\views/auth/login.blade.php ENDPATH**/ ?>