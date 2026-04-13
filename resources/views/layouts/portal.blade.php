<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Katalog Buku') — SiPerpus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">
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
                        brand: {
                            50:  '#fdf4ff',
                            100: '#fae8ff',
                            200: '#f3d0fe',
                            300: '#e9a8fd',
                            400: '#d972fa',
                            500: '#c044f0',
                            600: '#a421d4',
                            700: '#8b18ae',
                            800: '#73188e',
                            900: '#5e1874',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: linear-gradient(135deg, #fafafa 0%, #f0f0f0 100%);
            min-height: 100vh;
        }
        .form-input { @apply w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all; }
        .form-label { @apply block text-sm font-semibold text-slate-700 mb-1.5; }
        .btn-brand  { @apply inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-sm; }
        .btn-outline { @apply inline-flex items-center gap-2 border-2 border-brand-600 text-brand-600 hover:bg-brand-600 hover:text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all; }
        .card-book { @apply bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all duration-300; }
    </style>
    @stack('styles')
</head>
<body class="bg-gradient-to-b from-slate-50 via-white to-amber-50/20">

<x-navbar></x-navbar>

{{-- Flash Messages --}}
@if(session('success') || session('error'))
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
    @if(session('success'))
        <div data-alert class="flex items-start gap-3 px-4 py-3 rounded-xl border bg-emerald-50 border-emerald-200 text-emerald-800 text-sm font-medium mb-2">
            <i class="fas fa-circle-check text-emerald-500 mt-0.5"></i>
            <span>{!! session('success') !!}</span>
            <button onclick="this.parentElement.remove()" class="ml-auto opacity-60 hover:opacity-100 flex-shrink-0"><i class="fas fa-xmark"></i></button>
        </div>
    @endif
    @if(session('error'))
        <div data-alert class="flex items-center gap-3 px-4 py-3 rounded-xl border bg-red-50 border-red-200 text-red-800 text-sm font-medium mb-2">
            <i class="fas fa-circle-xmark text-red-500"></i>
            <span>{{ session('error') }}</span>
            <button onclick="this.parentElement.remove()" class="ml-auto opacity-60 hover:opacity-100"><i class="fas fa-xmark"></i></button>
        </div>
    @endif
</div>
@endif

{{-- Content --}}
<main class="min-h-screen">
    @yield('content')
</main>

<x-footer></x-footer>

<script>
    setTimeout(() => {
        document.querySelectorAll('[data-alert]').forEach(el => {
            el.style.transition = 'opacity 0.5s';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 500);
        });
    }, 6000);
</script>
@stack('scripts')
</body>
</html>