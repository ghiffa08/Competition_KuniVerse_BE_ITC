<div class="container mx-auto pt-32 xl:px-20 md:px-5 px-3 mb-20 font-sans text-gray-800">
    <div class="grid xl:grid-cols-4 gap-10">
        
        {{-- 75% KIRI (MAIN CONTENT) --}}
        <div class="xl:col-span-3">
            {{-- KEMBALI BUTTON --}}
            <button
                wire:navigate
                href="{{ route('artikel.index') }}" 
                onclick="history.back(); return false;" {{-- Fallback or just link --}}
                class="mb-6 flex items-center gap-2 text-sm font-semibold text-gray-600 hover:text-prestige-gold transition-colors"
            >
                <span class="material-symbols-outlined text-lg">arrow_back</span>
                Kembali
            </button>

            {{-- KATEGORI --}}
            <p class="text-prestige-gold font-semibold text-sm md:text-base mb-2 uppercase tracking-wide">
                {{ $post->category->name ?? 'Uncategorized' }}
            </p>

            {{-- JUDUL --}}
            <h1 class="text-3xl md:text-4xl font-bold mb-4 text-gray-900 leading-tight font-serif">
                {{ $post->name }}
            </h1>

            {{-- AUTHOR --}}
            <p class="font-semibold mb-4 text-gray-700">
                Dipublikasikan Oleh <span class="text-prestige-gold">{{ $post->created_by_name ?? 'Admin' }}</span>
            </p>

            {{-- TANGGAL --}}
            <div class="flex items-center gap-2 text-sm text-gray-500 mb-6">
                <span class="material-symbols-outlined text-sm">calendar_today</span>
                <span>{{ $post->created_at->isoFormat('D MMMM Y') }}</span>
            </div>

            {{-- IMAGE --}}
            <div class="rounded-xl overflow-hidden mb-8 shadow-md">
                <img
                    src="{{ $post->image ?? 'https://i.pinimg.com/736x/14/ad/31/14ad3171038b99261210a9fbe6785d41.jpg' }}"
                    alt="{{ $post->name }}"
                    class="w-full h-[300px] md:h-[400px] object-cover"
                />
            </div>

            {{-- CONTENT --}}
            <article class="prose max-w-none text-justify text-gray-700 leading-relaxed md:prose-lg lg:prose-xl prose-headings:font-serif prose-a:text-prestige-gold hover:prose-a:text-[#a6854e]">
                {!! $post->content !!}
            </article>
        </div>

        {{-- 25% KANAN (SIDEBAR) --}}
        <div class="hidden xl:block">
            <aside class="sticky top-32 space-y-8">
                {{-- THUMBNAIL / ADS / BANNER --}}
                <div class="relative h-[230px] rounded-xl overflow-hidden shadow-md group">
                    <img
                        src="https://i.pinimg.com/736x/14/ad/31/14ad3171038b99261210a9fbe6785d41.jpg"
                        class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700"
                        alt="Sidebar Banner"
                    />
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-black/10 transition-colors"></div>
                    <div class="absolute bottom-4 left-4 text-white font-bold text-lg drop-shadow-md">
                        Jelajahi Kuniverse
                    </div>
                </div>

                {{-- REKOMENDASI --}}
                <div>
                    <h3 class="font-bold text-xl mb-4 text-gray-900 font-serif border-l-4 border-prestige-gold pl-3">
                        Rekomendasi Artikel
                    </h3>
                    <div class="space-y-6">
                        @forelse($relatedPosts as $related)
                            <div class="group">
                                <p class="text-prestige-gold font-semibold text-xs mb-1 uppercase tracking-wide">
                                    {{ $related->category->name ?? 'Article' }}
                                </p>
                                <a href="{{ route('frontend.posts.show', $related->slug) }}" wire:navigate>
                                    <h5 class="font-semibold text-gray-900 hover:text-prestige-gold transition-colors leading-snug group-hover:translate-x-1 duration-300">
                                        {{ $related->name }}
                                    </h5>
                                </a>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm italic">Belum ada artikel terkait.</p>
                        @endforelse
                    </div>
                </div>
            </aside>
        </div>

    </div>
</div>
