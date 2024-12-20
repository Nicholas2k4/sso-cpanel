{{-- Style --}}
<style>
    .ham {
        cursor: pointer;
        -webkit-tap-highlight-color: transparent;
        transition: transform 400ms;
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .hamRotate.active {
        transform: rotate(45deg);
    }

    .hamRotate180.active {
        transform: rotate(180deg);
    }

    .line {
        fill: none;
        transition: stroke-dasharray 400ms, stroke-dashoffset 400ms;
        stroke: #000;
        stroke-width: 5.5;
        stroke-linecap: round;
    }

    .ham8 .top {
        stroke-dasharray: 40 160;
    }

    .ham8 .middle {
        stroke-dasharray: 40 142;
        transform-origin: 50%;
        transition: transform 400ms;
    }

    .ham8 .bottom {
        stroke-dasharray: 40 85;
        transform-origin: 50%;
        transition: transform 400ms, stroke-dashoffset 400ms;
    }

    .ham8.active .top {
        stroke-dashoffset: -64px;
    }

    .ham8.active .middle {
        transform: rotate(90deg);
    }

    .ham8.active .bottom {
        stroke-dashoffset: -64px;
    }

    #smallNav {
        margin-top: -450px;
        transition: all 1s ease;
    }

    #smallNav.active {
        margin-top: 0px;
    }
</style>



{{-- Sidebar --}}
<aside class="w-64 h-screen border-e-2 fixed hidden lg:block">
    <div class="h-[70px] w-screen flex items-center p-3 border-b-2 border-blue-300 bg-white">
        <a href="#" class="ml-12">
            <img src="{{ asset('assets/logo.png') }}" alt="logo" class="w-[110px] object-cover mt-2">
        </a>
        <div class="ml-auto flex align-center justify-center">
            <img src="{{ asset('assets/icons/profile.png') }}" alt="profile_icon"
                class="h-[15px] object-contain my-auto mr-4">
            <div class="flex flex-col my-auto mr-4">
                <h2 class="text-gray-500 text-xs">{{ auth()->user()->global_role }}</h2>
                <p>{{ auth()->user()->display_name }}</p>
            </div>
        </div>
    </div>
    <div class="mx-6 h-screen mt-[-70px] flex flex-col mb-5">
        {{-- Navlist --}}
        <div class="mt-[85px]">
            <ul>
                @if (auth()->user()->global_role == 'admin')
                    <a href="{{ route('teams') }}" class="text-md">
                        <li class="flex flex-row items-center p-2 px-3 my-2 hover:bg-gray-200 rounded-lg transition">
                            <i class="fa-regular fa-file-lines mr-3 text-lg w-[22px]"></i>
                            <span>List Teams</span>
                        </li>
                    </a>
                    <a href="{{ route('resource.list') }}" class="text-md">
                        <li class="flex flex-row items-center p-2 px-3 my-2 hover:bg-gray-200 rounded-lg transition">
                            <i class="fa-solid fa-chart-column mr-3 text-lg w-[22px]"></i>
                            <span>Manage Resources</span>
                        </li>
                    </a>
                @endif
                @if (auth()->user()->global_role == 'user')
                    <a href="{{ route('teams') }}" class="text-md">
                        <li class="flex flex-row items-center p-2 px-3 my-2 hover:bg-gray-200 rounded-lg transition">
                            <i class="fa-solid fa-users-viewfinder mr-3 text-lg w-[22px]"></i>
                            <span>My Teams</span>
                        </li>
                    </a>
                @endif
                <a href="{{ route('teams.create') }}" class="text-md">
                    <li class="flex flex-row items-center p-2 px-3 my-2 hover:bg-gray-200 rounded-lg transition">
                        <i class="fa-regular fa-square-plus mr-3 text-lg w-[22px]"></i>
                        <span>Create Team</span>
                    </li>
                </a>
                <hr>
            </ul>
        </div>

        {{-- Logout --}}
        <div class="mt-auto mb-6 p-3 hover:bg-rose-500 rounded-lg transition text-red-500 hover:text-white">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="text-md" type="submit">
                    <div class="flex flex-row items-center rounded-lg transition">
                        <i class="fa-solid fa-arrow-right-from-bracket mr-3 text-lg w-[22px]"></i>
                        <span class="font-bold">Log Out</span>
                    </div>
                </button>
            </form>
        </div>
    </div>
</aside>



