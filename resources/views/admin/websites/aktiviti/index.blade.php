@extends('layouts.admin')

@section('content')
    @php
        $user = auth()->user();
        $isSuperAdmin = $user && method_exists($user, 'hasRole') && $user->hasRole('Super Admin');
        $indexRoute = $isSuperAdmin ? 'admin.websites.aktiviti.index' : 'admin.panel.websites.aktiviti.index';
        $createRoute = $isSuperAdmin ? 'admin.websites.aktiviti.create' : 'admin.panel.websites.aktiviti.create';
        $editRoute = $isSuperAdmin ? 'admin.websites.aktiviti.edit' : 'admin.panel.websites.aktiviti.edit';
        $destroyRoute = $isSuperAdmin ? 'admin.websites.aktiviti.destroy' : 'admin.panel.websites.aktiviti.destroy';
    @endphp

    {{-- Header with Back Button and Title --}}
    <div class="mb-6">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ $isSuperAdmin ? route('admin.dashboard') : route('admin.panel.dashboard') }}"
                class="group flex items-center gap-2 px-4 py-2 rounded-xl bg-white border-2 border-[#F0F7F0] text-[#132A13] shadow-sm transition-all duration-300 hover:bg-[#F0F7F0] hover:border-[#132A13] hover:shadow-md active:scale-95 touch-manipulation">
                <svg class="w-5 h-5 transition-transform duration-300 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="font-medium">Kembali</span>
            </a>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2 bg-gradient-to-r from-[#132A13] via-[#2F4F2F] to-[#132A13] bg-clip-text text-transparent">
                    Aktiviti Kampung Budiman
                </h1>
                <p class="text-sm sm:text-base text-gray-600">Urus aktiviti dan program di Kampung Budiman</p>
            </div>
            <a href="{{ route($createRoute) }}"
                class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-[#132A13] to-[#2F4F2F] px-5 py-3 sm:px-6 sm:py-3.5 text-sm font-semibold text-white shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-[1.02] active:scale-95 transform touch-manipulation">
                <div class="absolute inset-0 bg-gradient-to-br from-white/0 to-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            </div>
                <div class="relative flex items-center justify-center gap-2">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span>Tambah Aktiviti</span>
        </div>
            </a>
        </div>
        </div>

    {{-- Data Table --}}
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-lg">
        @if (isset($activities) && count($activities) > 0)
        <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-[#F0F7F0] to-[#F0F7F0]/80">
                    <tr>
                            <th class="px-4 sm:px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700">No.</th>
                            <th class="px-4 sm:px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700">Gambar</th>
                            <th class="px-4 sm:px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700">Nama Aktiviti</th>
                            <th class="hidden md:table-cell px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700">Keterangan</th>
                            <th class="hidden sm:table-cell px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700">Tarikh</th>
                            <th class="px-4 sm:px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-gray-700">Tindakan</th>
                    </tr>
                </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach ($activities as $index => $activity)
                        @php
                                $images = array_filter(explode(',', $activity->image_path ?? ''));
                            $imagePaths = array_map(fn($img) => config('app.website_url') . '/storage/' . trim($img), $images);
                        @endphp
                            <tr class="hover:bg-[#F0F7F0]/50 transition-colors">
                                <td class="whitespace-nowrap px-4 sm:px-6 py-4">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-[#F0F7F0] text-[#132A13] font-bold text-sm">
                                {{ $loop->iteration }}
                                    </span>
                            </td>
                                <td class="px-4 sm:px-6 py-4">
                                    <div class="w-24 sm:w-36 h-16 sm:h-24 rounded-lg overflow-hidden bg-gray-200 relative group carousel hover:shadow-lg transition">
                                    @if (!empty($imagePaths))
                                        <div class="carousel-container flex transition-transform duration-300 h-full" data-index="0">
                                            @foreach ($imagePaths as $img)
                                                <img src="{{ $img }}" alt="Gambar Aktiviti" class="w-full h-full object-cover flex-shrink-0">
                                            @endforeach
                                        </div>
                                        @if (count($imagePaths) > 1)
                                                <button class="carousel-btn-prev absolute left-0 top-1/2 -translate-y-1/2 p-1 bg-black/40 hover:bg-black/70 text-white opacity-0 group-hover:opacity-100 transition-opacity rounded-r-lg">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="m15 18-6-6 6-6" />
                                                </svg>
                                            </button>
                                                <button class="carousel-btn-next absolute right-0 top-1/2 -translate-y-1/2 p-1 bg-black/40 hover:bg-black/70 text-white opacity-0 group-hover:opacity-100 transition-opacity rounded-l-lg">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="m9 18 6-6-6-6" />
                                                </svg>
                                            </button>
                                                <div class="absolute bottom-1 right-1 text-xs px-1.5 py-0.5 bg-black/50 text-white rounded carousel-indicator">
                                                1/{{ count($imagePaths) }}
                                            </div>
                                        @else
                                                <div class="absolute bottom-1 right-1 text-xs px-1.5 py-0.5 bg-black/50 text-white rounded">
                                                1/1
                                            </div>
                                        @endif
                                    @else
                                            <div class="flex items-center justify-center h-full text-gray-400 text-xs sm:text-sm">
                                            Tiada Gambar
                                        </div>
                                    @endif
                                </div>
                            </td>
                                <td class="px-4 sm:px-6 py-4">
                                    <div class="text-sm font-semibold text-gray-900">{{ $activity->title ?? 'N/A' }}</div>
                                    <div class="md:hidden text-xs text-gray-500 mt-1">{{ Str::limit($activity->description ?? '', 50) }}</div>
                                    <div class="sm:hidden text-xs text-gray-600 mt-1">{{ \Carbon\Carbon::parse($activity->activity_date ?? now())->format('d/m/Y') }}</div>
                            </td>
                                <td class="hidden md:table-cell px-6 py-4">
                                    <div class="text-sm text-gray-600 max-w-xs truncate">{{ $activity->description ?? '-' }}</div>
                            </td>
                                <td class="hidden sm:table-cell whitespace-nowrap px-6 py-4">
                                    <div class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($activity->activity_date ?? now())->format('d/m/Y') }}</div>
                            </td>
                                <td class="whitespace-nowrap px-4 sm:px-6 py-4">
                                    <div class="flex items-center justify-end gap-2 flex-wrap">
                                        <a href="{{ route($editRoute, ['aktiviti' => $activity->activityID]) }}"
                                            class="inline-flex items-center gap-1.5 rounded-lg border-2 border-[#F0F7F0] bg-[#F0F7F0] px-3 py-1.5 text-xs font-semibold text-[#132A13] shadow-sm hover:bg-[#132A13] hover:text-white hover:border-[#132A13] transition-all hover:scale-105 active:scale-95 transform touch-manipulation">
                                            <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                            </svg>
                                            <span class="hidden xs:inline">Edit</span>
                                        </a>
                                        <form action="{{ route($destroyRoute, ['aktiviti' => $activity->activityID]) }}" method="POST"
                                            class="inline delete-aktiviti-form">
                                    @csrf
                                    @method('DELETE')
                                            <button type="button" 
                                                class="delete-aktiviti-btn inline-flex items-center gap-1.5 rounded-lg border-2 border-red-200 bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-600 shadow-sm hover:bg-red-600 hover:text-white hover:border-red-600 transition-all hover:scale-105 active:scale-95 transform touch-manipulation"
                                                data-name="{{ $activity->title ?? 'Aktiviti ini' }}">
                                                <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="hidden xs:inline">Padam</span>
                                            </button>
                                </form>
                                    </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
            <div class="px-6 py-16 text-center">
                <div class="w-20 h-20 rounded-full bg-gradient-to-br from-[#F0F7F0] to-[#F0F7F0]/50 flex items-center justify-center mx-auto mb-4">
                    <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Tiada Aktiviti</h3>
                <p class="text-sm text-gray-500 mb-6">Mula dengan menambah aktiviti baharu.</p>
                <a href="{{ route($createRoute) }}"
                    class="inline-flex items-center gap-2 rounded-2xl bg-gradient-to-br from-[#132A13] to-[#2F4F2F] px-6 py-3 text-sm font-semibold text-white shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-[1.02] active:scale-95 transform touch-manipulation">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Tambah Aktiviti
                </a>
            </div>
        @endif
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

            // Carousel functionality
            document.querySelectorAll('.carousel-container').forEach(carousel => {
                const container = carousel.closest('.group');
                const images = carousel.querySelectorAll('img');
                const totalImages = images.length;

                if (totalImages <= 1) return;

                const prevBtn = container.querySelector('.carousel-btn-prev');
                const nextBtn = container.querySelector('.carousel-btn-next');
                const indicator = container.querySelector('.carousel-indicator');

                const navigate = (direction) => {
                    let currentIndex = parseInt(carousel.dataset.index);
                    currentIndex += direction;

                    if (currentIndex >= totalImages) currentIndex = 0;
                    if (currentIndex < 0) currentIndex = totalImages - 1;

                    carousel.dataset.index = currentIndex;
                    carousel.style.transform = `translateX(-${currentIndex * 100}%)`;
                    if (indicator) {
                    indicator.textContent = `${currentIndex + 1}/${totalImages}`;
                    }
                };

                prevBtn?.addEventListener('click', () => navigate(-1));
                nextBtn?.addEventListener('click', () => navigate(1));
            });

            // SweetAlert2 confirmation for delete action
            document.addEventListener('DOMContentLoaded', function() {
                const deleteButtons = document.querySelectorAll('.delete-aktiviti-btn');
                
                deleteButtons.forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        const form = this.closest('.delete-aktiviti-form');
                        const aktivitiName = this.getAttribute('data-name') || 'Aktiviti ini';
                        
                        Swal.fire({
                            title: 'Adakah anda pasti?',
                            html: `Adakah anda pasti mahu memadam <strong>${aktivitiName}</strong>?<br><br>Tindakan ini tidak boleh dibatalkan.`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#dc2626',
                            cancelButtonColor: '#6b7280',
                            confirmButtonText: 'Ya, Padam!',
                            cancelButtonText: 'Batal',
                            reverseButtons: true,
                            focusCancel: true,
                            customClass: {
                                popup: 'rounded-2xl',
                                confirmButton: 'rounded-lg',
                                cancelButton: 'rounded-lg'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Show loading state
                                Swal.fire({
                                    title: 'Memadam...',
                                    text: 'Sila tunggu sebentar.',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    showConfirmButton: false,
                                    didOpen: () => {
                                        Swal.showLoading();
                                    }
                                });
                                
                                // Submit the form
                                form.submit();
                            }
                        });
                    });
                });
            });
        </script>
    @endpush
@endsection
