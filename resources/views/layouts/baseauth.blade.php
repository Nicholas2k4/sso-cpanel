<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- JQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    {{-- Sweet Alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Font Awesome CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    {{-- Fonts --}}
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <style>
        body {
            font-family: 'Inter';
        }
    </style>

</head>
<body>
    @include('components.alerts')
    <div class="absolute mt-3">
        <img src="{{ asset('assets/logo.png') }}" alt="logo" class="w-[100px] md:w-[130px] object-cover ml-5">
    </div>

    <div class="flex justify-center items-center min-h-screen">
        <div class="basis-4/6 md:basis-1/3 lg:basis-1/3">
            @yield('content')
        </div>
    </div>


</body>
</html>
