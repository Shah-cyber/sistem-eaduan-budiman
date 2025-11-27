<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ config('app.name', 'e-Aduan Budiman') }} — Admin</title>
	<link rel="icon" type="image/png" href="{{ asset('images/logoKgBudiman.png') }}">
	@vite(['resources/css/app.css', 'resources/js/app.js'])
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.46.0/dist/apexcharts.min.js"></script>
	<script src="{{ asset('js/prevent-double-submit.js') }}"></script>
</head>
<body class="bg-gray-50 text-gray-900">
	@php($user = auth()->user())
	@if($user && method_exists($user, 'hasRole') && $user->hasRole('Super Admin'))
		<x-admin.sidebar />
	@else
		<x-admin.panel-sidebar />
	@endif
	<div class="lg:ml-64">
		<x-admin.header />
		<main class="mx-auto max-w-7xl p-6">
			@yield('content')
		</main>
	</div>
	@stack('scripts')
</body>
</html>
