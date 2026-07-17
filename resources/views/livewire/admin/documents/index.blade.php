<div>
    <!-- Page Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-display-lg text-3xl text-primary dark:text-white mb-1 font-bold">Document Repository</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Manage legal contracts, depositions, affidavits, and case files.</p>
        </div>
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
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search by file name or title..." 
                   class="pl-9 pr-4 py-2 w-full text-xs rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/60 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250">
        </div>
    </div>

    <!-- Table of Documents -->
    <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 shadow-sm overflow-hidden">
        @if($documents->isEmpty())
            <div class="p-12 text-center">
                <span class="material-symbols-outlined text-slate-300 dark:text-slate-650 text-5xl mb-4" style="font-variation-settings: 'FILL' 0;">description</span>
                <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-2">No Documents Found</h3>
                <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md mx-auto">No uploaded items match your filter criteria.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800 text-[10px] uppercase font-bold tracking-wider text-slate-400 dark:text-slate-500">
                            <th class="px-6 py-4">Document File</th>
                            <th class="px-6 py-4">Case File</th>
                            <th class="px-6 py-4">Linked Client</th>
                            <th class="px-6 py-4">Uploaded By</th>
                            <th class="px-6 py-4">Upload Date</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 text-xs text-slate-700 dark:text-slate-330">
                        @foreach($documents as $doc)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                                <!-- File Name & Type Icon -->
                                <td class="px-6 py-4 flex items-center gap-3">
                                    @php
                                        $icon = 'description';
                                        $color = 'text-blue-500 bg-blue-50 dark:bg-blue-950/30';
                                        $mime = strtolower($doc->mime_type);
                                        if (str_contains($mime, 'pdf')) {
                                            $icon = 'picture_as_pdf';
                                            $color = 'text-red-500 bg-red-50 dark:bg-red-950/30';
                                        } elseif (str_contains($mime, 'image')) {
                                            $icon = 'image';
                                            $color = 'text-slate-650 bg-slate-50 dark:bg-slate-800';
                                        }
                                    @endphp
                                    <div class="w-9 h-9 rounded-lg {{ $color }} flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-[20px]">{{ $icon }}</span>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-bold text-slate-800 dark:text-white mb-0.5 truncate max-w-[200px]" title="{{ $doc->title }}">{{ $doc->title }}</div>
                                        <div class="text-[10px] text-slate-400">Size: {{ number_format($doc->file_size / 1024, 1) }} KB</div>
                                    </div>
                                </td>
                                <!-- Linked Matter -->
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-800 dark:text-slate-350">{{ $doc->matter->title ?? 'General retainer' }}</div>
                                    @if($doc->matter)
                                        <div class="text-[10px] text-slate-400">#{{ $doc->matter->case_number }}</div>
                                    @endif
                                </td>
                                <!-- Linked Client -->
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-800 dark:text-slate-350">{{ $doc->client->name ?? 'Unlinked' }}</div>
                                </td>
                                <!-- Uploaded By -->
                                <td class="px-6 py-4 text-slate-500">
                                    {{ $doc->uploader->name ?? 'System' }}
                                </td>
                                <!-- Upload Date -->
                                <td class="px-6 py-4 text-slate-550">
                                    {{ $doc->created_at->format('M d, Y') }}
                                </td>
                                <!-- Action -->
                                <td class="px-6 py-4 text-right">
                                    <button class="p-2 text-slate-400 hover:text-primary dark:hover:text-blue-400 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" title="Download">
                                        <span class="material-symbols-outlined text-[20px]">download</span>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination Controls -->
            <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800/80">
                {{ $documents->links() }}
            </div>
        @endif
    </div>
</div>
