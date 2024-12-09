<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/css/app.css')
</head>
<body>
    <div class="absolute mt-5">
        <span class="text-3xl font-bold italic text-[#555555] ml-5 mt-5 ">Single Sign On</span>
    </div>

    <div class="flex justify-center items-center min-h-screen">
        <div class="basis-1/3">
            @yield('content')
        </div>
    </div>
    

</body>
</html>