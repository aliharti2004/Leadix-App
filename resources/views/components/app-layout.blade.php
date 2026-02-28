<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Leadix') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Tailwind CDN (since we are transitioning) -->
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

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- CRITICAL: Load after Tailwind to override utility classes -->
    <link rel="stylesheet" href="/css/btn-gradient-override.css">

    <!-- Notification System -->
    <script src="/js/notification-sounds.js"></script>
    <script src="/js/notification-poller.js"></script>

    <style>
        html,
        body {
            overflow-x: hidden !important;
            overflow-y: auto !important;
            height: auto !important;
            max-height: none !important;
            min-height: 100vh;
        }

        body {
            background-color: #0a0a0a;
            color: white;
        }

        /* Orange Sparkles Background */
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

        /* Glassmorphism */
        .glass-header {
            background: rgba(20, 20, 20, 0.6);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #0a0a0a;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(255, 115, 0, 0.3);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 115, 0, 0.5);
        }

        [x-cloak] {
            display: none !important;
        }

        /* Force scrollable layout */
        main {
            overflow: visible !important;
        }

        /* Navigation gradient button - MAXIMUM specificity to override Tailwind */
        nav a.btn-gradient,
        nav .btn-gradient,
        a.btn-gradient.flex,
        .btn-gradient,
        [class*="btn-gradient"] {
            background: linear-gradient(135deg, #ff7300 0%, #ff9500 100%) !important;
            background-color: #ff7300 !important;
            background-image: linear-gradient(135deg, #ff7300 0%, #ff9500 100%) !important;
        }
    </style>
</head>

<body class="font-sans antialiased">

    <!-- Sparkle Background Container -->
    <div class="sparkle-container" id="sparkles"></div>

    <div class="relative z-10" x-data="{ sidebarOpen: false }">

        <!-- Sidebar -->
        @include('layouts.navigation.sidebar')

        <!-- Main Content Wrapper -->
        <div class="md:ml-52 transition-all duration-300 ease-in-out">

            {{-- Top Navigation Bar --}}
            @include('layouts.partials.top-navigation')

            <!-- Page Content -->
            <main class="p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    <script>
        // Sparkle Animation
        function createSparkles() {
            const container = document.getElementById('sparkles');
            setInterval(() => {
                const sparkle = document.createElement('div');
                sparkle.className = 'sparkle';

                const size = Math.random() * 3 + 2;
                sparkle.style.width = size + 'px';
                sparkle.style.height = size + 'px';
                sparkle.style.left = Math.random() * 100 + '%';
                sparkle.style.bottom = '0';

                const duration = Math.random() * 3 + 3;
                const endX = (Math.random() - 0.5) * 200;
                const endY = -(Math.random() * 300 + 200);

                sparkle.style.setProperty('--duration', duration + 's');
                sparkle.style.setProperty('--end-x', endX + 'px');
                sparkle.style.setProperty('--end-y', endY + 'px');

                container.appendChild(sparkle);

                setTimeout(() => sparkle.remove(), duration * 1000);
            }, 200);
        }

        createSparkles();
    </script>
</body>

</html>