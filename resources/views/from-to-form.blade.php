<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('From/To CSV File') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('file.from-to', $hash) }}" enctype="multipart/form-data">
                        @method('PUT')
                    @csrf
                        @foreach($to as $column)
                            <div>
                                <x-label for="{{ $column }}" value="{{ $column }}"/>

                                <select id="{{ $column }}" class="block mt-1 w-full" name="{{ $column }}"
                                        required>
                                    @foreach($from as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach
                    <!-- File -->
                        <x-button class="ml-3">
                            {{ __('Import') }}
                        </x-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
