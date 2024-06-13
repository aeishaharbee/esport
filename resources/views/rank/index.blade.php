<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Team Rankings') }}
        </h2>
    </x-slot> --}}

    <x-slot name="title">
        {{ $title = 'Ranks' }}
    </x-slot>

    <div class="container mx-auto mt-8 flex flex-col justify-center items-center">
        @foreach ($categories as $category)
            @if ($category->id == 1)
                <img src="{{ asset('assets/images/mlbb.png') }}" alt="" class=" max-w-52 h-auto mx-auto mb-3">
            @elseif ($category->id == 2)
                <img src="{{ asset('assets/images/pubg.png') }}" alt="" class=" max-w-52 h-auto mx-auto mb-3">
            @elseif ($category->id == 3)
                <img src="{{ asset('assets/images/valo.png') }}" alt="" class=" max-w-52 h-auto mx-auto mb-3">
            @else
                <img src="{{ asset('assets/images/lol.png') }}" alt="" class=" max-w-52 h-auto mx-auto mb-3">
            @endif

            {{-- <h1 class="text-2xl font-bold mb-6 text-center text-white">{{ $category->name }}</h1> --}}
            @if ($teamsByCategory[$category->name]->isEmpty())
                <p class="text-gray-300 text-center pb-20">No teams found in this category.</p>
            @else
                <table
                    class="sm:min-w-[80vw] min-w-full bg-indigo-950 mb-20 sm:rounded-2xl text-gray-100 shadow shadow-white overflow-hidden">
                    <thead>
                        <tr>
                            <th class="py-2">Rank</th>
                            <th class="py-2">Name</th>
                            <th class="py-2">Win</th>
                            <th class="py-2">Lose</th>
                            <th class="py-2">Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($teamsByCategory[$category->name] as $index => $team)
                            <tr class="cursor-pointer border-t hover:bg-indigo-900 hover:text-lime-300"
                                data-href="{{ route('team.details', $team->id) }}">
                                <td class="py-2 text-center">{{ $team->rank }}</td>
                                <td class="py-2  flex items-center justify-start relative"><img
                                        src="{{ asset($team->logo) }}"
                                        class="lg:max-w-20 md:max-w-14 max-w-10 inline-block mr-6" alt=""><span
                                        class="">{{ $team->name }}</span>
                                </td>
                                <td class="py-2 text-center">{{ $team->win }}</td>
                                <td class="py-2 text-center">{{ $team->lost }}</td>
                                <td class="py-2 text-center">{{ $team->score }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        @endforeach
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
