<section>
    <div class="bg-gradient-to-r from-[#F0F7F0] to-[#F0F7F0]/80 border-b border-gray-200 px-6 py-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-[#132A13] flex items-center justify-center">
                <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-900">
                    {{ __('Kemaskini Kata Laluan') }}
                </h2>
                <p class="text-xs text-gray-600">
                    {{ __('Pastikan akaun anda menggunakan kata laluan yang panjang dan rawak untuk kekal selamat.') }}
                </p>
            </div>
        </div>
    </div>

    <form method="post" action="{{ route('password.update') }}" class="p-6 space-y-6" id="updatePasswordForm">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-sm font-semibold text-gray-700 mb-2">
                <div class="flex items-center gap-2">
                    <svg class="h-4 w-4 text-[#132A13]" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                    {{ __('Kata Laluan Semasa') }} <span class="text-red-500">*</span>
                </div>
            </label>
            <div class="relative">
                <input id="update_password_current_password" name="current_password" type="password" required
                    class="mt-1 block w-full rounded-xl border-2 border-gray-200 px-4 py-3 pr-12 shadow-sm focus:border-[#132A13] focus:ring-2 focus:ring-[#132A13]/20 sm:text-sm transition-all @error('current_password', 'updatePassword') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror" 
                    autocomplete="current-password" />
                <button type="button" onclick="togglePasswordVisibility('update_password_current_password', this)" 
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="h-5 w-5 show-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <svg class="h-5 w-5 hide-icon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password" class="block text-sm font-semibold text-gray-700 mb-2">
                <div class="flex items-center gap-2">
                    <svg class="h-4 w-4 text-[#132A13]" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                    {{ __('Kata Laluan Baharu') }} <span class="text-red-500">*</span>
                </div>
            </label>
            <div class="relative">
                <input id="update_password_password" name="password" type="password" required minlength="8"
                    class="mt-1 block w-full rounded-xl border-2 border-gray-200 px-4 py-3 pr-12 shadow-sm focus:border-[#132A13] focus:ring-2 focus:ring-[#132A13]/20 sm:text-sm transition-all @error('password', 'updatePassword') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror" 
                    autocomplete="new-password"
                    oninput="checkPasswordStrength(this.value); checkPasswordMatch();" />
                <button type="button" onclick="togglePasswordVisibility('update_password_password', this)" 
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="h-5 w-5 show-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <svg class="h-5 w-5 hide-icon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Password Strength Indicator -->
            <div id="passwordStrength" class="mt-3 hidden">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-xs font-semibold text-gray-600">Kekuatan Kata Laluan:</span>
                    <span id="strengthText" class="text-xs font-bold"></span>
                </div>
                <div class="h-2 w-full bg-gray-200 rounded-full overflow-hidden">
                    <div id="strengthBar" class="h-full transition-all duration-300 rounded-full"></div>
                </div>
            </div>

            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            <div class="mt-2 space-y-1">
                <p class="text-xs text-gray-500 flex items-center gap-1">
                <svg class="h-3 w-3 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                    Minimum 8 aksara
            </p>
                <p class="text-xs text-gray-500 flex items-center gap-1 ml-4">• Gabungan huruf besar dan kecil</p>
                <p class="text-xs text-gray-500 flex items-center gap-1 ml-4">• Sekurang-kurangnya 1 nombor</p>
                <p class="text-xs text-gray-500 flex items-center gap-1 ml-4">• Sekurang-kurangnya 1 simbol (@, #, $, dll.)</p>
            </div>
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                <div class="flex items-center gap-2">
                    <svg class="h-4 w-4 text-[#132A13]" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    {{ __('Sahkan Kata Laluan Baharu') }} <span class="text-red-500">*</span>
                </div>
            </label>
            <div class="relative">
                <input id="update_password_password_confirmation" name="password_confirmation" type="password" required minlength="8"
                    class="mt-1 block w-full rounded-xl border-2 border-gray-200 px-4 py-3 pr-12 shadow-sm focus:border-[#132A13] focus:ring-2 focus:ring-[#132A13]/20 sm:text-sm transition-all @error('password_confirmation', 'updatePassword') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror" 
                    autocomplete="new-password"
                    oninput="checkPasswordMatch();" />
                <button type="button" onclick="togglePasswordVisibility('update_password_password_confirmation', this)" 
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="h-5 w-5 show-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <svg class="h-5 w-5 hide-icon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Password Match Indicator -->
            <div id="passwordMatchMessage" class="mt-2 hidden">
                <p id="matchSuccess" class="text-xs font-semibold text-green-600 flex items-center gap-1 hidden">
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    Kata laluan sepadan
                </p>
                <p id="matchError" class="text-xs font-semibold text-red-600 flex items-center gap-1 hidden">
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                    Kata laluan tidak sepadan
                </p>
            </div>

            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
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
        // Toggle password visibility
        function togglePasswordVisibility(inputId, button) {
            const input = document.getElementById(inputId);
            const showIcon = button.querySelector('.show-icon');
            const hideIcon = button.querySelector('.hide-icon');
            
            if (input.type === 'password') {
                input.type = 'text';
                showIcon.classList.add('hidden');
                hideIcon.classList.remove('hidden');
            } else {
                input.type = 'password';
                showIcon.classList.remove('hidden');
                hideIcon.classList.add('hidden');
            }
        }

        // Check password strength
        function checkPasswordStrength(password) {
            const strengthDiv = document.getElementById('passwordStrength');
            const strengthBar = document.getElementById('strengthBar');
            const strengthText = document.getElementById('strengthText');
            
            if (password.length === 0) {
                strengthDiv.classList.add('hidden');
                return;
            }
            
            strengthDiv.classList.remove('hidden');
            
            let strength = 0;
            let feedback = '';
            
            // Length check
            if (password.length >= 8) strength += 1;
            if (password.length >= 12) strength += 1;
            
            // Character variety checks
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength += 1;
            if (/\d/.test(password)) strength += 1;
            if (/[^a-zA-Z0-9]/.test(password)) strength += 1;
            
            // Update UI based on strength
            if (strength <= 2) {
                strengthBar.style.width = '33%';
                strengthBar.className = 'h-full transition-all duration-300 rounded-full bg-red-500';
                strengthText.textContent = 'Lemah';
                strengthText.className = 'text-xs font-bold text-red-600';
            } else if (strength <= 3) {
                strengthBar.style.width = '66%';
                strengthBar.className = 'h-full transition-all duration-300 rounded-full bg-yellow-500';
                strengthText.textContent = 'Sederhana';
                strengthText.className = 'text-xs font-bold text-yellow-600';
            } else {
                strengthBar.style.width = '100%';
                strengthBar.className = 'h-full transition-all duration-300 rounded-full bg-green-500';
                strengthText.textContent = 'Kuat';
                strengthText.className = 'text-xs font-bold text-green-600';
            }
        }

        // Check if passwords match
        function checkPasswordMatch() {
            const password = document.getElementById('update_password_password').value;
            const confirmation = document.getElementById('update_password_password_confirmation').value;
            const messageDiv = document.getElementById('passwordMatchMessage');
            const matchSuccess = document.getElementById('matchSuccess');
            const matchError = document.getElementById('matchError');
            
            if (confirmation.length === 0) {
                messageDiv.classList.add('hidden');
                return;
            }
            
            messageDiv.classList.remove('hidden');
            
            if (password === confirmation) {
                matchSuccess.classList.remove('hidden');
                matchError.classList.add('hidden');
                document.getElementById('update_password_password_confirmation').classList.remove('border-red-300');
                document.getElementById('update_password_password_confirmation').classList.add('border-green-300');
            } else {
                matchSuccess.classList.add('hidden');
                matchError.classList.remove('hidden');
                document.getElementById('update_password_password_confirmation').classList.add('border-red-300');
                document.getElementById('update_password_password_confirmation').classList.remove('border-green-300');
            }
        }

        // Form submission with confirmation
        document.getElementById('updatePasswordForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const password = document.getElementById('update_password_password').value;
            const confirmation = document.getElementById('update_password_password_confirmation').value;
            const currentPassword = document.getElementById('update_password_current_password').value;
            
            // Validate current password
            if (!currentPassword) {
                Swal.fire({
                    icon: 'error',
                    title: 'Ralat!',
                    text: 'Sila masukkan kata laluan semasa anda.',
                    confirmButtonColor: '#dc2626'
                });
                return;
            }
            
            // Validate password length
            if (password.length < 8) {
                Swal.fire({
                    icon: 'error',
                    title: 'Ralat!',
                    text: 'Kata laluan baharu mestilah sekurang-kurangnya 8 aksara.',
                    confirmButtonColor: '#dc2626'
                });
                return;
            }
            
            // Check if passwords match
            if (password !== confirmation) {
                Swal.fire({
                    icon: 'error',
                    title: 'Kata Laluan Tidak Sepadan!',
                    text: 'Kata laluan baharu dan pengesahan kata laluan tidak sepadan.',
                    confirmButtonColor: '#dc2626'
                });
                return;
            }
            
            // Check password strength
            const hasUpperCase = /[A-Z]/.test(password);
            const hasLowerCase = /[a-z]/.test(password);
            const hasNumber = /\d/.test(password);
            const hasSpecial = /[^a-zA-Z0-9]/.test(password);
            
            if (!hasUpperCase || !hasLowerCase || !hasNumber || !hasSpecial) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Kata Laluan Lemah',
                    html: 'Kata laluan anda tidak memenuhi keperluan keselamatan:<br><br>' +
                          '<div class="text-left text-sm">' +
                          (!hasUpperCase ? '<p>• Tiada huruf besar</p>' : '') +
                          (!hasLowerCase ? '<p>• Tiada huruf kecil</p>' : '') +
                          (!hasNumber ? '<p>• Tiada nombor</p>' : '') +
                          (!hasSpecial ? '<p>• Tiada simbol khas</p>' : '') +
                          '</div><br>' +
                          'Adakah anda pasti mahu meneruskan?',
                    showCancelButton: true,
                    confirmButtonColor: '#f59e0b',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, teruskan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        showConfirmationDialog(this);
                    }
                });
                return;
            }
            
            // Show confirmation dialog
            showConfirmationDialog(this);
        });

        function showConfirmationDialog(form) {
            Swal.fire({
                title: 'Kemaskini Kata Laluan?',
                html: '<div class="text-left">' +
                      '<p class="mb-3">Anda akan menukar kata laluan akaun anda.</p>' +
                      '<div class="bg-yellow-50 border-l-4 border-yellow-400 p-3 rounded">' +
                      '<p class="text-sm text-yellow-800 font-semibold mb-1">Penting:</p>' +
                      '<ul class="text-sm text-yellow-700 space-y-1">' +
                      '<li>• Pastikan anda mengingati kata laluan baharu</li>' +
                      '<li>• Anda akan perlu log masuk semula</li>' +
                      '<li>• Semua sesi lain akan ditamatkan</li>' +
                      '</ul>' +
                      '</div>' +
                      '</div>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#132A13',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, kemaskini!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Mengemaskini...',
                        text: 'Sila tunggu',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Submit the form
                    form.submit();
                }
            });
        }
    </script>
    @endpush
</section>
