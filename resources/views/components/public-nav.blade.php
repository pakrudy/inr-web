<div class="relative z-50">
    <!-- Top Navigation Bar -->
    <div class="bg-gray-900 text-gray-300 text-sm py-2 hidden sm:block relative z-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center pb-1">
            <!-- Left Side: Date & Time -->
            <div x-data="{ 
                date: new Date().toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }),
                time: new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }),
                init() {
                    setInterval(() => {
                        this.time = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
                    }, 1000); // Update every minute is enough usually, but seconds are nice
                }
            }" x-init="init()" class="flex items-center space-x-4">
                <span x-text="date"></span>
                <span class="text-gray-600">|</span>
                <span x-text="time"></span>
            </div>

            <!-- Right Side: Hot Links -->
            <div class="flex items-center space-x-6">
                <a href="#" class="hover:text-white transition-colors">Tentang Kami</a>
                <a href="#" class="hover:text-white transition-colors">Hubungi Kami</a>
                <a href="#" class="hover:text-white transition-colors">Bantuan</a>
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <nav x-data="{ 
        open: false,
        showNavbar: true,
        isFixed: false,
        lastScrollY: 0,
        init() {
            this.lastScrollY = window.scrollY;
            window.addEventListener('scroll', () => {
                const currentScrollY = window.scrollY;
                
                // Only trigger if scroll difference is significant (prevent jitter)
                if (Math.abs(currentScrollY - this.lastScrollY) < 10) return;

                // Determine if we should be fixed
                this.isFixed = currentScrollY > 80;

                // Scroll Logic
                if (currentScrollY > this.lastScrollY && currentScrollY > 80) {
                    this.showNavbar = false; // Scroll Down -> Hide
                } else {
                    this.showNavbar = true;  // Scroll Up -> Show
                }
                
                this.lastScrollY = currentScrollY;
            }, { passive: true });
        }
    }" 
    x-init="init()"
    :class="{ 
        'fixed top-0 left-0 w-full shadow-md': isFixed,
        'relative w-full': !isFixed,
        '-translate-y-full': isFixed && !showNavbar
    }"
    class="bg-white z-50 transition-transform duration-300 transform will-change-transform">
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
                <a href="{{ route('records.index') }}" class="text-gray-600 hover:text-indigo-600">Legacy Index</a>
                <a href="{{ route('recommendations.index') }}" class="text-gray-600 hover:text-indigo-600">Recommendation Index</a>
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
            <a href="{{ route('records.index') }}" class="block ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300">Legacy Index</a>
            <a href="{{ route('recommendations.index') }}" class="block ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300">Recommendation Index</a>
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
</div>
