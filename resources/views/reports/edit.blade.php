<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Report
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('reports.update', $report) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                            <select id="type" name="type" class="mt-1 block w-full border-gray-300 rounded-md" required>
                                <option value="accident" {{ $report->type == 'accident' ? 'selected' : '' }}>Accident</option>
                                <option value="hazard" {{ $report->type == 'hazard' ? 'selected' : '' }}>Hazard</option>
                                <option value="police" {{ $report->type == 'police' ? 'selected' : '' }}>Police</option>
                                <option value="closure" {{ $report->type == 'closure' ? 'selected' : '' }}>Closure</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="latitude" class="block text-sm font-medium text-gray-700">Latitude</label>
                            <input id="latitude" name="latitude" type="number" step="any" value="{{ $report->latitude }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md" required>
                        </div>

                        <div class="mb-4">
                            <label for="longitude" class="block text-sm font-medium text-gray-700">Longitude</label>
                            <input id="longitude" name="longitude" type="number" step="any" value="{{ $report->longitude }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md" required>
                        </div>

                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea id="description" name="description" rows="4" 
                                      class="mt-1 block w-full border-gray-300 rounded-md" required>{{ $report->description }}</textarea>
                        </div>

                        <div class="flex gap-4">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                Update Report
                            </button>
                            <a href="{{ route('reports.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
