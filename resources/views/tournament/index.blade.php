<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tournament Dashboard') }}
        </h2>
    </x-slot> --}}

    <x-slot name="title">
        {{ $title = 'Tournament' }}
    </x-slot>

    {{-- SUCCESS MESSAGE --}}
    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @if (session()->has('success'))
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- FILTER BY CATEGORY --}}
    <div class="pb-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-center overflow-hidden m:rounded-lg">
                <div class="inline-flex rounded-md mx-auto" role="group">
                    <button type="button" onclick="filterTournaments('1')"
                        class="px-4 py-2 text-sm font-medium text-lime-300 bg-transparent border border-lime-300 hover:bg-lime-300 rounded-s-lg  hover:text-indigo-950 focus:z-10 focus:ring-2 focus:ring-indigo-950 focus:bg-lime-300 focus:text-indigo-950 ease-in-out">
                        MLBB
                    </button>
                    <button type="button" onclick="filterTournaments('2')"
                        class="px-4 py-2 text-sm font-medium text-lime-300 bg-transparent border-t border-b border-lime-300 hover:bg-lime-300 hover:text-indigo-950 focus:z-10 focus:ring-2 focus:ring-indigo-950 focus:bg-lime-300 focus:text-indigo-950 ease-in-out">
                        PUBG
                    </button>
                    <button type="button" onclick="filterTournaments('3')"
                        class="px-4 py-2 text-sm font-medium text-lime-300 bg-transparent border border-lime-300 hover:bg-lime-300 hover:text-indigo-950 focus:z-10 focus:ring-2 focus:ring-indigo-950 focus:bg-lime-300 focus:text-indigo-950 ease-in-out">
                        Valo
                    </button>
                    <button type="button" onclick="filterTournaments('4')"
                        class="px-4 py-2 text-sm font-medium text-lime-300 bg-transparent border-t border-b border-lime-300 hover:bg-lime-300 hover:text-indigo-950 focus:z-10 focus:ring-2 focus:ring-indigo-950 focus:bg-lime-300 focus:text-indigo-950 ease-in-out">
                        LoL
                    </button>
                    <button type="button" onclick="filterTournaments('all')"
                        class="px-4 py-2 text-sm font-medium text-lime-300 bg-transparent border border-lime-300 rounded-e-lg hover:bg-lime-300 hover:text-indigo-950 focus:z-10 focus:ring-2 focus:ring-indigo-950 focus:bg-lime-300 focus:text-indigo-950 ease-in-out">
                        All
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="pb-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <h2 class="p-6 text-center font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Active Tournaments
                </h2>
            </div>
        </div>
    </div> --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" shadow-sm sm:rounded-lg flex flex-wrap tournaments">
                @foreach ($activeTournaments as $tournament)
                    <div id="tournament-{{ $tournament->id }}"
                        data-url="{{ route('tournament.details', ['tournament' => $tournament]) }}"
                        class="tournament-item max-w-sm mx-auto flex flex-col items-start justify-between bg-indigo-950 border border-lime-300 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mb-5 
                        transition ease-in-out delay-50 hover:-translate-y-1 hover:scale-105  hover:shadow-white duration-300 cursor-pointer"
                        data-category="{{ $tournament->categoryId }}">

                        <div>
                            <img class="rounded-t-lg" src="{{ asset($tournament->image) }}" alt="" />

                            <div class="p-5">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-white">
                                    {{ $tournament->name }}</h5>
                                <p class="mb-2 text-xl font-bold tracking-tight text-white">
                                    {{ $tournament->category->name }}</p>
                                <p class="mb-3 font-normal text-gray-100">{{ $tournament->desc }}</p>
                            </div>
                        </div>

                        <div class="px-5">
                            <p class="mb-3 font-normal text-gray-100">
                                {{ $tournament->startDate }}
                                until
                                <span>{{ $tournament->endDate }}</span>
                            </p>
                        </div>

                        {{-- <div class="px-5 pb-5">
                            <a href="{{ route('tournament.details', ['tournament' => $tournament]) }}"
                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                See Details
                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </a>
                        </div> --}}
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- <div class="pb-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <h2 class="p-6 text-center font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Past Tournaments
                </h2>
            </div>
        </div>
    </div> --}}

    <div class="pt-12 pb-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-center overflow-hidden m:rounded-lg">
                <div class="inline-flex rounded-md mx-auto" role="group">
                    <div
                        class="px-4 py-2 text-sm font-medium text-lime-300 bg-transparent border border-lime-300 rounded-lg  focus:z-10 focus:ring-2 focus:ring-indigo-950 focus:bg-lime-300 focus:text-indigo-950 ease-in-out">
                        <h2 class="px-4 py-2 text-center font-semibold text-xl leading-tight">
                            Past Tournaments
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" shadow-sm sm:rounded-lg flex flex-wrap pb-6 tournaments">
                @foreach ($inactiveTournaments as $tournament)
                    <div id="tournament-{{ $tournament->id }}"
                        data-url="{{ route('tournament.details', ['tournament' => $tournament]) }}"
                        class="tournament-item max-w-sm mx-auto flex flex-col items-start justify-between bg-gray-800 border rounded-lg shadow  mb-5 
                    transition ease-in-out delay-50 hover:-translate-y-1 hover:scale-105  hover:shadow-white duration-300 cursor-pointer"
                        data-category="{{ $tournament->categoryId }}">

                        <div>
                            <img class="rounded-t-lg" src="{{ asset($tournament->image) }}" alt="" />

                            <div class="p-5">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-white">
                                    {{ $tournament->name }}</h5>

                                <p class="mb-2 text-xl font-bold tracking-tight text-white">
                                    {{ $tournament->category->name }}</p>
                                <p class="mb-3 font-normal text-gray-100">{{ $tournament->desc }}
                                </p>
                                <p class="mb-3 font-normal text-gray-100">
                                    {{ $tournament->startDate }}
                                    until
                                    <span>{{ $tournament->endDate }}</span>
                                </p>
                            </div>
                        </div>

                        {{-- <div class="px-5 pb-5">
                            <a href="{{ route('tournament.details', ['tournament' => $tournament]) }}"
                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                See Details
                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </a>
                        </div> --}}
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function filterTournaments(categoryId) {
        const tournaments = document.querySelectorAll('.tournament-item');
        let hasActiveTournaments = false;
        let hasInactiveTournaments = false;

        tournaments.forEach(tournament => {
            if (categoryId === 'all' || tournament.getAttribute('data-category') === categoryId) {
                tournament.style.display = 'block';
            } else {
                tournament.style.display = 'none';
            }
        });

        const noActiveTournamentsMessage = document.getElementById('no-active-tournaments');
        const noInactiveTournamentsMessage = document.getElementById('no-inactive-tournaments');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const tournamentItems = document.querySelectorAll('.tournament-item');

        tournamentItems.forEach(item => {
            item.addEventListener('click', function() {
                const url = item.getAttribute('data-url');
                window.location.href = url;
            });
        });
    });
</script>
