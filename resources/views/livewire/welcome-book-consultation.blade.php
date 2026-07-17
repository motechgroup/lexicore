<div>
    <!-- Success Banner (Always Visible if Session Status Exists) -->
    @if (session()->has('status'))
        <div class="fixed top-24 right-6 z-50 p-4 max-w-sm bg-slate-900 text-white rounded-2xl shadow-2xl border border-white/10 flex items-center gap-3 animate-in fade-in slide-in-from-top-4 duration-300" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)">
            <span class="material-symbols-outlined text-emerald-400">check_circle</span>
            <div class="text-xs">
                <p class="font-bold">Consultation Requested</p>
                <p class="opacity-80 mt-0.5">{{ session('status') }}</p>
            </div>
            <button @click="show = false" class="text-white/40 hover:text-white ml-auto">
                <span class="material-symbols-outlined text-sm">close</span>
            </button>
        </div>
    @endif

    <!-- Consultation Modal Backdrop -->
    @if($isOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-md transition-all">
            <!-- Modal Box -->
            <div class="w-full max-w-lg bg-[#031635] text-white rounded-3xl border border-white/10 p-8 shadow-2xl space-y-6 animate-in fade-in zoom-in-95 duration-200">
                <div class="flex justify-between items-center pb-4 border-b border-white/5">
                    <div>
                        <h3 class="text-xl font-bold font-display-lg text-secondary">Book Consultation</h3>
                        <p class="text-[11px] text-white/60 mt-0.5">Schedule a confidential case review with our partners.</p>
                    </div>
                    <button wire:click="closeModal" class="text-white/40 hover:text-white transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <form wire:submit="submit" class="space-y-4">
                    <!-- Name & Email -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="bookingName" class="block text-[10px] font-bold uppercase tracking-wider text-white/50 mb-1.5">Full Name</label>
                            <input wire:model="name" id="bookingName" type="text" placeholder="John Doe" 
                                   class="block w-full px-4 py-2.5 text-xs bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent transition-all text-white placeholder-white/20" />
                            <x-input-error :messages="$errors->get('name')" class="mt-1 text-red-400 text-[10px]" />
                        </div>
                        <div>
                            <label for="bookingEmail" class="block text-[10px] font-bold uppercase tracking-wider text-white/50 mb-1.5">Email Address</label>
                            <input wire:model="email" id="bookingEmail" type="email" placeholder="john@example.com" 
                                   class="block w-full px-4 py-2.5 text-xs bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent transition-all text-white placeholder-white/20" />
                            <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-400 text-[10px]" />
                        </div>
                    </div>

                    <!-- Phone & Preferred Date -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="bookingPhone" class="block text-[10px] font-bold uppercase tracking-wider text-white/50 mb-1.5">Phone Number</label>
                            <input wire:model="phone" id="bookingPhone" type="text" placeholder="+1 (555) 000-0000" 
                                   class="block w-full px-4 py-2.5 text-xs bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent transition-all text-white placeholder-white/20" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-1 text-red-400 text-[10px]" />
                        </div>
                        <div>
                            <label for="bookingDate" class="block text-[10px] font-bold uppercase tracking-wider text-white/50 mb-1.5">Preferred Date & Time</label>
                            <input wire:model="appointment_date" id="bookingDate" type="datetime-local" 
                                   class="block w-full px-4 py-2.5 text-xs bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent transition-all text-white [color-scheme:dark]" />
                            <x-input-error :messages="$errors->get('appointment_date')" class="mt-1 text-red-400 text-[10px]" />
                        </div>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="bookingNotes" class="block text-[10px] font-bold uppercase tracking-wider text-white/50 mb-1.5">Brief Matter Summary</label>
                        <textarea wire:model="notes" id="bookingNotes" rows="3" placeholder="Describe the legal assistance or service required..." 
                                  class="block w-full px-4 py-2.5 text-xs bg-white/5 border border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent transition-all text-white placeholder-white/20"></textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-1 text-red-400 text-[10px]" />
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-3 pt-4 border-t border-white/5">
                        <button type="button" wire:click="closeModal" 
                                class="px-5 py-2.5 bg-white/5 hover:bg-white/10 text-white font-semibold text-xs rounded-xl transition-all">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-5 py-2.5 bg-secondary text-primary hover:opacity-90 font-bold text-xs rounded-xl transition-all shadow-lg flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px]">calendar_month</span>
                            Submit Consultation Request
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
