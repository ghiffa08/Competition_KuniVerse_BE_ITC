@extends('frontend.layouts.app')

@section('title') Checkout - {{ $culinary->name }} @endsection

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
                <h2 class="text-xl font-serif font-semibold mb-4">Delivery Location</h2>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Pin Location (For Courier finding your house)</label>
                    <div id="delivery-map" class="mb-2 shadow-inner"></div>
                    <p class="text-xs text-gray-500">Drag marker to adjust address text</p>
                </div>



                <div class="form-group mb-4">
                    <label class="block text-sm font-medium mb-1">Full Address</label>
                    <textarea x-model="form.address" class="w-full border rounded-lg p-3 text-sm focus:ring-[#C49A5C] focus:border-[#C49A5C]" rows="3" placeholder="Street name, house number, details..."></textarea>
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
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100" x-show="rates.length > 0">
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
            <div x-show="rates.length === 0 && selectedDestinationId && !isLoading" class="bg-blue-50 p-4 rounded-xl text-center text-sm text-blue-600">
                <p>Calculating rates available...</p>
                 <button @click="checkRates" class="text-xs text-blue-500 hover:underline mt-2">Retry</button>
            </div>
        </div>

        <!-- RIGHT: Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-28">
                <h2 class="text-xl font-serif font-semibold mb-4">Order Summary</h2>
                <h4 class="text-sm font-semibold text-gray-500 mb-4">{{ $culinary->name }}</h4>

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
                    class="w-full bg-[#C49A5C] text-white py-3 rounded-xl font-semibold hover:bg-[#b08b52] transition-colors shadow-lg disabled:opacity-50 disabled:cursor-not-allowed">
                    PAY NOW
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

            <a href="{{ route('frontend.culinaries.index') }}" class="inline-block bg-[#C49A5C] text-white px-8 py-3 rounded-xl font-semibold hover:bg-[#b08b52] transition-colors shadow-lg">
                Back to Menu
            </a>
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    function checkoutPage() {
        // Define map and marker outside of the Alpine data object to avoid Proxy reactivity issues
        let map = null;
        let marker = null;

        return {
            culinaryId: {{ $culinary->id }},
            restaurantLat: {{ $culinary->latitude ?? -6.966667 }},
            restaurantLng: {{ $culinary->longitude ?? 108.466667 }},
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
            // Removed map and marker from here
            
            init() {
                // Load Cart
                const storedCart = localStorage.getItem('culinary_cart');
                if (storedCart) {
                    this.cart = JSON.parse(storedCart);
                } else {
                    alert('Cart is empty!');
                    window.location.href = "{{ route('frontend.culinaries.show', $culinary->id) }}";
                }

                // Init Map
                this.$nextTick(() => {
                    this.initMap();
                });
            },

            async searchDestination() {
                if(this.searchQuery.length < 3) return;
                this.isSearching = true;
                
                try {
                    const res = await fetch("{{ route('frontend.culinaries.search_destination') }}?term=" + this.searchQuery);
                    const data = await res.json();
                     // Komerce might return data in 'items' or directly array
                    this.searchResults = Array.isArray(data) ? data : (data.items || []);
                } catch(e) { console.error(e); }
                finally { this.isSearching = false; }
            },
            
            selectDestination(result) {
                this.selectedDestinationId = result.id;
                this.selectedDestinationName = result.display_name;
                this.searchQuery = ''; // Clear search or keep name? User preference.
                this.searchResults = []; // Close dropdown
                this.resetRates();
                
                // Auto-check rates
                this.checkRates();
            },
            
            resetRates() {
                this.rates = [];
                this.selectedCourier = null;
                this.deliveryFee = 0;
            },

            get subtotal() {
                return this.cart.reduce((sum, item) => sum + item.price * item.qty, 0);
            },

            get grandTotal() {
                return this.subtotal + this.deliveryFee;
            },

            get isValidOrder() {
                return this.cart.length > 0 && this.selectedCourier && this.form.name && this.form.phone && this.form.email && this.form.address;
            },

            initMap() {
                // Default to restaurant location for initial view if no user loc yet
                const defaultLat = this.restaurantLat; 
                const defaultLng = this.restaurantLng; 
                
                // Assign to local variable 'map'
                map = L.map('delivery-map').setView([defaultLat, defaultLng], 13);
                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', { 
                    maxZoom: 19,
                    attribution: '© OpenStreetMap'
                }).addTo(map);

                // Add Search Control
                L.Control.geocoder({
                    defaultMarkGeocode: false,
                    position: 'topleft',
                    placeholder: 'Search location...',
                })
                .on('markgeocode', function(e) {
                    const bbox = e.geocode.bbox;
                    const poly = L.polygon([
                        bbox.getSouthEast(),
                        bbox.getNorthEast(),
                        bbox.getNorthWest(),
                        bbox.getSouthWest()
                    ]);
                    // Access 'map' via 'this._map' since it's attached to control
                    this._map.fitBounds(poly.getBounds());
                    
                    // Update marker position
                    const center = e.geocode.center;
                    window.checkoutComponent.updateMarker(center.lat, center.lng); // Access via global or context
                })
                .addTo(map);

                // Restaurant Marker
                L.marker([this.restaurantLat, this.restaurantLng]).addTo(map)
                    .bindPopup("<b>Restaurant</b>");

                // Draggable User Marker (initially offset)
                // Assign to local variable 'marker'
                marker = L.marker([defaultLat - 0.01, defaultLng - 0.01], {draggable: true}).addTo(map)
                    .bindPopup("<b>My Delivery Location</b><br>Drag me!").openPopup();

                // Set initial form values
                const pos = marker.getLatLng();
                this.form.lat = pos.lat;
                this.form.lng = pos.lng;
                
                // Expose component instance for global access if needed
                window.checkoutComponent = this;

                marker.on('dragend', (e) => {
                    const pos = e.target.getLatLng();
                    this.updateMarker(pos.lat, pos.lng);
                });
                
                // Click map to move marker
                map.on('click', (e) => {
                    this.updateMarker(e.latlng.lat, e.latlng.lng);
                });
                
                // Try to reverse geocode initial position? Maybe not, usually incorrect.
            },

            updateMarker(lat, lng) {
                if(marker) {
                    marker.setLatLng([lat, lng]);
                    this.form.lat = lat;
                    this.form.lng = lng;
                    this.rates = []; // Clear old rates
                    this.selectedCourier = null;
                    this.deliveryFee = 0;
                    
                    // Reverse Geocode
                    this.reverseGeocode(lat, lng);
                }
            },

            locateMe() {
                if (!navigator.geolocation) {
                    alert("Geolocation is not supported by your browser");
                    return;
                }
                
                const btn = document.querySelector('button[click="locateMe"] svg'); // Visual feedback
                // Add spinning animation class if you had one
                
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        if(map) map.setView([lat, lng], 16);
                        this.updateMarker(lat, lng);
                    },
                    (error) => {
                        alert("Unable to retrieve your location: " + error.message);
                    }
                );
            },

            async reverseGeocode(lat, lng) {
                try {
                    // Use local proxy to avoid CORS
                    const response = await fetch(`{{ route('frontend.culinaries.reverse_geocode') }}?lat=${lat}&lng=${lng}`);

                    const data = await response.json();
                    if (data && data.address) {
                        const addr = data.display_name;
                        this.form.address = addr;
                        
                        console.log('📍 Geocoded address:', data.address);
                        
                        // Try multiple address fields in priority order
                        const possibleTerms = [
                            data.address.city,
                            data.address.town,
                            data.address.municipality,
                            data.address.county,
                            data.address.state_district,
                            data.address.state,
                            data.address.province
                        ].filter(Boolean); // Remove null/undefined
                        
                        console.log('🔍 Trying search terms:', possibleTerms);
                        
                        // Try each term until we find a match
                        let foundMatch = false;
                        
                        for(let rawTerm of possibleTerms) {
                            if(foundMatch) break;
                            
                            // Clean up search term
                            let searchTerm = rawTerm.replace(/^(Kabupaten|Kota|Kec\.|Kecamatan)\s+/i, '');
                            
                            console.log(`🔎 Searching with term: "${searchTerm}"`);
                            
                            this.isSearching = true;
                            try {
                                const res = await fetch("{{ route('frontend.culinaries.search_destination') }}?term=" + encodeURIComponent(searchTerm));
                                const results = await res.json();
                                
                                console.log(`📦 Results for "${searchTerm}":`, results.length);
                                
                                if (results.length > 0) {
                                    // Auto Select the first match
                                    console.log('✅ Auto-selected:', results[0].display_name);
                                    this.selectDestination(results[0]);
                                    foundMatch = true;
                                }
                            } catch(e) {
                                console.error('Auto search failed', e);
                            } finally {
                                this.isSearching = false;
                            }
                        }
                        
                        if(!foundMatch) {
                            console.warn('⚠️ No destination match found after trying all terms');
                            // Show the search box with the best guess
                            this.searchQuery = possibleTerms[0] || '';
                        }
                    }
                } catch (e) {
                    console.error("Reverse geocoding failed", e);
                }
            },

            async checkRates() {
                if (!this.selectedDestinationId) {
                    console.warn('No destination selected yet');
                    return;
                }
                if (this.cart.length === 0) {
                    console.warn('Cart is empty');
                    return;
                }
                
                this.isLoading = true;
                this.rates = [];
                
                console.log('🚚 Checking shipping rates...', {
                    destination_id: this.selectedDestinationId,
                    weight: 1
                });
                
                try {
                    const response = await fetch("{{ route('frontend.culinaries.check_shipping') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            destination_id: this.selectedDestinationId,
                            weight: 1 // Weight in KG (will be converted to grams in backend)
                        })
                    });
                    
                    const data = await response.json();
                    console.log('📦 Shipping response:', data);
                    
                    if(data.status === false && data.message) throw new Error(data.message);
                    
                    let results = data.data || []; 
                    
                    if(results.length === 0) {
                        console.warn('⚠️ No shipping options returned from API');
                        alert('No couriers available for this destination. Please try another location.');
                        return;
                    }
                    
                    // Normalize response
                    this.rates = results.map(r => ({
                         code: r.code || r.shipper_name,
                         service: r.service || r.service_name,
                         price: r.price || r.total_price || r.cost,
                         etd: r.etd || r.estimation || '-'
                    }));
                    
                    console.log('✅ Rates loaded:', this.rates.length, 'options');

                } catch (e) {
                    console.error('❌ Failed to check rates:', e);
                    alert('Failed to check rates: ' + e.message);
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
                
                try {
                    const response = await fetch("{{ route('frontend.culinaries.store_order') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            culinary_id: this.culinaryId,
                            customer_name: this.form.name,
                            customer_phone: this.form.phone,
                            customer_email: this.form.email,
                            delivery_address: this.form.address,
                            dest_lat: this.form.lat,
                            dest_lng: this.form.lng,
                            delivery_cost: this.deliveryFee,
                            total_price: this.subtotal,
                            items: this.cart,
                            courier_name: this.selectedCourier.code,
                            courier_service: this.selectedCourier.service,
                            courier_desc: 'Standard'
                        })
                    });

                    const result = await response.json();
                    
                    if (result.success && result.snap_token) {
                        window.snap.pay(result.snap_token, {
                            onSuccess: function(paymentResult) {
                                console.log('Payment Success!', paymentResult);
                                localStorage.removeItem('culinary_cart');
                                
                                // Show Receipt UI
                                self.showReceipt = true;
                                self.receiptData = {
                                    orderId: paymentResult.order_id,
                                    paymentType: paymentResult.payment_type
                                };
                                window.scrollTo({ top: 0, behavior: 'smooth' });
                            },
                            onPending: function(result) {
                                alert("Waiting for payment!");
                            },
                            onError: function(result) {
                                alert("Payment failed!");
                            },
                            onClose: function() {
                                alert('You closed the popup without finishing the payment');
                            }
                        });
                    } else {
                        alert('Order creation failed: ' + result.message);
                    }
                } catch (e) {
                    alert('Error: ' + e.message);
                }
            }
        }
    }
</script>
@endsection
