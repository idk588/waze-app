<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Traffic Report
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('reports.store') }}" id="reportForm">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="type" class="block text-sm font-medium text-gray-700">Report Type</label>
                            <select id="type" name="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="accident">Accident</option>
                                <option value="hazard">Hazard</option>
                                <option value="police">Police</option>
                                <option value="closure">Road Closure</option>
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
                            <p class="mt-1 text-xs text-gray-500">Start typing to search for a location</p>
                            @error('latitude')
                                <p class="mt-2 text-sm text-red-600">Please select a valid location</p>
                            @enderror
                        </div>

                        <!-- Hidden fields for coordinates -->
                        <input type="hidden" id="latitude" name="latitude" required>
                        <input type="hidden" id="longitude" name="longitude" required>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Selected Location Preview</label>
                            <div id="map" style="height: 300px; width: 100%; border-radius: 8px;"></div>
                        </div>

                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea id="description" name="description" rows="4" 
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" 
                                      placeholder="Describe what happened..." required></textarea>
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

    <script>
        let map, marker, autocomplete;

        function initMap() {
            // Center on Malta
            const malta = { lat: 35.9, lng: 14.5 };
            
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 13,
                center: malta
            });

            // Initialize autocomplete for Malta only
            autocomplete = new google.maps.places.Autocomplete(
                document.getElementById('location'),
                {
                    componentRestrictions: { country: 'mt' },
                    fields: ['geometry', 'name', 'formatted_address']
                }
            );

            // When user selects a place
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

                // Add/update marker
                if (marker) {
                    marker.setPosition(location);
                } else {
                    marker = new google.maps.Marker({
                        position: location,
                        map: map,
                        animation: google.maps.Animation.DROP
                    });
                }
            });
        }

        // Validate form before submit
        document.getElementById('reportForm').addEventListener('submit', function(e) {
            const lat = document.getElementById('latitude').value;
            const lng = document.getElementById('longitude').value;
            
            if (!lat || !lng) {
                e.preventDefault();
                alert('Please select a location from the autocomplete dropdown');
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
