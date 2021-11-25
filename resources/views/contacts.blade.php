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
                            <th>{{ __('name') }}</th>
                            <th>{{ __('birthday') }}</th>
                            <th>{{ __('telephone') }}</th>
                            <th>{{ __('address') }}</th>
                            <th>{{ __('credit_card') }}</th>
                            <th>{{ __('franchise') }}</th>
                            <th>{{ __('email') }}</th>
                        </tr>
                        <tbody>
                        @foreach($contacts as $contact)
                            <tr>
                                <td>{{ $contact['name'] }}</td>
                                <td>{{ $contact['birthday'] }}</td>
                                <td>{{ $contact['telephone'] }}</td>
                                <td>{{ $contact['address'] }}</td>
                                <td>{{ $contact['credit_card'] }}</td>
                                <td>{{ $contact['franchise'] }}</td>
                                <td>{{ $contact['email'] }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
