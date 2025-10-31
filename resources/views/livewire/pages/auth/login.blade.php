<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('.layouts.guest')] class extends Component
{
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();
        $this->form->authenticate();
        Session::regenerate();
        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
};
?>

<div class="flex flex-col items-center justify-center min-h-screen bg-gradient-to-br from-blue-50 to-blue-100 px-4 py-8">
    
    <div class="w-full sm:max-w-md bg-white shadow-xl rounded-2xl p-6 border border-gray-100">
        
        <div class="flex flex-col items-center mb-4">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo SIMTU" class="w-16 mb-3">
            <h2 class="text-2xl font-semibold text-gray-700">Masuk ke Akun Anda</h2>
            <p class="text-sm text-gray-500 mt-1">Selamat datang kembali di <strong>SIMTU IDN</strong></p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form wire:submit="login">
            <!-- Email or NIM -->
            <div>
                <x-input-label for="login" :value="__('Email atau NIM')" />
                <x-text-input wire:model="form.login" id="login" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg" type="text" name="login" required autofocus autocomplete="username" placeholder="contoh@email.com atau NIM" />
                <x-input-error :messages="$errors->get('form.login')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Kata Sandi')" />
                <x-text-input wire:model="form.password" id="password" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember" class="inline-flex items-center">
                    <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Ingat saya') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a wire:navigate class="text-sm text-blue-600 hover:text-blue-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 font-medium" href="{{ route('password.request') }}" wire:navigate>
                        {{ __('Lupa password?') }}
                    </a>
                @endif

                <button type="submit" class="ms-3 py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition duration-150 ease-in-out">
                    {{ __('Masuk') }}
                </button>
            </div>

            <!-- Link ke Register -->
            @if (Route::has('register'))
                <div class="block mt-4 pt-4 border-t border-gray-200">
                    <p class="text-center text-gray-500 text-sm">
                        Belum punya akun?
                        <a wire:navigate href="{{ route('register') }}" wire:navigate class="text-blue-600 hover:text-blue-700 font-semibold">
                            Daftar di sini
                        </a>
                    </p>
                </div>
            @endif
        </form>
    </div>

    <p class="mt-6 text-gray-400 text-xs">
        © {{ date('Y') }} SIMTU IDN. All Rights Reserved.
    </p>
</div>