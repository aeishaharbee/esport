<x-app-layout>
    <x-slot name="title">
        {{ $title = 'Home' }}
    </x-slot>

    {{-- <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-200 leading-tight">
            {{ __('Gouest Dashboard') }}
        </h2>
    </x-slot> --}}

    {{-- <div class="pb-12 w-full bg-chair-bg bg-cover relative overflow-hidden"> --}}
    {{-- <img src="{{ asset('assets/images/bg2.webp') }}" alt="" class=""> --}}
    {{-- </div> --}}

    <div
        class="max-h-[30rem] max-w-7xl mx-auto overflow-hidden flex items-center relative rounded-b-lg border-b border-l border-r shadow-lg shadow-white">
        <img src="{{ asset('assets/images/bg.webp') }}" alt="" class=" w-full z-0">
        <div class="w-full h-full absolute bg-opacity-50 bg-gradient-to-r from-slate-700 to-transparent z-10"></div>

        <div class=" z-20 absolute text-center w-full md:w-1/2">
            <h2 class="font-semibold text-3xl md:text-5xl text-lime-300 leading-tight">
                eSportXPert
            </h2>
            <p class="font-normal text-md text-gray-100 leading-tight">
                your no 1 <span class="underline decoration-lime-300 decoration-double">esport tournament</span> buddy
            </p>
        </div>
    </div>

    <div class="pb-12 pt-20">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-3xl text-gray-100 leading-tight text-center">
                Ongoing Tournaments
            </h2>
            <p class="text-gray-300 text-center mt-3">Don't miss the chance to <mark
                    class="px-2 text-indigo-950 bg-lime-300 rounded">prove</mark> your skills!</p>
        </div>
    </div>

    <div id="default-carousel" class="relative xl:max-w-7xl lg:max-w-5xl max-w-3xl mx-auto z-0" data-carousel="slide">
        <!-- Carousel wrapper -->
        <div class="relative h-56 overflow-hidden rounded-lg md:h-[30rem]">
            @foreach ($allActiveTournaments as $tournament)
                <div class="hidden duration-700 ease-in-out group" data-carousel-item>
                    <a href="{{ route('tournament.details', ['tournament' => $tournament]) }}">
                        <img src="{{ asset($tournament->image) }}"
                            class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 blur-none group-hover:blur-sm transition ease-in-out group-hover:scale-105 duration-300"
                            alt="...">
                        {{-- <p
                            class="text-gray-300 text-center mt-3 absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                            {{ $tournament->name }}</p> --}}
                        <h2
                            class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 font-semibold text-3xl text-gray-100 bg-indigo-950 group-hover:bg-opacity-100 bg-opacity-50 group-hover:text-lime-300 leading-tight text-center py-3
                            transition ease-in-out group-hover:scale-105 duration-300">
                            {{ $tournament->name }}
                        </h2>
                    </a>
                </div>
            @endforeach
        </div>
        <!-- Slider indicators -->
        <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
            @for ($i = 0; $i < $countAllActiveTournaments; $i++)
                <button type="button" class="w-3 h-3 rounded-full" aria-current="{{ $i === 0 ? 'true' : 'false' }}"
                    aria-label="Slide 1" data-carousel-slide-to="{{ $i }}"></button>
            @endfor
        </div>
        <!-- Slider controls -->
        <button type="button"
            class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
            data-carousel-prev>
            <span
                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30  group-hover:bg-white/50  group-focus:ring-4 group-focus:ring-lime-300 group-focus:outline-none">
                <svg class="w-4 h-4 text-white rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 1 1 5l4 4" />
                </svg>
                <span class="sr-only">Previous</span>
            </span>
        </button>
        <button type="button"
            class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
            data-carousel-next>
            <span
                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30  group-hover:bg-white/50  group-focus:ring-4 group-focus:ring-lime-300 group-focus:outline-none">
                <svg class="w-4 h-4 text-white rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 9 4-4-4-4" />
                </svg>
                <span class="sr-only">Next</span>
            </span>
        </button>
    </div>

    <div class="pb-12 pt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex justify-center">
            <a href="{{ route('tournament.index') }}" type="button"
                class="inline-block text-lime-300 text-xl hover:bg-lime-300 focus:ring-4 focus:outline-none focus:ring-lime-100 hover:text-indigo-950 border border-lime-300 font-medium rounded-lg px-5 py-2.5 text-center me-2 mb-2 
                        transition ease-in-out hover:-translate-y-1 hover:scale-105 duration-300 hover:shadow-white shadow-sm ">
                View All</a>
        </div>
    </div>

</x-app-layout>
