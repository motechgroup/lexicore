<div>
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="font-display-lg text-3xl text-primary dark:text-white mb-1 font-bold">Billing & Statements</h1>
        <p class="text-slate-500 dark:text-slate-400 text-sm">Review your legal fees, statements of account, and download invoices.</p>
    </div>

    <!-- Outstanding Balance Stat Box -->
    <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-6 shadow-sm mb-8 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <p class="text-slate-400 dark:text-slate-500 text-xs uppercase tracking-wider font-semibold mb-1">Total Outstanding Balance</p>
            <h2 class="font-display-lg text-4xl text-primary dark:text-white font-bold mb-2">${{ number_format($outstandingBalance, 2) }}</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400">All fees are payable upon statement receipt. Thank you for your retainer.</p>
        </div>
        <div class="flex items-center md:justify-end">
            <div class="px-5 py-4 bg-amber-50 dark:bg-amber-950/20 border border-amber-250 dark:border-amber-900 rounded-2xl text-xs text-amber-800 dark:text-amber-450 max-w-sm flex items-start gap-3">
                <span class="material-symbols-outlined text-[20px] shrink-0 text-amber-600">info</span>
                <div>
                    <span class="font-bold block mb-0.5">Wire Instructions:</span>
                    Please route wire settlements referencing your Case Number directly to our trust account.
                </div>
            </div>
        </div>
    </div>

    <!-- Invoices Ledger Card -->
    <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
            <h3 class="font-semibold text-sm text-slate-800 dark:text-slate-200">Invoice History</h3>
        </div>
        @if ($invoices->isEmpty())
            <div class="p-12 text-center">
                <span class="material-symbols-outlined text-slate-300 dark:text-slate-650 text-5xl mb-4" style="font-variation-settings: 'FILL' 0;">payments</span>
                <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-2">No Statements Registered</h3>
                <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md mx-auto">There are currently no billings or invoices linked to your account.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800 text-[10px] uppercase font-bold tracking-wider text-slate-400 dark:text-slate-500">
                            <th class="px-6 py-4">Invoice ID</th>
                            <th class="px-6 py-4">Linked Matter</th>
                            <th class="px-6 py-4">Due Date</th>
                            <th class="px-6 py-4">Total Amount</th>
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
                                <!-- Matter Title -->
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-800 dark:text-slate-300">{{ $invoice->matter->title ?? 'General Counsel retainer' }}</div>
                                    @if($invoice->matter)
                                        <div class="text-[10px] text-slate-400">#{{ $invoice->matter->case_number }}</div>
                                    @endif
                                </td>
                                <!-- Due Date -->
                                <td class="px-6 py-4">
                                    {{ $invoice->due_date->format('M d, Y') }}
                                </td>
                                <!-- Amount -->
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
                                        <a href="{{ route('client.invoices.show', $invoice->id) }}" class="p-1.5 text-slate-400 hover:text-primary dark:hover:text-blue-400 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" title="View Statement">
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
