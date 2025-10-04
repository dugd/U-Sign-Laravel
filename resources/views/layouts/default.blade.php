<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'USign')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <x-navigation/>

    <main>
        @yield('content')
    </main>

    <script src="/js/app.js"></script>
    @stack('scripts')
</body>
</html>
