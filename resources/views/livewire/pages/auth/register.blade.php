<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('.layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

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
}; ?>

<div class="flex flex-col items-center justify-center min-h-screen bg-gradient-to-br from-blue-50 to-blue-100 px-4 py-8">
    
    <div class="w-full sm:max-w-md bg-white shadow-xl rounded-2xl p-6 border border-gray-100">
        
        <div class="flex flex-col items-center mb-4">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo SIMTU" class="w-16 mb-3">
            <h2 class="text-2xl font-semibold text-gray-700">Buat Akun Baru</h2>
            <p class="text-sm text-gray-500 mt-1">Bergabunglah dengan <strong>SIMTU IDN</strong></p>
        </div>

        <form wire:submit="register">
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Nama Lengkap')" />
                <x-text-input wire:model="name" id="name" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg" type="text" name="name" required autofocus autocomplete="name" placeholder="Masukkan nama lengkap" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Alamat Email')" />
                <x-text-input wire:model="email" id="email" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg" type="email" name="email" required autocomplete="username" placeholder="contoh@email.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Kata Sandi')" />
                <x-text-input wire:model="password" id="password" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg"
                            type="password"
                            name="password"
                            required autocomplete="new-password" 
                            placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" />
                <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg"
                            type="password"
                            name="password_confirmation" 
                            required autocomplete="new-password"
                            placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="text-sm text-blue-600 hover:text-blue-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 font-medium" href="{{ route('login') }}" wire:navigate>
                    {{ __('Sudah punya akun?') }}
                </a>

                <button type="submit" class="ms-3 py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition duration-150 ease-in-out">
                    {{ __('Daftar') }}
                </button>
            </div>

            <!-- Link ke Login -->
            <div class="block mt-4 pt-4 border-t border-gray-200">
                <p class="text-center text-gray-500 text-sm">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" wire:navigate class="text-blue-600 hover:text-blue-700 font-semibold">
                        Masuk di sini
                    </a>
                </p>
            </div>
        </form>
    </div>

    <p class="mt-6 text-gray-400 text-xs">
        © {{ date('Y') }} SIMTU IDN. All Rights Reserved.
    </p>
</div>