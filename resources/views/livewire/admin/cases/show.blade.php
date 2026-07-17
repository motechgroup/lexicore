<div>
    <!-- Back to Cases & Title -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <a href="{{ route('admin.cases.index') }}" class="inline-flex items-center gap-1.5 text-xs text-slate-500 hover:text-primary dark:hover:text-blue-400 font-semibold mb-3">
                <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                Back to Case Files
            </a>
            <div class="flex items-center gap-3 mb-1">
                <span class="text-xs font-semibold text-slate-400 font-mono">#{{ $matter->case_number }}</span>
                <span class="px-2.5 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider
                    {{ $matter->status === 'closed' ? 'bg-slate-100 text-slate-650 dark:bg-slate-800 dark:text-slate-400' : '' }}
                    {{ $matter->status === 'trial' ? 'bg-rose-50 text-rose-600 dark:bg-rose-950/30 dark:text-rose-400' : '' }}
                    {{ $matter->status === 'mediation' ? 'bg-amber-50 text-amber-600 dark:bg-amber-950/30 dark:text-amber-450' : '' }}
                    {{ in_array($matter->status, ['discovery', 'in progress', 'In Progress', 'Discovery']) ? 'bg-blue-50 text-blue-600 dark:bg-blue-950/30 dark:text-blue-400' : '' }}
                    {{ !in_array($matter->status, ['closed', 'trial', 'mediation', 'discovery', 'in progress', 'In Progress', 'Discovery']) ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-950/30 dark:text-emerald-450' : '' }}
                ">
                    {{ $matter->status }}
                </span>
            </div>
            <h1 class="font-display-lg text-3xl text-primary dark:text-white font-bold">{{ $matter->title }}</h1>
        </div>
        <div>
            <a href="{{ route('admin.cases.edit', $matter->id) }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700/80 text-slate-700 dark:text-slate-300 font-semibold text-xs rounded-xl transition-all flex items-center gap-1.5 justify-center">
                <span class="material-symbols-outlined text-[18px]">edit</span>
                Edit Case Folder
            </a>
        </div>
    </div>

    <!-- Status Alert Messages -->
    @if (session()->has('status'))
        <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-250 dark:border-emerald-900 text-emerald-850 dark:text-emerald-450 text-xs rounded-xl flex items-center gap-2">
            <span class="material-symbols-outlined text-[20px]">check_circle</span>
            {{ session('status') }}
        </div>
    @endif

    <!-- Tabbed Panel Area -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- Tabs Menu Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-4 shadow-sm space-y-1.5">
                <button wire:click="setTab('overview')" class="w-full text-left px-4 py-3 rounded-xl text-xs font-semibold flex items-center gap-3 transition-all
                    {{ $activeTab === 'overview' ? 'bg-primary text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                    <span class="material-symbols-outlined text-[20px]">info</span>
                    Case Overview
                </button>
                <button wire:click="setTab('hearings')" class="w-full text-left px-4 py-3 rounded-xl text-xs font-semibold flex items-center gap-3 transition-all
                    {{ $activeTab === 'hearings' ? 'bg-primary text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                    <span class="material-symbols-outlined text-[20px]">gavel</span>
                    Court Hearings ({{ count($hearings) }})
                </button>
                <button wire:click="setTab('tasks')" class="w-full text-left px-4 py-3 rounded-xl text-xs font-semibold flex items-center gap-3 transition-all
                    {{ $activeTab === 'tasks' ? 'bg-primary text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                    <span class="material-symbols-outlined text-[20px]">checklist</span>
                    Tasks Checklist ({{ count($tasks) }})
                </button>
                <button wire:click="setTab('documents')" class="w-full text-left px-4 py-3 rounded-xl text-xs font-semibold flex items-center gap-3 transition-all
                    {{ $activeTab === 'documents' ? 'bg-primary text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                    <span class="material-symbols-outlined text-[20px]">description</span>
                    Documents File ({{ count($documents) }})
                </button>
            </div>
        </div>

        <!-- Tabs Content area -->
        <div class="lg:col-span-3 space-y-6">
            
            <!-- OVERVIEW PANEL -->
            @if ($activeTab === 'overview')
                <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-6 shadow-sm space-y-6">
                    <div>
                        <h3 class="font-display-lg text-lg text-slate-800 dark:text-white font-bold mb-3 border-b border-slate-100 dark:border-slate-800 pb-2">Matter Description</h3>
                        <p class="text-sm text-slate-650 dark:text-slate-350 leading-relaxed">
                            {{ $matter->description ?? 'No detailed description registered for this case folder.' }}
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t border-slate-100 dark:border-slate-800/80 pt-6">
                        <!-- Left Specs -->
                        <div class="space-y-4 text-xs">
                            <h4 class="font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider text-[10px]">Case Metadata</h4>
                            <div class="flex justify-between py-1 border-b border-slate-50 dark:border-slate-800">
                                <span class="text-slate-400">Client Profile:</span>
                                <span class="font-semibold text-slate-800 dark:text-slate-300">{{ $matter->client->name ?? 'Unlinked' }}</span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-slate-50 dark:border-slate-800">
                                <span class="text-slate-400">Practice specialty:</span>
                                <span class="font-semibold text-slate-800 dark:text-slate-300">{{ $matter->practiceArea->name ?? 'General Counsel' }}</span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-slate-50 dark:border-slate-800">
                                <span class="text-slate-400">Assigned Counsel:</span>
                                <span class="font-semibold text-slate-800 dark:text-slate-300">{{ $matter->leadAttorney->name ?? 'Unassigned' }}</span>
                            </div>
                            <div class="flex justify-between py-1">
                                <span class="text-slate-400">Claims Value:</span>
                                <span class="font-semibold text-slate-800 dark:text-slate-300">${{ number_format($matter->case_value ?? 0, 2) }}</span>
                            </div>
                        </div>

                        <!-- Right Specs -->
                        <div class="space-y-4 text-xs">
                            <h4 class="font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider text-[10px]">Court Venue & Opposing Counsel</h4>
                            <div class="flex justify-between py-1 border-b border-slate-50 dark:border-slate-800">
                                <span class="text-slate-400">Jurisdiction Court:</span>
                                <span class="font-semibold text-slate-800 dark:text-slate-300 text-right truncate max-w-[200px]" title="{{ $matter->court }}">{{ $matter->court ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-slate-50 dark:border-slate-800">
                                <span class="text-slate-400">Presiding Judge:</span>
                                <span class="font-semibold text-slate-800 dark:text-slate-300">{{ $matter->judge ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-slate-50 dark:border-slate-800">
                                <span class="text-slate-400">Opposing Counsel:</span>
                                <span class="font-semibold text-slate-800 dark:text-slate-300">{{ $matter->opposing_counsel ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between py-1">
                                <span class="text-slate-400">Opposing Party:</span>
                                <span class="font-semibold text-red-600 dark:text-red-400">{{ $matter->opposing_party ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- HEARINGS PANEL -->
            @if ($activeTab === 'hearings')
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Schedule Form -->
                    <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-5 shadow-sm space-y-4 h-fit md:col-span-1">
                        <h4 class="font-bold text-xs text-slate-500 uppercase tracking-wider">Schedule Hearing</h4>
                        <form wire:submit="addHearing" class="space-y-4">
                            <div>
                                <label for="newHearingTitle" class="font-semibold text-[10px] text-slate-400 uppercase tracking-wider block mb-1">Hearing Title</label>
                                <input wire:model="newHearingTitle" id="newHearingTitle" type="text" placeholder="e.g. Deposition"
                                       class="block w-full px-3 py-2 text-xs border border-slate-200 dark:border-slate-800 dark:bg-slate-900/60 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 text-slate-800 dark:text-slate-200" />
                                <x-input-error :messages="$errors->get('newHearingTitle')" class="mt-1" />
                            </div>
                            <div>
                                <label for="newHearingDate" class="font-semibold text-[10px] text-slate-400 uppercase tracking-wider block mb-1">Date & Time</label>
                                <input wire:model="newHearingDate" id="newHearingDate" type="datetime-local"
                                       class="block w-full px-3 py-2 text-xs border border-slate-200 dark:border-slate-800 dark:bg-slate-900/60 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 text-slate-800 dark:text-slate-200" />
                                <x-input-error :messages="$errors->get('newHearingDate')" class="mt-1" />
                            </div>
                            <div>
                                <label for="newHearingLocation" class="font-semibold text-[10px] text-slate-400 uppercase tracking-wider block mb-1">Venue Room</label>
                                <input wire:model="newHearingLocation" id="newHearingLocation" type="text" placeholder="e.g. Room 402"
                                       class="block w-full px-3 py-2 text-xs border border-slate-200 dark:border-slate-800 dark:bg-slate-900/60 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 text-slate-800 dark:text-slate-200" />
                                <x-input-error :messages="$errors->get('newHearingLocation')" class="mt-1" />
                            </div>
                            <button type="submit" class="w-full py-2 bg-primary text-white font-semibold text-xs rounded-xl hover:opacity-90 transition-all flex items-center justify-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">calendar_today</span>
                                Schedule Appearance
                            </button>
                        </form>
                    </div>

                    <!-- Hearings List -->
                    <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-5 shadow-sm md:col-span-2 space-y-4">
                        <h4 class="font-bold text-xs text-slate-500 uppercase tracking-wider">Scheduled Docket</h4>
                        @if($hearings->isEmpty())
                            <p class="text-xs text-slate-400 text-center py-8">No hearings docketed for this case.</p>
                        @else
                            <div class="space-y-4 max-h-[350px] overflow-y-auto pr-1">
                                @foreach($hearings as $h)
                                    <div class="flex gap-4 p-4 border border-slate-100 dark:border-slate-800/80 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                        <div class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-slate-800 flex items-center justify-center shrink-0">
                                            <span class="material-symbols-outlined text-primary dark:text-blue-400 text-[20px]">calendar_today</span>
                                        </div>
                                        <div class="min-w-0">
                                            <h4 class="font-bold text-xs text-slate-800 dark:text-white mb-0.5">{{ $h->title }}</h4>
                                            <p class="text-[9px] font-semibold text-slate-400 uppercase tracking-wider mb-1">
                                                {{ $h->hearing_date->format('M d, Y') }} &bull; {{ $h->hearing_date->format('g:i A T') }}
                                            </p>
                                            <p class="text-[10px] text-slate-500 dark:text-slate-400">Venue: {{ $h->location ?? 'Court House' }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- TASKS PANEL -->
            @if ($activeTab === 'tasks')
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Create Task Form -->
                    <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-5 shadow-sm space-y-4 h-fit md:col-span-1">
                        <h4 class="font-bold text-xs text-slate-500 uppercase tracking-wider">Add Task</h4>
                        <form wire:submit="addTask" class="space-y-4">
                            <div>
                                <label for="newTaskTitle" class="font-semibold text-[10px] text-slate-400 uppercase tracking-wider block mb-1">Task Title</label>
                                <input wire:model="newTaskTitle" id="newTaskTitle" type="text" placeholder="e.g. File Motion"
                                       class="block w-full px-3 py-2 text-xs border border-slate-200 dark:border-slate-800 dark:bg-slate-900/60 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 text-slate-800 dark:text-slate-200" />
                                <x-input-error :messages="$errors->get('newTaskTitle')" class="mt-1" />
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label for="newTaskPriority" class="font-semibold text-[10px] text-slate-400 uppercase tracking-wider block mb-1">Priority</label>
                                    <select wire:model="newTaskPriority" id="newTaskPriority"
                                            class="block w-full px-2 py-2 text-xs border border-slate-200 dark:border-slate-800 dark:bg-slate-900/60 rounded-xl focus:outline-none text-slate-800 dark:text-slate-200">
                                        <option value="low">Low</option>
                                        <option value="medium">Medium</option>
                                        <option value="high">High</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('newTaskPriority')" class="mt-1" />
                                </div>
                                <div>
                                    <label for="newTaskDueDate" class="font-semibold text-[10px] text-slate-400 uppercase tracking-wider block mb-1">Due Date</label>
                                    <input wire:model="newTaskDueDate" id="newTaskDueDate" type="date"
                                           class="block w-full px-2 py-2 text-xs border border-slate-200 dark:border-slate-800 dark:bg-slate-900/60 rounded-xl focus:outline-none text-slate-850 dark:text-slate-250" />
                                    <x-input-error :messages="$errors->get('newTaskDueDate')" class="mt-1" />
                                </div>
                            </div>
                            <button type="submit" class="w-full py-2 bg-primary text-white font-semibold text-xs rounded-xl hover:opacity-90 transition-all flex items-center justify-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">add</span>
                                Add Checklist Task
                            </button>
                        </form>
                    </div>

                    <!-- Tasks List -->
                    <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-5 shadow-sm md:col-span-2 space-y-4">
                        <h4 class="font-bold text-xs text-slate-500 uppercase tracking-wider">Litigation Checklist</h4>
                        @if($tasks->isEmpty())
                            <p class="text-xs text-slate-400 text-center py-8">No tasks logged for this matter.</p>
                        @else
                            <div class="space-y-4 max-h-[350px] overflow-y-auto pr-1">
                                @foreach($tasks as $t)
                                    <div class="flex items-start gap-3 p-3 border border-slate-50 dark:border-slate-800/60 rounded-xl hover:bg-slate-50/50">
                                        <input wire:click="toggleTask({{ $t->id }})" class="mt-1 rounded border-slate-300 text-primary focus:ring-primary dark:bg-slate-800 dark:border-slate-700" type="checkbox" @checked($t->status === 'completed') />
                                        <div class="min-w-0 flex-1">
                                            <p class="text-xs font-semibold text-slate-700 dark:text-slate-350 {{ $t->status === 'completed' ? 'line-through opacity-50' : '' }} truncate">{{ $t->title }}</p>
                                            <p class="text-[9px] text-slate-400 dark:text-slate-500 mt-0.5">
                                                Priority: <span class="font-bold text-slate-500">{{ strtoupper($t->priority) }}</span> &bull; 
                                                Due: {{ $t->due_date ? $t->due_date->format('M d, Y') : 'N/A' }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- DOCUMENTS PANEL -->
            @if ($activeTab === 'documents')
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- File Upload Form -->
                    <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-5 shadow-sm space-y-4 h-fit md:col-span-1">
                        <h4 class="font-bold text-xs text-slate-500 uppercase tracking-wider">Add Document</h4>
                        <form wire:submit="addDocument" class="space-y-4">
                            <div>
                                <label for="newDocTitle" class="font-semibold text-[10px] text-slate-400 uppercase tracking-wider block mb-1">Document Title / File Name</label>
                                <input wire:model="newDocTitle" id="newDocTitle" type="text" placeholder="e.g. Contract_Draft.pdf"
                                       class="block w-full px-3 py-2 text-xs border border-slate-200 dark:border-slate-800 dark:bg-slate-900/60 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 text-slate-800 dark:text-slate-200" />
                                <x-input-error :messages="$errors->get('newDocTitle')" class="mt-1" />
                            </div>
                            <button type="submit" class="w-full py-2 bg-primary text-white font-semibold text-xs rounded-xl hover:opacity-90 transition-all flex items-center justify-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">upload_file</span>
                                Add Case File
                            </button>
                        </form>
                    </div>

                    <!-- Documents List -->
                    <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-5 shadow-sm md:col-span-2 space-y-4">
                        <h4 class="font-bold text-xs text-slate-500 uppercase tracking-wider">Linked Case Files</h4>
                        @if($documents->isEmpty())
                            <p class="text-xs text-slate-400 text-center py-8">No documents linked to this case folder.</p>
                        @else
                            <div class="space-y-3 max-h-[350px] overflow-y-auto pr-1">
                                @foreach($documents as $doc)
                                    <div class="flex justify-between items-center p-3 border border-slate-100 dark:border-slate-800/60 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                        <div class="flex items-center gap-3 min-w-0">
                                            @php
                                                $icon = 'description';
                                                $color = 'text-blue-500 bg-blue-50 dark:bg-blue-950/30';
                                                $mime = strtolower($doc->mime_type);
                                                if (str_contains($mime, 'pdf')) {
                                                    $icon = 'picture_as_pdf';
                                                    $color = 'text-red-500 bg-red-50 dark:bg-red-950/30';
                                                } elseif (str_contains($mime, 'image')) {
                                                    $icon = 'image';
                                                    $color = 'text-slate-600 bg-slate-50 dark:bg-slate-800';
                                                }
                                            @endphp
                                            <div class="w-9 h-9 rounded-lg {{ $color }} flex items-center justify-center shrink-0">
                                                <span class="material-symbols-outlined text-[20px]">{{ $icon }}</span>
                                            </div>
                                            <div class="min-w-0">
                                                <h4 class="font-semibold text-xs text-slate-700 dark:text-slate-200 truncate">{{ $doc->title }}</h4>
                                                <p class="text-[9px] text-slate-400 dark:text-slate-500 mt-0.5">
                                                    Size: {{ number_format($doc->file_size / 1024, 1) }} KB &bull; Uploaded {{ $doc->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="shrink-0 ml-4">
                                            <button class="p-2 text-slate-400 hover:text-primary dark:hover:text-blue-400 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" title="Download">
                                                <span class="material-symbols-outlined text-[20px]">download</span>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endif

        </div>

    </div>
</div>
