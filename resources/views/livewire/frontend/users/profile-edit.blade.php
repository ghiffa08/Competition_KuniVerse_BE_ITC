<div class="min-h-screen relative overflow-hidden font-sans text-gray-100 pb-20 bg-[#15171e]">
    {{-- BLOB BACKGROUND --}}
    <div class="fixed -top-32 -left-32 w-[500px] h-[500px] bg-[#C19D60] rounded-full blur-[150px] opacity-10 pointer-events-none z-0"></div>
    <div class="fixed top-1/4 -right-32 w-[400px] h-[400px] bg-blue-900 rounded-full blur-[150px] opacity-20 pointer-events-none z-0"></div>
    <div class="fixed -bottom-32 left-1/4 w-[400px] h-[400px] bg-purple-900 rounded-full blur-[150px] opacity-20 pointer-events-none z-0"></div>

    <div class="relative z-10 max-w-5xl mx-auto px-4 py-12 sm:px-6 lg:px-8">
        {{-- Messages --}}
        <div class="mb-8">
            @include('frontend.includes.messages')
        </div>

        <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 sm:p-10 shadow-2xl">
            {{-- Header --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10 border-b border-white/10 pb-6">
                <div>
                    <h3 class="text-3xl font-bold text-white font-serif mb-2">Edit Profile</h3>
                    <p class="text-gray-400">Perbarui informasi profil Anda yang ditampilkan secara publik.</p>
                </div>
                <a href="{{ route('frontend.users.profile') }}" wire:navigate class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-white/10 text-white font-semibold hover:bg-white/20 transition-all border border-white/10">
                    <span class="material-symbols-outlined text-lg mr-2">arrow_back</span>
                    Kembali ke Profile
                </a>
            </div>

            <form wire:submit="update" enctype="multipart/form-data">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    {{-- Left Column --}}
                    <div class="space-y-6">
                        {{-- First Name --}}
                        <div>
                            <label for="first_name" class="block text-sm font-bold text-gray-300 mb-2 uppercase tracking-wide">
                                Nama Depan <span class="text-[#C19D60]">*</span>
                            </label>
                            <input
                                type="text"
                                wire:model="first_name"
                                id="first_name"
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-hidden focus:border-[#C19D60] focus:ring-1 focus:ring-[#C19D60] transition-colors"
                                placeholder="Masukkan nama depan"
                            />
                            @error('first_name') <span class="text-red-400 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>

                        {{-- Last Name --}}
                        <div>
                            <label for="last_name" class="block text-sm font-bold text-gray-300 mb-2 uppercase tracking-wide">
                                Nama Belakang <span class="text-[#C19D60]">*</span>
                            </label>
                            <input
                                type="text"
                                wire:model="last_name"
                                id="last_name"
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-hidden focus:border-[#C19D60] focus:ring-1 focus:ring-[#C19D60] transition-colors"
                                placeholder="Masukkan nama belakang"
                            />
                            @error('last_name') <span class="text-red-400 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>

                        {{-- Mobile --}}
                        <div>
                            <label for="mobile" class="block text-sm font-bold text-gray-300 mb-2 uppercase tracking-wide">
                                No. Handphone
                            </label>
                            <input
                                type="text"
                                wire:model="mobile"
                                id="mobile"
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-hidden focus:border-[#C19D60] focus:ring-1 focus:ring-[#C19D60] transition-colors"
                                placeholder="Contoh: 081234567890"
                            />
                            @error('mobile') <span class="text-red-400 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>

                         {{-- Date of Birth --}}
                         <div>
                            <label for="date_of_birth" class="block text-sm font-bold text-gray-300 mb-2 uppercase tracking-wide">
                                Tanggal Lahir
                            </label>
                            <input
                                type="date"
                                wire:model="date_of_birth"
                                id="date_of_birth"
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-hidden focus:border-[#C19D60] focus:ring-1 focus:ring-[#C19D60] transition-colors [color-scheme:dark]"
                            />
                            @error('date_of_birth') <span class="text-red-400 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- Right Column --}}
                    <div class="space-y-6">
                        {{-- Address --}}
                        <div>
                             <label for="address" class="block text-sm font-bold text-gray-300 mb-2 uppercase tracking-wide">
                                Alamat
                            </label>
                            <input
                                type="text"
                                wire:model="address"
                                id="address"
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-hidden focus:border-[#C19D60] focus:ring-1 focus:ring-[#C19D60] transition-colors"
                                placeholder="Alamat lengkap"
                            />
                            @error('address') <span class="text-red-400 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                        
                        {{-- Gender --}}
                        <div>
                            <label for="gender" class="block text-sm font-bold text-gray-300 mb-2 uppercase tracking-wide">
                                Jenis Kelamin
                            </label>
                            <select
                                wire:model="gender"
                                id="gender"
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-hidden focus:border-[#C19D60] focus:ring-1 focus:ring-[#C19D60] transition-colors"
                            >
                                <option value="" class="bg-gray-800 text-gray-400">-- Pilih --</option>
                                <option value="Female" class="bg-gray-800">Perempuan</option>
                                <option value="Male" class="bg-gray-800">Laki-laki</option>
                                <option value="Other" class="bg-gray-800">Lainnya</option>
                            </select>
                            @error('gender') <span class="text-red-400 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>

                        {{-- Avatar --}}
                         <div>
                            <label for="avatar" class="block text-sm font-bold text-gray-300 mb-2 uppercase tracking-wide">
                                Avatar
                            </label>
                            <input
                                type="file"
                                wire:model="avatar"
                                id="avatar"
                                accept="image/*"
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#C19D60] file:text-white hover:file:bg-[#a6854e] transition-colors"
                            />
                            @error('avatar') <span class="text-red-400 text-sm mt-1">{{ $message }}</span> @enderror

                            @if($avatar)
                                <div class="mt-4">
                                    <p class="text-xs text-gray-400 mb-2">Preview:</p>
                                    <img src="{{ $avatar->temporaryUrl() }}" class="h-24 w-24 rounded-full object-cover border-2 border-[#C19D60]" alt="Preview" />
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    {{-- Bio (Full Width) --}}
                    <div class="md:col-span-2">
                        <label for="bio" class="block text-sm font-bold text-gray-300 mb-2 uppercase tracking-wide">
                           Bio / Deskripsi
                        </label>
                        <textarea
                            wire:model="bio"
                            id="bio"
                            rows="4"
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-hidden focus:border-[#C19D60] focus:ring-1 focus:ring-[#C19D60] transition-colors"
                            placeholder="Ceritakan sedikit tentang diri Anda..."
                        ></textarea>
                        @error('bio') <span class="text-red-400 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Website URL --}}
                    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                             <label for="url" class="block text-sm font-bold text-gray-300 mb-2 uppercase tracking-wide">
                                Website URL
                            </label>
                            <input
                                type="url"
                                wire:model="url"
                                id="url"
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-hidden focus:border-[#C19D60] focus:ring-1 focus:ring-[#C19D60] transition-colors"
                                placeholder="https://example.com"
                            />
                            @error('url') <span class="text-red-400 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                             <label for="url_text" class="block text-sm font-bold text-gray-300 mb-2 uppercase tracking-wide">
                                Link Text (Opsional)
                            </label>
                            <input
                                type="text"
                                wire:model="url_text"
                                id="url_text"
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-hidden focus:border-[#C19D60] focus:ring-1 focus:ring-[#C19D60] transition-colors"
                                placeholder="Kunjungi Website Saya"
                            />
                            @error('url_text') <span class="text-red-400 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="mt-10 flex justify-end">
                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        class="px-8 py-4 rounded-xl bg-[#C19D60] text-white font-bold shadow-lg shadow-[#C19D60]/20 hover:bg-[#a6854e] transition-all transform hover:-translate-y-1 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <span wire:loading.remove>Simpan Perubahan</span>
                        <span wire:loading>Menyimpan...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@push("after-scripts")
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
