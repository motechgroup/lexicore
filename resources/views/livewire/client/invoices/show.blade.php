<div>
    <!-- Back to Invoices & Title -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <a href="{{ route('client.invoices.index') }}" class="inline-flex items-center gap-1.5 text-xs text-slate-500 hover:text-primary dark:hover:text-blue-400 font-semibold mb-3">
                <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                Back to Invoices Ledger
            </a>
            <div class="flex items-center gap-3 mb-1">
                <span class="text-xs font-semibold text-slate-400 font-mono">#{{ $invoice->invoice_number }}</span>
                @php
                    $isOverdue = $invoice->status === 'unpaid' && $invoice->due_date->isPast();
                    $badgeStatus = $isOverdue ? 'overdue' : $invoice->status;
                @endphp
                <span class="px-2.5 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider
                    {{ $badgeStatus === 'paid' ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-950/30 dark:text-emerald-450' : '' }}
                    {{ $badgeStatus === 'overdue' ? 'bg-rose-50 text-rose-600 dark:bg-rose-950/30 dark:text-rose-455' : '' }}
                    {{ $badgeStatus === 'unpaid' ? 'bg-blue-50 text-blue-600 dark:bg-blue-950/30 dark:text-blue-400' : '' }}
                ">
                    {{ $badgeStatus }}
                </span>
            </div>
            <h1 class="font-display-lg text-3xl text-primary dark:text-white font-bold">Statement of Account</h1>
        </div>
        <div>
            <a href="{{ route('invoices.pdf', $invoice->id) }}" class="px-4 py-2.5 bg-primary hover:opacity-90 active:scale-98 text-white font-semibold text-xs rounded-xl transition-all shadow-md shadow-indigo-900/10 flex items-center gap-1.5 justify-center">
                <span class="material-symbols-outlined text-[18px]">download</span>
                Download PDF Invoice
            </a>
        </div>
    </div>

    <!-- Statement Details Layout -->
    <div class="bg-white dark:bg-[#1e293b] rounded-3xl border border-slate-200/80 dark:border-slate-800/80 p-8 shadow-sm max-w-4xl mx-auto">
        <!-- Logo and Invoice Meta -->
        <div class="flex flex-col md:flex-row justify-between items-start border-b border-slate-100 dark:border-slate-850 pb-6 mb-6 gap-6">
            <div>
                <h1 class="font-display-lg text-2xl text-primary dark:text-white font-bold">{{ config('system.firm_name', 'LexCore') }}</h1>
                <p class="text-xs text-amber-600 dark:text-amber-450 uppercase tracking-wider font-semibold font-sans mt-1">Legal Practice & Advocacy</p>
            </div>
            <div class="text-left md:text-right space-y-1 text-xs">
                <p class="text-slate-400">Statement ID: <span class="font-semibold text-slate-800 dark:text-slate-200 font-mono">{{ $invoice->invoice_number }}</span></p>
                <p class="text-slate-400">Issue Date: <span class="font-semibold text-slate-800 dark:text-slate-200">{{ $invoice->created_at->format('M d, Y') }}</span></p>
                <p class="text-slate-400">Due Date: <span class="font-semibold text-slate-850 dark:text-slate-200">{{ $invoice->due_date->format('M d, Y') }}</span></p>
            </div>
        </div>

        <!-- Billed to & Case details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 text-xs">
            <div>
                <h3 class="text-slate-400 uppercase tracking-wider font-semibold mb-2 text-[10px]">Billed To</h3>
                <p class="font-bold text-sm text-slate-850 dark:text-white mb-1">{{ $invoice->client->name }}</p>
                <p class="text-slate-500">{{ $invoice->client->email }}</p>
            </div>
            <div class="text-left md:text-right">
                <h3 class="text-slate-400 uppercase tracking-wider font-semibold mb-2 text-[10px]">Case File Reference</h3>
                <p class="font-bold text-sm text-slate-850 dark:text-white mb-1">{{ $invoice->matter->title ?? 'General Legal Counsel' }}</p>
                @if($invoice->matter)
                    <p class="text-slate-500 font-mono">Case Code: #{{ $invoice->matter->case_number }}</p>
                @endif
            </div>
        </div>

        <!-- Line items table -->
        <div class="overflow-x-auto mb-8 border border-slate-100 dark:border-slate-850 rounded-2xl">
            <table class="w-full border-collapse text-xs text-left">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/40 text-slate-400 font-bold uppercase tracking-wider text-[10px] border-b border-slate-100 dark:border-slate-800">
                        <th class="px-6 py-3.5 w-1/2">Description</th>
                        <th class="px-6 py-3.5 text-right">Rate</th>
                        <th class="px-6 py-3.5 text-right font-semibold">Hours / Qty</th>
                        <th class="px-6 py-3.5 text-right">Line Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 text-slate-700 dark:text-slate-350">
                    @foreach($invoice->items as $item)
                        <tr>
                            <td class="px-6 py-4 font-semibold text-slate-850 dark:text-white">
                                {{ $item->description }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                {{ config('system.site_currency_symbol', '$') }}{{ number_format($item->unit_price, 2) }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                {{ number_format($item->qty, 1) }}
                            </td>
                            <td class="px-6 py-4 text-right font-bold text-slate-850 dark:text-white">
                                {{ config('system.site_currency_symbol', '$') }}{{ number_format($item->total, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Summary Totals -->
        <div class="flex flex-col items-end text-xs space-y-2 border-b border-slate-100 dark:border-slate-850 pb-6 mb-6">
            <div class="flex justify-between w-64">
                <span class="text-slate-400">Subtotal:</span>
                <span class="font-bold text-slate-800 dark:text-slate-200">{{ config('system.site_currency_symbol', '$') }}{{ number_format($invoice->subtotal, 2) }}</span>
            </div>
            @if($invoice->tax_amount > 0)
                <div class="flex justify-between w-64">
                    <span class="text-slate-400">Tax ({{ $invoice->tax_rate }}%):</span>
                    <span class="font-bold text-slate-800 dark:text-slate-200">{{ config('system.site_currency_symbol', '$') }}{{ number_format($invoice->tax_amount, 2) }}</span>
                </div>
            @endif
            @if($invoice->discount > 0)
                <div class="flex justify-between w-64">
                    <span class="text-slate-400">Discount Applied:</span>
                    <span class="font-bold text-red-500">-{{ config('system.site_currency_symbol', '$') }}{{ number_format($invoice->discount, 2) }}</span>
                </div>
            @endif
            <div class="flex justify-between w-64 pt-2 border-t border-slate-100 dark:border-slate-850 text-sm">
                <span class="font-bold text-primary dark:text-white">Total Balance:</span>
                <span class="font-extrabold text-primary dark:text-white text-base">{{ config('system.site_currency_symbol', '$') }}{{ number_format($invoice->total, 2) }}</span>
            </div>
        </div>

        <!-- Note / Wire Details -->
        @if($invoice->notes)
            <div class="bg-slate-50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-800/60 p-4 rounded-2xl text-xs text-slate-500 dark:text-slate-400">
                <h4 class="font-bold text-slate-700 dark:text-slate-350 uppercase tracking-wider text-[10px] mb-1">Terms & Payment Instructions</h4>
                <p class="leading-relaxed">{{ $invoice->notes }}</p>
            </div>
        @endif
    </div>
</div>
