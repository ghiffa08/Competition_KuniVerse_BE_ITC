<div class="pt-32 pb-20 min-h-screen bg-gray-50 relative">
    <div class="container mx-auto px-6 relative z-10">
        <div class="max-w-2xl mx-auto text-center" data-aos="fade-up">
            
            {{-- Success Icon --}}
            <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <span class="material-symbols-outlined text-5xl text-green-600">check_circle</span>
            </div>

            <h1 class="text-3xl font-serif font-bold text-gray-900 mb-2">Pembayaran Berhasil!</h1>
            <p class="text-gray-500 mb-10">Tiket elektronik telah dikirimkan ke email Anda.</p>

            {{-- Ticket Card --}}
            <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-xl overflow-hidden relative text-left">
                {{-- Decorative circles --}}
                <div class="absolute -left-4 top-1/2 w-8 h-8 bg-gray-50 rounded-full"></div>
                <div class="absolute -right-4 top-1/2 w-8 h-8 bg-gray-50 rounded-full"></div>
                <div class="absolute left-4 right-4 top-1/2 border-t-2 border-dashed border-gray-100"></div>

                {{-- Ticket Content --}}
                <div class="space-y-6 relative z-10">
                    <div class="flex items-start gap-4 mb-8">
                        <img src="{{ $booking->tourism->image }}" class="w-20 h-20 rounded-xl object-cover">
                        <div>
                            <span class="text-xs font-bold text-prestige-gold uppercase tracking-wider">Tiket Wisata</span>
                            <h3 class="text-xl font-bold text-gray-900 mt-1">{{ $booking->tourism->name }}</h3>
                            <p class="text-sm text-gray-500 mt-1">Kode Booking: <span class="font-mono text-gray-900">#{{ $booking->id }}</span></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6 pt-6">
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Tanggal</p>
                            <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('l, d F Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Pengunjung</p>
                            <p class="font-medium text-gray-900">{{ $booking->quantity }} Orang</p>
                        </div>
                        <div>
                             <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Pemesan</p>
                             <p class="font-medium text-gray-900">{{ $booking->user->name }}</p>
                        </div>
                        <div>
                             <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Total Bayar</p>
                             <p class="font-bold text-lg text-prestige-gold">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-10 space-y-3">
                <a href="{{ route('home') }}" class="block w-full bg-gray-900 text-white py-4 rounded-xl font-bold shadow-lg hover:bg-gray-800 transition-transform hover:scale-[1.02] active:scale-[0.98]">
                    Kembali ke Beranda
                </a>
            </div>

        </div>
    </div>
</div>
