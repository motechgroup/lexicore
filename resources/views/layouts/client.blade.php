<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      x-data="{ 
          darkMode: localStorage.getItem('darkMode') === 'true', 
          sidebarOpen: false, 
          sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true',
          toggleDarkMode() {
              this.darkMode = !this.darkMode;
              localStorage.setItem('darkMode', this.darkMode);
          },
          toggleSidebar() {
              this.sidebarCollapsed = !this.sidebarCollapsed;
              localStorage.setItem('sidebarCollapsed', this.sidebarCollapsed);
          }
      }"
      :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('system.firm_name', 'LexCore') }} - Client Portal</title>

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
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        /* Custom scrollbar for premium feel */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        .dark ::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.2);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(100, 116, 139, 0.2);
            border-radius: 4px;
        }
    </style>

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-[#f8fafc] dark:bg-[#0f172a] text-slate-800 dark:text-slate-200 antialiased min-h-screen flex transition-colors duration-300">

    <aside 
        class="fixed inset-y-0 left-0 z-50 flex flex-col bg-white dark:bg-[#1e293b] border-r border-slate-200/80 dark:border-slate-800/80 transition-all duration-300 transform md:translate-x-0 w-64"
        :class="{
            'w-64': !sidebarCollapsed,
            'w-20': sidebarCollapsed,
            'translate-x-0': sidebarOpen,
            '-translate-x-full': !sidebarOpen
        }"
        x-cloak>
        
        <!-- Sidebar Brand / Logo -->
        <div class="h-16 flex items-center justify-between px-5 border-b border-slate-200/80 dark:border-slate-800/80">
            <a href="/" class="flex items-center gap-3 overflow-hidden">
                <div class="w-9 h-9 rounded-lg bg-gradient-to-tr from-blue-600 to-indigo-600 dark:from-blue-500 dark:to-indigo-500 flex items-center justify-center shadow-md shadow-indigo-200 dark:shadow-none shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                    </svg>
                </div>
                <span class="font-bold text-lg tracking-tight bg-gradient-to-r from-slate-900 to-slate-700 dark:from-white dark:to-slate-300 bg-clip-text text-transparent transition-all duration-300 truncate"
                      :class="{ 'opacity-0 w-0': sidebarCollapsed, 'opacity-100': !sidebarCollapsed }">
                    LexCore
                </span>
            </a>
            <!-- Mobile Close Button -->
            <button @click="sidebarOpen = false" class="md:hidden text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Sidebar Navigation Links -->
        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
            @php
                $navItems = [
                    ['route' => route('client.dashboard'), 'label' => 'Overview', 'active' => request()->routeIs('client.dashboard'), 'icon' => 'dashboard'],
                    ['route' => route('client.cases.index'), 'label' => 'Case Management', 'active' => request()->routeIs('client.cases.*'), 'icon' => 'gavel'],
                    ['route' => route('client.appointments.index'), 'label' => 'Calendar', 'active' => request()->routeIs('client.appointments.*'), 'icon' => 'calendar_today'],
                    ['route' => route('client.invoices.index'), 'label' => 'Billing', 'active' => request()->routeIs('client.invoices.*'), 'icon' => 'payments'],
                ];
            @endphp

            @foreach ($navItems as $item)
                <a href="{{ $item['route'] }}" 
                   class="group flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium text-[14px] transition-all duration-200 
                          {{ $item['active'] 
                              ? 'bg-blue-50 text-blue-600 dark:bg-blue-950/40 dark:text-blue-400' 
                              : 'text-slate-600 hover:bg-slate-50 dark:text-slate-400 dark:hover:bg-slate-800/40 dark:hover:text-slate-200' }}"
                   :class="{ 'justify-center px-0': sidebarCollapsed }">
                    
                    <span class="material-symbols-outlined w-5 h-5 shrink-0 flex items-center justify-center transition-transform group-hover:scale-105">
                        {{ $item['icon'] }}
                    </span>

                    <span class="truncate transition-opacity duration-300"
                          :class="{ 'opacity-0 w-0 hidden': sidebarCollapsed, 'opacity-100': !sidebarCollapsed }">
                        {{ $item['label'] }}
                    </span>
                </a>
            @endforeach
        </nav>

        <!-- Sidebar Profile and Bottom Settings -->
        <div class="p-4 border-t border-slate-200/80 dark:border-slate-800/80 space-y-3">
            <a href="{{ route('profile') }}" 
               class="group flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium text-[14px] {{ request()->routeIs('profile') ? 'bg-blue-50 text-blue-600 dark:bg-blue-950/40 dark:text-blue-400' : 'text-slate-600 hover:bg-slate-50 dark:text-slate-400 dark:hover:bg-slate-800/40 dark:hover:text-slate-200' }}"
               :class="{ 'justify-center px-0': sidebarCollapsed }">
                <span class="material-symbols-outlined w-5 h-5 shrink-0 flex items-center justify-center">settings</span>
                <span class="truncate transition-opacity duration-300"
                      :class="{ 'opacity-0 w-0 hidden': sidebarCollapsed, 'opacity-100': !sidebarCollapsed }">
                    Settings
                </span>
            </a>
            <div class="flex items-center gap-3 px-1 transition-all duration-300" :class="{ 'justify-center': sidebarCollapsed }">
                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-500 to-blue-500 flex items-center justify-center text-white font-bold shrink-0 shadow-sm shadow-indigo-150">
                    {{ substr(auth()->user()->name ?? 'C', 0, 2) }}
                </div>
                <div class="flex flex-col text-left min-w-0" :class="{ 'opacity-0 w-0 hidden': sidebarCollapsed, 'opacity-100': !sidebarCollapsed }">
                    <p class="text-xs font-semibold text-slate-800 dark:text-slate-200 truncate">{{ auth()->user()->name ?? 'Client User' }}</p>
                    <p class="text-[10px] text-slate-400 dark:text-slate-500 truncate">Client #{{ auth()->user()->id ?? '0000' }}</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Sidebar Overlay for mobile -->
    <div x-show="sidebarOpen" 
         x-transition:opacity
         @click="sidebarOpen = false" 
         class="fixed inset-0 z-40 bg-slate-900/40 backdrop-blur-sm md:hidden"
         x-cloak>
    </div>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-h-screen transition-all duration-300 md:pl-64"
         :class="{
             'md:pl-64': !sidebarCollapsed,
             'md:pl-20': sidebarCollapsed
         }">
        
        <!-- Topbar / Header -->
        <header class="h-16 sticky top-0 z-30 flex items-center justify-between px-6 bg-white/80 dark:bg-[#1e293b]/80 backdrop-blur-md border-b border-slate-200/80 dark:border-slate-800/80 transition-colors">
            
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = !sidebarOpen" 
                        class="p-2 -ml-2 rounded-lg text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 md:hidden focus:outline-none focus:bg-slate-100 dark:focus:bg-slate-800">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                </button>

                <button @click="toggleSidebar()" 
                        class="hidden md:flex p-2 rounded-lg text-slate-400 hover:text-slate-600 dark:text-slate-500 dark:hover:text-slate-300 focus:outline-none hover:bg-slate-50 dark:hover:bg-slate-800/50">
                    <svg class="w-5 h-5 transform transition-transform duration-300" 
                         :class="{ 'rotate-180': sidebarCollapsed }"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                    </svg>
                </button>
            </div>

            <!-- Right Header: Dark Mode & User Profile -->
            <div class="flex items-center gap-4">
                <button @click="toggleDarkMode()" 
                        class="p-2 rounded-xl text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800/60 transition-colors focus:outline-none"
                        aria-label="Toggle Dark Mode">
                    <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m2.828-9.9a5 5 0 117.072 0l-.707.707M6.343 6.343l.707.707m9.9 9.9l.707.707" />
                    </svg>
                    <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>

                <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                    <button @click="open = !open" class="flex items-center gap-2 focus:outline-none">
                        <div class="w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center text-slate-750 dark:text-slate-200 font-bold text-xs shrink-0">
                            {{ substr(auth()->user()->name ?? 'C', 0, 1) }}
                        </div>
                    </button>

                    <div x-show="open" 
                         x-transition
                         class="absolute right-0 mt-2.5 w-48 bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 shadow-xl overflow-hidden z-50"
                         x-cloak>
                        <div class="px-4 py-3 border-b border-slate-100 dark:border-slate-800">
                            <p class="text-xs text-slate-400">Client Portal</p>
                            <p class="text-xs font-semibold text-slate-800 dark:text-slate-200 truncate">{{ auth()->user()->email }}</p>
                        </div>
                        <div class="py-1">
                            <a href="{{ route('profile') }}" class="flex items-center gap-2.5 px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                <span class="material-symbols-outlined text-[18px] text-slate-400">person</span>
                                My Profile
                            </a>
                        </div>
                        <div class="border-t border-slate-100 dark:border-slate-800 py-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-950/20 transition-colors text-left focus:outline-none">
                                    <span class="material-symbols-outlined text-[18px]">logout</span>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Panel Body -->
        <main class="flex-1 p-6 md:p-8">
            {{ $slot }}
        </main>
        
        <!-- Premium Footer -->
        <footer class="h-14 flex items-center justify-between px-6 border-t border-slate-200/80 dark:border-slate-800/80 bg-white/20 dark:bg-slate-900/10 text-xs text-slate-400 dark:text-slate-500">
            <div>&copy; {{ date('Y') }} {{ config('system.firm_name', 'LexCore') }}. All rights reserved.</div>
            <div class="flex gap-4">
                <a href="{{ route('privacy') }}" target="_blank" class="hover:underline">Privacy Policy</a>
                <a href="{{ route('terms') }}" target="_blank" class="hover:underline">Terms & Conditions</a>
                <a href="{{ route('accessibility') }}" target="_blank" class="hover:underline">Accessibility Statement</a>
            </div>
        </footer>
    </div>

    @livewireScripts
</body>
</html>
