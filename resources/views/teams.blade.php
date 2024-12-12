@extends('layouts.base')

@section('style')
    <style>
        h1 {
            font-family: 'Poppins', sans-serif;
        }
    </style>
@endsection

@section('body')
    <div class="p-8 pe-8 xl:pe-24">
        <h1 class="text-4xl font-bold mb-8">My Teams</h1>


        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row mb-6 gap-x-10 max-w-[1200px] flex-wrap gap-y-4">
            {{-- Entries --}}
            <div class="flex flex-row items-center gap-x-2">
                <p>Show</p>
                <select name="entries-count" class="bg-gray-100 rounded-lg px-2 py-2">
                    <option value="3">3</option>
                    <option value="6" selected>6</option>
                    <option value="9">9</option>
                    <option value="12">12</option>
                </select>
                <p>entries</p>
            </div>

            {{-- Search --}}
            <div class="flex flex-row items-center border border-gray-300 rounded-lg px-3 py-2">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" class="appearance-none bg-transparent border-none outline-none focus:ring-0 focus:outline-none ms-3 w-36" placeholder="Search...">
            </div>

            {{-- Add Teams --}}
            <a href="" class="ms-0 md:ms-auto bg-blue-500 text-white font-bold rounded-lg shadow px-5 py-2 flex items-center justify-center">+ Add Team</a>
        </div>

        {{-- Card section --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 max-w-[1200px]">
            @for ($counter = 1; $counter <= 12; $counter++)
                <div class="flex flex-col min-h-[170px] max-w-[400px] bg-[#F7F6FA] rounded-lg overflow-hidden">
                    <div class="flex p-5 gap-x-4">
                        <img src="{{ asset('assets/test/test.jpg') }}" alt=""
                            class="object-cover rounded-xl w-[80px] h-[80px]">
                        <div class="w-auto">
                            <h2 class="font-bold text-lg mb-1">Team Name</h2>
                            <p class="text-sm text-gray-500">Leader: Lorem, ipsum dolor.</p>
                        </div>
                    </div>
                    <hr class="mt-auto">
                    <a href="#" class="bg-blue-100 w-full h-[40px] flex items-center justify-center transition-all duration-200 hover:bg-blue-500 hover:text-white">Detail</a>
                </div>
            @endfor
        </div>
    </div>
@endsection
