@extends('layouts.base')

@section('body')
    <div class="container p-8 pe-8 pb-0 xl:pe-24">
        <h1 class="text-4xl font-bold mb-8">Create Team</h1>

        <div class="border-[5px] border-b-0 rounded-t-[40px] border-[#4285F4] p-14 pb-9 pt-12">
            <form action="{{ route('teams.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label text-[#4285F4] text-[12px] lg:text-sm font-semibold">Team Name</label>
                    <input type="text" name="name" id="name" class="form-control w-full px-4 py-2 text-[#4285F4] h-[1.5rem] text-[9px] md:text-xs md:h-[2.5rem] placeholder-[#90C0E9] border border-[#90C0E9] rounded-md focus:ring-2 focus:ring-[#90C0E9] focus:outline-none focus:border-[#90C0E9]" required>
                </div>

                <div class="mb-3">
                    <label for="leader_user_id" class="form-label text-[#4285F4] text-[12px] lg:text-sm font-semibold mb-2">Team Leader</label>
                    <select id="leader_user_id" name="leader_user_id" class="w-full px-4 py-2 text-[#4285F4] h-[1.5rem] text-[9px] md:text-xs md:h-[2.5rem] placeholder-[#90C0E9] border border-[#90C0E9] rounded-md focus:ring-2 focus:ring-[#90C0E9] focus:outline-none focus:border-[#90C0E9]" required">
                        <option value="" disabled selected>Select Team Leader</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->display_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="logo" class="form-label text-[#4285F4] text-[12px] lg:text-sm font-semibold">Team Picture</label>
                    <input type="file" name="logo" id="logo" class="form-control w-full px-4 py-2 text-[#4285F4] h-[1.5rem] text-[9px] md:text-xs md:h-[2.5rem] bg-white placeholder-[#90C0E9] border border-[#90C0E9] rounded-md focus:ring-2 focus:ring-[#90C0E9] focus:outline-none focus:border-[#90C0E9]" accept="image/*" required>
                    <p class="italic text-slate-500 text-sm">Please upload square image, size less than 100KB</p>
                </div>

                <button type="submit" class="px-4 py-2 md:h-[2.5rem] h-[1.5rem] text-xs md:text-base rounded-md font-semibold text-white bg-[#4587F3] hover:bg-[#639AF4] focus:outline-none focus:ring-2 focus:ring-[#468CFF]">Create</button>
                <a href="/teams" class="ml-5">Cancel</a>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#leader_user_id').select2({
                placeholder: 'Select Team Leader',
                allowClear: true, 
                ajax: {
                    url: '/api/users', 
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
                                    id: user.id,
                                    text: user.display_name
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
