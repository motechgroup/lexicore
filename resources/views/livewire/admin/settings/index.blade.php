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

            <!-- Currency Settings -->
            <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-6 shadow-sm space-y-5">
                <h3 class="font-bold text-xs text-slate-500 uppercase tracking-wider pb-3 border-b border-slate-100 dark:border-slate-850 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">payments</span>
                    Currency Settings
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="siteCurrency" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">Site Currency (e.g. USD, EUR, KES)</label>
                        <input wire:model="siteCurrency" id="siteCurrency" type="text" placeholder="USD"
                               class="block w-full px-4 py-2.5 text-sm bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                        <x-input-error :messages="$errors->get('siteCurrency')" class="mt-1" />
                    </div>
                    <div>
                        <label for="siteCurrencySymbol" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">Currency Symbol (e.g. $, €, KSh)</label>
                        <input wire:model="siteCurrencySymbol" id="siteCurrencySymbol" type="text" placeholder="$"
                               class="block w-full px-4 py-2.5 text-sm bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                        <x-input-error :messages="$errors->get('siteCurrencySymbol')" class="mt-1" />
                    </div>
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
                        <label for="logoFile" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">Upload Logo Image</label>
                        <input wire:model="logoFile" id="logoFile" type="file" accept="image/*"
                               class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-primary file:text-white hover:file:opacity-90 transition-all" />
                        <x-input-error :messages="$errors->get('logoFile')" class="mt-1" />
                        @if($logoUrl)
                            <div class="mt-2 flex items-center gap-2">
                                <span class="text-[10px] text-slate-400">Current Logo:</span>
                                <img src="{{ $logoUrl }}" class="h-6 object-contain bg-slate-900/10 p-0.5 rounded" />
                            </div>
                        @endif
                    </div>
                    <div>
                        <label for="faviconFile" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">Upload Favicon (.ico/.png)</label>
                        <input wire:model="faviconFile" id="faviconFile" type="file" accept=".ico,.png,.jpg,.jpeg"
                               class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-primary file:text-white hover:file:opacity-90 transition-all" />
                        <x-input-error :messages="$errors->get('faviconFile')" class="mt-1" />
                        @if($faviconUrl)
                            <div class="mt-2 flex items-center gap-2">
                                <span class="text-[10px] text-slate-400">Current Favicon:</span>
                                <img src="{{ $faviconUrl }}" class="w-5 h-5 object-contain bg-slate-900/10 p-0.5 rounded" />
                            </div>
                        @endif
                    </div>
                </div>

                <div>
                    <label for="footerText" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">Footer Copyright / Info Text</label>
                    <input wire:model="footerText" id="footerText" type="text"
                           class="block w-full px-4 py-2.5 text-sm bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                    <x-input-error :messages="$errors->get('footerText')" class="mt-1" />
                </div>
            </div>

            <!-- 3. Homepage Content Manager -->
            <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-6 shadow-sm space-y-5">
                <h3 class="font-bold text-xs text-slate-500 uppercase tracking-wider pb-3 border-b border-slate-100 dark:border-slate-850 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">home</span>
                    Homepage Sections & Hero CMS
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="heroSubtitle" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">Hero Subtitle / Establish Tag</label>
                        <input wire:model="heroSubtitle" id="heroSubtitle" type="text"
                               class="block w-full px-4 py-2.5 text-sm bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                        <x-input-error :messages="$errors->get('heroSubtitle')" class="mt-1" />
                    </div>
                    <div>
                        <label for="heroTitle" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">Hero Main Title</label>
                        <input wire:model="heroTitle" id="heroTitle" type="text"
                               class="block w-full px-4 py-2.5 text-sm bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                        <x-input-error :messages="$errors->get('heroTitle')" class="mt-1" />
                    </div>
                </div>

                <div>
                    <label for="heroDescription" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">Hero Subtext / Description</label>
                    <textarea wire:model="heroDescription" id="heroDescription" rows="2"
                              class="block w-full px-4 py-2.5 text-sm bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250"></textarea>
                    <x-input-error :messages="$errors->get('heroDescription')" class="mt-1" />
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 border-t border-slate-100 dark:border-slate-800 pt-4">
                    <div>
                        <label for="statRecovered" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">Settlements</label>
                        <input wire:model="statRecovered" id="statRecovered" type="text"
                               class="block w-full px-3 py-2 text-xs bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                        <x-input-error :messages="$errors->get('statRecovered')" class="mt-1" />
                    </div>
                    <div>
                        <label for="statYears" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">Advocacy Years</label>
                        <input wire:model="statYears" id="statYears" type="text"
                               class="block w-full px-3 py-2 text-xs bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                        <x-input-error :messages="$errors->get('statYears')" class="mt-1" />
                    </div>
                    <div>
                        <label for="statRetention" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">Retention Rate</label>
                        <input wire:model="statRetention" id="statRetention" type="text"
                               class="block w-full px-3 py-2 text-xs bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                        <x-input-error :messages="$errors->get('statRetention')" class="mt-1" />
                    </div>
                    <div>
                        <label for="statPartners" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">Global Partners</label>
                        <input wire:model="statPartners" id="statPartners" type="text"
                               class="block w-full px-3 py-2 text-xs bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                        <x-input-error :messages="$errors->get('statPartners')" class="mt-1" />
                    </div>
                </div>

                <div class="border-t border-slate-100 dark:border-slate-800 pt-4 space-y-4">
                    <div>
                        <label for="ctaTitle" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">CTA Card Title</label>
                        <input wire:model="ctaTitle" id="ctaTitle" type="text"
                               class="block w-full px-4 py-2.5 text-sm bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                        <x-input-error :messages="$errors->get('ctaTitle')" class="mt-1" />
                    </div>
                    <div>
                        <label for="ctaDescription" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">CTA Card Description</label>
                        <textarea wire:model="ctaDescription" id="ctaDescription" rows="2"
                                  class="block w-full px-4 py-2.5 text-sm bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250"></textarea>
                        <x-input-error :messages="$errors->get('ctaDescription')" class="mt-1" />
                    </div>
                </div>
            </div>

            <!-- SMTP Server Settings -->
            <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-6 shadow-sm space-y-5">
                <h3 class="font-bold text-xs text-slate-500 uppercase tracking-wider pb-3 border-b border-slate-100 dark:border-slate-850 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">mail</span>
                    SMTP Notification Settings
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-2">
                        <label for="mailHost" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">SMTP Server Host</label>
                        <input wire:model="mailHost" id="mailHost" type="text" placeholder="smtp.mailtrap.io"
                               class="block w-full px-4 py-2.5 text-sm bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                        <x-input-error :messages="$errors->get('mailHost')" class="mt-1" />
                    </div>
                    <div>
                        <label for="mailPort" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">SMTP Port</label>
                        <input wire:model="mailPort" id="mailPort" type="number" placeholder="2525"
                               class="block w-full px-4 py-2.5 text-sm bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                        <x-input-error :messages="$errors->get('mailPort')" class="mt-1" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="mailUsername" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">SMTP Username</label>
                        <input wire:model="mailUsername" id="mailUsername" type="text"
                               class="block w-full px-4 py-2.5 text-sm bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                        <x-input-error :messages="$errors->get('mailUsername')" class="mt-1" />
                    </div>
                    <div>
                        <label for="mailPassword" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">SMTP Password</label>
                        <input wire:model="mailPassword" id="mailPassword" type="password"
                               class="block w-full px-4 py-2.5 text-sm bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                        <x-input-error :messages="$errors->get('mailPassword')" class="mt-1" />
                    </div>
                    <div>
                        <label for="mailEncryption" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">Encryption protocol</label>
                        <select wire:model="mailEncryption" id="mailEncryption"
                                class="block w-full px-3 py-2.5 text-sm bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250">
                            <option value="tls">TLS</option>
                            <option value="ssl">SSL</option>
                            <option value="null">None (Plain Text)</option>
                        </select>
                        <x-input-error :messages="$errors->get('mailEncryption')" class="mt-1" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="mailFromAddress" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">Sender Email (From)</label>
                        <input wire:model="mailFromAddress" id="mailFromAddress" type="email" placeholder="noreply@lexicore.test"
                               class="block w-full px-4 py-2.5 text-sm bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                        <x-input-error :messages="$errors->get('mailFromAddress')" class="mt-1" />
                    </div>
                    <div>
                        <label for="mailFromName" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">Sender Name (From)</label>
                        <input wire:model="mailFromName" id="mailFromName" type="text" placeholder="LexCore System"
                               class="block w-full px-4 py-2.5 text-sm bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                        <x-input-error :messages="$errors->get('mailFromName')" class="mt-1" />
                    </div>
                </div>
            </div>

            <!-- Payment Gateways Settings -->
            <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-6 shadow-sm space-y-6">
                <h3 class="font-bold text-xs text-slate-500 uppercase tracking-wider pb-3 border-b border-slate-100 dark:border-slate-850 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">credit_card</span>
                    Payment Gateways Configurations
                </h3>

                <!-- Stripe Gateway settings -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <label for="stripeEnabled" class="font-bold text-[11px] text-slate-550 uppercase tracking-wider flex items-center gap-2 cursor-pointer">
                            <input wire:model.live="stripeEnabled" id="stripeEnabled" type="checkbox" class="w-4 h-4 text-primary bg-slate-100 border-slate-300 rounded focus:ring-primary" />
                            Enable Stripe Card Payments
                        </label>
                    </div>
                    @if($stripeEnabled)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 animate-in fade-in duration-200">
                            <div>
                                <label for="stripePublishableKey" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">Stripe Publishable Key</label>
                                <input wire:model="stripePublishableKey" id="stripePublishableKey" type="text" placeholder="pk_test_..."
                                       class="block w-full px-4 py-2.5 text-sm bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                                <x-input-error :messages="$errors->get('stripePublishableKey')" class="mt-1" />
                            </div>
                            <div>
                                <label for="stripeSecretKey" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">Stripe Secret Key</label>
                                <input wire:model="stripeSecretKey" id="stripeSecretKey" type="password" placeholder="sk_test_..."
                                       class="block w-full px-4 py-2.5 text-sm bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                                <x-input-error :messages="$errors->get('stripeSecretKey')" class="mt-1" />
                            </div>
                        </div>
                    @endif
                </div>

                <!-- PayPal Gateway settings -->
                <div class="space-y-4 border-t border-slate-100 dark:border-slate-800 pt-4">
                    <div class="flex items-center justify-between">
                        <label for="paypalEnabled" class="font-bold text-[11px] text-slate-550 uppercase tracking-wider flex items-center gap-2 cursor-pointer">
                            <input wire:model.live="paypalEnabled" id="paypalEnabled" type="checkbox" class="w-4 h-4 text-primary bg-slate-100 border-slate-300 rounded focus:ring-primary" />
                            Enable PayPal Express Checkout
                        </label>
                    </div>
                    @if($paypalEnabled)
                        <div class="space-y-4 animate-in fade-in duration-200">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="paypalClientId" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">PayPal Client ID</label>
                                    <input wire:model="paypalClientId" id="paypalClientId" type="text"
                                           class="block w-full px-4 py-2.5 text-sm bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                                    <x-input-error :messages="$errors->get('paypalClientId')" class="mt-1" />
                                </div>
                                <div>
                                    <label for="paypalSecret" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">PayPal Client Secret</label>
                                    <input wire:model="paypalSecret" id="paypalSecret" type="password"
                                           class="block w-full px-4 py-2.5 text-sm bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                                    <x-input-error :messages="$errors->get('paypalSecret')" class="mt-1" />
                                </div>
                            </div>
                            <div>
                                <label for="paypalMode" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">PayPal Environment Mode</label>
                                <select wire:model="paypalMode" id="paypalMode"
                                        class="block w-full px-3 py-2.5 text-xs bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none text-slate-800 dark:text-slate-200">
                                    <option value="sandbox">Sandbox (Testing)</option>
                                    <option value="live">Live (Production)</option>
                                </select>
                                <x-input-error :messages="$errors->get('paypalMode')" class="mt-1" />
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Notification Preferences -->
            <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-6 shadow-sm space-y-5">
                <h3 class="font-bold text-xs text-slate-500 uppercase tracking-wider pb-3 border-b border-slate-100 dark:border-slate-850 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">notifications_active</span>
                    Notification Preferences
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-3">
                        <h4 class="font-bold text-[10px] text-slate-400 uppercase tracking-wider">Email Channels</h4>
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 text-xs text-slate-700 dark:text-slate-300 cursor-pointer">
                                <input wire:model="notifyCaseUpdateEmail" type="checkbox" class="w-4 h-4 text-primary bg-slate-100 border-slate-300 rounded focus:ring-primary" />
                                Case Updates / Status Changes
                            </label>
                            <label class="flex items-center gap-2 text-xs text-slate-700 dark:text-slate-300 cursor-pointer">
                                <input wire:model="notifyAppointmentBookingEmail" type="checkbox" class="w-4 h-4 text-primary bg-slate-100 border-slate-300 rounded focus:ring-primary" />
                                Appointment Consultation Bookings
                            </label>
                            <label class="flex items-center gap-2 text-xs text-slate-700 dark:text-slate-300 cursor-pointer">
                                <input wire:model="notifyInvoiceGeneratedEmail" type="checkbox" class="w-4 h-4 text-primary bg-slate-100 border-slate-300 rounded focus:ring-primary" />
                                Retainer Invoices Generated
                            </label>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <h4 class="font-bold text-[10px] text-slate-400 uppercase tracking-wider">SMS Channels</h4>
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 text-xs text-slate-700 dark:text-slate-300 cursor-pointer">
                                <input wire:model="notifyCaseUpdateSms" type="checkbox" class="w-4 h-4 text-primary bg-slate-100 border-slate-300 rounded focus:ring-primary" />
                                Case Updates / Status Changes
                            </label>
                            <label class="flex items-center gap-2 text-xs text-slate-700 dark:text-slate-300 cursor-pointer">
                                <input wire:model="notifyAppointmentBookingSms" type="checkbox" class="w-4 h-4 text-primary bg-slate-100 border-slate-300 rounded focus:ring-primary" />
                                Appointment Consultation Bookings
                            </label>
                            <label class="flex items-center gap-2 text-xs text-slate-700 dark:text-slate-300 cursor-pointer">
                                <input wire:model="notifyInvoiceGeneratedSms" type="checkbox" class="w-4 h-4 text-primary bg-slate-100 border-slate-300 rounded focus:ring-primary" />
                                Retainer Invoices Generated
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SMS Gateway Configurations -->
            <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-6 shadow-sm space-y-5">
                <h3 class="font-bold text-xs text-slate-500 uppercase tracking-wider pb-3 border-b border-slate-100 dark:border-slate-850 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">sms</span>
                    SMS Gateway Configurations (Twilio)
                </h3>

                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <label for="smsGatewayEnabled" class="font-bold text-[11px] text-slate-550 uppercase tracking-wider flex items-center gap-2 cursor-pointer">
                            <input wire:model.live="smsGatewayEnabled" id="smsGatewayEnabled" type="checkbox" class="w-4 h-4 text-primary bg-slate-100 border-slate-300 rounded focus:ring-primary" />
                            Enable Twilio Gateway
                        </label>
                    </div>

                    @if($smsGatewayEnabled)
                        <div class="space-y-4 animate-in fade-in duration-200">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="twilioSid" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">Twilio Account SID</label>
                                    <input wire:model="twilioSid" id="twilioSid" type="text" placeholder="AC..."
                                           class="block w-full px-4 py-2.5 text-sm bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                                    <x-input-error :messages="$errors->get('twilioSid')" class="mt-1" />
                                </div>
                                <div>
                                    <label for="twilioAuthToken" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">Twilio Auth Token</label>
                                    <input wire:model="twilioAuthToken" id="twilioAuthToken" type="password"
                                           class="block w-full px-4 py-2.5 text-sm bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                                    <x-input-error :messages="$errors->get('twilioAuthToken')" class="mt-1" />
                                </div>
                            </div>
                            <div>
                                <label for="twilioFromNumber" class="font-semibold text-xs text-slate-500 block mb-1.5 uppercase tracking-wider text-[10px]">Twilio From Number (Sender ID)</label>
                                <input wire:model="twilioFromNumber" id="twilioFromNumber" type="text" placeholder="+1..."
                                       class="block w-full px-4 py-2.5 text-sm bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250" />
                                <x-input-error :messages="$errors->get('twilioFromNumber')" class="mt-1" />
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- SMS Templates Manager -->
            <div class="bg-white dark:bg-[#1e293b] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 p-6 shadow-sm space-y-5">
                <h3 class="font-bold text-xs text-slate-500 uppercase tracking-wider pb-3 border-b border-slate-100 dark:border-slate-850 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">quick_reference_all</span>
                    SMS Notification Templates
                </h3>

                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <label for="smsTemplateAppointment" class="font-semibold text-xs text-slate-500 uppercase tracking-wider text-[10px]">Appointment Booked Template</label>
                            <span class="text-[9px] text-slate-400 font-mono">Placeholders: {client_name}, {appointment_date}</span>
                        </div>
                        <textarea wire:model="smsTemplateAppointment" id="smsTemplateAppointment" rows="2"
                                  class="block w-full px-4 py-2.5 text-xs font-mono bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250"></textarea>
                        <x-input-error :messages="$errors->get('smsTemplateAppointment')" class="mt-1" />
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <label for="smsTemplateInvoice" class="font-semibold text-xs text-slate-500 uppercase tracking-wider text-[10px]">Invoice Generated Template</label>
                            <span class="text-[9px] text-slate-400 font-mono">Placeholders: {client_name}, {invoice_number}, {invoice_total}</span>
                        </div>
                        <textarea wire:model="smsTemplateInvoice" id="smsTemplateInvoice" rows="2"
                                  class="block w-full px-4 py-2.5 text-xs font-mono bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250"></textarea>
                        <x-input-error :messages="$errors->get('smsTemplateInvoice')" class="mt-1" />
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <label for="smsTemplateCase" class="font-semibold text-xs text-slate-500 uppercase tracking-wider text-[10px]">Case Updated Template</label>
                            <span class="text-[9px] text-slate-400 font-mono">Placeholders: {client_name}, {case_number}, {case_status}</span>
                        </div>
                        <textarea wire:model="smsTemplateCase" id="smsTemplateCase" rows="2"
                                  class="block w-full px-4 py-2.5 text-xs font-mono bg-white border border-slate-200 dark:border-slate-800 dark:bg-slate-900/65 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-850 dark:text-slate-250"></textarea>
                        <x-input-error :messages="$errors->get('smsTemplateCase')" class="mt-1" />
                    </div>
                </div>
            </div>

            <!-- 4. Legal pages content -->
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
