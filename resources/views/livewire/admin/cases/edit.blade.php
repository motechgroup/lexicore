<div>
    <!-- Back to Cases & Title -->
    <div class="mb-8">
        <a href="{{ route('admin.cases.index') }}" class="inline-flex items-center gap-1.5 text-xs text-slate-500 hover:text-primary dark:hover:text-blue-400 font-semibold mb-3">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            Back to Case Files
        </a>
        <h1 class="font-display-lg text-3xl text-primary dark:text-white mb-1 font-bold">Edit Legal Matter</h1>
        <p class="text-slate-500 dark:text-slate-400 text-sm">Modify information and update phases for case file #{{ $matter->case_number }}.</p>
    </div>

    <!-- Form Container -->
    <form wire:submit="save" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left 2 Columns: Primary Details -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-6 shadow-sm space-y-5">
                <h3 class="font-display-lg text-lg text-slate-800 dark:text-white font-bold border-b border-slate-100 dark:border-slate-800/60 pb-3">Primary Information</h3>

                <!-- Title & Case Number -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div class="md:col-span-2">
                        <label for="title" class="font-semibold text-xs text-slate-500 uppercase tracking-wider mb-1.5 block">Matter / Case Title</label>
                        <input wire:model="title" id="title" type="text"
                               class="block w-full px-4 py-2.5 text-sm bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                        <x-input-error :messages="$errors->get('title')" class="mt-1" />
                    </div>
                    <div>
                        <label for="case_number" class="font-semibold text-xs text-slate-500 uppercase tracking-wider mb-1.5 block">Case Number</label>
                        <input wire:model="case_number" id="case_number" type="text"
                               class="block w-full px-4 py-2.5 text-sm bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250 font-mono" />
                        <x-input-error :messages="$errors->get('case_number')" class="mt-1" />
                    </div>
                </div>

                <!-- Client Select & Practice Area -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label for="client_id" class="font-semibold text-xs text-slate-500 uppercase tracking-wider mb-1.5 block">Client</label>
                        <select wire:model="client_id" id="client_id"
                                class="block w-full px-3 py-2.5 text-sm bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250">
                            <option value="">Select Client...</option>
                            @foreach($clients as $c)
                                <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->email }})</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('client_id')" class="mt-1" />
                    </div>
                    <div>
                        <label for="practice_area_id" class="font-semibold text-xs text-slate-500 uppercase tracking-wider mb-1.5 block">Practice Area</label>
                        <select wire:model="practice_area_id" id="practice_area_id"
                                class="block w-full px-3 py-2.5 text-sm bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250">
                            <option value="">Select Specialty...</option>
                            @foreach($practiceAreas as $pa)
                                <option value="{{ $pa->id }}">{{ $pa->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('practice_area_id')" class="mt-1" />
                    </div>
                    <div>
                        <label for="lead_attorney_id" class="font-semibold text-xs text-slate-500 uppercase tracking-wider mb-1.5 block">Lead Attorney</label>
                        <select wire:model="lead_attorney_id" id="lead_attorney_id"
                                class="block w-full px-3 py-2.5 text-sm bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250">
                            <option value="">Select Counsel...</option>
                            @foreach($attorneys as $at)
                                <option value="{{ $at->id }}">{{ $at->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('lead_attorney_id')" class="mt-1" />
                    </div>
                </div>

                <!-- Description / Case Details -->
                <div>
                    <label for="description" class="font-semibold text-xs text-slate-500 uppercase tracking-wider mb-1.5 block">Description / Notes</label>
                    <textarea wire:model="description" id="description" rows="5"
                              class="block w-full px-4 py-2.5 text-sm bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250"></textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-1" />
                </div>
            </div>
        </div>

        <!-- Right 1 Column: Case Meta, Court & Opposing Details -->
        <div class="space-y-6">
            <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-6 shadow-sm space-y-5">
                <h3 class="font-display-lg text-lg text-slate-800 dark:text-white font-bold border-b border-slate-100 dark:border-slate-800/60 pb-3">Jurisdiction & Status</h3>

                <!-- Status & Priority -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="status" class="font-semibold text-xs text-slate-500 uppercase tracking-wider mb-1.5 block">Case Status</label>
                        <select wire:model="status" id="status"
                                class="block w-full px-3 py-2 text-xs bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250">
                            <option value="Intake">Intake</option>
                            <option value="Discovery">Discovery</option>
                            <option value="Mediation">Mediation</option>
                            <option value="Trial">Trial</option>
                            <option value="Closed">Closed</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-1" />
                    </div>
                    <div>
                        <label for="priority" class="font-semibold text-xs text-slate-500 uppercase tracking-wider mb-1.5 block">Priority</label>
                        <select wire:model="priority" id="priority"
                                class="block w-full px-3 py-2 text-xs bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250">
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                            <option value="critical">Critical</option>
                        </select>
                        <x-input-error :messages="$errors->get('priority')" class="mt-1" />
                    </div>
                </div>

                <!-- Open Date & Claim Value -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="start_date" class="font-semibold text-xs text-slate-500 uppercase tracking-wider mb-1.5 block">Commenced Date</label>
                        <input wire:model="start_date" id="start_date" type="date"
                               class="block w-full px-3 py-2 text-xs bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                        <x-input-error :messages="$errors->get('start_date')" class="mt-1" />
                    </div>
                    <div>
                        <label for="case_value" class="font-semibold text-xs text-slate-500 uppercase tracking-wider mb-1.5 block">Case Value ($)</label>
                        <input wire:model="case_value" id="case_value" type="number" step="0.01"
                               class="block w-full px-3 py-2 text-xs bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                        <x-input-error :messages="$errors->get('case_value')" class="mt-1" />
                    </div>
                </div>

                <!-- Court Room & Judge -->
                <div>
                    <label for="court" class="font-semibold text-xs text-slate-500 uppercase tracking-wider mb-1.5 block">Court Venue</label>
                    <input wire:model="court" id="court" type="text"
                           class="block w-full px-4 py-2.5 text-xs bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                    <x-input-error :messages="$errors->get('court')" class="mt-1" />
                </div>
                <div>
                    <label for="judge" class="font-semibold text-xs text-slate-500 uppercase tracking-wider mb-1.5 block">Presiding Judge</label>
                    <input wire:model="judge" id="judge" type="text"
                           class="block w-full px-4 py-2.5 text-xs bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                    <x-input-error :messages="$errors->get('judge')" class="mt-1" />
                </div>

                <!-- Opposing Party & opposing Counsel -->
                <div class="border-t border-slate-100 dark:border-slate-800/60 pt-4 space-y-4">
                    <h4 class="font-bold text-xs text-slate-700 dark:text-slate-350">Opposing Litigation Counsel</h4>
                    <div>
                        <label for="opposing_party" class="font-semibold text-xs text-slate-500 uppercase tracking-wider mb-1.5 block">Opposing Defendant/Plaintiff</label>
                        <input wire:model="opposing_party" id="opposing_party" type="text"
                               class="block w-full px-4 py-2.5 text-xs bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                        <x-input-error :messages="$errors->get('opposing_party')" class="mt-1" />
                    </div>
                    <div>
                        <label for="opposing_counsel" class="font-semibold text-xs text-slate-500 uppercase tracking-wider mb-1.5 block">Opposing Counsel Name</label>
                        <input wire:model="opposing_counsel" id="opposing_counsel" type="text"
                               class="block w-full px-4 py-2.5 text-xs bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                        <x-input-error :messages="$errors->get('opposing_counsel')" class="mt-1" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button block -->
        <div class="lg:col-span-3 flex justify-end gap-3 pt-4 border-t border-slate-200/80 dark:border-slate-800/80">
            <a href="{{ route('admin.cases.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700/80 text-slate-700 dark:text-slate-300 font-semibold text-xs rounded-xl transition-all">
                Cancel
            </a>
            <button type="submit" class="px-5 py-2.5 bg-primary text-white hover:opacity-90 font-semibold text-xs rounded-xl transition-all shadow-md shadow-indigo-900/10">
                Save Changes
            </button>
        </div>

    </form>
</div>
