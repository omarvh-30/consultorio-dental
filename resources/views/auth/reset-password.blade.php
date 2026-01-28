@extends('layouts.auth')

@section('content')

<div class="min-h-screen grid grid-cols-1 lg:grid-cols-2 overflow-hidden relative">

    {{-- PANEL IZQUIERDO CLARO CON FONDO ODONTOLOGÍA --}}
    <div class="hidden lg:flex flex-col justify-center px-16
                bg-gradient-to-br from-blue-100 via-white to-blue-200 text-gray-900
                relative overflow-hidden">

        {{-- Fondo odontología con SVG sutil --}}
        <svg class="absolute inset-0 w-full h-full opacity-10" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="toothPattern" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M10 20 C 20 10, 30 10, 40 20" stroke="#93c5fd" stroke-width="2" fill="none"/>
                    <circle cx="20" cy="20" r="3" fill="#bfdbfe"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#toothPattern)" />
        </svg>

        {{-- Logo gigante con halo luminoso --}}
        <div class="absolute top-1/4 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-20">
            <div class="relative">
                <div class="absolute inset-0 rounded-full bg-white opacity-20 blur-3xl animate-pulse-slow"></div>
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="relative h-40 w-auto drop-shadow-xl">
            </div>
        </div>

        <div class="max-w-lg z-30 relative">
            <div class="flex items-center gap-3 mb-6">
                <i class="fa-solid fa-tooth text-5xl text-blue-400 animate-pulse"></i>
                <span class="text-2xl font-semibold tracking-wide">
                    Sistema Clínico Dental Pro
                </span>
            </div>

            <h1 class="text-5xl font-bold mb-4 leading-tight tracking-tight animate-slideInLeft">
                Restablecer Contraseña
            </h1>

            <p class="text-gray-700 text-lg leading-relaxed animate-slideInLeft delay-100">
                Ingresa tu nueva contraseña para restablecer el acceso a tu cuenta.
            </p>
        </div>

        {{-- Partículas flotantes --}}
        <div class="absolute inset-0 z-10">
            @for ($i = 0; $i < 15; $i++)
                <div class="w-2 h-2 bg-blue-300 rounded-full opacity-30 absolute animate-float-slow"
                     style="top: {{ rand(0, 100) }}%; left: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 5) }}s;"></div>
            @endfor
        </div>

    </div>

    {{-- PANEL DERECHO - FORMULARIO --}}
    <div class="flex items-center justify-center px-6 bg-gray-50 relative overflow-hidden">

        <div class="w-full max-w-md bg-white
                    rounded-3xl shadow-2xl
                    border border-gray-200
                    p-10 relative overflow-hidden animate-fadeIn">

            {{-- Logo derecho inmóvil --}}
            <div class="flex justify-center mb-6">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 w-auto">
            </div>

            <h2 class="text-3xl font-bold text-gray-900 mb-2 text-center animate-slideInUp">
                Restablece tu contraseña
            </h2>

            <div class="mb-4 text-sm text-gray-600 text-center animate-slideInUp delay-100">
                Completa los campos para crear una nueva contraseña.
            </div>

            <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                @csrf

                <!-- Token oculto -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Correo Electrónico')" />
                    <x-text-input id="email" class="block mt-1 w-full rounded-xl
                                                      border-gray-300 focus:border-blue-500 focus:ring
                                                      focus:ring-blue-200 focus:ring-opacity-50
                                                      transition-all duration-300 hover:scale-105"
                                  type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Contraseña')" />
                    <x-text-input id="password" class="block mt-1 w-full rounded-xl
                                                         border-gray-300 focus:border-blue-500 focus:ring
                                                         focus:ring-blue-200 focus:ring-opacity-50
                                                         transition-all duration-300 hover:scale-105"
                                  type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full rounded-xl
                                                                  border-gray-300 focus:border-blue-500 focus:ring
                                                                  focus:ring-blue-200 focus:ring-opacity-50
                                                                  transition-all duration-300 hover:scale-105"
                                  type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="w-full justify-center py-3 rounded-xl
                                            bg-gradient-to-r from-blue-600 to-blue-400
                                            hover:from-blue-400 hover:to-blue-600
                                            text-white font-semibold shadow-lg
                                            transition-transform transform hover:scale-105 duration-300">
                        {{ __('Restablecer Contraseña') }}
                    </x-primary-button>
                </div>
            </form>

            <div class="text-xs text-gray-400 mt-8 text-center animate-slideInUp delay-200">
                © {{ date('Y') }} Sistema Clínico Dental Pro
            </div>

        </div>
    </div>

</div>

{{-- Animaciones personalizadas --}}
<style>
@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-20px); }
}
@keyframes float-slow {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-40px); }
}
@keyframes spin-slow { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
@keyframes slideInLeft { from { opacity: 0; transform: translateX(-50px); } to { opacity: 1; transform: translateX(0); } }
@keyframes slideInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
@keyframes pulse-slow { 0%, 100% { opacity: 0.3; } 50% { opacity: 0.5; } }

.animate-float { animation: float 6s ease-in-out infinite; }
.animate-float-slow { animation: float-slow 12s ease-in-out infinite; }
.animate-spin-slow { animation: spin-slow 40s linear infinite; }
.animate-slideInLeft { animation: slideInLeft 1s ease-out forwards; }
.animate-slideInUp { animation: slideInUp 1s ease-out forwards; }
.animate-fadeIn { animation: fadeIn 1s ease-out forwards; }
.animate-pulse-slow { animation: pulse-slow 3s ease-in-out infinite; }

.delay-100 { animation-delay: 0.1s; }
.delay-200 { animation-delay: 0.2s; }
</style>

@endsection
