<div>
    <!-- Page Header & Action -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-display-lg text-3xl text-primary dark:text-white mb-1 font-bold">Cases & Matters</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Monitor litigation progress, update phases, and manage active cases.</p>
        </div>
        <div>
            <a href="{{ route('admin.cases.create') }}" class="px-4 py-2.5 bg-primary hover:opacity-90 active:scale-98 text-white font-semibold text-xs rounded-xl transition-all shadow-md shadow-indigo-900/10 flex items-center gap-1.5 justify-center">
                <span class="material-symbols-outlined text-[18px]">add_circle</span>
                Open New Case
            </a>
        </div>
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
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search case title or number..." 
                   class="pl-9 pr-4 py-2 w-full text-xs rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/60 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-800 dark:text-slate-200">
        </div>

        <!-- Filters Dropdown group -->
        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            <!-- Status Filter -->
            <select wire:model.live="status" class="px-3 py-2 text-xs rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/60 focus:bg-white text-slate-800 dark:text-slate-200 focus:outline-none">
                <option value="">All Statuses</option>
                <option value="Discovery">Discovery</option>
                <option value="Mediation">Mediation</option>
                <option value="Trial">Trial</option>
                <option value="Closed">Closed</option>
                <option value="In Progress">In Progress</option>
            </select>

            <!-- Priority Filter -->
            <select wire:model.live="priority" class="px-3 py-2 text-xs rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/60 focus:bg-white text-slate-800 dark:text-slate-200 focus:outline-none">
                <option value="">All Priorities</option>
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
                <option value="critical">Critical</option>
            </select>
        </div>
    </div>

    <!-- Table of Cases -->
    <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 shadow-sm overflow-hidden">
        @if($matters->isEmpty())
            <div class="p-12 text-center">
                <span class="material-symbols-outlined text-slate-300 dark:text-slate-650 text-5xl mb-4" style="font-variation-settings: 'FILL' 0;">gavel</span>
                <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-2">No Cases Found</h3>
                <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md mx-auto">No cases match your filters. Try clearing your search parameters or open a new matter.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800 text-[10px] uppercase font-bold tracking-wider text-slate-400 dark:text-slate-500">
                            <th class="px-6 py-4">Case File</th>
                            <th class="px-6 py-4">Client</th>
                            <th class="px-6 py-4">Practice Area</th>
                            <th class="px-6 py-4">Lead Attorney</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Priority</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 text-xs text-slate-700 dark:text-slate-300">
                        @foreach($matters as $matter)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                                <!-- Case Title & Code -->
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-850 dark:text-white mb-0.5">{{ $matter->title }}</div>
                                    <div class="font-mono text-[10px] text-slate-400">#{{ $matter->case_number }}</div>
                                </td>
                                <!-- Client -->
                                <td class="px-6 py-4">
                                    <div class="font-semibold">{{ $matter->client->name ?? 'Unlinked' }}</div>
                                    <div class="text-[10px] text-slate-400">{{ $matter->client->email ?? '' }}</div>
                                </td>
                                <!-- Practice Area -->
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-[16px] text-primary dark:text-blue-400">
                                            {{ $matter->practiceArea->icon ?? 'gavel' }}
                                        </span>
                                        {{ $matter->practiceArea->name ?? 'General Counsel' }}
                                    </span>
                                </td>
                                <!-- Lead Attorney -->
                                <td class="px-6 py-4">
                                    <div class="font-semibold">{{ $matter->leadAttorney->name ?? 'Unassigned' }}</div>
                                </td>
                                <!-- Status Badge -->
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider
                                        {{ $matter->status === 'closed' ? 'bg-slate-100 text-slate-650 dark:bg-slate-800 dark:text-slate-400' : '' }}
                                        {{ $matter->status === 'trial' ? 'bg-rose-50 text-rose-600 dark:bg-rose-950/30 dark:text-rose-400' : '' }}
                                        {{ $matter->status === 'mediation' ? 'bg-amber-50 text-amber-600 dark:bg-amber-950/30 dark:text-amber-450' : '' }}
                                        {{ in_array($matter->status, ['discovery', 'in progress', 'In Progress', 'Discovery']) ? 'bg-blue-50 text-blue-600 dark:bg-blue-950/30 dark:text-blue-400' : '' }}
                                        {{ !in_array($matter->status, ['closed', 'trial', 'mediation', 'discovery', 'in progress', 'In Progress', 'Discovery']) ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-950/30 dark:text-emerald-450' : '' }}
                                    ">
                                        {{ $matter->status }}
                                    </span>
                                </td>
                                <!-- Priority Badge -->
                                <td class="px-6 py-4">
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider
                                        {{ $matter->priority === 'critical' ? 'bg-red-100 text-red-700 dark:bg-red-950/35 dark:text-red-400' : '' }}
                                        {{ $matter->priority === 'high' ? 'bg-orange-50 text-orange-600 dark:bg-orange-950/30 dark:text-orange-400' : '' }}
                                        {{ $matter->priority === 'medium' ? 'bg-blue-50 text-blue-600 dark:bg-blue-950/30 dark:text-blue-400' : '' }}
                                        {{ $matter->priority === 'low' ? 'bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400' : '' }}
                                    ">
                                        {{ $matter->priority }}
                                    </span>
                                </td>
                                <!-- Actions -->
                                <td class="px-6 py-4 text-right">
                                    <div class="inline-flex items-center gap-1">
                                        <a href="{{ route('admin.cases.show', $matter->id) }}" class="p-1.5 text-slate-400 hover:text-primary dark:hover:text-blue-400 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" title="View Detail">
                                            <span class="material-symbols-outlined text-[18px]">folder_open</span>
                                        </a>
                                        <a href="{{ route('admin.cases.edit', $matter->id) }}" class="p-1.5 text-slate-400 hover:text-amber-600 dark:hover:text-amber-400 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" title="Edit Case">
                                            <span class="material-symbols-outlined text-[18px]">edit</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination Controls -->
            <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800/80">
                {{ $matters->links() }}
            </div>
        @endif
    </div>
</div>
