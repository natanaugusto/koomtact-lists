<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Contacts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="table-auto">
                        <tr>
                            <th>{{ __('hash') }}</th>
                            <th>{{ __('path') }}</th>
                            <th>{{ __('type') }}</th>
                            <th>{{ __('created_at') }}</th>
                            <th>{{ __('updated_at') }}</th>
                            <th>{{ __('logs') }}</th>
                        </tr>
                        <tbody>
                        @foreach($files as $file)
                            <tr>
                                <td>{{ $file->hash }}</td>
                                <td>{{ $file->path }}</td>
                                <td>{{ $file->type }}</td>
                                <td>{{ $file->created_at }}</td>
                                <td>{{ $file->updated_at }}</td>
                                <td>
                                    <table class="table-auto">
                                        <tr>
                                            <th>{{ __('exception') }}</th>
                                            <th>{{ __('log') }}</th>
                                        </tr>
                                        <tbody>
                                        @foreach($file->logs as $log)
                                            <td>{{ $log->exception }}</td>
                                            <td>{{ $log->log }}</td>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
