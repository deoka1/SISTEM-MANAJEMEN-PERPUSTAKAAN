<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Perpustakaan') — SiPerpus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        display: ['Playfair Display', 'serif'],
                    },
                    colors: {
                        primary: {
                            50:  '#f0f4fe',
                            100: '#dde6fc',
                            200: '#c3d3fa',
                            300: '#99b5f6',
                            400: '#688ef0',
                            500: '#4468e9',
                            600: '#2e4bde',
                            700: '#2539cb',
                            800: '#2430a4',
                            900: '#232e82',
                        },
                        accent: {
                            400: '#fb923c',
                            500: '#f97316',
                            600: '#ea580c',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .sidebar-link { @apply flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-300 hover:bg-white/10 hover:text-white transition-all duration-200 text-sm font-medium; }
        .sidebar-link.active { @apply bg-white/15 text-white; }
        .card { @apply bg-white rounded-2xl shadow-sm border border-slate-100; }
        .btn-primary { @apply inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-200 shadow-sm; }
        .btn-secondary { @apply inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-200; }
        .btn-danger { @apply inline-flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-200; }
        .btn-success { @apply inline-flex items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-200; }
        .form-input { @apply w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all; }
        .form-label { @apply block text-sm font-semibold text-slate-700 mb-1.5; }
        .badge { @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 3px; }
    </style>
    @stack('styles')
</head>
<body class="h-full bg-slate-50">

<div class="flex h-screen overflow-hidden">

  {{-- Sidebar --}}
<aside class="w-64 flex-shrink-0 bg-gradient-to-b from-slate-800 to-slate-900 flex flex-col">
    {{-- Logo --}}
    <div class="p-6 border-b border-white/10">
        <div class="flex items-center gap-3">
            {{-- Image Logo --}}
            <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-lg overflow-hidden bg-gradient-to-br from-yellow-500 to-amber-500">
                <img src="{{ asset('img/LOGO.png') }}" alt="Logo Perpustakaan" class="w-full h-full object-cover">
            </div>
            <div>
                {{-- Silver and Gold Gradient Text --}}
                <h1 class="font-display text-lg leading-none bg-gradient-to-r from-gray-300 via-yellow-400 via-amber-500 to-gray-300 bg-clip-text text-transparent font-bold">
                    SiPerpus
                </h1>
                <p class="text-slate-400 text-xs mt-0.5">Sistem Perpustakaan</p>
            </div>
        </div>
    </div>

  {{-- Navigation --}}
<nav class="flex-1 px-3 py-6 overflow-y-auto">
    {{-- Menu Utama --}}
    <div class="mb-6">
        <p class="text-white/40 text-[11px] font-bold uppercase tracking-wider px-3 mb-3 flex items-center gap-2">
            <i class="fas fa-th-large text-[10px]"></i>
            Menu Utama
        </p>

        <div class="space-y-1">
            {{-- Dashboard --}}
            <a href="{{ route('dashboard') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all duration-200 group {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-emerald-500/20 to-emerald-600/20 text-emerald-400 border-l-4 border-emerald-500' : '' }}">
                <i class="fas fa-chart-pie w-4.5 group-hover:scale-110 transition-transform"></i>
                <span class="text-sm font-medium">Dashboard</span>
            </a>

            {{-- Manajemen Buku --}}
            <a href="{{ route('buku.index') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all duration-200 group {{ request()->routeIs('buku.*') ? 'bg-gradient-to-r from-emerald-500/20 to-emerald-600/20 text-emerald-400 border-l-4 border-emerald-500' : '' }}">
                <i class="fas fa-book w-4.5 group-hover:scale-110 transition-transform"></i>
                <span class="text-sm font-medium">Manajemen Buku</span>
            </a>

            {{-- Anggota --}}
            <a href="{{ route('anggota.index') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all duration-200 group {{ request()->routeIs('anggota.*') ? 'bg-gradient-to-r from-emerald-500/20 to-emerald-600/20 text-emerald-400 border-l-4 border-emerald-500' : '' }}">
                <i class="fas fa-users w-4.5 group-hover:scale-110 transition-transform"></i>
                <span class="text-sm font-medium">Anggota</span>
            </a>

            {{-- Peminjaman --}}
            <a href="{{ route('peminjaman.index') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all duration-200 group {{ request()->routeIs('peminjaman.*') ? 'bg-gradient-to-r from-emerald-500/20 to-emerald-600/20 text-emerald-400 border-l-4 border-emerald-500' : '' }}">
                <i class="fas fa-book-bookmark w-4.5 group-hover:scale-110 transition-transform"></i>
                <span class="text-sm font-medium">Peminjaman</span>
            </a>

            {{-- Booking Pelanggan --}}
            <a href="{{ route('booking.index') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all duration-200 group {{ request()->routeIs('booking.*') ? 'bg-gradient-to-r from-emerald-500/20 to-emerald-600/20 text-emerald-400 border-l-4 border-emerald-500' : '' }}">
                <i class="fas fa-calendar-check w-4.5 group-hover:scale-110 transition-transform"></i>
                <span class="text-sm font-medium">Booking Pelanggan</span>
                
                @php 
                    $jmlBooking = \App\Models\Booking::where('status','menunggu')->count(); 
                @endphp
                
                @if($jmlBooking > 0)
                    <span class="ml-auto bg-gradient-to-r from-amber-500 to-orange-500 text-white text-xs font-bold min-w-[20px] h-5 px-1.5 rounded-full flex items-center justify-center shadow-md">
                        {{ $jmlBooking }}
                    </span>
                @endif
            </a>
        </div>
    </div>

    {{-- Divider with gradient --}}
    <div class="relative my-6">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-white/10"></div>
        </div>
        <div class="relative flex justify-center">
            <span class="bg-slate-800 px-2 text-white/30 text-[10px]">
                <i class="fas fa-ellipsis-h"></i>
            </span>
        </div>
    </div>

    {{-- Portal Pelanggan --}}
    <div class="mb-6">
        <p class="text-white/40 text-[11px] font-bold uppercase tracking-wider px-3 mb-3 flex items-center gap-2">
            <i class="fas fa-globe text-[10px]"></i>
            Eksternal
        </p>
        
        <a href="{{ route('portal.index') }}" target="_blank" 
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-white/70 hover:text-white hover:bg-white/10 transition-all duration-200 group">
            <i class="fas fa-arrow-up-right-from-square w-4.5 group-hover:rotate-45 transition-transform"></i>
            <span class="text-sm font-medium">Lihat Portal Pelanggan</span>
            <i class="fas fa-external-link-alt text-[10px] ml-auto opacity-50 group-hover:opacity-100"></i>
        </a>
    </div>

    {{-- Akun --}}
    <div class="mt-auto pt-4">
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-white/10"></div>
            </div>
            <div class="relative flex justify-center">
                <span class="bg-slate-800 px-2 text-white/30 text-[10px]">
                    <i class="fas fa-user-circle"></i>
                </span>
            </div>
        </div>
        
        {{-- Profile Section --}}
        <div class="bg-white/5 rounded-xl p-3 mb-3 backdrop-blur-sm">
            <div class="flex items-center gap-3">
                <div class="relative">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center shadow-lg">
                        <span class="text-white font-bold text-sm">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </span>
                    </div>
                    <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-500 border-2 border-slate-800 rounded-full"></div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-white font-semibold text-sm truncate">{{ Auth::user()->name }}</p>
                    <p class="text-white/50 text-xs truncate">{{ Auth::user()->email }}</p>
                </div>
            </div>
            <div class="mt-2 pt-2 border-t border-white/10">
                <div class="flex items-center justify-between text-xs">
                    <span class="text-white/50">Role</span>
                    <span class="text-emerald-400 font-medium capitalize">
                        <i class="fas {{ Auth::user()->role == 'admin' ? 'fa-shield-alt' : 'fa-user' }} text-[10px] mr-1"></i>
                        {{ Auth::user()->role }}
                    </span>
                </div>
            </div>
        </div>
        
        {{-- Logout Button --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" 
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-red-300 hover:text-white hover:bg-red-500/20 w-full transition-all duration-200 group">
                <i class="fas fa-right-from-bracket w-4.5 group-hover:scale-110 transition-transform"></i>
                <span class="text-sm font-medium">Logout</span>
            </button>
        </form>
    </div>
</nav>

@push('styles')
<style>
    /* Custom scrollbar untuk sidebar */
    nav::-webkit-scrollbar {
        width: 4px;
    }
    
    nav::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
    }
    
    nav::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
    }
    
    nav::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.3);
    }
    
    /* Animation untuk badge */
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    
    .bg-gradient-to-r.from-amber-500.to-orange-500 {
        animation: pulse 2s ease-in-out infinite;
    }
