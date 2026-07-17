<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-5">
        <!-- Email Address -->
        <div>
            <label for="email" class="font-semibold text-xs text-slate-500 uppercase tracking-wider mb-1.5 block">Email Address</label>
            <input wire:model="form.email" id="email" 
                   class="block w-full px-4 py-2.5 text-sm bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-800" 
                   type="email" name="email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center mb-1.5">
                <label for="password" class="font-semibold text-xs text-slate-500 uppercase tracking-wider block">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-xs text-primary hover:underline font-semibold" href="{{ route('password.request') }}" wire:navigate>
                        Forgot?
                    </a>
                @endif
            </div>
            <input wire:model="form.password" id="password" 
                   class="block w-full px-4 py-2.5 text-sm bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-slate-800" 
                   type="password"
                   name="password"
                   required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('form.password')" class="mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember" class="inline-flex items-center cursor-pointer">
                <input wire:model="form.remember" id="remember" type="checkbox" 
                       class="rounded border-slate-300 text-primary focus:ring-primary shadow-sm" name="remember">
                <span class="ms-2 text-xs font-medium text-slate-500">{{ __('Remember my credentials') }}</span>
            </label>
        </div>

        <div>
            <button type="submit" class="w-full bg-primary text-white font-semibold text-sm py-3 rounded-xl hover:opacity-90 active:scale-98 transition-all shadow-md shadow-indigo-900/10 flex items-center justify-center gap-1.5">
                <span class="material-symbols-outlined text-[18px]">login</span>
                {{ __('Access Portal') }}
            </button>
        </div>
    </form>
</div>
