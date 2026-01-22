@extends('frontend.layouts.app')

@section('title') {{ $$module_name_singular->name }} - {{ __($module_title) }} @endsection

@push('after-styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <style>
        #map { height: 300px; width: 100%; border-radius: 1rem; z-index: 0; }
    </style>
@endpush

@section('content')

<div class="min-h-screen bg-white" x-data="kulinerDetail()">
    <section class="container mx-auto pt-28 xl:px-20 md:px-10 px-4 grid xl:grid-cols-4 gap-12 pb-20">
        <!-- ================= KIRI ================= -->
        <div class="xl:col-span-3">
            <!-- GALERI -->
            <img
                src="{{ $$module_name_singular->image ?? 'https://images.pexels.com/photos/958545/pexels-photo-958545.jpeg' }}"
                alt="{{ $$module_name_singular->name }}"
                class="w-full h-[260px] md:h-[420px] xl:h-[480px] object-cover rounded-2xl mb-10"
            />

            <!-- HEADER -->
            <h1 class="text-3xl md:text-4xl font-serif font-semibold mb-2">
                {{ $$module_name_singular->name }}
            </h1>

            <p class="flex items-center gap-2 text-gray-500 text-sm mb-6">
                <span class="material-symbols-outlined text-[#C49A5C]">location_on</span>
                {{ $$module_name_singular->location ?? 'Lokasi tidak tersedia' }}
            </p>

            <!-- MAP -->
            @if($$module_name_singular->latitude && $$module_name_singular->longitude)
                <div id="map" class="mb-8 shadow-md border border-gray-200"></div>
            @endif

            <!-- DESKRIPSI -->
            <article class="text-gray-700 leading-relaxed space-y-4 mb-12">
               <p>{{ $$module_name_singular->description }}</p>
            </article>

            <!-- FILTER KATEGORI -->
            <div class="flex gap-3 mb-8 overflow-x-auto pb-2">
                <template x-for="item in categories" :key="item.key">
                    <button
                        @click="activeCategory = item.key"
                        class="px-5 py-2 rounded-full border text-sm font-medium transition whitespace-nowrap"
                        :class="activeCategory === item.key ? 'bg-[#C49A5C] text-white border-[#C49A5C]' : 'hover:bg-[#C49A5C]/10 border-gray-200'"
                        x-text="item.label"
                    ></button>
                </template>
            </div>

            <!-- MENU -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                <template x-for="menu in filteredMenus" :key="menu.id">
                    <div class="border border-[#C49A5C] rounded-2xl overflow-hidden bg-white hover:shadow-md transition group">
                        <img
                            :src="menu.image"
                            :alt="menu.name"
                            class="h-40 w-full object-cover group-hover:scale-105 transition-transform duration-500"
                        />
                        <div class="p-4 flex justify-between items-center">
                            <div>
                                <h4 class="font-semibold text-gray-900" x-text="menu.name"></h4>
                                <p class="text-[#C49A5C] font-semibold text-sm" x-text="'Rp ' + menu.price.toLocaleString()"></p>
                            </div>
                            <button
                                @click="addToCart(menu)"
                                class="p-3 rounded-full border hover:bg-[#C49A5C] hover:text-white transition text-[#C49A5C] border-gray-100"
                            >
                                <span class="material-symbols-outlined text-xl">shopping_cart</span>
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- ================= BOOKING DESKTOP ================= -->
        <div class="hidden xl:block sticky top-32 self-start">
            <div class="border border-[#C49A5C]/40 rounded-2xl p-6 bg-white shadow-sm">
                <div class="mb-5 flex border-b border-gray-200">
                    <button @click="mode = 'booking'" :class="{'border-b-2 border-[#C49A5C] text-[#C49A5C] font-semibold': mode === 'booking'}" class="flex-1 pb-3 text-sm text-center text-gray-500 hover:text-[#C49A5C] transition">Booking Meja</button>
                    <button @click="mode = 'delivery'" :class="{'border-b-2 border-[#C49A5C] text-[#C49A5C] font-semibold': mode === 'delivery'}" class="flex-1 pb-3 text-sm text-center text-gray-500 hover:text-[#C49A5C] transition">Pesan Antar</button>
                </div>

                <!-- BOOKING FORM -->
                <div x-show="mode === 'booking'">
                    <h4 class="font-semibold text-lg mb-5">Booking Meja</h4>

                    <label class="text-sm font-medium block mb-2">Tanggal</label>
                    <div class="flex items-center gap-2 border rounded-lg px-3 py-2 mb-4">
                        <span class="material-symbols-outlined text-gray-400">calendar_today</span>
                        <input type="date" class="w-full outline-none text-sm bg-transparent" />
                    </div>

                    <label class="text-sm font-medium block mb-2">Jumlah Orang</label>
                    <div class="flex items-center gap-2 border rounded-lg px-3 py-2 mb-6">
                        <span class="material-symbols-outlined text-gray-400">group</span>
                        <input
                            type="number"
                            min="1"
                            x-model="people"
                            class="w-full outline-none text-sm bg-transparent"
                        />
                    </div>
                </div>

                <!-- DELIVERY INFO -->
                <div x-show="mode === 'delivery'" class="mb-6">
                     <h4 class="font-semibold text-lg mb-2">Pesan Antar</h4>
                     <p class="text-sm text-gray-500 mb-4">Kami akan mengantarkan pesanan ke lokasi Anda menggunakan kurir pilihan (Biteship).</p>
                     
                     <div class="flex items-start gap-2 bg-yellow-50 p-3 rounded-lg text-xs text-yellow-800 border border-yellow-100">
                        <span class="material-symbols-outlined text-base">info</span>
                        <p>Pastikan alamat pengiriman Anda dalam jangkauan kurir.</p>
                     </div>
                </div>

                <!-- CART -->
                <div class="space-y-4 mb-6 border-t border-gray-100 pt-4">
                    <template x-if="cart.length === 0">
                        <p class="text-sm text-gray-500 text-center py-4">Belum ada menu dipilih</p>
                    </template>

                    <template x-for="item in cart" :key="item.id">
                        <div class="flex justify-between items-center bg-gray-50 p-2 rounded-lg">
                            <div>
                                <p class="text-sm font-medium" x-text="item.name"></p>
                                <p class="text-xs text-gray-500" x-text="'Rp ' + item.price.toLocaleString()"></p>
                            </div>

                            <div class="flex items-center gap-2">
                                <button @click="decreaseQty(item.id)" class="w-6 h-6 flex items-center justify-center bg-white rounded shadow-sm hover:bg-gray-100 text-xs">-</button>
                                <span class="text-sm font-bold w-4 text-center" x-text="item.qty"></span>
                                <button @click="increaseQty(item.id)" class="w-6 h-6 flex items-center justify-center bg-white rounded shadow-sm hover:bg-gray-100 text-xs">+</button>
                                <button
                                    @click="removeItem(item.id)"
                                    class="text-red-500 ml-1 hover:bg-red-50 p-1 rounded transition"
                                >
                                    <span class="material-symbols-outlined text-sm">delete</span>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="flex justify-between font-semibold mb-6 pt-4 border-t border-dashed border-gray-200">
                    <span>Total</span>
                    <span class="text-[#C49A5C]" x-text="'Rp ' + totalPrice.toLocaleString()"></span>
                </div>

                <template x-if="mode === 'booking'">
                    <button class="w-full bg-[#C49A5C] text-white py-3 rounded-xl font-semibold hover:bg-[#b08b52] transition-colors shadow-lg">
                         Booking Meja
                    </button>
                </template>

                 <template x-if="mode === 'delivery'">
                    <button @click="goToCheckout" class="w-full bg-[#C49A5C] text-white py-3 rounded-xl font-semibold hover:bg-[#b08b52] transition-colors shadow-lg shadow-[#C49A5C]/20">
                        Lanjut ke Pengiriman
                    </button>
                </template>
            </div>
        </div>

        <!-- ================= MOBILE BAR ================= -->
        <div class="xl:hidden fixed bottom-0 left-0 right-0 bg-white border-t p-4 z-40 shadow-[0_-4px_20px_rgba(0,0,0,0.05)]">
            <div class="flex justify-between mb-2 text-sm">
                <span x-text="cart.length + ' item'"></span>
                <span class="font-semibold text-[#C49A5C]" x-text="'Rp ' + totalPrice.toLocaleString()"></span>
            </div>
             <div class="grid grid-cols-2 gap-2">
                 <button class="bg-[#C49A5C] text-white py-3 rounded-xl font-semibold hover:bg-[#b08b52] transition-colors text-sm">
                     Booking Meja
                </button>
                <button @click="goToCheckout" class="bg-[#C49A5C] text-white py-3 rounded-xl font-semibold hover:bg-[#b08b52] transition-colors text-sm">
                    Pesan Antar
                </button>
             </div>
        </div>
    </section>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    function kulinerDetail() {
        return {
            activeCategory: 'makanan',
            mode: 'booking', // booking or delivery
            people: 2,
            cart: [],
            map: null,
            init() {
                // Initialize Map if coordinates exist
                @if($$module_name_singular->latitude && $$module_name_singular->longitude)
                    this.$nextTick(() => {
                        this.map = L.map('map').setView([{{ $$module_name_singular->latitude }}, {{ $$module_name_singular->longitude }}], 15);
                        
                        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 19,
                            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                        }).addTo(this.map);

                        L.marker([{{ $$module_name_singular->latitude }}, {{ $$module_name_singular->longitude }}]).addTo(this.map)
                            .bindPopup("<b>{{ $$module_name_singular->name }}</b><br>{{ $$module_name_singular->location }}")
                            .openPopup();
                    });
                @endif
            },
            categories: [
                { key: "makanan", label: "🍛 Makanan" },
                { key: "minuman", label: "🥤 Minuman" },
                { key: "cemilan", label: "🍟 Cemilan" },
            ],
            menus: {!! $$module_name_singular->menus()->orderBy('sort_order')->get()->map(function($menu) {
                return [
                    'id' => $menu->id,
                    'name' => $menu->name,
                    'price' => (int) $menu->price,
                    'category' => $menu->category,
                    'image' => $menu->image
                ];
            })->toJson() !!},
            get filteredMenus() {
                return this.menus.filter(menu => menu.category === this.activeCategory);
            },
            get totalPrice() {
                return this.cart.reduce((sum, item) => sum + item.price * item.qty, 0);
            },
            addToCart(menu) {
                const exist = this.cart.find((item) => item.id === menu.id);
                if (exist) {
                    exist.qty++;
                } else {
                    this.cart.push({ ...menu, qty: 1 });
                }
            },
            increaseQty(id) {
                const item = this.cart.find((item) => item.id === id);
                if (item) item.qty++;
            },
            decreaseQty(id) {
                const item = this.cart.find((item) => item.id === id);
                if (item) {
                    item.qty--;
                    if (item.qty <= 0) {
                        this.removeItem(id);
                    }
                }
            },
            removeItem(id) {
                this.cart = this.cart.filter((item) => item.id !== id);
            },
            goToCheckout() {
                if (this.cart.length === 0) return alert("Pilih menu dulu!");
                localStorage.setItem('culinary_cart', JSON.stringify(this.cart));
                window.location.href = "{{ route('frontend.culinaries.checkout', $$module_name_singular->id) }}";
            }
        }
    }
</script>

@endsection