<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Traffic Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('reports.store') }}">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="type" class="block text-sm font-medium text-gray-700">Report Type</label>
                            <select id="type" name="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="accident">🚗 Accident</option>
                                <option value="hazard">⚠️ Hazard</option>
                                <option value="police">👮 Police</option>
                                <option value="closure">🚧 Road Closure</option>
                            </select>
                            @error('type')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="latitude" class="block text-sm font-medium text-gray-700">Latitude</label>
                            <input id="latitude" name="latitude" type="number" step="any" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" 
                                   placeholder="35.8999" required>
                            @error('latitude')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="longitude" class="block text-sm font-medium text-gray-700">Longitude</label>
                            <input id="longitude" name="longitude" type="number" step="any" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" 
                                   placeholder="14.5120" required>
                            @error('longitude')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea id="description" name="description" rows="4" 
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" 
                                      placeholder="Describe the issue..." required></textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500">
                                Submit Report
                            </button>
                            <a href="{{ route('reports.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
