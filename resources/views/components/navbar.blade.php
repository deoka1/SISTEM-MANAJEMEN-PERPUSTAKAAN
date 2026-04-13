{{-- Navbar with Scroll Animation --}}
<nav id="mainNavbar" class="fixed top-0 left-0 w-full z-50 transition-all duration-500 ease-in-out">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 md:h-20 lg:h-16 transition-all duration-300">

            {{-- Logo --}}
            <a href="{{ route('portal.index') }}" class="flex items-center gap-2 sm:gap-3 group flex-shrink-0">
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl flex items-center justify-center shadow-md overflow-hidden bg-gradient-to-br from-yellow-500 to-amber-500 transition-all duration-300">
                    <img src="{{ asset('img/logo1.png') }}" alt="Logo SiPerpus" class="w-full h-full object-cover">
                </div>
                <div>
                    <span class="font-display text-base sm:text-lg font-bold transition-all duration-300 logo-text">
                        SiPerpus
                    </span>
                    <p class="text-gray-400 text-[10px] sm:text-xs leading-tight hidden sm:block transition-all duration-300 logo-subtext">
                        Digital Library
                    </p>
                </div>
            </a>

            {{-- Desktop Nav Links --}}
            <div class="hidden md:flex items-center gap-4 lg:gap-6 text-sm font-medium">
                <a href="{{ route('portal.index') }}" class="nav-link transition-all duration-200 whitespace-nowrap {{ request()->routeIs('portal.index') ? 'active' : '' }}">
                    <i class="fas fa-book mr-1"></i> Katalog
                </a>
                <a href="{{ route('portal.cek-booking') }}" class="nav-link transition-all duration-200 whitespace-nowrap {{ request()->routeIs('portal.cek-booking') ? 'active' : '' }}">
                    <i class="fas fa-magnifying-glass mr-1"></i> Cek Booking
                </a>
            </div>

            {{-- Mobile Menu Button --}}
            <button id="mobileMenuButton" class="md:hidden transition-all duration-300 p-2 rounded-lg menu-button">
                <i id="menuIcon" class="fas fa-bars text-xl"></i>
            </button>

            {{-- Right Section --}}
            <div class="flex items-center gap-2 sm:gap-3">
                {{-- Search Button for Tablet --}}
                <a href="{{ route('portal.cek-booking') }}" class="md:hidden lg:hidden transition-all duration-200 p-2 rounded-lg search-button">
                    <i class="fas fa-magnifying-glass text-base sm:text-lg"></i>
                </a>
                
                <a href="{{ route('login') }}" class="login-button inline-flex items-center gap-1 sm:gap-2 px-3 sm:px-4 py-1.5 sm:py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-300 shadow-md whitespace-nowrap">
                    <i class="fas fa-lock text-xs sm:text-sm"></i>
                    <span class="hidden xs:inline">Login Petugas</span>
                    <span class="xs:hidden">Login</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Mobile Menu Dropdown --}}
    <div id="mobileMenu" class="hidden md:hidden transition-all duration-300 shadow-lg mobile-menu">
        <div class="px-4 py-3 space-y-2">
            <a href="{{ route('portal.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 mobile-nav-link {{ request()->routeIs('portal.index') ? 'active' : '' }}">
                <i class="fas fa-book w-5"></i>
                <span class="font-medium">Katalog Buku</span>
            </a>
            <a href="{{ route('portal.cek-booking') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 mobile-nav-link {{ request()->routeIs('portal.cek-booking') ? 'active' : '' }}">
                <i class="fas fa-magnifying-glass w-5"></i>
                <span class="font-medium">Cek Booking</span>
            </a>
        </div>
    </div>
</nav>

