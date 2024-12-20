@extends('layouts.base')

@section('style')
    <style>
        h1 {
            font-family: 'Poppins', sans-serif;
        }

        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        ::-webkit-scrollbar-corner {
            background: #f1f1f1;
        }
    </style>
@endsection

@section('body')
    <div class="p-8 pe-8 xl:pe-24">
        <h1 class="text-4xl font-bold mb-5">Resources</h1>
        @livewire('resource-table')
    </div>
@endsection

@section('script')
    <script></script>
@endsection
