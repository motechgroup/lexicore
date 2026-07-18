<div>
    <!-- Page Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-display-lg text-3xl text-primary dark:text-white mb-1 font-bold">Team Members & Counselors</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Manage roles, titles, credentials, and biographies of your legal staff.</p>
        </div>
        <button wire:click="openCreateModal" class="px-4 py-2.5 bg-primary hover:opacity-90 text-white rounded-xl text-xs font-bold transition-all flex items-center gap-2 self-start sm:self-auto">
            <span class="material-symbols-outlined text-[16px]">person_add</span>
            Add Staff Member
        </button>
    </div>

    <!-- Alert Notifications -->
    @if (session()->has('status'))
        <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-250 dark:border-emerald-900 text-emerald-850 dark:text-emerald-450 text-xs rounded-xl flex items-center gap-2">
            <span class="material-symbols-outlined text-[20px]">check_circle</span>
            {{ session('status') }}
        </div>
    @endif

    <!-- Filter & Search Controls Panel -->
    <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-5 shadow-sm mb-6 flex flex-col md:flex-row items-center justify-between gap-4">
        <!-- Search Input -->
        <div class="relative w-full md:w-80">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search team member name..." 
                   class="pl-9 pr-4 py-2.5 w-full text-xs rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/60 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250">
        </div>
    </div>

    <!-- List of Counselors in Table Form -->
    <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 shadow-sm overflow-hidden">
        @if($members->isEmpty())
            <div class="p-12 text-center">
                <span class="material-symbols-outlined text-slate-300 dark:text-slate-650 text-5xl mb-4" style="font-variation-settings: 'FILL' 0;">group</span>
                <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-2">No Counselors Found</h3>
                <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md mx-auto">No profiles match your search filters.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800 text-[10px] uppercase font-bold tracking-wider text-slate-400 dark:text-slate-500">
                            <th class="px-6 py-4">Name / Title</th>
                            <th class="px-6 py-4">System Role</th>
                            <th class="px-6 py-4">Experience</th>
                            <th class="px-6 py-4">Contact Email</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 text-xs text-slate-700 dark:text-slate-300">
                        @foreach($members as $m)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                                <!-- Name and Title -->
                                <td class="px-6 py-4 flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-500 to-indigo-500 flex items-center justify-center text-white font-bold text-sm shrink-0">
                                        {{ substr($m->name, 0, 2) }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-bold text-slate-850 dark:text-white truncate">{{ $m->name }}</div>
                                        <div class="text-[10px] text-amber-600 dark:text-amber-450 font-semibold mt-0.5">{{ $m->attorneyProfile->title ?? 'Legal Counsel' }}</div>
                                    </div>
                                </td>
                                <!-- Role Badge -->
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400">
                                        {{ $m->roles->first()->name ?? 'Staff' }}
                                    </span>
                                </td>
                                <!-- Experience -->
                                <td class="px-6 py-4 font-semibold text-slate-800 dark:text-slate-200">
                                    {{ $m->attorneyProfile->experience_years ?? 0 }} Years
                                </td>
                                <!-- Email -->
                                <td class="px-6 py-4 font-semibold text-primary dark:text-blue-400">
                                    {{ $m->email }}
                                </td>
                                <!-- Action -->
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button wire:click="editUser({{ $m->id }})" class="px-3 py-1.5 bg-slate-50 hover:bg-slate-100 dark:bg-slate-800 dark:hover:bg-slate-700/80 border border-slate-200/50 dark:border-slate-850 font-bold text-[10px] rounded-lg text-slate-700 dark:text-slate-300 transition-colors flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[14px]">edit</span>
                                            Manage
                                        </button>
                                        @if($m->id !== auth()->id())
                                            <button onclick="confirm('Are you sure you want to remove this team member? All their assigned matters will remain but will be unassigned.') || event.stopImmediatePropagation()" wire:click="deleteUser({{ $m->id }})" class="p-1.5 hover:text-rose-500 transition-all text-slate-400" title="Remove Member">
                                                <span class="material-symbols-outlined text-[18px]">delete</span>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination Controls -->
            <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800/80">
                {{ $members->links() }}
            </div>
        @endif
    </div>

    <!-- Edit Staff Modal (Alpine.js overlay backed by Livewire property control) -->
    @if($showEditModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/40 backdrop-blur-sm transition-all" wire:key="edit-staff-modal">
            <div class="w-full max-w-lg bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-6 shadow-2xl space-y-5 animate-in fade-in zoom-in-95 duration-200">
                <div class="flex justify-between items-center pb-3 border-b border-slate-100 dark:border-slate-800">
                    <h3 class="text-base font-bold text-slate-800 dark:text-white flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-primary text-[20px]">manage_accounts</span>
                        {{ $selectedUserId ? 'Manage Staff Profile' : 'Register New Staff Member' }}
                    </h3>
                    <button wire:click="$set('showEditModal', false)" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-250 transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <form wire:submit="saveUser" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Name -->
                        <div>
                            <label for="editName" class="font-semibold text-xs text-slate-500 block mb-1 uppercase tracking-wider text-[10px]">Name</label>
                            <input wire:model="editName" id="editName" type="text" 
                                   class="block w-full px-3.5 py-2 text-xs bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                            <x-input-error :messages="$errors->get('editName')" class="mt-1" />
                        </div>
                        <!-- Email -->
                        <div>
                            <label for="editEmail" class="font-semibold text-xs text-slate-500 block mb-1 uppercase tracking-wider text-[10px]">Email</label>
                            <input wire:model="editEmail" id="editEmail" type="email" 
                                   class="block w-full px-3.5 py-2 text-xs bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                            <x-input-error :messages="$errors->get('editEmail')" class="mt-1" />
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="editPassword" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">{{ $selectedUserId ? 'Password (Leave blank to keep current)' : 'Account Password' }}</label>
                        <input wire:model="editPassword" id="editPassword" type="password" placeholder="••••••••"
                               class="block w-full px-3.5 py-2 text-xs bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                        <x-input-error :messages="$errors->get('editPassword')" class="mt-1" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Role -->
                        <div>
                            <label for="editRole" class="font-semibold text-xs text-slate-500 block mb-1 uppercase tracking-wider text-[10px]">System Role</label>
                            <select wire:model="editRole" id="editRole" 
                                    class="block w-full px-2.5 py-2 text-xs bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250">
                                <option value="admin">Admin</option>
                                <option value="staff">Staff</option>
                            </select>
                            <x-input-error :messages="$errors->get('editRole')" class="mt-1" />
                        </div>
                        <!-- Title -->
                        <div class="md:col-span-2">
                            <label for="editTitle" class="font-semibold text-xs text-slate-500 block mb-1 uppercase tracking-wider text-[10px]">Professional Title</label>
                            <input wire:model="editTitle" id="editTitle" type="text" placeholder="e.g. Managing Partner, Senior Counsel"
                                   class="block w-full px-3.5 py-2 text-xs bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                            <x-input-error :messages="$errors->get('editTitle')" class="mt-1" />
                        </div>
                    </div>

                    <!-- Experience -->
                    <div>
                        <label for="editExperienceYears" class="font-semibold text-xs text-slate-500 block mb-1 uppercase tracking-wider text-[10px]">Years of Experience</label>
                        <input wire:model="editExperienceYears" id="editExperienceYears" type="number" 
                               class="block w-full px-3.5 py-2 text-xs bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                        <x-input-error :messages="$errors->get('editExperienceYears')" class="mt-1" />
                    </div>

                    <!-- Biography -->
                    <div>
                        <label for="editBio" class="font-semibold text-xs text-slate-500 block mb-1 uppercase tracking-wider text-[10px]">Staff Biography</label>
                        <textarea wire:model="editBio" id="editBio" rows="4" placeholder="Brief professional background summary..."
                                  class="block w-full px-3.5 py-2 text-xs bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250"></textarea>
                        <x-input-error :messages="$errors->get('editBio')" class="mt-1" />
                    </div>

                    <!-- Modal Actions -->
                    <div class="flex justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                        <button type="button" wire:click="$set('showEditModal', false)" class="px-4 py-2 bg-slate-100 hover:bg-slate-200/80 dark:bg-slate-800 dark:hover:bg-slate-700/85 text-slate-700 dark:text-slate-300 font-semibold text-xs rounded-xl transition-all">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-primary text-white hover:opacity-90 font-semibold text-xs rounded-xl transition-all shadow-md shadow-indigo-900/10 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px]">save</span>
                            Save Profile Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
