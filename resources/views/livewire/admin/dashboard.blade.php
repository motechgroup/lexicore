<div>
    <!-- Welcome Header -->
    <div class="mb-8">
        <h1 class="font-display-lg text-3xl text-primary dark:text-white mb-1 font-bold">Dashboard Overview</h1>
        <p class="text-slate-500 dark:text-slate-400 text-sm">Firm performance and case analytics for the current quarter.</p>
    </div>

    <!-- 4 Analytics Bento Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Active Cases -->
        <div class="bg-white dark:bg-[#1e293b] p-6 rounded-2xl shadow-sm border border-slate-200/80 dark:border-slate-800/80 hover:shadow-md transition-all duration-300">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-blue-50 dark:bg-blue-950/40 rounded-xl text-primary dark:text-blue-400">
                    <span class="material-symbols-outlined">gavel</span>
                </div>
                <span class="text-emerald-600 dark:text-emerald-400 text-xs font-semibold">{{ $stats['active_cases']['change'] }}</span>
            </div>
            <p class="text-slate-400 dark:text-slate-500 text-xs uppercase tracking-wider font-semibold mb-1">Active Cases</p>
            <h3 class="font-display-lg text-2xl text-slate-800 dark:text-white font-bold mb-4">{{ $stats['active_cases']['value'] }}</h3>
            <div class="h-10 w-full flex items-end gap-1">
                <div class="bg-blue-500/20 w-full h-1/2 rounded-t-sm"></div>
                <div class="bg-blue-500/20 w-full h-3/4 rounded-t-sm"></div>
                <div class="bg-blue-500 w-full h-1/2 rounded-t-sm"></div>
                <div class="bg-blue-500/20 w-full h-full rounded-t-sm"></div>
                <div class="bg-blue-500 w-full h-2/3 rounded-t-sm"></div>
            </div>
        </div>

        @role('admin')
        <!-- Revenue -->
        <div class="bg-white dark:bg-[#1e293b] p-6 rounded-2xl shadow-sm border border-slate-200/80 dark:border-slate-800/80 hover:shadow-md transition-all duration-300">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-blue-50 dark:bg-blue-950/40 rounded-xl text-primary dark:text-blue-400">
                    <span class="material-symbols-outlined">payments</span>
                </div>
                <span class="text-emerald-600 dark:text-emerald-400 text-xs font-semibold">{{ $stats['revenue']['change'] }}</span>
            </div>
            <p class="text-slate-400 dark:text-slate-500 text-xs uppercase tracking-wider font-semibold mb-1">Revenue (MTD)</p>
            <h3 class="font-display-lg text-2xl text-slate-800 dark:text-white font-bold mb-4">${{ number_format($stats['revenue']['value']) }}</h3>
            <div class="h-10 w-full flex items-end gap-1">
                <div class="bg-blue-500/10 w-full h-1/3 rounded-t-sm"></div>
                <div class="bg-blue-500/10 w-full h-2/3 rounded-t-sm"></div>
                <div class="bg-blue-500/10 w-full h-1/2 rounded-t-sm"></div>
                <div class="bg-blue-500/10 w-full h-4/5 rounded-t-sm"></div>
                <div class="bg-blue-500 w-full h-full rounded-t-sm"></div>
            </div>
        </div>
        @endrole

        <!-- Billable Hours -->
        <div class="bg-white dark:bg-[#1e293b] p-6 rounded-2xl shadow-sm border border-slate-200/80 dark:border-slate-800/80 hover:shadow-md transition-all duration-300">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-blue-50 dark:bg-blue-950/40 rounded-xl text-primary dark:text-blue-400">
                    <span class="material-symbols-outlined">timer</span>
                </div>
                <span class="text-slate-500 dark:text-slate-400 text-xs font-semibold">{{ $stats['billable_hours']['change'] }}</span>
            </div>
            <p class="text-slate-400 dark:text-slate-500 text-xs uppercase tracking-wider font-semibold mb-1">Billable Hours</p>
            <h3 class="font-display-lg text-2xl text-slate-800 dark:text-white font-bold mb-4">{{ number_format($stats['billable_hours']['value']) }}</h3>
            <div class="h-10 w-full flex items-end gap-1">
                <div class="bg-blue-500/20 w-full h-3/4 rounded-t-sm"></div>
                <div class="bg-blue-500/20 w-full h-1/2 rounded-t-sm"></div>
                <div class="bg-blue-500/20 w-full h-2/3 rounded-t-sm"></div>
                <div class="bg-blue-500 w-full h-4/5 rounded-t-sm"></div>
                <div class="bg-blue-500/20 w-full h-1/2 rounded-t-sm"></div>
            </div>
        </div>

        <!-- New Leads -->
        <div class="bg-white dark:bg-[#1e293b] p-6 rounded-2xl shadow-sm border border-slate-200/80 dark:border-slate-800/80 hover:shadow-md transition-all duration-300">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-blue-50 dark:bg-blue-950/40 rounded-xl text-primary dark:text-blue-400">
                    <span class="material-symbols-outlined">person_add</span>
                </div>
                <span class="text-rose-600 dark:text-rose-400 text-xs font-semibold">{{ $stats['new_leads']['change'] }}</span>
            </div>
            <p class="text-slate-400 dark:text-slate-500 text-xs uppercase tracking-wider font-semibold mb-1">New Leads</p>
            <h3 class="font-display-lg text-2xl text-slate-800 dark:text-white font-bold mb-4">{{ $stats['new_leads']['value'] }}</h3>
            <div class="h-10 w-full flex items-end gap-1">
                <div class="bg-blue-500 w-full h-full rounded-t-sm"></div>
                <div class="bg-blue-500/20 w-full h-4/5 rounded-t-sm"></div>
                <div class="bg-blue-500/20 w-full h-2/3 rounded-t-sm"></div>
                <div class="bg-blue-500/20 w-full h-3/4 rounded-t-sm"></div>
                <div class="bg-blue-500/20 w-full h-1/2 rounded-t-sm"></div>
            </div>
        </div>
    </div>

    <!-- Lower Section: Activity, Hearings, Tasks -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Recent Activity List -->
        <section class="lg:col-span-5 bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-6 flex flex-col justify-between shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h4 class="font-display-lg text-lg text-slate-800 dark:text-white font-bold">Recent Activity</h4>
                <button class="text-primary dark:text-blue-400 font-semibold text-xs hover:underline">View All</button>
            </div>
            <div class="space-y-4 overflow-y-auto max-h-80 pr-2">
                @foreach($activities as $act)
                    <div class="flex gap-4 pb-4 border-b border-slate-100 dark:border-slate-850 last:border-0 last:pb-0">
                        <div class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-slate-800 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-primary dark:text-blue-400 text-[20px]">{{ $act['icon'] }}</span>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-slate-700 dark:text-slate-300">
                                <span class="font-bold">{{ $act['title'] }}</span> {{ $act['detail'] }}
                            </p>
                            <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-1">{{ $act['time'] }} &bull; {{ $act['user'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Upcoming Hearings Widget -->
        <section class="lg:col-span-4 bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-6 flex flex-col justify-between shadow-sm">
            <h4 class="font-display-lg text-lg text-slate-800 dark:text-white font-bold mb-6">Upcoming Hearings</h4>
            <div class="space-y-4">
                @foreach($hearings as $hearing)
                    <div class="bg-slate-50 dark:bg-slate-800/40 p-4 rounded-xl border-l-4 
                        {{ $hearing['border_color'] === 'primary' ? 'border-indigo-600 dark:border-blue-500' : '' }}
                        {{ $hearing['border_color'] === 'secondary' ? 'border-amber-500 dark:border-amber-400' : '' }}
                        {{ $hearing['border_color'] === 'slate' ? 'border-slate-400' : '' }}
                    ">
                        <div class="flex justify-between items-start mb-1">
                            <span class="text-[9px] font-bold tracking-widest text-slate-400 dark:text-slate-500 uppercase">{{ $hearing['time_label'] }}</span>
                        </div>
                        <p class="text-xs font-bold text-slate-800 dark:text-slate-200">{{ $hearing['title'] }}</p>
                        <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-0.5">{{ $hearing['location'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Pending Tasks List -->
        <section class="lg:col-span-3 bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-6 flex flex-col justify-between shadow-sm">
            <h4 class="font-display-lg text-lg text-slate-800 dark:text-white font-bold mb-6">Pending Tasks</h4>
            <div class="space-y-4">
                @foreach($tasks as $task)
                    <div class="flex items-start gap-3">
                        <input class="mt-1 rounded text-primary focus:ring-primary dark:bg-slate-800 border-slate-300 dark:border-slate-700" type="checkbox" @checked($task['completed']) />
                        <div class="min-w-0">
                            <p class="text-xs font-semibold text-slate-700 dark:text-slate-300 {{ $task['completed'] ? 'line-through opacity-50' : '' }} truncate">{{ $task['title'] }}</p>
                            <p class="text-[10px] mt-0.5 
                                {{ $task['status'] === 'overdue' ? 'text-red-500 font-semibold' : '' }}
                                {{ $task['status'] === 'today' ? 'text-amber-600 dark:text-amber-400' : '' }}
                                {{ $task['status'] === 'tomorrow' || $task['status'] === 'completed' ? 'text-slate-400 dark:text-slate-500' : '' }}
                            ">{{ $task['due'] }}</p>
                        </div>
                    </div>
                @endforeach
                <div class="pt-2">
                    <button class="w-full py-2 border border-dashed border-slate-350 dark:border-slate-700 text-slate-500 hover:text-primary dark:hover:text-blue-400 hover:border-primary dark:hover:border-blue-500 rounded-xl transition-all font-semibold text-xs flex items-center justify-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">add</span>
                        Add Task
                    </button>
                </div>
            </div>
        </section>
    </div>
</div>
