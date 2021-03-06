<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>App</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
    <!-- {{ asset('js/app.js') }} -->
    <div id="app"></div>
    <script>
        var BASE_URL = '{{URL::to('/')}}';
    </script>
    <script src="{{ asset('js/app.js') }}?{{time()}}"></script>
    </body>
</html>
