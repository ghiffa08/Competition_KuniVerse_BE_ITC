<div class="min-h-screen relative overflow-hidden font-sans text-gray-100 pb-20 bg-[#15171e]">
    {{-- BLOB BACKGROUND --}}
    <div class="fixed -top-32 -left-32 w-[500px] h-[500px] bg-[#C19D60] rounded-full blur-[150px] opacity-10 pointer-events-none z-0"></div>
    <div class="fixed top-1/4 -right-32 w-[400px] h-[400px] bg-blue-900 rounded-full blur-[150px] opacity-20 pointer-events-none z-0"></div>
    <div class="fixed -bottom-32 left-1/4 w-[400px] h-[400px] bg-purple-900 rounded-full blur-[150px] opacity-20 pointer-events-none z-0"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="text-center mb-10" data-aos="fade-down">
            <!-- Hidden header text as requested to clean up, or keep consistent? The screenshot shows "Kuniverse" header but not page title. I will keep page title but make it white. -->
            {{-- Note: User didn't ask to remove header, just "rapihkan". I will keep it clean. --}}
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Left Column: Avatar & Actions --}}
            <div class="lg:col-span-1" data-aos="fade-up" data-aos-delay="100">
                <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 shadow-2xl text-center relative overflow-hidden h-full">
                    
                    <div class="relative z-10">
                        <div class="relative w-40 h-40 mx-auto mb-6">
                            <img
                                class="w-full h-full rounded-full object-cover border-4 border-[#C19D60] shadow-lg"
                                src="{{ asset($$module_name_singular->avatar) }}"
                                alt="{{ $$module_name_singular->name }}"
                            />
                            @auth
                                @if (auth()->user()->id == $$module_name_singular->id)
                                    <a href="{{ route('frontend.users.profileEdit') }}" class="absolute bottom-2 right-2 bg-[#C19D60] text-white p-2 rounded-full shadow-lg hover:bg-[#a6854e] transition-colors cursor-pointer">
                                        <span class="material-symbols-outlined text-sm">edit</span>
                                    </a>
                                @endif
                            @endauth
                        </div>

                        <h3 class="text-3xl font-bold text-white font-serif mb-1 tracking-wide">
                            {{ $$module_name_singular->name }}
                        </h3>
                        <p class="text-sm text-[#C19D60] font-bold uppercase tracking-wider mb-6">
                            {{ $$module_name_singular->getRoleNames()->first() ?? 'Wisatawan' }}
                        </p>
                        
                        <div class="flex items-center justify-center gap-2 text-gray-400 mb-8">
                            <span class="material-symbols-outlined text-lg">location_on</span>
                            <span>{{ $$module_name_singular->address ?? 'Belum ada alamat' }}</span>
                        </div>

                        @auth
                            <div class="space-y-4">
                                @if (auth()->user()->id == $$module_name_singular->id)
                                    <a href="{{ route('frontend.users.profileEdit') }}" wire:navigate class="block w-full py-3.5 rounded-xl bg-[#C19D60] text-white font-bold shadow-lg shadow-[#C19D60]/20 hover:bg-[#a6854e] transition-all transform hover:-translate-y-1">
                                        Edit Profile
                                    </a>
                                @endif

                                @if (auth()->user()->username == $$module_name_singular->username)
                                    <a href="{{ route('frontend.users.changePassword') }}" wire:navigate class="block w-full py-3.5 rounded-xl bg-white text-gray-900 font-bold hover:bg-gray-100 shadow-md transition-all">
                                        Ubah Password
                                    </a>
                                @endif
                            </div>
                        @endauth
                        
                        {{-- Social Links --}}
                        <div class="absolute bottom-8 left-0 right-0 flex justify-center gap-5 opacity-70">
                             @if ($$module_name_singular->url_website)
                                <a href="{{ $$module_name_singular->url_website }}" target="_blank" class="text-gray-400 hover:text-[#C19D60] transition-colors"><span class="material-symbols-outlined text-xl">language</span></a>
                            @endif
                            {{-- Add other social links if needed --}}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Details --}}
            <div class="lg:col-span-2" data-aos="fade-up" data-aos-delay="200">
                <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 shadow-2xl h-full">
                    <h3 class="text-2xl font-bold text-gray-200 border-b border-white/10 pb-4 mb-8 font-serif">
                        Informasi Detail
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Field Component --}}
                        <div class="bg-white rounded-xl p-4 shadow-sm">
                            <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mb-1">Nama Depan</p>
                            <p class="text-gray-900 font-bold text-lg">{{ $$module_name_singular->first_name ?? '-' }}</p>
                        </div>

                        <div class="bg-white rounded-xl p-4 shadow-sm">
                            <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mb-1">Nama Belakang</p>
                            <p class="text-gray-900 font-bold text-lg">{{ $$module_name_singular->last_name ?? '-' }}</p>
                        </div>
                        
                         @auth
                            @if (auth()->user()->id == $$module_name_singular->id)
                                <div class="bg-white rounded-xl p-4 shadow-sm">
                                    <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mb-1">Email</p>
                                    <p class="text-gray-900 font-bold text-lg truncate">{{ $$module_name_singular->email }}</p>
                                </div>
                                
                                <div class="bg-white rounded-xl p-4 shadow-sm">
                                    <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mb-1">No. Handphone</p>
                                    <p class="text-gray-900 font-bold text-lg">{{ $$module_name_singular->mobile ?? '-' }}</p>
                                </div>
                                
                                <div class="bg-white rounded-xl p-4 shadow-sm">
                                    <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mb-1">Tanggal Lahir</p>
                                    <p class="text-gray-900 font-bold text-lg">{{ optional($$module_name_singular->date_of_birth)->translatedFormat('d F Y') ?? '-' }}</p>
                                </div>
                                
                                <div class="bg-white rounded-xl p-4 shadow-sm">
                                    <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mb-1">Jenis Kelamin</p>
                                    <p class="text-gray-900 font-bold text-lg">{{ $$module_name_singular->gender ?? '-' }}</p>
                                </div>
                            @endif
                        @endauth
                    </div>

                    <div class="mt-6 bg-white rounded-xl p-6 shadow-sm">
                        <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mb-2">Bio / Deskripsi</p>
                        <p class="text-gray-800 leading-relaxed text-base">
                            {{ $$module_name_singular->bio ?? 'Belum ada deskripsi profil.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push("after-scripts")
    <script type="module" src="https://cdn.jsdelivr.net/npm/sharer.js@latest/sharer.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
