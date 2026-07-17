<div>
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="font-display-lg text-3xl text-primary dark:text-white mb-1 font-bold">Team Members & Counselors</h1>
        <p class="text-slate-500 dark:text-slate-400 text-sm">Browse your firm's attorneys, legal assistants, and administrators.</p>
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
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search team member name..." 
                   class="pl-9 pr-4 py-2 w-full text-xs rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/60 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250">
        </div>
    </div>

    <!-- Grid of Counselors -->
    @if($members->isEmpty())
        <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-12 text-center shadow-sm">
            <span class="material-symbols-outlined text-slate-300 dark:text-slate-650 text-5xl mb-4" style="font-variation-settings: 'FILL' 0;">group</span>
            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-2">No Counselors Found</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md mx-auto">No profiles match your search.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($members as $m)
                <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-6 flex flex-col justify-between shadow-sm hover:shadow-md transition-all duration-300">
                    <div>
                        <!-- Header with role badge -->
                        <div class="flex justify-between items-start gap-4 mb-4">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-blue-500 to-indigo-500 flex items-center justify-center text-white font-bold text-lg shrink-0">
                                {{ substr($m->name, 0, 2) }}
                            </div>
                            <span class="px-2 py-0.5 rounded-full text-[8px] font-bold uppercase tracking-wider bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400">
                                {{ $m->roles->first()->name ?? 'Staff' }}
                            </span>
                        </div>

                        <!-- Name and Title -->
                        <h3 class="font-display-lg text-lg font-bold text-slate-800 dark:text-white mb-0.5 truncate">{{ $m->name }}</h3>
                        <p class="text-xs text-amber-600 dark:text-amber-450 font-semibold mb-3">{{ $m->attorneyProfile->title ?? 'Legal Counsel' }}</p>


                        <!-- Bio -->
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed mb-6 line-clamp-3">
                            {{ $m->attorneyProfile->bio ?? 'Dedicated legal advocate focused on client representation and compliance operations.' }}
                        </p>
                    </div>

                    <!-- Contact Footer -->
                    <div class="border-t border-slate-100 dark:border-slate-800/80 pt-4 flex items-center justify-between text-xs">
                        <span class="text-slate-400">Email:</span>
                        <a href="mailto:{{ $m->email }}" class="font-semibold text-primary dark:text-blue-400 hover:underline">{{ $m->email }}</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
