<div class="pt-32 pb-20 min-h-screen bg-gray-50 relative">
    
    <div class="container mx-auto px-6 relative z-10">
        {{-- Breadcrumb / Back --}}
        <div class="mb-8" data-aos="fade-right">
             <a href="{{ route('frontend.wisata.show', $tourism->slug) }}" wire:navigate class="inline-flex items-center gap-2 text-gray-500 hover:text-prestige-gold transition font-medium text-sm">
                 <span class="material-symbols-outlined text-lg">arrow_back</span>
                 Kembali ke Detail Wisata
             </a>
        </div>

        <h1 class="text-3xl md:text-4xl font-serif text-gray-900 mb-8 font-medium" data-aos="fade-up">Checkout Pemesanan</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 md:gap-12">
            {{-- Order Details Column --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Item Card --}}
                <div class="bg-white rounded-3xl p-6 md:p-8 border border-gray-100 shadow-xl shadow-gray-200/50 grid grid-cols-1 md:grid-cols-[12rem_1fr] gap-6 items-start" data-aos="fade-up" data-aos-delay="100">
                    {{-- Image Container --}}
                    <div class="w-full h-48 md:h-full rounded-2xl overflow-hidden shadow-md relative group">
                        <img src="{{ $tourism->image }}" alt="{{ $tourism->name }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    </div>
                    
                    {{-- Content --}}
                    <div class="w-full flex flex-col justify-between h-full min-w-0">
                        <div class="mb-4">
                             <span class="text-xs font-bold text-prestige-gold bg-prestige-gold/10 px-3 py-1 rounded-full uppercase tracking-wider mb-3 inline-block">Tiket Wisata</span>
                             <h3 class="text-2xl md:text-3xl font-serif font-bold text-gray-900 leading-tight truncate">{{ $tourism->name }}</h3>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-8 mt-auto border-t border-gray-50 pt-4">
                            <div>
                                <span class="block text-gray-400 text-[10px] sm:text-xs uppercase tracking-widest font-bold mb-1">Tanggal Kunjungan</span>
                                <div class="font-medium text-gray-900 flex items-center gap-2 bg-gray-50 px-3 py-2 rounded-lg border border-gray-100">
                                    <span class="material-symbols-outlined text-prestige-gold text-lg">calendar_month</span>
                                    <span class="text-sm">
                                        {{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}
                                    </span>
                                </div>
                            </div>
                            <div>
                                <span class="block text-gray-400 text-[10px] sm:text-xs uppercase tracking-widest font-bold mb-1">Jumlah Tiket</span>
                                <div class="font-medium text-gray-900 flex items-center gap-2 bg-gray-50 px-3 py-2 rounded-lg border border-gray-100">
                                    <span class="material-symbols-outlined text-prestige-gold text-lg">groups</span>
                                    <span class="text-sm">
                                        {{ $quantity }} Orang
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Customer Details --}}
                <div class="bg-white rounded-3xl p-6 md:p-8 border border-gray-100 shadow-xl shadow-gray-200/50" data-aos="fade-up" data-aos-delay="200">
                    <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2 border-b border-gray-100 pb-4">
                        <span class="material-symbols-outlined text-gray-400">person</span>
                        Informasi Pemesan
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Nama Lengkap</label>
                            <div class="text-gray-900 font-medium bg-gray-50 px-4 py-3 rounded-xl border border-gray-200">
                                {{ Auth::user()->name }}
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Email</label>
                            <div class="text-gray-900 font-medium bg-gray-50 px-4 py-3 rounded-xl border border-gray-200">
                                {{ Auth::user()->email }}
                            </div>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-6 flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">info</span>
                        E-Tiket akan dikirimkan ke email ini setelah pembayaran berhasil.
                    </p>
                </div>
            </div>

            {{-- Summary Sidebar --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl p-6 md:p-8 border border-gray-100 shadow-xl shadow-gray-200/50 sticky top-32" data-aos="fade-up" data-aos-delay="300">
                    <h2 class="text-lg font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Rincian Pembayaran</h2>

                    <div class="space-y-4 mb-8">
                        <div class="flex justify-between text-gray-600 text-sm">
                            <span>Harga Satuan</span>
                            <span>Rp {{ number_format($tourism->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600 text-sm">
                            <span>Kuantitas</span>
                            <span>x {{ $quantity }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600 text-sm">
                            <span>Biaya Layanan</span>
                            <span class="text-green-600 font-medium">Gratis</span>
                        </div>
                        <div class="border-t border-dashed border-gray-200 pt-4 mt-4">
                            <div class="flex justify-between items-end">
                                <span class="text-gray-900 font-bold">Total Pembayaran</span>
                                <span class="text-2xl font-serif font-bold text-prestige-gold">Rp {{ number_format($total_price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    @error('midtrans')
                        <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm mb-4 border border-red-100 flex items-start gap-2">
                            <span class="material-symbols-outlined text-base mt-0.5">error</span>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror

                    @if($snapToken)
                        <button onclick="manualPay('{{ $snapToken }}', '{{ $bookingId }}')" class="w-full py-4 rounded-xl bg-[#C49A5C] text-white font-bold shadow-lg hover:bg-[#b08b52] transition-all transform hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center gap-2">
                            <span>BAYAR SEKARANG</span>
                            <span class="material-symbols-outlined">payments</span>
                        </button>
                    @else
                        <button wire:click="checkout" wire:loading.attr="disabled" class="w-full py-4 rounded-xl bg-[#C49A5C] text-white font-bold shadow-lg hover:bg-[#b08b52] transition-all transform hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                            <span wire:loading.remove>LANJUT KE PEMBAYARAN</span>
                            <span wire:loading.remove class="material-symbols-outlined">arrow_forward</span>
                            <span wire:loading>MEMPROSES...</span>
                        </button>
                    @endif
                    
                    <div class="mt-6 flex justify-center gap-4 opacity-50 grayscale hover:grayscale-0 transition-all duration-500">
                         <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e1/Logo_of_GoPay.svg/2560px-Logo_of_GoPay.svg.png" class="h-4 object-contain">
                         <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Logo_dana_blue.svg/2560px-Logo_dana_blue.svg.png" class="h-4 object-contain">
                         <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5c/Bank_Central_Asia.svg/2560px-Bank_Central_Asia.svg.png" class="h-4 object-contain">
                         <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/68/BANK_BRI_logo.svg/2560px-BANK_BRI_logo.svg.png" class="h-4 object-contain">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Always load Snap JS --}}
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    
    <script>
        // Define manualPay globally
        window.manualPay = function(token, bookingId) {
            if(typeof snap === 'undefined'){
                alert("Sistem pembayaran belum siap. Mohon refresh halaman.");
                return;
            }
            snap.pay(token, {
                onSuccess: function(result){
                    // Redirect to success page with Booking ID
                    let url = "{{ route('frontend.booking.success', ':id') }}";
                    url = url.replace(':id', bookingId);
                    window.location.href = url;
                },
                onPending: function(result){ console.log(result); },
                onError: function(result){ console.log(result); alert("Payment failed!"); },
                onClose: function(){ console.log('Popup closed'); }
            });
        }

        document.addEventListener('livewire:initialized', () => {
            Livewire.on('trigger-payment', (event) => {
                // Determine token: check if event is object or direct value
                // format: { token: '...', bookingId: '...', paymentUrl: '...' }
                
                let rawEvent = (Array.isArray(event) ? event[0] : event) || {}; 
                
                let token = rawEvent.token;
                let bookingId = rawEvent.bookingId;
                let paymentUrl = rawEvent.paymentUrl;
                
                console.log("Triggering Snap with token:", token);

                if(token){
                    if(typeof snap !== 'undefined'){
                        snap.pay(token, {
                            onSuccess: function(result){
                                // Redirect to success page with Booking ID
                                let url = "{{ route('frontend.booking.success', ':id') }}";
                                if(bookingId) {
                                    url = url.replace(':id', bookingId);
                                    window.location.href = url;
                                } else {
                                    window.location.href = "{{ route('home') }}";
                                }
                            },
                            onPending: function(result){
                                console.log(result);
                            },
                            onError: function(result){
                                console.log(result);
                                alert("Payment failed!");
                            },
                            onClose: function(){
                                console.log('Popup closed');
                            }
                        });
                    } else {
                        console.error("Snap JS not loaded");
                        // Fallback to paymentUrl if Snap fails
                        if(paymentUrl) {
                             window.location.href = paymentUrl;
                        } else {
                             alert("Gagal memuat sistem pembayaran. Coba refresh halaman.");
                        }
                    }
                } else {
                    console.error("Token not received");
                }
            });
        });
    </script>
</div>