<script>
    // Navbar scroll animation
    document.addEventListener('DOMContentLoaded', function() {
        const navbar = document.getElementById('mainNavbar');
        const logoText = document.querySelector('.logo-text');
        const logoSubtext = document.querySelector('.logo-subtext');
        const navLinks = document.querySelectorAll('.nav-link');
        const menuButton = document.querySelector('.menu-button');
        const searchButton = document.querySelector('.search-button');
        const loginButton = document.querySelector('.login-button');
        const mobileMenu = document.querySelector('.mobile-menu');
        const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');
        
        // Function to update navbar styles based on scroll position
        function updateNavbar() {
            if (window.scrollY > 50) {
                // Scrolled - Add white background
                navbar.classList.add('scrolled');
                
                // Update logo text color
                if (logoText) {
                    logoText.classList.add('scrolled-logo-text');
                }
                if (logoSubtext) {
                    logoSubtext.classList.add('scrolled-logo-subtext');
                }
                
                // Update nav links
                navLinks.forEach(link => {
                    link.classList.add('scrolled-nav-link');
                });
                
                // Update buttons
                if (menuButton) {
                    menuButton.classList.add('scrolled-menu-button');
                }
                if (searchButton) {
                    searchButton.classList.add('scrolled-search-button');
                }
                if (loginButton) {
                    loginButton.classList.add('scrolled-login-button');
                }
                
                // Update mobile menu
                if (mobileMenu) {
                    mobileMenu.classList.add('scrolled-mobile-menu');
                }
                
                // Update mobile nav links
                mobileNavLinks.forEach(link => {
                    link.classList.add('scrolled-mobile-nav-link');
                });
            } else {
                // Top - Transparent
                navbar.classList.remove('scrolled');
                
                // Reset logo text color
                if (logoText) {
                    logoText.classList.remove('scrolled-logo-text');
                }
                if (logoSubtext) {
                    logoSubtext.classList.remove('scrolled-logo-subtext');
                }
                
                // Reset nav links
                navLinks.forEach(link => {
                    link.classList.remove('scrolled-nav-link');
                });
                
                // Reset buttons
                if (menuButton) {
                    menuButton.classList.remove('scrolled-menu-button');
                }
                if (searchButton) {
                    searchButton.classList.remove('scrolled-search-button');
                }
                if (loginButton) {
                    loginButton.classList.remove('scrolled-login-button');
                }
                
                // Reset mobile menu
                if (mobileMenu) {
                    mobileMenu.classList.remove('scrolled-mobile-menu');
                }
                
                // Reset mobile nav links
                mobileNavLinks.forEach(link => {
                    link.classList.remove('scrolled-mobile-nav-link');
                });
            }
        }
        
        // Initial call
        updateNavbar();
        
        // Add scroll event listener
        window.addEventListener('scroll', updateNavbar);
        
        // Mobile menu toggle functionality
        const mobileMenuButton = document.getElementById('mobileMenuButton');
        const mobileMenuDiv = document.getElementById('mobileMenu');
        const menuIcon = document.getElementById('menuIcon');
        
        if (mobileMenuButton) {
            mobileMenuButton.addEventListener('click', function() {
                mobileMenuDiv.classList.toggle('hidden');
                if (menuIcon.classList.contains('fa-bars')) {
                    menuIcon.classList.remove('fa-bars');
                    menuIcon.classList.add('fa-times');
                } else {
                    menuIcon.classList.remove('fa-times');
                    menuIcon.classList.add('fa-bars');
                }
            });
        }
        
        // Close mobile menu when clicking on a link
        const mobileLinks = document.querySelectorAll('#mobileMenu a');
        mobileLinks.forEach(link => {
            link.addEventListener('click', () => {
                mobileMenuDiv.classList.add('hidden');
                if (menuIcon) {
                    menuIcon.classList.remove('fa-times');
                    menuIcon.classList.add('fa-bars');
                }
            });
        });
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const isClickInside = mobileMenuButton?.contains(event.target) || mobileMenuDiv?.contains(event.target);
            if (!isClickInside && mobileMenuDiv && !mobileMenuDiv.classList.contains('hidden')) {
                mobileMenuDiv.classList.add('hidden');
                if (menuIcon) {
                    menuIcon.classList.remove('fa-times');
                    menuIcon.classList.add('fa-bars');
                }
            }
        });
    });
</script>

