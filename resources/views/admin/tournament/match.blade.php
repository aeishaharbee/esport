<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('admin.tournament.details', ['tournament' => $tournament]) }}"
            class="font-semibold text-2xl text-gray-200 leading-tight text-center">
            Assign Match for {{ $tournament->name }}
        </a>
    </x-slot>

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

    @if ($errors->any())
        <div class="pt-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-red-500 text-white p-4 rounded mb-4 overflow-hidden shadow-sm sm:rounded-lg">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-indigo-950 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.tournament.match.store', $tournament->id) }}">
                    @csrf
                    @method('post')
                    <div class="mb-4">
                        <label for="team1Id" class="block text-gray-300 text-sm font-bold mb-2">Select Team 1:</label>
                        <select name="team1Id" id="team1Id"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="" selected disabled>Team 1</option>
                            @foreach ($teams as $team)
                                <option value="{{ $team->id }}">{{ $team->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="team2Id" class="block text-gray-300 text-sm font-bold mb-2">Select Team 2:</label>
                        <select name="team2Id" id="team2Id"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="" selected disabled>Team 2</option>
                            @foreach ($teams as $team)
                                <option value="{{ $team->id }}">{{ $team->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="time" class="block text-gray-300 text-sm font-bold mb-2">Select Time:</label>
                        <input type="datetime-local" name="time" id="time" required
                            min="{{ date('Y-m-d\TH:i', strtotime($tournament->startDate . ' 00:00')) }}"
                            max="{{ date('Y-m-d\TH:i', strtotime($tournament->endDate . ' 23:59')) }}">
                    </div>
                    <div class="mb-4">
                        <label for="levelId" class="block text-gray-300 text-sm font-bold mb-2">Select Team 2:</label>
                        <select name="levelId" id="levelId"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="" selected disabled>Level</option>
                            @foreach ($levels as $level)
                                <option value="{{ $level->id }}">{{ $level->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class=" flex items-center justify-end gap-x-6">
                        <a href="{{ route('admin.tournament.details', ['tournament' => $tournament]) }}"
                            class="text-sm font-semibold leading-6 text-gray-100">Cancel</a>
                        <button type="submit"
                            class="rounded-md bg-lime-300 px-3 py-2 text-sm font-semibold text-indigo-950 shadow-sm hover:bg-lime-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-lime-600">
                            Assign Match
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</x-app-layout>
