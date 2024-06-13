<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-white leading-tight text-center">
            {{ $tournament->name }}
        </h2>
    </x-slot>


    <img class="h-auto w-auto mx-auto md:max-w-xl 2xl:max-w-3xl " src="{{ asset($tournament->image) }}"
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
            <div class="bg-indigo-950 border overflow-hidden shadow-sm sm:rounded-lg justify-center flex flex-col">
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
                    <a href="{{ route('admin.tournament.match', ['tournament' => $tournament]) }}"
                        class="transition ease-in-out delay-100 hover:-translate-y-1 hover:scale-105 duration-300 mx-auto mb-3 block text-indigo-950 bg-lime-300 hover:bg-lime-500 focus:ring-4 focus:outline-none focus:ring-lime-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">
                        Assign Matches
                    </a>

                    <!-- Main modal -->
                    <div id="select-modal" tabindex="-1" aria-hidden="true"
                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative p-4 w-full max-w-md max-h-full">
                            <!-- Modal content -->
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                <!-- Modal header -->
                                <div
                                    class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        Team to Participate
                                    </h3>
                                    <button type="button"
                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
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
                                <div class="p-4 md:p-5">
                                    <p class="text-gray-500 dark:text-gray-400 mb-4">Select your desired Team:</p>
                                    <ul class="space-y-4 mb-4">


                                    </ul>
                                    <button type="submit"
                                        class="text-white inline-flex w-full justify-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        Confirm
                                    </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <button disabled
                        class="mx-auto mb-3 text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                        Assign Matches
                    </button>
                    <p class="px-6 pb-3 text-gray-100 text-center font-bold">
                        Tournament has ended.
                    </p>
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
            <div class="overflow-hidden shadow-sm sm:rounded-lg ">
                {{-- <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight px-6 pt-3  text-center">
                    {{ $tournament->category->name }}
                </h2>

                <p class="px-6 py-3 text-gray-900 dark:text-gray-100 text-center">
                    {{ $tournament->desc }}
                </p>

                <p class="px-6 pb-3 text-gray-900 dark:text-gray-100 text-center font-bold">
                    {{ $tournament->startDate }} <span class=" font-normal">until</span> {{ $tournament->endDate }}
                </p> --}}

                @if ($registeredTeams->isEmpty())
                    <h2 class="text-xl font-bold mb-4 px-6 text-center text-white">Participated Teams</h2>

                    <p class="text-gray-100 px-6 text-center">No teams have registered for this tournament.</p>
                @else
                    <h2 class="font-semibold text-xl text-white leading-tight px-6 py-3  text-center">
                        Participated Teams
                    </h2>
                    <div class="flex flex-wrap">
                        @foreach ($registeredTeams as $team)
                            <div
                                class="mx-auto flex flex-col justify-between max-w-52 rounded overflow-hidden shadow m-4
                                bg-indigo-950 text-white border">

                                <div>
                                    <div id="team-{{ $team->id }}"
                                        data-url="{{ route('team.details', $team->id) }}"
                                        class="team-item cursor-pointer mx-auto flex flex-col justify-between max-w-52 rounded overflow-hidden shadow
                                    transition ease-in-out delay-50 hover:-translate-y-1 hover:scale-105 hover:shadow-sm hover:shadow-white duration-300 
                                    bg-indigo-950 text-white  hover:bg-lime-300 hover:text-indigo-950">
                                        <img class="w-full" src="{{ asset($team->logo) }}" alt="Team Image">
                                    </div>
                                    <div class="px-6 py-4">
                                        <p class="font-bold text-xl mb-2 text-center ">
                                            {{ $team->name }}</p>
                                        {{-- <p class="text-gray-700 text-base">Category: {{ $team->win }}</p> --}}
                                    </div>
                                </div>

                                <div class="px-5 pb-5 flex items-center justify-center text-center w-full">

                                    {{-- <a href="{{ route('team.edit', ['team' => $team]) }}"
                                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        Edit
                                        <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                        </svg>
                                    </a> --}}


                                    <button data-modal-target="popup-modal-{{ $team->id }}"
                                        data-modal-toggle="popup-modal-{{ $team->id }}"
                                        class="inline-flex text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
                                        type="button">
                                        Remove
                                    </button>

                                    <div id="popup-modal-{{ $team->id }}" tabindex="-1"
                                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                        <div class="relative p-4 w-full max-w-md max-h-full">
                                            <div class="relative bg-indigo-950 rounded-lg shadow shadow-white">
                                                <button type="button"
                                                    class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                    data-modal-hide="popup-modal-{{ $team->id }}">
                                                    <svg class="w-3 h-3" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 14 14">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                                <div class="p-4 md:p-5 text-center">
                                                    <svg class="mx-auto mb-4 text-gray-200 w-12 h-12 "
                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        fill="none" viewBox="0 0 20 20">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                    </svg>
                                                    <h3 class="mb-5 text-lg font-normal text-gray-200 ">Are
                                                        you sure you
                                                        want to remove <span
                                                            class=" font-bold text-lime-300 block">{{ $team->name }}</span>
                                                        from this tournament?</h3>
                                                    <form method="POST" class=" inline-block"
                                                        action="{{ route('admin.tournament.teams.destroy', ['tournament' => $tournament->id, 'team' => $team->id]) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                            Yes, I'm sure
                                                        </button>
                                                    </form>
                                                    <button data-modal-hide="popup-modal-{{ $team->id }}"
                                                        type="button"
                                                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-lime-700 focus:z-10 focus:ring-4 focus:ring-lime-300 ">No,
                                                        cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                <div class="container mx-auto mt-8">
                    {{-- <h1 class="text-2xl font-bold mb-6 px-6">{{ $tournament->name }}</h1>
                    <p class="text-gray-700 text-base px-6">{{ $tournament->desc }}</p> --}}

                    <h2 class="text-xl font-bold mt-8 mb-4 px-6 text-center text-white">Ongoing Matches</h2>
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
                                    <div class="mb-4 flex justify-center w-full">
                                        <a href="{{ route('admin.match.edit', ['tournament' => $tournament->id, 'match' => $match->id]) }}"
                                            class="inline-flex me-2 items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            Edit
                                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 14 10">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M1 5h12m0 0L9 1m4 4L9 9" />
                                            </svg>
                                        </a>

                                        <button data-modal-target="popup-modal-{{ $match->id }}"
                                            data-modal-toggle="popup-modal-{{ $match->id }}"
                                            class="me-2 inline-flex text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
                                            type="button">
                                            Delete
                                        </button>

                                        <div id="popup-modal-{{ $match->id }}" tabindex="-1"
                                            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                            <div class="relative p-4 w-full max-w-md max-h-full">
                                                <div class="relative bg-indigo-950 rounded-lg shadow shadow-white">
                                                    <button type="button"
                                                        class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                        data-modal-hide="popup-modal-{{ $match->id }}">
                                                        <svg class="w-3 h-3" aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 14 14">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                        </svg>
                                                        <span class="sr-only">Close modal</span>
                                                    </button>
                                                    <div class="p-4 md:p-5 text-center">
                                                        <svg class="mx-auto mb-4 text-gray-200 w-12 h-12 "
                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            fill="none" viewBox="0 0 20 20">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                        </svg>
                                                        <h3 class="mb-5 text-lg font-normal text-gray-200 ">Are
                                                            you sure you
                                                            want to delete <span
                                                                class=" font-bold text-lime-300 block">{{ $match->team1->name }}
                                                                vs {{ $match->team2->name }}</span>
                                                            match?</h3>
                                                        <form method="POST" class=" inline-block"
                                                            action="{{ route('admin.match.destroy', ['tournament' => $tournament->id, 'match' => $match->id]) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                                Yes, I'm sure
                                                            </button>
                                                        </form>
                                                        <button data-modal-hide="popup-modal-{{ $match->id }}"
                                                            type="button"
                                                            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-lime-700 focus:z-10 focus:ring-4 focus:ring-lime-300 ">No,
                                                            cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        <button data-modal-target="popup-completed-{{ $match->id }}"
                                            data-modal-toggle="popup-completed-{{ $match->id }}"
                                            class="inline-flex text-white bg-lime-500 hover:bg-lime-600 focus:ring-4 focus:outline-none focus:ring-lime-700 font-medium rounded-lg text-sm px-3 py-2 text-center "
                                            type="button">
                                            Completed
                                        </button>

                                        <div id="popup-completed-{{ $match->id }}" tabindex="-1"
                                            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                            <div class="relative p-4 w-full max-w-md max-h-full">
                                                <div
                                                    class="relative bg-indigo-950 border rounded-lg shadow shadow-white">
                                                    <!-- Modal header -->
                                                    <div
                                                        class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                                                        <h3 class="text-lg font-semibold text-white">
                                                            Match Completed
                                                        </h3>
                                                        <button type="button"
                                                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center"
                                                            data-modal-toggle="popup-completed-{{ $match->id }}">
                                                            <svg class="w-3 h-3" aria-hidden="true"
                                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 14 14">
                                                                <path stroke="currentColor" stroke-linecap="round"
                                                                    stroke-linejoin="round" stroke-width="2"
                                                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                            </svg>
                                                            <span class="sr-only">Close modal</span>
                                                        </button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <div class="p-4 md:p-5">
                                                        <p class="text-gray-300 mb-4">Which team
                                                            <span class=" font-bold text-white">won</span> the
                                                            match?
                                                        </p>
                                                        <ul class="space-y-4 mb-4">
                                                            <form method="POST"
                                                                action="{{ route('admin.match.complete', ['tournament' => $tournament->id, 'match' => $match->id]) }}">
                                                                @csrf
                                                                @method('post')
                                                                {{-- HAVE TEAMS --}}
                                                                <li class="mb-3">
                                                                    <input type="radio"
                                                                        id="{{ $match->id }}{{ $match->team1->id }}"
                                                                        name="teamWon"
                                                                        value="{{ $match->team1->id }}"
                                                                        class="hidden peer" required />
                                                                    <label
                                                                        for="{{ $match->id }}{{ $match->team1->id }}"
                                                                        class="inline-flex items-center justify-between w-full p-5  bg-indigo-950 border border-gray-200 rounded-lg cursor-pointer  dark:border-gray-500 peer-checked:border-lime-600 peer-checked:text-lime-600 hover:text-lime-500 text-white">
                                                                        <div class="block">
                                                                            <div class="w-full text-lg font-semibold">
                                                                                {{ $match->team1->name }}
                                                                            </div>
                                                                            {{-- <div
                                                                                class="w-full text-gray-500 dark:text-gray-400">
                                                                                {{ $match->team1->categoryId }}
                                                                            </div> --}}
                                                                        </div>
                                                                        <svg class="w-4 h-4 ms-3 rtl:rotate-180 "
                                                                            aria-hidden="true"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            fill="none" viewBox="0 0 14 10">
                                                                            <path stroke="currentColor"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                stroke-width="2"
                                                                                d="M1 5h12m0 0L9 1m4 4L9 9" />
                                                                        </svg>
                                                                    </label>
                                                                </li>

                                                                <li>
                                                                    <input type="radio"
                                                                        id="{{ $match->id }}{{ $match->team2->id }}"
                                                                        name="teamWon"
                                                                        value="{{ $match->team2->id }}"
                                                                        class="hidden peer" required />
                                                                    <label
                                                                        for="{{ $match->id }}{{ $match->team2->id }}"
                                                                        class="inline-flex items-center justify-between w-full p-5 bg-indigo-950 border border-gray-200 rounded-lg cursor-pointer dark:border-gray-500 peer-checked:border-lime-600 peer-checked:text-lime-600 hover:text-lime-500 text-white">
                                                                        <div class="block">
                                                                            <div class="w-full text-lg font-semibold">
                                                                                {{ $match->team2->name }}
                                                                            </div>
                                                                            {{-- <div
                                                                                class="w-full text-gray-500 dark:text-gray-400">
                                                                                {{ $team->category->name }}
                                                                            </div> --}}
                                                                        </div>
                                                                        <svg class="w-4 h-4 ms-3 rtl:rotate-180 "
                                                                            aria-hidden="true"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            fill="none" viewBox="0 0 14 10">
                                                                            <path stroke="currentColor"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                stroke-width="2"
                                                                                d="M1 5h12m0 0L9 1m4 4L9 9" />
                                                                        </svg>
                                                                    </label>
                                                                </li>
                                                        </ul>
                                                        <button type="submit"
                                                            class="text-indigo-950 inline-flex w-full justify-center bg-lime-300 hover:bg-lime-500 focus:ring-4 focus:outline-none focus:ring-lime-600 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">
                                                            Confirm
                                                        </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    @if ($matches->isEmpty() || $hasNoActiveMatches)
                        <p class="text-gray-200 px-6 pb-6 text-center">No ongoing matches have been assigned for this
                            tournament.</p>
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
                                        <div class="px-6 py-4 w-full">
                                            <p class="text-gray-100 text-base text-center">{{ $match->time }}</p>
                                        </div>
                                        <div class="mb-4 flex justify-center w-full">
                                            <button disabled
                                                class="inline-flex me-2 items-center px-3 py-2 text-sm font-medium text-center text-white bg-gray-700 rounded-lg hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                                                Edit
                                                {{-- <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 14 10">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M1 5h12m0 0L9 1m4 4L9 9" />
                                                </svg> --}}
                                            </button>

                                            <button disabled data-modal-target="popup-modal-{{ $match->id }}"
                                                data-modal-toggle="popup-modal-{{ $match->id }}"
                                                class="me-2 inline-flex text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-3 py-2 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800"
                                                type="button">
                                                Delete
                                            </button>

                                            <div id="popup-modal-{{ $match->id }}" tabindex="-1"
                                                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                                <div class="relative p-4 w-full max-w-md max-h-full">
                                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                        <button type="button"
                                                            class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                            data-modal-hide="popup-modal-{{ $match->id }}">
                                                            <svg class="w-3 h-3" aria-hidden="true"
                                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 14 14">
                                                                <path stroke="currentColor" stroke-linecap="round"
                                                                    stroke-linejoin="round" stroke-width="2"
                                                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                            </svg>
                                                            <span class="sr-only">Close modal</span>
                                                        </button>
                                                        <div class="p-4 md:p-5 text-center">
                                                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200"
                                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                fill="none" viewBox="0 0 20 20">
                                                                <path stroke="currentColor" stroke-linecap="round"
                                                                    stroke-linejoin="round" stroke-width="2"
                                                                    d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                            </svg>
                                                            <h3
                                                                class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                                                Are
                                                                you sure you
                                                                want to delete this tournament?</h3>
                                                            <form method="POST" class=" inline-block"
                                                                action="{{ route('admin.match.destroy', ['tournament' => $tournament->id, 'match' => $match->id]) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                                    Yes, I'm sure
                                                                </button>
                                                            </form>
                                                            <button data-modal-hide="popup-modal-{{ $match->id }}"
                                                                type="button"
                                                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No,
                                                                cancel</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <button disabled data-modal-target="popup-completed-{{ $match->id }}"
                                                data-modal-toggle="popup-completed-{{ $match->id }}"
                                                class="inline-flex text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-3 py-2 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800"
                                                type="button">
                                                Completed
                                            </button>

                                            <div id="popup-completed-{{ $match->id }}" tabindex="-1"
                                                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                                <div class="relative p-4 w-full max-w-md max-h-full">
                                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                        <!-- Modal header -->
                                                        <div
                                                            class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                                            <h3 class="text-lg font-semibold text-white">
                                                                Match Completed
                                                            </h3>
                                                            <button type="button"
                                                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                                data-modal-toggle="popup-completed-{{ $match->id }}">
                                                                <svg class="w-3 h-3" aria-hidden="true"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 14 14">
                                                                    <path stroke="currentColor" stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                                </svg>
                                                                <span class="sr-only">Close modal</span>
                                                            </button>
                                                        </div>

                                                        <!-- Modal body -->
                                                        <div class="p-4 md:p-5">
                                                            <p class="text-gray-500 dark:text-gray-400 mb-4">Which team
                                                                <span class=" font-bold text-black">won</span> the
                                                                match?
                                                            </p>
                                                            <ul class="space-y-4 mb-4">
                                                                <form method="POST"
                                                                    action="{{ route('admin.match.complete', ['tournament' => $tournament->id, 'match' => $match->id]) }}">
                                                                    @csrf
                                                                    @method('post')
                                                                    {{-- HAVE TEAMS --}}
                                                                    <li class="mb-3">
                                                                        <input type="radio" id="teamWon"
                                                                            name="teamWon"
                                                                            value="{{ $match->team1->id }}"
                                                                            class="hidden peer" required />
                                                                        <label for="teamWon"
                                                                            class="inline-flex items-center justify-between w-full p-5 text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-500 dark:peer-checked:text-green-500 peer-checked:border-green-600 peer-checked:text-green-600 hover:text-gray-900 hover:bg-gray-100 dark:text-white dark:bg-gray-600 dark:hover:bg-gray-500">
                                                                            <div class="block">
                                                                                <div
                                                                                    class="w-full text-lg font-semibold">
                                                                                    {{ $match->team1->name }}
                                                                                </div>
                                                                                {{-- <div
                                                                                class="w-full text-gray-500 dark:text-gray-400">
                                                                                {{ $match->team1->categoryId }}
                                                                            </div> --}}
                                                                            </div>
                                                                            <svg class="w-4 h-4 ms-3 rtl:rotate-180 text-gray-500 dark:text-gray-400"
                                                                                aria-hidden="true"
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                fill="none" viewBox="0 0 14 10">
                                                                                <path stroke="currentColor"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    stroke-width="2"
                                                                                    d="M1 5h12m0 0L9 1m4 4L9 9" />
                                                                            </svg>
                                                                        </label>
                                                                    </li>

                                                                    <li>
                                                                        <input type="radio" id="teamWon"
                                                                            name="teamWon"
                                                                            value="{{ $match->team2->id }}"
                                                                            class="hidden peer" required />
                                                                        <label for="teamWon"
                                                                            class="inline-flex items-center justify-between w-full p-5 text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-500 dark:peer-checked:text-green-500 peer-checked:border-green-600 peer-checked:text-green-600 hover:text-gray-900 hover:bg-gray-100 dark:text-white dark:bg-gray-600 dark:hover:bg-gray-500">
                                                                            <div class="block">
                                                                                <div
                                                                                    class="w-full text-lg font-semibold">
                                                                                    {{ $match->team2->name }}
                                                                                </div>
                                                                                {{-- <div
                                                                                class="w-full text-gray-500 dark:text-gray-400">
                                                                                {{ $team->category->name }}
                                                                            </div> --}}
                                                                            </div>
                                                                            <svg class="w-4 h-4 ms-3 rtl:rotate-180 text-gray-500 dark:text-gray-400"
                                                                                aria-hidden="true"
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                fill="none" viewBox="0 0 14 10">
                                                                                <path stroke="currentColor"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    stroke-width="2"
                                                                                    d="M1 5h12m0 0L9 1m4 4L9 9" />
                                                                            </svg>
                                                                        </label>
                                                                    </li>
                                                            </ul>
                                                            <button type="submit"
                                                                class="text-white inline-flex w-full justify-center bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                                                Confirm
                                                            </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    </div>

                    @if ($hasNoInactiveMatches)
                </div>
                <p class="text-gray-200 px-6 pb-6 text-center">No matches has complete for this tournament.</p>
                @endif
            </div>
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
