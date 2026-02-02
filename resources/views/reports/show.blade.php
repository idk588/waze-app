<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Report Details
        </h2>
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

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="p-6">
                    <h3 class="text-2xl font-bold mb-4">{{ ucfirst($report->type) }}</h3>
                    
                    <div class="mb-4">
                        <p class="text-gray-700">{{ $report->description }}</p>
                    </div>
                    
                    <div class="mb-4 text-sm text-gray-600">
                        <p><strong>Location:</strong> {{ $report->latitude }}, {{ $report->longitude }}</p>
                        <p><strong>Reported by:</strong> {{ $report->user->name }}</p>
                        <p><strong>Reported:</strong> {{ $report->created_at->format('M d, Y h:i A') }}</p>
                        <p><strong>Confirmations:</strong> {{ $report->confirmations->count() }} 👍</p>
                    </div>

                    @auth
                        @if($report->user_id !== auth()->id())
                            <form method="POST" action="{{ route('reports.confirm', $report) }}" class="mb-4">
                                @csrf
                                <input type="hidden" name="is_helpful" value="1">
                                <button type="submit" class="bg-green-600 text-black px-4 py-2 rounded hover:bg-green-700">
                                     Confirm Report
                                </button>
                            </form>
                        @endif
                        
                        @if($report->user_id === auth()->id())
                            <div class="flex gap-2">
                                <a href="{{ route('reports.edit', $report) }}" 
                                   class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">Edit</a>
                                <form method="POST" action="{{ route('reports.destroy', $report) }}" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700" 
                                            onclick="return confirm('Delete this report?')">Delete</button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>

            <a href="{{ route('reports.index') }}" class="mt-4 inline-block text-blue-600 hover:underline">← Back to Reports</a>
        </div>
    </div>
</x-app-layout>
