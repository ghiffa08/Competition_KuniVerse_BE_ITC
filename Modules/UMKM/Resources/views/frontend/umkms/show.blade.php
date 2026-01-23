@extends("frontend.layouts.app")

@section("title")
    {{ $umkm->name }}
@endsection

@section("content")
<div class="container mx-auto pt-32 xl:px-20 md:px-5 px-3 mb-20 font-sans text-gray-800">
    <div class="grid xl:grid-cols-4 gap-10">
        
        {{-- 75% KIRI (MAIN CONTENT) --}}
        <div class="xl:col-span-3">
            {{-- KEMBALI BUTTON --}}
            <button
                onclick="window.location.href='{{ route('frontend.umkms.index') }}'"
                class="mb-6 flex items-center gap-2 text-sm font-semibold text-gray-600 hover:text-prestige-gold transition-colors"
            >
                <span class="material-symbols-outlined text-lg">arrow_back</span>
                Kembali ke UMKM
            </button>

            {{-- KATEGORI --}}
            <p class="text-prestige-gold font-semibold text-sm md:text-base mb-2 uppercase tracking-wide">
                UMKM Lokal
            </p>

            {{-- JUDUL --}}
            <h1 class="text-3xl md:text-4xl font-bold mb-4 text-gray-900 leading-tight font-serif">
                {{ $umkm->name }}
            </h1>

            {{-- AUTHOR --}}
            <p class="font-semibold mb-4 text-gray-700">
                Terdaftar Sejak <span class="text-prestige-gold">{{ $umkm->created_at->format('d M Y') }}</span>
            </p>

            {{-- IMAGE --}}
            <div class="rounded-xl overflow-hidden mb-8 shadow-md">
                <img
                    src="{{ $umkm->getFirstMediaUrl('cover') ?: 'https://pdbifiles.nos.jkt-1.neo.id/files/2018/08/05/oskm18_sappk_adriel_595839a1be7662943bad20c349ee8fa2ac09666f.jpg' }}"
                    alt="{{ $umkm->name }}"
                    class="w-full h-[300px] md:h-[400px] object-cover"
                />
            </div>

            {{-- CONTENT --}}
            <article class="prose max-w-none text-justify text-gray-700 leading-relaxed md:prose-lg lg:prose-xl prose-headings:font-serif prose-a:text-prestige-gold hover:prose-a:text-[#a6854e]">
                {!! nl2br(e($umkm->note)) !!}
            </article>
        </div>

        {{-- 25% KANAN (SIDEBAR) --}}
        <div class="hidden xl:block">
            <aside class="sticky top-32 space-y-8">
                {{-- THUMBNAIL / ADS / BANNER --}}
                <div class="relative h-[230px] rounded-xl overflow-hidden shadow-md group">
                    <img
                        src="https://pdbifiles.nos.jkt-1.neo.id/files/2018/08/05/oskm18_sappk_adriel_595839a1be7662943bad20c349ee8fa2ac09666f.jpg"
                        class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700"
                        alt="Sidebar Banner"
                    />
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-black/10 transition-colors"></div>
                    <div class="absolute bottom-4 left-4 text-white font-bold text-lg drop-shadow-md">
                        Dukung Produk Lokal
                    </div>
                </div>

                {{-- INFO --}}
                <div>
                     <h3 class="font-bold text-xl mb-4 text-gray-900 font-serif border-l-4 border-prestige-gold pl-3">
                        Informasi
                    </h3>
                    <p class="text-gray-600 text-sm">
                        UMKM ini adalah bagian dari inisiatif Kuniverse untuk memajukan ekonomi lokal Kabupaten Kuningan.
                    </p>
                    
                    {{-- ADD TO CART / BUY BUTTON --}}
                    <div class="mt-6 p-4 bg-gray-50 rounded-xl border border-gray-100" x-data="{ 
                        qty: 1,
                        addToCart() {
                            const item = {
                                id: {{ $umkm->id }},
                                name: '{{ $umkm->name }}',
                                price: 25000, // Dummy Price since no product variant logic yet
                                qty: this.qty,
                                image: '{{ $umkm->getFirstMediaUrl('cover') }}'
                            };
                            
                            // Simple Single Item Cart for Demo
                            localStorage.setItem('umkm_cart', JSON.stringify([item]));
                            window.location.href = '{{ route('frontend.umkms.checkout', $umkm->id) }}';
                        }
                    }">
                        <div class="flex items-center justify-between mb-4">
                            <span class="font-bold text-lg text-[#C49A5C]">Rp 25.000</span>
                            <div class="flex items-center border rounded-lg bg-white">
                                <button @click="qty > 1 ? qty-- : null" class="px-3 py-1 text-gray-500 hover:bg-gray-100">-</button>
                                <input type="text" x-model="qty" class="w-10 text-center border-0 focus:ring-0 text-sm font-semibold" readonly>
                                <button @click="qty++" class="px-3 py-1 text-gray-500 hover:bg-gray-100">+</button>
                            </div>
                        </div>
                        <button @click="addToCart()" class="w-full bg-[#C49A5C] hover:bg-[#b08b52] text-white font-bold py-3 px-4 rounded-xl transition duration-300 flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined">shopping_cart</span>
                            Beli Sekarang
                        </button>
                    </div>
                </div>
            </aside>
        </div>

    </div>
</div>
@endsection
