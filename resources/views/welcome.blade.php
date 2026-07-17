<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>{{ config('system.firm_name', 'Lexis & Co.') }} | Professional Legal Excellence</title>

    <!-- Google Fonts & Material Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <!-- Vite Styles and Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        .bento-item {
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
        .bento-item:hover {
            transform: translateY(-8px);
            box-shadow: 0px 12px 24px rgba(0,0,0,0.04);
        }
        .legal-gradient {
            background: linear-gradient(135deg, #031635 0%, #1a2b4b 100%);
        }
        body {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body class="bg-background text-on-background selection:bg-secondary-container selection:text-on-secondary-container">
    <!-- TopNavBar -->
    <header class="sticky top-0 z-50 bg-surface/80 backdrop-blur-md border-b border-outline-variant">
        <nav class="flex justify-between items-center w-full px-lg py-md max-w-7xl mx-auto h-20">
            <div class="flex items-center gap-xl">
                <a class="font-headline-md text-headline-md font-bold text-primary dark:text-on-primary-fixed" href="/">
                    {{ config('system.firm_name', 'Lexis & Co.') }}
                </a>
                <div class="hidden md:flex items-center gap-md">
                    <a class="font-label-md text-label-md text-primary dark:text-primary-fixed font-bold border-b-2 border-primary py-sm" href="#practice-areas">Practice Areas</a>
                    <a class="font-label-md text-label-md text-on-surface-variant dark:text-on-tertiary-container hover:text-primary transition-colors py-sm" href="#statistics">Statistics</a>
                    <a class="font-label-md text-label-md text-on-surface-variant dark:text-on-tertiary-container hover:text-primary transition-colors py-sm" href="#attorneys">Attorneys</a>
                    <a class="font-label-md text-label-md text-on-surface-variant dark:text-on-tertiary-container hover:text-primary transition-colors py-sm" href="#testimonials">Testimonials</a>
                </div>
            </div>
            <div class="flex items-center gap-md">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}" class="font-label-md text-label-md text-primary hover:text-secondary-fixed-dim transition-all px-md py-sm">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="hidden lg:block font-label-md text-label-md text-primary hover:text-secondary-fixed-dim transition-all px-md py-sm">Client Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="hidden sm:block font-label-md text-label-md text-primary hover:text-secondary-fixed-dim transition-all px-md py-sm">Register</a>
                        @endif
                    @endauth
                @endif
                <button onclick="Livewire.dispatch('triggerConsultationModal')" class="bg-primary text-on-primary font-label-md text-label-md px-lg py-sm rounded-lg hover:bg-primary-container transition-all scale-95 active:opacity-80">Book Consultation</button>
            </div>
        </nav>
    </header>

    <main class="max-w-[1440px] mx-auto overflow-hidden">
        <!-- Hero Section -->
        <section class="relative min-h-[870px] flex items-center px-lg lg:px-3xl py-2xl overflow-hidden">
            <div class="absolute inset-0 z-0">
                <div class="w-full h-full bg-cover bg-center opacity-40" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuD0npYWLc0BRq2c5_9S8R0fyxRZRakl0e0DEpiKPuIQDiQLJkEGvYl5EQ75H3OtgOQcrsXxspcAQ6ibQP0V1QujTB29hsvFahGZzo58Oe9p1SXwg2M7CPeStKMXEcijpBm5LqPV9jikPKWhcS-V9UUeOH1fYi8ft7pOjMYikgTaS0ji88E0e2EAPThpDLqWzWYFfI6MehZc5y6lX8ae_qahSHWKRKX7ivg0ZZwhHT0YJiU7cPRa1wh_WA')"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-background via-background/60 to-transparent"></div>
            </div>
            <div class="relative z-10 max-w-4xl">
                <span class="inline-block py-xs px-md mb-md bg-secondary-container text-on-secondary-container font-label-sm text-label-sm rounded-full tracking-wider">{{ config('system.hero_subtitle', 'ESTABLISHED 1984') }}</span>
                <h1 class="font-display-lg text-display-lg text-primary mb-lg leading-tight">
                    {!! nl2br(e(config('system.hero_title', 'Sophisticated counsel for complex legal landscapes.'))) !!}
                </h1>
                <p class="font-body-lg text-body-lg text-on-surface-variant mb-xl max-w-2xl">
                    {{ config('system.hero_description', 'LexCore Law Firm provides elite representation across corporate, intellectual property, and high-stakes litigation matters. We combine heritage with modern agility to protect your legacy.') }}
                </p>
                <div class="flex flex-col sm:flex-row gap-md">
                    <button onclick="Livewire.dispatch('triggerConsultationModal')" class="bg-primary text-on-primary font-label-md text-label-md px-3xl py-md rounded-lg shadow-lg hover:shadow-xl hover:translate-y-[-2px] transition-all">Book Consultation</button>
                    <a href="#practice-areas" class="inline-flex items-center justify-center bg-transparent border border-primary text-primary font-label-md text-label-md px-3xl py-md rounded-lg hover:bg-primary/5 transition-all text-center">View Practice Areas</a>
                </div>
            </div>
            <!-- Floating Card Detail -->
            <div class="hidden lg:block absolute right-24 bottom-24 w-80 glass-card p-xl rounded-2xl border border-white/50 shadow-2xl">
                <div class="flex items-center gap-md mb-md">
                    <span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">verified_user</span>
                    <span class="font-label-md text-label-md text-primary">Top Tier Firm 2024</span>
                </div>
                <p class="font-body-sm text-body-sm text-on-surface-variant">"Unparalleled strategic insight and a relentless commitment to our corporate interests."</p>
                <div class="mt-md border-t border-outline-variant pt-md">
                    <span class="font-label-sm text-label-sm font-bold">Fortune 500 General Counsel</span>
                </div>
            </div>
        </section>

        <!-- Practice Areas (Bento Grid) -->
        <section id="practice-areas" class="py-3xl px-lg lg:px-3xl bg-surface-container-low">
            <div class="max-w-7xl mx-auto">
                <div class="mb-2xl text-center md:text-left">
                    <h2 class="font-headline-lg text-headline-lg text-primary mb-md">Practice Areas</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant max-w-xl">Deep expertise across the foundational pillars of modern law, delivered with precision and strategic foresight.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-lg h-full">
                    <!-- Corporate Law -->
                    <div class="md:col-span-2 bento-item bg-surface-container-lowest p-2xl rounded-2xl border border-outline-variant flex flex-col justify-between h-[340px] group">
                        <div>
                            <span class="material-symbols-outlined text-primary text-4xl mb-md">business_center</span>
                            <h3 class="font-headline-md text-headline-md text-primary mb-sm">Corporate & M&A</h3>
                            <p class="font-body-md text-body-md text-on-surface-variant max-w-md">Guiding multi-billion dollar transactions with rigorous due diligence and sophisticated deal structures.</p>
                        </div>
                        <a class="flex items-center gap-sm font-label-md text-label-md text-primary group-hover:gap-md transition-all" href="#">Learn More <span class="material-symbols-outlined text-sm">arrow_forward</span></a>
                    </div>
                    <!-- Intellectual Property -->
                    <div class="bento-item bg-primary text-on-primary p-2xl rounded-2xl flex flex-col justify-between h-[340px] group">
                        <div>
                            <span class="material-symbols-outlined text-secondary-fixed text-4xl mb-md" style="font-variation-settings: 'FILL' 1;">lightbulb</span>
                            <h3 class="font-headline-md text-headline-md mb-sm">Intellectual Property</h3>
                            <p class="font-body-sm text-body-sm opacity-80">Global portfolio management and aggressive patent protection for innovators.</p>
                        </div>
                        <a class="flex items-center gap-sm font-label-md text-label-md group-hover:gap-md transition-all" href="#">Learn More <span class="material-symbols-outlined text-sm">arrow_forward</span></a>
                    </div>
                    <!-- Litigation -->
                    <div class="bento-item bg-surface-container-lowest p-2xl rounded-2xl border border-outline-variant flex flex-col justify-between group">
                        <div>
                            <span class="material-symbols-outlined text-primary text-4xl mb-md">gavel</span>
                            <h3 class="font-headline-md text-headline-md text-primary mb-sm">High-Stakes Litigation</h3>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">Uncompromising advocacy in state and federal courts across the country.</p>
                        </div>
                        <a class="flex items-center gap-sm font-label-md text-label-md text-primary group-hover:gap-md transition-all" href="#">Learn More <span class="material-symbols-outlined text-sm">arrow_forward</span></a>
                    </div>
                    <!-- Estate Planning -->
                    <div class="bento-item bg-surface-container-lowest p-2xl rounded-2xl border border-outline-variant flex flex-col justify-between group">
                        <div>
                            <span class="material-symbols-outlined text-primary text-4xl mb-md">family_history</span>
                            <h3 class="font-headline-md text-headline-md text-primary mb-sm">Private Wealth</h3>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">Discreet asset protection and multi-generational legacy planning.</p>
                        </div>
                        <a class="flex items-center gap-sm font-label-md text-label-md text-primary group-hover:gap-md transition-all" href="#">Learn More <span class="material-symbols-outlined text-sm">arrow_forward</span></a>
                    </div>
                    <!-- Real Estate -->
                    <div class="bento-item bg-surface-container-lowest p-2xl rounded-2xl border border-outline-variant flex flex-col justify-between group">
                        <div>
                            <span class="material-symbols-outlined text-primary text-4xl mb-md">apartment</span>
                            <h3 class="font-headline-md text-headline-md text-primary mb-sm">Commercial Real Estate</h3>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">Navigating complex zoning, financing, and development challenges.</p>
                        </div>
                        <a class="flex items-center gap-sm font-label-md text-label-md text-primary group-hover:gap-md transition-all" href="#">Learn More <span class="material-symbols-outlined text-sm">arrow_forward</span></a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Milestone Numbers -->
        <section id="statistics" class="py-3xl px-lg lg:px-3xl">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-2xl">
                <div class="text-center">
                    <span class="block font-display-lg text-[56px] text-primary mb-xs">{{ config('system.stat_recovered', '$2.4B+') }}</span>
                    <span class="font-label-md text-label-md text-on-surface-variant uppercase tracking-widest">In Settlements Recovered</span>
                </div>
                <div class="w-px h-16 bg-outline-variant hidden md:block"></div>
                <div class="text-center">
                    <span class="block font-display-lg text-[56px] text-primary mb-xs">{{ config('system.stat_years', '40+') }}</span>
                    <span class="font-label-md text-label-md text-on-surface-variant uppercase tracking-widest">Years of Advocacy</span>
                </div>
                <div class="w-px h-16 bg-outline-variant hidden md:block"></div>
                <div class="text-center">
                    <span class="block font-display-lg text-[56px] text-primary mb-xs">{{ config('system.stat_retention', '98%') }}</span>
                    <span class="font-label-md text-label-md text-on-surface-variant uppercase tracking-widest">Client Retention Rate</span>
                </div>
                <div class="w-px h-16 bg-outline-variant hidden md:block"></div>
                <div class="text-center">
                    <span class="block font-display-lg text-[56px] text-primary mb-xs">{{ config('system.stat_partners', '150+') }}</span>
                    <span class="font-label-md text-label-md text-on-surface-variant uppercase tracking-widest">Global Partners</span>
                </div>
            </div>
        </section>

        <!-- Featured Attorneys -->
        <section id="attorneys" class="py-3xl px-lg lg:px-3xl bg-white">
            <div class="max-w-7xl mx-auto">
                <div class="flex justify-between items-end mb-2xl">
                    <div class="max-w-xl">
                        <h2 class="font-headline-lg text-headline-lg text-primary mb-md">Elite Leadership</h2>
                        <p class="font-body-md text-body-md text-on-surface-variant">Our attorneys are recognized leaders in their fields, frequently cited in national media and academic journals.</p>
                    </div>
                    <a class="hidden md:flex items-center gap-sm font-label-md text-label-md text-primary hover:gap-md transition-all" href="#">All Partners <span class="material-symbols-outlined text-sm">arrow_forward</span></a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-xl">
                    <!-- Attorney 1 -->
                    <div class="group">
                        <div class="aspect-[4/5] overflow-hidden rounded-xl mb-md">
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Julian Thorne Portrait" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDUSUFnRGzUKW9rQGna9F0Rqx7XiOEeTKZ_ZjFNqpM20c0HpWZ5g3kVDQorJAFkVWElHWzZyyfh9prkVn1SSg9UaRggUQXB--bK3TqGvaMzsByacPZHnyp_W6FqCoCqmoa3ZxCz9rxKq2-LUqvlr56omdaMQaTMIFOBItnzAWDPuEWide7UVsapEIjSbiboOrx8iyOGn23wwr-YYZIbsrtOkpXtgvyLUU7J5xnBafW0eFLAFFGmkbGzxA"/>
                        </div>
                        <h4 class="font-headline-md text-headline-md text-primary">Julian Thorne</h4>
                        <p class="font-label-sm text-label-sm text-secondary uppercase tracking-wider mb-xs">Managing Partner</p>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">Specializing in Cross-Border M&A and Strategic Advisory.</p>
                    </div>
                    <!-- Attorney 2 -->
                    <div class="group">
                        <div class="aspect-[4/5] overflow-hidden rounded-xl mb-md">
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Sarah Kensington Portrait" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD8-Hj7QxqJVPkNOzaDbA4X5Wf1-KE7g_R-Rf5q70p2ntTcSo2OPIAqGjuELzZETa5gUzP-ANYtBgyvIfZVQBHgdAzNWOlAHTbz60xse078jAUsXhA-cw2XE3ZcL70H9n0yb9nahYlVr2aILfR5A_mRhrooH4--I2NO_umOcRs70zvxgtoCdMjXsVniz33AJjYVzrPDduA1nbFwCIkxyL6lQ2hfXJHj9lrs3fp1-8Y6xcy_1Ot4SBWDwQ"/>
                        </div>
                        <h4 class="font-headline-md text-headline-md text-primary">Sarah Kensington</h4>
                        <p class="font-label-sm text-label-sm text-secondary uppercase tracking-wider mb-xs">Senior Partner, IP</p>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">Recognized as one of the top 50 IP litigators in the country.</p>
                    </div>
                    <!-- Attorney 3 -->
                    <div class="group">
                        <div class="aspect-[4/5] overflow-hidden rounded-xl mb-md">
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Marcus Vane Portrait" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCfR2Eho-JK7dkZZ0dl-EpoO3ZRa1r1anOPIV9WwxTZSEPjSLHwPuTXRu8P1Bp1hHxRZZ3WLdW4D7_BiM7aUurMjOnN7WcO8CuefKjQJM0PaSQq7jclmZWLBFvI2QPLnS7GpDNkeh5v-1vUn1lNw1wM1Hqt1QgsG15yXVyo1005jfGb0iFz9_QJKMX15J3lCUN0eEXOzlYQg2NUv2M849uLW--1TlIpwnGChp5BT7PM1KT27Q00xLlMYA"/>
                        </div>
                        <h4 class="font-headline-md text-headline-md text-primary">Marcus Vane</h4>
                        <p class="font-label-sm text-label-sm text-secondary uppercase tracking-wider mb-xs">Litigation Partner</p>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">Expert in high-stakes white-collar defense and civil litigation.</p>
                    </div>
                    <!-- Attorney 4 -->
                    <div class="group">
                        <div class="aspect-[4/5] overflow-hidden rounded-xl mb-md">
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Elena Rodriguez Portrait" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC1sZwRy7th2uNe38jq37PbLA8AiXzQERTF_96UbTxjJH-y-nNX4IrAbODxzQ9t93Q5yEF4VmUy8R6GKFOtKwMEtdr7t3kdk_0tGFKkcujJKXO-nPxcGp6WCI1hC8YAqkg3pZ-3miR117CpkoR7gqGnnV3ces1Ggu3uiLgreK2c9vAEX5YYmyjNxNuapv57bzedyVRyKNG5tb24tD_0PrNv8lLNe0ykfb6vRV7UTY4Sa88gysZrM-e33Q"/>
                        </div>
                        <h4 class="font-headline-md text-headline-md text-primary">Elena Rodriguez</h4>
                        <p class="font-label-sm text-label-sm text-secondary uppercase tracking-wider mb-xs">Private Wealth Lead</p>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">Bespoke estate planning for ultra-high-net-worth families.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials -->
        <section id="testimonials" class="py-3xl px-lg lg:px-3xl bg-surface-container-low overflow-hidden relative">
            <div class="max-w-7xl mx-auto flex flex-col lg:flex-row items-center gap-3xl">
                <div class="lg:w-1/3">
                    <h2 class="font-headline-lg text-headline-lg text-primary mb-md">Unwavering Trust</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant">Hear from the founders, directors, and private individuals we are proud to represent.</p>
                </div>
                <div class="lg:w-2/3 grid grid-cols-1 md:grid-cols-2 gap-lg">
                    <div class="bg-surface-container-lowest p-xl rounded-2xl shadow-sm border border-outline-variant">
                        <div class="flex gap-xs text-secondary-container mb-md">
                            <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                        </div>
                        <p class="font-body-md text-body-md text-on-surface mb-lg italic">"Lexis & Co. did more than just win our case; they navigated a geopolitical minefield with surgical precision. Their counsel is essential."</p>
                        <div class="flex items-center gap-md">
                            <div class="w-10 h-10 rounded-full bg-primary-container"></div>
                            <div>
                                <p class="font-label-md text-label-md text-primary">CEO, TechGlobal Inc.</p>
                                <p class="font-label-sm text-label-sm text-on-surface-variant">International Arbitration</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-surface-container-lowest p-xl rounded-2xl shadow-sm border border-outline-variant">
                        <div class="flex gap-xs text-secondary-container mb-md">
                            <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                        </div>
                        <p class="font-body-md text-body-md text-on-surface mb-lg italic">"The level of discretion and meticulous attention to detail in our family office restructuring was truly world-class."</p>
                        <div class="flex items-center gap-md">
                            <div class="w-10 h-10 rounded-full bg-secondary-container"></div>
                            <div>
                                <p class="font-label-md text-label-md text-primary">Director, Sterling Estates</p>
                                <p class="font-label-sm text-label-sm text-on-surface-variant">Wealth Management</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-3xl px-lg lg:px-3xl">
            <div class="max-w-7xl mx-auto legal-gradient rounded-3xl p-3xl text-center relative overflow-hidden">
                <!-- Abstract Pattern Background -->
                <div class="absolute inset-0 opacity-10 pointer-events-none">
                    <svg height="100%" preserveaspectratio="none" viewbox="0 0 100 100" width="100%">
                        <path d="M0 100 L100 0" stroke="white" stroke-width="0.1"></path>
                        <path d="M0 80 L80 0" stroke="white" stroke-width="0.1"></path>
                        <path d="M0 60 L60 0" stroke="white" stroke-width="0.1"></path>
                        <path d="M20 100 L100 20" stroke="white" stroke-width="0.1"></path>
                        <path d="M40 100 L100 40" stroke="white" stroke-width="0.1"></path>
                    </svg>
                </div>
                <div class="relative z-10">
                    <h2 class="font-headline-lg text-[42px] text-on-primary mb-md leading-tight">{{ config('system.cta_title', 'Secure your future with proven expertise.') }}</h2>
                    <p class="font-body-lg text-body-lg text-on-primary/70 mb-xl max-w-2xl mx-auto">{{ config('system.cta_description', 'Contact us today for a confidential consultation. Our partners are ready to discuss your matter with the gravity it deserves.') }}</p>
                    <div class="flex flex-col sm:flex-row justify-center gap-md">
                        <button onclick="Livewire.dispatch('triggerConsultationModal')" class="bg-on-primary text-primary font-label-md text-label-md px-3xl py-md rounded-lg hover:bg-surface-container transition-all">Book Consultation</button>
                        <a href="#contact" class="inline-flex items-center justify-center bg-transparent border border-on-primary/30 text-on-primary font-label-md text-label-md px-3xl py-md rounded-lg hover:bg-white/10 transition-all text-center">Contact Us</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-surface-container-highest dark:bg-inverse-surface border-t border-outline-variant">
        <div class="w-full py-2xl px-lg flex flex-col md:flex-row justify-between items-start max-w-7xl mx-auto gap-xl">
            <div class="max-w-xs">
                <a class="font-headline-md text-headline-md text-primary mb-md block" href="/">{{ config('system.firm_name', 'Lexis & Co.') }}</a>
                <p class="font-body-sm text-body-sm text-on-surface-variant mb-md">Elite legal counsel since 1984. Providing world-class representation for the most complex legal matters.</p>
                <div class="flex gap-md">
                    <span class="material-symbols-outlined text-primary cursor-pointer hover:opacity-70">share</span>
                    <span class="material-symbols-outlined text-primary cursor-pointer hover:opacity-70">mail</span>
                    <span class="material-symbols-outlined text-primary cursor-pointer hover:opacity-70">phone_in_talk</span>
                </div>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-3 gap-xl w-full md:w-auto">
                <div class="flex flex-col gap-sm">
                    <h5 class="font-label-md text-label-md text-primary mb-sm uppercase tracking-widest">Firm</h5>
                    <a class="font-label-sm text-label-sm text-on-surface-variant hover:text-primary transition-colors" href="#">About</a>
                    <a class="font-label-sm text-label-sm text-on-surface-variant hover:text-primary transition-colors" href="#">Careers</a>
                    <a class="font-label-sm text-label-sm text-on-surface-variant hover:text-primary transition-colors" href="#">Contact</a>
                </div>
                <div class="flex flex-col gap-sm">
                    <h5 class="font-label-md text-label-md text-primary mb-sm uppercase tracking-widest">Resources</h5>
                    <a class="font-label-sm text-label-sm text-on-surface-variant hover:text-primary transition-colors" href="#">Privacy Policy</a>
                    <a class="font-label-sm text-label-sm text-on-surface-variant hover:text-primary transition-colors" href="#">Terms of Service</a>
                    <a class="font-label-sm text-label-sm text-on-surface-variant hover:text-primary transition-colors" href="#">Accessibility</a>
                </div>
                <div class="hidden lg:flex flex-col gap-sm">
                    <h5 class="font-label-md text-label-md text-primary mb-sm uppercase tracking-widest">Offices</h5>
                    <p class="font-label-sm text-label-sm text-on-surface-variant">New York</p>
                    <p class="font-label-sm text-label-sm text-on-surface-variant">London</p>
                    <p class="font-label-sm text-label-sm text-on-surface-variant">Singapore</p>
                </div>
            </div>
        </div>
        <div class="w-full py-md px-lg border-t border-outline-variant max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-sm">
            <p class="font-label-sm text-label-sm text-on-surface-variant">© {{ date('Y') }} {{ config('system.firm_name', 'Lexis & Co.') }}. All rights reserved. Professional Legal Excellence.</p>
            <p class="font-label-sm text-label-sm text-on-surface-variant italic">Attorney Advertising. Prior results do not guarantee a similar outcome.</p>
        </div>
    </footer>

    <script>
        // Micro-interactions and subtle scroll effects
        document.addEventListener('DOMContentLoaded', () => {
            const bentoItems = document.querySelectorAll('.bento-item');
            
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('opacity-100', 'translate-y-0');
                        entry.target.classList.remove('opacity-0', 'translate-y-10');
                    }
                });
            }, observerOptions);

            bentoItems.forEach(item => {
                item.classList.add('opacity-0', 'translate-y-10', 'transition-all', 'duration-700');
                observer.observe(item);
            });
        });
    </script>
    
    @livewire('welcome-book-consultation')
</body>
</html>
