<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                🚗 Traffic Reports
            </h2>
            @auth
                <a href="{{ route('reports.create') }}" 
                class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-semibold hover:bg-blue-700">
                    + New Report
                </a>
            @endauth
        </div>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Map Container -->
            <div class="mb-6 bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div id="map" style="height: 500px; width: 100%;"></div>
            </div>

            @auth
                <div class="mb-6">
                    <a href="{{ route('reports.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                        + New Report
                    </a>
                </div>
            @endauth

            <h3 class="text-lg font-semibold mb-4">All Reports</h3>

            @if($reports->count() > 0)
                @foreach($reports as $report)
                    <div class="bg-white shadow-sm sm:rounded-lg mb-6 overflow-hidden">
                        <div class="p-6 border-b border-gray-200">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-xl font-bold text-gray-900">
                                    {{ ucfirst($report->type) }}
                                </h3>
                                <span class="text-sm text-gray-500">
                                    {{ $report->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <p class="text-gray-700 mb-3">{{ $report->description }}</p>
                            <div class="flex gap-4 text-sm text-gray-500 mb-3">
                                <span>📍 {{ number_format($report->latitude, 4) }}, {{ number_format($report->longitude, 4) }}</span>
                                <span>👤 {{ $report->user->name }}</span>
                                <span>✓ {{ $report->confirmations->count() }} confirmations</span>
                            </div>
                            <div class="mt-4 flex gap-2">
                                <a href="{{ route('reports.show', $report) }}" 
                                   class="text-blue-600 hover:text-blue-900 font-medium">View Details</a>
                                @auth
                                    @if($report->user_id === auth()->id())
                                        <a href="{{ route('reports.edit', $report) }}" 
                                           class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                        <form method="POST" action="{{ route('reports.destroy', $report) }}" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 font-medium" 
                                                    onclick="return confirm('Delete?')">Delete</button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="bg-white shadow-sm sm:rounded-lg p-12 text-center">
                    <p class="text-gray-500 text-lg">No active reports yet.</p>
                    @auth
                        <a href="{{ route('reports.create') }}" class="mt-4 inline-block bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700">
                            Be the first to report!
                        </a>
                    @endauth
                </div>
            @endif
        </div>
    </div>

    <script>
        function initMap() {
            // Center on Malta
            const center = { lat: 35.9, lng: 14.5 };
            
            const map = new google.maps.Map(document.getElementById('map'), {
                zoom: 11,
                center: center
            });

            // Add markers for all reports
            const reports = @json($reports);
            
            if (reports.length === 0) {
                // No reports, just show Malta
                return;
            }

            reports.forEach(report => {
                const marker = new google.maps.Marker({
                    position: { 
                        lat: parseFloat(report.latitude), 
                        lng: parseFloat(report.longitude) 
                    },
                    map: map,
                    title: report.type.toUpperCase(),
                    icon: getMarkerIcon(report.type)
                });

                const infoWindow = new google.maps.InfoWindow({
                    content: `
                        <div style="padding: 10px; min-width: 200px;">
                            <h3 style="font-weight: bold; margin-bottom: 8px; font-size: 16px;">${report.type.toUpperCase()}</h3>
                            <p style="margin-bottom: 8px; color: #333;">${report.description}</p>
                            <p style="font-size: 12px; color: #666; margin-bottom: 8px;">Reported by ${report.user.name}</p>
                            <p style="font-size: 12px; color: #666; margin-bottom: 8px;">✓ ${report.confirmations.length} confirmations</p>
                            <a href="/reports/${report.id}" style="color: #2563eb; text-decoration: underline; font-weight: 500;">View Details →</a>
                        </div>
                    `
                });

                marker.addListener('click', () => {
                    infoWindow.open(map, marker);
                });
            });
        }

        function getMarkerIcon(type) {
            const colors = {
                'accident': 'http://maps.google.com/mapfiles/ms/icons/red-dot.png',
                'hazard': 'http://maps.google.com/mapfiles/ms/icons/yellow-dot.png',
                'police': 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png',
                'closure': 'http://maps.google.com/mapfiles/ms/icons/orange-dot.png'
            };
            return colors[type] || 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
        }

        // Load Google Maps API and initialize
        (function() {
            const script = document.createElement('script');
            script.src = 'https://maps.googleapis.com/maps/api/js?key={{ env("GOOGLE_MAPS_API_KEY") }}&callback=initMap';
            script.async = true;
            script.defer = true;
            document.head.appendChild(script);
        })();
    </script>
</x-app-layout>
