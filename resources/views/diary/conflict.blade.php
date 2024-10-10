<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Conflicting Emotions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-xl font-bold mb-4">{{ __('Summary') }}</h3>

                    @if($conflictingEntries->isEmpty())
                        <p>No conflicting emotions found.</p>
                    @else
                        <table class="table-auto w-full">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">ID</th>
                                    <th class="px-4 py-2">Date</th>
                                    <th class="px-4 py-2">Content</th>
                                    <th class="px-4 py-2">Emotion</th>
                                    <th class="px-4 py-2">Intensity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($conflictingEntries as $entry)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $entry->id }}</td>
                                        <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($entry->date)->format('F j, Y') }}
                                        </td>
                                        <td class="border px-4 py-2">{{ $entry->content }}</td>
                                        <td class="border px-4 py-2">{{ $entry->emotion_id == 2 ? 'Sad' : 'Unknown' }}</td>
                                        <td class="border px-4 py-2">{{ $entry->intensity }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>