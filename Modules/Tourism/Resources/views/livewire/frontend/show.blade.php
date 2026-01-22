<div class="min-h-screen bg-white">
    <section class="max-w-7xl mx-auto px-5 md:px-10 xl:px-20 py-26 pt-32 text-gray-800">
        
        {{-- ===== GRID FOTO (Mocked Gallery for MVP) ===== --}}
        <div class="grid grid-cols-1 md:grid-cols-4 grid-rows-2 gap-4 h-[500px] mb-12 rounded-3xl overflow-hidden shadow-2xl">
            {{-- Main Image --}}
            <div class="md:col-span-2 md:row-span-2 relative group overflow-hidden">
                <img 
                    src="{{ $tourism->image ?? 'https://via.placeholder.com/800x600' }}" 
                    alt="Main" 
                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                />
            </div>
            {{-- Side Images (Mocked) --}}
            <div class="relative group overflow-hidden bg-gray-100">
                 <img src="https://images.pexels.com/photos/1666021/pexels-photo-1666021.jpeg?auto=compress&cs=tinysrgb&w=800" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />
            </div>
            <div class="relative group overflow-hidden bg-gray-100">
                 <img src="https://images.pexels.com/photos/417173/pexels-photo-417173.jpeg?auto=compress&cs=tinysrgb&w=800" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />
            </div>
            <div class="relative group overflow-hidden bg-gray-100">
                 <img src="https://images.pexels.com/photos/1271619/pexels-photo-1271619.jpeg?auto=compress&cs=tinysrgb&w=800" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />
            </div>
            <div class="relative group overflow-hidden bg-gray-100 cursor-pointer">
                 <div class="absolute inset-0 bg-black/50 flex items-center justify-center z-10 group-hover:bg-black/40 transition-colors">
                    <span class="text-white font-bold text-lg">+5 Lainnya</span>
                 </div>
                 <img src="https://images.pexels.com/photos/572897/pexels-photo-572897.jpeg?auto=compress&cs=tinysrgb&w=800" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />
            </div>
        </div>

        {{-- ===== HEADER ===== --}}
        <div class="max-w-4xl mx-auto mb-10 text-center">
            <span class="font-serif tracking-widest uppercase text-prestige-gold text-sm font-bold">
                Wisata Kuningan
            </span>

            <h1 class="mt-4 text-3xl md:text-4xl lg:text-5xl font-serif font-medium text-gray-900 leading-tight">
                {{ $tourism->name }}
            </h1>

            <div class="mt-4 flex flex-col items-center gap-2 text-gray-500 text-sm">
                <p class="flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-base">location_on</span>
                    {{ $tourism->address ?? ($tourism->intro ?? 'Lokasi tidak tersedia') }}
                </p>
                
                @if($tourism->open_hours)
                    <p class="flex items-center justify-center gap-2 text-xs bg-gray-50 px-3 py-1 rounded-full border border-gray-100">
                        <span class="material-symbols-outlined text-sm text-prestige-gold">schedule</span>
                        Jam Buka: {{ $tourism->open_hours }}
                    </p>
                @endif
            </div>
        </div>

        {{-- ===== BOOKING PANEL ===== --}}
        <div class="max-w-4xl mx-auto mb-14">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 bg-white rounded-2xl shadow-xl border border-prestige-gold/30 p-8 transform hover:-translate-y-1 transition-all duration-300">
                {{-- Harga --}}
                <div class="flex flex-col justify-center border-b md:border-b-0 md:border-r border-gray-100 pb-4 md:pb-0 md:pr-4">
                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Harga Tiket</p>
                    <p class="text-2xl font-bold text-prestige-gold font-serif">
                        Rp {{ number_format($tourism->price ?? 0, 0, ',', '.') }}
                    </p>
                    <p class="text-xs text-gray-400">/ orang</p>
                </div>

                {{-- Jumlah Orang --}}
                <div class="flex flex-col justify-center">
                    <label class="text-xs text-gray-500 uppercase tracking-wider mb-2">Jumlah Orang</label>
                    <select wire:model="bookingQuantity" class="w-full border-gray-200 rounded-lg text-sm focus:ring-prestige-gold focus:border-prestige-gold bg-gray-50 py-2.5">
                        @foreach(range(1, 10) as $qty)
                            <option value="{{ $qty }}">{{ $qty }} Orang</option>
                        @endforeach
                    </select>
                </div>

                {{-- Tanggal --}}
                <div class="flex flex-col justify-center">
                    <label class="text-xs text-gray-500 uppercase tracking-wider mb-2">Pilih Tanggal</label>
                    <input
                        type="date"
                        wire:model="bookingDate"
                        min="{{ now()->format('Y-m-d') }}"
                        class="w-full border-gray-200 rounded-lg text-sm focus:ring-prestige-gold focus:border-prestige-gold bg-gray-50 py-2.5"
                    />
                </div>

                {{-- Tombol Pesan --}}
                <div class="flex items-end">
                    <button wire:click="bookNow" class="w-full bg-prestige-gold text-white py-3 rounded-xl font-bold uppercase tracking-widest text-xs hover:bg-[#a6854e] transition-all shadow-lg shadow-prestige-gold/20 active:scale-95">
                        Pesan Tiket
                    </button>
                </div>
            </div>
        </div>

        {{-- ===== KONTEN ===== --}}
        {{-- ===== FACILITIES ===== --}}
        @if($tourism->facilities)
            <div class="max-w-4xl mx-auto mb-8 bg-gray-50 p-6 rounded-2xl border border-gray-100">
                <h3 class="font-serif font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-prestige-gold">verified</span>
                    Fasilitas
                </h3>
                <p class="text-sm text-gray-600 leading-relaxed dark:text-gray-400 whitespace-pre-line">
                    {{ $tourism->facilities }}
                </p>
            </div>
        @endif

        {{-- ===== KONTEN ===== --}}
        <div class="max-w-4xl mx-auto text-gray-700 leading-relaxed text-base md:text-lg prose prose-headings:font-serif prose-a:text-prestige-gold">
            {!! $tourism->content !!}
        </div>
        
        {{-- ===== MAP ===== --}}
        @if($tourism->latitude && $tourism->longitude)
            <div class="max-w-4xl mx-auto mt-12 mb-12">
                <h3 class="font-serif font-bold text-gray-900 mb-6 text-2xl flex items-center gap-2">
                    <span class="material-symbols-outlined text-prestige-gold">map</span>
                    Lokasi Wisata
                </h3>
                
                <div wire:ignore id="frontend-map" class="w-full h-[400px] rounded-2xl shadow-lg border border-gray-200 z-0"></div>

                <div class="mt-4 text-center flex flex-wrap justify-center gap-3">
                    <a href="https://www.google.com/maps/search/?api=1&query={{ $tourism->latitude }},{{ $tourism->longitude }}" target="_blank" class="inline-flex items-center gap-2 bg-white border border-gray-200 px-6 py-3 rounded-xl shadow-sm hover:shadow-md transition text-prestige-gold font-bold hover:bg-gray-50">
                        <span class="material-symbols-outlined">map</span>
                        <span>Buka di Google Maps</span>
                        <span class="material-symbols-outlined text-sm">open_in_new</span>
                    </a>

                    <button onclick="getRoute()" class="inline-flex items-center gap-2 bg-prestige-gold border border-prestige-gold px-6 py-3 rounded-xl shadow-sm hover:shadow-md transition text-white font-bold hover:bg-[#a6854e]">
                        <span class="material-symbols-outlined">directions</span>
                        <span>Rute dari Lokasi Saya</span>
                    </button>
                </div>
            </div>
        @endif

         <div class="max-w-4xl mx-auto mt-12 pt-8 border-t border-gray-100 text-center">
             <a href="{{ route('frontend.wisata.index') }}" wire:navigate class="inline-flex items-center gap-2 text-gray-500 hover:text-prestige-gold transition font-medium">
                 <span class="material-symbols-outlined">arrow_back</span>
                 Kembali ke Daftar Wisata
             </a>
         </div>

    </section>
