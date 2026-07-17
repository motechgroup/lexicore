<div>
    <!-- Page Header & Action -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-display-lg text-3xl text-primary dark:text-white mb-1 font-bold">Billing & Invoices</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Oversee trust accounts, billable statements, collections, and fees.</p>
        </div>
        <div>
            <a href="{{ route('admin.invoices.create') }}" class="px-4 py-2.5 bg-primary hover:opacity-90 active:scale-98 text-white font-semibold text-xs rounded-xl transition-all shadow-md shadow-indigo-900/10 flex items-center gap-1.5 justify-center">
                <span class="material-symbols-outlined text-[18px]">add_circle</span>
                Generate Invoice
            </a>
        </div>
    </div>

    <!-- Quick Stats Receivables Dashboard -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-[#1e293b] p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800/80 shadow-sm">
            <p class="text-slate-400 dark:text-slate-500 text-xs uppercase tracking-wider font-semibold mb-1">Gross Billings</p>
            <h3 class="font-display-lg text-2xl text-slate-800 dark:text-white font-bold">{{ config('system.site_currency_symbol', '$') }}{{ number_format($totalBilled, 2) }}</h3>
        </div>
        <div class="bg-white dark:bg-[#1e293b] p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800/80 shadow-sm">
            <p class="text-slate-400 dark:text-slate-500 text-xs uppercase tracking-wider font-semibold mb-1">Collections MTD</p>
            <h3 class="font-display-lg text-2xl text-emerald-600 dark:text-emerald-450 font-bold">{{ config('system.site_currency_symbol', '$') }}{{ number_format($collectionsMtd, 2) }}</h3>
        </div>
        <div class="bg-white dark:bg-[#1e293b] p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800/80 shadow-sm">
            <p class="text-slate-400 dark:text-slate-500 text-xs uppercase tracking-wider font-semibold mb-1">Unpaid Receivables</p>
            <h3 class="font-display-lg text-2xl text-rose-600 dark:text-rose-400 font-bold">{{ config('system.site_currency_symbol', '$') }}{{ number_format($outstandingBalance, 2) }}</h3>
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
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search invoice ID or client name..." 
                   class="pl-9 pr-4 py-2 w-full text-xs rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/60 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-800 dark:text-slate-200">
        </div>

        <!-- Filters Dropdown group -->
        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            <!-- Status Filter -->
            <select wire:model.live="status" class="px-3 py-2 text-xs rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/60 focus:bg-white text-slate-800 dark:text-slate-200 focus:outline-none">
                <option value="">All Statuses</option>
                <option value="paid">Paid</option>
                <option value="unpaid">Unpaid</option>
                <option value="void">Void</option>
            </select>
        </div>
    </div>

    <!-- Table of Invoices -->
    <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 shadow-sm overflow-hidden">
        @if($invoices->isEmpty())
            <div class="p-12 text-center">
                <span class="material-symbols-outlined text-slate-300 dark:text-slate-650 text-5xl mb-4" style="font-variation-settings: 'FILL' 0;">payments</span>
                <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-2">No Invoices Found</h3>
                <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md mx-auto">No invoices match your filters. Try clearing your parameters or generate a new retainer statement.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800 text-[10px] uppercase font-bold tracking-wider text-slate-400 dark:text-slate-500">
                            <th class="px-6 py-4">Invoice ID</th>
                            <th class="px-6 py-4">Client</th>
                            <th class="px-6 py-4">Case File</th>
                            <th class="px-6 py-4">Due Date</th>
                            <th class="px-6 py-4">Total</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 text-xs text-slate-700 dark:text-slate-300">
                        @foreach($invoices as $invoice)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                                <!-- Invoice Number -->
                                <td class="px-6 py-4 font-mono font-bold text-slate-850 dark:text-white">
                                    #{{ $invoice->invoice_number }}
                                </td>
                                <!-- Client Profile -->
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-850 dark:text-white">{{ $invoice->client->name ?? 'Unlinked' }}</div>
                                    <div class="text-[10px] text-slate-400">{{ $invoice->client->email ?? '' }}</div>
                                </td>
                                <!-- Matter Title -->
                                <td class="px-6 py-4">
                                    <div class="font-medium text-slate-750 dark:text-slate-300 truncate max-w-[200px]">{{ $invoice->matter->title ?? 'General retainer' }}</div>
                                    @if($invoice->matter)
                                        <div class="text-[10px] text-slate-400">#{{ $invoice->matter->case_number }}</div>
                                    @endif
                                </td>
                                <!-- Due Date -->
                                <td class="px-6 py-4">
                                    {{ $invoice->due_date->format('M d, Y') }}
                                </td>
                                <!-- Total -->
                                <td class="px-6 py-4 font-bold text-slate-850 dark:text-white">
                                    {{ config('system.site_currency_symbol', '$') }}{{ number_format($invoice->total, 2) }}
                                </td>
                                <!-- Status Badge -->
                                <td class="px-6 py-4">
                                    @php
                                        $isOverdue = $invoice->status === 'unpaid' && $invoice->due_date->isPast();
                                        $badgeStatus = $isOverdue ? 'overdue' : $invoice->status;
                                    @endphp
                                    <span class="px-2.5 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider
                                        {{ $badgeStatus === 'paid' ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-950/30 dark:text-emerald-450' : '' }}
                                        {{ $badgeStatus === 'overdue' ? 'bg-rose-50 text-rose-600 dark:bg-rose-950/30 dark:text-rose-450' : '' }}
                                        {{ $badgeStatus === 'unpaid' ? 'bg-blue-50 text-blue-600 dark:bg-blue-950/30 dark:text-blue-400' : '' }}
                                    ">
                                        {{ $badgeStatus }}
                                    </span>
                                </td>
                                <!-- Actions -->
                                <td class="px-6 py-4 text-right">
                                    <div class="inline-flex items-center gap-1.5 justify-end">
                                        <a href="{{ route('admin.invoices.show', $invoice->id) }}" class="p-1.5 text-slate-400 hover:text-primary dark:hover:text-blue-400 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" title="View Statement">
                                            <span class="material-symbols-outlined text-[18px]">folder_open</span>
                                        </a>
                                        <a href="{{ route('invoices.pdf', $invoice->id) }}" class="p-1.5 text-slate-400 hover:text-amber-600 dark:hover:text-amber-450 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" title="Download PDF Invoice">
                                            <span class="material-symbols-outlined text-[18px]">download</span>
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
                {{ $invoices->links() }}
            </div>
        @endif
    </div>
</div>
