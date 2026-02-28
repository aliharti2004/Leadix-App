<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Leadix') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        slate: {
                            850: '#151f32',
                            900: '#0f172a',
                            950: '#020617',
                        },
                    }
                }
            }
        }
    </script>
</head>

<body class="font-sans text-gray-900 antialiased bg-slate-950">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div>
            <a href="/">
                <span class="text-4xl font-bold tracking-tighter text-white">LEAD<span
                        class="text-orange-500">IX</span></span>
            </a>
        </div>

        <div
            class="w-full sm:max-w-md mt-6 px-6 py-8 bg-slate-900 shadow-2xl overflow-hidden sm:rounded-lg border border-slate-800">
            {{ $slot }}
        </div>
    </div>
</body>

</html>