<div class="w-full max-w-lg mx-auto bg-slate-900/60 backdrop-blur-md rounded-3xl p-8 border border-white/10 shadow-2xl space-y-6">
    <!-- Header -->
    <div class="text-center space-y-2">
        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-500 mb-2">
            <span class="material-symbols-outlined text-[28px]" style="font-variation-settings: 'FILL' 1;">balance</span>
        </div>
        <h2 class="text-2xl font-bold text-white tracking-tight">LexCore Installation</h2>
        <p class="text-xs text-slate-400">Step {{ $step }} of 5: 
            @if($step === 1) License Verification
            @elseif($step === 2) Server Requirements
            @elseif($step === 3) Database Configuration
            @elseif($step === 4) Admin Account
            @else Finished
            @endif
        </p>
    </div>

    <!-- Progress Steps Tracker -->
    <div class="flex justify-between items-center px-4">
        @for($i = 1; $i <= 5; $i++)
            <div class="flex items-center">
                <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-300 
                    {{ $step === $i ? 'bg-amber-500 text-slate-950 font-black scale-110 shadow-md shadow-amber-500/20' : ($step > $i ? 'bg-emerald-500 text-white' : 'bg-slate-800 text-slate-500 border border-slate-700') }}">
                    @if($step > $i)
                        <span class="material-symbols-outlined text-sm font-bold">check</span>
                    @else
                        {{ $i }}
                    @endif
                </div>
                @if($i < 5)
                    <div class="w-8 sm:w-12 h-0.5 transition-all duration-300 {{ $step > $i ? 'bg-emerald-500' : 'bg-slate-800' }}"></div>
                @endif
            </div>
        @endfor
    </div>

    <!-- Step Content -->
    <div class="mt-6 space-y-4">
        <!-- Step 1: License Verification -->
        @if($step === 1)
            <div class="space-y-4">
                <div class="p-4 bg-slate-850 rounded-2xl border border-slate-800 text-xs text-slate-300 leading-relaxed">
                    Welcome to LexCore! To begin the installation, please verify your CodeCanyon purchase code. A valid license guarantees product authenticity and access to official updates.
                </div>

                <form wire:submit="verifyLicense" class="space-y-4">
                    <div>
                        <x-input-label for="envatoUsername" value="Envato Username" class="text-slate-300" />
                        <x-text-input wire:model="envatoUsername" id="envatoUsername" type="text" class="block w-full mt-1 bg-slate-950 border-slate-800 text-white focus:border-amber-500 focus:ring-amber-500/20" placeholder="e.g. envato_buyer" required autofocus />
                        <x-input-error :messages="$errors->get('envatoUsername')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="purchaseCode" value="Envato Purchase Code" class="text-slate-300" />
                        <x-text-input wire:model="purchaseCode" id="purchaseCode" type="text" class="block w-full mt-1 bg-slate-950 border-slate-800 text-white font-mono text-xs focus:border-amber-500 focus:ring-amber-500/20" placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx" required />
                        <x-input-error :messages="$errors->get('purchaseCode')" class="mt-1" />
                    </div>

                    <x-primary-button class="w-full justify-center bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold py-2.5">
                        Verify & Continue
                    </x-primary-button>
                </form>
            </div>
        @endif

        <!-- Step 2: Server Requirements -->
        @if($step === 2)
            <div class="space-y-4">
                <div class="space-y-3">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">PHP Extensions Audit</h3>
                    <div class="grid grid-cols-1 gap-2">
                        @foreach($requirements as $name => $passed)
                            <div class="flex justify-between items-center p-3 bg-slate-950 rounded-xl border border-slate-850">
                                <span class="text-xs font-semibold text-slate-300">{{ $name }}</span>
                                <span class="flex items-center gap-1.5 text-[11px] {{ $passed ? 'text-emerald-400' : 'text-rose-400' }}">
                                    <span class="material-symbols-outlined text-[16px]">{{ $passed ? 'check_circle' : 'cancel' }}</span>
                                    {{ $passed ? 'Passed' : 'Failed' }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="space-y-3">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Directory Permissions</h3>
                    <div class="grid grid-cols-1 gap-2">
                        @foreach($permissions as $name => $passed)
                            <div class="flex justify-between items-center p-3 bg-slate-950 rounded-xl border border-slate-850">
                                <span class="text-xs font-semibold text-slate-300">{{ $name }} (Writable)</span>
                                <span class="flex items-center gap-1.5 text-[11px] {{ $passed ? 'text-emerald-400' : 'text-rose-400' }}">
                                    <span class="material-symbols-outlined text-[16px]">{{ $passed ? 'check_circle' : 'cancel' }}</span>
                                    {{ $passed ? 'Passed' : 'Failed' }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

                @if($errors->has('requirements'))
                    <div class="p-3 bg-rose-500/10 text-rose-400 text-xs rounded-xl border border-rose-500/20">
                        {{ $errors->first('requirements') }}
                    </div>
                @endif

                <x-primary-button wire:click="proceedToDatabase" class="w-full justify-center bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold py-2.5">
                    Configure Database
                </x-primary-button>
            </div>
        @endif

        <!-- Step 3: Database Configuration -->
        @if($step === 3)
            <div class="space-y-4">
                <form wire:submit="verifyDatabase" class="space-y-4">
                    <div>
                        <x-input-label for="dbConnection" value="Database Connection Driver" class="text-slate-300" />
                        <select wire:model.live="dbConnection" id="dbConnection" class="block w-full mt-1 bg-slate-950 border-slate-800 text-white rounded-xl focus:border-amber-500 focus:ring-amber-500/20 text-xs py-2 px-3">
                            <option value="sqlite">SQLite</option>
                            <option value="mysql">MySQL</option>
                        </select>
                    </div>

                    @if($dbConnection === 'sqlite')
                        <div>
                            <x-input-label for="dbDatabase" value="Database File Path" class="text-slate-300" />
                            <x-text-input wire:model="dbDatabase" id="dbDatabase" type="text" class="block w-full mt-1 bg-slate-950 border-slate-800 text-white text-xs" required />
                            <x-input-error :messages="$errors->get('dbDatabase')" class="mt-1" />
                        </div>
                    @else
                        <div class="grid grid-cols-3 gap-3">
                            <div class="col-span-2">
                                <x-input-label for="dbHost" value="Host IP" class="text-slate-300" />
                                <x-text-input wire:model="dbHost" id="dbHost" type="text" class="block w-full mt-1 bg-slate-950 border-slate-800 text-white text-xs" required />
                            </div>
                            <div>
                                <x-input-label for="dbPort" value="Port" class="text-slate-300" />
                                <x-text-input wire:model="dbPort" id="dbPort" type="text" class="block w-full mt-1 bg-slate-950 border-slate-800 text-white text-xs" required />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="dbDatabase" value="Database Name" class="text-slate-300" />
                            <x-text-input wire:model="dbDatabase" id="dbDatabase" type="text" class="block w-full mt-1 bg-slate-950 border-slate-800 text-white text-xs" required />
                            <x-input-error :messages="$errors->get('dbDatabase')" class="mt-1" />
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <x-input-label for="dbUsername" value="Username" class="text-slate-300" />
                                <x-text-input wire:model="dbUsername" id="dbUsername" type="text" class="block w-full mt-1 bg-slate-950 border-slate-800 text-white text-xs" required />
                            </div>
                            <div>
                                <x-input-label for="dbPassword" value="Password" class="text-slate-300" />
                                <x-text-input wire:model="dbPassword" id="dbPassword" type="password" class="block w-full mt-1 bg-slate-950 border-slate-800 text-white text-xs" />
                            </div>
                        </div>
                    @endif

                    @if($errors->has('database'))
                        <div class="p-3 bg-rose-500/10 text-rose-400 text-xs rounded-xl border border-rose-500/20 leading-normal">
                            {{ $errors->first('database') }}
                        </div>
                    @endif

                    <x-primary-button class="w-full justify-center bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold py-2.5">
                        Test Connection & Next
                    </x-primary-button>
                </form>
            </div>
        @endif

        <!-- Step 4: Admin Account Setup -->
        @if($step === 4)
            <div class="space-y-4">
                <div class="p-4 bg-slate-850 rounded-2xl border border-slate-800 text-xs text-slate-300 leading-relaxed">
                    Set up your super-administrator credentials. Clicking "Run Installation" will dynamically run migrations, seed permissions/roles, and generate default law firm content.
                </div>

                <form wire:submit="runInstall" class="space-y-4">
                    <div>
                        <x-input-label for="adminName" value="Administrator Name" class="text-slate-300" />
                        <x-text-input wire:model="adminName" id="adminName" type="text" class="block w-full mt-1 bg-slate-950 border-slate-800 text-white text-xs" placeholder="e.g. John Doe" required autofocus />
                        <x-input-error :messages="$errors->get('adminName')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="adminEmail" value="Email Address" class="text-slate-300" />
                        <x-text-input wire:model="adminEmail" id="adminEmail" type="email" class="block w-full mt-1 bg-slate-950 border-slate-800 text-white text-xs" placeholder="admin@myfirm.com" required />
                        <x-input-error :messages="$errors->get('adminEmail')" class="mt-1" />
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <x-input-label for="adminPassword" value="Password" class="text-slate-300" />
                            <x-text-input wire:model="adminPassword" id="adminPassword" type="password" class="block w-full mt-1 bg-slate-950 border-slate-800 text-white text-xs" required />
                            <x-input-error :messages="$errors->get('adminPassword')" class="mt-1" />
                        </div>
                        <div>
                            <x-input-label for="adminPasswordConfirmation" value="Confirm Password" class="text-slate-300" />
                            <x-text-input wire:model="adminPasswordConfirmation" id="adminPasswordConfirmation" type="password" class="block w-full mt-1 bg-slate-950 border-slate-800 text-white text-xs" required />
                        </div>
                    </div>

                    @if($errors->has('install'))
                        <div class="p-3 bg-rose-500/10 text-rose-400 text-xs rounded-xl border border-rose-500/20 leading-normal">
                            {{ $errors->first('install') }}
                        </div>
                    @endif

                    <x-primary-button class="w-full justify-center bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold py-2.5">
                        Run Installation
                    </x-primary-button>
                </form>
            </div>
        @endif

        <!-- Step 5: Completed -->
        @if($step === 5)
            <div class="space-y-6 text-center py-4">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-500 mb-2">
                    <span class="material-symbols-outlined text-[36px]" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                </div>

                <div class="space-y-2">
                    <h3 class="text-xl font-bold text-white">Installation Successful!</h3>
                    <p class="text-xs text-slate-400 max-w-sm mx-auto leading-relaxed">
                        LexCore is fully configured and ready. Database migrations have been compiled, permissions seeded, and lock parameters written to your `.env` repository.
                    </p>
                </div>

                <a href="{{ route('login') }}" class="inline-flex items-center justify-center w-full bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold py-2.5 rounded-xl transition-all shadow-md text-xs uppercase tracking-widest">
                    Go to Portal Login
                </a>
            </div>
        @endif
    </div>
</div>
