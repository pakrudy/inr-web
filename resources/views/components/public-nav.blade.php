<nav x-data="{ open: false }" class="bg-white shadow-sm">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="/">
                    <img src="https://inr.or.id/storage/icons/logo-inr-web-130.png" alt="Logo Organisasi" class="h-10 w-auto">
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden sm:flex sm:items-center sm:space-x-6">
                <a href="{{ route('records.index') }}" class="text-gray-600 hover:text-indigo-600">Records</a>
                @foreach ($public_pages as $nav_page)
                    <a href="{{ route('pages.show', $nav_page->slug) }}" class="text-gray-600 hover:text-indigo-600">{{ $nav_page->title }}</a>
                @endforeach
                <a href="{{ route('news.index') }}" class="text-gray-600 hover:text-indigo-600">Berita</a>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-gray-600">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-gray-600">Register</a>
                        @endif
                    @endauth
                @endif
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('records.index') }}" class="block ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300">Records</a>
            @foreach ($public_pages as $nav_page)
                <a href="{{ route('pages.show', $nav_page->slug) }}" class="block ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300">{{ $nav_page->title }}</a>
            @endforeach
            <a href="{{ route('news.index') }}" class="block ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300">Berita</a>
        </div>
        <div class="pt-4 pb-3 border-t border-gray-200">
            <div class="space-y-1">
                 @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="block ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="block ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="block ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300">Register</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </div>
</nav>