<style>
    /* Base navbar styles - Transparent */
    #mainNavbar {
        background: transparent;
        backdrop-filter: blur(0px);
    }
    
    /* Scrolled navbar styles - White with shadow */
    #mainNavbar.scrolled {
        background: white;
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }
    
    /* Logo text styles - Transparent state */
    .logo-text {
        background: linear-gradient(135deg, #ffffff 0%, #fef08a 100%);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .logo-subtext {
        color: rgba(255, 255, 255, 0.8);
    }
    
    /* Logo text styles - Scrolled state */
    .logo-text.scrolled-logo-text {
        background: linear-gradient(135deg, #eab308 0%, #f59e0b 100%);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        text-shadow: none;
    }
    
    .logo-subtext.scrolled-logo-subtext {
        color: #94a3b8;
    }
    
    /* Nav links - Transparent state */
    .nav-link {
        color: rgba(255, 255, 255, 0.9);
        position: relative;
    }
    
    .nav-link:hover {
        color: #fbbf24;
    }
    
    .nav-link.active {
        color: #fbbf24;
        border-bottom: 2px solid #fbbf24;
        padding-bottom: 0.125rem;
    }
    
    /* Nav links - Scrolled state */
    .nav-link.scrolled-nav-link {
        color: #475569;
    }
    
    .nav-link.scrolled-nav-link:hover {
        color: #eab308;
    }
    
    .nav-link.scrolled-nav-link.active {
        color: #eab308;
        border-bottom-color: #eab308;
    }
    
    /* Menu button - Transparent state */
    .menu-button {
        color: white;
    }
    
    .menu-button:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #fbbf24;
    }
    
    /* Menu button - Scrolled state */
    .menu-button.scrolled-menu-button {
        color: #475569;
    }
    
    .menu-button.scrolled-menu-button:hover {
        background: #fef3c7;
        color: #eab308;
    }
    
    /* Search button - Transparent state */
    .search-button {
        color: white;
    }
    
    .search-button:hover {
        color: #fbbf24;
    }
    
    /* Search button - Scrolled state */
    .search-button.scrolled-search-button {
        color: #475569;
    }
    
    .search-button.scrolled-search-button:hover {
        color: #eab308;
    }
    
    /* Login button - Transparent state */
    .login-button {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.9), rgba(234, 179, 8, 0.9));
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .login-button:hover {
        background: linear-gradient(135deg, #f59e0b, #eab308);
        transform: translateY(-1px);
    }
    
    /* Login button - Scrolled state */
    .login-button.scrolled-login-button {
        background: linear-gradient(135deg, #eab308, #f59e0b);
        border: none;
    }
    
    /* Mobile menu - Transparent state */
    .mobile-menu {
        background: rgba(0, 0, 0, 0.9);
        backdrop-filter: blur(10px);
    }
    
    /* Mobile menu - Scrolled state */
    .mobile-menu.scrolled-mobile-menu {
        background: white;
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }
    
    /* Mobile nav links - Transparent state */
    .mobile-nav-link {
        color: rgba(255, 255, 255, 0.9);
    }
    
    .mobile-nav-link:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #fbbf24;
    }
    
    .mobile-nav-link.active {
        background: rgba(251, 191, 36, 0.2);
        color: #fbbf24;
    }
    
    /* Mobile nav links - Scrolled state */
    .mobile-nav-link.scrolled-mobile-nav-link {
        color: #475569;
    }
    
    .mobile-nav-link.scrolled-mobile-nav-link:hover {
        background: #fef3c7;
        color: #eab308;
    }
    
    .mobile-nav-link.scrolled-mobile-nav-link.active {
        background: #fef3c7;
        color: #eab308;
    }
    
    /* Responsive styles */
    @media (min-width: 475px) {
        .xs\:inline { display: inline; }
        .xs\:hidden { display: none; }
    }
    
    /* Mobile menu animation */
    #mobileMenu {
        transition: all 0.3s ease;
        max-height: 0;
        overflow: hidden;
    }
    
    #mobileMenu:not(.hidden) {
        max-height: 300px;
    }
    
    /* Touch-friendly tap targets */
    @media (max-width: 768px) {
        #mobileMenu a { min-height: 44px; }
        button, a {
            cursor: pointer;
            -webkit-tap-highlight-color: transparent;
        }
    }
    
    /* Smooth scroll behavior */
    html {
        scroll-behavior: smooth;
    }
</style>