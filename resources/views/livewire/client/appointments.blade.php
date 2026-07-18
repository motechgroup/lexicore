<div>
    <!-- Page Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-display-lg text-3xl text-primary dark:text-white mb-1 font-bold">My Calendar & Consultations</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Schedule and manage legal appointments and consultations with your lead attorneys.</p>
        </div>
        <button wire:click="openBookingModal" class="px-4 py-2.5 bg-primary hover:opacity-90 text-white rounded-xl text-xs font-bold transition-all flex items-center gap-2 self-start sm:self-auto shadow-lg shadow-indigo-900/10">
            <span class="material-symbols-outlined text-[16px]">calendar_add_on</span>
            Book Consultation
        </button>
    </div>

    <!-- Alert Notifications -->
    @if (session()->has('status'))
        <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-250 dark:border-emerald-900 text-emerald-850 dark:text-emerald-450 text-xs rounded-xl flex items-center gap-2">
            <span class="material-symbols-outlined text-[20px]">check_circle</span>
            {{ session('status') }}
        </div>
    @endif

    <!-- Main Schedule Overview -->
    <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 shadow-sm overflow-hidden">
        @if($appointments->isEmpty())
            <div class="p-12 text-center">
                <span class="material-symbols-outlined text-slate-300 dark:text-slate-650 text-5xl mb-4" style="font-variation-settings: 'FILL' 0;">calendar_today</span>
                <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-2">No Scheduled Appointments</h3>
                <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md mx-auto">You do not have any consultations scheduled. Click the button above to request a booking.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800 text-[10px] uppercase font-bold tracking-wider text-slate-400 dark:text-slate-500">
                            <th class="px-6 py-4">Appointment Detail</th>
                            <th class="px-6 py-4">Assigned Counsel</th>
                            <th class="px-6 py-4">Meeting Type / Method</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 text-xs text-slate-700 dark:text-slate-300">
                        @foreach($appointments as $app)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                                <!-- Appointment Detail -->
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-850 dark:text-white mb-0.5">
                                        {{ $app->appointment_date ? $app->appointment_date->format('l, M d, Y') : 'N/A' }}
                                    </div>
                                    <div class="text-[10px] text-slate-400">
                                        Time: {{ $app->appointment_date ? $app->appointment_date->format('g:i A') : 'N/A' }}
                                    </div>
                                </td>
                                <!-- Assigned Counsel -->
                                <td class="px-6 py-4">
                                    @if($app->attorney)
                                        <div class="font-bold text-slate-800 dark:text-slate-200">{{ $app->attorney->name }}</div>
                                        <div class="text-[10px] text-slate-400">{{ $app->attorney->email }}</div>
                                    @else
                                        <span class="text-slate-400">Awaiting Assignment</span>
                                    @endif
                                </td>
                                <!-- Meeting Type -->
                                <td class="px-6 py-4 font-semibold text-slate-650 dark:text-slate-350">
                                    <span class="flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-[16px] text-primary">video_call</span>
                                        Google Meet / Video Conference
                                    </span>
                                </td>
                                <!-- Status Badge -->
                                <td class="px-6 py-4">
                                    @if($app->status === 'scheduled')
                                        <span class="px-2.5 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-600 dark:bg-emerald-950/40 dark:text-emerald-400 border border-emerald-250 dark:border-emerald-900/60">
                                            Confirmed
                                        </span>
                                    @elseif($app->status === 'pending')
                                        <span class="px-2.5 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider bg-amber-50 text-amber-600 dark:bg-amber-950/40 dark:text-amber-400 border border-amber-250 dark:border-amber-900/60">
                                            Pending
                                        </span>
                                    @elseif($app->status === 'completed')
                                        <span class="px-2.5 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider bg-blue-50 text-blue-600 dark:bg-blue-950/40 dark:text-blue-400 border border-blue-250 dark:border-blue-900/60">
                                            Completed
                                        </span>
                                    @else
                                        <span class="px-2.5 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-450 border border-slate-200 dark:border-slate-800/80">
                                            Cancelled
                                        </span>
                                    @endif
                                </td>
                                <!-- Notes -->
                                <td class="px-6 py-4 text-slate-500 max-w-xs truncate" title="{{ $app->notes }}">
                                    {{ $app->notes ?: 'No description provided.' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800/80">
                {{ $appointments->links() }}
            </div>
        @endif
    </div>

    <!-- Booking consultation Modal -->
    @if($showBookingModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/40 backdrop-blur-sm transition-all" wire:key="booking-modal">
            <div class="w-full max-w-md bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-6 shadow-2xl space-y-5 animate-in fade-in zoom-in-95 duration-200">
                <div class="flex justify-between items-center pb-3 border-b border-slate-100 dark:border-slate-800">
                    <h3 class="text-base font-bold text-slate-800 dark:text-white flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-primary text-[20px]">calendar_month</span>
                        Request Legal Consultation
                    </h3>
                    <button wire:click="$set('showBookingModal', false)" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-250 transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <form wire:submit="bookConsultation" class="space-y-4">
                    <!-- Date & Time -->
                    <div>
                        <label for="appointment_date" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">Preferred Date & Time</label>
                        <input wire:model="appointment_date" id="appointment_date" type="datetime-local"
                               class="block w-full px-3.5 py-2 text-xs bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                        <x-input-error :messages="$errors->get('appointment_date')" class="mt-1" />
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">Consultation Notes / Case Outline</label>
                        <textarea wire:model="notes" id="notes" rows="4" placeholder="Describe the matter you wish to consult on..."
                                  class="block w-full px-3.5 py-2 text-xs bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250"></textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-1" />
                    </div>

                    <!-- Modal Actions -->
                    <div class="flex justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                        <button type="button" wire:click="$set('showBookingModal', false)" class="px-4 py-2 bg-slate-100 hover:bg-slate-200/80 dark:bg-slate-800 dark:hover:bg-slate-700/85 text-slate-700 dark:text-slate-300 font-semibold text-xs rounded-xl transition-all">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-primary text-white hover:opacity-90 font-semibold text-xs rounded-xl transition-all shadow-md shadow-indigo-900/10 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px]">send</span>
                            Request Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
