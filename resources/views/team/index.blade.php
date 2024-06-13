<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-200 leading-tight text-center">
            {{ __('My Team Dashboard') }}
        </h2>
    </x-slot>

    <x-slot name="title">
        {{ $title = 'My Team' }}
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


    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex justify-center flex-col">
            @if (Auth::user())
                <a href="{{ route('team.create') }}"
                    class="transition ease-in-out delay-100 hover:-translate-y-1 hover:scale-105 duration-300 text-indigo-950 inline-flex mx-auto justify-center bg-lime-300 hover:bg-lime-500 focus:ring-4 focus:outline-none focus:ring-lime-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">
                    Register Your Team
                </a>
            @else
                <h2 class="font-semibold text-xl text-gray-200 leading-tight p-6 text-center">
                    Want to create a team? Register an account first.
                </h2>
            @endif

            @if ($teams->isEmpty())
                @if (Auth::user())
                    <h2 class="font-semibold text-xl text-gray-200 leading-tight p-6 text-center">
                        You have not registered any teams yet.
                    </h2>
                @else
                    <div class="p-6 flex justify-center">
                        <a href="{{ route('register') }}"
                            class="transition ease-in-out delay-100 hover:-translate-y-1 hover:scale-105 duration-300 text-indigo-950 inline-flex mx-auto justify-center bg-lime-300 hover:bg-lime-500 focus:ring-4 focus:outline-none focus:ring-lime-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">
                            Register an Account
                        </a>
                    </div>
                @endif
            @endif
        </div>
    </div>



    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg flex flex-wrap">
                @foreach ($teams as $team)
                    <div
                        class="max-w-72 mx-auto flex flex-col items-start justify-between bg-indigo-950 border border-gray-200 rounded-lg shadow mb-5">
                        <a href="{{ route('team.details', $team->id) }}">
                            <div>
                                <img class="rounded-t-lg" src="{{ asset($team->logo) }}" alt="" />

                                <div class="p-5">
                                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-white">
                                        {{ $team->name }}</h5>
                                    <p class="mb-2 text-xl font-bold tracking-tight text-white">
                                        {{ $team->category->name }}</p>
                                </div>

                            </div>
                        </a>

                        <div class="px-5 pb-5 flex justify-around w-full">

                            <a href=" {{ route('team.details', $team->id) }}"
                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-indigo-950 bg-lime-300 rounded-lg hover:bg-lime-500 focus:ring-4 focus:outline-none focus:ring-lime-100 ">
                                Details
                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </a>


                            <button data-modal-target="popup-modal-{{ $team->id }}"
                                data-modal-toggle="popup-modal-{{ $team->id }}"
                                class="inline-block text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
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
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                        <div class="p-4 md:p-5 text-center">
                                            <svg class="mx-auto mb-4 text-gray-200 w-12 h-12 " aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
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
                                            <button data-modal-hide="popup-modal-{{ $team->id }}" type="button"
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
        </div>
    </div>
</x-app-layout>
