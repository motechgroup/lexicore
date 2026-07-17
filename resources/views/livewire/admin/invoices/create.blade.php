<div>
    <!-- Back & Title -->
    <div class="mb-8">
        <a href="{{ route('admin.invoices.index') }}" class="inline-flex items-center gap-1.5 text-xs text-slate-500 hover:text-primary dark:hover:text-blue-400 font-semibold mb-3">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            Back to Billing Ledger
        </a>
        <h1 class="font-display-lg text-3xl text-primary dark:text-white mb-1 font-bold">Generate Retainer Invoice</h1>
        <p class="text-slate-500 dark:text-slate-400 text-sm">Issue fee statements, billable hours, and retainer requests.</p>
    </div>

    <!-- Form Container -->
    <form wire:submit="save" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Panel: Invoicing Details & Line Items -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Client & Matter selection -->
            <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-6 shadow-sm space-y-4">
                <h3 class="font-bold text-xs text-slate-500 uppercase tracking-wider">Statement Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="client_id" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">Client</label>
                        <select wire:model.live="client_id" id="client_id"
                                class="block w-full px-3 py-2.5 text-sm bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250">
                            <option value="">Select Client...</option>
                            @foreach($clients as $c)
                                <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->email }})</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('client_id')" class="mt-1" />
                    </div>
                    <div>
                        <label for="matter_id" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">Linked Matter</label>
                        <select wire:model="matter_id" id="matter_id"
                                class="block w-full px-3 py-2.5 text-sm bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250"
                                @disabled(empty($client_id))>
                            <option value="">Select Case Reference...</option>
                            @foreach($matters as $m)
                                <option value="{{ $m->id }}">{{ $m->title }} (#{{ $m->case_number }})</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('matter_id')" class="mt-1" />
                    </div>
                </div>
            </div>

            <!-- Dynamic Line-Items Box -->
            <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-6 shadow-sm space-y-4">
                <div class="flex justify-between items-center pb-3 border-b border-slate-100 dark:border-slate-800">
                    <h3 class="font-bold text-xs text-slate-500 uppercase tracking-wider">Billable Items</h3>
                    <button type="button" wire:click="addItem" class="text-xs text-primary dark:text-blue-400 font-bold hover:underline flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">add</span>
                        Add Row
                    </button>
                </div>

                <div class="space-y-3">
                    @foreach($items as $index => $item)
                        <div class="flex flex-col md:flex-row gap-3 items-start border-b border-slate-50 dark:border-slate-800/60 pb-3 md:pb-0 md:border-b-0">
                            <!-- Description -->
                            <div class="flex-1 w-full">
                                <label class="font-semibold text-[9px] text-slate-400 block mb-1 uppercase tracking-wider">Description</label>
                                <input wire:model="items.{{ $index }}.description" type="text" placeholder="e.g. Legal Retainer Fees"
                                       class="block w-full px-3 py-2 text-xs border border-slate-200 dark:border-slate-800 dark:bg-slate-900/60 rounded-xl focus:outline-none text-slate-800 dark:text-slate-200" />
                                <x-input-error :messages="$errors->get('items.' . $index . '.description')" class="mt-1" />
                            </div>
                            <!-- Hourly Rate -->
                            <div class="w-full md:w-32">
                                <label class="font-semibold text-[9px] text-slate-400 block mb-1 uppercase tracking-wider">Hourly Rate ($)</label>
                                <input wire:model.live="items.{{ $index }}.unit_price" type="number" step="0.01"
                                       class="block w-full px-3 py-2 text-xs border border-slate-200 dark:border-slate-800 dark:bg-slate-900/60 rounded-xl focus:outline-none text-slate-800 dark:text-slate-200" />
                                <x-input-error :messages="$errors->get('items.' . $index . '.unit_price')" class="mt-1" />
                            </div>
                            <!-- Quantity -->
                            <div class="w-full md:w-24">
                                <label class="font-semibold text-[9px] text-slate-400 block mb-1 uppercase tracking-wider">Hours / Qty</label>
                                <input wire:model.live="items.{{ $index }}.qty" type="number" step="0.1"
                                       class="block w-full px-3 py-2 text-xs border border-slate-200 dark:border-slate-800 dark:bg-slate-900/60 rounded-xl focus:outline-none text-slate-800 dark:text-slate-200" />
                                <x-input-error :messages="$errors->get('items.' . $index . '.qty')" class="mt-1" />
                            </div>
                            <!-- Remove Button -->
                            <div class="md:pt-5 shrink-0 self-end md:self-auto">
                                @if(count($items) > 1)
                                    <button type="button" wire:click="removeItem({{ $index }})" class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-950/20 rounded-lg transition-colors">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right Panel: Configurations & Calculations -->
        <div class="space-y-6">
            <!-- Details & Terms -->
            <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-6 shadow-sm space-y-4">
                <h3 class="font-bold text-xs text-slate-500 uppercase tracking-wider">Invoice Terms</h3>
                
                <div>
                    <label for="invoice_number" class="font-semibold text-xs text-slate-500 block mb-1 uppercase tracking-wider text-[10px]">Invoice Number</label>
                    <input wire:model="invoice_number" id="invoice_number" type="text"
                           class="block w-full px-3 py-2 text-xs bg-slate-50 border border-slate-200 dark:border-slate-800 dark:bg-slate-900/40 rounded-xl text-slate-500 font-mono" readonly />
                    <x-input-error :messages="$errors->get('invoice_number')" class="mt-1" />
                </div>

                <div>
                    <label for="due_date" class="font-semibold text-xs text-slate-500 block mb-1 uppercase tracking-wider text-[10px]">Payment Due Date</label>
                    <input wire:model="due_date" id="due_date" type="date"
                           class="block w-full px-3 py-2 text-xs border border-slate-200 dark:border-slate-800 dark:bg-slate-900/60 rounded-xl focus:outline-none text-slate-850 dark:text-slate-250" />
                    <x-input-error :messages="$errors->get('due_date')" class="mt-1" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="tax_rate" class="font-semibold text-xs text-slate-500 block mb-1 uppercase tracking-wider text-[10px]">Tax Rate (%)</label>
                        <input wire:model.live="tax_rate" id="tax_rate" type="number" step="0.1"
                               class="block w-full px-3 py-2 text-xs border border-slate-200 dark:border-slate-800 dark:bg-slate-900/60 rounded-xl focus:outline-none text-slate-800 dark:text-slate-200" />
                        <x-input-error :messages="$errors->get('tax_rate')" class="mt-1" />
                    </div>
                    <div>
                        <label for="discount" class="font-semibold text-xs text-slate-500 block mb-1 uppercase tracking-wider text-[10px]">Discount ($)</label>
                        <input wire:model.live="discount" id="discount" type="number" step="0.01"
                               class="block w-full px-3 py-2 text-xs border border-slate-200 dark:border-slate-800 dark:bg-slate-900/60 rounded-xl focus:outline-none text-slate-800 dark:text-slate-200" />
                        <x-input-error :messages="$errors->get('discount')" class="mt-1" />
                    </div>
                </div>

                <div>
                    <label for="notes" class="font-semibold text-xs text-slate-500 block mb-1 uppercase tracking-wider text-[10px]">Notes & Wire Terms</label>
                    <textarea wire:model="notes" id="notes" rows="4" placeholder="Input specific wire routing or payment schedules..."
                              class="block w-full px-3 py-2 text-xs border border-slate-200 dark:border-slate-800 dark:bg-slate-900/60 rounded-xl focus:outline-none text-slate-850 dark:text-slate-250"></textarea>
                    <x-input-error :messages="$errors->get('notes')" class="mt-1" />
                </div>
            </div>

            <!-- Interactive Totals Summary Card -->
            <div class="bg-slate-50 dark:bg-slate-800/40 rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-5 shadow-sm space-y-3">
                <h4 class="font-bold text-[10px] text-slate-400 uppercase tracking-wider">Interactive Statement Calculations</h4>
                <div class="space-y-2 text-xs">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Subtotal:</span>
                        <span class="font-bold text-slate-700 dark:text-slate-300">${{ number_format($this->subtotal, 2) }}</span>
                    </div>
                    @if($this->tax_amount > 0)
                        <div class="flex justify-between">
                            <span class="text-slate-500">Tax ({{ $tax_rate }}%):</span>
                            <span class="font-bold text-slate-700 dark:text-slate-300">${{ number_format($this->tax_amount, 2) }}</span>
                        </div>
                    @endif
                    @if($discount > 0)
                        <div class="flex justify-between">
                            <span class="text-slate-500">Discount:</span>
                            <span class="font-bold text-red-500">-${{ number_format($discount, 2) }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between pt-2 border-t border-slate-250 dark:border-slate-700 text-sm">
                        <span class="font-bold text-primary dark:text-white">Total:</span>
                        <span class="font-extrabold text-primary dark:text-white text-base">${{ number_format($this->total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="lg:col-span-3 flex justify-end gap-3 pt-4 border-t border-slate-200/80 dark:border-slate-800/80">
            <a href="{{ route('admin.invoices.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700/80 text-slate-700 dark:text-slate-300 font-semibold text-xs rounded-xl transition-all">
                Cancel
            </a>
            <button type="submit" class="px-5 py-2.5 bg-primary text-white hover:opacity-90 font-semibold text-xs rounded-xl transition-all shadow-md shadow-indigo-900/10">
                Generate Invoice
            </button>
        </div>

    </form>
</div>
