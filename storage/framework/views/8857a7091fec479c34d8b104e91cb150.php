<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LeadiX - Stop Revenue Leaks</title>

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

        /* Card Hover Effects */
        .feature-card,
        .pricing-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255, 115, 0, 0.1);
            background: rgba(20, 20, 20, 0.6);
            backdrop-filter: blur(10px);
        }

        .feature-card:hover {
            transform: translateY(-8px) scale(1.02);
            border-color: rgba(255, 115, 0, 0.5);
            box-shadow: 0 20px 60px rgba(255, 115, 0, 0.2), 0 0 40px rgba(255, 115, 0, 0.1);
            background: rgba(30, 30, 30, 0.8);
        }

        .pricing-card:hover {
            transform: translateY(-12px) scale(1.03);
            border-color: rgba(255, 115, 0, 0.6);
            box-shadow: 0 25px 70px rgba(255, 115, 0, 0.25), 0 0 50px rgba(255, 115, 0, 0.15);
            background: rgba(30, 30, 30, 0.9);
        }

        .pricing-card.popular {
            border-color: rgba(255, 115, 0, 0.5);
            background: rgba(30, 20, 10, 0.8);
        }

        .pricing-card.popular:hover {
            border-color: rgba(255, 115, 0, 0.8);
        }

        /* Icon Glow */
        .icon-glow {
            background: rgba(255, 115, 0, 0.1);
            box-shadow: 0 0 20px rgba(255, 115, 0, 0.3);
            transition: all 0.3s ease;
        }

        .feature-card:hover .icon-glow {
            box-shadow: 0 0 30px rgba(255, 115, 0, 0.6);
            background: rgba(255, 115, 0, 0.2);
        }

        /* Button Gradient */
        .btn-gradient {
            background: linear-gradient(135deg, #ff7300 0%, #ff9500 100%);
            box-shadow: 0 4px 20px rgba(255, 115, 0, 0.3);
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            box-shadow: 0 8px 30px rgba(255, 115, 0, 0.5);
            transform: translateY(-2px) scale(1.05);
        }

        /* Testimonial Card */
        .testimonial-card {
            background: rgba(20, 20, 20, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
        }

        .testimonial-card:hover {
            border-color: rgba(255, 115, 0, 0.3);
            transform: translateY(-4px);
        }

        /* Rotating Text Fade */
        #rotating-text {
            transition: opacity 0.3s ease-in-out;
        }

        /* Cursor Spotlight Effect on Cards */
        .feature-card,
        .pricing-card {
            position: relative;
            overflow: hidden;
        }

        .feature-card::before,
        .pricing-card::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255, 115, 0, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 1;
        }

        .feature-card:hover::before,
        .pricing-card:hover::before {
            opacity: 1;
        }
    </style>
</head>

