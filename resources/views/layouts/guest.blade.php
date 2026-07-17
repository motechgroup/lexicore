<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('system.firm_name', 'LexCore') }} | Secure Portal Access</title>

        <!-- Google Fonts & Material Symbols -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

        <style>
            body {
                font-family: 'Inter', sans-serif;
            }
            h1, h2, h3, h4, h5, h6 {
                font-family: 'Playfair Display', serif;
            }
            .legal-gradient {
                background: linear-gradient(135deg, #031635 0%, #1a2b4b 100%);
            }
            .glass-card {
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(16px);
                border: 1px solid rgba(255, 255, 255, 0.5);
            }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased min-h-screen legal-gradient flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Abstract Pattern Background -->
        <div class="absolute inset-0 opacity-10 pointer-events-none z-0">
            <svg height="100%" preserveAspectRatio="none" viewBox="0 0 100 100" width="100%">
                <path d="M0 100 L100 0" stroke="white" stroke-width="0.1"></path>
                <path d="M0 80 L80 0" stroke="white" stroke-width="0.1"></path>
                <path d="M0 60 L60 0" stroke="white" stroke-width="0.1"></path>
                <path d="M20 100 L100 20" stroke="white" stroke-width="0.1"></path>
                <path d="M40 100 L100 40" stroke="white" stroke-width="0.1"></path>
            </svg>
        </div>

        <div class="relative z-10 w-full sm:max-w-md">
            <!-- Brand Logo / Title -->
            <div class="text-center mb-8">
                <a href="/" class="inline-flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-amber-400 to-amber-600 flex items-center justify-center shadow-lg shadow-amber-950/30 shrink-0">
                        <span class="material-symbols-outlined text-white text-[28px]" style="font-variation-settings: 'FILL' 1;">balance</span>
                    </div>
                </a>
                <h1 class="text-3xl font-extrabold text-white mt-4 tracking-tight">
                    {{ config('system.firm_name', 'LexCore') }}
                </h1>
                <p class="mt-2 text-sm text-indigo-200">
                    Law Firm & Practice Management Portal
                </p>
            </div>

            <!-- Card Wrap -->
            <div class="glass-card shadow-2xl rounded-3xl p-8 border border-white/20">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
