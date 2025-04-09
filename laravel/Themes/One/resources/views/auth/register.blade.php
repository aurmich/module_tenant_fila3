@php
$title = 'Registrazione - Salute ORAle';
@endphp

<x-layouts.marketing :title="$title">
    <div class="wave-bg min-h-screen flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        {{-- Onde decorative --}}
        <div class="wave w-96 h-96 -left-20 bottom-20 transform rotate-45"></div>
        <div class="wave w-80 h-80 right-10 bottom-36 transform -rotate-12"></div>
        <div class="wave w-64 h-64 left-10 bottom-40 transform rotate-30"></div>

        {{-- Punti luminosi --}}
        <div class="absolute bottom-1/4 right-1/3 w-3 h-3 bg-blue-300 rounded-full blur-sm"></div>
        <div class="absolute bottom-1/5 left-1/3 w-2 h-2 bg-blue-300 rounded-full blur-sm"></div>

        {{-- Logo e Titolo --}}
        <div class="text-white text-center z-10 mb-8">
            <h1 class="logo-text text-4xl sm:text-5xl tracking-wider mb-2">
                <span>S</span>ALUTE <span>O</span>RA<span class="orale-text text-3xl sm:text-4xl">le</span>
            </h1>
            <p class="text-blue-200 text-lg">Crea il tuo account</p>
        </div>

        {{-- Form di Registrazione --}}
        <div class="w-full max-w-md bg-white/10 backdrop-blur-sm rounded-lg shadow-xl p-8 z-10">
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                {{-- Nome --}}
                <div>
                    <x-input-label for="name" :value="__('Nome')" class="text-white" />
                    <x-text-input id="name" class="block mt-1 w-full bg-white/20 text-white placeholder-blue-200" type="text" name="name" :value="old('name')" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                {{-- Email --}}
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-white" />
                    <x-text-input id="email" class="block mt-1 w-full bg-white/20 text-white placeholder-blue-200" type="email" name="email" :value="old('email')" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                {{-- Password --}}
                <div>
                    <x-input-label for="password" :value="__('Password')" class="text-white" />
                    <x-text-input id="password" class="block mt-1 w-full bg-white/20 text-white placeholder-blue-200" type="password" name="password" required />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                {{-- Conferma Password --}}
                <div>
                    <x-input-label for="password_confirmation" :value="__('Conferma Password')" class="text-white" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full bg-white/20 text-white placeholder-blue-200" type="password" name="password_confirmation" required />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                {{-- Pulsante Registrazione --}}
                <div class="flex items-center justify-end">
                    <x-primary-button class="bg-blue-600 hover:bg-blue-700 text-white">
                        {{ __('Registrati') }}
                    </x-primary-button>
                </div>
            </form>

            {{-- Link Login --}}
            <div class="mt-6 text-center">
                <p class="text-blue-200">
                    {{ __('Hai già un account?') }}
                    <a href="{{ route('login') }}" class="text-white hover:text-blue-300 underline">
                        {{ __('Accedi') }}
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-layouts.marketing>

@push('styles')
<style>
    .wave-bg {
        background: linear-gradient(to bottom, #002855 40%, #00387a 100%);
        position: relative;
        overflow: hidden;
    }

    .wave {
        position: absolute;
        opacity: 0.2;
        background: linear-gradient(to right, #0056b3, #007bff);
        border-radius: 50%;
    }

    .logo-text {
        font-family: 'Georgia', serif;
    }

    .orale-text {
        font-style: italic;
    }

    input::placeholder {
        color: rgba(191, 219, 254, 0.7);
    }

    input:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
    }
</style>
@endpush