<footer class="bg-gradient-to-br from-slate-900 to-slate-800 text-white mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            
            {{-- Brand --}}
            <div class="md:col-span-1">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-md overflow-hidden bg-gradient-to-br from-yellow-500 to-amber-500">
                        <img src="{{ asset('img/logo1.png') }}" alt="Logo SiPerpus" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <span class="font-display text-lg font-bold bg-gradient-to-r from-yellow-400 to-amber-400 bg-clip-text text-transparent">
                            SiPerpus
                        </span>
                        <p class="text-gray-400 text-xs">Digital Library</p>
                    </div>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Platform peminjaman buku digital yang memudahkan Anda mengakses koleksi perpustakaan kapan saja, di mana saja.
                </p>
            </div>
            
            {{-- Quick Links --}}
            <div>
                <h3 class="font-semibold text-white text-sm uppercase tracking-wider mb-4">Tautan Cepat</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('portal.index') }}" class="text-gray-400 hover:text-yellow-400 transition-colors">Katalog Buku</a></li>
                    <li><a href="{{ route('portal.cek-booking') }}" class="text-gray-400 hover:text-yellow-400 transition-colors">Cek Booking</a></li>
                    <!-- <li><a href="#" class="text-gray-400 hover:text-yellow-400 transition-colors">Panduan Pengguna</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-yellow-400 transition-colors">FAQ</a></li> -->
                </ul>
            </div>
            
            {{-- Contact --}}
            <div>
                <h3 class="font-semibold text-white text-sm uppercase tracking-wider mb-4">Kontak Kami</h3>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li class="flex items-start gap-2">
                        <i class="fas fa-map-marker-alt mt-0.5 text-yellow-500"></i>
                        <span>Jl. Perpustakaan No. 123, Kota</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fas fa-phone text-yellow-500"></i>
                        <span>(021) 1234567</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fas fa-envelope text-yellow-500"></i>
                        <span>siperpus@gmail.com</span>
                    </li>
                </ul>
            </div>
            
            {{-- Social Media --}}
            <div>
                <h3 class="font-semibold text-white text-sm uppercase tracking-wider mb-4">Ikuti Kami</h3>
                <div class="flex gap-3">
                    <a href="#" class="w-10 h-10 bg-white/10 hover:bg-yellow-500 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110">
                        <i class="fab fa-facebook-f text-gray-300 hover:text-white"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-white/10 hover:bg-yellow-500 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110">
                        <i class="fab fa-instagram text-gray-300 hover:text-white"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-white/10 hover:bg-yellow-500 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110">
                        <i class="fab fa-twitter text-gray-300 hover:text-white"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-white/10 hover:bg-yellow-500 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110">
                        <i class="fab fa-youtube text-gray-300 hover:text-white"></i>
                    </a>
                </div>
            </div>
        </div>
        
        {{-- Copyright --}}
        <div class="border-t border-white/10 mt-8 pt-6 text-center text-sm text-gray-400">
            <p>&copy; {{ date('Y') }} SiPerpus - Digital Library. All rights reserved.</p>
        </div>
    </div>
</footer>