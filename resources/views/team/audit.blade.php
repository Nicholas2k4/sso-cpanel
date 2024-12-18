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
        <h1 class="text-4xl font-bold mb-5">{{ $team->name }}</h1>

        <div class="flex gap-x-3 mb-8">
            <a
                href="{{ route('teams.resource', $team->id) }}" class="rounded-lg bg-[#DFE3F9] border-2 border-[#4D75E2] font-bold text-[#4D75E2] px-5 py-2 hover:bg-[#4D75E2] hover:text-white transition-all duration-150">Resource</a>
            <a
                href="{{ route('teams.member', $team->id) }}" class="rounded-lg bg-[#DFE3F9] border-2 border-[#4D75E2] font-bold text-[#4D75E2] px-5 py-2 hover:bg-[#4D75E2] hover:text-white transition-all duration-150">Member</a>
            <a
                href="{{ route('teams.audit', $team->id) }}" class="rounded-lg border-2 border-[#4D75E2] font-bold px-5 py-2 bg-[#4D75E2] transition-all duration-150 text-white hover:bg-blue-700 hover:border-blue-700">Audit
                Log</a>
        </div>

        <h1>Audit</h1>
    </div>
@endsection

@section('script')
    <script></script>
@endsection
