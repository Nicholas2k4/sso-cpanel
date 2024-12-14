@extends('layouts.base')

@section('style')
    <style>
        h1 {
            font-family: 'Poppins', sans-serif;
        }
    </style>
@endsection

@section('body')
    @livewire('team-cards')
@endsection
