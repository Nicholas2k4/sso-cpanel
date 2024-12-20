<div>
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row mb-6 gap-x-10 max-w-[1200px] flex-wrap gap-y-4">
        {{-- Entries --}}
        <div class="flex flex-row items-center gap-x-2">
            <p>Show</p>
            <select name="entries-count" class="bg-gray-100 rounded-lg px-2 py-2" wire:model.live="entries">
                <option value="5">5</option>
                <option value="10" selected>10</option>
                <option value="15">15</option>
                <option value="20">20</option>
            </select>
            <p>entries</p>
        </div>

        {{-- Search --}}
        <div class="flex flex-row items-center border border-gray-300 rounded-lg px-3 py-2">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input wire:model.live="search" type="text"
                class="appearance-none bg-transparent border-none outline-none focus:ring-0 focus:outline-none ms-3 w-36"
                placeholder="Search..." id="search">
        </div>

        {{-- Add Members --}}
        @if (auth()->user()->global_role == 'admin' ||
                auth()->user()->groupRole($teamId) == 'leader' ||
                auth()->user()->groupRole($teamId) == 'manager')
            <a href="{{ route('resource.create', 'cpanel') }}"
                class="ms-0 md:ms-auto bg-blue-500 text-white font-bold rounded-lg shadow px-5 py-2 flex items-center justify-center">+
                Add Resource</a>
        @endif
    </div>

    {{-- Tables --}}
    <div class="overflow-x-auto rounded-lg z-0">
        <table class="w-full text-sm text-left rtl:text-right">
            <thead class="text-xs text-gray-700 uppercase text-center">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        #
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Type
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @if ($resources->count() == 0)
                    <tr>
                        <td colspan="4" class="text-center font-bold text-2xl py-12">No resources available</td>
                    </tr>
                @endif
                @foreach ($resources as $resource)
                    <tr class="odd:bg-[#E6F3FD] even:bg-white text-center">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            {{ ($resources->currentPage() - 1) * $resources->perPage() + $loop->iteration }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $resource->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $resource->type }}
                        </td>
                        <td class="px-6 py-4 flex items-center justify-center gap-x-2">
                            <a href="{{ route('resource.delete', $resource->id) }}"
                                class="font-medium bg-red-400 hover:bg-red-500 transition-all duration-200 px-4 py-2 rounded-lg shadow">Action</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-3">
        {{ $resources->links() }}
    </div>
</div>
