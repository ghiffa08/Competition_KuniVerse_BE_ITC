<div class="min-h-screen bg-white">
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 pt-32">
        {{-- Judul Halaman --}}
        <div class="text-center mb-10 pt-4">
            <div class="mt-2 h-1 w-12 bg-prestige-gold mx-auto opacity-50 rounded-full"></div>
        </div>

        {{-- HERO SECTION (Hardcoded as per design reference) --}}
        <section class="relative h-[60vh] rounded-3xl overflow-hidden group mb-12 shadow-xl mx-auto mt-8">
            <img
                src="https://i.pinimg.com/736x/14/ad/31/14ad3171038b99261210a9fbe6785d41.jpg"
                alt="Gunung Ciremai"
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/75 to-black/30"></div>
            <div class="absolute bottom-10 left-8 md:left-12 max-w-2xl text-white text-left">
                <span class="bg-prestige-gold text-xs font-bold tracking-widest px-3 py-1 rounded mb-4 inline-block uppercase shadow-md text-white">
                    Ikon Kuningan
                </span>
                <h2 class="font-serif text-4xl md:text-5xl mb-4 leading-tight drop-shadow-lg text-white">
                    Pesona Gunung Ciremai
                </h2>
                <p class="text-gray-100 mb-8 opacity-90 text-sm md:text-base leading-relaxed">
                    Atap Jawa Barat yang menawarkan keindahan alam memukau, jalur
                    pendakian menantang, dan kesejukan udara khas pegunungan.
                </p>
                <button class="bg-prestige-gold text-white px-8 py-3 rounded-full text-sm font-bold flex items-center gap-2 hover:bg-[#b08b52] transition-all cursor-pointer">
                    JELAJAHI SEKARANG
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </button>
            </div>
        </section>

        {{-- SEARCH & FILTER BAR --}}
        <div class="bg-white border border-prestige-gold rounded-xl p-3 flex flex-col md:flex-row gap-4 items-center mb-12 shadow-sm">
            <div class="relative w-full">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                    search
                </span>
                <input
                    wire:model.live.debounce.300ms="search"
                    type="text"
                    placeholder="Cari wisata di Kuningan..."
                    class="w-full pl-12 pr-4 py-2.5 bg-gray-50 rounded-lg text-sm outline-none focus:ring-1 focus:ring-prestige-gold border-none"
                />
            </div>
            
             {{-- Placeholder Filters - future implementation --}}
            <div class="flex gap-3 w-full md:w-auto">
                <select class="px-4 py-2.5 bg-gray-50 rounded-lg text-sm text-gray-600 outline-none cursor-pointer hover:bg-gray-100 w-full md:w-auto border-none focus:ring-1 focus:ring-prestige-gold">
                    <option>Semua Kategori</option>
                    <option>Alam</option>
                    <option>Sejarah</option>
                </select>
            </div>
        </div>

        {{-- GRID CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($tourisms as $item)
                <div class="group bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="relative h-60 overflow-hidden shadow-xl bg-gray-200">
                        <img
                            src="{{ $item->image ?? 'https://via.placeholder.com/400x300' }}"
                            alt="{{ $item->name }}"
                            loading="lazy"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                        />
                        @if($item->rating)
                        <div class="absolute top-3 right-3 bg-white/90 px-2 py-1 rounded-md text-xs font-bold text-prestige-gold flex items-center gap-1 shadow-sm">
                            <span class="material-symbols-outlined text-[14px]">star</span>
                            {{ $item->rating }}
                        </div>
                        @endif
                    </div>
                    <div class="p-5 text-left">
                        <h3 class="font-serif text-lg font-bold mb-2 text-gray-900 group-hover:text-prestige-gold transition-colors">
                            {{ $item->name }}
                        </h3>
                        <p class="text-gray-400 text-xs mb-4 line-clamp-2">
                            {{ Str::limit(strip_tags($item->content), 100) }}
                        </p>
                        <div class="flex justify-between items-center border-t border-gray-50 pt-4">
                            <span class="text-xs text-gray-400 flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">location_on</span>
                                {{ Str::limit($item->address, 40) ?? 'Kuningan' }}
                            </span>

                            <a 
                                href="{{ route('frontend.wisata.show', $item->slug) }}" 
                                wire:navigate
                                class="text-prestige-gold bg-prestige-gold/10 hover:bg-prestige-gold hover:text-white px-4 py-1.5 rounded-md text-[10px] font-bold tracking-wider transition-all cursor-pointer"
                            >
                                DETAIL
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-12">
                    <span class="material-symbols-outlined text-4xl text-gray-300 mb-4">landscape</span>
                    <p class="text-gray-500">Belum ada data wisata.</p>
                </div>
            @endforelse
        </div>
        
        <div class="mt-8">
            {{ $tourisms->links() }}
        </div>
    </main>
</div>
