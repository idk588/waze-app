<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Report
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('reports.update', $report) }}" id="reportForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="type" class="block text-sm font-medium text-gray-700">Report Type</label>
                            <select id="type" name="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="accident" {{ $report->type == 'accident' ? 'selected' : '' }}>🚗 Accident</option>
                                <option value="hazard" {{ $report->type == 'hazard' ? 'selected' : '' }}>⚠️ Hazard</option>
                                <option value="police" {{ $report->type == 'police' ? 'selected' : '' }}>👮 Police</option>
                                <option value="closure" {{ $report->type == 'closure' ? 'selected' : '' }}>🚧 Road Closure</option>
                            </select>
                            @error('type')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                            <input id="location" type="text" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" 
                                   placeholder="Start typing address in Malta..." required>
                            <p class="mt-1 text-xs text-gray-500">Start typing to search for a new location</p>
                            @error('latitude')
                                <p class="mt-2 text-sm text-red-600">Please select a valid location</p>
                            @enderror
                        </div>

                        <!-- Hidden fields for coordinates -->
                        <input type="hidden" id="latitude" name="latitude" value="{{ $report->latitude }}" required>
                        <input type="hidden" id="longitude" name="longitude" value="{{ $report->longitude }}" required>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Current Location</label>
                            <div id="map" style="height: 300px; width: 100%; border-radius: 8px;"></div>
                            <p class="mt-1 text-xs text-gray-500">Current: {{ number_format($report->latitude, 6) }}, {{ number_format($report->longitude, 6) }}</p>
                        </div>

                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea id="description" name="description" rows="4" 
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" 
                                      required>{{ $report->description }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500">
                                Update Report
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

    <script>
        let map, marker, autocomplete;
        
        // Current location from database
        const currentLocation = {
            lat: {{ $report->latitude }},
            lng: {{ $report->longitude }}
        };

        function initMap() {
            // Initialize map centered on current report location
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 16,
                center: currentLocation
            });

            // Add marker at current location
            marker = new google.maps.Marker({
                position: currentLocation,
                map: map,
                draggable: false
            });

            // Initialize autocomplete for Malta only
            autocomplete = new google.maps.places.Autocomplete(
                document.getElementById('location'),
                {
                    componentRestrictions: { country: 'mt' },
                    fields: ['geometry', 'name', 'formatted_address']
                }
            );

            // When user selects a new place
            autocomplete.addListener('place_changed', function() {
                const place = autocomplete.getPlace();

                if (!place.geometry) {
                    alert('Please select a valid location from the dropdown');
                    return;
                }

                const location = place.geometry.location;
                
                // Update hidden fields
                document.getElementById('latitude').value = location.lat();
                document.getElementById('longitude').value = location.lng();

                // Update map
                map.setCenter(location);
                map.setZoom(16);

                // Update marker
                marker.setPosition(location);
                marker.setAnimation(google.maps.Animation.DROP);
            });
        }

        // Validate form before submit
        document.getElementById('reportForm').addEventListener('submit', function(e) {
            const lat = document.getElementById('latitude').value;
            const lng = document.getElementById('longitude').value;
            
            if (!lat || !lng) {
                e.preventDefault();
                alert('Please ensure location is set');
                return false;
            }
        });

        // Load Google Maps with Places library
        (function() {
            const script = document.createElement('script');
            script.src = 'https://maps.googleapis.com/maps/api/js?key={{ env("GOOGLE_MAPS_API_KEY") }}&libraries=places&callback=initMap';
            script.async = true;
            script.defer = true;
            document.head.appendChild(script);
        })();
    </script>
</x-app-layout>
