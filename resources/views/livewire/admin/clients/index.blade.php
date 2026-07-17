<div>
    <!-- Page Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-display-lg text-3xl text-primary dark:text-white mb-1 font-bold">Client Directory (CRM)</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Manage client representation folders, case histories, and billing metrics.</p>
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
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search client name or email..." 
                   class="pl-9 pr-4 py-2 w-full text-xs rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/60 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250">
        </div>
    </div>

    <!-- Table of Clients -->
    <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 shadow-sm overflow-hidden">
        @if($clients->isEmpty())
            <div class="p-12 text-center">
                <span class="material-symbols-outlined text-slate-300 dark:text-slate-650 text-5xl mb-4" style="font-variation-settings: 'FILL' 0;">person</span>
                <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-2">No Clients Found</h3>
                <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md mx-auto">No client profiles match your query.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800 text-[10px] uppercase font-bold tracking-wider text-slate-400 dark:text-slate-500">
                            <th class="px-6 py-4">Client Profile</th>
                            <th class="px-6 py-4">Linked Matters</th>
                            <th class="px-6 py-4">Total Invoices</th>
                            <th class="px-6 py-4">Outstanding Receivables</th>
                            <th class="px-6 py-4">Registration Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 text-xs text-slate-700 dark:text-slate-300">
                        @foreach($clients as $client)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                                <!-- Client Profile -->
                                <td class="px-6 py-4 flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-primary/5 dark:bg-blue-950/40 text-primary dark:text-blue-400 flex items-center justify-center font-bold text-xs shrink-0">
                                        {{ substr($client->name, 0, 2) }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-bold text-slate-850 dark:text-white mb-0.5">{{ $client->name }}</div>
                                        <div class="text-[10px] text-slate-400">{{ $client->email }}</div>
                                    </div>
                                </td>
                                <!-- Matters Count -->
                                <td class="px-6 py-4 font-semibold">
                                    {{ $client->matters_count }} active cases
                                </td>
                                <!-- Invoices Count -->
                                <td class="px-6 py-4">
                                    {{ $client->invoices_count }} statements
                                </td>
                                <!-- Outstanding Receivables -->
                                <td class="px-6 py-4 font-bold text-slate-850 dark:text-white">
                                    ${{ number_format($client->invoices->where('status', 'unpaid')->sum('total'), 2) }}
                                </td>
                                <!-- Registration Date -->
                                <td class="px-6 py-4 text-slate-500">
                                    {{ $client->created_at->format('M d, Y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination Controls -->
            <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800/80">
                {{ $clients->links() }}
            </div>
        @endif
    </div>
</div>
