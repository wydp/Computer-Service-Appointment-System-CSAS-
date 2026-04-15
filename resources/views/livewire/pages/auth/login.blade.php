<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;
    public bool $showPassword = false;

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

    public function togglePassword(): void
    {
        $this->showPassword = !$this->showPassword;
    }
}; ?>

<div style="width: 100%;">
    <!-- Session Status -->
    @if (session('status'))
        <div style="background: #00AA00; color: #FFFFFF; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; font-weight: 500; display: flex; align-items: center; gap: 12px;">
            <svg style="width: 18px; height: 18px; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('status') }}
        </div>
    @endif

    <form wire:submit="login" class="space-y-5">
        <!-- Email Address -->
        <div>
            <label for="email" style="display: block; font-size: 12px; font-weight: 600; color: #000000; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.05em;">
                {{ __('Email Address') }}
            </label>
            <div style="position: relative;">
                <input
                    wire:model="form.email"
                    id="email"
                    type="email"
                    name="email"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="you@example.com"
                    style="width: 100%; padding: 11px 14px; border: 1.5px solid #D5D5D5; border-radius: 8px; font-size: 14px; font-weight: 400; background: #FFFFFF; color: #000000; outline: none; transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);"
                    onfocus="this.style.borderColor='#000000'; this.style.boxShadow='0 0 0 3px rgba(0, 0, 0, 0.04)'"
                    onblur="this.style.borderColor='#D5D5D5'; this.style.boxShadow='none'"
                />
                <svg style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: #999999; pointer-events: none;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            @error('form.email')
                <p style="color: #CC0000; font-size: 12px; margin-top: 6px; display: flex; align-items: center; gap: 6px; font-weight: 500;">
                    <svg style="width: 14px; height: 14px;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18.101 12.93a.75.75 0 00-1.06 1.061L18.04 16l-1.939-1.939a.75.75 0 00-1.06 1.061L17.94 17.06 16 19a.75.75 0 101.06 1.061l2-2a.75.75 0 .061-1.06l-2-2zm2-2.5a.75.75 0 00-1.06-1.061l-2 2a.75.75 0 101.06 1.06l2-2z" clip-rule="evenodd"/></path></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" style="display: block; font-size: 12px; font-weight: 600; color: #000000; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.05em;">
                {{ __('Password') }}
            </label>
            <div style="position: relative;">
                <input
                    wire:model="form.password"
                    id="password"
                    type="{{ $showPassword ? 'text' : 'password' }}"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Enter your password"
                    style="width: 100%; padding: 11px 14px; padding-right: 44px; border: 1.5px solid #D5D5D5; border-radius: 8px; font-size: 14px; font-weight: 400; background: #FFFFFF; color: #000000; outline: none; transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);"
                    onfocus="this.style.borderColor='#000000'; this.style.boxShadow='0 0 0 3px rgba(0, 0, 0, 0.04)'"
                    onblur="this.style.borderColor='#D5D5D5'; this.style.boxShadow='none'"
                />
                <button
                    type="button"
                    wire:click="togglePassword"
                    style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; width: 24px; height: 24px; color: #999999; padding: 0; transition: color 0.2s;"
                    title="Toggle password visibility"
                    onmouseover="this.style.color='#666666'"
                    onmouseout="this.style.color='#999999'"
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
            @error('form.password')
                <p style="color: #CC0000; font-size: 12px; margin-top: 6px; display: flex; align-items: center; gap: 6px; font-weight: 500;">
                    <svg style="width: 14px; height: 14px;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18.101 12.93a.75.75 0 00-1.06 1.061L18.04 16l-1.939-1.939a.75.75 0 00-1.06 1.061L17.94 17.06 16 19a.75.75 0 101.06 1.061l2-2a.75.75 0 .061-1.06l-2-2zm2-2.5a.75.75 0 00-1.06-1.061l-2 2a.75.75 0 101.06 1.06l2-2z" clip-rule="evenodd"/></path></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div style="display: flex; align-items: center; margin-top: 16px;">
            <input
                wire:model="form.remember"
                id="remember"
                type="checkbox"
                name="remember"
                style="width: 16px; height: 16px; cursor: pointer; accent-color: #000000; border: 1.5px solid #D5D5D5; border-radius: 6px;"
            />
            <label for="remember" style="margin-left: 10px; font-size: 13px; color: #666666; cursor: pointer; user-select: none;">
                {{ __('Remember me') }}
            </label>
        </div>

        <!-- Actions -->
        <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 28px; padding-top: 20px; border-top: 1px solid #E5E5E5;">
            @if (Route::has('password.request'))
                <a
                    href="{{ route('password.request') }}"
                    wire:navigate
                    style="font-size: 13px; color: #000000; text-decoration: none; font-weight: 500; transition: all 0.2s;"
                    onmouseover="this.style.color='#666666'; this.style.textDecoration='underline'"
                    onmouseout="this.style.color='#000000'; this.style.textDecoration='none'"
                >
                    {{ __('Forgot password?') }}
                </a>
            @else
                <div></div>
            @endif

            <button
                type="submit"
                style="padding: 10px 28px; background: #000000; color: #FFFFFF; border: 2px solid #000000; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); text-transform: uppercase; letter-spacing: 0.05em; display: inline-flex; align-items: center; gap: 8px;"
                wire:loading.attr="disabled"
                onmouseover="this.style.background='#2D2D2D'; this.style.borderColor='#2D2D2D'; this.style.boxShadow='0 4px 12px rgba(0, 0, 0, 0.15)'"
                onmouseout="this.style.background='#000000'; this.style.borderColor='#000000'; this.style.boxShadow='none'"
            >
                <span wire:loading.remove>
                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    {{ __('Sign In') }}
                </span>
                <span wire:loading style="display: inline-block; width: 14px; height: 14px; border: 2px solid rgba(255, 255, 255, 0.3); border-top-color: #FFFFFF; border-radius: 50%; animation: spin 0.8s linear infinite;"></span>
            </button>
        </div>
    </form>
</div>

<style>
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>
