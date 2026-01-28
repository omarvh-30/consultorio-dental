<nav class="bg-white shadow-md border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between h-16 items-center">

            {{-- IZQUIERDA --}}
            <div class="flex items-center gap-10">

                {{-- LOGO --}}
                <a href="{{ route('dashboard') }}" class="flex items-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 object-contain">
                </a>

                {{-- LINKS PRINCIPALES --}}
                <div class="hidden md:flex items-center gap-8 font-semibold text-gray-700">
                    <a href="{{ route('dashboard') }}"
                       class="{{ request()->routeIs('dashboard') ? 'text-blue-600 border-b-2 border-blue-600' : 'hover:text-blue-500 transition' }}">
                        Dashboard
                    </a>

                    <a href="{{ route('pacientes.index') }}"
                       class="{{ request()->routeIs('pacientes.*') ? 'text-blue-600 border-b-2 border-blue-600' : 'hover:text-blue-500 transition' }}">
                        Pacientes
                    </a>

                    <a href="{{ route('citas.index') }}"
                       class="{{ request()->routeIs('citas.*') ? 'text-blue-600 border-b-2 border-blue-600' : 'hover:text-blue-500 transition' }}">
                        Citas
                    </a>

                    <a href="{{ route('citas.calendario') }}"
                       class="{{ request()->routeIs('citas.calendario') ? 'text-blue-600 border-b-2 border-blue-600' : 'hover:text-blue-500 transition' }}">
                        Agenda
                    </a>
                </div>
            </div>

            {{-- DERECHA: USUARIO + DROPDOWN --}}
            <div class="flex items-center gap-4 relative">

                {{-- NOMBRE --}}
                <div class="hidden sm:flex flex-col text-right">
                    <span class="font-semibold text-gray-800">{{ Auth::user()->name }}</span>
                    <span class="text-gray-500 text-sm">{{ Auth::user()->email }}</span>
                </div>

                {{-- DROPDOWN PREMIUM --}}
                <div x-data="{ open: false }" class="relative" x-cloak>
                    <button @click="open = !open"
                        class="flex items-center gap-2 px-4 py-2 bg-blue-50 hover:bg-blue-100 rounded-md text-blue-700 font-medium transition">
                        <span>Cuenta</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    {{-- CONTENIDO DEL DROPDOWN --}}
                    <div x-show="open" 
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95"
                        @click.outside="open = false"
                        class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-50 py-2 text-sm text-gray-700">
                        <a href="{{ route('profile.edit') }}"
                        class="block px-4 py-2 hover:bg-blue-50 transition">Perfil</a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 hover:bg-red-50 text-red-600 transition">
                                Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>


            </div>

        </div>
    </div>

    {{-- MOBILE MENU --}}
    <div x-data="{ open: false }" class="md:hidden border-t border-gray-200">
        <div class="flex justify-between items-center px-6 py-3">
            <div>
                <button @click="open = !open" class="text-gray-700 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'inline-flex': open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <div x-show="open" class="px-6 pb-4 space-y-2">
            <a href="{{ route('dashboard') }}" class="block py-2 text-gray-700 hover:text-blue-600 transition">Dashboard</a>
            <a href="{{ route('pacientes.index') }}" class="block py-2 text-gray-700 hover:text-blue-600 transition">Pacientes</a>
            <a href="{{ route('citas.index') }}" class="block py-2 text-gray-700 hover:text-blue-600 transition">Citas</a>
            <a href="{{ route('citas.calendario') }}" class="block py-2 text-gray-700 hover:text-blue-600 transition">Agenda</a>

            <div class="border-t border-gray-200 mt-2 pt-2">
                <a href="{{ route('profile.edit') }}" class="block py-2 text-gray-700 hover:text-blue-600 transition">Perfil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left py-2 text-red-600 hover:bg-red-50 transition">
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
