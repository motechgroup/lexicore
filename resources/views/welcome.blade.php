<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>{{ config('system.seo_title', config('system.firm_name', 'Lexis & Co.').' | Professional Legal Excellence') }}</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="{{ config('system.seo_description', 'LexCore Law Firm provides elite representation across corporate, intellectual property, and high-stakes litigation matters. We combine heritage with modern agility to protect your legacy.') }}">
    <meta name="keywords" content="{{ config('system.seo_keywords', 'law firm, corporate lawyer, intellectual property attorney, business litigation, legal services, private wealth trust planning, commercial real estate contract legal') }}">
    <meta name="author" content="{{ config('system.firm_name', 'LexCore') }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ config('system.seo_title', config('system.firm_name', 'LexCore').' | Professional Legal Excellence') }}">
    <meta property="og:description" content="{{ config('system.seo_description', 'LexCore Law Firm provides elite representation across corporate, intellectual property, and high-stakes litigation matters. We combine heritage with modern agility to protect your legacy.') }}">
    @if(config('system.logo_url'))
        <meta property="og:image" content="{{ url(config('system.logo_url')) }}">
    @endif
    <meta property="og:url" content="{{ url()->current() }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:title" content="{{ config('system.seo_title', config('system.firm_name', 'LexCore').' | Professional Legal Excellence') }}">
    <meta property="twitter:description" content="{{ config('system.seo_description', 'LexCore Law Firm provides elite representation across corporate, intellectual property, and high-stakes litigation matters. We combine heritage with modern agility to protect your legacy.') }}">
    @if(config('system.logo_url'))
        <meta property="twitter:image" content="{{ url(config('system.logo_url')) }}">
    @endif

    <!-- Google Analytics -->
    @if(config('system.google_analytics_id'))
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('system.google_analytics_id') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            window.gtag = function(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ config('system.google_analytics_id') }}');
        </script>
    @endif

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
                    <a class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors py-sm" href="#about">About</a>
                    <a class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors py-sm" href="#practice-areas">Practice Areas</a>
                    <a class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors py-sm" href="#statistics">Statistics</a>
                    <a class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors py-sm" href="#attorneys">Attorneys</a>
                    <a class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors py-sm" href="#faq">FAQ</a>
                    <a class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors py-sm" href="#contact">Contact</a>
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
        <section class="relative min-h-[650px] flex items-center px-lg lg:px-3xl py-2xl overflow-hidden">
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

        <!-- About / Mission / Values Section -->
        <section id="about" class="py-3xl px-lg lg:px-3xl bg-white">
            <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-xl items-center">
                <div class="lg:col-span-5 space-y-md">
                    <span class="font-label-sm text-label-sm text-secondary uppercase tracking-wider">Our Heritage</span>
                    <h2 class="font-display-lg text-headline-lg text-primary leading-tight">Elite counsel built on trust and strategic agility.</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant">Founded in 1984, LexCore has built a legacy of uncompromising advocacy. We protect your enterprise, your innovations, and your generational assets through rigorous diligence.</p>
                    <div class="flex items-center gap-md pt-sm">
                        <div class="flex flex-col">
                            <span class="font-display-md text-primary font-bold text-[28px]">1984</span>
                            <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest text-[9px]">Year Founded</span>
                        </div>
                        <div class="w-px h-10 bg-outline-variant"></div>
                        <div class="flex flex-col">
                            <span class="font-display-md text-primary font-bold text-[28px]">98%</span>
                            <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest text-[9px]">Success Rate</span>
                        </div>
                    </div>
                </div>
                <div class="lg:col-span-7 grid grid-cols-1 md:grid-cols-2 gap-lg">
                    <!-- Mission Card -->
                    <div class="p-xl bg-surface-container-low rounded-2xl border border-outline-variant space-y-sm">
                        <span class="material-symbols-outlined text-primary text-3xl">explore</span>
                        <h4 class="font-headline-md text-base text-primary font-bold">Our Mission</h4>
                        <p class="font-body-sm text-xs text-on-surface-variant leading-relaxed">To deliver sophisticated, result-oriented legal counsel that safeguards client assets, fosters commercial innovation, and upholds justice with absolute integrity.</p>
                    </div>
                    <!-- Vision Card -->
                    <div class="p-xl bg-surface-container-low rounded-2xl border border-outline-variant space-y-sm">
                        <span class="material-symbols-outlined text-primary text-3xl">visibility</span>
                        <h4 class="font-headline-md text-base text-primary font-bold">Our Vision</h4>
                        <p class="font-body-sm text-xs text-on-surface-variant leading-relaxed">To remain the global benchmark for professional legal excellence, pioneering adaptive strategies for complex commercial and private client affairs.</p>
                    </div>
                    <!-- Value 1 -->
                    <div class="p-xl bg-surface-container-low rounded-2xl border border-outline-variant space-y-sm">
                        <span class="material-symbols-outlined text-primary text-3xl">verified_user</span>
                        <h4 class="font-headline-md text-base text-primary font-bold">Absolute Integrity</h4>
                        <p class="font-body-sm text-xs text-on-surface-variant leading-relaxed">Upholding strict attorney-client privilege, professional transparency, and ethical standards across all dockets and advisory roles.</p>
                    </div>
                    <!-- Value 2 -->
                    <div class="p-xl bg-surface-container-low rounded-2xl border border-outline-variant space-y-sm">
                        <span class="material-symbols-outlined text-primary text-3xl">psychology</span>
                        <h4 class="font-headline-md text-base text-primary font-bold">Strategic Agility</h4>
                        <p class="font-body-sm text-xs text-on-surface-variant leading-relaxed">Combining cross-disciplinary legal foresight with modern technological agility to resolve complex multi-jurisdictional matters.</p>
                    </div>
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
                        <a class="flex items-center gap-sm font-label-md text-label-md text-primary group-hover:gap-md transition-all cursor-pointer" data-learn-more="corporate" href="javascript:void(0)">Learn More <span class="material-symbols-outlined text-sm">arrow_forward</span></a>
                    </div>
                    <!-- Intellectual Property -->
                    <div class="bento-item bg-primary text-on-primary p-2xl rounded-2xl flex flex-col justify-between h-[340px] group">
                        <div>
                            <span class="material-symbols-outlined text-secondary-fixed text-4xl mb-md" style="font-variation-settings: 'FILL' 1;">lightbulb</span>
                            <h3 class="font-headline-md text-headline-md mb-sm">Intellectual Property</h3>
                            <p class="font-body-sm text-body-sm opacity-80">Global portfolio management and aggressive patent protection for innovators.</p>
                        </div>
                        <a class="flex items-center gap-sm font-label-md text-label-md group-hover:gap-md transition-all cursor-pointer" data-learn-more="ip" href="javascript:void(0)">Learn More <span class="material-symbols-outlined text-sm">arrow_forward</span></a>
                    </div>
                    <!-- Litigation -->
                    <div class="bento-item bg-surface-container-lowest p-2xl rounded-2xl border border-outline-variant flex flex-col justify-between group">
                        <div>
                            <span class="material-symbols-outlined text-primary text-4xl mb-md">gavel</span>
                            <h3 class="font-headline-md text-headline-md text-primary mb-sm">High-Stakes Litigation</h3>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">Uncompromising advocacy in state and federal courts across the country.</p>
                        </div>
                        <a class="flex items-center gap-sm font-label-md text-label-md text-primary group-hover:gap-md transition-all cursor-pointer" data-learn-more="litigation" href="javascript:void(0)">Learn More <span class="material-symbols-outlined text-sm">arrow_forward</span></a>
                    </div>
                    <!-- Estate Planning -->
                    <div class="bento-item bg-surface-container-lowest p-2xl rounded-2xl border border-outline-variant flex flex-col justify-between group">
                        <div>
                            <span class="material-symbols-outlined text-primary text-4xl mb-md">family_history</span>
                            <h3 class="font-headline-md text-headline-md text-primary mb-sm">Private Wealth</h3>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">Discreet asset protection and multi-generational legacy planning.</p>
                        </div>
                        <a class="flex items-center gap-sm font-label-md text-label-md text-primary group-hover:gap-md transition-all cursor-pointer" data-learn-more="wealth" href="javascript:void(0)">Learn More <span class="material-symbols-outlined text-sm">arrow_forward</span></a>
                    </div>
                    <!-- Real Estate -->
                    <div class="bento-item bg-surface-container-lowest p-2xl rounded-2xl border border-outline-variant flex flex-col justify-between group">
                        <div>
                            <span class="material-symbols-outlined text-primary text-4xl mb-md">apartment</span>
                            <h3 class="font-headline-md text-headline-md text-primary mb-sm">Commercial Real Estate</h3>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">Navigating complex zoning, financing, and development challenges.</p>
                        </div>
                        <a class="flex items-center gap-sm font-label-md text-label-md text-primary group-hover:gap-md transition-all cursor-pointer" data-learn-more="realestate" href="javascript:void(0)">Learn More <span class="material-symbols-outlined text-sm">arrow_forward</span></a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Milestone Numbers -->
        <section id="statistics" class="py-3xl px-lg lg:px-3xl">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-2xl">
                <div class="text-center">
                    <span class="block font-display-lg text-[56px] text-primary mb-xs" data-animate-stat="{{ config('system.stat_recovered', '$2.4B+') }}">{{ config('system.stat_recovered', '$2.4B+') }}</span>
                    <span class="font-label-md text-label-md text-on-surface-variant uppercase tracking-widest">In Settlements Recovered</span>
                </div>
                <div class="w-px h-16 bg-outline-variant hidden md:block"></div>
                <div class="text-center">
                    <span class="block font-display-lg text-[56px] text-primary mb-xs" data-animate-stat="{{ config('system.stat_years', '40+') }}">{{ config('system.stat_years', '40+') }}</span>
                    <span class="font-label-md text-label-md text-on-surface-variant uppercase tracking-widest">Years of Advocacy</span>
                </div>
                <div class="w-px h-16 bg-outline-variant hidden md:block"></div>
                <div class="text-center">
                    <span class="block font-display-lg text-[56px] text-primary mb-xs" data-animate-stat="{{ config('system.stat_retention', '98%') }}">{{ config('system.stat_retention', '98%') }}</span>
                    <span class="font-label-md text-label-md text-on-surface-variant uppercase tracking-widest">Client Retention Rate</span>
                </div>
                <div class="w-px h-16 bg-outline-variant hidden md:block"></div>
                <div class="text-center">
                    <span class="block font-display-lg text-[56px] text-primary mb-xs" data-animate-stat="{{ config('system.stat_partners', '150+') }}">{{ config('system.stat_partners', '150+') }}</span>
                    <span class="font-label-md text-label-md text-on-surface-variant uppercase tracking-widest">Global Partners</span>
                </div>
            </div>
        </section>

        <!-- Featured Attorneys -->
        <section id="attorneys" class="py-3xl px-lg lg:px-3xl bg-white">
            <div class="max-w-7xl mx-auto">
                <div class="flex justify-between items-end mb-2xl">
                    <div class="max-w-xl">
                        <h2 class="font-headline-lg text-headline-lg text-primary mb-md">{{ config('system.leader_headline', 'Elite Leadership') }}</h2>
                        <p class="font-body-md text-body-md text-on-surface-variant">{{ config('system.leader_subtitle', 'Our attorneys are recognized leaders in their fields, frequently cited in national media and academic journals.') }}</p>
                    </div>
                    <a class="hidden md:flex items-center gap-sm font-label-md text-label-md text-primary hover:gap-md transition-all" href="#">All Partners <span class="material-symbols-outlined text-sm">arrow_forward</span></a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-xl">
                    <!-- Attorney 1 -->
                    <div class="group">
                        <div class="aspect-[4/5] overflow-hidden rounded-xl mb-md">
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ config('system.leader_1_name', 'Julian Thorne') }} Portrait" src="{{ config('system.leader_1_image', 'https://lh3.googleusercontent.com/aida-public/AB6AXuDUSUFnRGzUKW9rQGna9F0Rqx7XiOEeTKZ_ZjFNqpM20c0HpWZ5g3kVDQorJAFkVWElHWzZyyfh9prkVn1SSg9UaRggUQXB--bK3TqGvaMzsByacPZHnyp_W6FqCoCqmoa3ZxCz9rxKq2-LUqvlr56omdaMQaTMIFOBItnzAWDPuEWide7UVsapEIjSbiboOrx8iyOGn23wwr-YYZIbsrtOkpXtgvyLUU7J5xnBafW0eFLAFFGmkbGzxA') }}"/>
                        </div>
                        <h4 class="font-headline-md text-headline-md text-primary">{{ config('system.leader_1_name', 'Julian Thorne') }}</h4>
                        <p class="font-label-sm text-label-sm text-secondary uppercase tracking-wider mb-xs">{{ config('system.leader_1_title', 'Managing Partner') }}</p>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">{{ config('system.leader_1_description', 'Specializing in Cross-Border M&A and Strategic Advisory.') }}</p>
                    </div>
                    <!-- Attorney 2 -->
                    <div class="group">
                        <div class="aspect-[4/5] overflow-hidden rounded-xl mb-md">
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ config('system.leader_2_name', 'Sarah Kensington') }} Portrait" src="{{ config('system.leader_2_image', 'https://lh3.googleusercontent.com/aida-public/AB6AXuD8-Hj7QxqJVPkNOzaDbA4X5Wf1-KE7g_R-Rf5q70p2ntTcSo2OPIAqGjuELzZETa5gUzP-ANYtBgyvIfZVQBHgdAzNWOlAHTbz60xse078jAUsXhA-cw2XE3ZcL70H9n0yb9nahYlVr2aILfR5A_mRhrooH4--I2NO_umOcRs70zvxgtoCdMjXsVniz33AJjYVzrPDduA1nbFwCIkxyL6lQ2hfXJHj9lrs3fp1-8Y6xcy_1Ot4SBWDwQ') }}"/>
                        </div>
                        <h4 class="font-headline-md text-headline-md text-primary">{{ config('system.leader_2_name', 'Sarah Kensington') }}</h4>
                        <p class="font-label-sm text-label-sm text-secondary uppercase tracking-wider mb-xs">{{ config('system.leader_2_title', 'Senior Partner, IP') }}</p>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">{{ config('system.leader_2_description', 'Recognized as one of the top 50 IP litigators in the country.') }}</p>
                    </div>
                    <!-- Attorney 3 -->
                    <div class="group">
                        <div class="aspect-[4/5] overflow-hidden rounded-xl mb-md">
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ config('system.leader_3_name', 'Marcus Vane') }} Portrait" src="{{ config('system.leader_3_image', 'https://lh3.googleusercontent.com/aida-public/AB6AXuCfR2Eho-JK7dkZZ0dl-EpoO3ZRa1r1anOPIV9WwxTZSEPjSLHwPuTXRu8P1Bp1hHxRZZ3WLdW4D7_BiM7aUurMjOnN7WcO8CuefKjQJM0PaSQq7jclmZWLBFvI2QPLnS7GpDNkeh5v-1vUn1lNw1wM1Hqt1QgsG15yXVyo1005jfGb0iFz9_QJKMX15J3lCUN0eEXOzlYQg2NUv2M849uLW--1TlIpwnGChp5BT7PM1KT27Q00xLlMYA') }}"/>
                        </div>
                        <h4 class="font-headline-md text-headline-md text-primary">{{ config('system.leader_3_name', 'Marcus Vane') }}</h4>
                        <p class="font-label-sm text-label-sm text-secondary uppercase tracking-wider mb-xs">{{ config('system.leader_3_title', 'Litigation Partner') }}</p>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">{{ config('system.leader_3_description', 'Expert in high-stakes white-collar defense and civil litigation.') }}</p>
                    </div>
                    <!-- Attorney 4 -->
                    <div class="group">
                        <div class="aspect-[4/5] overflow-hidden rounded-xl mb-md">
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ config('system.leader_4_name', 'Elena Rodriguez') }} Portrait" src="{{ config('system.leader_4_image', 'https://lh3.googleusercontent.com/aida-public/AB6AXuC1sZwRy7th2uNe38jq37PbLA8AiXzQERTF_96UbTxjJH-y-nNX4IrAbODxzQ9t93Q5yEF4VmUy8R6GKFOtKwMEtdr7t3kdk_0tGFKkcujJKXO-nPxcGp6WCI1hC8YAqkg3pZ-3miR117CpkoR7gqGnnV3ces1Ggu3uiLgreK2c9vAEX5YYmyjNxNuapv57bzedyVRyKNG5tb24tD_0PrNv8lLNe0ykfb6vRV7UTY4Sa88gysZrM-e33Q') }}"/>
                        </div>
                        <h4 class="font-headline-md text-headline-md text-primary">{{ config('system.leader_4_name', 'Elena Rodriguez') }}</h4>
                        <p class="font-label-sm text-label-sm text-secondary uppercase tracking-wider mb-xs">{{ config('system.leader_4_title', 'Private Wealth Lead') }}</p>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">{{ config('system.leader_4_description', 'Bespoke estate planning for ultra-high-net-worth families.') }}</p>
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

        <!-- FAQ Section -->
        <section id="faq" class="py-3xl px-lg lg:px-3xl bg-white border-t border-outline-variant">
            <div class="max-w-4xl mx-auto space-y-xl">
                <div class="text-center space-y-sm">
                    <span class="font-label-sm text-label-sm text-secondary uppercase tracking-wider">Answers to your queries</span>
                    <h2 class="font-display-lg text-headline-lg text-primary">Frequently Asked Questions</h2>
                    <p class="font-body-sm text-xs text-on-surface-variant max-w-md mx-auto">Get answers to the most common queries regarding our representation, client onboarding, and billing processes.</p>
                </div>

                <div class="space-y-sm">
                    <!-- FAQ 1 -->
                    <div class="faq-item border border-outline-variant rounded-2xl overflow-hidden bg-surface-container-lowest">
                        <button class="w-full flex justify-between items-center p-xl font-headline-md text-sm text-primary text-left focus:outline-none select-none transition-all">
                            <span>How do I establish representation with LexCore?</span>
                            <span class="material-symbols-outlined faq-icon transition-transform">add</span>
                        </button>
                        <div class="faq-answer max-h-0 overflow-hidden transition-all duration-300 ease-in-out">
                            <p class="p-xl pt-0 font-body-sm text-xs text-on-surface-variant leading-relaxed border-t border-slate-50 dark:border-slate-800">
                                Representation is established solely after a formal conflict-of-interest check is conducted and a written retainer agreement is executed by an authorized partner of LexCore. Booking an initial consultation does not form an attorney-client relationship.
                            </p>
                        </div>
                    </div>

                    <!-- FAQ 2 -->
                    <div class="faq-item border border-outline-variant rounded-2xl overflow-hidden bg-surface-container-lowest">
                        <button class="w-full flex justify-between items-center p-xl font-headline-md text-sm text-primary text-left focus:outline-none select-none transition-all">
                            <span>What are your billing rates and fee structures?</span>
                            <span class="material-symbols-outlined faq-icon transition-transform">add</span>
                        </button>
                        <div class="faq-answer max-h-0 overflow-hidden transition-all duration-300 ease-in-out">
                            <p class="p-xl pt-0 font-body-sm text-xs text-on-surface-variant leading-relaxed border-t border-slate-50 dark:border-slate-800">
                                We offer hourly billing, flat-fee retainers, and structured contingency fee schedules depending on the scope of the matter. All billings are managed and tracked transparently through our secure Client Portal.
                            </p>
                        </div>
                    </div>

                    <!-- FAQ 3 -->
                    <div class="faq-item border border-outline-variant rounded-2xl overflow-hidden bg-surface-container-lowest">
                        <button class="w-full flex justify-between items-center p-xl font-headline-md text-sm text-primary text-left focus:outline-none select-none transition-all">
                            <span>Is the data uploaded to the Client Portal secure?</span>
                            <span class="material-symbols-outlined faq-icon transition-transform">add</span>
                        </button>
                        <div class="faq-answer max-h-0 overflow-hidden transition-all duration-300 ease-in-out">
                            <p class="p-xl pt-0 font-body-sm text-xs text-on-surface-variant leading-relaxed border-t border-slate-50 dark:border-slate-800">
                                Yes. All client matter files, hearing schedules, and communication dockets are protected by state-of-the-art SSL/TLS encryption and strict database access controls, ensuring absolute confidentiality and attorney-client privilege.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact & Inquiry Section -->
        <section id="contact" class="py-3xl px-lg lg:px-3xl bg-surface-container-low border-t border-outline-variant">
            <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-xl">
                <!-- Info Column -->
                <div class="lg:col-span-5 space-y-lg">
                    <div class="space-y-sm">
                        <span class="font-label-sm text-label-sm text-secondary uppercase tracking-wider">Reach Out</span>
                        <h2 class="font-display-lg text-headline-lg text-primary">Contact Our Offices</h2>
                        <p class="font-body-sm text-xs text-on-surface-variant">Speak directly with our intake coordinators to discuss scheduling parameters or matter escalations.</p>
                    </div>

                    <div class="space-y-md text-xs">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary">pin_drop</span>
                            <div>
                                <h5 class="font-bold text-slate-700">Global Headquarters</h5>
                                <p class="text-on-surface-variant">{{ config('system.firm_address', '100 Legal Way, Suite 400, New York, NY') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary">phone_in_talk</span>
                            <div>
                                <h5 class="font-bold text-slate-700">Intake Hotline</h5>
                                <p class="text-on-surface-variant">{{ config('system.firm_phone', '+1 (555) 019-2834') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary">mail</span>
                            <div>
                                <h5 class="font-bold text-slate-700">General Inquiries</h5>
                                <p class="text-on-surface-variant">{{ config('system.firm_email', 'admin@lexcore.test') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary">schedule</span>
                            <div>
                                <h5 class="font-bold text-slate-700">Office Hours</h5>
                                <p class="text-on-surface-variant">Monday – Friday: 8:00 AM – 6:00 PM EST</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Inquiry Form Column -->
                <div class="lg:col-span-7 bg-white p-xl rounded-2xl border border-outline-variant shadow-sm space-y-4">
                    <h3 class="font-headline-md text-base text-primary font-bold flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">chat_bubble</span>
                        Send a Message
                    </h3>
                    <form id="inquiry-form" class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="inquiry-name" class="font-semibold text-xs text-slate-500 block mb-1 uppercase tracking-wider text-[10px]">Your Name</label>
                                <input type="text" id="inquiry-name" required class="block w-full px-3 py-2 text-xs bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-primary/20 text-slate-800" />
                            </div>
                            <div>
                                <label for="inquiry-email" class="font-semibold text-xs text-slate-500 block mb-1 uppercase tracking-wider text-[10px]">Email Address</label>
                                <input type="email" id="inquiry-email" required class="block w-full px-3 py-2 text-xs bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-primary/20 text-slate-800" />
                            </div>
                        </div>
                        <div>
                            <label for="inquiry-subject" class="font-semibold text-xs text-slate-500 block mb-1 uppercase tracking-wider text-[10px]">Subject</label>
                            <input type="text" id="inquiry-subject" required class="block w-full px-3 py-2 text-xs bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-primary/20 text-slate-800" />
                        </div>
                        <div>
                            <label for="inquiry-message" class="font-semibold text-xs text-slate-500 block mb-1 uppercase tracking-wider text-[10px]">Message Details</label>
                            <textarea id="inquiry-message" rows="4" required class="block w-full px-3 py-2 text-xs bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-primary/20 text-slate-800"></textarea>
                        </div>
                        <button type="submit" class="w-full py-2.5 bg-primary text-white hover:opacity-90 font-semibold text-xs rounded-xl transition-all shadow-md shadow-indigo-900/10 flex items-center justify-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px]">send</span>
                            Submit Inquiry
                        </button>
                        <div id="inquiry-success" class="hidden p-3 bg-emerald-50 text-emerald-800 text-[10px] rounded-xl flex items-center gap-2 border border-emerald-150">
                            <span class="material-symbols-outlined text-[16px]">check_circle</span>
                            Thank you! Your inquiry has been logged successfully. Our intake coordinators will contact you shortly.
                        </div>
                    </form>
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
                    <a class="font-label-sm text-label-sm text-on-surface-variant hover:text-primary transition-colors" href="{{ route('privacy') }}">Privacy Policy</a>
                    <a class="font-label-sm text-label-sm text-on-surface-variant hover:text-primary transition-colors" href="{{ route('terms') }}">Terms of Service</a>
                    <a class="font-label-sm text-label-sm text-on-surface-variant hover:text-primary transition-colors" href="{{ route('accessibility') }}">Accessibility</a>
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

            // Statistics Count-Up Animation
            const stats = document.querySelectorAll("[data-animate-stat]");
            
            const parseStat = (text) => {
                const regex = /^([^0-9\.]*)([0-9\.]+)(.*)$/;
                const match = text.trim().match(regex);
                if (!match) return { prefix: '', value: 0, suffix: text, decimals: 0 };
                
                const prefix = match[1];
                const rawVal = match[2];
                const suffix = match[3];
                const decimals = rawVal.includes('.') ? rawVal.split('.')[1].length : 0;
                
                return {
                    prefix,
                    value: parseFloat(rawVal),
                    suffix,
                    decimals
                };
            };

            const animateStat = (el) => {
                const targetText = el.getAttribute("data-animate-stat");
                const parsed = parseStat(targetText);
                
                let startTimestamp = null;
                const duration = 1800; // 1.8 seconds duration
                
                const step = (timestamp) => {
                    if (!startTimestamp) startTimestamp = timestamp;
                    const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                    const easeProgress = progress * (2 - progress); // easeOutQuad
                    const currentVal = easeProgress * parsed.value;
                    
                    el.textContent = parsed.prefix + currentVal.toFixed(parsed.decimals) + parsed.suffix;
                    
                    if (progress < 1) {
                        window.requestAnimationFrame(step);
                    } else {
                        el.textContent = targetText;
                    }
                };
                window.requestAnimationFrame(step);
            };

            const statObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateStat(entry.target);
                        statObserver.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });

            stats.forEach(stat => statObserver.observe(stat));
            // Practice Area Modal Logic
            const practiceModal = document.getElementById("practice-modal");
            const modalTitle = document.getElementById("modal-title");
            const modalIcon = document.getElementById("modal-icon");
            const modalDescription = document.getElementById("modal-description");
            const modalBullets = document.getElementById("modal-bullets");
            const closeBtn = document.getElementById("close-modal");
            const cancelBtn = document.getElementById("modal-cancel");
            const bookBtn = document.getElementById("modal-book");
            
            const practiceDetails = {
                'corporate': {
                    title: 'Corporate & M&A',
                    icon: 'business_center',
                    description: 'Guiding multi-billion dollar transactions with rigorous due diligence, advanced risk mitigations, and sophisticated deal structures.',
                    details: [
                        'Cross-Border Mergers & Acquisitions',
                        'Joint Ventures & Strategic Alliances',
                        'Corporate Governance & SEC Compliance',
                        'Private Equity & Venture Capital Financing',
                        'Corporate Restructuring & Shareholder Agreements'
                    ]
                },
                'ip': {
                    title: 'Intellectual Property',
                    icon: 'lightbulb',
                    description: 'Global portfolio management and aggressive patent, trademark, and copyright protection for innovators.',
                    details: [
                        'Patent Prosecution & Portfolio Strategy',
                        'Trademark Registration & Brand Protection',
                        'IP Licensing & Technology Transfers',
                        'Copyright Enforcement & Digital Media Law',
                        'Trade Secret Protection Programs'
                    ]
                },
                'litigation': {
                    title: 'High-Stakes Litigation',
                    icon: 'gavel',
                    description: 'Uncompromising advocacy in state and federal courts across the country for complex business disputes.',
                    details: [
                        'Commercial & Securities Litigation',
                        'Class Action Defense Representation',
                        'White-Collar Criminal Defense & Investigations',
                        'Appellate Advocacy & Supreme Court Filings',
                        'International Arbitration & Dispute Resolution'
                    ]
                },
                'wealth': {
                    title: 'Private Wealth & Trust',
                    icon: 'family_history',
                    description: 'Discreet asset protection, tax minimization, and multi-generational legacy planning for high-net-worth families.',
                    details: [
                        'Family Trust & Estate Administration',
                        'Asset Protection & Wealth Transfer Structuring',
                        'Charitable Foundations & Philanthropy Strategy',
                        'Business Succession & Transition Planning',
                        'Estate & Gift Tax Minimization'
                    ]
                },
                'realestate': {
                    title: 'Commercial Real Estate',
                    icon: 'apartment',
                    description: 'Navigating complex zoning, land use, structured financing, and development challenges for developers and investors.',
                    details: [
                        'Acquisitions, Dispositions & Syndications',
                        'Commercial Leasing & Landlord-Tenant Work',
                        'Real Estate Finance & Joint Venture Equity',
                        'Zoning, Land Use & Environmental Approvals',
                        'Construction Contracts & Dispute Mediation'
                    ]
                }
            };

            const openPracticeModal = (key) => {
                const data = practiceDetails[key];
                if (!data) return;
                
                modalTitle.childNodes[2].textContent = ' ' + data.title;
                modalIcon.textContent = data.icon;
                modalDescription.textContent = data.description;
                
                modalBullets.innerHTML = "";
                data.details.forEach(item => {
                    const li = document.createElement("li");
                    li.className = "flex items-center gap-2";
                    li.innerHTML = `<span class="material-symbols-outlined text-[14px] text-emerald-500 font-bold">check</span> ${item}`;
                    modalBullets.appendChild(li);
                });
                
                practiceModal.classList.remove("hidden");
                setTimeout(() => {
                    practiceModal.classList.remove("opacity-0");
                    practiceModal.querySelector(".transform").classList.remove("scale-95");
                    practiceModal.querySelector(".transform").classList.add("scale-100");
                }, 20);
            };

            const closePracticeModal = () => {
                practiceModal.classList.add("opacity-0");
                practiceModal.querySelector(".transform").classList.remove("scale-100");
                practiceModal.querySelector(".transform").classList.add("scale-95");
                setTimeout(() => {
                    practiceModal.classList.add("hidden");
                }, 200);
            };

            document.querySelectorAll("[data-learn-more]").forEach(btn => {
                btn.addEventListener("click", () => {
                    const key = btn.getAttribute("data-learn-more");
                    openPracticeModal(key);
                });
            });

            closeBtn.addEventListener("click", closePracticeModal);
            cancelBtn.addEventListener("click", closePracticeModal);
            
            bookBtn.addEventListener("click", () => {
                closePracticeModal();
                setTimeout(() => {
                    if (window.Livewire) {
                        Livewire.dispatch('triggerConsultationModal');
                    }
                }, 250);
            });

            practiceModal.addEventListener("click", (e) => {
                if (e.target === practiceModal) {
                    closePracticeModal();
                }
            });

            // Cookie Consent Banner Logic
            const cookieBanner = document.getElementById("cookie-consent");
            const acceptCookiesBtn = document.getElementById("accept-cookies");

            if (cookieBanner && !localStorage.getItem("cookie_consent_accepted")) {
                cookieBanner.classList.remove("hidden");
                setTimeout(() => {
                    cookieBanner.classList.remove("translate-y-20", "opacity-0");
                }, 1000);
            }

            if (acceptCookiesBtn) {
                acceptCookiesBtn.addEventListener("click", () => {
                    localStorage.setItem("cookie_consent_accepted", "true");
                    cookieBanner.classList.add("translate-y-20", "opacity-0");
                    setTimeout(() => {
                        cookieBanner.classList.add("hidden");
                    }, 300);
                });
            }

            // FAQ Accordion Logic
            const faqItems = document.querySelectorAll(".faq-item");
            faqItems.forEach(item => {
                const btn = item.querySelector("button");
                const answer = item.querySelector(".faq-answer");
                const icon = item.querySelector(".faq-icon");

                btn.addEventListener("click", () => {
                    const isOpen = answer.style.maxHeight && answer.style.maxHeight !== "0px";
                    
                    document.querySelectorAll(".faq-answer").forEach(ans => ans.style.maxHeight = "0px");
                    document.querySelectorAll(".faq-icon").forEach(ic => ic.textContent = "add");

                    if (!isOpen) {
                        answer.style.maxHeight = answer.scrollHeight + "px";
                        icon.textContent = "remove";
                    }
                });
            });

            // Contact Inquiry Form Logic
            const inquiryForm = document.getElementById("inquiry-form");
            const inquirySuccess = document.getElementById("inquiry-success");

            if (inquiryForm) {
                inquiryForm.addEventListener("submit", (e) => {
                    e.preventDefault();
                    inquirySuccess.classList.remove("hidden");
                    inquiryForm.querySelectorAll("input, textarea, button").forEach(el => {
                        if (el.id !== "inquiry-success") el.style.display = "none";
                    });
                });
            }
        });
    </script>

    <!-- Practice Area Detail Modal -->
    <div id="practice-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/40 backdrop-blur-sm transition-all hidden opacity-0">
        <div class="w-full max-w-lg bg-white rounded-2xl border border-slate-200 p-6 shadow-2xl space-y-5 transition-all transform scale-95 duration-200">
            <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                <h3 id="modal-title" class="text-base font-bold text-slate-800 flex items-center gap-1.5">
                    <span id="modal-icon" class="material-symbols-outlined text-primary text-[20px]">gavel</span>
                    Practice Area Title
                </h3>
                <button id="close-modal" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <div class="space-y-4">
                <p id="modal-description" class="text-xs text-slate-650 leading-relaxed">
                    Detailed practice description...
                </p>

                <div class="space-y-2">
                    <h4 class="font-bold text-[10px] text-slate-400 uppercase tracking-wider">Key Specializations</h4>
                    <ul id="modal-bullets" class="space-y-2 text-xs text-slate-700">
                        <!-- Bullets go here -->
                    </ul>
                </div>
            </div>

            <!-- Footer / Book CTA -->
            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <button id="modal-cancel" class="px-4 py-2 bg-slate-100 hover:bg-slate-200/80 text-slate-700 font-semibold text-xs rounded-xl transition-all">
                    Close
                </button>
                <button id="modal-book" class="px-4 py-2 bg-primary text-white hover:opacity-90 font-semibold text-xs rounded-xl transition-all shadow-md shadow-indigo-900/10 flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[16px]">calendar_month</span>
                    Book Consultation
                </button>
            </div>
        </div>
    </div>
    
    <!-- Cookie Consent Banner -->
    <div id="cookie-consent" class="fixed bottom-4 left-4 right-4 md:left-6 md:right-auto md:max-w-md bg-slate-900 text-slate-100 p-4 rounded-2xl border border-slate-800 shadow-2xl z-50 transition-all transform translate-y-20 opacity-0 duration-300 hidden">
        <div class="flex flex-col gap-3">
            <div class="flex items-start gap-3">
                <span class="material-symbols-outlined text-secondary text-[24px]">cookie</span>
                <div class="space-y-1">
                    <h4 class="font-bold text-xs">We value your privacy</h4>
                    <p class="text-[10px] text-slate-400 leading-relaxed">
                        We use essential cookies to maintain your login session and theme preferences. By clicking "Accept All", you agree to our policies.
                    </p>
                </div>
            </div>
            <div class="flex justify-end gap-2 text-[10px] font-semibold">
                <a href="/privacy" class="px-3 py-1.5 text-slate-400 hover:text-slate-200 transition-colors">Privacy Policy</a>
                <button id="accept-cookies" class="px-4 py-1.5 bg-primary text-white hover:opacity-90 rounded-lg transition-all">Accept All</button>
            </div>
        </div>
    </div>
    
    @livewire('welcome-book-consultation')
</body>
</html>
