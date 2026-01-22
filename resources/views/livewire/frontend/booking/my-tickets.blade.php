<div class="pt-32 pb-20 min-h-screen bg-gray-50 relative">
    <div class="container mx-auto px-6 relative z-10">
        
        <div class="flex items-center justify-between mb-8" data-aos="fade-down">
            <h1 class="text-3xl md:text-4xl font-serif text-gray-900 font-medium">Tiket Saya</h1>
            <a href="{{ route('home') }}" wire:navigate class="text-sm font-medium text-gray-500 hover:text-prestige-gold transition">
                Kembali ke Beranda
            </a>
        </div>

        @if($bookings->isEmpty())
            <div class="bg-white rounded-3xl p-12 text-center border border-gray-100 shadow-xl" data-aos="fade-up">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="material-symbols-outlined text-4xl text-gray-400">confirmation_number</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Tiket</h3>
                <p class="text-gray-500 mb-8">Anda belum memesan tiket wisata apapun.</p>
                <a href="{{ route('home') }}" wire:navigate class="inline-block bg-gray-900 text-white px-8 py-3 rounded-full font-bold hover:bg-gray-800 transition shadow-lg">
                    Jelajahi Wisata
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 gap-6">
                @foreach($bookings as $booking)
                    <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-md hover:shadow-xl transition-all duration-300 grid grid-cols-1 md:grid-cols-[12rem_1fr] gap-6 group" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        
                        {{-- Image --}}
                        <div class="w-full h-48 md:h-full rounded-2xl overflow-hidden relative shadow-sm">
                             <img src="{{ $booking->tourism->image }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        </div>

                        {{-- Content --}}
                        <div class="w-full min-w-0 flex flex-col justify-between">
                            <div>
                                <div class="flex flex-wrap justify-between items-start gap-4 mb-3">
                                    <div>
                                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1 block">Tiket Wisata</span>
                                        <h3 class="text-xl font-serif font-bold text-gray-900 truncate pr-4">{{ $booking->tourism->name }}</h3>
                                    </div>
                                    
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-700',
                                            'paid' => 'bg-green-100 text-green-700',
                                            'cancelled' => 'bg-red-100 text-red-700',
                                            'failed' => 'bg-red-100 text-red-700',
                                        ];
                                        $statusColor = $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-700';
                                        
                                        $statusLabels = [
                                            'pending' => 'Menunggu Pembayaran',
                                            'paid' => 'Lunas',
                                            'cancelled' => 'Dibatalkan',
                                            'failed' => 'Gagal',
                                        ];
                                    @endphp
                                    <span class="flex-shrink-0 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide {{ $statusColor }}">
                                        {{ $statusLabels[$booking->status] ?? $booking->status }}
                                    </span>
                                </div>

                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-4 text-left">
                                    <div>
                                        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Tanggal</p>
                                        <p class="font-medium text-gray-900 text-sm">{{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d M Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Jumlah</p>
                                        <p class="font-medium text-gray-900 text-sm">{{ $booking->quantity }} Orang</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Total</p>
                                        <p class="font-bold text-gray-900 text-sm">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Kode Booking</p>
                                        <p class="font-mono text-gray-900 text-sm truncate">#{{ $booking->id }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-6 flex gap-3 justify-end border-t border-gray-50 pt-4">
                                @if($booking->status == 'pending' && $booking->snap_token)
                                    <a href="{{ route('frontend.booking.checkout', $booking->tourism->slug) }}" class="text-sm font-bold text-gray-900 hover:text-prestige-gold transition">
                                        Lanjut Bayar &rarr;
                                    </a>
                                @elseif($booking->status == 'paid')
                                    <a href="{{ route('frontend.booking.success', $booking->id) }}" class="text-sm font-bold text-prestige-gold hover:text-gray-900 transition flex items-center gap-1">
                                        <span class="material-symbols-outlined text-lg">receipt_long</span>
                                        Lihat E-Tiket
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