{{-- Small Navbar --}}
{{-- Hamburger Icon & Nav --}}
<div class="h-[70px] w-screen bg-white border-b-2 flex lg:hidden z-[100] relative">
    <a href="#" class="ml-4">
        <img src="{{ asset('assets/logo.png') }}" alt="logo" class="w-[110px] object-cover mt-[-5px]">
    </a>
    <div id="toggle" class="ms-auto me-4 self-center active:bg-gray-200 rounded-full transition">
        <svg class="ham hamRotate ham8" viewBox="0 0 100 100" width="44" onclick="this.classList.toggle('active')">
            <path class="line top"
                d="m 30,33 h 40 c 3.722839,0 7.5,3.126468 7.5,8.578427 0,5.451959 -2.727029,8.421573 -7.5,8.421573 h -20" />
            <path class="line middle" d="m 30,50 h 40" />
            <path class="line bottom"
                d="m 70,67 h -40 c 0,0 -7.5,-0.802118 -7.5,-8.365747 0,-7.563629 7.5,-8.634253 7.5,-8.634253 h 20" />
        </svg>
    </div>
</div>

{{-- Navbar Content --}}
<div id="smallNav" class="bg-white border-b-2 absolute w-full z-[99] lg:hidden">
    <ul class="ml-0">
        <ul class="m-3">
            @if (auth()->user()->global_role == 'admin')
                <a href="{{ route('teams') }}" class="text-md">
                    <li class="flex flex-row items-center p-2 px-3 my-2 hover:bg-gray-200 rounded-lg transition">
                        <i class="fa-regular fa-file-lines mr-3 text-lg w-[22px]"></i>
                        <span>List Teams</span>
                    </li>
                </a>
                <a href="{{ route('resource.list') }}" class="text-md">
                    <li class="flex flex-row items-center p-2 px-3 my-2 hover:bg-gray-200 rounded-lg transition">
                        <i class="fa-solid fa-chart-column mr-3 text-lg w-[22px]"></i>
                        <span>Manage Resources</span>
                    </li>
                </a>
            @endif
            @if (auth()->user()->global_role == 'user')
                <a href="{{ route('teams') }}" class="text-md">
                    <li class="flex flex-row items-center p-2 px-3 my-2 hover:bg-gray-200 rounded-lg transition">
                        <i class="fa-solid fa-users-viewfinder mr-3 text-lg w-[22px]"></i>
                        <span>My Teams</span>
                    </li>
                </a>
            @endif
            <a href="{{ route('teams.create') }}" class="text-md">
                <li class="flex flex-row items-center p-2 px-3 my-2 hover:bg-gray-200 rounded-lg transition">
                    <i class="fa-regular fa-square-plus mr-3 text-lg w-[22px]"></i>
                    <span>Create Team</span>
                </li>
            </a>

            {{-- <a href="#" class="text-md">
                <li class="flex flex-row items-center p-2 px-3 my-2 hover:bg-gray-200 rounded-lg transition">
                    <i class="fa-solid fa-list mr-3 text-lg w-[22px]"></i>
                    <span>Audit Logs</span>
                </li>
            </a> --}}
            <hr>
        </ul>

        {{-- Profile --}}
        <div class="m-3 px-3 flex align-center justify-left mt-12">
            <img src="{{ asset('assets/icons/profile.png') }}" alt="profile_icon"
                class="h-[15px] object-contain my-auto mr-4">
            <div class="flex flex-col my-auto mr-4">
                <h2 class="text-gray-500 text-xs">{{ auth()->user()->global_role }}</h2>
                <p>{{ auth()->user()->display_name }}</p>
            </div>
        </div>

        {{-- Logout --}}
        <div class="mt-0 m-3 p-3 hover:bg-rose-500 rounded-lg transition text-red-500 hover:text-white">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-md">
                    <div class="flex flex-row items-center rounded-lg transition">
                        <i class="fa-solid fa-arrow-right-from-bracket mr-3 text-lg w-[22px]"></i>
                        <span class="font-bold">Log Out</span>
                    </div>
                </button>
            </form>
        </div>
    </ul>
</div>



{{-- Script --}}
<script>
    // Hamburget Icon Logic
    $(document).ready(function() {
        $('#toggle').on('click', function() {
            if ($('#smallNav').hasClass('active')) {
                $('#smallNav').removeClass('active');
            } else {
                $('#smallNav').addClass('active');
            }
        })
    })
</script>
