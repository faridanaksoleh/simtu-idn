<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

// Pastikan layout me-render { $slot } saja
new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}; ?>

<div class="flex flex-col items-center justify-center min-h-screen bg-gradient-to-br from-blue-50 to-blue-100 px-4 py-8">
    
    <div class="w-full sm:max-w-md bg-white shadow-xl rounded-2xl p-6 border border-gray-100">
        
        <div class="flex flex-col items-center mb-4">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo SIMTU" class="w-16 mb-3">
            <h2 class="text-2xl font-semibold text-gray-700">Lupa Password</h2>
        </div>

        <div class="mb-4 text-sm text-gray-600 text-center">
            {{ __('Lupa password Anda? Tidak masalah. Beri tahu kami alamat email Anda dan kami akan mengirimkan link reset password.') }}
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form wire:submit="sendPasswordResetLink">
            <div>
                <x-input-label for="email" :value="__('Alamat Email')" />
                
                <x-text-input 
                    wire:model="email" 
                    id="email" 
                    class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg" 
                    type="email" 
                    name="email" 
                    required 
                    autofocus 
                    placeholder="contoh@email.com" 
                />
                
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <button type="submit" class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition duration-150 ease-in-out">
                    {{ __('Kirim Link Reset Password') }}
                </button>
            </div>

            <div class="block mt-4 pt-4 border-t border-gray-200">
                <p class="text-center text-gray-500 text-sm">
                    Sudah ingat password?
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