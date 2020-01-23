<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
    <link rel="icon" href="assets/favicon.ico">
    <title>@yield('title', 'TM - Lokaalbezetting')</title>

</head>
<body>
{{--  Navigation  --}}
@include('shared.navigation')

<main class="container mt-3">
    <p>
        @yield('main', 'Page under construction ...')
    </p>
</main>

{{--  Footer  --}}
@include('shared.footer')

<script src="{{ mix('js/app.js') }}"></script>

@yield('script_after')
@if(env('APP_DEBUG'))
    <script>
        $('form').attr('novalidate', 'true');
    </script>
@endif

</body>
</html>
