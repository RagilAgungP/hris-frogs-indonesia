<meta name="csrf-token" content="{{ csrf_token() }}">
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Dashboard')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body 

    class="flex min-h-screen"
    style="
        background: linear-gradient(to bottom, white, #3DB5FF);
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
    "
>


    {{-- Sidebar --}}
    @include('components.sidebar')

    {{-- Main Area --}}
    <div class="flex-1 flex flex-col ml-64">

        {{-- Navbar --}}
        @include('components.navbar')

        {{-- Page Content --}}
        <main class="flex-1 p-6">
            @yield('content')
        </main>

    </div>
<style>
[x-cloak] { display: none !important; }
</style>
</body>
</html>