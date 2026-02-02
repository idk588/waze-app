<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Get Directions
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Plan Your Route</h3>
                    
                    <div class="mb-4">
                        <label for="origin" class="block text-sm font-medium text-gray-700 mb-2">From:</label>
                        <input id="origin" type="text" placeholder="Enter starting location" 
                               class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="destination" class="block text-sm font-medium text-gray-700 mb-2">To:</label>
                        <input id="destination" type="text" placeholder="Enter destination" 
                               class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <button onclick="calculateRoute()" 
                            class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 font-semibold">
                        Get Directions
                    </button>

                    <div id="routeInfo" class="mt-4 p-4 bg-gray-50 rounded hidden">
                        <h4 class="font-semibold mb-2">Route Information:</h4>
                        <p id="distance" class="text-sm text-gray-700"></p>
                        <p id="duration" class="text-sm text-gray-700"></p>
                    </div>
                </div>
            </div>

            <!-- Map with directions -->
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div id="directionsMap" style="height: 600px; width: 100%;"></div>
            </div>
        </div>
    </div>

    <script>
        let map, directionsService, directionsRenderer;
        let originAutocomplete, destinationAutocomplete;

        function initDirectionsMap() {
            const malta = { lat: 35.9, lng: 14.5 };
            
            map = new google.maps.Map(document.getElementById('directionsMap'), {
                zoom: 12,
                center: malta
            });

            directionsService = new google.maps.DirectionsService();
            directionsRenderer = new google.maps.DirectionsRenderer();
            directionsRenderer.setMap(map);

            // Autocomplete for origin
            originAutocomplete = new google.maps.places.Autocomplete(
                document.getElementById('origin'),
                { componentRestrictions: { country: 'mt' } }
            );

            // Autocomplete for destination
            destinationAutocomplete = new google.maps.places.Autocomplete(
                document.getElementById('destination'),
                { componentRestrictions: { country: 'mt' } }
            );
        }

        function calculateRoute() {
            const origin = document.getElementById('origin').value;
            const destination = document.getElementById('destination').value;

            if (!origin || !destination) {
                alert('Please enter both origin and destination');
                return;
            }

            const request = {
                origin: origin,
                destination: destination,
                travelMode: google.maps.TravelMode.DRIVING
            };

            directionsService.route(request, (result, status) => {
                if (status === 'OK') {
                    directionsRenderer.setDirections(result);
                    
                    // Display route info
                    const route = result.routes[0].legs[0];
                    document.getElementById('distance').textContent = 
                        `Distance: ${route.distance.text}`;
                    document.getElementById('duration').textContent = 
                        `Duration: ${route.duration.text}`;
                    document.getElementById('routeInfo').classList.remove('hidden');
                } else {
                    alert('Could not calculate route: ' + status);
                }
            });
        }

        // Load Google Maps with Places library
        (function() {
            const script = document.createElement('script');
            script.src = 'https://maps.googleapis.com/maps/api/js?key={{ env("GOOGLE_MAPS_API_KEY") }}&libraries=places&callback=initDirectionsMap';
            script.async = true;
            script.defer = true;
            document.head.appendChild(script);
        })();
    </script>
</x-app-layout>
