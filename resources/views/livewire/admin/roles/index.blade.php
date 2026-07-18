<div>
    <!-- Page Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-display-lg text-3xl text-primary dark:text-white mb-1 font-bold">Access Roles & Permissions</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Define, configure, and assign access control parameters across the firm directory.</p>
        </div>
        <button wire:click="openCreateModal" class="px-4 py-2.5 bg-primary hover:opacity-90 text-white rounded-xl text-xs font-bold transition-all flex items-center gap-2 self-start sm:self-auto shadow-lg shadow-indigo-900/10">
            <span class="material-symbols-outlined text-[16px]">add_moderator</span>
            Create Custom Role
        </button>
    </div>

    <!-- Alert Notifications -->
    @if (session()->has('status'))
        <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-250 dark:border-emerald-900 text-emerald-850 dark:text-emerald-450 text-xs rounded-xl flex items-center gap-2">
            <span class="material-symbols-outlined text-[20px]">check_circle</span>
            {{ session('status') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="mb-6 p-4 bg-rose-50 dark:bg-rose-950/30 border border-rose-250 dark:border-rose-900 text-rose-850 dark:text-rose-455 text-xs rounded-xl flex items-center gap-2">
            <span class="material-symbols-outlined text-[20px]">warning</span>
            {{ session('error') }}
        </div>
    @endif

    <!-- Roles Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @foreach($roles as $role)
            <div class="bg-white dark:bg-[#1e293b] p-6 rounded-2xl shadow-sm border border-slate-200/80 dark:border-slate-800/80 flex flex-col justify-between hover:shadow-md transition-all duration-300">
                <div>
                    <!-- Badge and User Count -->
                    <div class="flex justify-between items-start mb-4">
                        <div class="px-3 py-1 bg-blue-50 dark:bg-blue-950/40 rounded-xl text-primary dark:text-blue-400 font-bold text-xs uppercase tracking-wide">
                            {{ $role->name }}
                        </div>
                        <span class="text-xs text-slate-400 font-medium">
                            {{ $role->users_count }} Assigned Users
                        </span>
                    </div>

                    <p class="text-xs text-slate-500 dark:text-slate-400 mb-6 leading-relaxed">
                        @if($role->name === 'admin')
                            Full administrative privileges. Access to firm settings, team lists, billing, system logs, and security controls.
                        @elseif($role->name === 'staff')
                            Legal staff privileges. Access to active cases, client notes, scheduler, documents, and calendar.
                        @elseif($role->name === 'client')
                            Client portal access. View matter summaries, billing details, upcoming hearings, and book consultations.
                        @else
                            Custom user access role with specialized permission boundaries.
                        @endif
                    </p>

                    <!-- Assigned Permissions -->
                    <div class="space-y-2 mb-6">
                        <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Permissions</h4>
                        <div class="flex flex-wrap gap-1.5 max-h-24 overflow-y-auto pr-1">
                            @forelse($role->permissions as $perm)
                                <span class="px-2 py-0.5 bg-slate-100 dark:bg-slate-800/60 rounded text-[10px] text-slate-600 dark:text-slate-450">
                                    {{ $perm->name }}
                                </span>
                            @empty
                                <span class="text-[10px] text-slate-400 italic">No specific permissions linked.</span>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Card Actions -->
                <div class="flex items-center justify-between border-t border-slate-100 dark:border-slate-800/80 pt-4 mt-2">
                    <span class="text-[10px] text-slate-400 uppercase tracking-wider font-mono">Guard: {{ $role->guard_name }}</span>
                    <div class="flex gap-2">
                        <button wire:click="openEditModal({{ $role->id }})" class="p-1.5 text-slate-400 hover:text-primary dark:hover:text-blue-400 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors" title="Edit Role">
                            <span class="material-symbols-outlined text-[18px]">edit</span>
                        </button>
                        @if(!in_array($role->name, ['admin', 'staff', 'client']))
                            <button onclick="confirm('Are you sure you want to delete this role?') || event.stopImmediatePropagation()" wire:click="deleteRole({{ $role->id }})" class="p-1.5 text-slate-400 hover:text-red-500 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors" title="Delete Role">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Create/Edit Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/40 backdrop-blur-sm transition-all" wire:key="role-modal">
            <div class="w-full max-w-lg bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-6 shadow-2xl space-y-5 animate-in fade-in zoom-in-95 duration-200">
                <div class="flex justify-between items-center pb-3 border-b border-slate-100 dark:border-slate-800">
                    <h3 class="text-base font-bold text-slate-800 dark:text-white flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-primary text-[20px]">verified_user</span>
                        {{ $roleId ? 'Modify System Role' : 'Create Custom Role' }}
                    </h3>
                    <button wire:click="$set('showModal', false)" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-250 transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <form wire:submit="saveRole" class="space-y-4">
                    <!-- Role Name -->
                    <div>
                        <label for="name" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">Role Name (lowercase, e.g. clerk, partner)</label>
                        <input wire:model="name" id="name" type="text" placeholder="e.g. associate"
                               class="block w-full px-3.5 py-2 text-xs bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    <!-- Permissions List -->
                    @if($permissions->isNotEmpty())
                        <div>
                            <label class="font-semibold text-xs text-slate-500 block mb-2.5 uppercase tracking-wider text-[10px]">Assign Access Permissions</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 max-h-56 overflow-y-auto border border-slate-100 dark:border-slate-800 p-3 rounded-xl bg-slate-50/50 dark:bg-slate-900/30">
                                @foreach($permissions as $perm)
                                    <label class="flex items-center gap-2.5 text-xs text-slate-700 dark:text-slate-355 cursor-pointer hover:text-primary dark:hover:text-blue-450 transition-colors">
                                        <input wire:model="selectedPermissions" value="{{ $perm->name }}" type="checkbox"
                                               class="rounded text-primary focus:ring-primary dark:bg-slate-800 border-slate-300 dark:border-slate-700" />
                                        <span>{{ $perm->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="flex justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                        <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2 bg-slate-100 hover:bg-slate-200/80 dark:bg-slate-800 dark:hover:bg-slate-700/85 text-slate-700 dark:text-slate-300 font-semibold text-xs rounded-xl transition-all">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-primary text-white hover:opacity-90 font-semibold text-xs rounded-xl transition-all shadow-md shadow-indigo-900/10 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px]">save</span>
                            Save Role
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
