<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-200 leading-tight">
            {{ __('Create Tournament') }}
        </h2>
    </x-slot>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-indigo-950 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    @if ($errors->any())
                        <ul class="mb-10 text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif

                    <form method="POST" action="{{ route('admin.tournament.store') }}" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <div class="space-y-12">
                            <div class="border-b border-gray-900/10 pb-12">
                                <h2 class="text-base font-semibold leading-7 text-gray-100">Add a New Tournament</h2>
                                <p class="mt-1 text-sm leading-6 text-gray-300">Create a new tournament to attract more
                                    players.</p>

                                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                                    <div class="mb-4 col-span-full">
                                        <label for="logo" class="block text-gray-100 text-sm font-bold mb-2">Cover
                                            Photo</label>
                                        <div class="bg-white p-7 rounded sm:w-8/12 " x-data="dataFileDnD()">
                                            <div x-ref="dnd"
                                                class="relative flex flex-col text-gray-500 border border-gray-200 border-dashed rounded cursor-pointer">
                                                <input accept="image/*" type="file" name="image"
                                                    class="absolute inset-0 z-50 w-full h-full p-0 m-0 outline-none opacity-0 cursor-pointer"
                                                    @change="addFiles($event)"
                                                    @dragover="$refs.dnd.classList.add('border-blue-400'); $refs.dnd.classList.add('ring-4'); $refs.dnd.classList.add('ring-inset');"
                                                    @dragleave="$refs.dnd.classList.remove('border-blue-400'); $refs.dnd.classList.remove('ring-4'); $refs.dnd.classList.remove('ring-inset');"
                                                    @drop="$refs.dnd.classList.remove('border-blue-400'); $refs.dnd.classList.remove('ring-4'); $refs.dnd.classList.remove('ring-inset');"
                                                    title="" />

                                                <div class="flex flex-col items-center justify-center py-10 text-center"
                                                    x-show="!file">
                                                    <svg class="w-4 h-4 mr-1 text-current-50"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    <p class="m-0">Drag your files here or click in this area.</p>
                                                </div>

                                                <template x-if="file">
                                                    <div class="relative flex flex-col items-center overflow-hidden text-center bg-gray-100 border rounded cursor-move select-none"
                                                        style=" height: 200px;">
                                                        <button
                                                            class="absolute top-0 right-0 z-50 p-1 bg-white rounded-bl focus:outline-none"
                                                            type="button" @click="remove()">
                                                            <svg class="w-4 h-4 text-gray-700"
                                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                        <img class="absolute inset-0 z-0 object-cover w-full h-full border-4 border-white preview"
                                                            x-bind:src="loadFile(file)" />
                                                        <div
                                                            class="absolute bottom-0 left-0 right-0 flex flex-col p-2 text-xs bg-white bg-opacity-50">
                                                            <span class="w-full font-bold text-gray-900 truncate"
                                                                x-text="file.name">Loading</span>
                                                            <span class="text-xs text-gray-900"
                                                                x-text="humanFileSize(file.size)">...</span>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="sm:col-span-4">
                                        <label for="email"
                                            class="block text-sm font-medium leading-6 text-gray-100">Name</label>
                                        <div class="mt-2">
                                            <input id="name" name="name" type="text" autocomplete="email"
                                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        </div>
                                    </div>

                                    <div class="col-span-full">
                                        <label for="about"
                                            class="block text-sm font-medium leading-6 text-gray-100">Description</label>
                                        <div class="mt-2">
                                            <input id="desc" name="desc" rows="3"
                                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        </div>
                                        <p class="mt-3 text-sm leading-6 text-gray-300">Write a few sentences about
                                            the tournament.</p>
                                    </div>





                                    <div class="sm:col-span-3">
                                        <label for="first-name"
                                            class="block text-sm font-medium leading-6 text-gray-100">Start Date</label>
                                        <div class="mt-2">
                                            <input type="date" name="startDate" id="startDate" required
                                                min="{{ date('Y-m-d') }}" autocomplete="given-name"
                                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        </div>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="last-name"
                                            class="block text-sm font-medium leading-6 text-gray-100">End Date</label>
                                        <div class="mt-2">
                                            <input type="date" name="endDate" id="endDate"
                                                min="{{ date('Y-m-d') }}" autocomplete="family-name"
                                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        </div>
                                    </div>


                                    <fieldset>
                                        <label for="first-name"
                                            class="block text-sm font-medium leading-6 text-gray-100">Category</label>
                                        <div class="mt-6 space-y-6">
                                            @foreach ($categoryList as $category)
                                                <div class="flex items-center gap-x-3">
                                                    <input id="{{ $category->id }}" name="categoryId" type="radio"
                                                        class="h-4 w-4 border-gray-300 text-lime-400 focus:ring-lime-400"
                                                        value="{{ $category->id }}">
                                                    <label for="push-everything"
                                                        class="block text-sm font-medium leading-6 text-gray-100">{{ $category->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </fieldset>


                                </div>
                            </div>
                        </div>
                        <div class="mt-6 flex items-center justify-end gap-x-6">
                            <a href="{{ route('admin.tournament.index') }}" type="button"
                                class="text-sm font-semibold leading-6 text-gray-100">Cancel</a>
                            <input type="submit"
                                class="rounded-md bg-lime-300 px-3 py-2 text-sm font-semibold text-indigo-950 shadow-sm hover:bg-lime-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-lime-600"
                                value="Save">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://unpkg.com/create-file-list"></script>
<script>
    function dataFileDnD() {
        return {
            file: null,
            fileDragging: null,
            fileDropping: null,
            humanFileSize(size) {
                const i = Math.floor(Math.log(size) / Math.log(1024));
                return (
                    (size / Math.pow(1024, i)).toFixed(2) * 1 +
                    " " + ["B", "kB", "MB", "GB", "TB"][i]
                );
            },
            remove() {
                this.file = null;
            },
            loadFile(file) {
                const preview = document.querySelector(".preview");
                const blobUrl = URL.createObjectURL(file);

                preview.onload = () => {
                    URL.revokeObjectURL(preview.src); // free memory
                };

                return blobUrl;
            },
            addFiles(e) {
                const files = e.target.files;
                if (files.length > 0) {
                    this.file = files[0];
                }
            }
        };
    }
</script>
