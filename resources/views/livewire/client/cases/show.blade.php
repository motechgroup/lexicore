<div>
    <!-- Back to Cases & Title -->
    <div class="mb-8">
        <a href="{{ route('client.cases.index') }}" class="inline-flex items-center gap-1.5 text-xs text-slate-500 hover:text-primary dark:hover:text-blue-400 font-semibold mb-3">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            Back to Case List
        </a>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 mb-1">
                    <span class="text-xs font-semibold text-slate-400 font-mono">#{{ $matter->case_number }}</span>
                    <span class="px-2.5 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider
                        {{ $matter->status === 'closed' ? 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400' : '' }}
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
        </div>
    </div>

    <!-- Main Two-Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Side: Counsel Profile & Court Details -->
        <div class="space-y-6">
            <!-- Assigned Attorney Profile Card -->
            <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-6 shadow-sm">
                <h3 class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-4">Lead Attorney</h3>
                @if ($matter->leadAttorney)
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-blue-500 to-indigo-500 flex items-center justify-center text-white font-bold text-lg shrink-0">
                            {{ substr($matter->leadAttorney->name, 0, 2) }}
                        </div>
                        <div class="min-w-0">
                            <h4 class="font-bold text-sm text-slate-800 dark:text-white truncate">{{ $matter->leadAttorney->name }}</h4>
                            <p class="text-xs text-slate-500 dark:text-slate-450 truncate">{{ $matter->leadAttorney->attorneyProfile->title ?? 'Attorney at Law' }}</p>
                        </div>
                    </div>
                    <div class="space-y-2 text-xs">
                        <p class="text-slate-500 leading-relaxed">{{ $matter->leadAttorney->attorneyProfile->bio ?? 'Assigned to protect and advocate for your rights in this matter.' }}</p>
                        <div class="pt-2 border-t border-slate-100 dark:border-slate-800/80 mt-2">
                            <span class="text-slate-400 block mb-0.5">Email Address:</span>
                            <a href="mailto:{{ $matter->leadAttorney->email }}" class="text-primary dark:text-blue-400 hover:underline font-semibold">{{ $matter->leadAttorney->email }}</a>
                        </div>
                    </div>
                @else
                    <div class="text-center py-4">
                        <span class="material-symbols-outlined text-slate-300 dark:text-slate-650 text-4xl mb-2">person</span>
                        <p class="text-xs text-slate-500">Attorney assignment pending</p>
                    </div>
                @endif
            </div>

            <!-- Court Jurisdiction Card -->
            <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-6 shadow-sm">
                <h3 class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-4">Jurisdiction & Court</h3>
                <div class="space-y-4 text-xs">
                    <div>
                        <span class="text-slate-400 block mb-0.5">Court Room / Venue:</span>
                        <span class="font-semibold text-slate-800 dark:text-slate-300">{{ $matter->court ?? 'Not Applicable (Transactional)' }}</span>
                    </div>
                    @if($matter->judge)
                        <div>
                            <span class="text-slate-400 block mb-0.5">Presiding Judge:</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-300">{{ $matter->judge }}</span>
                        </div>
                    @endif
                    @if($matter->opposing_party)
                        <div>
                            <span class="text-slate-400 block mb-0.5">Opposing Party:</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-300 text-red-600 dark:text-red-400">{{ $matter->opposing_party }}</span>
                        </div>
                    @endif
                    @if($matter->opposing_counsel)
                        <div>
                            <span class="text-slate-400 block mb-0.5">Opposing Counsel:</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-300">{{ $matter->opposing_counsel }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Side: Timeline, Hearings, Documents -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Matter Summary Details -->
            <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-6 shadow-sm">
                <h3 class="font-display-lg text-lg text-slate-800 dark:text-white font-bold mb-4">Matter Overview</h3>
                <p class="text-sm text-slate-650 dark:text-slate-350 leading-relaxed mb-4">
                    {{ $matter->description ?? 'No detailed description registered for this matter.' }}
                </p>
                <div class="grid grid-cols-2 gap-4 border-t border-slate-100 dark:border-slate-800/80 pt-4 text-xs">
                    <div>
                        <span class="text-slate-400">Date Opened:</span>
                        <span class="font-semibold text-slate-800 dark:text-slate-300 block mt-0.5">{{ $matter->start_date ? $matter->start_date->format('F d, Y') : 'Pending' }}</span>
                    </div>
                    @if($matter->case_value)
                        <div>
                            <span class="text-slate-400">Total Claim / Value:</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-300 block mt-0.5">${{ number_format($matter->case_value, 2) }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Case Progress Timeline -->
            <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-6 shadow-sm">
                <h3 class="font-display-lg text-lg text-slate-800 dark:text-white font-bold mb-6 font-semibold">Litigation Phase Timeline</h3>
                
                <!-- Status Timeline Flow -->
                <div class="relative pl-6 border-l-2 border-slate-100 dark:border-slate-800 space-y-8">
                    
                    <!-- Milestone 1: Intake -->
                    <div class="relative">
                        <span class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-emerald-500 border-4 border-white dark:border-[#1e293b]"></span>
                        <div>
                            <h4 class="font-bold text-xs text-slate-800 dark:text-white">Case Intake & Evaluation</h4>
                            <p class="text-[10px] text-slate-400 mt-0.5">Completed on {{ $matter->start_date ? $matter->start_date->format('M d, Y') : 'Pending' }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-450 mt-1">Conflict check cleared. Representation agreement executed.</p>
                        </div>
                    </div>

                    <!-- Milestone 2: Discovery -->
                    <div class="relative">
                        @php
                            $isDiscovery = in_array(strtolower($matter->status), ['discovery', 'trial', 'mediation']);
                            $discoveryComplete = in_array(strtolower($matter->status), ['trial', 'mediation', 'closed']);
                        @endphp
                        <span class="absolute -left-[31px] top-0 w-4 h-4 rounded-full border-4 border-white dark:border-[#1e293b]
                            {{ $discoveryComplete ? 'bg-emerald-500' : ($isDiscovery ? 'bg-blue-500 ring-4 ring-blue-500/20' : 'bg-slate-250') }}
                        "></span>
                        <div>
                            <h4 class="font-bold text-xs text-slate-800 dark:text-white">Discovery & Deposition Phase</h4>
                            <p class="text-[10px] text-slate-400 mt-0.5">
                                {{ $discoveryComplete ? 'Completed' : ($isDiscovery ? 'CURRENT PHASE' : 'Upcoming') }}
                            </p>
                            <p class="text-xs text-slate-500 dark:text-slate-450 mt-1">Interrogatories drafted, document production exchanges, and scheduling expert witness testimonies.</p>
                        </div>
                    </div>

                    <!-- Milestone 3: Mediation / Settlement -->
                    <div class="relative">
                        @php
                            $isMediation = in_array(strtolower($matter->status), ['mediation', 'trial']);
                            $mediationComplete = in_array(strtolower($matter->status), ['trial', 'closed']);
                        @endphp
                        <span class="absolute -left-[31px] top-0 w-4 h-4 rounded-full border-4 border-white dark:border-[#1e293b]
                            {{ $mediationComplete ? 'bg-emerald-500' : ($isMediation ? 'bg-blue-500 ring-4 ring-blue-500/20' : 'bg-slate-250') }}
                        "></span>
                        <div>
                            <h4 class="font-bold text-xs text-slate-800 dark:text-white">Mediation & Negotiation</h4>
                            <p class="text-[10px] text-slate-400 mt-0.5">
                                {{ $mediationComplete ? 'Completed' : ($isMediation ? 'CURRENT PHASE' : 'Upcoming') }}
                            </p>
                            <p class="text-xs text-slate-500 dark:text-slate-450 mt-1">Review alternative dispute resolutions and present settlement proposals to opposing party.</p>
                        </div>
                    </div>

                    <!-- Milestone 4: Trial -->
                    <div class="relative">
                        @php
                            $isTrial = strtolower($matter->status) === 'trial';
                            $trialComplete = strtolower($matter->status) === 'closed';
                        @endphp
                        <span class="absolute -left-[31px] top-0 w-4 h-4 rounded-full border-4 border-white dark:border-[#1e293b]
                            {{ $trialComplete ? 'bg-emerald-500' : ($isTrial ? 'bg-blue-500 ring-4 ring-blue-500/20' : 'bg-slate-250') }}
                        "></span>
                        <div>
                            <h4 class="font-bold text-xs text-slate-800 dark:text-white">Trial Representation</h4>
                            <p class="text-[10px] text-slate-400 mt-0.5">
                                {{ $trialComplete ? 'Completed' : ($isTrial ? 'CURRENT PHASE' : 'Upcoming') }}
                            </p>
                            <p class="text-xs text-slate-500 dark:text-slate-450 mt-1">Courtroom advocacy, witness examination, arguments, and jury deliberations.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Scheduled Hearings -->
            <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-6 shadow-sm">
                <h3 class="font-display-lg text-lg text-slate-800 dark:text-white font-bold mb-6 font-semibold">Scheduled Hearings & Appearances</h3>
                @if ($hearings->isEmpty())
                    <p class="text-xs text-slate-450 dark:text-slate-500 py-4 text-center">No hearings scheduled at this time.</p>
                @else
                    <div class="space-y-4">
                        @foreach ($hearings as $hearing)
                            <div class="flex gap-4 items-start p-4 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-800/80">
                                <div class="w-10 h-10 rounded-xl bg-primary/5 dark:bg-blue-950/40 flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-primary dark:text-blue-400 text-[20px]">calendar_today</span>
                                </div>
                                <div class="min-w-0">
                                    <h4 class="font-bold text-xs text-slate-800 dark:text-white mb-0.5">{{ $hearing->title }}</h4>
                                    <p class="text-[10px] font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">
                                        {{ $hearing->hearing_date->format('M d, Y') }} &bull; {{ $hearing->hearing_date->format('g:i A T') }}
                                    </p>
                                    @if($hearing->location)
                                        <p class="text-[10px] text-slate-450 dark:text-slate-500">Location: {{ $hearing->location }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Shared Case Documents -->
            <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-6 shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-display-lg text-lg text-slate-800 dark:text-white font-bold font-semibold">Shared Documents</h3>
                </div>
                @if ($documents->isEmpty())
                    <p class="text-xs text-slate-450 dark:text-slate-500 py-4 text-center">No documents have been uploaded or shared for this case.</p>
                @else
                    <div class="space-y-3">
                        @foreach ($documents as $doc)
                            <div class="flex justify-between items-center p-3 border border-slate-100 dark:border-slate-800/60 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
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
                                    <button class="p-2 text-slate-400 hover:text-primary dark:hover:text-blue-400 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                                        <span class="material-symbols-outlined text-[20px]">download</span>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
