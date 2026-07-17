<div>
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="font-display-lg text-3xl text-primary dark:text-white mb-1 font-bold">System Settings</h1>
        <p class="text-slate-500 dark:text-slate-400 text-sm">Configure legal practice billing, branding, theme layouts, privacy policy, and backup logs.</p>
    </div>

    <!-- Alert Notifications -->
    @if (session()->has('status'))
        <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-250 dark:border-emerald-900 text-emerald-850 dark:text-emerald-450 text-xs rounded-xl flex items-center gap-2">
            <span class="material-symbols-outlined text-[20px]">check_circle</span>
            {{ session('status') }}
        </div>
    @endif

    <form wire:submit="save" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Panel: Configurations (2 Columns) -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- 1. Firm Details -->
            <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-6 shadow-sm space-y-5">
                <h3 class="font-bold text-xs text-slate-500 uppercase tracking-wider pb-3 border-b border-slate-100 dark:border-slate-850 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">domain</span>
                    Firm Information
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="firmName" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">Firm Name</label>
                        <input wire:model="firmName" id="firmName" type="text"
                               class="block w-full px-4 py-2.5 text-sm bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                        <x-input-error :messages="$errors->get('firmName')" class="mt-1" />
                    </div>
                    <div>
                        <label for="taxRate" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">Default Tax Rate (%)</label>
                        <input wire:model="taxRate" id="taxRate" type="number" step="0.1"
                               class="block w-full px-4 py-2.5 text-sm bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                        <x-input-error :messages="$errors->get('taxRate')" class="mt-1" />
                    </div>
                </div>

                <div>
                    <label for="paymentTerms" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">Default Retainer Payment Terms</label>
                    <textarea wire:model="paymentTerms" id="paymentTerms" rows="3"
                              class="block w-full px-4 py-2.5 text-sm bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250"></textarea>
                    <x-input-error :messages="$errors->get('paymentTerms')" class="mt-1" />
                </div>
            </div>

            <!-- 2. Branding & Theme -->
            <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-6 shadow-sm space-y-5">
                <h3 class="font-bold text-xs text-slate-500 uppercase tracking-wider pb-3 border-b border-slate-100 dark:border-slate-850 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">palette</span>
                    Branding & Theme Layout
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="siteTheme" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">Site Theme</label>
                        <select wire:model="siteTheme" id="siteTheme"
                                class="block w-full px-3 py-2.5 text-sm bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250">
                            <option value="dark">Sleek Dark Mode (Default)</option>
                            <option value="light">Classic Light Mode</option>
                            <option value="system">System Preference</option>
                        </select>
                        <x-input-error :messages="$errors->get('siteTheme')" class="mt-1" />
                    </div>
                    <div>
                        <label for="logoUrl" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">Logo Resource URL</label>
                        <input wire:model="logoUrl" id="logoUrl" type="text" placeholder="e.g. /images/logo.png"
                               class="block w-full px-4 py-2.5 text-sm bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                        <x-input-error :messages="$errors->get('logoUrl')" class="mt-1" />
                    </div>
                    <div>
                        <label for="faviconUrl" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">Favicon URL</label>
                        <input wire:model="faviconUrl" id="faviconUrl" type="text" placeholder="e.g. /favicon.ico"
                               class="block w-full px-4 py-2.5 text-sm bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                        <x-input-error :messages="$errors->get('faviconUrl')" class="mt-1" />
                    </div>
                </div>

                <div>
                    <label for="footerText" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">Footer Copyright / Info Text</label>
                    <input wire:model="footerText" id="footerText" type="text"
                           class="block w-full px-4 py-2.5 text-sm bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                    <x-input-error :messages="$errors->get('footerText')" class="mt-1" />
                </div>
            </div>

            <!-- 3. Legal pages content -->
            <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-6 shadow-sm space-y-5">
                <h3 class="font-bold text-xs text-slate-500 uppercase tracking-wider pb-3 border-b border-slate-100 dark:border-slate-850 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">gavel</span>
                    Legal Pages & Disclaimers Content
                </h3>

                <div>
                    <label for="privacyPolicy" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">Privacy Policy Page (Markdown/HTML)</label>
                    <textarea wire:model="privacyPolicy" id="privacyPolicy" rows="5"
                              class="block w-full px-4 py-2.5 text-xs font-mono bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250"></textarea>
                    <x-input-error :messages="$errors->get('privacyPolicy')" class="mt-1" />
                </div>

                <div>
                    <label for="termsConditions" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">Terms of Service Page (Markdown/HTML)</label>
                    <textarea wire:model="termsConditions" id="termsConditions" rows="5"
                              class="block w-full px-4 py-2.5 text-xs font-mono bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250"></textarea>
                    <x-input-error :messages="$errors->get('termsConditions')" class="mt-1" />
                </div>
            </div>
        </div>

        <!-- Right Panel: Actions & Backups (1 Column) -->
        <div class="space-y-6">
            
            <!-- Save Button block -->
            <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-6 shadow-sm space-y-4">
                <h3 class="font-bold text-xs text-slate-500 uppercase tracking-wider pb-3 border-b border-slate-100 dark:border-slate-850">Actions</h3>
                <button type="submit" class="w-full py-2.5 bg-primary text-white hover:opacity-90 font-semibold text-xs rounded-xl transition-all shadow-md shadow-indigo-900/10 flex items-center gap-1.5 justify-center">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    Save System Settings
                </button>
            </div>

            <!-- Backups -->
            <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-6 shadow-sm space-y-5 h-fit">
                <h3 class="font-bold text-xs text-slate-500 uppercase tracking-wider pb-3 border-b border-slate-100 dark:border-slate-850">System Backups</h3>
                
                <p class="text-xs text-slate-500 leading-relaxed">
                    Regularly back up your MySQL/SQLite database schema and uploaded matter files to prevent data loss on shared hosting.
                </p>

                <button type="button" wire:click="triggerBackup" class="w-full py-2.5 bg-slate-50 hover:bg-slate-100 dark:bg-slate-800 dark:hover:bg-slate-700/85 transition-all border border-slate-200/50 dark:border-slate-800 font-semibold text-xs rounded-xl flex items-center justify-center gap-1.5 text-slate-700 dark:text-slate-300">
                    <span class="material-symbols-outlined text-[18px]">backup</span>
                    Run System Backup
                </button>

                <!-- Mock backup files list -->
                <div class="border-t border-slate-100 dark:border-slate-800/60 pt-4 space-y-3">
                    <h4 class="font-bold text-[10px] text-slate-400 uppercase tracking-wider">Recent Backup Archives</h4>
                    <div class="space-y-2 text-xs">
                        <div class="flex justify-between items-center p-2 rounded-lg bg-slate-50 dark:bg-slate-900/40">
                            <div class="min-w-0">
                                <p class="font-semibold text-slate-750 dark:text-slate-300 truncate">backup_db_20260717.sql.gz</p>
                                <p class="text-[9px] text-slate-400 mt-0.5">Size: 4.8 MB &bull; Created today</p>
                            </div>
                            <span class="material-symbols-outlined text-emerald-500 text-[18px]">check_circle</span>
                        </div>
                        <div class="flex justify-between items-center p-2 rounded-lg bg-slate-50 dark:bg-slate-900/40">
                            <div class="min-w-0">
                                <p class="font-semibold text-slate-750 dark:text-slate-300 truncate">backup_db_20260710.sql.gz</p>
                                <p class="text-[9px] text-slate-400 mt-0.5">Size: 4.6 MB &bull; 7 days ago</p>
                            </div>
                            <span class="material-symbols-outlined text-slate-400 text-[18px]">check_circle</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>
