@extends("frontend.layouts.app")

@section("title")
    {{ __($module_title) }}
@endsection

@section("content")
    {{-- HERO & VIDEO SECTION --}}
    <section class="container mx-auto grid xl:grid-cols-4 gap-10 pt-26 px-5 mt-24 mb-10">
        {{-- HERO --}}
        <div 
            class="xl:col-span-3 h-[280px] md:h-[350px] xl:h-[450px] relative flex items-end rounded-xl overflow-hidden p-4 md:p-10 bg-cover bg-center group"
            style="background-image: url('https://pdbifiles.nos.jkt-1.neo.id/files/2018/08/05/oskm18_sappk_adriel_595839a1be7662943bad20c349ee8fa2ac09666f.jpg');"
        >
            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/75 to-black/30 group-hover:via-black/80 transition-all duration-500"></div>

            <div class="relative z-10 w-full max-w-3xl">
                <h6 class="text-prestige-gold font-semibold text-sm md:text-base mb-2 uppercase tracking-wider">
                    Jelajahi UMKM Kuningan
                </h6>

                <a href="#" class="block">
                    <h2 class="text-white font-bold text-xl md:text-2xl xl:text-3xl leading-tight hover:text-prestige-gold transition-colors">
                        Produk Lokal Berkualitas, Kebanggaan Daerah
                    </h2>
                </a>

                <p class="text-gray-200 mt-3 text-sm hidden xl:block line-clamp-2">
                    Temukan dan dukung produk-produk terbaik dari pelaku UMKM di Kabupaten Kuningan. Dari kuliner lezat hingga kerajinan tangan yang unik.
                </p>
            </div>
        </div>

        {{-- VIDEO --}}
        <div class="hidden xl:block">
            <div class="relative w-full h-full max-w-[245px] mx-auto rounded-xl overflow-hidden shadow-lg border border-white/20">
                <video class="w-full h-full object-cover" autoplay muted loop playsinline>
                    <source src="https://v1.pinimg.com/videos/mc/720p/5f/fb/b3/5ffbb3be23d853129a1bd0597c45e41b.mp4" type="video/mp4" />
                </video>
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
            </div>
        </div>
    </section>

    {{-- LIST SECTION --}}
    <section class="container mx-auto mt-10 px-5 mb-20">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"> 
            @foreach($umkms as $umkm)
                <div class="border border-prestige-gold/30 rounded-2xl p-3 bg-white hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
                    <div class="grid gap-4 h-full flex flex-col">
                        {{-- IMAGE --}}
                        <div class="overflow-hidden rounded-xl h-[200px] w-full">
                            <img 
                                src="{{ $umkm->getFirstMediaUrl('cover') ?: 'https://pdbifiles.nos.jkt-1.neo.id/files/2018/08/05/oskm18_sappk_adriel_595839a1be7662943bad20c349ee8fa2ac09666f.jpg' }}" 
                                alt="{{ $umkm->name }}" 
                                class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700"
                            >
                        </div>

                        {{-- CONTENT --}}
                        <div class="flex flex-col flex-grow">
                            <p class="text-prestige-gold text-xs font-semibold tracking-widest uppercase mb-2">
                                UMKM Lokal
                            </p>

                            <a href="{{ route('frontend.umkms.show', $umkm->slug) }}" wire:navigate>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2 leading-snug group-hover:text-prestige-gold transition-colors">
                                    {{ $umkm->name }}
                                </h3>
                            </a>

                            <p class="text-gray-600 text-sm leading-relaxed line-clamp-3 mb-4 flex-grow">
                                {{ Str::limit(strip_tags($umkm->note), 100) }}
                            </p>

                            <div class="flex items-center justify-between text-xs text-gray-400 mt-auto pt-4 border-t border-gray-100">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm">calendar_today</span>
                                    <span>{{ $umkm->created_at->format('d M Y') }}</span>
                                </div>

                                <a href="{{ route('frontend.umkms.show', $umkm->slug) }}" wire:navigate class="flex items-center gap-1 text-prestige-gold font-semibold hover:underline">
                                    Detail
                                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- PAGINATION --}}
        <div class="mt-12">
            {{ $umkms->links() }} 
        </div>
    </section>
@endsection
