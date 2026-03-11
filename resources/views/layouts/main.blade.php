<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('assets/images/logo.jpg') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- all css imported in main.css --}}
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <title>ATZ Madagascar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- @stack('styles') --}}
</head>


<body class="">

    <!-- Navbar -->
    <x-nav />

    <!-- Contenu -->
    <main class="flex-grow">
        @yield('content')
    </main>


    <!-- Footer -->
    <x-footer />


    {{-- @stack('scripts') --}}
    <script src="https://kit.fontawesome.com/VOTRE_CODE_KIT.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>



</html>
