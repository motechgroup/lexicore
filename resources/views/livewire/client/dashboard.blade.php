<div>
    <!-- Header / Welcome Section -->
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
        <div>
            <p class="font-label-sm text-xs text-secondary uppercase tracking-widest mb-1">Secure Portal Access</p>
            <h2 class="font-display-lg text-3xl text-primary font-bold">Welcome back, {{ auth()->user()->name }}.</h2>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Here is an overview of your active legal matters.</p>
        </div>
        <div class="flex gap-3">
            <button class="bg-white dark:bg-[#1e293b] text-primary border border-slate-200 dark:border-slate-800 px-5 py-2.5 rounded-xl font-medium text-sm hover:bg-slate-50 dark:hover:bg-slate-800 transition-all shadow-sm">
                Message Counsel
            </button>
            <button class="bg-primary text-on-primary px-5 py-2.5 rounded-xl font-medium text-sm hover:opacity-90 transition-all flex items-center gap-1.5 shadow-sm">
                <span class="material-symbols-outlined text-[18px]">add</span>
                New Consultation
            </button>
        </div>
    </div>

    <!-- Bento Grid Layout -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
        <!-- Case Status Card (Spans 8) -->
        <section class="md:col-span-8 bg-white dark:bg-[#1e293b] rounded-2xl p-6 shadow-sm border border-slate-200/80 dark:border-slate-800/80 relative overflow-hidden flex flex-col justify-between">
            <div class="absolute top-0 right-0 p-6">
                <span class="bg-amber-50 text-amber-700 dark:bg-amber-950/30 dark:text-amber-400 px-3 py-1 rounded-full text-xs font-semibold">
                    {{ $case['status'] }}
                </span>
            </div>
            <div class="mb-8">
                <p class="text-xs text-slate-400 uppercase font-semibold mb-1">Current Case Status</p>
                <h3 class="font-headline-md text-xl text-primary dark:text-white font-bold">{{ $case['title'] }}</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $case['practice_area'] }} | Case ID: {{ $case['case_id'] }}</p>
            </div>
            
            <!-- Status Timeline -->
            <div class="flex justify-between items-start mt-6 mb-8 relative">
                <div class="absolute top-4 left-0 w-full h-[2px] bg-slate-100 dark:bg-slate-800 z-0"></div>
                <div class="absolute top-4 left-0 w-1/2 h-[2px] bg-primary dark:bg-blue-500 z-0"></div>
                
                <!-- Steps -->
                <div class="relative z-10 flex flex-col items-center">
                    <div class="w-8 h-8 rounded-full bg-primary dark:bg-blue-500 text-white flex items-center justify-center mb-2 shadow">
                        <span class="material-symbols-outlined text-[16px]">check</span>
                    </div>
                    <span class="text-xs text-primary dark:text-blue-400 font-medium">Filing</span>
                </div>
                <div class="relative z-10 flex flex-col items-center">
                    <div class="w-8 h-8 rounded-full bg-primary dark:bg-blue-500 text-white flex items-center justify-center mb-2 shadow">
                        <span class="material-symbols-outlined text-[16px]">check</span>
                    </div>
                    <span class="text-xs text-primary dark:text-blue-400 font-medium">Service</span>
                </div>
                <div class="relative z-10 flex flex-col items-center">
                    <div class="w-9 h-9 rounded-full bg-primary dark:bg-blue-500 text-white flex items-center justify-center mb-1.5 border-4 border-white dark:border-[#1e293b] shadow-md">
                        <span class="material-symbols-outlined text-[16px]">search</span>
                    </div>
                    <span class="text-xs text-primary dark:text-blue-400 font-bold">Discovery</span>
                </div>
                <div class="relative z-10 flex flex-col items-center">
                    <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center mb-2">
                        <span class="material-symbols-outlined text-[16px]">balance</span>
                    </div>
                    <span class="text-xs text-slate-400 dark:text-slate-500">Mediation</span>
                </div>
                <div class="relative z-10 flex flex-col items-center">
                    <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center mb-2">
                        <span class="material-symbols-outlined text-[16px]">gavel</span>
                    </div>
                    <span class="text-xs text-slate-400 dark:text-slate-500">Trial</span>
                </div>
            </div>

            <div class="mt-4 pt-6 border-t border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex gap-8">
                    <div>
                        <p class="text-[11px] font-semibold text-slate-400 uppercase">Last Update</p>
                        <p class="text-sm text-slate-700 dark:text-slate-300 font-medium">{{ $case['last_update'] }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] font-semibold text-slate-400 uppercase">Assigned Counsel</p>
                        <p class="text-sm text-slate-700 dark:text-slate-300 font-medium">{{ $case['counsel'] }}</p>
                    </div>
                </div>
                <a class="text-primary dark:text-blue-400 text-sm font-semibold flex items-center gap-1 hover:underline" href="#">
                    Full Case File <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </a>
            </div>
        </section>

        <!-- Next Appointment Card (Spans 4) -->
        <section class="md:col-span-4 bg-primary text-on-primary rounded-2xl p-6 shadow-sm flex flex-col justify-between">
            <div>
                <div class="w-12 h-12 bg-primary-container rounded-xl flex items-center justify-center mb-6 shadow-sm">
                    <span class="material-symbols-outlined text-on-primary-container">event</span>
                </div>
                <p class="text-xs text-indigo-200 uppercase tracking-widest font-semibold mb-1">Next Appointment</p>
                <h3 class="font-headline-md text-xl text-white font-bold leading-tight">{{ $appointment['title'] }}</h3>
                <p class="text-sm text-indigo-200 mt-1">With {{ $appointment['counsel'] }}</p>
                
                <div class="mt-8 flex items-baseline gap-2">
                    <div class="text-center">
                        <p class="text-3xl font-extrabold text-white leading-none">0{{ $appointment['days_left'] }}</p>
                        <p class="text-[10px] text-indigo-200 font-bold mt-1">DAYS</p>
                    </div>
                    <p class="text-2xl font-bold text-indigo-300 leading-none">:</p>
                    <div class="text-center">
                        <p class="text-3xl font-extrabold text-white leading-none">{{ $appointment['hours_left'] }}</p>
                        <p class="text-[10px] text-indigo-200 font-bold mt-1">HRS</p>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-indigo-900/60 space-y-4">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-indigo-300 text-[20px]">schedule</span>
                    <span class="text-xs text-indigo-100 font-medium">{{ $appointment['date'] }} at {{ $appointment['time'] }}</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-indigo-300 text-[20px]">pin_drop</span>
                    <span class="text-xs text-indigo-100 font-medium truncate">{{ $appointment['location'] }}</span>
                </div>
                <button class="w-full bg-white text-primary py-2.5 rounded-xl font-semibold text-sm hover:bg-slate-50 transition-all shadow-md mt-2">
                    Reschedule
                </button>
            </div>
        </section>

        <!-- Unpaid Invoices (Spans 4) -->
        <section class="md:col-span-4 bg-white dark:bg-[#1e293b] rounded-2xl p-6 shadow-sm border border-slate-200/80 dark:border-slate-800/80 flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xs font-bold text-slate-400 uppercase">Financial Summary</h3>
                    <span class="material-symbols-outlined text-slate-400">payments</span>
                </div>
                <div class="mb-6">
                    <p class="text-xs text-slate-500 dark:text-slate-400">Total Outstanding</p>
                    <p class="font-headline-lg text-3xl text-primary dark:text-white font-bold">${{ number_format(collect($invoices)->sum('amount'), 2) }}</p>
                </div>
                <div class="space-y-4 mb-6">
                    @foreach($invoices as $invoice)
                        <div class="flex justify-between items-center py-2.5 border-b border-slate-100 dark:border-slate-850">
                            <div>
                                <p class="text-xs font-semibold text-slate-700 dark:text-slate-300">Invoice #{{ $invoice['number'] }}</p>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400">{{ $invoice['description'] }}</p>
                            </div>
                            <p class="text-sm font-semibold text-primary dark:text-blue-400">${{ number_format($invoice['amount'], 2) }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            <button class="w-full bg-secondary text-white py-2.5 rounded-xl font-semibold text-sm hover:opacity-90 transition-all shadow-md">
                Pay Outstanding Balance
            </button>
        </section>

        <!-- Recent Documents (Spans 8) -->
        <section class="md:col-span-8 bg-white dark:bg-[#1e293b] rounded-2xl p-6 shadow-sm border border-slate-200/80 dark:border-slate-800/80">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xs font-bold text-slate-400 uppercase">Recent Documents</h3>
                <a class="text-xs text-blue-600 dark:text-blue-400 font-semibold hover:underline" href="#">View All Documents</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach($documents as $doc)
                    <div class="group cursor-pointer p-3.5 border border-slate-100 dark:border-slate-800 hover:border-blue-500/50 dark:hover:border-blue-500/50 rounded-xl flex items-center gap-3.5 hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition-all">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0
                            {{ $doc['icon_color'] === 'red' ? 'bg-red-50 text-red-600 dark:bg-red-950/20 dark:text-red-400' : '' }}
                            {{ $doc['icon_color'] === 'blue' ? 'bg-blue-50 text-blue-600 dark:bg-blue-950/20 dark:text-blue-400' : '' }}
                            {{ $doc['icon_color'] === 'amber' ? 'bg-amber-50 text-amber-600 dark:bg-amber-950/20 dark:text-amber-400' : '' }}
                            {{ $doc['icon_color'] === 'slate' ? 'bg-slate-50 text-slate-600 dark:bg-slate-900/30 dark:text-slate-400' : '' }}
                        ">
                            <span class="material-symbols-outlined">{{ $doc['icon'] }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold text-slate-700 dark:text-slate-300 group-hover:text-primary dark:group-hover:text-blue-400 transition-colors truncate">
                                {{ $doc['name'] }}
                            </p>
                            <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-0.5">{{ $doc['time'] }}</p>
                        </div>
                        <span class="material-symbols-outlined text-slate-400 group-hover:text-primary dark:group-hover:text-blue-400 transition-all">download</span>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
</div>
