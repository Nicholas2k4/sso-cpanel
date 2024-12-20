@extends('layouts.base')

@section('body')
    <div class="container p-8 pe-8 pb-0 xl:pe-24">
        <h1 class="text-4xl font-bold mb-8">Create Resources</h1>

        <form action="{{ route('resource.store', 'cpanel') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label text-[#4285F4] text-[12px] lg:text-sm font-semibold">Resource
                    Name</label>
                <input type="text" name="name" id="name"
                    class="form-control w-full px-4 py-2 text-[#4285F4] h-[1.5rem] text-[9px] md:text-xs md:h-[2.5rem] placeholder-[#90C0E9] border border-[#90C0E9] rounded-md focus:ring-2 focus:ring-[#90C0E9] focus:outline-none focus:border-[#90C0E9]"
                    required>
            </div>

            <div class="mb-3">
                <label for="whmurl" class="form-label text-[#4285F4] text-[12px] lg:text-sm font-semibold">whmURL</label>
                <input type="text" name="whmUrl" id="whmurl"
                    class="form-control w-full px-4 py-2 text-[#4285F4] h-[1.5rem] text-[9px] md:text-xs md:h-[2.5rem] placeholder-[#90C0E9] border border-[#90C0E9] rounded-md focus:ring-2 focus:ring-[#90C0E9] focus:outline-none focus:border-[#90C0E9]"
                    required>
            </div>

            <div class="mb-3">
                <label for="whmauth" class="form-label text-[#4285F4] text-[12px] lg:text-sm font-semibold">whmAuth</label>
                <input type="text" name="whmAuth" id="whmauth"
                    class="form-control w-full px-4 py-2 text-[#4285F4] h-[1.5rem] text-[9px] md:text-xs md:h-[2.5rem] placeholder-[#90C0E9] border border-[#90C0E9] rounded-md focus:ring-2 focus:ring-[#90C0E9] focus:outline-none focus:border-[#90C0E9]"
                    required>
            </div>

            <div class="mb-3">
                <label for="whmauth" class="form-label text-[#4285F4] text-[12px] lg:text-sm font-semibold">cpanel User</label>
                <input type="text" name="cpanelUser" id="whmauth"
                    class="form-control w-full px-4 py-2 text-[#4285F4] h-[1.5rem] text-[9px] md:text-xs md:h-[2.5rem] placeholder-[#90C0E9] border border-[#90C0E9] rounded-md focus:ring-2 focus:ring-[#90C0E9] focus:outline-none focus:border-[#90C0E9]"
                    required>
            </div>

            <div class="mb-3">
                <label for="teams" class="form-label text-[#4285F4] text-[12px] lg:text-sm font-semibold mb-2">Associated
                    Teams</label>
                <select id="teams" name="team_id"
                    class="w-full px-4 py-2 text-[#4285F4] h-[1.5rem] text-[9px] md:text-xs md:h-[2.5rem] placeholder-[#90C0E9] border border-[#90C0E9] rounded-md focus:ring-2 focus:ring-[#90C0E9] focus:outline-none focus:border-[#90C0E9]"
                    required>
                    <option value="" disabled selected>Select Team</option>
                    @foreach ($teams as $team)
                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit"
                class="px-4 py-2 md:h-[2.5rem] h-[1.5rem] text-xs md:text-base rounded-md font-semibold text-white bg-[#4587F3] hover:bg-[#639AF4] focus:outline-none focus:ring-2 focus:ring-[#468CFF]">Create</button>
        </form>
    </div>
@endsection
