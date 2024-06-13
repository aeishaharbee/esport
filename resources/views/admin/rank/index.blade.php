<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Team Rankings') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-8">
        @foreach ($categories as $category)
            <h1 class="text-2xl font-bold mb-6 text-center">{{ $category->name }}</h1>
            @if ($teamsByCategory[$category->name]->isEmpty())
                <p class="text-gray-700 text-center pb-12">No teams found in this category.</p>
            @else
                <table class="min-w-full bg-white mb-12">
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
                            <tr class="cursor-pointer bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                                data-href="{{ route('admin.team.details', $team->id) }}">
                                <td class="py-2 text-center">{{ $index + 1 }}</td>
                                <td class="py-2  flex items-center justify-start relative"><img
                                        src="{{ asset($team->logo) }}"
                                        class="lg:max-w-20 md:max-w-14 max-w-10 inline-block mr-6" alt=""><span
                                        class=" self-center">{{ $team->name }}</span>
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
