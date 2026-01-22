@extends('frontend.layouts.app')

@section('title') {{ __($module_title) }} @endsection

@section('content')

<div class="min-h-screen bg-white">
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Judul Halaman -->
        <div class="text-center mb-10 pt-4">
            <div class="mt-2 h-1 w-12 bg-[#C49A5C] mx-auto opacity-50 rounded-full"></div>
        </div>

        <!-- Hero Section -->
        <section class="relative h-[60vh] rounded-3xl overflow-hidden group mb-12 shadow-xl mx-auto mt-8">
            <img
                src="https://images.pexels.com/photos/1267320/pexels-photo-1267320.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
                alt="Kuliner Kuningan"
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent">
            </div>
            <div class="absolute bottom-10 left-8 md:left-12 max-w-2xl text-white text-left">
                <span class="bg-[#C49A5C] text-xs font-bold tracking-widest px-3 py-1 rounded mb-4 inline-block uppercase shadow-md">
                    Kuliner Khas
                </span>
                <h2 class="font-serif text-4xl md:text-5xl mb-4 leading-tight drop-shadow-lg">
                    Jelajahi Cita Rasa Kuningan
                </h2>
                <p class="text-gray-100 mb-8 opacity-90 text-sm md:text-base leading-relaxed">
                    Temukan aneka hidangan lezat mulai dari makanan tradisional hingga cafe modern yang memanjakan lidah Anda di Kuningan.
                </p>
                <button class="bg-[#C49A5C] text-white px-8 py-3 rounded-full text-sm font-bold flex items-center gap-2 hover:bg-[#b08b52] transition-all cursor-pointer">
                    CARI REKOMENDASI <span class="material-icons-outlined text-sm">restaurant_menu</span>
                </button>
            </div>
        </section>

        <!-- Search Bar & Filters -->
        <div class="bg-white/80 backdrop-blur-md border border-gray-100 rounded-2xl p-4 flex flex-col md:flex-row gap-4 items-center mb-12 shadow-sm sticky top-20 z-10 transition-all duration-300">
            <div class="relative w-full">
                <span class="material-icons-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#C49A5C] transition-colors">
                    search
                </span>
                <input
                    type="text"
                    placeholder="Cari restoran di Kuningan..."
                    class="w-full pl-12 pr-4 py-3 bg-gray-50 rounded-xl text-sm text-gray-700 outline-none focus:ring-2 focus:ring-[#C49A5C]/20 focus:bg-white transition-all border border-transparent focus:border-[#C49A5C]/30"
                />
            </div>

            <div class="flex gap-3 w-full md:w-auto">
                <select class="px-5 py-3 bg-gray-50 rounded-xl text-sm text-gray-600 outline-none cursor-pointer hover:bg-gray-100 focus:ring-2 focus:ring-[#C49A5C]/20 w-full md:w-auto transition-all border border-transparent">
                    <option>Semua Kategori</option>
                    <option>Sunda</option>
                    <option>Nusantara</option>
                    <option>Cafe & Resto</option>
                    <option>Tradisional</option>
                </select>

                <select class="px-5 py-3 bg-gray-50 rounded-xl text-sm text-gray-600 outline-none cursor-pointer hover:bg-gray-100 focus:ring-2 focus:ring-[#C49A5C]/20 w-full md:w-auto transition-all border border-transparent">
                    <option>Semua Area</option>
                    <option>Cigugur</option>
                    <option>Cilimus</option>
                    <option>Darma</option>
                    <option>Kuningan Kota</option>
                </select>
            </div>
        </div>

        <!-- Grid Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($$module_name as $$module_name_singular)
            @php
            $details_url = route("frontend.$module_name.show",[encode_id($$module_name_singular->id), $$module_name_singular->slug]);
            @endphp
            
            <div class="group bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:-translate-y-2 transition-all duration-300">
                <div class="relative h-64 overflow-hidden bg-gray-200">
                    <img src="{{ $$module_name_singular->image ?? 'https://via.placeholder.com/800x600' }}" alt="{{ $$module_name_singular->name }}" loading="lazy" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />
                    
                    @if($$module_name_singular->category)
                    <div class="absolute top-4 left-4 flex gap-2">
                        <span class="bg-black/40 backdrop-blur-sm px-3 py-1 rounded-full text-[10px] font-bold text-white uppercase tracking-wider border border-white/10">
                            {{ $$module_name_singular->category }}
                        </span>
                    </div>
                    @endif

                    @if($$module_name_singular->rating)
                    <div class="absolute top-4 right-4 bg-white/95 backdrop-blur-sm px-2.5 py-1 rounded-lg text-xs font-bold text-[#C49A5C] flex items-center gap-1 shadow-sm border border-gray-100">
                        <span class="material-icons-outlined text-[14px]">star</span>
                        {{ $$module_name_singular->rating }}
                    </div>
                    @endif
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>

                <div class="p-6 text-left">
                    <h3 class="font-serif text-xl font-bold mb-2 text-gray-900 group-hover:text-[#C49A5C] transition-colors">
                        {{ $$module_name_singular->name }}
                    </h3>
                    <p class="text-gray-500 text-sm mb-4 line-clamp-2 leading-relaxed">
                        {{ $$module_name_singular->description }}
                    </p>
                    <div class="flex justify-between items-center border-t border-gray-50 pt-5 mt-auto">
                        @if($$module_name_singular->location)
                        <span class="text-xs text-gray-500 flex items-center gap-1.5 bg-gray-50 px-3 py-1.5 rounded-full">
                            <span class="material-icons-outlined text-[14px] text-[#C49A5C]">location_on</span>
                            {{ $$module_name_singular->location }}
                        </span>
                        @endif
                        <a href="{{ $details_url }}">
                            <button class="flex items-center gap-1 text-[#C49A5C] font-bold text-xs tracking-wider hover:gap-2 transition-all duration-300">
                                LIHAT MENU
                                <span class="material-icons-outlined text-[14px]">arrow_forward</span>
                            </button>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center w-100 mt-3">
            {{$$module_name->links()}}
        </div>

        <!-- Tombol Load More -->
        <div class="mt-16 text-center pb-12">
            <button class="border border-[#C49A5C] text-[#C49A5C] px-8 py-3 rounded-full text-sm font-bold hover:bg-[#C49A5C] hover:text-white transition-all cursor-pointer">
                JELAJAHI LEBIH BANYAK
            </button>
        </div>
    </main>
</div>

@endsection