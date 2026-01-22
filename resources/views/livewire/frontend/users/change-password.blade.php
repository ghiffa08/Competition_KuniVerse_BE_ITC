<div class="min-h-screen relative overflow-hidden font-sans text-gray-100 pb-20 bg-[#15171e]">
    {{-- BLOB BACKGROUND --}}
    <div class="fixed -top-32 -left-32 w-[500px] h-[500px] bg-[#C19D60] rounded-full blur-[150px] opacity-10 pointer-events-none z-0"></div>
    <div class="fixed top-1/4 -right-32 w-[400px] h-[400px] bg-blue-900 rounded-full blur-[150px] opacity-20 pointer-events-none z-0"></div>
    <div class="fixed -bottom-32 left-1/4 w-[400px] h-[400px] bg-purple-900 rounded-full blur-[150px] opacity-20 pointer-events-none z-0"></div>

    <div class="container mx-auto flex justify-center z-50 relative">
        @include('frontend.includes.messages')
    </div>

    <div class="relative z-10 max-w-4xl mx-auto px-4 py-12 sm:px-6 lg:px-8">
        <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 sm:p-10 shadow-2xl">
            {{-- Header --}}
             <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10 border-b border-white/10 pb-6">
                <div>
                    <h3 class="text-3xl font-bold text-white font-serif mb-2">Ubah Password</h3>
                    <p class="text-gray-400">Amankan akun Anda dengan memperbarui password secara berkala.</p>
                </div>
                <a href="{{ route('frontend.users.profile') }}" wire:navigate class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-white/10 text-white font-semibold hover:bg-white/20 transition-all border border-white/10">
                    <span class="material-symbols-outlined text-lg mr-2">arrow_back</span>
                    Kembali ke Profile
                </a>
            </div>

            <form wire:submit="updatePassword">
                <div class="max-w-xl mx-auto space-y-8">
                    
                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-300 mb-2 uppercase tracking-wide">
                            Password Baru <span class="text-[#C19D60]">*</span>
                        </label>
                        <div class="relative">
                            <input
                                wire:model="password"
                                type="password"
                                id="password"
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-hidden focus:border-[#C19D60] focus:ring-1 focus:ring-[#C19D60] transition-colors"
                                placeholder="Masukkan password baru"
                                required
                            />
                            <span class="material-symbols-outlined absolute right-4 top-3.5 text-gray-500">lock</span>
                        </div>
                        @error('password') <span class="text-red-400 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-gray-300 mb-2 uppercase tracking-wide">
                            Konfirmasi Password <span class="text-[#C19D60]">*</span>
                        </label>
                         <div class="relative">
                            <input
                                wire:model="password_confirmation"
                                type="password"
                                id="password_confirmation"
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-hidden focus:border-[#C19D60] focus:ring-1 focus:ring-[#C19D60] transition-colors"
                                placeholder="Ulangi password baru"
                                required
                            />
                             <span class="material-symbols-outlined absolute right-4 top-3.5 text-gray-500">lock_reset</span>
                        </div>
                        @error('password_confirmation') <span class="text-red-400 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Submit Button --}}
                    <div class="pt-4">
                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            class="w-full py-4 rounded-xl bg-[#C19D60] text-white font-bold shadow-lg shadow-[#C19D60]/20 hover:bg-[#a6854e] transition-all transform hover:-translate-y-1 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                        >
                            <span wire:loading.remove>Update Password</span>
                            <span wire:loading class="flex items-center gap-2">
                                <i class="fas fa-spinner fa-spin"></i> Updating...
                            </span>
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
@push("after-scripts")
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
