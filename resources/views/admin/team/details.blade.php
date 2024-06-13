<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
            {{ $team->name }}
        </h2>
    </x-slot>

    <img class="h-auto w-auto mx-auto md:max-w-sm max-w-xs " src="{{ asset($team->logo) }}" alt="image description">

    <div class="container mx-auto mt-8">
        <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
            <h3 class="text-xl font-semibold mb-4">Team Information</h3>
            <p><strong>Category:</strong> {{ $team->category->name }}</p>
            <p><strong>Rank:</strong> {{ $rank === false ? '-' : $rank + 1 }}</p>
            <p><strong>Current Score:</strong> {{ $team->score }}</p>
            <p><strong>Wins:</strong> {{ $team->win }}</p>
            <p><strong>Losses:</strong> {{ $team->lost }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
            <h3 class="text-xl font-semibold mb-4">Ongoing Tournaments</h3>
            @if ($ongoingTournaments->isEmpty())
                <p>No ongoing tournaments.</p>
            @else
                @foreach ($ongoingTournaments as $tournament)
                    <div
                        class=" inline-flex max-w-xs flex-col items-start justify-between bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mb-5">

                        <div>
                            <a href="{{ route('admin.tournament.details', ['tournament' => $tournament]) }}">
                                <img class="rounded-t-lg" src="{{ asset($tournament->image) }}" alt="" />
                            </a>
                            <div class="p-5">
                                <a href="{{ route('admin.tournament.details', ['tournament' => $tournament]) }}">
                                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                        {{ $tournament->name }}</h5>
                                </a>
                                </p>
                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                                    {{ $tournament->startDate }}
                                    until
                                    <span>{{ $tournament->endDate }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
            <h3 class="text-xl font-semibold mb-4">Past Tournaments</h3>
            @if ($pastTournaments->isEmpty())
                <p>No past tournaments.</p>
            @else
                @foreach ($pastTournaments as $tournament)
                    <div
                        class=" inline-flex max-w-xs flex-col items-start justify-between bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mb-5">

                        <a href="{{ route('admin.tournament.details', ['tournament' => $tournament]) }}">
                            <div>
                                <img class="rounded-t-lg" src="{{ asset($tournament->image) }}" alt="" />

                                <div class="p-5">
                                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                        {{ $tournament->name }}</h5>
                                    </p>
                                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                                        {{ $tournament->startDate }}
                                        until
                                        <span>{{ $tournament->endDate }}</span>
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</x-app-layout>
