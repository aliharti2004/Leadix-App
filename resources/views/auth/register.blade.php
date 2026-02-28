<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - LeadiX</title>

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

            <!-- Register Card -->
            <div class="glass-card rounded-2xl p-8 shadow-2xl">
                <h2 class="text-3xl font-black text-white text-center mb-2">Create Your Account</h2>
                <p class="text-gray-400 text-center mb-8">Start controlling your revenue pipeline and financial tracking
                    today.</p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-semibold text-gray-300 mb-2">Full Name</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-500" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                                placeholder="John Doe"
                                class="w-full pl-10 pr-4 py-3 bg-gray-900/50 border border-gray-700 rounded-lg text-white placeholder-gray-500 transition">
                        </div>
                        @error('name')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-semibold text-gray-300 mb-2">Work Email</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-500" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                placeholder="john@company.com"
                                class="w-full pl-10 pr-4 py-3 bg-gray-900/50 border border-gray-700 rounded-lg text-white placeholder-gray-500 transition">
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
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
                        @error('password')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-6">
                        <label for="password_confirmation"
                            class="block text-sm font-semibold text-gray-300 mb-2">Confirm Password</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-500" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                placeholder="••••••••"
                                class="w-full pl-10 pr-4 py-3 bg-gray-900/50 border border-gray-700 rounded-lg text-white placeholder-gray-500 transition">
                        </div>
                        @error('password_confirmation')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full btn-gradient text-white font-bold py-3 px-6 rounded-lg shadow-lg mb-6">
                        Create Account
                    </button>

                    <!-- Terms -->
                    <p class="text-xs text-gray-500 text-center mb-6">
                        By creating an account, you agree to our
                        <a href="#" class="text-orange-500 hover:text-orange-400">Terms of Service</a> and
                        <a href="#" class="text-orange-500 hover:text-orange-400">Privacy Policy</a>
                    </p>
                </form>

                <!-- Login Link -->
                <p class="text-center text-sm text-gray-400">
                    Already have an account?
                    <a href="{{ route('login') }}"
                        class="text-orange-500 hover:text-orange-400 font-semibold transition">
                        Login Here
                    </a>
                </p>
            </div>

            <!-- Footer -->
            <p class="text-center text-xs text-gray-600 mt-8">
                © {{ date('Y') }} LeadiX Inc. Revenue Pipeline & Cashflow Control
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

</html>