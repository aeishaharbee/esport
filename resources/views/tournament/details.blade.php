<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-white leading-tight text-center">
            {{ $tournament->name }}
        </h2>
    </x-slot>

    <x-slot name="title">
        {{ $title = $tournament->name }}
    </x-slot>


    <img class="h-auto w-auto md:max-w-xl 2xl:max-w-3xl  mx-auto" src="{{ asset($tournament->image) }}"
        alt="image description">

    @if (session('success'))
        <div class="pt-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-lime-300 text-indigo-950 p-4 rounded mb-4 overflow-hidden shadow-sm sm:rounded-lg">
                    {{ session('success') }}
                </div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="pt-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-red-500 text-white p-4 rounded mb-4 overflow-hidden shadow-sm sm:rounded-lg">
                    {{ session('error') }}
                </div>
            </div>
        </div>
    @endif

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-indigo-950 overflow-hidden shadow-sm sm:rounded-lg justify-center flex flex-col">
                <h2 class="font-semibold text-xl text-gray-200 leading-tight px-6 pt-3  text-center">
                    {{ $tournament->category->name }}
                </h2>

                <p class="px-6 py-3 text-gray-100 text-center">
                    {{ $tournament->desc }}
                </p>

                <p class="px-6 pb-3 text-gray-100 text-center font-bold">
                    {{ $tournament->startDate }} <span class=" font-normal">until</span> {{ $tournament->endDate }}
                </p>

                @if ($tournament->isActive)
                    <!-- Modal toggle -->
                    @if (Auth::user())
                        <button data-modal-target="select-modal" data-modal-toggle="select-modal"
                            class="transition ease-in-out delay-100 hover:-translate-y-1 hover:scale-105 duration-300 mx-auto mb-3 block text-indigo-950 bg-lime-300 hover:bg-lime-500 focus:ring-4 focus:outline-none focus:ring-lime-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center "
                            type="button">
                            Participate
                        </button>
                    @else
                        <a href="{{ route('register') }}"
                            class="mx-auto mb-3 block text-white bg-lime-500 hover:bg-lime-600 focus:ring-4 focus:outline-none focus:ring-lime-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center "
                            type="button">
                            Want to participate? Register an account first.
                        </a>
                    @endif
                    <!-- Main modal -->
                    <div id="select-modal" tabindex="-1" aria-hidden="true"
                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative p-4 w-full max-w-md max-h-full">
                            <!-- Modal content -->
                            <div class="relative bg-indigo-950 rounded-lg shadow shadow-white ">
                                <!-- Modal header -->
                                <div
                                    class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-600">
                                    <h3 class="text-lg font-semibold text-white">
                                        Team to Participate
                                    </h3>
                                    <button type="button"
                                        class="text-gray-200 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center "
                                        data-modal-toggle="select-modal">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <div class="p-4 md:p-5 shadow shadow-white">
                                    <p class="text-gray-300 mb-4">Select your desired Team:</p>
                                    <ul class="space-y-4 mb-4">

                                        {{-- NO TEAMS --}}
                                        @if ($userTeams->isEmpty())
                                            <p class="text-gray-100">You have not registered any teams yet.</p>
                                            <a href="{{ route('team.create') }}"
                                                class="text-indigo-950 inline-flex w-full justify-center bg-lime-300 hover:bg-lime-500 focus:ring-4 focus:outline-none focus:ring-lime-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">
                                                Register a Team
                                            </a>
                                        @else
                                            <form method="POST"
                                                action="{{ route('tournament.team.register', $tournament->id) }}">
                                                @csrf
                                                @method('post')
                                                {{-- HAVE TEAMS --}}
                                                @foreach ($userTeams as $team)
                                                    <li class="mb-2">
                                                        <input type="radio" id="{{ $team->id }}" name="teamId"
                                                            value="{{ $team->id }}" class="hidden peer" required />
                                                        <label for="{{ $team->id }}"
                                                            class="group inline-flex items-center justify-between w-full p-5 border hover:border-lime-300 rounded-lg cursor-pointer hover:text-lime-300 border-gray-500 peer-checked:text-lime-300 peer-checked:border-lime-300  text-white bg-indigo-950 ">
                                                            <div class="block">
                                                                <div class="w-full text-lg font-semibold">
                                                                    {{ $team->name }}
                                                                </div>
                                                                <div
                                                                    class="w-full text-gray-200 group-hover:text-white">
                                                                    {{ $team->category->name }}</div>
                                                            </div>
                                                            <svg class="w-4 h-4 ms-3 rtl:rotate-180 text-gray-200 group-hover:text-white"
                                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                fill="none" viewBox="0 0 14 10">
                                                                <path stroke="currentColor" stroke-linecap="round"
                                                                    stroke-linejoin="round" stroke-width="2"
                                                                    d="M1 5h12m0 0L9 1m4 4L9 9" />
                                                            </svg>
                                                        </label>
                                                    </li>
                                                @endforeach
                                    </ul>
                                    <button type="submit"
                                        class="text-indigo-950 inline-flex w-full justify-center bg-lime-300 hover:bg-lime-500 focus:ring-4 focus:outline-none focus:ring-lime-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">
                                        Confirm
                                    </button>
                                    </form>
                @endif
            </div>
        </div>
    </div>
    </div>
    {{-- @else --}}
    {{-- <button disabled
        class="mx-auto mb-3 text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
        Participate
    </button> --}}
    {{-- <p class="px-6 pb-3 text-gray-500 text-center font-bold">
        Tournament has ended.
    </p> --}}
    @endif
    </div>
    </div>
    </div>

    @php
        // Reorder the array
        $silverFirst = count($topTeams) >= 3 ? collect([$topTeams[2], $topTeams[1], $topTeams[3]]) : '';
        // $goldFirst = collect([$topTeams[1], $topTeams[2], $topTeams[3]]);
    @endphp
    @if (!$tournament->isActive && !empty($topTeams))
        <div class="pt-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class=" overflow-hidden shadow-sm sm:rounded-lg justify-center flex flex-col">
                    <h2 class="font-semibold text-xl text-gray-200 leading-tight px-6 py-3  text-center">
                        Top 3 Teams
                    </h2>

                    {{-- MORE THAN MD --}}
                    <div class="hidden md:flex flex-wrap justify-center ">
                        @foreach ($silverFirst as $index => $team)
                            <div>
                                <div id="team-{{ $team->id }}" data-url="{{ route('team.details', $team->id) }}"
                                    class="team-item cursor-pointer flex flex-col justify-between max-w-52 rounded overflow-hidden shadow m-4
                            transition ease-in-out delay-50 hover:-translate-y-1 hover:scale-105 hover:shadow-sm  duration-300 
                            {{ $index == 1 ? 'bg-yellow-300 hover:shadow-yellow-300' : '' }}
                            {{ $index == 0 ? 'bg-gray-400 hover:shadow-gray-300 md:mt-20 ' : '' }}
                            {{ $index == 2 ? 'bg-amber-700 hover:shadow-amber-700 md:mt-36' : '' }}
                            text-white border ">
                                    {{-- <a href="{{ route('team.details', $team->id) }}"> --}}
                                    <img class="w-full" src="{{ asset($team->logo) }}" alt="Team Image">
                                    <div class="px-6 py-4">
                                        <p class="font-bold text-xl mb-2 text-center ">
                                            {{ $team->name }}</p>
                                        {{-- <p class="text-gray-700 text-base">Category: {{ $team->win }}</p> --}}
                                    </div>
                                    {{-- </a> --}}
                                </div>
                                <div class="hidden md:flex justify-center">
                                    <img src="
                                    {{ $index == 1 ? asset('assets/images/gold.png') : '' }}
                                    {{ $index == 2 ? asset('assets/images/bronze.png') : '' }}
                                    {{ $index == 0 ? asset('assets/images/silver.png') : '' }}
                                     "
                                        alt="" class="w-20 h-20">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- LESS THAN MD --}}
                    <div class="md:hidden flex flex-wrap justify-center ">
                        @foreach ($topTeams as $index => $team)
                            <div>
                                <div id="team-{{ $team->id }}" data-url="{{ route('team.details', $team->id) }}"
                                    class="team-item cursor-pointer flex flex-col justify-between max-w-52 rounded overflow-hidden shadow m-4
                            transition ease-in-out delay-50 hover:-translate-y-1 hover:scale-105 hover:shadow-sm  duration-300 
                            {{ $index == 1 ? 'bg-yellow-300 hover:shadow-yellow-300' : '' }}
                            {{ $index == 2 ? 'bg-gray-300 hover:shadow-gray-300' : '' }}
                            {{ $index == 3 ? 'bg-amber-700 hover:shadow-amber-700' : '' }}
                            text-white border ">
                                    {{-- <a href="{{ route('team.details', $team->id) }}"> --}}
                                    <img class="w-full" src="{{ asset($team->logo) }}" alt="Team Image">
                                    <div class="px-6 py-4">
                                        <p class="font-bold text-xl mb-2 text-center ">
                                            {{ $team->name }}</p>
                                        {{-- <p class="text-gray-700 text-base">Category: {{ $team->win }}</p> --}}
                                    </div>
                                    {{-- </a> --}}
                                </div>
                                <div class="md:hidden flex justify-center">
                                    <img src="
                                {{ $index == 1 ? asset('assets/images/gold.png') : '' }}
                                {{ $index == 2 ? asset('assets/images/silver.png') : '' }}
                                {{ $index == 3 ? asset('assets/images/bronze.png') : '' }}
                                 "
                                        alt="" class="w-20 h-20">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg py-6">
                {{-- <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight px-6 pt-3  text-center">
                    {{ $tournament->category->name }}
                </h2>

                <p class="px-6 py-3 text-gray-900 dark:text-gray-100 text-center">
                    {{ $tournament->desc }}
                </p>

                <p class="px-6 pb-3 text-gray-900 dark:text-gray-100 text-center font-bold">
                    {{ $tournament->startDate }} <span class=" font-normal">until</span> {{ $tournament->endDate }}
                </p> --}}


                @if ($participatingTeams->isEmpty())
                    <h2 class="text-xl font-bold mb-4 px-6 text-center text-white">Participated Teams</h2>

                    <p class="text-gray-100 px-6 text-center">No teams have registered for this tournament.</p>
                @else
                    <h2 class="font-semibold text-xl text-white leading-tight px-6 py-3  text-center">
                        Participated Teams
                    </h2>
                    <div class="flex flex-wrap">
                        @foreach ($participatingTeams as $team)
                            <div id="team-{{ $team->id }}" data-url="{{ route('team.details', $team->id) }}"
                                class="team-item cursor-pointer mx-auto flex flex-col justify-between max-w-52 rounded overflow-hidden shadow m-4
                                transition ease-in-out delay-50 hover:-translate-y-1 hover:scale-105 hover:shadow-sm hover:shadow-white duration-300 
                                bg-indigo-950 text-white border hover:border-lime-300 hover:bg-lime-300 hover:text-indigo-950">
                                {{-- <a href="{{ route('team.details', $team->id) }}"> --}}
                                <img class="w-full" src="{{ asset($team->logo) }}" alt="Team Image">
                                <div class="px-6 py-4">
                                    <p class="font-bold text-xl mb-2 text-center ">
                                        {{ $team->name }}</p>
                                    {{-- <p class="text-gray-700 text-base">Category: {{ $team->win }}</p> --}}
                                </div>
                                {{-- </a> --}}
                            </div>
                        @endforeach

                    </div>

                @endif


            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" overflow-hidden shadow-sm sm:rounded-lg ">
                <div class="container mx-auto mt-8 pb-6">
                    {{-- <h1 class="text-2xl font-bold mb-6 px-6">{{ $tournament->name }}</h1>
                    <p class="text-gray-700 text-base px-6">{{ $tournament->desc }}</p> --}}

                    @if ($tournament->isActive)
                        <h2 class="text-xl font-bold mt-6 mb-4 px-6 text-center text-white">Ongoing Matches</h2>
                        <div class="flex flex-wrap justify-center">
                            @foreach ($matches as $match)
                                @if ($match->isActive)
                                    <div
                                        class="max-w-sm rounded overflow-hidden shadow-lg m-4 flex flex-col items-start bg-indigo-950 border border-lime-300">
                                        <div class="font-bold text-2xl mt-3 text-white text-center w-full">
                                            {{ $match->level->name }}</div>
                                        <div
                                            class="px-6 py-4 flex justify-between w-full items-center flex-col sm:flex-row">
                                            <div class="flex flex-col justify-between items-center h-full">
                                                <div
                                                    class="block sm:hidden font-normal text-md mb-2 text-white text-center">
                                                    {{ $match->team1->name }}</div>
                                                <div id="team-{{ $match->team1->id }}"
                                                    data-url="{{ route('team.details', $match->team1->id) }}"
                                                    class="team-item cursor-pointer mx-auto flex flex-col justify-between max-w-52 rounded overflow-hidden shadow m-4
                                                transition ease-in-out delay-50 hover:-translate-y-1 hover:scale-105 hover:shadow-sm hover:shadow-white duration-300 
                                                 text-white border hover:border-lime-300 hover:bg-lime-300 hover:text-indigo-950">
                                                    <img class="max-w-28" src="{{ asset($match->team1->logo) }}"
                                                        alt="Team Image">
                                                </div>
                                                <div
                                                    class="sm:block hidden font-normal text-lg mb-2 text-white text-center">
                                                    {{ $match->team1->name }}</div>
                                            </div>
                                            <div class="font-bold text-xl mb-2 text-white px-5 py-5 sm:py-0">VS</div>
                                            <div class="flex flex-col justify-between items-center h-full">

                                                <div id="team-{{ $match->team2->id }}"
                                                    data-url="{{ route('team.details', $match->team2->id) }}"
                                                    class="team-item cursor-pointer mx-auto flex flex-col justify-between max-w-52 rounded overflow-hidden shadow m-4
                                                transition ease-in-out delay-50 hover:-translate-y-1 hover:scale-105 hover:shadow-sm hover:shadow-white duration-300 
                                                 text-white border hover:border-lime-300 hover:bg-lime-300 hover:text-indigo-950">

                                                    <img class="max-w-28" src="{{ asset($match->team2->logo) }}"
                                                        alt="Team Image">
                                                </div>
                                                <div class="font-normal text-lg mb-2 text-white text-center">
                                                    {{ $match->team2->name }}</div>
                                            </div>
                                        </div>
                                        <div class="px-6 py-4 w-full">
                                            <p class="text-gray-100 text-base text-center">{{ $match->time }}</p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        @if ($matches->isEmpty() || $hasNoActiveMatches)
                            <p class="text-gray-200 px-6 pb-6 text-center">No ongoing matches have been
                                assigned for
                                this
                                tournament.</p>
                        @endif
                    @endif

                    <h2 class="text-xl font-bold mt-8 mb-4 px-6 text-center text-white">Completed Matches</h2>
                    <div class="flex flex-wrap justify-center">
                        @foreach ($matches as $match)
                            @if (!$match->isActive)
                                @if ($match->result)
                                    <div
                                        class="max-w-sm rounded overflow-hidden shadow-lg m-4 flex flex-col items-start bg-gray-800">
                                        <div class="font-bold text-2xl mt-3 text-white text-center w-full">
                                            {{ $match->level->name }}</div>
                                        <div
                                            class="px-6 py-4 flex justify-between w-full items-center flex-col sm:flex-row">
                                            <div class="flex flex-col justify-between items-center h-full">
                                                @if ($match->team1->id == $match->result->winner->id)
                                                    <div
                                                        class="block sm:hidden font-bold text-2xl mb-2 text-yellow-400 text-center">
                                                        {{ $match->team1->name }}</div>
                                                @else
                                                    <div
                                                        class="block sm:hidden font-normal text-md mb-2 text-white text-center">
                                                        {{ $match->team1->name }}</div>
                                                @endif
                                                <div id="team-{{ $match->team1->id }}"
                                                    data-url="{{ route('team.details', $match->team1->id) }}"
                                                    class="team-item cursor-pointer mx-auto flex flex-col justify-between max-w-52 rounded overflow-hidden shadow m-4
                                                transition ease-in-out delay-50 hover:-translate-y-1 hover:scale-105 hover:shadow-sm hover:shadow-white duration-300 
                                                 text-white border hover:border-lime-300 hover:bg-lime-300 hover:text-indigo-950">
                                                    <img class="max-w-28" src="{{ asset($match->team1->logo) }}"
                                                        alt="Team Image">
                                                </div>
                                                @if ($match->team1->id == $match->result->winner->id)
                                                    <div
                                                        class="sm:block hidden font-bold text-2xl mb-2 text-yellow-400 text-center">
                                                        {{ $match->team1->name }}</div>
                                                @else
                                                    <div
                                                        class="sm:block hidden font-normal text-md mb-2 text-white text-center">
                                                        {{ $match->team1->name }}</div>
                                                @endif
                                            </div>
                                            <div class="font-bold text-xl mb-2 text-white px-5 py-5 sm:py-0">VS</div>
                                            <div class="flex flex-col justify-between items-center h-full">

                                                <div id="team-{{ $match->team2->id }}"
                                                    data-url="{{ route('team.details', $match->team2->id) }}"
                                                    class="team-item cursor-pointer mx-auto flex flex-col justify-between max-w-52 rounded overflow-hidden shadow m-4
                                                transition ease-in-out delay-50 hover:-translate-y-1 hover:scale-105 hover:shadow-sm hover:shadow-white duration-300 
                                                 text-white border hover:border-lime-300 hover:bg-lime-300 hover:text-indigo-950">

                                                    <img class="max-w-28" src="{{ asset($match->team2->logo) }}"
                                                        alt="Team Image">
                                                </div>
                                                @if ($match->team2->id == $match->result->winner->id)
                                                    <div class="font-bold text-2xl mb-2 text-yellow-400 text-center">
                                                        {{ $match->team2->name }}</div>
                                                @else
                                                    <div class="font-normal text-md mb-2 text-white text-center">
                                                        {{ $match->team2->name }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        {{-- <div class="px-6 py-4 w-full">
                                            <p class="text-gray-100 text-base text-center">{{ $match->time }}</p>
                                        </div> --}}
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    </div>
                </div>
                @if ($hasNoInactiveMatches)
                    <p class="text-gray-200 px-6 pb-6 text-center">No matches has complete for this tournament.</p>
                @endif
            </div>
        </div>
    </div>

</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const teamItems = document.querySelectorAll('.team-item');

        teamItems.forEach(item => {
            item.addEventListener('click', function() {
                const url = item.getAttribute('data-url');
                window.location.href = url;
            });
        });
    });
</script>
