<nav x-data="{ open:false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="h-16 flex items-center justify-between">
            <div class="flex items-center gap-6">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <x-application-logo class="h-8 w-8 text-gray-800" />
                    <span class="font-semibold">{{ config('app.name','USign') }}</span>
                </a>
                <div class="hidden space-x-3 sm:-my-px sm:ms-4 sm:flex">
                    <x-nav-link :href="route('gestures.index')" :active="request()->routeIs('gestures.index')">
                        {{ __('Gestures') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-4 sm:flex">
                    <x-nav-link :href="route('gestures.index')" :active="request()->routeIs('gestures.index')">
                        {{ __('Gestures') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-4 sm:flex">
                    <x-nav-link :href="route('gestures.index')" :active="request()->routeIs('gestures.index')">
                        {{ __('Gestures') }}
                    </x-nav-link>
                </div>
                {{-- Add here --}}
            </div>

            <div class="hidden sm:flex items-center gap-3">
                @auth
                    @can('admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900">Admin Panel</a>
                    @endcan

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 text-sm rounded-md text-gray-600 bg-white hover:text-gray-900">
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="ms-1 h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                Profile
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    Logout
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900">Login</a>
                    <a href="{{ route('register') }}" class="text-sm text-gray-600 hover:text-gray-900">Register</a>
                @endauth
            </div>

            <div class="sm:hidden">
                <button @click="open = !open" class="p-2 rounded-md text-gray-500 hover:bg-gray-100">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': !open}" class="sm:hidden hidden border-t border-gray-100">
        <div class="px-4 py-3 space-y-1">
            <a href="{{ route('gestures.index') }}" class="block text-gray-700">Gestures</a>
            @auth
                @can('admin')
                    <a href="{{ route('admin.dashboard') }}" class="block text-gray-700">Admin Panel</a>
                @endcan
                <a href="{{ route('profile.edit') }}" class="block text-gray-700">Profile</a>
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button class="text-left w-full text-gray-700">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block text-gray-700">Login</a>
                <a href="{{ route('register') }}" class="block text-gray-700">Register</a>
            @endauth
        </div>
    </div>
</nav>
