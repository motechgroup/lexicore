<div>
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="font-display-lg text-3xl text-primary dark:text-white mb-1 font-bold">System Audit Logs</h1>
        <p class="text-slate-500 dark:text-slate-400 text-sm">Trace system events, user authentications, and compliance operations.</p>
    </div>

    <!-- Filter & Search Controls Panel -->
    <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-5 shadow-sm mb-6 flex flex-col md:flex-row items-center justify-between gap-4">
        <!-- Search Input -->
        <div class="relative w-full md:w-80">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search logs by activity or component..." 
                   class="pl-9 pr-4 py-2 w-full text-xs rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/60 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250">
        </div>
    </div>

    <!-- Table of Logs -->
    <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 shadow-sm overflow-hidden">
        @if($activities->isEmpty())
            <div class="p-12 text-center">
                <span class="material-symbols-outlined text-slate-300 dark:text-slate-650 text-5xl mb-4" style="font-variation-settings: 'FILL' 0;">history</span>
                <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-2">No System Logs Logged</h3>
                <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md mx-auto">The audit trail is currently empty or no events match your filter query.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800 text-[10px] uppercase font-bold tracking-wider text-slate-400 dark:text-slate-500">
                            <th class="px-6 py-4">Event Date</th>
                            <th class="px-6 py-4">Component</th>
                            <th class="px-6 py-4">Activity Description</th>
                            <th class="px-6 py-4">Causer / Operator</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 text-xs text-slate-700 dark:text-slate-300">
                        @foreach($activities as $act)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                                <!-- Date -->
                                <td class="px-6 py-4 font-mono text-[11px] text-slate-500">
                                    {{ $act->created_at->format('Y-m-d H:i:s T') }}
                                </td>
                                <!-- Component / Log Name -->
                                <td class="px-6 py-4 uppercase font-bold text-[10px] tracking-wider text-primary dark:text-blue-400">
                                    {{ $act->log_name }}
                                </td>
                                <!-- Description -->
                                <td class="px-6 py-4 font-semibold text-slate-850 dark:text-white">
                                    {{ $act->description }}
                                </td>
                                <!-- Causer / Operator -->
                                <td class="px-6 py-4">
                                    @if($act->causer)
                                        <div class="font-semibold">{{ $act->causer->name }}</div>
                                        <div class="text-[10px] text-slate-400">{{ $act->causer->email }}</div>
                                    @else
                                        <span class="text-slate-400 italic">System Auto-Scheduler</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination Controls -->
            <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800/80">
                {{ $activities->links() }}
            </div>
        @endif
    </div>
</div>
