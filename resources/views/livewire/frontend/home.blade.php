<div>
    @php
      $articles = [
        [
          "id" => 1,
          "title" => "Pesona Alam Gunung Ciremai yang Wajib Dikunjungi",
          "category" => "Wisata",
          "image" => "https://i.pinimg.com/736x/14/ad/31/14ad3171038b99261210a9fbe6785d41.jpg",
        ],
        [
          "id" => 2,
          "title" => "Kuliner Khas Kuningan yang Bikin Rindu Kampung",
          "category" => "Kuliner",
          "image" => "https://i.gojekapi.com/darkroom/gofood-indonesia/v2/images/uploads/0896b65a-6d1e-4583-b60c-573359528121_Go-Biz_20220218_132132.jpeg",
        ],
        [
          "id" => 3,
          "title" => "UMKM Lokal Kuningan yang Siap Go Digital",
          "category" => "UMKM",
          "image" => "https://pdbifiles.nos.jkt-1.neo.id/files/2018/08/05/oskm18_sappk_adriel_595839a1be7662943bad20c349ee8fa2ac09666f.jpg",
        ],
        [
          "id" => 4,
          "title" => "Rekomendasi Tempat Healing di Kuningan",
          "category" => "Wisata",
          "image" => "https://pdbifiles.nos.jkt-1.neo.id/files/2018/08/05/oskm18_sappk_adriel_595839a1be7662943bad20c349ee8fa2ac09666f.jpg",
        ],
        [
          "id" => 5,
          "title" => "Event Budaya Kuningan yang Wajib Dikunjungi",
          "category" => "Event",
          "image" => "https://pdbifiles.nos.jkt-1.neo.id/files/2018/08/05/oskm18_sappk_adriel_595839a1be7662943bad20c349ee8fa2ac09666f.jpg",
        ],
      ];
    @endphp

    {{-- Hero Section --}}
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
      
      {{-- Split Background --}}
      <div class="absolute inset-0 grid grid-cols-1 md:grid-cols-2">
        
        {{-- Image 1 (Always Visible) --}}
        <div class="relative overflow-hidden group">
          <div class="absolute inset-0 bg-forest/40 md:bg-forest/20 z-10 transition-opacity group-hover:opacity-0"></div>
          <div class="absolute inset-0 from-forest via-transparent to-transparent z-10 hidden md:block"></div>
          <div
            class="w-full h-full bg-cover bg-center scale-110 transition-transform duration-[10s]"
            style="background-image: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=3270&auto=format&fit=crop');"
          ></div>
        </div>

        {{-- Image 2 (ONLY FROM TABLET UP) --}}
        <div class="relative overflow-hidden group hidden md:block">
          <div class="absolute inset-0 bg-forest/40 z-10 transition-opacity group-hover:opacity-0"></div>
          <div class="absolute inset-0 from-forest via-transparent to-transparent z-10"></div>
          <div
            class="w-full h-full bg-cover bg-center scale-110 transition-transform duration-[10s]"
            style="background-image: url('https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?q=80&w=3474&auto=format&fit=crop');"
          ></div>
        </div>
      </div>

      {{-- Hero Content --}}
      <div class="relative z-30 text-center px-4 sm:px-6 mt-24 md:mt-16">
        <h1 class="font-serif text-white text-4xl sm:text-5xl md:text-7xl lg:text-9xl leading-[0.95] tracking-tighter max-w-5xl mx-auto drop-shadow-2xl">
          {{ app_name() }}
        </h1>

        <p class="mt-6 md:mt-8 text-ethereal-white/70 text-xs sm:text-sm md:text-base max-w-xs sm:max-w-md md:max-w-xl mx-auto font-light leading-relaxed tracking-wide">
          {!! setting('app_description') !!}
        </p>
      </div>
    </section>

    {{-- About Section --}}
    <section class="grid grid-cols-3 xl:grid-cols-5 gap-16 px-5 md:px-10 xl:px-20 py-16 text-gray-800 relative z-20 bg-white">
      <div class="col-span-3 xl:col-span-2 flex items-center text-center rounded-xl bg-white shadow-xl/20 border-r-8 border-r-prestige-gold border border-prestige-gold px-10 py-14">
        <div class="text-center mx-auto">
          <div class="flex items-center justify-center gap-6">
            <hr class="border-3 border-prestige-gold w-9 md:w-10 lg:w-16" />

            <div class="flex flex-col items-center">
              {{-- <img src="{{ asset('images/logo.png') }}" alt="" class="w-16 h-16" /> --}}
              <h3 class=" font-extralight text-md lg:text-xl font-serif tracking-widest text-prestige-gold uppercase">
                {{ app_name() }}
              </h3>
              <h2 class="text-lg font-medium ">Tentang</h2>
            </div>
            <hr class="border-3 border-prestige-gold w-9 md:w-10 lg:w-16" />
          </div>
          <p class="mt-5">
            Melalui
            <span class="font-extralight font-serif tracking-widest text-prestige-gold uppercase">
              {{ app_name() }}
            </span>
            , Anda dapat menjelajahi wisata Kuningan, menemukan kuliner khas,
            serta mendukung produk UMKM lokal dalam satu platform digital.
          </p>
        </div>
      </div>
      <div class="hidden md:grid grid-cols-3 col-span-3 gap-2"> 
          <a href="/kuliner" class="group">
            <div class="relative overflow-hidden rounded-sm cursor-pointer h-full">
                <img src="https://i.gojekapi.com/darkroom/gofood-indonesia/v2/images/uploads/0896b65a-6d1e-4583-b60c-573359528121_Go-Biz_20220218_132132.jpeg" alt="Kuliner Khas" class="h-full w-full object-cover transform transition-transform duration-500 ease-in-out group-hover:scale-110" />
                <div class="absolute inset-0 bg-black/50 flex items-center justify-center transition-colors duration-300 group-hover:bg-black/60">
                    <div class="text-center">
                        <p class="text-gray-100 text-lg font-bold">Kuliner Khas</p>
                    </div>
                </div>
            </div>
          </a>

          <a href="/wisata" class="group">
            <div class="relative overflow-hidden rounded-sm cursor-pointer h-full">
                <img src="https://i.pinimg.com/736x/14/ad/31/14ad3171038b99261210a9fbe6785d41.jpg" alt="Wisata Kuningan" class="h-full w-full object-cover transform transition-transform duration-500 ease-in-out group-hover:scale-110" />
                <div class="absolute inset-0 bg-black/50 flex items-center justify-center transition-colors duration-300 group-hover:bg-black/60">
                    <div class="text-center">
                        <p class="text-gray-100 text-lg font-bold">Wisata Kuningan</p>
                    </div>
                </div>
            </div>
          </a>

          <a href="/umkm" class="group">
            <div class="relative overflow-hidden rounded-sm cursor-pointer h-full">
                <img src="https://pdbifiles.nos.jkt-1.neo.id/files/2018/08/05/oskm18_sappk_adriel_595839a1be7662943bad20c349ee8fa2ac09666f.jpg" alt="UMKM Lokal" class="h-full w-full object-cover transform transition-transform duration-500 ease-in-out group-hover:scale-110" />
                <div class="absolute inset-0 bg-black/50 flex items-center justify-center transition-colors duration-300 group-hover:bg-black/60">
                    <div class="text-center">
                        <p class="text-gray-100 text-lg font-bold">UMKM Lokal</p>
                    </div>
                </div>
            </div>
          </a>
        </div>
    </section>

    {{-- List Artikel Section --}}
    <section class="container mx-auto px-4 py-16 relative z-20">
      <div class="flex items-center justify-between my-8">
        {{-- Judul --}}
        <h3 class="flex items-center gap-2 font-serif font-extralight tracking-widest uppercase text-prestige-gold text-base lg:text-2xl">
          <span class="material-symbols-outlined text-lg lg:text-2xl">description</span>
          Sekilas Artikel
        </h3>

        {{-- Link --}}
        <a
          href="/artikel"
          class="text-sm lg:text-base font-medium text-prestige-gold/80 hover:text-prestige-gold transition flex items-center gap-1 group"
        >
          Lihat Semuanya
          <span class="group-hover:translate-x-1 transition">→</span>
        </a>
      </div>
      {{-- GRID UTAMA --}}
      <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        {{-- ARTIKEL BESAR (First Item) --}}
        <div class="lg:col-span-3 hidden lg:block">
            @if(isset($articles[0]))
                <div class="group relative overflow-hidden rounded-xl cursor-pointer h-[420px]">
                  <img
                    src="{{ $articles[0]['image'] }}"
                    alt="{{ $articles[0]['title'] }}"
                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                  />
                  <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent p-5 flex flex-col justify-end">
                    <span class="mb-2 w-fit bg-black/70 px-3 py-1 text-xs text-white rounded">
                      {{ $articles[0]['category'] }}
                    </span>
                    <h3 class="text-white font-semibold leading-snug text-2xl">
                      {{ $articles[0]['title'] }}
                    </h3>
                  </div>
                </div>
            @endif
        </div>

        {{-- LIST ARTIKEL KECIL --}}
        <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-6">
          @foreach($articles as $index => $article)
            <div class="{{ $index === 0 ? 'lg:hidden' : '' }}">
                <div class="group relative overflow-hidden rounded-xl cursor-pointer h-[200px]">
                  <img
                    src="{{ $article['image'] }}"
                    alt="{{ $article['title'] }}"
                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                  />
                  <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent p-5 flex flex-col justify-end">
                    <span class="mb-2 w-fit bg-black/70 px-3 py-1 text-xs text-white rounded">
                      {{ $article['category'] }}
                    </span>
                    <h3 class="text-white font-semibold leading-snug text-sm">
                      {{ $article['title'] }}
                    </h3>
                  </div>
                </div>
            </div>
          @endforeach
        </div>
      </div>
    </section>

    {{-- CTA Section --}}
    <section class="relative px-5 md:px-10 xl:px-20 py-24 overflow-hidden z-20 bg-white">
      {{-- Aksen gradient kiri --}}
      <div class="absolute -top-20 -left-20 w-72 h-72 bg-gradient-to-br from-prestige-gold/40 to-transparent rounded-full blur-3xl"></div>

      {{-- Aksen gradient kanan --}}
      <div class="absolute -bottom-20 -right-20 w-72 h-72 bg-gradient-to-tr from-prestige-gold/30 to-transparent rounded-full blur-3xl"></div>

      <div class="relative z-10 max-w-5xl mx-auto text-center bg-white rounded-2xl shadow-xl/20 border border-gray-100 px-6 md:px-16 py-16">
        <h2 class="text-2xl md:text-3xl lg:text-4xl font-serif font-light tracking-widest uppercase text-gray-800">
          Tunggu Apa Lagi?
        </h2>

        <p class="mt-4 max-w-2xl mx-auto text-sm md:text-base text-gray-600">
          Jelajahi wisata Kuningan, temukan kuliner khas terbaik, dan dukung
          UMKM lokal melalui satu platform digital bernama{" "}
          <span class="font-serif tracking-widest uppercase text-prestige-gold">
            {{ app_name() }}
          </span>
          .
        </p>

        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
          <a
            href="/wisata"
            class="px-8 py-3 rounded-full bg-prestige-gold text-white font-medium shadow hover:shadow-lg hover:opacity-90 transition"
          >
            Jelajahi Sekarang
          </a>

          <a
            href="/artikel"
            class="px-8 py-3 rounded-full border border-prestige-gold text-prestige-gold hover:bg-prestige-gold hover:text-white transition"
          >
            Baca Artikel
          </a>
        </div>
      </div>
    </section>
</div>
