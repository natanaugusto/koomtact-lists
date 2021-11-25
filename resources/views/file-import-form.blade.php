<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Import CSV File') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('file.import') }}" enctype="multipart/form-data">
                    @csrf
                    <!-- File -->
                        <div>
                            <x-label for="file" :value="__('File')"/>

                            <x-input id="file" class="block mt-1 w-full" type="file" name="file" required autofocus/>
                        </div>
                        <x-button class="ml-3">
                            {{ __('Import') }}
                        </x-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
