<nav x-data="{ open: false }" class="fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-100">
    <style>
        .custom-logo {
            max-height: 50px;
            width: auto;
        }

        :root {
            --navbar-height: 64px;
        }

        header {
            margin-top: var(--navbar-height);
        }
    </style>

    </style>
    <div class="max-w-screen-xl mx-auto px-4">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}">
                    <img src="{{ asset('img/2.png') }}" alt="Logo" class="custom-logo">
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="flex flex-1 justify-center space-x-8">
                @if (Auth::user()->role === 'admin')
                    {{-- <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                      {{ __('Dashboard') }}
                  </x-nav-link> --}}
                    <x-nav-link :href="route('admin.pdindex')" :active="request()->routeIs('admin.pdindex')">
                        Produk
                    </x-nav-link>
                    <x-nav-link :href="route('admin.bbindex')" :active="request()->routeIs(['admin.bbindex', 'admin.bbcreate'])">
                        Bahan Baku
                    </x-nav-link>
                    <x-nav-link :href="route('admin.usindex')" :active="request()->routeIs('admin.usindex')">
                        Pengguna
                    </x-nav-link>
                    <x-nav-link :href="route('admin.forecast')" :active="request()->routeIs('admin.forecast')">
                        Peramalan
                    </x-nav-link>
                    <x-nav-link :href="route('laporan.index')" :active="request()->routeIs('laporan.index')">
                        Laporan
                    </x-nav-link>
                    <x-nav-link :href="route('admin.tsindex')" :active="request()->routeIs(['admin.tsindex', 'admin.tscreate'])">
                        Transaksi
                    </x-nav-link>

                @elseif(Auth::user()->role === 'owner')
                    <x-nav-link :href="route('forecast')" :active="request()->routeIs('forecast')">
                        Peramalan
                    </x-nav-link>
                    <x-nav-link :href="route('laporan.index')" :active="request()->routeIs('laporan.index')">
                        Laporan
                    </x-nav-link>
                @endif
            </div>

            <!-- Settings Dropdown -->
            <div class="ml-auto flex items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                              this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>
