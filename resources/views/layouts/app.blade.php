<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'NexaMarket')</title>

    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f8fafc;
            color: #333;
            min-height: 100vh;
        }

        main {
            min-height: 80vh;
        }
    </style>

    <!-- CSS tambahan setiap halaman -->
    @stack('styles')
</head>

<body>

    <!-- Header utama NexaMarket -->
    @include('partials.header')

    <!-- Konten halaman -->
    <main>
        @yield('content')
    </main>

    <!-- JavaScript tambahan -->
    @stack('scripts')

</body>
</html>