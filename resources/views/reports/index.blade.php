<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Traffic Reports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @auth
                <div class="mb-6">
                    <a href="{{ route('reports.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                        + New Report
                    </a>
                </div>
            @endauth

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
                            <div class="flex gap-2 text-sm text-gray-500">
                                <span>📍 {{ $report->latitude }}, {{ $report->longitude }}</span>
                                <span>👤 {{ $report->user->name }}</span>
                            </div>
                            <div class="mt-4 flex gap-2">
                                <a href="{{ route('reports.show', $report) }}" 
                                   class="text-blue-600 hover:text-blue-900 font-medium">View</a>
                                @auth
                                    @if($report->user_id === auth()->id())
                                        <a href="{{ route('reports.edit', $report) }}" 
                                           class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                        <form method="POST" action="{{ route('reports.destroy', $report) }}" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 font-medium" 
                                                    onclick="return confirm('Delete this report?')">Delete</button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-12">
                    <p class="text-gray-500 text-lg">No active reports yet.</p>
                    @auth
                        <a href="{{ route('reports.create') }}" class="mt-4 inline-block bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold">
                            Be the first to report!
                        </a>
                    @endauth
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
