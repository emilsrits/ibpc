<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<title>@yield('title')</title>

	<!-- Styles -->
	<link rel="stylesheet" href="{{ URL::to('/css/font-awesome.min.css') }}">
	@stack('styles')
	<link rel="stylesheet" href="{{ URL::to('/css/app.css') }}">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
	@yield('styles')

	<!-- Scripts Head -->
    <script>
        window.Laravel = @php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); @endphp
    </script>
</head>
<body>
	<div id="app">
        @yield('modal')
		@include('_partials.header')

		<main>
			@yield('content')
		</main>

		@include('_partials.footer')
	</div>

	<!-- Scripts Body -->
	@stack('scripts')
	<script src="{{ mix('/js/app.js') }}"></script>
	@yield('scripts')
</body>
</html>