</div>

@push('after-styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
    <style>
        #frontend-map { z-index: 1 !important; }
        .leaflet-routing-container { display: none !important; } /* Hide the directions text box to keep UI clean */
    </style>
@endpush

@push('after-scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
    
    @if($tourism->latitude && $tourism->longitude)
        <script>
            var frontendMap = null;
            var routingControl = null;

            function initMap() {
                var mapContainer = document.getElementById('frontend-map');
                if (!mapContainer) return;
                 
                // If map is already initialized, just assign to global var and return
                if (mapContainer._leaflet_id) {
                     // Try to find the map object in global scope or leaflet internals if needed, 
                     // but usually re-init handles the assignment effectively if we manage the variable correctly.
                     return; 
                }

                var lat = {{ $tourism->latitude }};
                var lng = {{ $tourism->longitude }};
                
                try {
                    frontendMap = L.map('frontend-map', {
                        scrollWheelZoom: false
                    }).setView([lat, lng], 15);

                    // Remove Leaflet credit, keep only OpenStreetMap
                    frontendMap.attributionControl.setPrefix(false);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(frontendMap);

                    L.marker([lat, lng]).addTo(frontendMap)
                        .bindPopup("<div class='text-center'><b>{{ $tourism->name }}</b><br><span class='text-xs'>{{ Str::limit($tourism->address, 50) }}</span></div>")
                        .openPopup();
                        
                    // Fix for map size issues on some loads
                    setTimeout(function(){ frontendMap.invalidateSize(); }, 200);
                } catch (e) {
                    console.error("Map init error:", e);
                }
            }

            function getRoute() {
               if (!frontendMap) return;

               if (navigator.geolocation) {
                   navigator.geolocation.getCurrentPosition(function(position) {
                       var userLat = position.coords.latitude;
                       var userLng = position.coords.longitude;
                       
                       var tourismLat = {{ $tourism->latitude }};
                       var tourismLng = {{ $tourism->longitude }};
                       
                       if (routingControl) {
                           frontendMap.removeControl(routingControl);
                       }

                       // Add routing
                       routingControl = L.Routing.control({
                           waypoints: [
                               L.latLng(userLat, userLng),
                               L.latLng(tourismLat, tourismLng)
                           ],
                           routeWhileDragging: false,
                           showAlternatives: false,
                           fitSelectedRoutes: true,
                           lineOptions: {
                               styles: [{color: '#c4a065', opacity: 0.8, weight: 6}]
                           },
                           show: false, // hide the itinerary container
                           createMarker: function(i, wp, nWps) {
                                // Keep the tourism marker (destination), maybe add user marker
                                if (i === 0) {
                                    return L.marker(wp.latLng, {
                                        draggable: false,
                                        title: 'Lokasi Anda'
                                    }).bindPopup("<b>Lokasi Anda</b>");
                                }
                                return null; // Don't create new marker for destination as we already have one
                           }
                       }).addTo(frontendMap);

                   }, function(error) {
                       alert("Gagal mendapatkan lokasi anda. Pastikan GPS aktif.\nError: " + error.message);
                   });
               } else { 
                   alert("Geolocation tidak didukung oleh browser ini.");
               }
            }

            // Run on initial load and Livewire navigation
            document.addEventListener('livewire:navigated', function() {
                initMap();
                routingControl = null; // Reset routing control on nav
            });
            document.addEventListener('DOMContentLoaded', initMap);
        </script>
    @endif
@endpush
