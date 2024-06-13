<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-white leading-tight text-center pt-12">
            {{ __('Quick Actions') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="sm:rounded-lg flex flex-wrap justify-center items-center relative">
                <div>
                    <a href="{{ route('admin.tournament.create') }}" type="button"
                        class="inline-block text-lime-300 text-xl hover:bg-lime-300 focus:ring-4 focus:outline-none focus:ring-lime-100 hover:text-indigo-950 border border-lime-300 font-medium rounded-lg px-5 py-2.5 text-center me-2 mb-2 
                        transition ease-in-out hover:-translate-y-1 hover:scale-105 duration-300 ">
                        Create New Tournament</a>

                    <button data-modal-target="popup-modal-allTournaments" data-modal-toggle="popup-modal-allTournaments"
                        type="button"
                        class="inline-block text-lime-300 text-xl hover:bg-lime-300 focus:ring-4 focus:outline-none focus:ring-lime-100 hover:text-indigo-950 border border-lime-300 font-medium rounded-lg px-5 py-2.5 text-center me-2 mb-2 
                        transition ease-in-out hover:-translate-y-1 hover:scale-105 duration-300 ">
                        Go To Tournament</button>

                    <div id="popup-modal-allTournaments" tabindex="-1"
                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative p-4 w-full max-w-md max-h-full">
                            <div class="relative bg-indigo-950 border rounded-lg shadow shadow-white">
                                <!-- Modal header -->
                                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                                    <h3 class="text-lg font-semibold text-white">
                                        Go To Tournament
                                    </h3>
                                    <button type="button"
                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center"
                                        data-modal-toggle="popup-modal-allTournaments">
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
                                    <p class="text-gray-300 mb-4">Active Tournaments</p>
                                    <ul class="space-y-4 mb-4">
                                        @foreach ($allActiveTournaments as $tournament)
                                            <a href="{{ route('admin.tournament.index') }}#{{ $tournament->id }}">
                                                <li class="mb-3">
                                                    {{-- <input type="radio" id="{{ $tournament->id }}"
                                                        name="{{ $tournament->id }}" value="{{ $tournament->id }}"
                                                        class="hidden peer" required /> --}}
                                                    <label for="{{ $tournament->id }}"
                                                        class="inline-flex items-center justify-between w-full p-5  bg-indigo-950 border border-gray-200 rounded-lg cursor-pointer  dark:border-gray-500 peer-checked:border-lime-600 peer-checked:text-lime-600 hover:text-lime-500 text-white">
                                                        <div class="block">
                                                            <div class="w-full text-lg font-semibold">
                                                                {{ $tournament->name }}
                                                            </div>
                                                            <div class="w-full text-gray-500 dark:text-gray-400">
                                                                {{ $tournament->category->name }}
                                                            </div>
                                                        </div>
                                                        <svg class="w-4 h-4 ms-3 rtl:rotate-180 " aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 14 10">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="M1 5h12m0 0L9 1m4 4L9 9" />
                                                        </svg>
                                                    </label>
                                                </li>
                                            </a>
                                        @endforeach
                                    </ul>

                                    <p class="text-gray-300 mb-4">Past Tournaments</p>
                                    <ul class="space-y-4 mb-4">
                                        @foreach ($allInactiveTournaments as $tournament)
                                            <a
                                                href="{{ route('admin.tournament.details', ['tournament' => $tournament]) }}">
                                                <li class="mb-3">
                                                    {{-- <input type="radio" id="{{ $tournament->id }}"
                                                        name="{{ $tournament->id }}" value="{{ $tournament->id }}"
                                                        class="hidden peer" required /> --}}
                                                    <label for="{{ $tournament->id }}"
                                                        class="inline-flex items-center justify-between w-full p-5  bg-indigo-950 border border-gray-200 rounded-lg cursor-pointer  dark:border-gray-500 peer-checked:border-lime-600 peer-checked:text-lime-600 hover:text-lime-500 text-white">
                                                        <div class="block">
                                                            <div class="w-full text-lg font-semibold">
                                                                {{ $tournament->name }}
                                                            </div>
                                                            <div class="w-full text-gray-500 dark:text-gray-400">
                                                                {{ $tournament->category->name }}
                                                            </div>
                                                        </div>
                                                        <svg class="w-4 h-4 ms-3 rtl:rotate-180 " aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 14 10">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="M1 5h12m0 0L9 1m4 4L9 9" />
                                                        </svg>
                                                    </label>
                                                </li>
                                            </a>
                                        @endforeach
                                    </ul>
                                    {{-- <button type="submit"
                                        class="text-indigo-950 inline-flex w-full justify-center bg-lime-300 hover:bg-lime-500 focus:ring-4 focus:outline-none focus:ring-lime-600 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">
                                        Confirm
                                    </button> --}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <button data-modal-target="popup-modal-allTeams" data-modal-toggle="popup-modal-allTeams"
                        type="button"
                        class="inline-block text-lime-300 text-xl hover:bg-lime-300 focus:ring-4 focus:outline-none focus:ring-lime-100 hover:text-indigo-950 border border-lime-300 font-medium rounded-lg px-5 py-2.5 text-center me-2 mb-2 
                        transition ease-in-out hover:-translate-y-1 hover:scale-105 duration-300 ">
                        Go To Team</button>

                    <div id="popup-modal-allTeams" tabindex="-1"
                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative p-4 w-full max-w-md max-h-full">
                            <div class="relative bg-indigo-950 border rounded-lg shadow shadow-white">
                                <!-- Modal header -->
                                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                                    <h3 class="text-lg font-semibold text-white">
                                        Go To Team
                                    </h3>
                                    <button type="button"
                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center"
                                        data-modal-toggle="popup-modal-allTeams">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>

                                <!-- Modal body -->
                                <div class="p-4 md:p-5 z-50">
                                    @foreach ($categories as $category)
                                        @php
                                            $hasTeamsInCategory = $teams->contains(function ($team) use ($category) {
                                                return $team->category->name === $category->name;
                                            });
                                        @endphp

                                        @if (!$hasTeamsInCategory)
                                            <p class="text-gray-300 mb-2">{{ $category->name }}</p>
                                            <p class="text-gray-300 mb-4">No teams in this category.</p>
                                        @else
                                            <p class="text-gray-300 mb-4">{{ $category->name }}</p>
                                            <ul class="space-y-4 mb-4">
                                                @foreach ($teams as $team)
                                                    @if ($team->category->name == $category->name)
                                                        <a
                                                            href="{{ route('admin.team.index') }}#{{ $team->category->id }}">
                                                            <li class="mb-3">
                                                                {{-- <input type="radio" id="{{ $tournament->id }}"
                                                        name="{{ $tournament->id }}" value="{{ $tournament->id }}"
                                                        class="hidden peer" required /> --}}
                                                                <label for="{{ $team->id }}"
                                                                    class="inline-flex items-center justify-between w-full p-5  bg-indigo-950 border border-gray-200 rounded-lg cursor-pointer  dark:border-gray-500 peer-checked:border-lime-600 peer-checked:text-lime-600 hover:text-lime-500 text-white">
                                                                    <div class="block">
                                                                        <div class="w-full text-lg font-semibold">
                                                                            {{ $team->name }}
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
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M1 5h12m0 0L9 1m4 4L9 9" />
                                                                    </svg>
                                                                </label>
                                                            </li>
                                                        </a>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-3xl text-gray-100 leading-tight text-center">
                Statistics
            </h2>
        </div>
    </div>

    <div class="pt-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="sm:rounded-lg flex flex-wrap pb-6">
                <div id="totalTournaments" data-url="{{ route('admin.tournament.index') }}"
                    class="tournament-item cursor-pointer mx-auto flex flex-col justify-between max-w-sm rounded overflow-hidden shadow
                    items-start border-gray-200 mb-5
                    transition ease-in-out delay-50 hover:-translate-y-1 hover:scale-105 hover:shadow-sm hover:shadow-white duration-300 
                    bg-indigo-950 text-lime-300 border hover:border-lime-300 hover:bg-lime-300 hover:text-indigo-950">
                    <div class="p-5 flex items-center justify-center text-center w-full">
                        <h5 class="mb-2 text-8xl font-bold tracking-tight  text-center ">
                            {{ $totalTournaments }}</h5>
                    </div>
                    <div class="px-5 pb-5 flex items-center justify-center text-center w-full">
                        <p class="mb-2 text-xl font-bold tracking-tight text-gray-500">Tournaments
                            Created</p>
                    </div>
                </div>

                <div id="totalTournaments" data-url="{{ route('admin.tournament.index') }}#activeTournaments"
                    class="tournament-item cursor-pointer mx-auto flex flex-col justify-between max-w-sm rounded overflow-hidden shadow
                    items-start border-gray-200 mb-5
                    transition ease-in-out delay-50 hover:-translate-y-1 hover:scale-105 hover:shadow-sm hover:shadow-white duration-300 
                    bg-indigo-950 text-lime-300 border hover:border-lime-300 hover:bg-lime-300 hover:text-indigo-950">
                    <div class="p-5 flex items-center justify-center text-center w-full">
                        <h5 class="mb-2 text-8xl font-bold tracking-tight  text-center ">
                            {{ $activeTournaments }}</h5>
                    </div>
                    <div class="px-5 pb-5 flex items-center justify-center text-center w-full">
                        <p class="mb-2 text-xl font-bold tracking-tight text-gray-500">Upcoming Tournaments</p>
                    </div>
                </div>

                <div id="totalTournaments" data-url="{{ route('admin.tournament.index') }}#pastTournaments"
                    class="tournament-item cursor-pointer mx-auto flex flex-col justify-between max-w-sm rounded overflow-hidden shadow
                    items-start border-gray-200 mb-5
                    transition ease-in-out delay-50 hover:-translate-y-1 hover:scale-105 hover:shadow-sm hover:shadow-white duration-300 
                    bg-indigo-950 text-lime-300 border hover:border-lime-300 hover:bg-lime-300 hover:text-indigo-950">
                    <div class="p-5 flex items-center justify-center text-center w-full">
                        <h5 class="mb-2 text-8xl font-bold tracking-tight  text-center ">
                            {{ $inactiveTournaments }}</h5>
                    </div>
                    <div class="px-5 pb-5 flex items-center justify-center text-center w-full">
                        <p class="mb-2 text-xl font-bold tracking-tight text-gray-500">Tournaments Ended</p>
                    </div>
                </div>

                <div id="totalTeams" data-url="{{ route('admin.team.index') }}"
                    class="tournament-item cursor-pointer mx-auto flex flex-col justify-between max-w-sm rounded overflow-hidden shadow
                    items-start border-gray-200 mb-5
                    transition ease-in-out delay-50 hover:-translate-y-1 hover:scale-105 hover:shadow-sm hover:shadow-white duration-300 
                    bg-indigo-950 text-lime-300 border hover:border-lime-300 hover:bg-lime-300 hover:text-indigo-950">
                    <div class="p-5 flex items-center justify-center text-center w-full">
                        <h5 class="mb-2 text-8xl font-bold tracking-tight  text-center ">
                            {{ $totalTeams }}</h5>
                    </div>
                    <div class="px-5 pb-5 flex items-center justify-center text-center w-full">
                        <p class="mb-2 text-xl font-bold tracking-tight text-gray-500">Teams Registered</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const teamItems = document.querySelectorAll('.tournament-item');

        teamItems.forEach(item => {
            item.addEventListener('click', function() {
                const url = item.getAttribute('data-url');
                window.location.href = url;
            });
        });
    });
</script>
