<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ URL::to('/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ URL::to('/css/magnific-popup.min.css') }}">
    <link rel="stylesheet" href="{{ URL::to('/css/app.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
    @yield('styles')

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <div id="app">
        @yield('modal')
        @include('partials.admin.header')

        <main>
            <div class="container-inner cf">
                @yield('content')
            </div>
        </main>

        @include('partials.footer')
    </div>

<!-- Scripts -->
<script type="text/javascript" src="{{ URL::to('/js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('/js/magnific-popup.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('/js/app.js') }}"></script>
@yield('scripts')
</body>
</html>