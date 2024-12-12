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
    <div class="absolute mt-5">
        <span class=" text-md lg:text-3xl font-bold italic text-[#555555] ml-5 mt-5 ">Single Sign On</span>
    </div>

    <div class="flex justify-center items-center min-h-screen">
        <div class="lg:basis-1/3">
            @yield('content')
        </div>
    </div>


</body>
</html>
