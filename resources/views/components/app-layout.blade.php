<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        <header class="bg-white shadow mt-16">
            <div class="px-4 sm:px-6 lg:px-8 py-4">
                {{ $header ?? '' }}
            </div>
        </header>


        <!-- Page Content -->
        <main class="pt-6"> <!-- Pastikan padding cukup untuk menghindari tumpang tindih -->
            {{ $slot }}
        </main>
    </div>
    @stack('scripts') {{-- ⬅️ tambahkan ini di sini --}}
</body>

</html>
