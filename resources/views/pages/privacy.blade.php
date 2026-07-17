<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Privacy Policy - {{ config('system.firm_name', 'LexCore') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @if(config('system.favicon_url'))
        <link rel="icon" type="image/x-icon" href="{{ config('system.favicon_url') }}">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-900 text-slate-100 font-sans min-h-screen flex flex-col justify-between">
    <header class="border-b border-slate-800 bg-slate-950/60 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
            <a href="/" class="font-bold text-lg text-white tracking-tight flex items-center gap-2">
                @if(config('system.logo_url'))
                    <img src="{{ config('system.logo_url') }}" alt="Logo" class="w-8 h-8 object-contain" />
                @endif
                {{ config('system.firm_name', 'LexCore') }}
            </a>
            <a href="/login" class="text-xs font-semibold text-slate-400 hover:text-white transition-colors">Client Portal</a>
        </div>
    </header>

    <main class="flex-1 max-w-4xl mx-auto px-6 py-12 w-full">
        <div class="prose prose-invert max-w-none bg-slate-950/40 border border-slate-850 p-8 rounded-2xl shadow-xl">
            {!! nl2br(e(config('system.privacy_policy', 'Privacy Policy is under construction.'))) !!}
        </div>
    </main>

    <footer class="border-t border-slate-850 bg-slate-950/40 py-6 text-center text-xs text-slate-500">
        {{ config('system.footer_text', '© ' . date('Y') . ' ' . config('system.firm_name', 'LexCore') . '. All rights reserved.') }}
    </footer>
</body>
</html>
