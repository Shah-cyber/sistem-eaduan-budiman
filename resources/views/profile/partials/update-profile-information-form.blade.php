<section>
    <div class="bg-gradient-to-r from-[#F0F7F0] to-[#F0F7F0]/80 border-b border-gray-200 px-6 py-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-[#132A13] flex items-center justify-center">
                <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-900">
                    {{ __('Maklumat Profil') }}
                </h2>
                <p class="text-xs text-gray-600">
                    {{ __('Kemaskini maklumat profil dan alamat emel anda.') }}
                </p>
            </div>
        </div>
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="p-6 space-y-6" enctype="multipart/form-data" id="profileForm">
        @csrf
        @method('patch')

        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                    <div class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-[#132A13]" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                        {{ __('Nama') }} <span class="text-red-500">*</span>
                    </div>
                </label>
                <input id="name" name="name" type="text" class="mt-1 block w-full rounded-xl border-2 border-gray-200 px-4 py-3 shadow-sm focus:border-[#132A13] focus:ring-2 focus:ring-[#132A13]/20 sm:text-sm transition-all @error('name') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                    <div class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-[#132A13]" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path></svg>
                        {{ __('Emel') }} <span class="text-red-500">*</span>
                    </div>
                </label>
                <input id="email" name="email" type="email" class="mt-1 block w-full rounded-xl border-2 border-gray-200 px-4 py-3 shadow-sm focus:border-[#132A13] focus:ring-2 focus:ring-[#132A13]/20 sm:text-sm transition-all @error('email') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-3 p-3 rounded-xl bg-yellow-50 border border-yellow-200">
                        <p class="text-sm text-yellow-800 flex items-center gap-2">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                            {{ __('Alamat emel anda belum disahkan.') }}
                        </p>
                        <button form="send-verification" class="mt-2 text-sm font-semibold text-[#132A13] hover:text-[#2F4F2F] transition-colors">
                            {{ __('Klik di sini untuk menghantar semula emel pengesahan.') }}
                        </button>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-green-600 flex items-center gap-1">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                {{ __('Pautan pengesahan baharu telah dihantar ke alamat emel anda.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <div>
                <label for="phone_number" class="block text-sm font-semibold text-gray-700 mb-2">
                    <div class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-[#132A13]" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path></svg>
                        Telefon
                    </div>
                </label>
                <input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full rounded-xl border-2 border-gray-200 px-4 py-3 shadow-sm focus:border-[#132A13] focus:ring-2 focus:ring-[#132A13]/20 sm:text-sm transition-all @error('phone_number') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror" value="{{ old('phone_number', $user->phone_number) }}" autocomplete="tel" />
                <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
            </div>

            <div>
                <label for="position" class="block text-sm font-semibold text-gray-700 mb-2">
                    <div class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-[#132A13]" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"></path><path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"></path></svg>
                        Jawatan
                    </div>
                </label>
                <input id="position" name="position" type="text" class="mt-1 block w-full rounded-xl border-2 border-gray-200 px-4 py-3 shadow-sm focus:border-[#132A13] focus:ring-2 focus:ring-[#132A13]/20 sm:text-sm transition-all @error('position') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror" value="{{ old('position', $user->position) }}" />
                <x-input-error class="mt-2" :messages="$errors->get('position')" />
            </div>
        </div>

        <div>
            <label for="profile_picture" class="block text-sm font-semibold text-gray-700 mb-2">
                <div class="flex items-center gap-2">
                    <svg class="h-4 w-4 text-[#132A13]" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path></svg>
                    Gambar Profil
                </div>
            </label>
            <div class="mt-3 flex items-center gap-6">
                <div class="relative">
                    @if ($user->profile_picture)
                        <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" id="profile-preview" class="h-24 w-24 rounded-full object-cover border-4 border-white shadow-lg ring-2 ring-[#F0F7F0]" />
                    @else
                        <img src="{{ asset('images/default-avatar.svg') }}" alt="Profile Picture" id="profile-preview" class="h-24 w-24 rounded-full object-cover border-4 border-white shadow-lg ring-2 ring-[#F0F7F0]" />
                    @endif
                    <div class="absolute bottom-0 right-0 w-6 h-6 rounded-full bg-green-500 border-4 border-white"></div>
                </div>
                <div class="flex-1">
                    <input id="profile_picture" name="profile_picture" type="file" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:rounded-xl file:border-0 file:bg-gradient-to-br file:from-[#132A13] file:to-[#2F4F2F] file:px-6 file:py-3 file:text-sm file:font-semibold file:text-white hover:file:from-[#2F4F2F] hover:file:to-[#132A13] transition-all @error('profile_picture') border-red-300 @enderror" onchange="previewProfilePicture(this)" />
                    <p class="mt-2 text-xs text-gray-500 flex items-center gap-1">
                        <svg class="h-3 w-3 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                        Format: JPG, PNG, GIF. Maksimum: 2MB
                    </p>
                </div>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('profile_picture')" />
        </div>

        <div class="flex items-center justify-end gap-3 border-t-2 border-gray-200 pt-6">
            <button type="submit" class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-[#132A13] to-[#2F4F2F] px-6 py-2.5 text-sm font-semibold text-white shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-[1.02] transform">
                <div class="absolute inset-0 bg-gradient-to-br from-white/0 to-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative flex items-center gap-2">
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                    {{ __('Simpan') }}
                </div>
            </button>
        </div>
    </form>

    @push('scripts')
    <script>
        function previewProfilePicture(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profile-preview').src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    @endpush
</section>
