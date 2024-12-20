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
                href="{{ route('teams.resource', $team->id) }}"
                class="rounded-lg border-2 border-[#4D75E2] font-bold px-5 py-2 bg-[#4D75E2] transition-all duration-150 text-white hover:bg-blue-700 hover:border-blue-700"
            >Resource</a>
            <a
                href="{{ route('teams.member', $team->id) }}"
                class="rounded-lg bg-[#DFE3F9] border-2 border-[#4D75E2] font-bold text-[#4D75E2] px-5 py-2 hover:bg-[#4D75E2] hover:text-white transition-all duration-150"
            >Member</a>
            <a
                href="{{ route('teams.audit', $team->id) }}"
                class="rounded-lg bg-[#DFE3F9] border-2 border-[#4D75E2] font-bold text-[#4D75E2] px-5 py-2 hover:bg-[#4D75E2] hover:text-white transition-all duration-150"
            >Audit
                Log</a>
        </div>

        {{-- <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse ($resources as $resource)
                @if ($resource->resource->type == 'cpanel')
                    <x-resource-card.cpanel :resource="$resource" />
                @endif
            @empty
                <div class="text-center col-span-3">
                    <p class="text-gray-700 text-xl">No resources assigned to your team. Contact your admin.</p>
                </div>
            @endforelse
        </div>

        {{ $resources->links() }} --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 max-w-[1200px]">
            {{-- @foreach ($resources as $resource) --}}
                <div class="flex flex-col min-h-[170px] max-w-[400px] bg-[#F7F6FA] rounded-lg overflow-hidden">
                    <div class="flex p-5 gap-x-4">
                        <div class="w-auto">
                            <h2 class="font-bold text-lg mb-1">{{-- $resource->name --}}Cpanel</h2>
                            <p class="text-sm text-gray-500">{{-- $team->leader->display_name --}} Type: abc</p>
                        </div>
                    </div>
                    <hr class="mt-auto">
                    <a href="{{-- route('teams.resource', $team->id) --}}"
                        class="bg-blue-100 w-full h-[40px] flex items-center justify-center transition-all duration-200 hover:bg-blue-500 hover:text-white">Detail</a>
                </div>
            {{-- @endforeach --}}
        </div>

        {{-- Pagination --}}
        {{-- <div class="mt-3">
            {{ $resource->links() }}
        </div> --}}
    </div>
@endsection

@section('script')
    <script></script>
@endsection
