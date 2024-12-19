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
            <button onclick="openModal()"
                class="ms-0 md:ms-auto bg-blue-500 text-white font-bold rounded-lg shadow px-5 py-2 flex items-center justify-center">+
                Add Member</button>
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
                        Role
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @if ($members->count() == 0)
                    <tr>
                        <td colspan="4" class="text-center font-bold text-2xl py-12">No member available</td>
                    </tr>
                @endif
                @foreach ($members as $member)
                    <tr class="odd:bg-[#E6F3FD] even:bg-white text-center">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            {{ ($members->currentPage() - 1) * $members->perPage() + $loop->iteration }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $member->user->display_name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $member->role }}
                        </td>
                        <td class="px-6 py-4 flex items-center justify-center gap-x-2">
                            @if (
                                $member->role == 'member' &&
                                    (auth()->user()->groupRole($teamId) == 'manager' ||
                                        auth()->user()->groupRole($teamId) == 'leader' ||
                                        auth()->user()->global_role == 'admin'))
                                <button
                                    class="font-medium bg-green-400 hover:bg-green-500 transition-all duration-200 px-4 py-2 rounded-lg shadow"
                                    onclick="promote({{ $member->id }})">Promote</button>
                            @endif
                            @if (
                                $member->role == 'manager' &&
                                    (auth()->user()->groupRole($teamId) == 'leader' || auth()->user()->global_role == 'admin'))
                                <button
                                    class="font-medium bg-yellow-400 hover:bg-yellow-500 transition-all duration-200 px-4 py-2 rounded-lg shadow"
                                    onclick="demote({{ $member->id }})">Demote</button>
                            @endif
                            @if (
                                $member->role != 'leader' &&
                                    ((auth()->user()->groupRole($teamId) == 'leader' && $member->role == 'manager') ||
                                        (auth()->user()->groupRole($teamId) == 'manager' && $member->role == 'member') ||
                                        (auth()->user()->groupRole($teamId) == 'leader' && $member->role == 'member') ||
                                        auth()->user()->global_role == 'admin'))
                                <button
                                    class="font-medium bg-red-400 hover:bg-red-500 transition-all duration-200 px-4 py-2 rounded-lg shadow"
                                    onclick="kick({{ $member->id }})">Kick</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-3">
        {{ $members->links() }}
    </div>

    {{-- Modal --}}
    <div id="modal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-lg w-10/12 md:w-8/12 lg:w-1/2 p-6">
            {{-- Header --}}
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Add Team Member</h2>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">&times;</button>
            </div>

            {{-- Body --}}
            <div class="space-y-4">
                {{-- Dropdown --}}
                <div>
                    <label for="user" class="block text-sm font-medium text-gray-700">User</label>
                    <select id="user"
                        class="w-full mt-2 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2 text-gray-700">
                        <option value="" disabled selected class="text-gray-500">Select a member...</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->email }} - {{ $user->display_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Footer --}}
            <div class="flex flex-col md:flex-row justify-end mt-6 md:space-x-4">
                <button onclick="closeModal()" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                    Cancel
                </button>
                <button class="bg-blue-500 text-white px-4 py-2 rounded mt-3 md:mt-0 hover:bg-blue-600"
                    onclick="addMember()">
                    Add Member
                </button>
            </div>
        </div>
    </div>

    {{-- Script --}}
    <script>
        function promote(id) {
            Swal.fire({
                title: 'Promote this user?',
                text: "This action cannot be reverted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2C854D',
                cancelButtonColor: '#888',
                confirmButtonText: 'Promote',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('promote') }}",
                        method: "POST",
                        data: {
                            teamId: {{ $teamId }},
                            memberId: id
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                timer: 1500,
                                timerProgressBar: true,
                                showConfirmButton: false,
                            }).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: xhr.responseJSON.message,
                                timer: 1500,
                                showConfirmButton: false,
                            })
                        }
                    });
                }
            });
        }

        function demote(id) {
            Swal.fire({
                title: 'Demote this user?',
                text: "This action cannot be reverted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#FACC15',
                cancelButtonColor: '#888',
                confirmButtonText: 'Demote',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('demote') }}",
                        method: "POST",
                        data: {
                            teamId: {{ $teamId }},
                            memberId: id
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                timer: 1500,
                                timerProgressBar: true,
                                showConfirmButton: false,
                            }).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: xhr.responseJSON.message,
                                timer: 1500,
                                showConfirmButton: false,
                            })
                        }
                    });
                }
            });
        }

        function kick(id) {
            Swal.fire({
                title: 'Kick this user?',
                text: "This action cannot be reverted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#F87171',
                cancelButtonColor: '#888',
                confirmButtonText: 'Kick',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('kick') }}",
                        method: "POST",
                        data: {
                            teamId: {{ $teamId }},
                            memberId: id
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                timer: 1500,
                                timerProgressBar: true,
                                showConfirmButton: false,
                            }).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: xhr.responseJSON.message,
                                timer: 1500,
                                showConfirmButton: false,
                            })
                        }
                    });
                }
            });
        }

        function openModal() {
            document.getElementById('modal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }

        function addMember() {
            const userId = $('#user').val();
            if (!userId) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: "Please select a user!",
                    timer: 1500,
                    timerProgressBar: true,
                    showConfirmButton: false,
                });
            } else {
                $.ajax({
                    url: "{{ route('addMember') }}",
                    method: 'POST',
                    data: {
                        userId: userId,
                        teamId: {{ $teamId }},
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                            timer: 1500,
                            timerProgressBar: true,
                            showConfirmButton: false,
                        }).then(() => {
                            window.location.reload();
                        });
                        closeModal();
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: xhr.responseJSON.message,
                            timer: 1500,
                            showConfirmButton: false,
                        })
                        closeModal();
                    }
                });
            }
        }
    </script>
</div>
