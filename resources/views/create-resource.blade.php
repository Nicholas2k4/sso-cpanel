@extends('layouts.base')

@section('body')
    <div class="container p-8 pe-8 pb-0 xl:pe-24">
        <h1 class="text-4xl font-bold mb-8">Create Resources</h1>

        <form action="#" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="type" class="form-label text-[#4285F4] text-[12px] lg:text-sm font-semibold mb-2">Type:</label>
            <select id="type" name="type" class=" w-44 px-4 py-2 text-[#4285F4] h-[1.5rem] text-[9px] md:text-xs md:h-[2.5rem] placeholder-[#90C0E9] border border-[#90C0E9] rounded-md focus:ring-2 focus:ring-[#90C0E9] focus:outline-none focus:border-[#90C0E9]" required">
                <option value="" disabled selected>Select Type</option>
                {{-- @foreach ($resources as $resource)
                    <option value="{{ $resource->id }}">{{ $user->type }}</option>
                @endforeach --}}
                <option value="1">cPanel</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label text-[#4285F4] text-[12px] lg:text-sm font-semibold">Resource Name</label>
            <input type="text" name="name" id="name" class="form-control w-full px-4 py-2 text-[#4285F4] h-[1.5rem] text-[9px] md:text-xs md:h-[2.5rem] placeholder-[#90C0E9] border border-[#90C0E9] rounded-md focus:ring-2 focus:ring-[#90C0E9] focus:outline-none focus:border-[#90C0E9]" required>
        </div>

        <div class="mb-3">
            <label for="whmurl" class="form-label text-[#4285F4] text-[12px] lg:text-sm font-semibold">whmURL</label>
            <input type="text" name="whmurl" id="whmurl" class="form-control w-full px-4 py-2 text-[#4285F4] h-[1.5rem] text-[9px] md:text-xs md:h-[2.5rem] placeholder-[#90C0E9] border border-[#90C0E9] rounded-md focus:ring-2 focus:ring-[#90C0E9] focus:outline-none focus:border-[#90C0E9]" required>
        </div>

        <div class="mb-3">
            <label for="whmauth" class="form-label text-[#4285F4] text-[12px] lg:text-sm font-semibold">whmAuth</label>
            <input type="text" name="whmauth" id="whmauth" class="form-control w-full px-4 py-2 text-[#4285F4] h-[1.5rem] text-[9px] md:text-xs md:h-[2.5rem] placeholder-[#90C0E9] border border-[#90C0E9] rounded-md focus:ring-2 focus:ring-[#90C0E9] focus:outline-none focus:border-[#90C0E9]" required>
        </div>    

        <div class="mb-3">
            <label for="teams" class="form-label text-[#4285F4] text-[12px] lg:text-sm font-semibold mb-2">Associated Teams</label>
            <select id="teams" name="teams" class="w-full px-4 py-2 text-[#4285F4] h-[1.5rem] text-[9px] md:text-xs md:h-[2.5rem] placeholder-[#90C0E9] border border-[#90C0E9] rounded-md focus:ring-2 focus:ring-[#90C0E9] focus:outline-none focus:border-[#90C0E9]" required>
                <option value="" disabled selected>Select Team</option>
                {{-- @foreach ($teams as $team)
                    <option value="{{ $team->id }}">{{ $team->display_name }}</option>
                @endforeach --}}
                <option value="1">Team 1</option>
            </select>
        </div>

        <button type="submit" class="px-4 py-2 md:h-[2.5rem] h-[1.5rem] text-xs md:text-base rounded-md font-semibold text-white bg-[#4587F3] hover:bg-[#639AF4] focus:outline-none focus:ring-2 focus:ring-[#468CFF]">Create</button>
        </form>
    </div>
    <script>
        $(document).ready(function () {
            $('#teams').select2({
                placeholder: 'Select Team',
                allowClear: true, 
                ajax: {
                    url: '/api/teams', 
                    dataType: 'json', 
                    delay: 250, 
                    data: function (params) {
                        return {
                            search: params.term, 
                            limit: 10
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.map(function (user) {
                                return {
                                    id: team.id,
                                    text: team.name
                                };
                            })
                        };
                    }
                },
                minimumInputLength: 1
            });
        });
    </script>    
@endsection
