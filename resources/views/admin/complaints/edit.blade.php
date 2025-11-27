@extends('layouts.admin')

@section('content')
	<div class="mb-8">
		<div class="flex items-center justify-between">
			<div>
				<h1 class="text-3xl font-bold text-gray-900 mb-2">Kemaskini Aduan</h1>
				<p class="text-sm text-gray-600">ID Aduan: {{ $complaint->public_id ?? 'N/A' }}</p>
			</div>
			<a href="{{ route($isAdminPanel ? 'admin.panel.complaints.index' : 'admin.complaints.index') }}" class="rounded-xl border-2 border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 transition-all flex items-center gap-2">
				<svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path></svg>
				Kembali
			</a>
		</div>
	</div>

	<div class="rounded-2xl border border-gray-200 bg-white shadow-lg">
		<div class="bg-gradient-to-r from-[#F0F7F0] to-[#F0F7F0]/80 border-b border-gray-200 px-6 py-4">
			<div class="flex items-center gap-3">
				<div class="w-10 h-10 rounded-lg bg-[#132A13] flex items-center justify-center">
					<svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path></svg>
				</div>
				<div>
					<h2 class="text-lg font-bold text-gray-900">Kemaskini Maklumat</h2>
					<p class="text-xs text-gray-600">Ubah maklumat aduan di bawah</p>
				</div>
			</div>
		</div>
		<form action="{{ route($isAdminPanel ? 'admin.panel.complaints.update' : 'admin.complaints.update', $complaint) }}" method="POST" class="p-6" enctype="multipart/form-data" id="complaintForm" novalidate>
			@csrf
			@method('PUT')

			<div class="grid gap-6 md:grid-cols-2">
				{{-- Nama --}}
				<div>
					<label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
						<div class="flex items-center gap-2">
							<svg class="h-4 w-4 text-[#132A13]" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path></svg>
							Nama <span class="text-red-500">*</span>
						</div>
					</label>
					<input 
						type="text" 
						name="name" 
						id="name" 
						value="{{ old('name', $complaint->name) }}" 
						required
						maxlength="100"
						pattern="[a-zA-Z\s]+"
						title="Nama hanya boleh mengandungi huruf dan ruang"
						class="mt-1 block w-full rounded-xl border-2 border-gray-200 px-4 py-3 shadow-sm focus:border-[#132A13] focus:ring-2 focus:ring-[#132A13]/20 sm:text-sm transition-all @error('name') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror"
						oninput="validateName(this)"
					/>
					<div id="name-error" class="mt-1 text-sm text-red-600 hidden"></div>
					@error('name')
						<p class="mt-1 text-sm text-red-600 flex items-center gap-1">
							<svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
							{{ $message }}
						</p>
					@enderror
					<p class="mt-2 text-xs text-gray-500 flex items-center gap-1">
						<svg class="h-3 w-3 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
						Hanya huruf dan ruang dibenarkan
					</p>
				</div>

				{{-- Telefon --}}
				<div>
					<label for="phone_number" class="block text-sm font-semibold text-gray-700 mb-2">
						<div class="flex items-center gap-2">
							<svg class="h-4 w-4 text-[#132A13]" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path></svg>
							Telefon <span class="text-red-500">*</span>
						</div>
					</label>
					<input 
						type="text" 
						name="phone_number" 
						id="phone_number" 
						value="{{ old('phone_number', $complaint->phone_number) }}" 
						required
						maxlength="20"
						pattern="[0-9]+"
						title="Nombor telefon hanya boleh mengandungi nombor"
						class="mt-1 block w-full rounded-xl border-2 border-gray-200 px-4 py-3 shadow-sm focus:border-[#132A13] focus:ring-2 focus:ring-[#132A13]/20 sm:text-sm transition-all @error('phone_number') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror"
						oninput="validatePhone(this)"
					/>
					<div id="phone_number-error" class="mt-1 text-sm text-red-600 hidden"></div>
					@error('phone_number')
						<p class="mt-1 text-sm text-red-600 flex items-center gap-1">
							<svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
							{{ $message }}
						</p>
					@enderror
					<p class="mt-2 text-xs text-gray-500 flex items-center gap-1">
						<svg class="h-3 w-3 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
						Hanya nombor dibenarkan
					</p>
				</div>

				{{-- Email --}}
				<div>
					<label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
						<div class="flex items-center gap-2">
							<svg class="h-4 w-4 text-[#132A13]" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path></svg>
							Emel <span class="text-red-500">*</span>
						</div>
					</label>
					<input 
						type="email" 
						name="email" 
						id="email" 
						value="{{ old('email', $complaint->email) }}" 
						required
						maxlength="255"
						title="Sila masukkan alamat emel yang sah"
						class="mt-1 block w-full rounded-xl border-2 border-gray-200 px-4 py-3 shadow-sm focus:border-[#132A13] focus:ring-2 focus:ring-[#132A13]/20 sm:text-sm transition-all @error('email') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror"
						oninput="validateEmail(this)"
					/>
					<div id="email-error" class="mt-1 text-sm text-red-600 hidden"></div>
					@error('email')
						<p class="mt-1 text-sm text-red-600 flex items-center gap-1">
							<svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
							{{ $message }}
						</p>
					@enderror
					<p class="mt-2 text-xs text-gray-500 flex items-center gap-1">
						<svg class="h-3 w-3 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
						Contoh: nama@email.com
					</p>
				</div>

				{{-- Alamat --}}
				<div class="md:col-span-2">
					<label for="address" class="block text-sm font-semibold text-gray-700 mb-2">
						<div class="flex items-center gap-2">
							<svg class="h-4 w-4 text-[#132A13]" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
							Alamat <span class="text-red-500">*</span>
						</div>
					</label>
					<textarea 
						name="address" 
						id="address" 
						rows="3"
						required
						maxlength="200"
						pattern="[a-zA-Z0-9\s.,-]+"
						title="Alamat hanya boleh mengandungi huruf, nombor, dan aksara khas (., -)"
						class="mt-1 block w-full rounded-xl border-2 border-gray-200 px-4 py-3 shadow-sm focus:border-[#132A13] focus:ring-2 focus:ring-[#132A13]/20 sm:text-sm transition-all resize-none @error('address') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror"
						oninput="updateCharCounter('address', 200); validateAddress(this)"
					>{{ old('address', $complaint->address) }}</textarea>
					<div class="mt-2 flex items-center justify-between">
						<div id="address-error" class="text-sm text-red-600 hidden flex items-center gap-1">
							<svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
						</div>
						<div id="address-counter" class="text-xs font-medium text-gray-500">
							<span id="address-count" class="text-[#132A13]">0</span>/200 aksara
						</div>
					</div>
					@error('address')
						<p class="mt-1 text-sm text-red-600 flex items-center gap-1">
							<svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
							{{ $message }}
						</p>
					@enderror
				</div>

				{{-- Jenis Aduan --}}
				<div>
					<label for="complaint_type_id" class="block text-sm font-semibold text-gray-700 mb-2">
						<div class="flex items-center gap-2">
							<svg class="h-4 w-4 text-[#132A13]" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2h-2.22l.123.489.804.804A1 1 0 0113 18H7a1 1 0 01-.707-1.707l.804-.804L7.22 15H5a2 2 0 01-2-2V5zm5.771 7H5V5h10v7H8.771z" clip-rule="evenodd"></path></svg>
							Jenis Aduan <span class="text-red-500">*</span>
						</div>
					</label>
					<div class="relative">
						<select 
							name="complaint_type_id" 
							id="complaint_type_id" 
							required
							class="mt-1 block w-full appearance-none rounded-xl border-2 border-gray-200 bg-white px-4 py-3 pr-10 shadow-sm focus:border-[#132A13] focus:ring-2 focus:ring-[#132A13]/20 sm:text-sm transition-all @error('complaint_type_id') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror"
						>
							<option value="">Pilih Jenis Aduan</option>
							@foreach($complaintTypes as $type)
								<option value="{{ $type->id }}" {{ old('complaint_type_id', $complaint->complaint_type_id) == $type->id ? 'selected' : '' }}>
									{{ $type->type_name }}
								</option>
							@endforeach
						</select>
						<div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 mt-1">
							<svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
						</div>
					</div>
					@error('complaint_type_id')
						<p class="mt-1 text-sm text-red-600 flex items-center gap-1">
							<svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
							{{ $message }}
						</p>
					@enderror
				</div>

				{{-- Status --}}
				<div>
					<label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
						<div class="flex items-center gap-2">
							<svg class="h-4 w-4 text-[#132A13]" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
							Status <span class="text-red-500">*</span>
						</div>
					</label>
					<div class="relative">
						<select 
							name="status" 
							id="status" 
							required
							class="mt-1 block w-full appearance-none rounded-xl border-2 border-gray-200 bg-white px-4 py-3 pr-10 shadow-sm focus:border-[#132A13] focus:ring-2 focus:ring-[#132A13]/20 sm:text-sm transition-all @error('status') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror"
						>
							@foreach($statuses as $status)
								<option value="{{ $status }}" {{ old('status', $complaint->status) === $status ? 'selected' : '' }}>
									{{ ucfirst($status) }}
								</option>
							@endforeach
						</select>
						<div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 mt-1">
							<svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
						</div>
					</div>
					@error('status')
						<p class="mt-1 text-sm text-red-600 flex items-center gap-1">
							<svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
							{{ $message }}
						</p>
					@enderror
				</div>

				{{-- Penerangan --}}
				<div class="md:col-span-2">
					<label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
						<div class="flex items-center gap-2">
							<svg class="h-4 w-4 text-[#132A13]" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
							Penerangan <span class="text-red-500">*</span>
						</div>
					</label>
					<textarea 
						name="description" 
						id="description" 
						rows="4"
						required
						maxlength="500"
						class="mt-1 block w-full rounded-xl border-2 border-gray-200 px-4 py-3 shadow-sm focus:border-[#132A13] focus:ring-2 focus:ring-[#132A13]/20 sm:text-sm transition-all resize-none @error('description') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror"
						oninput="updateCharCounter('description', 500)"
					>{{ old('description', $complaint->description) }}</textarea>
					<div class="mt-2 flex items-center justify-between">
						<div id="description-error" class="text-sm text-red-600 hidden flex items-center gap-1">
							<svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
						</div>
						<div id="description-counter" class="text-xs font-medium text-gray-500">
							<span id="description-count" class="text-[#132A13]">0</span>/500 aksara
						</div>
					</div>
					@error('description')
						<p class="mt-1 text-sm text-red-600 flex items-center gap-1">
							<svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
							{{ $message }}
						</p>
					@enderror
				</div>

				{{-- Gambar --}}
				<div class="md:col-span-2">
					<label for="image_path" class="block text-sm font-semibold text-gray-700 mb-2">
						<div class="flex items-center gap-2">
							<svg class="h-4 w-4 text-[#132A13]" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path></svg>
							Gambar
						</div>
					</label>
					@if($complaint->hasImages())
						<div class="mb-6 rounded-xl border-2 border-gray-200 bg-gray-50 p-4">
							<p class="mb-4 text-sm font-semibold text-gray-700 flex items-center gap-2">
								<svg class="h-4 w-4 text-[#132A13]" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path></svg>
								Gambar Semasa ({{ count($complaint->image_path) }}):
							</p>
							<div class="grid grid-cols-2 gap-3 md:grid-cols-4">
								@foreach($complaint->image_path as $imagePath)
									<div class="relative group">
										{{-- Image Container --}}
										<div class="relative w-full rounded-md border border-gray-300 overflow-hidden bg-gray-100">
											{{-- Image --}}
											<div class="relative w-full h-24">
												<img src="{{ asset('storage/' . $imagePath) }}" alt="Gambar Aduan" class="w-full h-full object-cover">
												
												{{-- Delete Checkbox - Always on top, fully clickable, positioned first so it's above everything --}}
												<div class="absolute top-1 right-1 z-50">
													<label class="flex items-center gap-1 bg-white border-2 border-red-400 px-2 py-1 rounded-md text-xs cursor-pointer hover:bg-red-50 hover:border-red-500 shadow-lg transition-all" 
														   onclick="event.stopPropagation(); event.preventDefault();">
														<input type="checkbox" 
															   name="remove_images[]" 
															   value="{{ $imagePath }}" 
															   class="rounded border-gray-300 text-red-600 focus:ring-red-500 cursor-pointer w-3.5 h-3.5"
															   onclick="event.stopPropagation(); event.cancelBubble = true;">
														<span class="text-red-600 font-semibold text-[11px]">Padam</span>
													</label>
												</div>
												
												{{-- Preview Overlay - Clickable but excludes top-right corner --}}
												<a href="{{ asset('storage/' . $imagePath) }}" 
												   target="_blank" 
												   class="absolute left-0 bottom-0 right-0 top-0 flex items-center justify-center bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-opacity z-10 rounded-md"
												   style="clip-path: polygon(0 0, calc(100% - 70px) 0, calc(100% - 70px) 35px, 100% 35px, 100% 100%, 0 100%);"
												   onclick="if(event.target.closest('.z-50')) { event.preventDefault(); event.stopPropagation(); return false; }">
													<svg class="h-6 w-6 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
														<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
													</svg>
												</a>
											</div>
										</div>
									</div>
								@endforeach
							</div>
						</div>
					@endif
					<div class="relative">
						<input 
							type="file" 
							name="image_path[]" 
							id="image_path" 
							accept="image/*"
							multiple
							class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:rounded-xl file:border-0 file:bg-gradient-to-br file:from-[#132A13] file:to-[#2F4F2F] file:px-6 file:py-3 file:text-sm file:font-semibold file:text-white hover:file:from-[#2F4F2F] hover:file:to-[#132A13] transition-all @error('image_path') border-red-300 @enderror"
						/>
					</div>
					<p class="mt-2 text-xs text-gray-500 flex items-center gap-1">
						<svg class="h-3 w-3 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
						Format: JPG, PNG, GIF. Maksimum: 10 gambar, setiap satu 2MB
					</p>
					<div id="image-preview-container" class="mt-4 grid grid-cols-2 gap-4 md:grid-cols-4"></div>
					@error('image_path')
						<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
					@enderror
					@error('image_path.*')
						<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
					@enderror
				</div>

				{{-- Komen Admin --}}
				<div class="md:col-span-2">
					<label for="admin_comment" class="block text-sm font-semibold text-gray-700 mb-2">
						<div class="flex items-center gap-2">
							<svg class="h-4 w-4 text-[#132A13]" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
							Komen Admin (Pilihan)
						</div>
					</label>
					<textarea 
						name="admin_comment" 
						id="admin_comment" 
						rows="3"
						maxlength="500"
						class="mt-1 block w-full rounded-xl border-2 border-gray-200 px-4 py-3 shadow-sm focus:border-[#132A13] focus:ring-2 focus:ring-[#132A13]/20 sm:text-sm transition-all resize-none @error('admin_comment') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror"
						oninput="updateCharCounter('admin_comment', 500)"
					>{{ old('admin_comment', $complaint->admin_comment) }}</textarea>
					<div class="mt-2 flex items-center justify-between">
						<div id="admin_comment-error" class="text-sm text-red-600 hidden flex items-center gap-1">
							<svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
						</div>
						<div id="admin_comment-counter" class="text-xs font-medium text-gray-500">
							<span id="admin_comment-count" class="text-[#132A13]">0</span>/500 aksara
						</div>
					</div>
					@error('admin_comment')
						<p class="mt-1 text-sm text-red-600 flex items-center gap-1">
							<svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
							{{ $message }}
						</p>
					@enderror
				</div>
			</div>

			{{-- Actions --}}
			<div class="mt-8 flex items-center justify-end gap-3 border-t-2 border-gray-200 pt-6">
				<a href="{{ route($isAdminPanel ? 'admin.panel.complaints.index' : 'admin.complaints.index') }}" class="rounded-xl border-2 border-gray-300 bg-white px-6 py-2.5 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 transition-all">
					Batal
				</a>
				<button type="submit" class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-[#132A13] to-[#2F4F2F] px-6 py-2.5 text-sm font-semibold text-white shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-[1.02] transform">
					<div class="absolute inset-0 bg-gradient-to-br from-white/0 to-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
					<div class="relative flex items-center gap-2">
						<svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
						Kemaskini
					</div>
				</button>
			</div>
		</form>
	</div>

	@push('scripts')
	<script>
		// Show success/error messages from session
		@if (session('success'))
			Swal.fire({
				icon: 'success',
				title: 'Berjaya!',
				text: '{{ session('success') }}',
				confirmButtonColor: '#4f46e5',
				timer: 3000,
				timerProgressBar: true
			}).then(() => {
				window.location.href = '{{ route($isAdminPanel ? "admin.panel.complaints.index" : "admin.complaints.index") }}';
			});
		@endif

		@if ($errors->any())
			Swal.fire({
				icon: 'error',
				title: 'Ralat Pengesahan!',
				html: '<ul class="text-left list-disc list-inside">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
				confirmButtonColor: '#dc2626'
			});
		@endif

		// Initialize character counters on page load
		document.addEventListener('DOMContentLoaded', function() {
			updateCharCounter('address', 200);
			updateCharCounter('description', 500);
			updateCharCounter('admin_comment', 500);
		});

		// Character counter function
		function updateCharCounter(fieldId, maxLength) {
			const field = document.getElementById(fieldId);
			const counter = document.getElementById(fieldId + '-count');
			if (field && counter) {
				const currentLength = field.value.length;
				counter.textContent = currentLength;
				
				// Update counter color based on length
				const counterDiv = document.getElementById(fieldId + '-counter');
				if (currentLength > maxLength * 0.9) {
					counterDiv.classList.remove('text-gray-500');
					counterDiv.classList.add('text-orange-600', 'font-medium');
				} else if (currentLength > maxLength) {
					counterDiv.classList.remove('text-gray-500', 'text-orange-600');
					counterDiv.classList.add('text-red-600', 'font-semibold');
				} else {
					counterDiv.classList.remove('text-orange-600', 'text-red-600', 'font-medium', 'font-semibold');
					counterDiv.classList.add('text-gray-500');
				}
			}
		}

		// Validate name field (letters and spaces only)
		function validateName(input) {
			const value = input.value;
			const errorDiv = document.getElementById('name-error');
			const pattern = /^[a-zA-Z\s]*$/;
			
			if (value && !pattern.test(value)) {
				input.classList.add('border-red-300', 'ring-2', 'ring-red-200');
				input.classList.remove('border-gray-300');
				errorDiv.textContent = 'Nama hanya boleh mengandungi huruf dan ruang.';
				errorDiv.classList.remove('hidden');
				return false;
			} else {
				input.classList.remove('border-red-300', 'ring-2', 'ring-red-200');
				input.classList.add('border-gray-300');
				errorDiv.classList.add('hidden');
				return true;
			}
		}

		// Validate phone field (numbers only)
		function validatePhone(input) {
			const value = input.value;
			const errorDiv = document.getElementById('phone_number-error');
			const pattern = /^[0-9]*$/;
			
			if (value && !pattern.test(value)) {
				input.classList.add('border-red-300', 'ring-2', 'ring-red-200');
				input.classList.remove('border-gray-300');
				errorDiv.textContent = 'Nombor telefon hanya boleh mengandungi nombor.';
				errorDiv.classList.remove('hidden');
				return false;
			} else {
				input.classList.remove('border-red-300', 'ring-2', 'ring-red-200');
				input.classList.add('border-gray-300');
				errorDiv.classList.add('hidden');
				return true;
			}
		}

		// Validate address field (letters, numbers, and special chars)
		function validateAddress(input) {
			const value = input.value;
			const errorDiv = document.getElementById('address-error');
			const pattern = /^[a-zA-Z0-9\s.,-]*$/;
			
			if (value && !pattern.test(value)) {
				input.classList.add('border-red-300', 'ring-2', 'ring-red-200');
				input.classList.remove('border-gray-300');
				errorDiv.textContent = 'Alamat hanya boleh mengandungi huruf, nombor, dan aksara khas (., -).';
				errorDiv.classList.remove('hidden');
				return false;
			} else {
				input.classList.remove('border-red-300', 'ring-2', 'ring-red-200');
				input.classList.add('border-gray-300');
				errorDiv.classList.add('hidden');
				return true;
			}
		}

		// Validate email field
		function validateEmail(input) {
			const value = input.value;
			const errorDiv = document.getElementById('email-error');
			const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
			
			if (value && !emailPattern.test(value)) {
				input.classList.add('border-red-300', 'ring-2', 'ring-red-200');
				input.classList.remove('border-gray-300');
				errorDiv.textContent = 'Sila masukkan alamat emel yang sah (contoh: nama@email.com).';
				errorDiv.classList.remove('hidden');
				return false;
			} else if (value && value.length > 255) {
				input.classList.add('border-red-300', 'ring-2', 'ring-red-200');
				input.classList.remove('border-gray-300');
				errorDiv.textContent = 'Emel tidak boleh melebihi 255 aksara.';
				errorDiv.classList.remove('hidden');
				return false;
			} else {
				input.classList.remove('border-red-300', 'ring-2', 'ring-red-200');
				input.classList.add('border-gray-300');
				errorDiv.classList.add('hidden');
				return true;
			}
		}

		// Image preview functionality
		document.getElementById('image_path').addEventListener('change', function(e) {
			const container = document.getElementById('image-preview-container');
			container.innerHTML = '';
			
			if (this.files && this.files.length > 0) {
				Array.from(this.files).forEach((file, index) => {
					if (file.type.startsWith('image/')) {
						const reader = new FileReader();
						reader.onload = function(e) {
							const div = document.createElement('div');
							div.className = 'relative group';
							div.innerHTML = `
								<img src="${e.target.result}" alt="Preview ${index + 1}" class="w-full h-24 object-cover rounded-md border border-gray-300">
								<div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-opacity rounded-md flex items-center justify-center">
									<span class="text-white text-xs opacity-0 group-hover:opacity-100">Gambar ${index + 1}</span>
								</div>
							`;
							container.appendChild(div);
						};
						reader.readAsDataURL(file);
					}
				});
			}
		});

		// Form submission validation
		document.getElementById('complaintForm').addEventListener('submit', function(e) {
			const name = document.getElementById('name');
			const phone = document.getElementById('phone_number');
			const email = document.getElementById('email');
			const address = document.getElementById('address');
			const description = document.getElementById('description');
			const adminComment = document.getElementById('admin_comment');
			
			let isValid = true;
			
			// Validate all fields
			if (!validateName(name)) isValid = false;
			if (!validatePhone(phone)) isValid = false;
			if (!validateEmail(email)) isValid = false;
			if (!validateAddress(address)) isValid = false;
			
			// Check max lengths
			if (email.value.length > 255) {
				email.classList.add('border-red-300', 'ring-2', 'ring-red-200');
				const errorDiv = document.getElementById('email-error');
				errorDiv.textContent = 'Emel tidak boleh melebihi 255 aksara.';
				errorDiv.classList.remove('hidden');
				isValid = false;
			}
			
			if (address.value.length > 200) {
				address.classList.add('border-red-300', 'ring-2', 'ring-red-200');
				const errorDiv = document.getElementById('address-error');
				errorDiv.textContent = 'Alamat tidak boleh melebihi 200 aksara.';
				errorDiv.classList.remove('hidden');
				isValid = false;
			}
			
			if (description.value.length > 500) {
				description.classList.add('border-red-300', 'ring-2', 'ring-red-200');
				const errorDiv = document.getElementById('description-error');
				errorDiv.textContent = 'Penerangan tidak boleh melebihi 500 aksara.';
				errorDiv.classList.remove('hidden');
				isValid = false;
			}
			
			if (adminComment.value.length > 500) {
				adminComment.classList.add('border-red-300', 'ring-2', 'ring-red-200');
				const errorDiv = document.getElementById('admin_comment-error');
				errorDiv.textContent = 'Komen admin tidak boleh melebihi 500 aksara.';
				errorDiv.classList.remove('hidden');
				isValid = false;
			}
			
			if (!isValid) {
				e.preventDefault();
				// Scroll to first error
				const firstError = document.querySelector('.border-red-300');
				if (firstError) {
					firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
					firstError.focus();
				}
			}
		});

		// Ensure delete checkboxes are always clickable
		document.addEventListener('DOMContentLoaded', function() {
			// Find all delete checkboxes
			const deleteCheckboxes = document.querySelectorAll('input[name="remove_images[]"]');
			
			deleteCheckboxes.forEach(function(checkbox) {
				// Make sure checkbox and its label are always on top
				const label = checkbox.closest('label');
				if (label) {
					label.style.zIndex = '9999';
					label.style.position = 'relative';
					
					// Prevent any parent click handlers from interfering
					label.addEventListener('click', function(e) {
						e.stopPropagation();
						e.preventDefault();
						checkbox.checked = !checkbox.checked;
					});
					
					checkbox.addEventListener('click', function(e) {
						e.stopPropagation();
						e.cancelBubble = true;
					});
				}
			});
			
			// Prevent preview links from blocking checkbox clicks
			const previewLinks = document.querySelectorAll('a[target="_blank"]');
			previewLinks.forEach(function(link) {
				link.addEventListener('click', function(e) {
					// If click is on or near a delete checkbox, don't open preview
					const deleteBtn = e.target.closest('.z-50');
					if (deleteBtn) {
						e.preventDefault();
						e.stopPropagation();
						return false;
					}
				});
			});
		});

		// Prevent double submission
		preventDoubleSubmit('complaintForm', 'Mengemaskini Aduan...');
	</script>
	@endpush
@endsection

