<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'USign')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col bg-gray-50 text-gray-900">

<x-header/>

<main class="flex-1 container mx-auto px-4 py-8">
    @yield('content')
</main>

<x-footer/>
</body>
</html>
