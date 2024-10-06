<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>@yield('title', 'My Laravel App')</title>

        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('bootstrap-icons-1.11.3/font/bootstrap-icons.css') }}">

        @vite([
            'resources/css/app.css',
            'resources/js/app.js'
        ])

        @stack('styles')
    </head>
    <body>
        <div class="container">
            @yield('content')
        </div>

        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
        @stack('scripts')
    </body>
</html>
