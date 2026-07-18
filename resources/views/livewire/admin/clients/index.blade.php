<div>
    <!-- Page Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-display-lg text-3xl text-primary dark:text-white mb-1 font-bold">Client Directory (CRM)</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Manage client representation folders, case histories, and billing metrics.</p>
        </div>
        <button wire:click="openCreateModal" class="px-4 py-2.5 bg-primary hover:opacity-90 text-white rounded-xl text-xs font-bold transition-all flex items-center gap-2 self-start sm:self-auto">
            <span class="material-symbols-outlined text-[16px]">person_add</span>
            Add New Client
        </button>
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
                            <th class="px-6 py-4 text-right">Actions</th>
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
                                <!-- Actions -->
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button type="button" wire:click="openEditModal({{ $client->id }})" class="p-1 text-slate-400 hover:text-primary transition-all" title="Edit Client">
                                            <span class="material-symbols-outlined text-[18px]">edit</span>
                                        </button>
                                        <button type="button" onclick="confirm('Are you sure you want to delete this client? All their matters and invoices will remain but will be unassigned.') || event.stopImmediatePropagation()" wire:click="deleteClient({{ $client->id }})" class="p-1 text-slate-400 hover:text-rose-500 transition-all" title="Delete Client">
                                            <span class="material-symbols-outlined text-[18px]">delete</span>
                                        </button>
                                    </div>
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

    <!-- Add/Edit Client Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/40 backdrop-blur-sm transition-all" wire:key="client-modal">
            <div class="w-full max-w-md bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-6 shadow-2xl space-y-5 animate-in fade-in zoom-in-95 duration-200">
                <div class="flex justify-between items-center pb-3 border-b border-slate-100 dark:border-slate-800">
                    <h3 class="text-base font-bold text-slate-800 dark:text-white flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-primary text-[20px]">person_add</span>
                        {{ $clientId ? 'Edit Client Profile' : 'Add New Client Profile' }}
                    </h3>
                    <button wire:click="$set('showModal', false)" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-250 transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <form wire:submit="saveClient" class="space-y-4">
                    <!-- Name -->
                    <div>
                        <label for="name" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">Client Name</label>
                        <input wire:model="name" id="name" type="text" placeholder="e.g. John Doe"
                               class="block w-full px-3.5 py-2 text-xs bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">Email Address</label>
                        <input wire:model="email" id="email" type="email" placeholder="e.g. john@example.com"
                               class="block w-full px-3.5 py-2 text-xs bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">Phone Number</label>
                        <input wire:model="phone" id="phone" type="text" placeholder="e.g. +1 (555) 019-2834"
                               class="block w-full px-3.5 py-2 text-xs bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                        <x-input-error :messages="$errors->get('phone')" class="mt-1" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">{{ $clientId ? 'Password (Leave blank to keep current)' : 'Account Password' }}</label>
                        <input wire:model="password" id="password" type="password" placeholder="••••••••"
                               class="block w-full px-3.5 py-2 text-xs bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <!-- Modal Actions -->
                    <div class="flex justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                        <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2 bg-slate-100 hover:bg-slate-200/80 dark:bg-slate-800 dark:hover:bg-slate-700/85 text-slate-700 dark:text-slate-300 font-semibold text-xs rounded-xl transition-all">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-primary text-white hover:opacity-90 font-semibold text-xs rounded-xl transition-all shadow-md shadow-indigo-900/10 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px]">save</span>
                            {{ $clientId ? 'Save Changes' : 'Create Client' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
