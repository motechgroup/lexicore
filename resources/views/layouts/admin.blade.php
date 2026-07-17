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

    <title>{{ $title ?? config('system.firm_name', 'LexCore') }} - Management System</title>

    @if(config('system.favicon_url'))
        <link rel="icon" type="image/x-icon" href="{{ config('system.favicon_url') }}">
    @endif

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

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
        .dark ::-webkit-scrollbar-thumb:hover {
            background: rgba(148, 163, 184, 0.4);
        }
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(100, 116, 139, 0.4);
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
            <a href="#" class="flex items-center gap-3 overflow-hidden">
                <!-- Premium Gold/Indigo Icon logo -->
                @if(config('system.logo_url'))
                    <img src="{{ config('system.logo_url') }}" alt="Logo" class="w-9 h-9 object-contain shrink-0 rounded-lg bg-white/5 p-1" />
                @else
                    <div class="w-9 h-9 rounded-lg bg-gradient-to-tr from-blue-600 to-indigo-600 dark:from-blue-500 dark:to-indigo-500 flex items-center justify-center shadow-md shadow-indigo-200 dark:shadow-none shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                        </svg>
                    </div>
                @endif
                <span class="font-bold text-lg tracking-tight bg-gradient-to-r from-slate-900 to-slate-700 dark:from-white dark:to-slate-300 bg-clip-text text-transparent transition-all duration-300 truncate"
                      :class="{ 'opacity-0 w-0': sidebarCollapsed, 'opacity-100': !sidebarCollapsed }">
                    {{ config('system.firm_name', 'LexCore') }}
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
            <!-- Navigation items with active state checks -->
            @php
                $navItems = [
                    ['route' => route('admin.dashboard'), 'label' => 'Dashboard', 'active' => request()->routeIs('admin.dashboard'), 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />'],
                    ['route' => route('admin.cases.index'), 'label' => 'Cases & Matters', 'active' => request()->routeIs('admin.cases.*'), 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />'],
                    ['route' => route('admin.clients.index'), 'label' => 'Clients', 'active' => request()->routeIs('admin.clients.*'), 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />'],
                    ['route' => route('admin.invoices.index'), 'label' => 'Billing & Invoices', 'active' => request()->routeIs('admin.invoices.*'), 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />'],
                    ['route' => route('admin.appointments.index'), 'label' => 'Appointments', 'active' => request()->routeIs('admin.appointments.*'), 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />'],
                    ['route' => route('admin.documents.index'), 'label' => 'Documents', 'active' => request()->routeIs('admin.documents.*'), 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />'],
                    ['route' => route('admin.staff.index'), 'label' => 'Team Members', 'active' => request()->routeIs('admin.staff.*'), 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />'],
                    ['route' => route('admin.logs.index'), 'label' => 'System Logs', 'active' => request()->routeIs('admin.logs.*'), 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />'],
                ];
            @endphp

            @foreach ($navItems as $item)
                <a href="{{ $item['route'] }}" 
                   class="group flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium text-[14px] transition-all duration-200 
                          {{ $item['active'] 
                              ? 'bg-blue-50 text-blue-600 dark:bg-blue-950/40 dark:text-blue-400' 
                              : 'text-slate-600 hover:bg-slate-50 dark:text-slate-400 dark:hover:bg-slate-800/40 dark:hover:text-slate-200' }}"
                   :class="{ 'justify-center px-0': sidebarCollapsed }">
                    
                    <svg class="w-5 h-5 shrink-0 transition-transform group-hover:scale-105" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        {!! $item['icon'] !!}
                    </svg>

                    <span class="truncate transition-opacity duration-300"
                          :class="{ 'opacity-0 w-0 hidden': sidebarCollapsed, 'opacity-100': !sidebarCollapsed }">
                        {{ $item['label'] }}
                    </span>
                    
                    <!-- Tooltip when collapsed -->
                    <span x-show="sidebarCollapsed" 
                          x-transition
                          class="absolute left-20 bg-slate-900 text-white text-xs px-2.5 py-1.5 rounded shadow-lg pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-50">
                        {{ $item['label'] }}
                    </span>
                </a>
            @endforeach
        </nav>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-slate-200/80 dark:border-slate-800/80">
            <a href="{{ route('admin.settings.index') }}" 
               class="group flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium text-[14px] {{ request()->routeIs('admin.settings.*') ? 'bg-blue-50 text-blue-600 dark:bg-blue-950/40 dark:text-blue-400' : 'text-slate-600 hover:bg-slate-50 dark:text-slate-400 dark:hover:bg-slate-800/40 dark:hover:text-slate-200' }}"
               :class="{ 'justify-center px-0': sidebarCollapsed }">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="truncate transition-opacity duration-300"
                      :class="{ 'opacity-0 w-0 hidden': sidebarCollapsed, 'opacity-100': !sidebarCollapsed }">
                    Settings
                </span>
            </a>
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
            
            <!-- Left Header: Toggle Button & Search -->
            <div class="flex items-center gap-4">
                <!-- Hamburger (Mobile) -->
                <button @click="sidebarOpen = !sidebarOpen" 
                        class="p-2 -ml-2 rounded-lg text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 md:hidden focus:outline-none focus:bg-slate-100 dark:focus:bg-slate-800">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                </button>

                <!-- Sidebar collapse button (Desktop) -->
                <button @click="toggleSidebar()" 
                        class="hidden md:flex p-2 rounded-lg text-slate-400 hover:text-slate-600 dark:text-slate-500 dark:hover:text-slate-300 focus:outline-none hover:bg-slate-50 dark:hover:bg-slate-800/50">
                    <!-- Collapse Icon (changes direction based on state) -->
                    <svg class="w-5 h-5 transform transition-transform duration-300" 
                         :class="{ 'rotate-180': sidebarCollapsed }"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                    </svg>
                </button>

                <!-- Search Input with premium icon styling -->
                <div class="hidden sm:flex items-center relative max-w-xs">
                    <span class="absolute left-3 text-slate-400">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input type="text" 
                           placeholder="Search cases, invoices..." 
                           class="pl-10 pr-4 py-1.5 w-64 text-sm rounded-xl border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/60 focus:bg-white dark:focus:bg-slate-950 focus:border-indigo-500 focus:ring focus:ring-indigo-200/50 dark:focus:ring-indigo-900/30 transition-all placeholder-slate-400 dark:placeholder-slate-500 text-slate-800 dark:text-slate-200">
                </div>
            </div>

            <!-- Right Header: Dark Mode, Notifications, User Profile -->
            <div class="flex items-center gap-4">
                
                <!-- Dark Mode Toggle -->
                <button @click="toggleDarkMode()" 
                        class="p-2 rounded-xl text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800/60 transition-colors focus:outline-none"
                        aria-label="Toggle Dark Mode">
                    <!-- Sun Icon (shown in dark mode) -->
                    <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m2.828-9.9a5 5 0 117.072 0l-.707.707M6.343 6.343l.707.707m9.9 9.9l.707.707" />
                    </svg>
                    <!-- Moon Icon (shown in light mode) -->
                    <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>

                <!-- Notifications Dropdown -->
                <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                    <button @click="open = !open" 
                            class="p-2 rounded-xl text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800/60 transition-colors focus:outline-none relative">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <!-- Active Notification Dot -->
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-amber-500 ring-2 ring-white dark:ring-[#1e293b]"></span>
                    </button>

                    <!-- Dropdown Panel -->
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2.5 w-80 bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 shadow-xl overflow-hidden z-50"
                         x-cloak>
                        
                        <div class="px-4 py-3 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                            <span class="font-bold text-sm text-slate-800 dark:text-slate-200">Notifications</span>
                            <a href="#" class="text-xs text-blue-600 dark:text-blue-400 hover:underline">Mark all read</a>
                        </div>
                        
                        <div class="max-h-64 overflow-y-auto">
                            <!-- Dummy Notification 1 -->
                            <a href="#" class="flex gap-3 px-4 py-3 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors border-b border-slate-100 dark:border-slate-800/50">
                                <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center shrink-0">
                                    <svg class="w-4.5 h-4.5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-semibold text-slate-700 dark:text-slate-300 truncate">New case created: #2026-0045</p>
                                    <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-0.5">10 minutes ago</p>
                                </div>
                            </a>
                            <!-- Dummy Notification 2 -->
                            <a href="#" class="flex gap-3 px-4 py-3 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors border-b border-slate-100 dark:border-slate-800/50">
                                <div class="w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center shrink-0">
                                    <svg class="w-4.5 h-4.5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-semibold text-slate-700 dark:text-slate-300 truncate">Invoice paid by Apex Corp.</p>
                                    <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-0.5">1 hour ago</p>
                                </div>
                            </a>
                        </div>

                        <div class="px-4 py-2 bg-slate-50 dark:bg-slate-850/50 text-center border-t border-slate-100 dark:border-slate-800">
                            <a href="#" class="text-xs text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-300 font-medium">View all notifications</a>
                        </div>
                    </div>
                </div>

                <!-- User Profile Dropdown -->
                <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                    <button @click="open = !open" 
                            class="flex items-center gap-2 focus:outline-none rounded-xl p-1 hover:bg-slate-50 dark:hover:bg-slate-800/60 transition-colors">
                        <div class="w-8.5 h-8.5 rounded-full bg-gradient-to-tr from-indigo-500 to-blue-500 p-0.5 shrink-0">
                            <!-- Avatar Placeholder -->
                            <div class="w-full h-full bg-[#1e293b] rounded-full flex items-center justify-center border border-white/20">
                                <span class="font-bold text-xs text-white uppercase">{{ substr(auth()->user()->name, 0, 2) }}</span>
                            </div>
                        </div>
                        <div class="hidden md:flex flex-col text-left mr-1">
                            <span class="text-xs font-semibold text-slate-800 dark:text-slate-200">{{ auth()->user()->name }}</span>
                            <span class="text-[10px] text-slate-400 dark:text-slate-500 capitalize">{{ auth()->user()->loadMissing('roles')->roles->first()->name ?? 'Administrator' }}</span>
                        </div>
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
 
                    <!-- Dropdown Panel -->
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2.5 w-48 bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 shadow-xl overflow-hidden z-50 animate-in"
                         x-cloak>
                        
                        <div class="px-4 py-3 border-b border-slate-100 dark:border-slate-800">
                            <p class="text-xs text-slate-400">Signed in as</p>
                            <p class="text-xs font-semibold text-slate-800 dark:text-slate-200 truncate">{{ auth()->user()->email }}</p>
                        </div>
                        
                        <div class="py-1">
                            <a href="{{ route('profile') }}" class="flex items-center gap-2.5 px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                <svg class="w-4.5 h-4.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                My Profile
                            </a>
                            <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-2.5 px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                <svg class="w-4.5 h-4.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                </svg>
                                Firm Settings
                            </a>
                        </div>

                        <!-- Logout Action -->
                        <div class="border-t border-slate-100 dark:border-slate-800 py-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-950/20 transition-colors text-left focus:outline-none">
                                    <svg class="w-4.5 h-4.5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
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
            <div>{{ config('system.footer_text') ?: '© ' . date('Y') . ' ' . config('system.firm_name', 'LexCore') . '. All rights reserved.' }}</div>
            <div class="flex gap-4">
                <a href="{{ route('privacy') }}" target="_blank" class="hover:underline">Privacy Policy</a>
                <a href="{{ route('terms') }}" target="_blank" class="hover:underline">Terms & Conditions</a>
            </div>
        </footer>
    </div>

    @livewireScripts
</body>
</html>
