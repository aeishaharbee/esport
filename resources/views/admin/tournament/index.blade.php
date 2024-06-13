<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tournament Dashboard') }}
        </h2>
    </x-slot> --}}

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

    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex justify-center flex-col">
            <div class="p-6 flex justify-center">
                <a href="{{ route('admin.tournament.create') }}"
                    class="transition ease-in-out delay-100 hover:-translate-y-1 hover:scale-105 duration-300 text-indigo-950 inline-flex mx-auto justify-center bg-lime-300 hover:bg-lime-500 focus:ring-4 focus:outline-none focus:ring-lime-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">
                    Create New Tournament
                </a>
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

        <div class="pt-3" id="activeTournaments">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden sm:rounded-lg">
                    <h2 class="pt-6 text-center font-semibold text-3xl text-gray-200 leading-tight">
                        Active Tournaments
                    </h2>
                </div>
            </div>
        </div>


        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden sm:rounded-lg flex flex-wrap pb-6 tournaments">
                    @foreach ($activeTournaments as $tournament)
                        <div id="{{ $tournament->id }}"
                            class="tournament-item max-w-sm mx-auto flex flex-col items-start justify-between bg-indigo-950 border border-gray-200 rounded-lg shadow mb-5"
                            data-category="{{ $tournament->categoryId }}">

                            <div>
                                <img class="rounded-t-lg" src="{{ asset($tournament->image) }}" alt="" />
                                <div class="p-5">
                                    <a href="#">
                                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-white">
                                            {{ $tournament->name }}</h5>
                                    </a>
                                    <p class="mb-2 text-xl font-bold tracking-tight text-white">
                                        {{ $tournament->category->name }}</p>
                                    <p class="mb-3 font-normal text-gray-300">{{ $tournament->desc }}
                                    </p>
                                    <p class="mb-3 font-normal text-gray-300">
                                        {{ $tournament->startDate }}
                                        until
                                        <span>{{ $tournament->endDate }}</span>
                                    </p>
                                </div>
                            </div>

                            <div class="px-5 pb-5">

                                <a href="{{ route('admin.tournament.edit', ['tournament' => $tournament]) }}"
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    Edit
                                    <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                    </svg>
                                </a>


                                <button data-modal-target="popup-modal-{{ $tournament->id }}"
                                    data-modal-toggle="popup-modal-{{ $tournament->id }}"
                                    class="inline-flex text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
                                    type="button">
                                    Delete
                                    {{-- <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z"
                                        clip-rule="evenodd" />
                                </svg> --}}
                                </button>

                                <div id="popup-modal-{{ $tournament->id }}" tabindex="-1"
                                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative p-4 w-full max-w-md max-h-full">
                                        <div class="relative bg-indigo-950 rounded-lg shadow shadow-white">
                                            <button type="button"
                                                class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                data-modal-hide="popup-modal-{{ $tournament->id }}">
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
                                                <svg class="mx-auto mb-4 text-gray-200 w-12 h-12 " aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 20 20">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>
                                                <h3 class="mb-5 text-lg font-normal text-gray-200 ">Are
                                                    you sure you
                                                    want to delete <span
                                                        class=" font-bold text-lime-300 block">{{ $tournament->name }}</span>
                                                    tournament?</h3>
                                                <form method="POST" class=" inline-block"
                                                    action="{{ route('admin.tournament.destroy', ['tournament' => $tournament]) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                        Yes, I'm sure
                                                    </button>
                                                </form>
                                                <button data-modal-hide="popup-modal-{{ $tournament->id }}"
                                                    type="button"
                                                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-lime-700 focus:z-10 focus:ring-4 focus:ring-lime-300 ">No,
                                                    cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <a href="{{ route('admin.tournament.details', ['tournament' => $tournament]) }}"
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                    See Details
                                    <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                    </svg>
                                </a>

                            </div>
                        </div>
                    @endforeach

                    {{-- <div id="no-active-tournaments" class="hidden bg-red-100 text-red-700 p-4 rounded-lg mb-6">
                    This category doesn't have any active tournaments.
                </div> --}}
                </div>
            </div>
        </div>


        <div class="pt-3" id="pastTournaments">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden sm:rounded-lg">
                    <h2 class="pt-6 text-center font-semibold text-3xl text-gray-200 leading-tight">
                        Past Tournaments
                    </h2>
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-sm sm:rounded-lg flex flex-wrap pb-6 tournaments">
                    @foreach ($inactiveTournaments as $tournament)
                        <div id="{{ $tournament->id }}"
                            class="tournament-item max-w-sm mx-auto flex flex-col items-start justify-between bg-indigo-950 border border-gray-200 rounded-lg shadow mb-5"
                            data-category="{{ $tournament->categoryId }}">

                            <div>
                                <img class="rounded-t-lg" src="{{ asset($tournament->image) }}" alt="" />
                                <div class="p-5">
                                    <a href="#">
                                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-white">
                                            {{ $tournament->name }}</h5>
                                    </a>
                                    <p class="mb-2 text-xl font-bold tracking-tight text-white">
                                        {{ $tournament->category->name }}</p>
                                    <p class="mb-3 font-normal text-gray-300">
                                        {{ $tournament->desc }}
                                    </p>
                                    <p class="mb-3 font-normal text-gray-300">
                                        {{ $tournament->startDate }}
                                        until
                                        <span>{{ $tournament->endDate }}</span>
                                    </p>
                                </div>
                            </div>

                            <div class="px-5 pb-5">

                                <a href="{{ route('admin.tournament.details', ['tournament' => $tournament]) }}"
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                    See Details
                                    <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                    </svg>
                                </a>

                            </div>
                        </div>
                    @endforeach

                    {{-- <div id="no-inactive-tournaments" class="hidden bg-red-100 text-red-700 p-4 rounded-lg mb-6">
                    This category doesn't have any past tournaments.
                </div> --}}
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
                // if (isActive) {
                //     hasActiveTournaments = true;
                // } else {
                //     hasInactiveTournaments = true;
                // }
            } else {
                tournament.style.display = 'none';
            }
        });

        const noActiveTournamentsMessage = document.getElementById('no-active-tournaments');
        const noInactiveTournamentsMessage = document.getElementById('no-inactive-tournaments');

        // if (hasActiveTournaments) {
        //     noActiveTournamentsMessage.classList.add('hidden');
        // } else {
        //     noActiveTournamentsMessage.classList.remove('hidden');
        // }

        // if (hasInactiveTournaments) {
        //     noInactiveTournamentsMessage.classList.add('hidden');
        // } else {
        //     noInactiveTournamentsMessage.classList.remove('hidden');
        // }
    }
</script>
