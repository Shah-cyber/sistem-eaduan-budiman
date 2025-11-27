@extends('layouts.public')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#F0F7F0] via-white to-[#F0F7F0]">
    <div class="flex items-center justify-center min-h-screen px-4 py-6 sm:py-12">
        <div class="w-full max-w-4xl lg:max-w-6xl xl:max-w-7xl">
            {{-- Main Card --}}
            <div class="bg-white/90 backdrop-blur-sm p-6 sm:p-8 md:p-10 lg:p-12 rounded-2xl sm:rounded-3xl shadow-2xl border border-[#2F4F2F]/10">
                {{-- Header Section --}}
                <div class="text-center mb-6 sm:mb-8">
                    <div class="flex justify-center mb-4 sm:mb-6">
                        <div class="relative">
                            <div class="absolute inset-0 bg-[#132A13]/10 rounded-full blur-xl"></div>
                            <div class="relative w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-gradient-to-br from-[#132A13] to-[#2F4F2F] flex items-center justify-center shadow-lg">
                                <i class="fa fa-pencil-alt text-2xl sm:text-3xl text-white" aria-hidden="true"></i>
                            </div>
                        </div>
        </div>
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-2 sm:mb-3 tracking-tight bg-gradient-to-r from-[#132A13] via-[#2F4F2F] to-[#132A13] bg-clip-text text-transparent">
            Borang Tambah Aduan
        </h1>
                    <p class="text-[#2F4F2F]/70 text-sm sm:text-base font-medium">
                        Sila isi maklumat di bawah dengan lengkap dan betul
                    </p>
                </div>

                {{-- Form Section --}}
                <form action="{{ route('public.complaint.store') }}" method="POST" class="space-y-6" id="complaintForm" enctype="multipart/form-data">
                    @csrf

                    {{-- Form Fields Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                        {{-- Nama --}}
                        <div class="md:col-span-2 lg:col-span-3">
                            <label class="mb-2 block text-sm font-semibold text-[#132A13]">
                                Nama Penuh <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fa fa-user text-[#2F4F2F]/50" aria-hidden="true"></i>
                                </div>
                                <input type="text" 
                                       name="nama" 
                                       id="nama"
                                       maxlength="100"
                                       class="w-full pl-12 pr-4 py-3.5 rounded-xl border-2 border-gray-200 bg-white text-sm focus:ring-2 focus:ring-[#132A13] focus:border-[#132A13] transition-all"
                                       placeholder="Masukkan nama penuh anda"
                                       required>
                            </div>
                            <div class="flex items-center justify-between mt-1">
                                <p class="text-xs text-[#2F4F2F]/60">Hanya huruf dan ruang dibenarkan</p>
                                <span id="nama-count" class="text-xs text-[#2F4F2F]/60">0/100</span>
                            </div>
                            <div id="nama-error" class="mt-1 text-sm text-red-600 hidden"></div>
            </div>

                        {{-- Telefon --}}
            <div>
                            <label class="mb-2 block text-sm font-semibold text-[#132A13]">
                                Nombor Telefon <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fa fa-phone text-[#2F4F2F]/50" aria-hidden="true"></i>
                                </div>
                                <input type="tel" 
                                       name="telefon" 
                                       id="telefon"
                                       minlength="10"
                                       maxlength="12"
                                       class="w-full pl-12 pr-4 py-3.5 rounded-xl border-2 border-gray-200 bg-white text-sm focus:ring-2 focus:ring-[#132A13] focus:border-[#132A13] transition-all"
                                       placeholder="0123456789"
                                       required>
                            </div>
                            <div class="flex items-center justify-between mt-1">
                                <p class="text-xs text-[#2F4F2F]/60">10-12 digit (tanpa tanda sengkang)</p>
                                <span id="telefon-count" class="text-xs text-[#2F4F2F]/60">0/12</span>
                            </div>
                            <div id="telefon-error" class="mt-1 text-sm text-red-600 hidden"></div>
            </div>

                        {{-- Emel --}}
            <div>
                            <label class="mb-2 block text-sm font-semibold text-[#132A13]">
                                Emel <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fa fa-envelope text-[#2F4F2F]/50" aria-hidden="true"></i>
                                </div>
                                <input type="email" 
                                       name="email" 
                                       id="email"
                                       class="w-full pl-12 pr-4 py-3.5 rounded-xl border-2 border-gray-200 bg-white text-sm focus:ring-2 focus:ring-[#132A13] focus:border-[#132A13] transition-all"
                                       placeholder="nama@email.com"
                                       required>
                            </div>
            </div>

                        {{-- Jenis Aduan --}}
                        <div class="md:col-span-2 lg:col-span-1">
                            <label class="mb-2 block text-sm font-semibold text-[#132A13]">
                                Jenis Aduan <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fa fa-list text-[#2F4F2F]/50" aria-hidden="true"></i>
                                </div>
                                <select name="kategori" 
                                        id="kategori"
                                        class="w-full pl-12 pr-4 py-3.5 rounded-xl border-2 border-gray-200 bg-white text-sm focus:ring-2 focus:ring-[#132A13] focus:border-[#132A13] transition-all appearance-none cursor-pointer @error('kategori') border-red-300 @enderror"
                                        required>
                                    <option value="">-- Pilih Jenis Aduan --</option>
                                    @foreach($complaintTypes ?? [] as $type)
                                        <option value="{{ $type->id }}" {{ old('kategori') == $type->id ? 'selected' : '' }}>
                                            {{ $type->type_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i class="fa fa-chevron-down text-[#2F4F2F]/50" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div id="kategori-error" class="mt-1 text-sm text-red-600 hidden"></div>
            </div>

                        {{-- Alamat --}}
                        <div class="md:col-span-2 lg:col-span-3">
                            <label class="mb-2 block text-sm font-semibold text-[#132A13]">
                                Alamat <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute top-3 left-4 pointer-events-none">
                                    <i class="fa fa-map-marker-alt text-[#2F4F2F]/50" aria-hidden="true"></i>
                                </div>
                                <textarea name="alamat" 
                                          id="alamat"
                                          rows="2"
                                          maxlength="200"
                                          class="w-full pl-12 pr-4 py-3.5 rounded-xl border-2 border-gray-200 bg-white text-sm focus:ring-2 focus:ring-[#132A13] focus:border-[#132A13] transition-all resize-none"
                                          placeholder="Lokasi aduan (contoh: Jalan Kampung Budiman, Taman Desa)"
                                          required></textarea>
                            </div>
                            <div class="flex items-center justify-between mt-1">
                                <p class="text-xs text-[#2F4F2F]/60">Huruf, nombor, dan aksara khas (., -) dibenarkan</p>
                                <span id="alamat-count" class="text-xs text-[#2F4F2F]/60">0/200</span>
                            </div>
                            <div id="alamat-error" class="mt-1 text-sm text-red-600 hidden"></div>
            </div>

                        {{-- Huraian --}}
                        <div class="md:col-span-2 lg:col-span-3">
                            <label class="mb-2 block text-sm font-semibold text-[#132A13]">
                                Huraian Aduan <span class="text-red-500">*</span>
                            </label>
                            <textarea name="huraian" 
                                      id="huraian"
                                      rows="5"
                                      maxlength="1000"
                                      class="w-full px-4 py-3.5 rounded-xl border-2 border-gray-200 bg-white text-sm focus:ring-2 focus:ring-[#132A13] focus:border-[#132A13] transition-all resize-none"
                                      placeholder="Terangkan aduan anda dengan terperinci..."
                                      required></textarea>
                            <div class="flex items-center justify-between mt-1">
                                <p class="text-xs text-[#2F4F2F]/60">Sila berikan maklumat yang lengkap untuk memudahkan tindakan</p>
                                <span id="huraian-count" class="text-xs text-[#2F4F2F]/60">0/1000</span>
                            </div>
                            <div id="huraian-error" class="mt-1 text-sm text-red-600 hidden"></div>
            </div>

                        {{-- Gambar --}}
                        <div class="md:col-span-2 lg:col-span-3">
                            <label class="mb-2 block text-sm font-semibold text-[#132A13]">
                                Muat Naik Gambar <span class="text-gray-500 text-xs font-normal">(Pilihan)</span>
                            </label>
                            <div class="relative">
                                <input type="file" 
                                       name="gambar[]" 
                                       id="gambar"
                                       accept=".jpg,.jpeg,.png"
                                       multiple
                                       class="block w-full text-sm text-gray-700 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 focus:ring-2 focus:ring-[#132A13] focus:border-[#132A13] transition-all file:mr-4 file:py-3 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#132A13] file:text-white hover:file:bg-[#2F4F2F]">
                            </div>
                            <p class="text-xs text-[#2F4F2F]/60 mt-2 flex items-center gap-1">
                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                                Format: JPG, PNG sahaja. Maksimum: 10 gambar. Saiz setiap gambar: 2MB
                            </p>
                            <div id="gambar-error" class="mt-1 text-sm text-red-600 hidden"></div>
                            <div id="gambar-count" class="mt-1 text-xs text-[#2F4F2F]/60 hidden"></div>
                        </div>
            </div>

                    {{-- Action Buttons --}}
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 sm:pt-6 border-t border-[#2F4F2F]/10">
                        <a href="{{ route('public.home') }}" 
                           class="inline-flex items-center gap-2 text-sm text-[#2F4F2F]/70 hover:text-[#132A13] font-medium transition-colors">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>
                            Kembali ke Laman Utama
                        </a>
                        <button type="submit" 
                                class="w-full sm:w-auto group relative overflow-hidden rounded-2xl bg-gradient-to-br from-[#132A13] to-[#2F4F2F] px-8 py-3.5 text-white shadow-lg transition-all duration-300 hover:shadow-2xl hover:scale-[1.02] transform">
                            <div class="absolute inset-0 bg-gradient-to-br from-white/0 to-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <div class="relative flex items-center justify-center gap-2">
                                <i class="fa fa-paper-plane text-lg" aria-hidden="true"></i>
                                <span class="font-bold">Hantar Aduan</span>
                            </div>
                </button>
            </div>
        </form>
            </div>

            {{-- Help Section --}}
            <div class="mt-6 text-center">
                <p class="text-xs text-[#2F4F2F]/50">
                    <i class="fa fa-shield-alt mr-1" aria-hidden="true"></i>
                    Maklumat anda adalah selamat dan dirahsiakan
                </p>
            </div>
        </div>
    </div>
    </div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Name validation - letters and spaces only
    const namaInput = document.getElementById('nama');
    const namaCount = document.getElementById('nama-count');
    const namaError = document.getElementById('nama-error');
    
    namaInput.addEventListener('input', function(e) {
        let value = this.value;
        const originalLength = value.length;
        
        // Remove non-letter and non-space characters
        value = value.replace(/[^a-zA-Z\s]/g, '');
        
        if (value.length !== originalLength) {
            this.value = value;
        }
        
        // Update character count
        const currentLength = value.length;
        namaCount.textContent = `${currentLength}/100`;
        
        // Validate
        namaError.classList.add('hidden');
        namaError.textContent = '';
        this.classList.remove('border-red-500', 'ring-2', 'ring-red-200');
        this.classList.add('border-gray-200');
        
        if (value.length > 100) {
            this.value = value.substring(0, 100);
            namaCount.textContent = '100/100';
        }
        
        if (value && !/^[a-zA-Z\s]+$/.test(value)) {
            this.classList.add('border-red-500', 'ring-2', 'ring-red-200');
            this.classList.remove('border-gray-200');
            namaError.textContent = 'Nama hanya boleh mengandungi huruf dan ruang.';
            namaError.classList.remove('hidden');
        }
    });

    // Phone number validation - only numbers
    const telefonInput = document.getElementById('telefon');
    const telefonCount = document.getElementById('telefon-count');
    const telefonError = document.getElementById('telefon-error');
    
    telefonInput.addEventListener('input', function(e) {
        // Remove non-numeric characters
        this.value = this.value.replace(/[^0-9]/g, '');
        
        // Update character count
        const currentLength = this.value.length;
        telefonCount.textContent = `${currentLength}/12`;
        
        // Validate
        telefonError.classList.add('hidden');
        telefonError.textContent = '';
        this.classList.remove('border-red-500', 'ring-2', 'ring-red-200', 'border-green-500');
        this.classList.add('border-gray-200');
        
        if (this.value.length > 12) {
            this.value = this.value.substring(0, 12);
            telefonCount.textContent = '12/12';
        }
        
        if (this.value && !/^[0-9]+$/.test(this.value)) {
            this.classList.add('border-red-500', 'ring-2', 'ring-red-200');
            this.classList.remove('border-gray-200');
            telefonError.textContent = 'Nombor telefon hanya boleh mengandungi nombor.';
            telefonError.classList.remove('hidden');
        } else if (this.value.length > 0 && this.value.length < 10) {
            this.classList.add('border-red-500', 'ring-2', 'ring-red-200');
            this.classList.remove('border-gray-200');
            telefonError.textContent = 'Nombor telefon mestilah sekurang-kurangnya 10 digit.';
            telefonError.classList.remove('hidden');
        } else if (this.value.length >= 10 && this.value.length <= 12) {
            this.classList.add('border-green-500');
            this.classList.remove('border-gray-200');
        }
    });

    // Email validation
    const emailInput = document.getElementById('email');
    const emailError = document.createElement('div');
    emailError.id = 'email-error';
    emailError.className = 'mt-1 text-sm text-red-600 hidden';
    emailInput.parentElement.appendChild(emailError);
    
    emailInput.addEventListener('input', function(e) {
        const email = this.value;
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        emailError.classList.add('hidden');
        emailError.textContent = '';
        this.classList.remove('border-red-500', 'ring-2', 'ring-red-200');
        this.classList.add('border-gray-200');
        
        if (email && !emailPattern.test(email)) {
            this.classList.add('border-red-500', 'ring-2', 'ring-red-200');
            this.classList.remove('border-gray-200');
            emailError.textContent = 'Sila masukkan alamat emel yang sah (contoh: nama@email.com).';
            emailError.classList.remove('hidden');
        } else if (email && email.length > 255) {
            this.classList.add('border-red-500', 'ring-2', 'ring-red-200');
            this.classList.remove('border-gray-200');
            emailError.textContent = 'Emel tidak boleh melebihi 255 aksara.';
            emailError.classList.remove('hidden');
        }
    });

    // Address validation - letters, numbers, and special chars (., -)
    const alamatInput = document.getElementById('alamat');
    const alamatCount = document.getElementById('alamat-count');
    const alamatError = document.getElementById('alamat-error');
    
    alamatInput.addEventListener('input', function(e) {
        let value = this.value;
        const originalLength = value.length;
        
        // Remove characters that are not letters, numbers, spaces, or allowed special chars
        value = value.replace(/[^a-zA-Z0-9\s.,-]/g, '');
        
        if (value.length !== originalLength) {
            this.value = value;
        }
        
        // Update character count
        const currentLength = value.length;
        alamatCount.textContent = `${currentLength}/200`;
        
        // Validate
        alamatError.classList.add('hidden');
        alamatError.textContent = '';
        this.classList.remove('border-red-500', 'ring-2', 'ring-red-200');
        this.classList.add('border-gray-200');
        
        if (value.length > 200) {
            this.value = value.substring(0, 200);
            alamatCount.textContent = '200/200';
        }
        
        if (value && !/^[a-zA-Z0-9\s.,-]+$/.test(value)) {
            this.classList.add('border-red-500', 'ring-2', 'ring-red-200');
            this.classList.remove('border-gray-200');
            alamatError.textContent = 'Alamat hanya boleh mengandungi huruf, nombor, dan aksara khas (., -).';
            alamatError.classList.remove('hidden');
        }
    });

    // Description validation - all characters, max 1000
    const huraianInput = document.getElementById('huraian');
    const huraianCount = document.getElementById('huraian-count');
    const huraianError = document.getElementById('huraian-error');
    
    huraianInput.addEventListener('input', function(e) {
        const value = this.value;
        
        // Update character count
        const currentLength = value.length;
        huraianCount.textContent = `${currentLength}/1000`;
        
        // Validate
        huraianError.classList.add('hidden');
        huraianError.textContent = '';
        this.classList.remove('border-red-500', 'ring-2', 'ring-red-200');
        this.classList.add('border-gray-200');
        
        if (value.length > 1000) {
            this.value = value.substring(0, 1000);
            huraianCount.textContent = '1000/1000';
        }
    });

    // Category validation
    const kategoriInput = document.getElementById('kategori');
    const kategoriError = document.getElementById('kategori-error');
    
    kategoriInput.addEventListener('change', function(e) {
        kategoriError.classList.add('hidden');
        kategoriError.textContent = '';
        this.classList.remove('border-red-500', 'ring-2', 'ring-red-200');
        this.classList.add('border-gray-200');
        
        if (!this.value) {
            this.classList.add('border-red-500', 'ring-2', 'ring-red-200');
            this.classList.remove('border-gray-200');
            kategoriError.textContent = 'Sila pilih jenis aduan.';
            kategoriError.classList.remove('hidden');
        }
    });

    // Image upload validation
    document.getElementById('gambar').addEventListener('change', function(e) {
        const files = this.files;
        const errorDiv = document.getElementById('gambar-error');
        const countDiv = document.getElementById('gambar-count');
        const maxFiles = 10;
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        const maxSize = 2 * 1024 * 1024; // 2MB in bytes
        
        // Clear previous errors
        errorDiv.classList.add('hidden');
        errorDiv.textContent = '';
        countDiv.classList.add('hidden');
        this.classList.remove('border-red-500', 'ring-2', 'ring-red-200');
        this.classList.add('border-gray-300');
        
        if (files.length === 0) {
            countDiv.classList.add('hidden');
            return;
        }
        
        // Check file count
        if (files.length > maxFiles) {
            this.classList.add('border-red-500', 'ring-2', 'ring-red-200');
            this.classList.remove('border-gray-300');
            errorDiv.textContent = `Maksimum ${maxFiles} gambar dibenarkan. Anda telah memilih ${files.length} gambar.`;
            errorDiv.classList.remove('hidden');
            this.value = ''; // Clear selection
            return;
        }
        
        // Check each file
        let hasError = false;
        let errorMessages = [];
        
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            
            // Check file type
            if (!allowedTypes.includes(file.type)) {
                hasError = true;
                errorMessages.push(`Gambar ${i + 1}: Format tidak dibenarkan. Hanya JPG dan PNG dibenarkan.`);
            }
            
            // Check file size
            if (file.size > maxSize) {
                hasError = true;
                errorMessages.push(`Gambar ${i + 1}: Saiz melebihi 2MB (${(file.size / 1024 / 1024).toFixed(2)}MB).`);
            }
        }
        
        if (hasError) {
            this.classList.add('border-red-500', 'ring-2', 'ring-red-200');
            this.classList.remove('border-gray-300');
            errorDiv.innerHTML = '<ul class="list-disc list-inside">' + 
                errorMessages.map(msg => '<li>' + msg + '</li>').join('') + 
                '</ul>';
            errorDiv.classList.remove('hidden');
            this.value = ''; // Clear selection
        } else {
            // Show file count
            countDiv.textContent = `${files.length} gambar dipilih (Maksimum: ${maxFiles})`;
            countDiv.classList.remove('hidden');
        }
    });

    // Form submission validation
    document.getElementById('complaintForm').addEventListener('submit', function(e) {
        const nama = document.getElementById('nama');
        const telefon = document.getElementById('telefon');
        const email = document.getElementById('email');
        const alamat = document.getElementById('alamat');
        const kategori = document.getElementById('kategori');
        const huraian = document.getElementById('huraian');
        const gambarInput = document.getElementById('gambar');
        const files = gambarInput.files;
        
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const maxFiles = 10;
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        const maxSize = 2 * 1024 * 1024; // 2MB
        
        let isValid = true;
        let errorMessages = [];
        let firstErrorField = null;
        
        // Validate name
        if (!nama.value.trim()) {
            isValid = false;
            nama.classList.add('border-red-500', 'ring-2', 'ring-red-200');
            namaError.textContent = 'Nama diperlukan.';
            namaError.classList.remove('hidden');
            if (!firstErrorField) firstErrorField = nama;
            errorMessages.push('Nama diperlukan.');
        } else if (!/^[a-zA-Z\s]+$/.test(nama.value)) {
            isValid = false;
            nama.classList.add('border-red-500', 'ring-2', 'ring-red-200');
            namaError.textContent = 'Nama hanya boleh mengandungi huruf dan ruang.';
            namaError.classList.remove('hidden');
            if (!firstErrorField) firstErrorField = nama;
            errorMessages.push('Nama hanya boleh mengandungi huruf dan ruang.');
        } else if (nama.value.length > 100) {
            isValid = false;
            nama.classList.add('border-red-500', 'ring-2', 'ring-red-200');
            namaError.textContent = 'Nama tidak boleh melebihi 100 aksara.';
            namaError.classList.remove('hidden');
            if (!firstErrorField) firstErrorField = nama;
            errorMessages.push('Nama tidak boleh melebihi 100 aksara.');
        }
        
        // Validate phone
        if (!telefon.value.trim()) {
            isValid = false;
            telefon.classList.add('border-red-500', 'ring-2', 'ring-red-200');
            telefonError.textContent = 'Nombor telefon diperlukan.';
            telefonError.classList.remove('hidden');
            if (!firstErrorField) firstErrorField = telefon;
            errorMessages.push('Nombor telefon diperlukan.');
        } else if (!/^[0-9]+$/.test(telefon.value)) {
            isValid = false;
            telefon.classList.add('border-red-500', 'ring-2', 'ring-red-200');
            telefonError.textContent = 'Nombor telefon hanya boleh mengandungi nombor.';
            telefonError.classList.remove('hidden');
            if (!firstErrorField) firstErrorField = telefon;
            errorMessages.push('Nombor telefon hanya boleh mengandungi nombor.');
        } else if (telefon.value.length < 10) {
            isValid = false;
            telefon.classList.add('border-red-500', 'ring-2', 'ring-red-200');
            telefonError.textContent = 'Nombor telefon mestilah sekurang-kurangnya 10 digit.';
            telefonError.classList.remove('hidden');
            if (!firstErrorField) firstErrorField = telefon;
            errorMessages.push('Nombor telefon mestilah sekurang-kurangnya 10 digit.');
        } else if (telefon.value.length > 12) {
            isValid = false;
            telefon.classList.add('border-red-500', 'ring-2', 'ring-red-200');
            telefonError.textContent = 'Nombor telefon tidak boleh melebihi 12 digit.';
            telefonError.classList.remove('hidden');
            if (!firstErrorField) firstErrorField = telefon;
            errorMessages.push('Nombor telefon tidak boleh melebihi 12 digit.');
        }
        
        // Validate email
        if (!email.value.trim()) {
            isValid = false;
            email.classList.add('border-red-500', 'ring-2', 'ring-red-200');
            emailError.textContent = 'Emel diperlukan.';
            emailError.classList.remove('hidden');
            if (!firstErrorField) firstErrorField = email;
            errorMessages.push('Emel diperlukan.');
        } else if (!emailPattern.test(email.value)) {
            isValid = false;
            email.classList.add('border-red-500', 'ring-2', 'ring-red-200');
            emailError.textContent = 'Sila masukkan alamat emel yang sah.';
            emailError.classList.remove('hidden');
            if (!firstErrorField) firstErrorField = email;
            errorMessages.push('Sila masukkan alamat emel yang sah.');
        } else if (email.value.length > 255) {
            isValid = false;
            email.classList.add('border-red-500', 'ring-2', 'ring-red-200');
            emailError.textContent = 'Emel tidak boleh melebihi 255 aksara.';
            emailError.classList.remove('hidden');
            if (!firstErrorField) firstErrorField = email;
            errorMessages.push('Emel tidak boleh melebihi 255 aksara.');
        }
        
        // Validate address
        if (!alamat.value.trim()) {
            isValid = false;
            alamat.classList.add('border-red-500', 'ring-2', 'ring-red-200');
            alamatError.textContent = 'Alamat diperlukan.';
            alamatError.classList.remove('hidden');
            if (!firstErrorField) firstErrorField = alamat;
            errorMessages.push('Alamat diperlukan.');
        } else if (!/^[a-zA-Z0-9\s.,-]+$/.test(alamat.value)) {
            isValid = false;
            alamat.classList.add('border-red-500', 'ring-2', 'ring-red-200');
            alamatError.textContent = 'Alamat hanya boleh mengandungi huruf, nombor, dan aksara khas (., -).';
            alamatError.classList.remove('hidden');
            if (!firstErrorField) firstErrorField = alamat;
            errorMessages.push('Alamat hanya boleh mengandungi huruf, nombor, dan aksara khas (., -).');
        } else if (alamat.value.length > 200) {
            isValid = false;
            alamat.classList.add('border-red-500', 'ring-2', 'ring-red-200');
            alamatError.textContent = 'Alamat tidak boleh melebihi 200 aksara.';
            alamatError.classList.remove('hidden');
            if (!firstErrorField) firstErrorField = alamat;
            errorMessages.push('Alamat tidak boleh melebihi 200 aksara.');
        }
        
        // Validate category
        if (!kategori.value) {
            isValid = false;
            kategori.classList.add('border-red-500', 'ring-2', 'ring-red-200');
            kategoriError.textContent = 'Sila pilih jenis aduan.';
            kategoriError.classList.remove('hidden');
            if (!firstErrorField) firstErrorField = kategori;
            errorMessages.push('Sila pilih jenis aduan.');
        }
        
        // Validate description
        if (!huraian.value.trim()) {
            isValid = false;
            huraian.classList.add('border-red-500', 'ring-2', 'ring-red-200');
            huraianError.textContent = 'Huraian aduan diperlukan.';
            huraianError.classList.remove('hidden');
            if (!firstErrorField) firstErrorField = huraian;
            errorMessages.push('Huraian aduan diperlukan.');
        } else if (huraian.value.length > 1000) {
            isValid = false;
            huraian.classList.add('border-red-500', 'ring-2', 'ring-red-200');
            huraianError.textContent = 'Huraian tidak boleh melebihi 1000 aksara.';
            huraianError.classList.remove('hidden');
            if (!firstErrorField) firstErrorField = huraian;
            errorMessages.push('Huraian tidak boleh melebihi 1000 aksara.');
        }
        
        // Validate images
        if (files.length > 0) {
            // Check file count
            if (files.length > maxFiles) {
                isValid = false;
                gambarInput.classList.add('border-red-500', 'ring-2', 'ring-red-200');
                errorMessages.push(`Maksimum ${maxFiles} gambar dibenarkan. Anda telah memilih ${files.length} gambar.`);
            }
            
            // Check each file
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                
                // Check file type
                if (!allowedTypes.includes(file.type)) {
                    isValid = false;
                    gambarInput.classList.add('border-red-500', 'ring-2', 'ring-red-200');
                    errorMessages.push(`Gambar ${i + 1}: Format tidak dibenarkan. Hanya JPG dan PNG dibenarkan.`);
                }
                
                // Check file size
                if (file.size > maxSize) {
                    isValid = false;
                    gambarInput.classList.add('border-red-500', 'ring-2', 'ring-red-200');
                    errorMessages.push(`Gambar ${i + 1}: Saiz melebihi 2MB (${(file.size / 1024 / 1024).toFixed(2)}MB).`);
                }
            }
        }
        
        if (!isValid) {
            e.preventDefault();
            
            // Scroll to first error field
            if (firstErrorField) {
                firstErrorField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                setTimeout(() => firstErrorField.focus(), 300);
            }
            
            Swal.fire({
                icon: 'error',
                title: 'Ralat Validasi!',
                html: '<ul class="text-left list-disc list-inside">' + 
                    errorMessages.map(msg => '<li>' + msg + '</li>').join('') + 
                    '</ul>',
                confirmButtonColor: '#132A13'
            });
            return false;
        }
    });

    // Show success/error messages from server
    @if(session('success'))
        @php
            $emailSent = session('email_sent', false);
            $redirectTo = session('redirect_to', 'semakstatus');
        @endphp
        Swal.fire({
            icon: '{{ $emailSent ? 'success' : 'warning' }}',
            title: '{{ $emailSent ? 'Berjaya!' : 'Berjaya (Dengan Nota)' }}',
            text: '{{ session('success') }}',
            confirmButtonColor: '#132A13',
            timer: {{ $emailSent ? 3000 : 5000 }},
            timerProgressBar: true,
            showConfirmButton: true,
            confirmButtonText: 'OK'
        }).then((result) => {
            @if($redirectTo === 'semakstatus')
                window.location.href = '{{ route('public.status.check') }}';
            @else
                // Stay on current page if no redirect specified
            @endif
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Ralat!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#132A13',
            confirmButtonText: 'OK'
        });
    @endif

    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Ralat Validasi!',
            html: '<ul class="text-left list-disc list-inside">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
            confirmButtonColor: '#132A13',
            confirmButtonText: 'OK'
        });
    @endif

    // Prevent double submission
    preventDoubleSubmit('complaintForm', 'Menghantar Aduan...');
</script>
@endpush
@endsection