</style>
@endpush
    </aside>

    {{-- Main Content --}}
    <div class="flex-1 flex flex-col overflow-hidden">
        {{-- Top Bar --}}
        <header class="bg-white border-b border-slate-100 px-8 py-4 flex items-center justify-between flex-shrink-0">
            <div>
                <h2 class="text-xl font-bold text-slate-800">@yield('page-title', 'Dashboard')</h2>
                <p class="text-slate-400 text-sm mt-0.5">@yield('page-subtitle', '')</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-slate-400 text-sm">
                    <i class="far fa-calendar mr-1"></i>
                    {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                </span>
            </div>
        </header>

        {{-- Alert Flash --}}
        <div class="px-8 pt-4 flex-shrink-0">
            @if(session('success'))
                <x-alert type="success" :message="session('success')" />
            @endif
            @if(session('error'))
                <x-alert type="error" :message="session('error')" />
            @endif
        </div>

        {{-- Page Content --}}
        <main class="flex-1 overflow-y-auto px-8 py-6">
            @yield('content')
        </main>
    </div>

</div>

<script>
    // Auto hide alerts
    setTimeout(() => {
        document.querySelectorAll('[data-alert]').forEach(el => {
            el.style.transition = 'opacity 0.5s';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 500);
        });
    }, 5000);
</script>
@stack('scripts')
</body>
</html>
