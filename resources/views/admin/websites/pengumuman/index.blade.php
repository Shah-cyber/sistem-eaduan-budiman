@extends('layouts.admin')

@section('content')
    @php
        $user = auth()->user();
        $isSuperAdmin = $user && method_exists($user, 'hasRole') && $user->hasRole('Super Admin');
        $indexRoute = $isSuperAdmin ? 'admin.websites.pengumuman.index' : 'admin.panel.websites.pengumuman.index';
        $createRoute = $isSuperAdmin ? 'admin.websites.pengumuman.create' : 'admin.panel.websites.pengumuman.create';
    @endphp

    {{-- Header with Back Button and Title --}}
    <div class="mb-6">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ $isSuperAdmin ? route('admin.dashboard') : route('admin.panel.dashboard') }}"
                class="group flex items-center gap-2 px-4 py-2 rounded-xl bg-white border-2 border-[#F0F7F0] text-[#132A13] shadow-sm transition-all duration-300 hover:bg-[#F0F7F0] hover:border-[#132A13] hover:shadow-md active:scale-95 touch-manipulation">
                <svg class="w-5 h-5 transition-transform duration-300 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="font-medium">Kembali</span>
            </a>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1
                    class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2 bg-gradient-to-r from-[#132A13] via-[#2F4F2F] to-[#132A13] bg-clip-text text-transparent">
                    Pengumuman
                </h1>
                <p class="text-sm sm:text-base text-gray-600">Urus pengumuman dan maklumat penting untuk penduduk Kampung Budiman</p>
            </div>
            <a href="{{ route($createRoute) }}"
                class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-[#132A13] to-[#2F4F2F] px-5 py-3 sm:px-6 sm:py-3.5 text-sm font-semibold text-white shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-[1.02] active:scale-95 transform touch-manipulation">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-white/0 to-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>
                <div class="relative flex items-center justify-center gap-2">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span>Tambah Pengumuman</span>
                </div>
            </a>
        </div>
    </div>

    {{-- Search & Filter --}}
    <div class="mb-6 rounded-2xl border border-gray-200 bg-gradient-to-br from-[#F0F7F0] to-white p-6 shadow-lg">
        <form id="searchForm" class="flex gap-4" onsubmit="return false;">
            <div class="flex-1">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <input type="text" id="searchInput" name="search" placeholder="Cari Pengumuman (Tajuk, Kandungan)..."
                        class="w-full pl-10 rounded-xl border-2 border-gray-200 py-2.5 text-sm shadow-sm focus:border-[#132A13] focus:ring-[#132A13] transition-all">
                </div>
            </div>
            <button type="button" id="resetBtn" 
                class="hidden group relative overflow-hidden rounded-xl border-2 border-gray-300 bg-white px-6 py-2.5 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 hover:border-gray-400 transition-all duration-300">
                <div class="relative flex items-center justify-center gap-2">
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <span>Reset</span>
                </div>
            </button>
        </form>
        <div id="searchResults" class="mt-3 text-sm text-gray-600 hidden">
            <span id="resultCount" class="font-semibold text-[#132A13]">0</span> hasil ditemui
        </div>
    </div>

    {{-- Data Table --}}
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-lg">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200 bg-gradient-to-r from-[#F0F7F0] to-white">
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Tajuk</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Kandungan</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Tarikh Mula</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Tarikh Tamat</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Imej</th>
                        <th class="px-6 py-4 text-right text-sm font-semibold text-gray-900">Tindakan</th>
                    </tr>
                </thead>
                <tbody id="pengumumanTableBody">
                    @php
                        $editRoute = $isSuperAdmin ? 'admin.websites.pengumuman.edit' : 'admin.panel.websites.pengumuman.edit';
                        $destroyRoute = $isSuperAdmin ? 'admin.websites.pengumuman.destroy' : 'admin.panel.websites.pengumuman.destroy';
                    @endphp

                    @forelse($asdasd as $pengumuman)
                        <tr class="pengumuman-row border-b border-gray-100 hover:bg-[#F0F7F0]/50 transition-colors"
                            data-title="{{ strtolower($pengumuman->title ?? '') }}"
                            data-content="{{ strtolower(strip_tags($pengumuman->content ?? ($pengumuman->kandungan ?? ''))) }}">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $pengumuman->title ?? '—' }}</td>

                            <td class="px-6 py-4 text-sm text-gray-600 max-w-xl">
                                <div class="text-sm text-gray-600 line-clamp-2">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($pengumuman->content ?? ($pengumuman->kandungan ?? '')), 120) }}
                                </div>
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $pengumuman->start_date ? \Carbon\Carbon::parse($pengumuman->start_date)->format('d F Y') : '-' }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $pengumuman->end_date ? \Carbon\Carbon::parse($pengumuman->end_date)->format('d F Y') : '-' }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-600">
                                <div class="w-20 h-12 overflow-hidden rounded-md border border-gray-200">
                                    <img src="{{ config('app.website_url') }}/storage/{{ $pengumuman->image_path }}" alt="Imej Pengumuman"
                                        class="w-full h-full object-cover">
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right text-sm">
                                <a href="{{ route($editRoute, ['pengumuman' => $pengumuman->announcementID]) }}"
                                    class="text-[#132A13] hover:text-[#2F4F2F] font-medium mr-4">Edit</a>

                                <form action="{{ route($destroyRoute, ['pengumuman' => $pengumuman->announcementID]) }}" method="POST"
                                    class="inline-block delete-form" data-title="{{ $pengumuman->title ?? 'pengumuman ini' }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Padam</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500">
                                Tiada pengumuman ditemui.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- No Results Message --}}
        <div id="noResultsMessage" class="hidden px-6 py-16 text-center">
            <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <h3 class="text-base font-semibold text-gray-900 mb-1">Tiada Hasil Ditemui</h3>
            <p class="text-sm text-gray-500 mb-6">Tiada pengumuman yang sepadan dengan carian anda.</p>
            <button type="button" id="clearSearchBtn"
                class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-br from-[#132A13] to-[#2F4F2F] px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:shadow-md transition-all">
                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
                Padam Carian
            </button>
        </div>
    </div>

    {{-- Modern Pagination --}}
    @if($asdasd->hasPages())
        <div class="mt-6 flex flex-col items-center justify-between gap-4 sm:flex-row">
            <div class="flex items-center gap-2 text-sm text-gray-600">
                <span>Menunjukkan</span>
                <span class="font-semibold text-[#132A13]">{{ $asdasd->firstItem() ?? 0 }}</span>
                <span>hingga</span>
                <span class="font-semibold text-[#132A13]">{{ $asdasd->lastItem() ?? 0 }}</span>
                <span>daripada</span>
                <span class="font-semibold text-[#132A13]">{{ $asdasd->total() }}</span>
                <span>pengumuman</span>
            </div>
            
            <div class="flex items-center gap-2">
                {{-- Previous Button --}}
                @if($asdasd->onFirstPage())
                    <button disabled class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-400 cursor-not-allowed">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                        Sebelumnya
                    </button>
                @else
                    <a href="{{ $asdasd->appends(request()->query())->previousPageUrl() }}" class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition-all hover:bg-[#F0F7F0] hover:border-[#132A13] hover:text-[#132A13]">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                        Sebelumnya
                    </a>
                @endif

                {{-- Page Numbers --}}
                <div class="hidden sm:flex items-center gap-1">
                    @foreach($asdasd->getUrlRange(1, $asdasd->lastPage()) as $page => $url)
                        @if($page == $asdasd->currentPage())
                            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-gradient-to-r from-[#132A13] to-[#2F4F2F] text-sm font-semibold text-white shadow-md">{{ $page }}</span>
                        @elseif($page == 1 || $page == $asdasd->lastPage() || ($page >= $asdasd->currentPage() - 2 && $page <= $asdasd->currentPage() + 2))
                            <a href="{{ $asdasd->appends(request()->query())->url($page) }}" class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 transition-all hover:bg-[#F0F7F0] hover:border-[#132A13] hover:text-[#132A13]">{{ $page }}</a>
                        @elseif($page == $asdasd->currentPage() - 3 || $page == $asdasd->currentPage() + 3)
                            <span class="flex h-9 w-9 items-center justify-center text-sm text-gray-400">...</span>
                        @endif
                    @endforeach
                </div>

                {{-- Mobile Page Info --}}
                <div class="flex sm:hidden items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700">
                    <span>Halaman</span>
                    <span class="text-[#132A13]">{{ $asdasd->currentPage() }}</span>
                    <span>daripada</span>
                    <span class="text-[#132A13]">{{ $asdasd->lastPage() }}</span>
                </div>

                {{-- Next Button --}}
                @if($asdasd->hasMorePages())
                    <a href="{{ $asdasd->appends(request()->query())->nextPageUrl() }}" class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition-all hover:bg-[#F0F7F0] hover:border-[#132A13] hover:text-[#132A13]">
                        Seterusnya
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    </a>
                @else
                    <button disabled class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-400 cursor-not-allowed">
                        Seterusnya
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    </button>
                @endif
            </div>
        </div>
    @else
        <div class="mt-6 text-center text-sm text-gray-600">
            <p>Menunjukkan semua {{ $asdasd->total() }} pengumuman</p>
        </div>
    @endif

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

            // Search and Filter Functionality
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('searchInput');
                const resetBtn = document.getElementById('resetBtn');
                const clearSearchBtn = document.getElementById('clearSearchBtn');
                const searchResults = document.getElementById('searchResults');
                const resultCount = document.getElementById('resultCount');
                const noResultsMessage = document.getElementById('noResultsMessage');
                const tableBody = document.getElementById('pengumumanTableBody');
                const tableContainer = tableBody ? tableBody.closest('.overflow-x-auto') : null;
                const paginationContainer = document.querySelector('.mt-6.flex.flex-col');

                function filterTable() {
                    const searchTerm = searchInput.value.toLowerCase().trim();
                    const rows = document.querySelectorAll('.pengumuman-row');
                    let visibleCount = 0;

                    if (!rows.length) return;

                    rows.forEach(row => {
                        const title = row.getAttribute('data-title') || '';
                        const content = row.getAttribute('data-content') || '';

                        const matches = searchTerm === '' || 
                            title.includes(searchTerm) || 
                            content.includes(searchTerm);

                        if (matches) {
                            row.style.display = '';
                            visibleCount++;
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    // Show/hide reset button
                    if (searchTerm) {
                        resetBtn.classList.remove('hidden');
                        searchResults.classList.remove('hidden');
                        resultCount.textContent = visibleCount;
                    } else {
                        resetBtn.classList.add('hidden');
                        searchResults.classList.add('hidden');
                    }

                    // Show/hide no results message and pagination
                    if (visibleCount === 0 && searchTerm) {
                        if (tableContainer) tableContainer.style.display = 'none';
                        if (paginationContainer) paginationContainer.style.display = 'none';
                        noResultsMessage.classList.remove('hidden');
                    } else {
                        if (tableContainer) tableContainer.style.display = '';
                        if (paginationContainer && !searchTerm) paginationContainer.style.display = '';
                        else if (paginationContainer && searchTerm) paginationContainer.style.display = 'none';
                        noResultsMessage.classList.add('hidden');
                    }
                }

                // Search input event listener
                if (searchInput) {
                    searchInput.addEventListener('input', filterTable);
                    searchInput.addEventListener('keyup', function(e) {
                        if (e.key === 'Escape') {
                            searchInput.value = '';
                            filterTable();
                        }
                    });
                }

                // Reset button event listener
                if (resetBtn) {
                    resetBtn.addEventListener('click', function() {
                        searchInput.value = '';
                        filterTable();
                        searchInput.focus();
                    });
                }

                // Clear search button in no results message
                if (clearSearchBtn) {
                    clearSearchBtn.addEventListener('click', function() {
                        searchInput.value = '';
                        filterTable();
                        searchInput.focus();
                    });
                }
            });

            // Handle delete confirmation with SweetAlert2
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const form = this;
                    const title = form.getAttribute('data-title');
                    
                    Swal.fire({
                        title: 'Adakah anda pasti?',
                        html: `Pengumuman <strong>"${title}"</strong> akan dipadam secara kekal!`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, padam!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading
                            Swal.fire({
                                title: 'Memadam...',
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
                });
            });
        </script>
    @endpush
@endsection
