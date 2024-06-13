<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-200 leading-tight text-center">
            {{ $team->name }}
        </h2>
    </x-slot>

    <x-slot name="title">
        {{ $title = $team->name }}
    </x-slot>

    @if (session('success'))
        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-lime-300 text-indigo-950 p-4 rounded mb-4 overflow-hidden shadow-sm sm:rounded-lg">
                    {{ session('success') }}
                </div>
            </div>
        </div>
    @endif

    <img class="h-auto w-auto mx-auto md:max-w-sm max-w-xs " src="{{ asset($team->logo) }}" alt="image description">

    @if (Auth::check() && auth()->user()->id == $team->registeredId)
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
                <h2 class="p-6 text-center font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    <a href="{{ route('team.edit', ['team' => $team]) }}"
                        class="transition ease-in-out delay-100 hover:-translate-y-1 hover:scale-105 duration-300 text-indigo-950 inline-flex justify-center bg-lime-300 hover:bg-lime-500 focus:ring-4 focus:outline-none focus:ring-lime-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">
                        Edit Details
                    </a>
                </h2>
            </div>
        </div>
    @endif

    <div class="container mx-auto mt-8">
        <table class="mx-auto min-w-[80vw] bg-indigo-950 mb-12 text-gray-100 shadow shadow-white sm:rounded-2xl">
            <thead>
                <tr>
                    <th class="py-2">Category</th>
                    <th class="py-2">Rank</th>
                    <th class="py-2">Score</th>
                    <th class="py-2">Wins</th>
                    <th class="py-2">Losses</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-t text-lime-300">
                    <td class="py-2 text-center">{{ $team->category->name }}</td>
                    <td class="py-2 text-center">{{ $teamRank === null ? '-' : $teamRank }}</td>
                    <td class="py-2 text-center">{{ $team->score }}</td>
                    <td class="py-2 text-center">{{ $team->win }}</td>
                    <td class="py-2 text-center">{{ $team->lost }}</td>
                </tr>
            </tbody>
        </table>

        {{-- <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
            <h3 class="text-xl font-semibold mb-4">Team Information</h3>
            <p><strong>Category:</strong> {{ $team->category->name }}</p>
            <p><strong>Rank:</strong> {{ $rank === false ? '-' : $rank + 1 }}</p>
            <p><strong>Current Score:</strong> {{ $team->score }}</p>
            <p><strong>Wins:</strong> {{ $team->win }}</p>
            <p><strong>Losses:</strong> {{ $team->lost }}</p>
        </div> --}}

        <div class="p-6 rounded-lg mb-6 sm:max-w-[80vw] mx-auto text-gray-100">
            <h3 class="text-xl font-semibold mb-4">Ongoing Tournaments</h3>
            @if ($ongoingTournaments->isEmpty())
                <p>No ongoing tournaments.</p>
            @else
                <div class="flex flex-wrap gap-3">
                    @foreach ($ongoingTournaments as $tournament)
                        @php
                            $detailsRoute =
                                auth()->check() && auth()->user()->isAdmin()
                                    ? route('admin.tournament.details', ['tournament' => $tournament])
                                    : route('tournament.details', ['tournament' => $tournament]);
                        @endphp
                        <div id="tournament-{{ $tournament->id }}" data-category="{{ $tournament->categoryId }}"
                            data-url="{{ $detailsRoute }}"
                            class="tournament-item inline-flex max-w-xs flex-col items-start justify-between bg-indigo-950 border border-lime-300 rounded-lg shadow mb-5
                    transition ease-in-out delay-50 hover:-translate-y-1 hover:scale-105  hover:shadow-white duration-300 cursor-pointer">

                            <a href="{{ $detailsRoute }}">
                                <div>
                                    <img class="rounded-t-lg" src="{{ asset($tournament->image) }}" alt="" />

                                    <div class="p-5">
                                        <h5 class="mb-2 text-2xl font-bold tracking-tighttext-white">
                                            {{ $tournament->name }}</h5>
                                        </p>
                                        <p class="mb-3 font-normal text-gray-200">
                                            {{ $tournament->startDate }}
                                            until
                                            <span>{{ $tournament->endDate }}</span>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="p-6 rounded-lg mb-6 sm:max-w-[80vw] mx-auto text-gray-100">
            <h3 class="text-xl font-semibold mb-4">Past Tournaments</h3>
            @if ($pastTournaments->isEmpty())
                <p>No past tournaments.</p>
            @else
                <div class="flex flex-wrap gap-3">
                    @foreach ($pastTournaments as $tournament)
                        @php
                            $detailsRoute =
                                auth()->check() && auth()->user()->isAdmin()
                                    ? route('admin.tournament.details', ['tournament' => $tournament])
                                    : route('tournament.details', ['tournament' => $tournament]);
                        @endphp
                        <div id="tournament-{{ $tournament->id }}" data-category="{{ $tournament->categoryId }}"
                            data-url="{{ $detailsRoute }}"
                            class="tournament-item inline-flex max-w-xs flex-col items-start justify-between bg-indigo-950 border border-lime-300 rounded-lg shadow mb-5
                        transition ease-in-out delay-50 hover:-translate-y-1 hover:scale-105  hover:shadow-white duration-300 cursor-pointer">

                            <a href="{{ $detailsRoute }}">
                                <div>
                                    <img class="rounded-t-lg" src="{{ asset($tournament->image) }}" alt="" />

                                    <div class="p-5">
                                        <h5 class="mb-2 text-2xl font-bold tracking-tighttext-white">
                                            {{ $tournament->name }}</h5>
                                        </p>
                                        <p class="mb-3 font-normal text-gray-200">
                                            {{ $tournament->startDate }}
                                            until
                                            <span>{{ $tournament->endDate }}</span>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const rows = document.querySelectorAll('tr[data-href]');
        rows.forEach(row => {
            row.addEventListener('click', function() {
                window.location.href = this.dataset.href;
            });
        });
    });
</script>
