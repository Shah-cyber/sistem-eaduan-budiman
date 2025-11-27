<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ config('app.name', 'e-Aduan Budiman') }} — Sistem e-Aduan</title>
	
	<!-- Favicon -->
	<link rel="icon" type="image/png" href="{{ asset('images/logoKgBudiman.png') }}">
	<link rel="shortcut icon" type="image/png" href="{{ asset('images/logoKgBudiman.png') }}">
	<link rel="apple-touch-icon" href="{{ asset('images/logoKgBudiman.png') }}">
	
	<!-- Fonts & Icons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
	
	@vite(['resources/css/app.css', 'resources/js/app.js'])
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="{{ asset('js/prevent-double-submit.js') }}"></script>
	
	<style>
		body {
			font-family: 'Poppins', sans-serif;
		}
		[x-cloak] { display: none !important; }
	</style>
</head>
<body class="bg-gray-50 text-gray-900">
	<main class="min-h-screen">
		@yield('content')
	</main>
	@stack('scripts')
</body>
</html>

