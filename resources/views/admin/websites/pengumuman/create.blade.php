@extends('layouts.admin')

@section('content')
    @php
        $user = auth()->user();
        $isSuperAdmin = $user && method_exists($user, 'hasRole') && $user->hasRole('Super Admin');
        $indexRoute = $isSuperAdmin ? 'admin.websites.pengumuman.index' : 'admin.panel.websites.pengumuman.index';
        $storeRoute = $isSuperAdmin ? 'admin.websites.pengumuman.store' : 'admin.panel.websites.pengumuman.store';
    @endphp

    {{-- Header with Back Button --}}
    <div class="mb-6">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route($indexRoute) }}"
                class="group flex items-center gap-2 px-4 py-2 rounded-xl bg-white border-2 border-[#F0F7F0] text-[#132A13] shadow-sm transition-all duration-300 hover:bg-[#F0F7F0] hover:border-[#132A13] hover:shadow-md active:scale-95 touch-manipulation">
                <svg class="w-5 h-5 transition-transform duration-300 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="font-medium">Kembali</span>
            </a>
        </div>
        <div>
            <h1
                class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2 bg-gradient-to-r from-[#132A13] via-[#2F4F2F] to-[#132A13] bg-clip-text text-transparent">
                Tambah Pengumuman Baharu
            </h1>
            <p class="text-sm sm:text-base text-gray-600">Isi maklumat pengumuman untuk ditambah ke dalam sistem</p>
        </div>
    </div>

    {{-- Form Panel --}}
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-[#F0F7F0] to-[#F0F7F0]/80 px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-bold text-[#132A13] flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z">
                    </path>
                </svg>
                Daftar Pengumuman
            </h2>
        </div>
        <div class="p-6 sm:p-8">
            <form action="{{ route($storeRoute) }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="pengumumanForm">
                @csrf
                @method('POST')

                <!-- Tajuk -->
                <div>
                    <label for="tajuk" class="block text-sm font-semibold text-gray-700 mb-2">
                        Tajuk Pengumuman <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="tajuk" id="tajuk" placeholder="Masukkan tajuk pengumuman"
                        class="w-full rounded-xl border-2 border-gray-200 px-4 py-3 bg-white text-gray-900 placeholder-gray-400 focus:border-[#132A13] focus:ring-2 focus:ring-[#132A13]/20 focus:outline-none transition-all"
                        required value="{{ old('tajuk') }}">
                    @error('tajuk')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kandungan -->
                <div>
                    <label for="kandungan" class="block text-sm font-semibold text-gray-700 mb-2">
                        Kandungan <span class="text-red-500">*</span>
                    </label>
                    <textarea name="kandungan" id="kandungan" rows="6" placeholder="Masukkan kandungan pengumuman"
                        class="w-full rounded-xl border-2 border-gray-200 px-4 py-3 bg-white text-gray-900 placeholder-gray-400 focus:border-[#132A13] focus:ring-2 focus:ring-[#132A13]/20 focus:outline-none transition-all resize-none"
                        required>{{ old('kandungan') }}</textarea>
                    @error('kandungan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tarikh Mula -->
                <div>
                    <label for="tarikh_mula" class="block text-sm font-semibold text-gray-700 mb-2">
                        Tarikh Mula <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tarikh_mula" id="tarikh_mula"
                        class="w-full rounded-xl border-2 border-gray-200 px-4 py-3 bg-white text-gray-900 focus:border-[#132A13] focus:ring-2 focus:ring-[#132A13]/20 focus:outline-none transition-all"
                        required value="{{ old('tarikh_mula') }}">
                    @error('tarikh_mula')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tarikh Akhir -->
                <div>
                    <label for="tarikh_akhir" class="block text-sm font-semibold text-gray-700 mb-2">
                        Tarikh Akhir <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tarikh_akhir" id="tarikh_akhir"
                        class="w-full rounded-xl border-2 border-gray-200 px-4 py-3 bg-white text-gray-900 focus:border-[#132A13] focus:ring-2 focus:ring-[#132A13]/20 focus:outline-none transition-all"
                        required value="{{ old('tarikh_akhir') }}">
                    @error('tarikh_akhir')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gambar -->
                <div>
                    <label for="gambar" class="block text-sm font-semibold text-gray-700 mb-2">
                        Gambar Pengumuman
                    </label>
                    <div class="relative">
                        <input type="file" name="gambar" id="gambar" accept="image/*"
                            class="w-full rounded-xl border-2 border-gray-200 px-4 py-3 bg-gray-50 text-gray-900 text-sm focus:border-[#132A13] focus:ring-2 focus:ring-[#132A13]/20 focus:outline-none transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#F0F7F0] file:text-[#132A13] hover:file:bg-[#132A13] hover:file:text-white cursor-pointer">
                    </div>
                    <p class="mt-2 text-xs text-gray-500">Format yang disokong: JPG, JPEG, PNG. Saiz maksimum: 2MB.</p>
                    @error('gambar')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Form Actions --}}
                <div class="flex flex-col sm:flex-row items-center justify-end gap-3 pt-4 border-t border-gray-200">
                    <a href="{{ route($indexRoute) }}"
                        class="w-full sm:w-auto px-6 py-3 rounded-xl border-2 border-gray-300 bg-white text-gray-700 font-semibold text-sm shadow-sm hover:bg-gray-50 hover:border-gray-400 transition-all duration-300 active:scale-95 touch-manipulation text-center">
                        Batal
                    </a>
                    <button type="submit"
                        class="group relative w-full sm:w-auto overflow-hidden rounded-xl bg-gradient-to-br from-[#132A13] to-[#2F4F2F] px-8 py-3 text-sm font-semibold text-white shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-[1.02] active:scale-95 transform touch-manipulation">
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-white/0 to-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                        <div class="relative flex items-center justify-center gap-2">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span>Simpan Pengumuman</span>
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berjaya!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#132A13',
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Ralat!',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#dc2626'
                });
            @endif

            // Prevent double submission
            preventDoubleSubmit('pengumumanForm', 'Menyimpan Pengumuman...');
        </script>
    @endpush
@endsection
