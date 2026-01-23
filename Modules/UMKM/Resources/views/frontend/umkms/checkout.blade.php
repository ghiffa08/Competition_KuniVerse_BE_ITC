@extends('frontend.layouts.app')

@section('title') Checkout - {{ $umkm->name }} @endsection

@push('after-styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <style>
        #delivery-map { height: 350px; width: 100%; border-radius: 0.75rem; z-index: 0; }
        .courier-card { transition: all 0.2s; border: 2px solid transparent; }
        .courier-option:checked + .courier-card { border-color: #C49A5C; background-color: #FDF8F3; transform: translateY(-2px); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .btn-locate { position: absolute; bottom: 20px; right: 20px; z-index: 400; background: white; padding: 8px; border-radius: 50%; box-shadow: 0 2px 5px rgba(0,0,0,0.2); cursor: pointer; transition: transform 0.2s; }
        .btn-locate:hover { transform: scale(1.1); }
        .search-results { max-height: 200px; overflow-y: auto; z-index: 50; }
    </style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50 pt-28 pb-20" x-data="checkoutPage()">
    <!-- CHECKOUT FORM -->
    <div x-show="!showReceipt" class="container mx-auto px-4 md:px-10 xl:px-20 grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- LEFT: Delivery Details -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h2 class="text-xl font-serif font-semibold mb-4" x-text="mode === 'delivery' ? 'Delivery Location' : 'Contact Details'"></h2>
                
                <div x-show="mode === 'pickup'" class="mb-6 bg-[#C49A5C]/10 p-4 rounded-xl border border-[#C49A5C]/20">
                    <h3 class="font-semibold text-[#8B6B3D] mb-2 flex items-center gap-2">
                        <span class="material-symbols-outlined">store</span>
                        Pickup Details
                    </h3>
                    <p class="text-sm text-gray-700">Please pick up your order at the store location.</p>
                </div>

                <div class="mb-4" x-show="mode === 'delivery'">
                    <label class="block text-sm font-medium mb-1">Pin Location (For Courier finding your house)</label>
                    <div id="delivery-map" class="mb-2 shadow-inner"></div>
                    <p class="text-xs text-gray-500">Drag marker to adjust address text</p>
                </div>

                <div class="form-group mb-4" x-show="mode === 'delivery'">
                    <label class="block text-sm font-medium mb-1">Full Address</label>
                    <textarea x-model="form.address" class="w-full border rounded-lg p-3 text-sm focus:ring-[#C49A5C] focus:border-[#C49A5C]" rows="3" placeholder="Street name, house number, details..."></textarea>
                </div>
                
                 <!-- New Destination Search -->
                <div class="relative mb-4" x-show="mode === 'delivery'">
                    <label class="block text-sm font-medium mb-1">City / District (For Shipping Calculation)</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-3 text-gray-400">location_on</span>
                        <input type="text" 
                             x-model="searchQuery"
                             @focus="searchQuery.length >= 3 ? isSearching = true : null"
                             class="w-full pl-10 pr-4 py-2 border rounded-xl focus:ring-[#C49A5C] focus:border-[#C49A5C]" 
                             placeholder="Search your city or sub-district...">
                         <div x-show="isSearching" class="absolute right-3 top-3 text-gray-400">
                            <span class="animate-spin material-symbols-outlined text-sm">refresh</span>
                        </div>
                    </div>

                    <!-- Dropdown Results -->
                    <div x-show="searchResults.length > 0" class="search-results absolute z-50 w-full bg-white border rounded-xl mt-1 shadow-lg">
                        <ul>
                            <template x-for="item in searchResults" :key="item.id">
                                <li @click="selectDestination(item)" class="px-4 py-3 hover:bg-gray-50 cursor-pointer border-b last:border-0 flex flex-col justify-center h-16 transition-colors">
                                    <span class="font-semibold text-gray-800" x-text="item.display_name"></span>
                                    <span class="text-xs text-gray-500" x-text="item.type + ' - ' + item.province_name"></span>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Your Name</label>
                            <input type="text" x-model="form.name" class="w-full border rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#C49A5C]">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Phone Number</label>
                            <input type="text" x-model="form.phone" class="w-full border rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#C49A5C]">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Email for Receipt</label>
                        <input type="email" x-model="form.email" class="w-full border rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#C49A5C]" placeholder="example@mail.com">
                    </div>
            </div>

            <!-- Shipping Options -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100" x-show="mode === 'delivery' && rates.length > 0">
                <h2 class="text-xl font-serif font-semibold mb-4">Select Shipping</h2>
                <!-- RajaOngkir often returns couriers separately, but we will flat map them for UI -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <template x-for="rate in rates" :key="rate.code + rate.service + Math.random()">
                        <label class="cursor-pointer block h-full">
                            <input type="radio" name="courier" class="courier-option hidden" 
                                @change="selectCourier(rate)">
                            <div class="courier-card border border-gray-200 rounded-xl p-4 h-full flex flex-col justify-between hover:border-gray-300 bg-white">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-500 uppercase" x-text="(rate.code || '').substring(0,2)"></div>
                                        <div>
                                            <span class="font-bold uppercase text-gray-800" x-text="rate.code"></span>
                                            <p class="text-xs text-gray-500 font-medium" x-text="rate.service"></p>
                                        </div>
                                    </div>
                                    <span class="font-bold text-[#C49A5C]" x-text="'Rp ' + (rate.price || 0).toLocaleString()"></span>
                                </div>
                                <div class="flex items-center gap-1 text-xs text-gray-400 mt-2 pt-2 border-t border-dashed">
                                    <span x-text="rate.etd ? (rate.etd + (String(rate.etd).toLowerCase().includes('day') || String(rate.etd).toLowerCase().includes('hari') ? '' : ' Days')) : 'Standard'"></span>
                                </div>
                            </div>
                        </label>
                    </template>
                </div>
            </div>
            
            <!-- Auto-Calculate Active -->
            <div x-show="mode === 'delivery' && rates.length === 0 && selectedDestinationId && !isLoading" class="bg-blue-50 p-4 rounded-xl text-center text-sm text-blue-600">
                <p>Calculating rates available...</p>
                 <button @click="checkRates" class="text-xs text-blue-500 hover:underline mt-2">Retry</button>
            </div>
        </div>

        <!-- RIGHT: Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-28">
                <h2 class="text-xl font-serif font-semibold mb-4">Order Summary</h2>
                <h4 class="text-sm font-semibold text-gray-500 mb-4">{{ $umkm->name }}</h4>

                <div class="space-y-3 mb-6 border-b pb-4">
                    <template x-for="item in cart" :key="item.id">
                        <div class="flex justify-between text-sm">
                            <span><span x-text="item.qty"></span>x <span x-text="item.name"></span></span>
                            <span x-text="'Rp ' + (item.price * item.qty).toLocaleString()"></span>
                        </div>
                    </template>
                </div>

                <div class="space-y-2 text-sm mb-6">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span x-text="'Rp ' + subtotal.toLocaleString()"></span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Delivery Fee</span>
                        <span x-text="deliveryFee > 0 ? 'Rp ' + deliveryFee.toLocaleString() : '-'"></span>
                    </div>
                    <div class="flex justify-between font-bold text-lg pt-2 border-t">
                        <span>Total</span>
                        <span class="text-[#C49A5C]" x-text="'Rp ' + grandTotal.toLocaleString()"></span>
                    </div>
                </div>

                <button @click="processPayment" 
                    :disabled="!isValidOrder"
                    class="w-full bg-[#C49A5C] text-white py-3 rounded-xl font-semibold hover:bg-[#b08b52] transition-colors shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                    x-text="mode === 'pickup' ? 'CONFIRM ORDER' : 'PAY NOW'">
                </button>
            </div>
        </div>
    </div>

    <!-- RECEIPT UI -->
    <div x-show="showReceipt" class="container mx-auto px-4 md:px-10 xl:px-20 max-w-3xl pt-10" style="display: none;">
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 text-center">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <h2 class="text-3xl font-serif font-bold text-gray-800 mb-2">Payment Successful!</h2>
            <p class="text-gray-500 mb-8">Thank you for your order. Here is your receipt.</p>

            <div class="bg-gray-50 rounded-xl p-6 mb-8 text-left">
                <div class="flex justify-between mb-4 border-b border-gray-200 pb-4">
                    <span class="text-gray-600">Order ID</span>
                    <span class="font-bold text-gray-800" x-text="receiptData.orderId || '-'"></span>
                </div>
                 <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Date</span>
                    <span class="font-bold text-gray-800" x-text="new Date().toLocaleDateString()"></span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Name</span>
                    <span class="font-bold text-gray-800" x-text="form.name"></span>
                </div>
                 <div class="flex justify-between mb-4 border-b border-gray-200 pb-4">
                    <span class="text-gray-600">Payment Status</span>
                    <span class="font-bold text-green-600">PAID</span>
                </div>
                
                 <div class="space-y-2 mb-4 border-b border-gray-200 pb-4">
                    <template x-for="item in cart" :key="item.id">
                        <div class="flex justify-between text-sm">
                            <span><span x-text="item.qty"></span>x <span x-text="item.name"></span></span>
                            <span x-text="'Rp ' + (item.price * item.qty).toLocaleString()"></span>
                        </div>
                    </template>
                     <div class="flex justify-between text-sm text-gray-600" x-show="deliveryFee > 0">
                        <span>Delivery Fee</span>
                        <span x-text="'Rp ' + (deliveryFee).toLocaleString()"></span>
                    </div>
                 </div>

                <div class="flex justify-between text-lg font-bold text-[#C49A5C]">
                    <span>Total Paid</span>
                    <span x-text="'Rp ' + grandTotal.toLocaleString()"></span>
                </div>
            </div>

            <a href="{{ route('frontend.umkms.index') }}" class="inline-block bg-[#C49A5C] text-white px-8 py-3 rounded-xl font-semibold hover:bg-[#b08b52] transition-colors shadow-lg">
                Back to UMKM List
            </a>
        </div>
    </div>
</div>
@endsection

@push('after-scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    function checkoutPage() {
        // Define map and marker outside of the Alpine data object to avoid Proxy reactivity issues
        let map = null;
        let marker = null;
        const params = new URLSearchParams(window.location.search);
        const mode = params.get('mode') || 'delivery';

        return {
            mode: mode,
            umkmId: {{ $umkm->id }},
            restaurantLat: {{ $umkm->latitude ?? -6.966667 }},
            restaurantLng: {{ $umkm->longitude ?? 108.466667 }},
            cart: [],
            searchQuery: '',
            searchResults: [],
            isSearching: false,
            selectedDestinationId: null,
            selectedDestinationName: '',
            rates: [],
            isLoading: false,
            showReceipt: false,
            receiptData: {},
            deliveryFee: 0,
            selectedCourier: null,
            form: {
                name: 'Guest User',
                phone: '',
                email: '',
                address: '',
                lat: null,
                lng: null
            },
            
            init() {
                // Load Cart
                const storedCart = localStorage.getItem('umkm_cart');
                if (storedCart) {
                    this.cart = JSON.parse(storedCart);
                } else {
                    alert('Cart is empty!');
                    window.location.href = "{{ route('frontend.umkms.show', $umkm->slug) }}";
                }

                // Check for payment result from Midtrans redirect
                const snapToken = params.get('snap_token');
                const orderId = params.get('order_id');
                if (params.get('transaction_status') === 'settlement' || params.get('transaction_status') === 'capture') {
                     this.showReceipt = true;
                     this.receiptData = { orderId: orderId, status: 'PAID' };
                     localStorage.removeItem('umkm_cart');
                }

                this.$watch('searchQuery', (value) => {
                    this.performSearch(value);
                });

                // Initialize Leaflet Map for Delivery
                this.$nextTick(() => {
                    if (this.mode === 'delivery') {
                        this.initMap();
                    }
                });
            },

            initMap() {
                 // Prevent multiple init
                if (map) return;

                const defaultLat = this.restaurantLat || -6.966667;
                const defaultLng = this.restaurantLng || 108.466667;

                map = L.map('delivery-map').setView([defaultLat, defaultLng], 13);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                // Add draggable marker
                marker = L.marker([defaultLat, defaultLng], {
                    draggable: true,
                    autoPan: true
                }).addTo(map);
                
                // Initialize form lat/lng
                this.form.lat = defaultLat;
                this.form.lng = defaultLng;

                marker.on('dragend', (event) => {
                    var position = marker.getLatLng();
                    this.updatePosition(position.lat, position.lng);
                });
                
                // Click on map
                 map.on('click', (e) => {
                    marker.setLatLng(e.latlng);
                    this.updatePosition(e.latlng.lat, e.latlng.lng);
                });
                
                // Locate Me Button
                const locateBtn = L.DomUtil.create('div', 'btn-locate leaflet-bar');
                locateBtn.innerHTML = '<span class="material-symbols-outlined text-gray-600">my_location</span>';
                locateBtn.onclick = () => {
                   if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(position => {
                            const lat = position.coords.latitude;
                            const lng = position.coords.longitude;
                            map.setView([lat, lng], 16);
                            marker.setLatLng([lat, lng]);
                            this.updatePosition(lat, lng);
                        });
                    }
                };
                document.getElementById('delivery-map').appendChild(locateBtn);
            },
            
            async updatePosition(lat, lng) {
                this.form.lat = lat;
                this.form.lng = lng;
                
                // Reverse Geocode to get address text
                try {
                    const res = await fetch(`{{ route('frontend.umkms.reverse_geocode') }}?lat=${lat}&lng=${lng}`);
                    const data = await res.json();
                    if(data && data.display_name) {
                        this.form.address = data.display_name;
                    }
                } catch(e) {
                    console.log('Reverse geocode failed', e);
                }
            },

            performSearch(query) {
                if (query.length < 3) {
                    this.searchResults = [];
                    return;
                }
                this.isSearching = true;
                
                // Debounce could be added here
                fetch("{{ route('frontend.umkms.search_destination') }}?term=" + query)
                    .then(res => res.json())
                    .then(data => {
                        this.searchResults = data;
                        this.isSearching = false;
                    })
                    .catch(err => {
                         console.error(err);
                         this.isSearching = false;
                    });
            },

            selectDestination(item) {
                this.selectedDestinationId = item.id;
                this.selectedDestinationName = item.display_name;
                this.searchQuery = item.display_name;
                this.searchResults = []; // Close dropdown
                this.isSearching = false;
                
                // Reset Shipping
                this.rates = [];
                this.selectedCourier = null;
                this.deliveryFee = 0;
                
                // Trigger Check Shipping
                this.checkRates();
            },

            async checkRates() {
                if (!this.selectedDestinationId) return;
                
                this.isLoading = true;
                this.rates = [];
                
                try {
                    const response = await fetch("{{ route('frontend.umkms.check_shipping') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            destination_id: this.selectedDestinationId,
                            weight: 1 // Weight in KG
                        })
                    });
                    
                    const rates = await response.json();
                    this.rates = rates;
                    
                } catch(e) {
                    console.error("Shipping check failed", e);
                    alert("Failed to calculate shipping rates.");
                } finally {
                    this.isLoading = false;
                }
            },

            selectCourier(rate) {
                this.selectedCourier = rate;
                this.deliveryFee = rate.price;
            },

            async processPayment() {
                if (!this.isValidOrder) return;
                const self = this;
                
                const payload = {
                    umkm_id: this.umkmId,
                    name: this.form.name,
                    phone: this.form.phone,
                    email: this.form.email,
                    address: this.form.address,
                    cart: this.cart,
                    mode: this.mode
                };

                if (this.mode === 'delivery') {
                    payload.destination_id = this.selectedDestinationId;
                    payload.courier = this.selectedCourier;
                }

                try {
                    const response = await fetch("{{ route('frontend.umkms.store_order') }}", {
                        method: 'POST',
                        headers: {
                           'Content-Type': 'application/json',
                           'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(payload)
                    });
                    
                    const result = await response.json();
                    
                    if (result.status === 'success') {
                         window.snap.pay(result.snap_token, {
                            onSuccess: function(result){
                                // Redirect or show success
                                window.location.href = "{{ route('frontend.umkms.checkout', $umkm->id) }}?transaction_status=settlement&order_id=" + result.order_id + "&snap_token=" + result.snap_token;
                            },
                            onPending: function(result){
                                alert("Waiting for payment!");
                            },
                            onError: function(result){
                                alert("Payment failed!");
                            },
                            onClose: function(){
                                console.log('customer closed the popup without finishing the payment');
                            }
                        });
                    } else {
                        alert(result.message || 'Failed to create order');
                    }
                    
                } catch (e) {
                    console.error("Payment Error", e);
                    alert("System error upon checkout.");
                }
            },

            get subtotal() {
                return this.cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
            },

            get grandTotal() {
                return this.subtotal + this.deliveryFee;
            },

            get isValidOrder() {
                if (!this.form.name || !this.form.phone || !this.form.email) return false;
                if (this.mode === 'delivery') {
                    if (!this.form.address || !this.selectedCourier) return false;
                }
                return true;
            }
        };
    }
</script>
@endpush
