<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — SiPerpus</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                    animation: {
                        'fade-in-up': 'fadeInUp 0.6s ease-out',
                        'fade-in': 'fadeIn 0.5s ease-out',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                    }
                }
            }
        }
    </script>
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
        }
        
        /* Custom gradient background */
        .bg-gradient-custom {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 50%, #1e1b4b 100%);
        }
        
        /* Glass morphism effect */
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        /* Input focus effect */
        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
        }
        
        /* Floating animation for logo */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>
<body class="h-full bg-gradient-custom flex items-center justify-center p-4 relative overflow-hidden">

    {{-- Decorative Background Elements --}}
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse-slow"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse-slow" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-amber-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10"></div>
    </div>

    <div class="w-full max-w-md relative z-10 animate-fade-in-up">

        {{-- Logo Section --}}
        <div class="text-center mb-8 animate-float">
            {{-- Logo with Image --}}
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl shadow-2xl mb-4 overflow-hidden bg-gradient-to-br from-yellow-500 to-amber-500">
                <img src="{{ asset('img/logo1.png') }}" alt="SiPerpus Logo" class="w-full h-full object-cover">
            </div>
            <h1 class="font-display text-white text-4xl tracking-tight">
                <span class="bg-gradient-to-r from-yellow-400 to-amber-400 bg-clip-text text-transparent">SiPerpus</span>
            </h1>
            <p class="text-slate-400 text-sm mt-2">Sistem Manajemen Perpustakaan Digital</p>
        </div>

        {{-- Card --}}
        <div class="glass-card rounded-3xl p-8 shadow-2xl hover:shadow-blue-500/10 transition-shadow duration-300">
            
            <div class="flex items-center gap-3 mb-6 pb-3 border-b border-white/10">
                <div class="w-8 h-8 bg-blue-500/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-key text-blue-400 text-sm"></i>
                </div>
                <div>
                    <h2 class="text-white text-xl font-bold">Login Petugas</h2>
                    <p class="text-slate-500 text-xs">Masuk ke dashboard perpustakaan</p>
                </div>
            </div>

            {{-- Flash Error --}}
            @if(session('error'))
                <div class="bg-red-500/20 border border-red-500/30 text-red-300 text-sm rounded-xl px-4 py-3 mb-5 flex items-center gap-2 animate-fade-in">
                    <i class="fas fa-circle-exclamation"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if(session('success'))
                <div class="bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 text-sm rounded-xl px-4 py-3 mb-5 flex items-center gap-2 animate-fade-in">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                @csrf

                {{-- Email Field --}}
                <div>
                    <label class="block text-slate-300 text-sm font-medium mb-2 flex items-center gap-2">
                        <i class="fas fa-envelope text-slate-500 text-xs"></i>
                        Alamat Email
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-slate-500 text-sm group-focus-within:text-blue-400 transition-colors"></i>
                        </div>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="w-full bg-white/5 border @error('email') border-red-500 @else border-white/10 @enderror rounded-xl pl-11 pr-4 py-3 text-white placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                            placeholder="admin@siperpus.com"
                            autocomplete="email"
                            autofocus
                        >
                    </div>
                    @error('email')
                        <p class="text-red-400 text-xs mt-1.5 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Password Field --}}
                <div>
                    <label class="block text-slate-300 text-sm font-medium mb-2 flex items-center gap-2">
                        <i class="fas fa-lock text-slate-500 text-xs"></i>
                        Kata Sandi
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-slate-500 text-sm group-focus-within:text-blue-400 transition-colors"></i>
                        </div>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="w-full bg-white/5 border @error('password') border-red-500 @else border-white/10 @enderror rounded-xl pl-11 pr-12 py-3 text-white placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                            placeholder="Masukkan password"
                            autocomplete="current-password"
                        >
                        <button type="button" onclick="togglePassword()" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-300 transition-colors">
                            <i class="fas fa-eye text-sm" id="eye-icon"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-400 text-xs mt-1.5 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Remember Me --}}
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-slate-400 text-sm cursor-pointer group">
                        <input type="checkbox" name="remember" class="rounded border-white/20 bg-white/5 text-blue-600 focus:ring-blue-500 focus:ring-offset-0">
                        <span class="group-hover:text-slate-300 transition-colors">Ingat saya</span>
                    </label>
                    <a href="#" class="text-sm text-blue-400 hover:text-blue-300 transition-colors">
                        Lupa password?
                    </a>
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 rounded-xl transition-all duration-300 shadow-lg shadow-blue-900/40 text-sm mt-2 flex items-center justify-center gap-2 group">
                    <i class="fas fa-right-to-bracket group-hover:translate-x-1 transition-transform"></i>
                    <span>Masuk ke Dashboard</span>
                    <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </button>
            </form>

            {{-- Info Text --}}
            <div class="mt-6 pt-4 border-t border-white/10 text-center">
                <p class="text-xs text-slate-500">
                    <i class="fas fa-shield-alt mr-1"></i>
                    Akses terbatas untuk petugas perpustakaan
                </p>
            </div>
        </div>

        {{-- Footer --}}
        <div class="text-center mt-6 space-y-2">
            <p class="text-slate-600 text-xs">
                <i class="fas fa-copyright mr-1"></i>
                {{ date('Y') }} SiPerpus - Digital Library System
            </p>
            <!-- <p class="text-slate-700 text-xs">
                <i class="fas fa-heart text-red-500/50 text-[10px]"></i>
                Powered by Laravel
            </p> -->
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
        
        // Auto-hide flash messages after 5 seconds
        setTimeout(() => {
            const flashMessages = document.querySelectorAll('.animate-fade-in');
            flashMessages.forEach(msg => {
                msg.style.transition = 'opacity 0.5s';
                msg.style.opacity = '0';
                setTimeout(() => msg.remove(), 500);
            });
        }, 5000);
    </script>
</body>
</html>