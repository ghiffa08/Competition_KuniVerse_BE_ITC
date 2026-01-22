<div class="max-w-4xl mx-auto mt-12 mb-12" id="reviews-section">
    <h3 class="font-serif font-bold text-gray-900 mb-6 text-2xl flex items-center gap-2">
        <span class="material-symbols-outlined text-[#C49A5C]">star</span>
        Ulasan & Rating
    </h3>
    
    {{-- Review Form --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
        @auth
            <h4 class="font-bold text-lg mb-4">Tulis Ulasan Anda</h4>
            
            @if(session()->has('success'))
                <div class="bg-green-50 text-green-700 p-4 rounded-xl mb-4 text-sm font-medium flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">check_circle</span>
                    {{ session('success') }}
                </div>
            @endif

            <form wire:submit.prevent="submit">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                    <div class="flex gap-2">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" wire:click="$set('rating', {{ $i }})" class="focus:outline-none transition-transform hover:scale-110">
                                <span class="material-symbols-outlined text-3xl {{ $rating >= $i ? 'text-[#C49A5C]' : 'text-gray-300' }}"
                                      style="font-variation-settings: 'FILL' {{ $rating >= $i ? 1 : 0 }}, 'wght' 400, 'GRAD' 0, 'opsz' 48;">
                                    star
                                </span>
                            </button>
                        @endfor
                    </div>
                    @error('rating') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Komentar</label>
                    <textarea wire:model="review" rows="3" class="w-full border border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-[#C49A5C] focus:border-transparent transition" placeholder="Bagikan pengalaman Anda..."></textarea>
                    @error('review') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                
                <button type="submit" class="bg-[#C49A5C] text-white px-6 py-2 rounded-xl font-bold hover:bg-[#a6854e] transition shadow-md disabled:opacity-50">
                    <span wire:loading.remove>Kirim Ulasan</span>
                    <span wire:loading>Mengirim...</span>
                </button>
            </form>
        @else
            <div class="text-center py-6">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                    <span class="material-symbols-outlined text-3xl">rate_review</span>
                </div>
                <h4 class="font-bold text-gray-800 mb-2">Ingin menulis ulasan?</h4>
                <p class="text-gray-500 text-sm mb-4">Silakan login terlebih dahulu untuk membagikan pengalaman Anda.</p>
                <a href="{{ route('login') }}" class="inline-block border border-gray-300 px-6 py-2 rounded-xl font-bold text-gray-700 hover:bg-gray-50 transition">
                    Login Sekarang
                </a>
            </div>
        @endauth
    </div>
    
    {{-- Review List --}}
    <div class="space-y-4">
        @forelse($reviews as $reviewItem)
            <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 transition hover:bg-white hover:shadow-sm">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-[#C49A5C]/10 text-[#C49A5C] rounded-full flex items-center justify-center font-bold text-lg">
                            {{ substr($reviewItem->user->name, 0, 1) }}
                        </div>
                        <div>
                            <h5 class="font-bold text-gray-900 text-sm">{{ $reviewItem->user->name }}</h5>
                            <div class="flex text-[#C49A5C] text-xs">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="material-symbols-outlined text-[16px] {{ $reviewItem->rating >= $i ? '' : 'text-gray-300' }}"
                                          style="font-variation-settings: 'FILL' {{ $reviewItem->rating >= $i ? 1 : 0 }}, 'wght' 400, 'GRAD' 0, 'opsz' 24;">
                                        star
                                    </span>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <span class="text-xs text-gray-400">{{ $reviewItem->created_at->diffForHumans() }}</span>
                </div>
                <p class="text-gray-600 text-sm leading-relaxed">
                    {{ $reviewItem->review }}
                </p>
            </div>
        @empty
            <div class="text-center py-10 text-gray-400">
                <span class="material-symbols-outlined text-4xl mb-2 opacity-50">sentiment_neutral</span>
                <p>Belum ada ulasan. Jadilah yang pertama mereview!</p>
            </div>
        @endforelse
        
        <div class="mt-6">
            {{ $reviews->links() }}
        </div>
    </div>
</div>
