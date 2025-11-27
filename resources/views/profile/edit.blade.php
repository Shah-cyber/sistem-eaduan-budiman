@extends('layouts.admin')

@section('content')
	<div class="mb-8">
		<div>
			<h1 class="text-3xl font-bold text-gray-900 mb-2">Profil Saya</h1>
			<p class="text-sm text-gray-600">Urus maklumat profil, kata laluan, dan tetapan akaun anda</p>
		</div>
	</div>

	<div class="space-y-6">
		{{-- Profile Information --}}
		<div class="rounded-2xl border border-gray-200 bg-white shadow-lg overflow-hidden">
			@include('profile.partials.update-profile-information-form')
		</div>

		{{-- Update Password --}}
		<div class="rounded-2xl border border-gray-200 bg-white shadow-lg overflow-hidden">
			@include('profile.partials.update-password-form')
		</div>

		{{-- Delete Account --}}
		<div class="rounded-2xl border-2 border-red-200 bg-gradient-to-br from-red-50 to-white shadow-lg overflow-hidden">
			@include('profile.partials.delete-user-form')
		</div>
	</div>

	@push('scripts')
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<script>
			// Profile updated successfully
			@if (session('status') === 'profile-updated')
				Swal.fire({
					icon: 'success',
					title: 'Berjaya!',
					text: 'Maklumat profil anda telah dikemaskini.',
					confirmButtonColor: '#132A13',
					timer: 3000,
					timerProgressBar: true
				});
			@endif

			// Password updated successfully
			@if (session('status') === 'password-updated')
				Swal.fire({
					icon: 'success',
					title: 'Berjaya!',
					text: 'Kata laluan anda telah dikemaskini.',
					confirmButtonColor: '#132A13',
					timer: 3000,
					timerProgressBar: true
				});
			@endif

			// Verification link sent
			@if (session('status') === 'verification-link-sent')
				Swal.fire({
					icon: 'info',
					title: 'Emel Dihantar',
					text: 'Pautan pengesahan baharu telah dihantar ke alamat emel anda.',
					confirmButtonColor: '#132A13',
					timer: 4000,
					timerProgressBar: true
				});
			@endif

			// Show errors if any
			@if ($errors->any())
				@if ($errors->has('name') || $errors->has('email') || $errors->has('phone_number') || $errors->has('profile_picture'))
					Swal.fire({
						icon: 'error',
						title: 'Ralat!',
						html: '<div class="text-left">' +
							'@foreach ($errors->all() as $error)' +
							'<p class="text-sm mb-1">• {{ $error }}</p>' +
							'@endforeach' +
							'</div>',
						confirmButtonColor: '#dc2626'
					});
				@elseif ($errors->updatePassword->any())
					Swal.fire({
						icon: 'error',
						title: 'Ralat Kata Laluan!',
						html: '<div class="text-left">' +
							'@foreach ($errors->updatePassword->all() as $error)' +
							'<p class="text-sm mb-1">• {{ $error }}</p>' +
							'@endforeach' +
							'</div>',
						confirmButtonColor: '#dc2626'
					});
				@endif
			@endif
		</script>
	@endpush
@endsection
