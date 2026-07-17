<div>
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="font-display-lg text-3xl text-primary dark:text-white mb-1 font-bold">Calendar & Appointments</h1>
        <p class="text-slate-500 dark:text-slate-400 text-sm">Schedule client interviews, attorney consultations, and manage upcoming dockets.</p>
    </div>

    <!-- Alert Notifications -->
    @if (session()->has('status'))
        <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-250 dark:border-emerald-900 text-emerald-850 dark:text-emerald-450 text-xs rounded-xl flex items-center gap-2">
            <span class="material-symbols-outlined text-[20px]">check_circle</span>
            {{ session('status') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Side: Schedule Form -->
        <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-6 shadow-sm h-fit space-y-4">
            <h3 class="font-bold text-xs text-slate-500 uppercase tracking-wider">Book Consultation</h3>
            
            <form wire:submit="schedule" class="space-y-4">
                <div>
                    <label for="client_id" class="font-semibold text-xs text-slate-500 block mb-1 uppercase tracking-wider text-[10px]">Client</label>
                    <select wire:model="client_id" id="client_id"
                            class="block w-full px-3 py-2 text-xs bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary text-slate-850 dark:text-slate-250">
                        <option value="">Select Client...</option>
                        @foreach($clients as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('client_id')" class="mt-1" />
                </div>

                <div>
                    <label for="attorney_id" class="font-semibold text-xs text-slate-500 block mb-1 uppercase tracking-wider text-[10px]">Assigned Counselor</label>
                    <select wire:model="attorney_id" id="attorney_id"
                            class="block w-full px-3 py-2 text-xs bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary text-slate-850 dark:text-slate-250">
                        <option value="">Select Attorney...</option>
                        @foreach($attorneys as $at)
                            <option value="{{ $at->id }}">{{ $at->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('attorney_id')" class="mt-1" />
                </div>

                <div>
                    <label for="scheduled_at" class="font-semibold text-xs text-slate-500 block mb-1 uppercase tracking-wider text-[10px]">Scheduled Date & Time</label>
                    <input wire:model="scheduled_at" id="scheduled_at" type="datetime-local"
                           class="block w-full px-3 py-2 text-xs bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary text-slate-800 dark:text-slate-200" />
                    <x-input-error :messages="$errors->get('scheduled_at')" class="mt-1" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="duration_minutes" class="font-semibold text-xs text-slate-500 block mb-1 uppercase tracking-wider text-[10px]">Duration (Min)</label>
                        <input wire:model="duration_minutes" id="duration_minutes" type="number" step="15"
                               class="block w-full px-3 py-2 text-xs bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none text-slate-800 dark:text-slate-200" />
                        <x-input-error :messages="$errors->get('duration_minutes')" class="mt-1" />
                    </div>
                    <div>
                        <label for="status" class="font-semibold text-xs text-slate-500 block mb-1 uppercase tracking-wider text-[10px]">Status</label>
                        <select wire:model="status" id="status"
                                class="block w-full px-3 py-2 text-xs bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none text-slate-800 dark:text-slate-200">
                            <option value="scheduled">Scheduled</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-1" />
                    </div>
                </div>

                <div>
                    <label for="notes" class="font-semibold text-xs text-slate-500 block mb-1 uppercase tracking-wider text-[10px]">Agenda / Purpose</label>
                    <textarea wire:model="notes" id="notes" rows="3" placeholder="Case overview, settlement negotiation..."
                              class="block w-full px-3 py-2 text-xs border border-slate-200 dark:border-slate-800 dark:bg-slate-900/60 rounded-xl focus:outline-none text-slate-850 dark:text-slate-250"></textarea>
                    <x-input-error :messages="$errors->get('notes')" class="mt-1" />
                </div>

                <button type="submit" class="w-full py-2.5 bg-primary text-white font-semibold text-xs rounded-xl hover:opacity-90 transition-all flex items-center justify-center gap-1.5 shadow-md shadow-indigo-900/10">
                    <span class="material-symbols-outlined text-[16px]">calendar_today</span>
                    Add Appointment
                </button>
            </form>
        </div>

        <!-- Right Side: Appointments List -->
        <div class="lg:col-span-2 bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-6 shadow-sm space-y-5">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <h3 class="font-bold text-xs text-slate-500 uppercase tracking-wider">Scheduled Consultation Dockets</h3>
                <!-- Search -->
                <div class="relative w-full sm:w-64">
                    <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search by name..." 
                           class="pl-8 pr-3 py-1.5 w-full text-[11px] rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/60 focus:bg-white focus:outline-none focus:ring-1 focus:ring-primary/20 text-slate-800 dark:text-slate-200">
                </div>
            </div>

            @if($appointments->isEmpty())
                <p class="text-xs text-slate-400 text-center py-12">No appointments scheduled.</p>
            @else
                <div class="space-y-4 max-h-[500px] overflow-y-auto pr-1">
                    @foreach($appointments as $app)
                        <div class="flex gap-4 p-4 border border-slate-100 dark:border-slate-800/80 rounded-2xl hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                            <div class="w-12 h-12 rounded-xl bg-primary/5 dark:bg-blue-950/40 text-primary dark:text-blue-450 flex flex-col items-center justify-center shrink-0">
                                <span class="text-[10px] font-bold uppercase tracking-wider">{{ $app->scheduled_at->format('M') }}</span>
                                <span class="text-base font-extrabold -mt-1">{{ $app->scheduled_at->format('d') }}</span>
                            </div>
                            <div class="min-w-0 flex-1 text-xs">
                                <div class="flex items-center justify-between gap-4 mb-1">
                                    <h4 class="font-bold text-slate-850 dark:text-white truncate">Client: {{ $app->client ? $app->client->name : $app->name }}</h4>
                                    <div class="flex items-center gap-2">
                                        <span class="px-2 py-0.5 rounded-full text-[8px] font-bold uppercase tracking-wider
                                            {{ $app->status === 'completed' ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-950/30' : '' }}
                                            {{ $app->status === 'cancelled' ? 'bg-slate-100 text-slate-500 dark:bg-slate-800' : '' }}
                                            {{ $app->status === 'scheduled' ? 'bg-blue-50 text-blue-600 dark:bg-blue-950/30' : '' }}
                                        ">
                                            {{ $app->status }}
                                        </span>
                                        <button wire:click="editAppointment({{ $app->id }})" class="text-slate-400 hover:text-primary dark:hover:text-blue-400 transition-colors flex" title="Manage Consultation">
                                            <span class="material-symbols-outlined text-[16px]">edit</span>
                                        </button>
                                    </div>
                                </div>
                                <p class="text-[10px] font-semibold text-slate-450 dark:text-slate-400 uppercase tracking-wider mb-2">
                                    Attorney: {{ $app->attorney ? $app->attorney->name : 'Pending Assignment' }} &bull; Time: {{ $app->scheduled_at->format('g:i A') }} ({{ $app->duration_minutes }} Mins)
                                </p>
                                @if($app->notes)
                                    <p class="text-slate-500 dark:text-slate-450 leading-relaxed border-t border-slate-50 dark:border-slate-800/60 pt-2">{{ $app->notes }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6">
                    {{ $appointments->links() }}
                </div>
            @endif
        </div>

    </div>

    <!-- Edit/Manage Appointment Modal -->
    @if($showEditModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/40 backdrop-blur-sm transition-all" wire:key="edit-appointment-modal">
            <div class="w-full max-w-lg bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-6 shadow-2xl space-y-5 animate-in fade-in zoom-in-95 duration-200">
                <div class="flex justify-between items-center pb-3 border-b border-slate-100 dark:border-slate-800">
                    <h3 class="text-base font-bold text-slate-800 dark:text-white flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-primary text-[20px]">calendar_month</span>
                        Manage Consultation Details
                    </h3>
                    <button wire:click="$set('showEditModal', false)" class="text-slate-400 hover:text-slate-600 dark:hover:text-white transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <form wire:submit="saveAppointment" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Client -->
                        <div>
                            <label for="editClientId" class="font-semibold text-xs text-slate-500 block mb-1 uppercase tracking-wider text-[10px]">Client / Guest</label>
                            <select wire:model="editClientId" id="editClientId"
                                    class="block w-full px-3 py-2 text-xs bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary text-slate-850 dark:text-slate-250">
                                <option value="">External / Guest Client</option>
                                @foreach($clients as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('editClientId')" class="mt-1" />
                        </div>
                        <!-- Attorney -->
                        <div>
                            <label for="editAttorneyId" class="font-semibold text-xs text-slate-500 block mb-1 uppercase tracking-wider text-[10px]">Assigned Attorney</label>
                            <select wire:model="editAttorneyId" id="editAttorneyId"
                                    class="block w-full px-3 py-2 text-xs bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary text-slate-850 dark:text-slate-250">
                                <option value="">Unassigned (Pending)</option>
                                @foreach($attorneys as $at)
                                    <option value="{{ $at->id }}">{{ $at->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('editAttorneyId')" class="mt-1" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Date -->
                        <div>
                            <label for="editScheduledAt" class="font-semibold text-xs text-slate-500 block mb-1 uppercase tracking-wider text-[10px]">Scheduled Date & Time</label>
                            <input wire:model="editScheduledAt" id="editScheduledAt" type="datetime-local"
                                   class="block w-full px-3 py-2 text-xs bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary text-slate-800 dark:text-slate-200" />
                            <x-input-error :messages="$errors->get('editScheduledAt')" class="mt-1" />
                        </div>
                        <!-- Status -->
                        <div>
                            <label for="editStatus" class="font-semibold text-xs text-slate-500 block mb-1 uppercase tracking-wider text-[10px]">Status</label>
                            <select wire:model="editStatus" id="editStatus"
                                    class="block w-full px-3 py-2 text-xs bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none text-slate-800 dark:text-slate-200">
                                <option value="pending">Pending</option>
                                <option value="scheduled">Scheduled</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                            <x-input-error :messages="$errors->get('editStatus')" class="mt-1" />
                        </div>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="editNotes" class="font-semibold text-xs text-slate-500 block mb-1 uppercase tracking-wider text-[10px]">Consultation Agenda / Purpose</label>
                        <textarea wire:model="editNotes" id="editNotes" rows="4" placeholder="Agenda notes..."
                                  class="block w-full px-3.5 py-2 text-xs bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250"></textarea>
                        <x-input-error :messages="$errors->get('editNotes')" class="mt-1" />
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                        <button type="button" wire:click="$set('showEditModal', false)" class="px-4 py-2 bg-slate-100 hover:bg-slate-200/80 dark:bg-slate-800 dark:hover:bg-slate-700/85 text-slate-700 dark:text-slate-300 font-semibold text-xs rounded-xl transition-all">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-primary text-white hover:opacity-90 font-semibold text-xs rounded-xl transition-all shadow-md shadow-indigo-900/10 flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px]">save</span>
                            Save Consultation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
