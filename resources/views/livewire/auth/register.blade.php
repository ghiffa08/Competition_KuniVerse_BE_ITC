<div class="min-h-screen flex items-center justify-center bg-[#F8F9FA] relative overflow-hidden px-4 font-sans text-gray-800">
    {{-- BACKGROUND BLOBS --}}
    <div class="absolute -top-[15%] -left-[10%] w-[420px] h-[420px] bg-[#C19D60] rounded-full blur-[120px] opacity-30"></div>
    <div class="absolute -bottom-[15%] -right-[10%] w-[420px] h-[420px] bg-yellow-200 rounded-full blur-[120px] opacity-40"></div>

    {{-- CARD CONTAINER --}}
    <div class="relative w-full max-w-md">
        <div class="absolute -inset-1 bg-gradient-to-r from-[#C19D60] to-yellow-200 rounded-3xl blur opacity-20"></div>

        <div class="relative bg-white/60 backdrop-blur-xl border border-white/50 rounded-3xl p-8 shadow-lg">
            {{-- HEADER --}}
            <div class="text-center mb-6">
                <h2 class="text-4xl font-bold text-gray-900 font-serif">Daftar Akun</h2>
                <p class="text-gray-600 mt-1 text-sm">
                    Buat akun untuk mulai menjelajah Kuniverse
                </p>
            </div>

            {{-- Role Toggle --}}
            <div class="bg-[#F0F2F5] p-1 rounded-xl flex mb-6 relative">
                <div class="absolute inset-y-1 bg-white rounded-lg shadow-sm w-[48%] transition-all duration-300 ease-[cubic-bezier(0.4,0,0.2,1)]"
                     style="left: {{ $role === 'user' ? '2%' : '50%' }}"></div>
                 
                 <label class="flex-1 relative z-10 cursor-pointer">
                    <input type="radio" wire:model.live="role" value="user" class="hidden">
                    <div class="py-2 text-sm font-bold text-center transition-colors duration-300 {{ $role === 'user' ? 'text-[#C19D60]' : 'text-gray-500 hover:text-gray-700' }}">
                        Wisatawan
                    </div>
                 </label>

                 <label class="flex-1 relative z-10 cursor-pointer">
                    <input type="radio" wire:model.live="role" value="merchant" class="hidden">
                    <div class="py-2 text-sm font-bold text-center transition-colors duration-300 {{ $role === 'merchant' ? 'text-[#C19D60]' : 'text-gray-500 hover:text-gray-700' }}">
                        Merchant
                    </div>
                 </label>
            </div>

            <div class="text-center mb-6 text-sm text-gray-500 px-2 min-h-[40px] flex items-center justify-center transition-all duration-300">
                <span x-show="$wire.role === 'merchant'" x-transition.opacity.duration.300ms>
                    Daftar sebagai Merchant untuk mempromosikan Wisata, UMKM, dan Kuliner.
                </span>
                <span x-show="$wire.role === 'user'" x-transition.opacity.duration.300ms>
                    Daftar sebagai Wisatawan untuk akses tiket mudah dan promo menarik.
                </span>
            </div>

            {{-- FORM --}}
            <form wire:submit="register" class="space-y-4">
                {{-- Name --}}
                <div x-data>
                    <label for="name" class="text-sm font-semibold text-gray-700 block mb-1" x-text="$wire.role === 'merchant' ? 'Nama Bisnis / Usaha' : 'Nama Lengkap'">Nama Lengkap</label>
                    <input 
                        wire:model="name"
                        id="name"
                        type="text" 
                        required 
                        :placeholder="$wire.role === 'merchant' ? 'Contoh: Kopi Janji Jiwa' : 'Kuniverse'"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white/60 focus:outline-none focus:ring-2 focus:ring-[#C19D60]/40 focus:border-[#C19D60] transition-all placeholder:text-gray-400"
                    >
                    @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="text-sm font-semibold text-gray-700 block mb-1">Email</label>
                    <input 
                        wire:model="email"
                        id="email"
                        type="email" 
                        required 
                        placeholder="email@example.com"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white/60 focus:outline-none focus:ring-2 focus:ring-[#C19D60]/40 focus:border-[#C19D60] transition-all placeholder:text-gray-400"
                    >
                    @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="text-sm font-semibold text-gray-700 block mb-1">Password</label>
                    <input 
                        wire:model="password"
                        id="password"
                        type="password" 
                        required 
                        placeholder="••••••••"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white/60 focus:outline-none focus:ring-2 focus:ring-[#C19D60]/40 focus:border-[#C19D60] transition-all placeholder:text-gray-400"
                    >
                    @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label for="password_confirmation" class="text-sm font-semibold text-gray-700 block mb-1">Konfirmasi Password</label>
                    <input 
                        wire:model="password_confirmation"
                        id="password_confirmation"
                        type="password" 
                        required 
                        placeholder="••••••••"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white/60 focus:outline-none focus:ring-2 focus:ring-[#C19D60]/40 focus:border-[#C19D60] transition-all placeholder:text-gray-400"
                    >
                </div>

                {{-- Register Mitra Link (Placeholder) --}}
                <p class="text-sm text-center text-gray-600 pt-2">
                    Mau register sebagai mitra? 
                    <a href="#" class="font-bold text-[#C19D60] hover:underline cursor-not-allowed opacity-70" title="Coming Soon">
                        Daftar di sini
                    </a>
                </p>

                {{-- Submit Button --}}
                <button 
                    type="submit" 
                    class="w-full mt-3 py-3 rounded-xl bg-[#C19D60] text-white font-bold shadow-lg shadow-[#C19D60]/30 hover:bg-[#a6854e] transition-all transform active:scale-[0.98]"
                >
                    DAFTAR SEKARANG
                </button>
            </form>

            {{-- Divider --}}
            <div class="my-6 text-center text-xs text-gray-500 relative">
                <span class="bg-transparent px-2 relative z-10">atau daftar dengan</span>
            </div>

            {{-- Google Signup --}}
            @if (env('GOOGLE_CLIENT_ID'))
                <a :href="'{{ route('social.login', 'google') }}?role=' + $wire.role" class="w-full flex justify-center items-center py-3 rounded-xl bg-white border border-gray-200 hover:bg-gray-50 hover:shadow transition font-semibold text-gray-700">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5 mr-2" alt="Google logo">
                    Sign up with Google
                </a>
            @endif

            {{-- Footer --}}
            <p class="text-center text-sm text-gray-600 mt-6">
                Sudah punya akun? 
                <a href="{{ route('login') }}" wire:navigate class="font-bold text-[#C19D60] hover:underline">
                    Login
                </a>
            </p>
        </div>
    </div>
</div>
