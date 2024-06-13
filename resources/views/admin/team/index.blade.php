<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Team Dashboard') }}
        </h2>
    </x-slot> --}}

    @foreach ($categoryList as $category)
        <div class="pt-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class=" p-4 rounded mb-4 overflow-hidden shadow-sm sm:rounded-lg">
                    {{-- @if ($category->id == 1)
                        <img src="{{ asset('assets/images/mlbb.png') }}" alt=""
                            class=" max-w-52 h-auto mx-auto mb-3">
                    @elseif ($category->id == 2)
                        <img src="{{ asset('assets/images/pubg.png') }}" alt=""
                            class=" max-w-52 h-auto mx-auto mb-3">
                    @elseif ($category->id == 3)
                        <img src="{{ asset('assets/images/valo.png') }}" alt=""
                            class=" max-w-52 h-auto mx-auto mb-3">
                    @else
                        <img src="{{ asset('assets/images/lol.png') }}" alt=""
                            class=" max-w-52 h-auto mx-auto mb-3">
                    @endif --}}
                    <h2 class="font-semibold text-2xl text-gray-100 leading-tight text-center">
                        {{ $category->name }}
                    </h2>
                </div>
            </div>
        </div>
        <div class="pb-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="shadow-sm sm:rounded-lg flex flex-wrap justify-center pb-6">
                    @php
                        $hasTeamsInCategory = $teams->contains(function ($team) use ($category) {
                            return $team->category->name === $category->name;
                        });
                    @endphp

                    @if (!$hasTeamsInCategory)
                        <h2 class="font-semibold text-xl text-gray-300 leading-tight text-center pb-6">
                            No teams in this category.
                        </h2>
                    @endif

                    @foreach ($teams as $team)
                        @if ($category->name === $team->category->name)
                            <div id="{{ $team->category->id }}"
                                class="max-w-52 mx-auto flex flex-col items-start justify-between bg-indigo-950 border border-gray-200 rounded-lg shadow  mb-5 overflow-hidden">

                                <div>
                                    <a href="{{ route('team.details', $team->id) }}" class="">
                                        <div
                                            class="transition ease-in-out delay-50 hover:-translate-y-1 hover:scale-105 hover:shadow-sm hover:shadow-white duration-300 hover:bg-lime-300">
                                            <img class="rounded-t-lg" src="{{ asset($team->logo) }}" alt="" />
                                        </div>
                                    </a>
                                    <div class="p-5">
                                        <h5
                                            class="mb-2 text-2xl font-bold tracking-tight text-white text-center 
                                            ">
                                            {{ $team->name }}</h5>
                                        {{-- <p class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                                            {{ $team->category->name }}</p> --}}
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
                                        Delete
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
                                                        want to delete <span
                                                            class=" font-bold text-lime-300 block">{{ $team->name }}</span>
                                                        team?</h3>
                                                    <form method="POST" class=" inline-block"
                                                        action="{{ route('team.destroy', ['team' => $team]) }}">
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
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach

</x-app-layout>
