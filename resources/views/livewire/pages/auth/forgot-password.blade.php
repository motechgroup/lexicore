<?php

use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Services\SmsService;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';
    public string $phone = '';
    public string $method = 'email'; // 'email' or 'sms'
    public string $code = '';
    public string $password = '';
    public string $password_confirmation = '';
    public bool $codeSent = false;

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        if ($this->method === 'email') {
            $this->validate([
                'email' => ['required', 'string', 'email'],
            ]);

            $status = Password::sendResetLink(
                $this->only('email')
            );

            if ($status != Password::RESET_LINK_SENT) {
                $this->addError('email', __($status));
                return;
            }

            $this->reset('email');
            session()->flash('status', __($status));
        } else {
            $this->sendSmsVerificationCode();
        }
    }

    /**
     * Send a verification code to the provided phone number.
     */
    public function sendSmsVerificationCode(): void
    {
        $this->validate([
            'phone' => ['required', 'string', 'min:7', 'max:20'],
        ]);

        $user = User::where('phone', $this->phone)->first();

        if (!$user) {
            $this->addError('phone', __('No registered user found with this phone number.'));
            return;
        }

        // Generate a 6-digit random code
        $verificationCode = (string) rand(100000, 999999);

        // Store verification code in cache for 10 minutes
        Cache::put('sms_reset_' . $this->phone, [
            'code' => $verificationCode,
            'user_id' => $user->id,
        ], now()->addMinutes(10));

        // Dispatch SMS
        $smsService = new SmsService();
        $sent = $smsService->send(
            $this->phone,
            "Your LexCore password verification code is: {$verificationCode}. This code expires in 10 minutes."
        );

        if (!$sent) {
            $this->addError('phone', __('Failed to dispatch verification code via Twilio SMS gateway.'));
            return;
        }

        $this->codeSent = true;
        session()->flash('status', __('Verification code successfully sent via SMS.'));
    }

    /**
     * Reset the user's password using the verified code.
     */
    public function resetPasswordViaSms(): void
    {
        $this->validate([
            'code' => ['required', 'string', 'size:6'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $cached = Cache::get('sms_reset_' . $this->phone);

        if (!$cached || $cached['code'] !== $this->code) {
            $this->addError('code', __('Invalid or expired verification code.'));
            return;
        }

        $user = User::find($cached['user_id']);

        if (!$user) {
            $this->addError('code', __('User account not found.'));
            return;
        }

        // Update password
        $user->update([
            'password' => Hash::make($this->password),
        ]);

        // Clear cache
        Cache::forget('sms_reset_' . $this->phone);

        session()->flash('status', __('Password reset successful! Please log in.'));
        $this->redirectRoute('login');
    }
}; ?>

<div>
    <div class="mb-6 flex justify-center border-b border-outline-variant">
        <button type="button" 
            wire:click="$set('method', 'email')" 
            class="pb-2 px-4 text-xs font-bold transition-all border-b-2 {{ $method === 'email' ? 'border-primary text-primary' : 'border-transparent text-slate-400 hover:text-slate-650' }}">
            Reset via Email (SMTP)
        </button>
        <button type="button" 
            wire:click="$set('method', 'sms')" 
            class="pb-2 px-4 text-xs font-bold transition-all border-b-2 {{ $method === 'sms' ? 'border-primary text-primary' : 'border-transparent text-slate-400 hover:text-slate-650' }}">
            Reset via SMS (Twilio)
        </button>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    @if ($method === 'email')
        <div class="mb-4 text-xs text-on-surface-variant leading-relaxed">
            {{ __('Forgot your password? Enter your email address below, and we will email you a password reset link to choose a new one.') }}
        </div>

        <form wire:submit="sendPasswordResetLink" class="space-y-4">
            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button>
                    {{ __('Email Reset Link') }}
                </x-primary-button>
            </div>
        </form>
    @else
        @if (!$codeSent)
            <div class="mb-4 text-xs text-on-surface-variant leading-relaxed">
                {{ __('Forgot your password? Enter your registered phone number below, and we will send you a 6-digit verification code via Twilio SMS.') }}
            </div>

            <form wire:submit="sendSmsVerificationCode" class="space-y-4">
                <!-- Phone Number -->
                <div>
                    <x-input-label for="phone" :value="__('Phone Number')" />
                    <x-text-input wire:model="phone" id="phone" class="block mt-1 w-full" type="text" name="phone" placeholder="+15550192834" required autofocus />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button>
                        {{ __('Send Verification Code') }}
                    </x-primary-button>
                </div>
            </form>
        @else
            <div class="mb-4 text-xs text-on-surface-variant leading-relaxed">
                {{ __('We sent a 6-digit verification code to your phone number. Enter the code and your new password below.') }}
            </div>

            <form wire:submit="resetPasswordViaSms" class="space-y-4">
                <!-- Verification Code -->
                <div>
                    <x-input-label for="code" :value="__('Verification Code')" />
                    <x-text-input wire:model="code" id="code" class="block mt-1 w-full font-mono text-center tracking-widest" type="text" name="code" placeholder="123456" required autofocus />
                    <x-input-error :messages="$errors->get('code')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('New Password')" />
                    <x-text-input wire:model="password" id="password" class="block mt-1 w-full" type="password" name="password" required />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button>
                        {{ __('Reset Password') }}
                    </x-primary-button>
                </div>
            </form>
        @endif
    @endif
</div>
