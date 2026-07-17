<div>
    <!-- Page Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-display-lg text-3xl text-primary dark:text-white mb-1 font-bold">My Cases & Matters</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Browse your active and past legal representation records.</p>
        </div>
    </div>

    <!-- Case Cards Grid -->
    @if ($matters->isEmpty())
        <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-12 text-center shadow-sm">
            <span class="material-symbols-outlined text-slate-300 dark:text-slate-650 text-5xl mb-4" style="font-variation-settings: 'FILL' 0;">gavel</span>
            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-2">No Active Cases Found</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md mx-auto">There are currently no matters linked to your account. If you believe this is in error, please contact your attorney.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($matters as $matter)
                <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-6 flex flex-col justify-between shadow-sm hover:shadow-md transition-all duration-300">
                    <div>
                        <!-- Header: Case Number & Status -->
                        <div class="flex justify-between items-start gap-4 mb-4">
                            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider font-mono">#{{ $matter->case_number }}</span>
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
                                {{ $matter->status === 'closed' ? 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400' : '' }}
                                {{ $matter->status === 'trial' ? 'bg-rose-50 text-rose-600 dark:bg-rose-950/30 dark:text-rose-400' : '' }}
                                {{ $matter->status === 'mediation' ? 'bg-amber-50 text-amber-600 dark:bg-amber-950/30 dark:text-amber-450' : '' }}
                                {{ in_array($matter->status, ['discovery', 'in progress', 'In Progress', 'Discovery']) ? 'bg-blue-50 text-blue-600 dark:bg-blue-950/30 dark:text-blue-400' : '' }}
                                {{ !in_array($matter->status, ['closed', 'trial', 'mediation', 'discovery', 'in progress', 'In Progress', 'Discovery']) ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-950/30 dark:text-emerald-450' : '' }}
                            ">
                                {{ $matter->status }}
                            </span>
                        </div>

                        <!-- Title -->
                        <h3 class="font-display-lg text-xl font-bold text-slate-800 dark:text-white mb-2 line-clamp-1">
                            {{ $matter->title }}
                        </h3>

                        <!-- Practice Area -->
                        <div class="flex items-center gap-2 mb-4">
                            <span class="material-symbols-outlined text-primary dark:text-blue-400 text-[18px]">
                                {{ $matter->practiceArea->icon ?? 'gavel' }}
                            </span>
                            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                                {{ $matter->practiceArea->name ?? 'General Legal Matter' }}
                            </span>
                        </div>

                        <!-- Case Details List -->
                        <div class="border-t border-slate-100 dark:border-slate-800/80 pt-4 space-y-2 mb-6">
                            <div class="flex justify-between text-xs">
                                <span class="text-slate-400">Lead Counsel:</span>
                                <span class="font-semibold text-slate-700 dark:text-slate-350">{{ $matter->leadAttorney->name ?? 'Unassigned' }}</span>
                            </div>
                            @if($matter->court)
                                <div class="flex justify-between text-xs">
                                    <span class="text-slate-400">Jurisdiction:</span>
                                    <span class="font-semibold text-slate-700 dark:text-slate-350 truncate max-w-[200px]" title="{{ $matter->court }}">{{ $matter->court }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between text-xs">
                                <span class="text-slate-400">Commencement:</span>
                                <span class="font-semibold text-slate-700 dark:text-slate-350">{{ $matter->start_date ? $matter->start_date->format('M d, Y') : 'Pending' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div>
                        <a href="{{ route('client.cases.show', $matter->id) }}" class="w-full py-2.5 bg-slate-50 hover:bg-primary hover:text-white dark:bg-slate-800/40 dark:hover:bg-primary transition-all font-semibold text-xs rounded-xl flex items-center justify-center gap-1.5 text-slate-600 dark:text-slate-300">
                            <span class="material-symbols-outlined text-[16px]">folder_open</span>
                            View Case File
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
