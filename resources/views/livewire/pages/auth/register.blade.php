<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public bool $showPassword = false;

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }

    public function togglePassword(): void
    {
        $this->showPassword = !$this->showPassword;
    }
}; ?>

<div>
    <form wire:submit="register" class="space-y-5">
        <!-- Name -->
        <div>
            <label for="name" style="display: block; font-size: 13px; font-weight: 600; color: #1A1A1A; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.05em;">
                {{ __('Full Name') }}
            </label>
            <div style="position: relative;">
                <input
                    wire:model="name"
                    id="name"
                    type="text"
                    name="name"
                    required
                    autofocus
                    autocomplete="name"
                    class="input-gradient"
                    placeholder="John Doe"
                    style="width: 100%; padding: 10px 14px; border: 2px solid #D5D5D5; border-radius: 10px; font-size: 14px; transition: all 0.2s;"
                />
                <svg style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: #6B7280; pointer-events: none;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            @error('name')
                <p style="color: #DC2626; font-size: 12px; margin-top: 6px;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" style="display: block; font-size: 13px; font-weight: 600; color: #1A1A1A; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.05em;">
                {{ __('Email Address') }}
            </label>
            <div style="position: relative;">
                <input
                    wire:model="email"
                    id="email"
                    type="email"
                    name="email"
                    required
                    autocomplete="username"
                    class="input-gradient"
                    placeholder="your@email.com"
                    style="width: 100%; padding: 10px 14px; border: 2px solid #D5D5D5; border-radius: 10px; font-size: 14px; transition: all 0.2s;"
                />
                <svg style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: #6B7280; pointer-events: none;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            @error('email')
                <p style="color: #DC2626; font-size: 12px; margin-top: 6px;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" style="display: block; font-size: 13px; font-weight: 600; color: #1A1A1A; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.05em;">
                {{ __('Password') }}
            </label>
            <div style="position: relative;">
                <input
                    wire:model="password"
                    id="password"
                    type="{{ $showPassword ? 'text' : 'password' }}"
                    name="password"
                    required
                    autocomplete="new-password"
                    class="input-gradient"
                    placeholder="••••••••"
                    style="width: 100%; padding: 10px 14px; padding-right: 44px; border: 2px solid #D5D5D5; border-radius: 10px; font-size: 14px; transition: all 0.2s;"
                />
                <button
                    type="button"
                    wire:click="togglePassword"
                    style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; width: 24px; height: 24px; color: #6B7280; padding: 0;"
                    title="Toggle password visibility"
                >
                    @if ($showPassword)
                        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    @else
                        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-4.803m5.596-3.856a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18"/>
                        </svg>
                    @endif
                </button>
            </div>
            @error('password')
                <p style="color: #DC2626; font-size: 12px; margin-top: 6px;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" style="display: block; font-size: 13px; font-weight: 600; color: #1A1A1A; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.05em;">
                {{ __('Confirm Password') }}
            </label>
            <div style="position: relative;">
                <input
                    wire:model="password_confirmation"
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    class="input-gradient"
                    placeholder="••••••••"
                    style="width: 100%; padding: 10px 14px; border: 2px solid #D5D5D5; border-radius: 10px; font-size: 14px; transition: all 0.2s;"
                />
                <svg style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: #6B7280; pointer-events: none;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            @error('password_confirmation')
                <p style="color: #DC2626; font-size: 12px; margin-top: 6px;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Actions -->
        <div style="display: flex; items-center: justify-between; margin-top: 24px; padding-top: 12px; border-top: 1px solid #E5E5E5;">
            <a
                href="{{ route('login') }}"
                wire:navigate
                style="font-size: 13px; color: #2D2D2D; text-decoration: none; font-weight: 500; transition: all 0.2s;"
                onmouseover="this.style.color='#666666'"
                onmouseout="this.style.color='#2D2D2D'"
            >
                {{ __('Already registered?') }}
            </a>

            <button
                type="submit"
                class="btn-gradient-primary"
                style="display: inline-flex; align-items: center; gap: 8px;"
                wire:loading.attr="disabled"
            >
                <span wire:loading.remove>
                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    {{ __('Create Account') }}
                </span>
                <span wire:loading class="spinner-gold"></span>
            </button>
        </div>
    </form>
</div>
