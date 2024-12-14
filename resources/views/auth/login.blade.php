@extends('layouts.baseauth')

@section('content')
<form action="{{ route('signin.post') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <h1 class="font-bold text-center mb-5 text-[#555555] text-2xl md:text-3xl">Welcome Back</h1>
    <x-input label="Email address" name="email" type="email" placeholder="example@gmail.com"></x-input>
    <x-input label="Password" name="password" type="password" placeholder="Enter your password"></x-input>
    <a href="{{ route('user.auth') }}" class="px-9 py-2 lg:h-[3.5rem] h-[2.5rem] text-xs lg:text-base w-full flex border border-[#555555] items-center justify-center mb-4 rounded-md hover:bg-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-500">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 488 512" class=" w-3 lg:w-5 mr-3"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z"/></svg>
        <span class="font-semibold text-[#555555]">Sign In with Google</span>
    </a>    
    <x-button type="submit" color="[#4587F3]" class=" w-full ">Continue</x-button>
    <p class="text-center mt-3 font-semibold text-[10px] lg:text-sm text-[#555555]">
        Don't have an account?
        <a href="/signup" class="text-[#4285F4] hover:text-[#7FAAEF] underline">Sign Up</a>
    </p>
</form>
@endsection