<body class="antialiased">

    <!-- Sparkle Background Container -->
    <div class="sparkle-container" id="sparkles"></div>

    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 backdrop-blur-sm bg-transparent border-b border-white/5">
        <div class="max-w-7xl mx-auto px-8 h-24 flex items-center justify-between">
            <!-- Logo -->
            <a href="/" class="flex items-center">
                <img src="/images/leadix-logo-new.png" alt="LeadiX" class="h-24 w-auto logo-float">
            </a>

            <!-- Menu Links -->
            <div class="hidden md:flex items-center gap-12">
                <a href="#features"
                    class="text-xl text-gray-400 font-semibold hover:text-white transition-colors">Features</a>
                <a href="#pricing"
                    class="text-xl text-gray-400 font-semibold hover:text-white transition-colors">Pricing</a>
                <a href="#about"
                    class="text-xl text-gray-400 font-semibold hover:text-white transition-colors">About</a>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-5">
                <!-- Languages -->
                <div class="hidden md:flex items-center gap-3">
                    <button class="px-3 py-1.5 text-base font-bold text-orange-500">EN</button>
                    <span class="text-gray-600">|</span>
                    <button
                        class="px-3 py-1.5 text-base font-bold text-gray-400 hover:text-orange-500 transition">FR</button>
                    <span class="text-gray-600">|</span>
                    <button
                        class="px-3 py-1.5 text-base font-bold text-gray-400 hover:text-orange-500 transition">AR</button>
                </div>

                <a href="<?php echo e(route('login')); ?>"
                    class="hidden md:block text-xl text-gray-300 hover:text-white px-5 py-2.5 font-semibold transition">Login</a>
                <a href="<?php echo e(route('register')); ?>"
                    class="bg-orange-500 hover:bg-orange-600 text-white text-lg font-bold px-8 py-3 rounded-full shadow-lg hover:shadow-xl transition-all duration-300">Get
                    Started</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-48 pb-32 px-6 text-center z-10">
        <div class="max-w-6xl mx-auto">
            <div
                class="inline-block px-6 py-2.5 rounded-full border border-orange-500/40 bg-orange-500/10 text-orange-500 text-base font-bold mb-10 uppercase tracking-widest">
                Revenue Intelligence Platform
            </div>
            <h1 class="text-6xl md:text-7xl lg:text-8xl font-black text-white leading-tight mb-8">
                Stop Revenue Leaks. <br>
                Start <span id="rotating-text"
                    class="text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-amber-500">Growing.</span>
            </h1>
            <p class="text-xl md:text-2xl text-gray-300 mb-12 max-w-4xl mx-auto leading-relaxed font-medium">
                LeadiX unifies sales execution, financial tracking, and revenue forecasting. Stop revenue leakage and
                take full control of your cashflow pipeline.
            </p>
        </div>
    </section>

    <!-- Capabilities / Features Grid -->
    <section id="features" class="relative py-16 px-6 z-10">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Feature 1 -->
                <div class="feature-card p-8 rounded-2xl cursor-pointer">
                    <div class="w-12 h-12 rounded-xl icon-glow flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Unified Sales Pipelines</h3>
                    <p class="text-gray-400 leading-relaxed">Track every lead, every deal, from prospect to close.
                        Visualize your entire sales process in one intuitive board.</p>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card p-8 rounded-2xl cursor-pointer">
                    <div class="w-12 h-12 rounded-xl icon-glow flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Real-time Cashflow Forecasting</h3>
                    <p class="text-gray-400 leading-relaxed">Predict future income with accuracy, eliminating guesswork.
                        Know exactly where your finances stand months in advance.</p>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card p-8 rounded-2xl cursor-pointer">
                    <div class="w-12 h-12 rounded-xl icon-glow flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Automated Invoice Tracking</h3>
                    <p class="text-gray-400 leading-relaxed">Ensure timely collection and reduce forgotten payments.
                        Automated reminders keep your cashflow positive.</p>
                </div>

                <!-- Feature 4 -->
                <div class="feature-card p-8 rounded-2xl cursor-pointer">
                    <div class="w-12 h-12 rounded-xl icon-glow flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Revenue Leakage Prevention</h3>
                    <p class="text-gray-400 leading-relaxed">Identify stalled deals and unbilled hours instantly. Plug
                        the holes in your pipeline before they impact your bottom line.</p>
                </div>

                <!-- Feature 5 -->
                <div class="feature-card p-8 rounded-2xl cursor-pointer">
                    <div class="w-12 h-12 rounded-xl icon-glow flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Profitability Analysis</h3>
                    <p class="text-gray-400 leading-relaxed">Connect project costs directly to revenue sources. See
                        real-time margins for every client, project, and service.</p>
                </div>

                <!-- Feature 6 -->
                <div class="feature-card p-8 rounded-2xl cursor-pointer">
                    <div class="w-12 h-12 rounded-xl icon-glow flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Integrated Financials</h3>
                    <p class="text-gray-400 leading-relaxed">Seamlessly sync data with Xero, QuickBooks, and Stripe.
                        Keep your sales and finance teams in perfect alignment.</p>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="#pricing"
                    class="inline-flex items-center gap-2 text-orange-500 font-semibold hover:text-orange-400 transition">
                    Explore all capabilities
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="relative py-24 px-6 z-10 bg-white/[0.02]">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <div
                    class="inline-block px-4 py-1.5 rounded-full border border-orange-500/30 bg-orange-500/10 text-orange-500 text-xs font-bold mb-6 uppercase tracking-wider">
                    Trusted by 500+ Teams
                </div>
                <h2 class="text-4xl md:text-5xl font-black text-white mb-4">
                    Stop Revenue Leakage like these <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-amber-500">Industry
                        Leaders</span>
                </h2>
                <p class="text-lg text-gray-400 max-w-2xl mx-auto">
                    Join high-growth agencies, SaaS startups, and freelancers who regained control of their cashflow
                    pipeline with LeadiX.
                </p>
            </div>

            <!-- Rating Widget -->
            <div class="max-w-2xl mx-auto mb-16 p-8 rounded-2xl bg-gray-900/50 border border-white/5">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-5xl font-black text-white mb-2">4.9</div>
                        <div class="flex items-center gap-1 mb-2">
                            <svg class="w-5 h-5 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </div>
                        <div class="text-sm text-gray-400">Based on 500+ reviews</div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-gray-500 w-4">5</span>
                            <div class="w-40 h-2 bg-gray-800 rounded-full overflow-hidden">
                                <div class="h-full bg-orange-500" style="width: 87%"></div>
                            </div>
                            <span class="text-xs text-gray-500">87%</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-gray-500 w-4">4</span>
                            <div class="w-40 h-2 bg-gray-800 rounded-full overflow-hidden">
                                <div class="h-full bg-gray-600" style="width: 10%"></div>
                            </div>
                            <span class="text-xs text-gray-500">10%</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-gray-500 w-4">3</span>
                            <div class="w-40 h-2 bg-gray-800 rounded-full overflow-hidden">
                                <div class="h-full bg-gray-600" style="width: 2%"></div>
                            </div>
                            <span class="text-xs text-gray-500">2%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Testimonial Cards -->
            <div class="grid md:grid-cols-3 gap-6">
                <!-- Testimonial 1 -->
                <div class="testimonial-card p-8 rounded-2xl">
                    <div class="text-5xl text-orange-500/60 mb-4 font-serif">"</div>
                    <p class="text-gray-300 mb-6 leading-relaxed">Recovered <span class="text-white font-bold">$15k in
                            lost billings</span> in month one. LeadiX flagged invoices that slipped through the cracks
                        of our manual spreadsheet system immediately.</p>
                    <div class="flex items-center gap-3">
                        <img src="/images/alex-morgan.png" alt="Alex Morgan" class="w-12 h-12 rounded-full">
                        <div>
                            <div class="font-bold text-white">Alex Morgan</div>
                            <div class="text-sm text-orange-500">Agency Owner</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="testimonial-card p-8 rounded-2xl">
                    <div class="text-5xl text-orange-500/60 mb-4 font-serif">"</div>
                    <p class="text-gray-300 mb-6 leading-relaxed">Finally unified our sales CRM with actual bank
                        deposits. The <span class="text-white font-bold">cashflow visibility</span> is unlike anything
                        else on the market. We can forecast with 95% accuracy now.</p>
                    <div class="flex items-center gap-3">
                        <img src="/images/sarah-chen.png" alt="Sarah Chen" class="w-12 h-12 rounded-full">
                        <div>
                            <div class="font-bold text-white">Sarah Chen</div>
                            <div class="text-sm text-orange-500">SaaS Founder</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="testimonial-card p-8 rounded-2xl">
                    <div class="text-5xl text-orange-500/60 mb-4 font-serif">"</div>
                    <p class="text-gray-300 mb-6 leading-relaxed">Automated collections saved me <span
                            class="text-white font-bold">10 hours a week</span>. I used to chase clients manually; now
                        LeadiX handles the polite nudges and I get paid faster.</p>
                    <div class="flex items-center gap-3">
                        <img src="/images/mike-ross.png" alt="Mike Ross" class="w-12 h-12 rounded-full">
                        <div>
                            <div class="font-bold text-white">Mike Ross</div>
                            <div class="text-sm text-orange-500">Freelance Designer</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="relative py-24 px-6 z-10">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black text-white mb-4">
                    Plans that scale with your <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-amber-500">cashflow.</span>
                </h2>
                <p class="text-lg text-gray-400 max-w-2xl mx-auto">
                    ROI-focused pricing for freelancers, agencies, and SMEs. Unify sales execution and financial
                    tracking without the bloat.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto items-start">
                <!-- Starter -->
                <div class="pricing-card p-8 rounded-2xl">
                    <h3 class="text-xl font-bold text-white mb-2">Starter</h3>
                    <p class="text-sm text-gray-400 mb-6">Essential Lead & Deal Tracking for freelancers.</p>
                    <div class="mb-6">
                        <span class="text-5xl font-black text-white">$29</span>
                        <span class="text-gray-500">/mo</span>
                    </div>
                    <a href="<?php echo e(route('register')); ?>"
                        class="block w-full py-3 rounded-lg border border-orange-500/30 hover:border-orange-500/50 hover:bg-orange-500/5 text-center text-white font-bold mb-8 transition">Start
                        Your Free Trial</a>

                    <div class="space-y-3 text-sm">
                        <div class="flex items-center gap-2 text-white">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            1 User Seat
                        </div>
                        <div class="flex items-center gap-2 text-white">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            3 Active Pipelines
                        </div>
                        <div class="flex items-center gap-2 text-white">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Basic Deal Tracking
                        </div>
                        <div class="flex items-center gap-2 text-white">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Simple Revenue Reports
                        </div>
                        <div class="flex items-center gap-2 text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Forecasting & AI
                        </div>
                    </div>
                </div>

                <!-- Pro (Most Popular) -->
                <div class="pricing-card popular p-8 rounded-2xl relative transform md:scale-105 shadow-2xl">
                    <div
                        class="absolute -top-4 left-1/2 -translate-x-1/2 px-4 py-1 bg-orange-500 rounded-full text-white text-xs font-bold uppercase tracking-wide">
                        Most Popular
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Pro</h3>
                    <p class="text-sm text-gray-300 mb-6">Advanced Pipeline Management & Basic Forecasting.</p>
                    <div class="mb-6">
                        <span class="text-5xl font-black text-white">$79</span>
                        <span class="text-gray-500">/mo</span>
                    </div>
                    <a href="<?php echo e(route('register')); ?>"
                        class="block w-full py-3 rounded-lg btn-gradient text-center text-white font-bold mb-8">Choose
                        Plan</a>

                    <div class="text-xs font-bold text-orange-500 mb-3 uppercase tracking-wide">Everything in Starter,
                        plus:</div>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center gap-2 text-white">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Up to 5 User Seats
                        </div>
                        <div class="flex items-center gap-2 text-white">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Unlimited Pipelines
                        </div>
                        <div class="flex items-center gap-2 text-white">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Basic Revenue Forecasting
                        </div>
                        <div class="flex items-center gap-2 text-white">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Cashflow Analytics
                        </div>
                        <div class="flex items-center gap-2 text-white">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Email & CRM Integrations
                        </div>
                    </div>
                </div>

                <!-- Business -->
                <div class="pricing-card p-8 rounded-2xl">
                    <h3 class="text-xl font-bold text-white mb-2">Business</h3>
                    <p class="text-sm text-gray-400 mb-6">Full Revenue Operations & Predictive AI.</p>
                    <div class="mb-6">
                        <span class="text-5xl font-black text-white">$199</span>
                        <span class="text-gray-500">/mo</span>
                    </div>
                    <a href="<?php echo e(route('register')); ?>"
                        class="block w-full py-3 rounded-lg border border-orange-500/30 hover:border-orange-500/50 hover:bg-orange-500/5 text-center text-white font-bold mb-8 transition">Choose
                        Plan</a>

                    <div class="text-xs font-bold text-gray-400 mb-3 uppercase tracking-wide">Everything in Pro, plus:
                    </div>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center gap-2 text-white">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Unlimited Users
                        </div>
                        <div class="flex items-center gap-2 text-white">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Predictive AI Insights
                        </div>
                        <div class="flex items-center gap-2 text-white">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Advanced API Access
                        </div>
                        <div class="flex items-center gap-2 text-white">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Dedicated Success Manager
                        </div>
                        <div class="flex items-center gap-2 text-white">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            White-label Reports
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-center gap-8 mt-12 text-sm text-gray-500">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    No credit card required for trial
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    24/7 Support available
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    SSL Secure Payment
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA Section -->
    <section class="relative py-32 px-6 z-10 text-center">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-4xl md:text-5xl font-black text-white mb-6">
                Ready to Stop <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-amber-500">Revenue
                    Leaks?</span>
            </h2>
            <p class="text-lg text-gray-400 mb-10 leading-relaxed">
                Unify your sales execution and financial tracking in one platform. Stop guessing and start forecasting
                with precision. Join 5,000+ SMEs mastering their cashflow.
            </p>
            <a href="<?php echo e(route('register')); ?>"
                class="inline-flex items-center gap-2 btn-gradient text-white text-lg font-bold px-10 py-4 rounded-lg mb-4">
                Start Free Trial
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
            <div class="flex items-center justify-center gap-2 text-sm text-gray-500">
                <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                14-day free trial • No credit card required
            </div>
            <div class="mt-6">
                <a href="#" class="inline-flex items-center gap-2 text-gray-400 hover:text-white transition text-sm">
                    Schedule a Demo
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section id="about" class="relative py-20 px-6 z-10 border-t border-white/5">
        <div class="max-w-4xl mx-auto text-center">
            <h3 class="text-3xl font-bold text-white mb-4">Stay ahead of your cashflow</h3>
            <p class="text-gray-400 mb-8">
                Join 10,000+ sales leaders and founders getting weekly insights on revenue control and pipeline
                efficiency.
            </p>
            <form class="flex flex-col sm:flex-row items-center justify-center gap-4 max-w-lg mx-auto">
                <input type="email" placeholder="Enter your work email"
                    class="w-full px-6 py-3 rounded-lg bg-gray-900 border border-gray-700 text-white placeholder-gray-500 focus:outline-none focus:border-orange-500 transition">
                <button type="submit"
                    class="btn-gradient px-8 py-3 rounded-lg text-white font-bold whitespace-nowrap">Subscribe</button>
            </form>
            <p class="text-xs text-gray-600 mt-4">No spam. Unsubscribe anytime.</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="relative py-12 px-6 border-t border-white/5 z-10">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-4 gap-8 mb-12">
                <!-- Brand -->
                <div>
                    <p class="text-sm text-gray-400 leading-relaxed">
                        LeadiX unifies sales execution, financial tracking, and revenue forecasting to prevent revenue
                        leakage for growth-focused SMEs.
                    </p>
                </div>

                <!-- Product -->
                <div>
                    <h4 class="font-bold text-white mb-4 uppercase text-sm tracking-wider">Product</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#features" class="hover:text-white transition">Features</a></li>
                        <li><a href="#pricing" class="hover:text-white transition">Pricing</a></li>
                        <li><a href="#" class="hover:text-white transition">Integrations</a></li>
                        <li><a href="#" class="hover:text-white transition">Changelog</a></li>
                    </ul>
                </div>

                <!-- Company -->
                <div>
                    <h4 class="font-bold text-white mb-4 uppercase text-sm tracking-wider">Company</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white transition">About Us</a></li>
                        <li><a href="#" class="hover:text-white transition">Careers</a></li>
                        <li><a href="#" class="hover:text-white transition">Contact</a></li>
                        <li><a href="#" class="hover:text-white transition">Partners</a></li>
                    </ul>
                </div>

                <!-- Resources -->
                <div>
                    <h4 class="font-bold text-white mb-4 uppercase text-sm tracking-wider">Resources</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition">Help Center</a></li>
                        <li><a href="#" class="hover:text-white transition">API Docs</a></li>
                        <li><a href="#" class="hover:text-white transition">Community</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-white/5 pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-sm text-gray-500">© <?php echo e(date('Y')); ?> LeadiX Inc. All rights reserved.</p>
                <div class="flex items-center gap-6 text-sm text-gray-500">
                    <a href="#" class="hover:text-white transition">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition">Terms of Service</a>
                    <a href="#" class="hover:text-white transition">Cookie Policy</a>
                    <a href="#" class="hover:text-white transition">Security</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Sparkle Generation Script -->
    <script>
        // Generate orange particles with dramatic burst effect
        const sparkleContainer = document.getElementById('sparkles');
        const sparkleCount = 150; // Increased for denser effect

        for (let i = 0; i < sparkleCount; i++) {
            const sparkle = document.createElement('div');
            sparkle.classList.add('sparkle');

            // Varied sizes for depth
            const size = Math.random() * 6 + 2; // 2-8px

            // Radial burst pattern
            const angle = (Math.PI * 2 * i) / sparkleCount + (Math.random() * 0.5);
            const baseDistance = Math.random() * 15 + 5; // Start closer to center
            const burstDistance = Math.random() * 60 + 40; // Burst out 40-100vh

            // Calculate positions
            const centerX = 50; // Center of screen
            const centerY = 50;

            const endX = Math.cos(angle) * burstDistance;
            const endY = Math.sin(angle) * burstDistance;

            const duration = Math.random() * 4 + 3; // 3-7s faster animation
            const delay = Math.random() * 4; // Stagger start times

            sparkle.style.width = `${size}px`;
            sparkle.style.height = `${size}px`;
            sparkle.style.left = `${centerX}%`;
            sparkle.style.top = `${centerY}%`;
            sparkle.style.setProperty('--end-x', `${endX}vh`);
            sparkle.style.setProperty('--end-y', `${endY}vh`);
            sparkle.style.setProperty('--duration', `${duration}s`);
            sparkle.style.animationDelay = `-${delay}s`;

            sparkleContainer.appendChild(sparkle);
        }

        // Cursor spotlight effect on cards
        document.querySelectorAll('.feature-card, .pricing-card').forEach(card => {
            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                const spotlight = card.querySelector('::before') || card;
                card.style.setProperty('--mouse-x', `${x}px`);
                card.style.setProperty('--mouse-y', `${y}px`);

                if (card.querySelector('::before')) {
                    card.style.setProperty('--spotlight-x', `${x - 150}px`);
                    card.style.setProperty('--spotlight-y', `${y - 150}px`);
                } else {
                    // Fallback: add background radial gradient at cursor position
                    card.style.background = `radial-gradient(circle 300px at ${x}px ${y}px, rgba(255, 115, 0, 0.08), rgba(20, 20, 20, 0.6))`;
                }
            });

            card.addEventListener('mouseleave', () => {
                card.style.background = '';
            });
        });

        // Rotating text animation
        const words = ['Growing.', 'Scaling.', 'Expanding.'];
        let currentIndex = 0;
        const rotatingText = document.getElementById('rotating-text');

        function rotateText() {
            rotatingText.style.opacity = '0';

            setTimeout(() => {
                currentIndex = (currentIndex + 1) % words.length;
                rotatingText.textContent = words[currentIndex];
                rotatingText.style.opacity = '1';
            }, 300);
        }

        setInterval(rotateText, 5000);
    </script>
</body>

</html><?php /**PATH C:\Users\dell\.gemini\antigravity\scratch\leadix-app\resources\views/welcome.blade.php ENDPATH**/ ?>