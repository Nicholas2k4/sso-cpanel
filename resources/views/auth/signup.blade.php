@extends('base.baseauth')

@section('content')
<form action="{{ route('signup.post') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <h1 class="font-bold text-center mb-5 text-[#555555] text-3xl">Create an Account</h1>
    <x-input label="Email address" name="email" type="email" placeholder="example@gmail.com"></x-input>
    <x-input label="Password" name="password_hash" type="password_hash" placeholder="Enter your password"></x-input>
    <x-button type="submit" color="[#4587F3]" class=" w-full ">Continue</x-button>
    <p class="text-center mt-3 font-semibold text-sm text-[#555555]">
        Already have an account?
        <a href="/login" class="text-[#4285F4] hover:text-[#7FAAEF] underline">Sign in</a>
    </p>
</form>
@endsection