<footer class="relative mt-24 border-t border-gray-100 bg-white">
    {{-- aksen gradient halus --}}
    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-prestige-gold/40 to-transparent"></div>

    <div class="px-5 md:px-10 xl:px-20 py-16">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
            
            {{-- Brand --}}
            <div>
                <h3 class="font-serif tracking-widest uppercase text-prestige-gold text-lg">
                    {{ app_name() }}
                </h3>
                <p class="mt-4 text-sm text-gray-600 leading-relaxed">
                    Gerbang digital untuk menjelajahi wisata, kuliner, dan UMKM lokal
                    terbaik di Kabupaten Kuningan.
                </p>
            </div>

            {{-- Menu --}}
            <div>
                <h4 class="text-sm font-semibold text-gray-800 mb-4">
                    Menu
                </h4>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li><a href="/" wire:navigate class="hover:text-prestige-gold transition">Beranda</a></li>
                    <li><a href="/wisata" wire:navigate class="hover:text-prestige-gold transition">Wisata</a></li>
                    <li><a href="/kuliner" wire:navigate class="hover:text-prestige-gold transition">Kuliner</a></li>
                    <li><a href="/umkm" wire:navigate class="hover:text-prestige-gold transition">UMKM</a></li>
                    <li><a href="/artikel" wire:navigate class="hover:text-prestige-gold transition">Artikel</a></li>
                </ul>
            </div>

            {{-- Layanan --}}
            <div>
                <h4 class="text-sm font-semibold text-gray-800 mb-4">
                    Layanan
                </h4>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li>Informasi Wisata</li>
                    <li>Reservasi Kuliner</li>
                    <li>Produk UMKM Lokal</li>
                    <li>Artikel & Edukasi</li>
                </ul>
            </div>

            {{-- Kontak --}}
            <div>
                <h4 class="text-sm font-semibold text-gray-800 mb-4">
                    Kontak
                </h4>
                <ul class="space-y-3 text-sm text-gray-600">
                    <li class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-prestige-gold text-lg">location_on</span>
                        Kuningan, Jawa Barat
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-prestige-gold text-lg">mail</span>
                        info@kuniverse.id
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-prestige-gold text-lg">call</span>
                        +62 8xxx xxxx xxxx
                    </li>
                </ul>
            </div>
        </div>

        {{-- bottom --}}
        <div class="mt-12 pt-6 border-t border-gray-100 flex flex-col md:flex-row items-center justify-between text-sm text-gray-500">
            <p>
                © {{ date('Y') }}
                <span class="font-serif tracking-widest text-prestige-gold uppercase">
                    Tim Bos Udin
                </span>. All rights reserved.
            </p>

            <div class="flex gap-6 mt-4 md:mt-0">
                <a href="#" class="hover:text-prestige-gold transition">Kebijakan Privasi</a>
                <a href="#" class="hover:text-prestige-gold transition">Syarat & Ketentuan</a>
            </div>
        </div>
    </div>
</footer>
