<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h4 class="font-semibold text-lg mb-2">Your Reports:</h4>
                    <p class="text-3xl font-bold text-blue-600">{{ Auth::user()->reports->count() }}</p>
                </div>
                
                <div class="bg-green-50 p-4 rounded-lg">
                    <h4 class="font-semibold text-lg mb-2">Total Reports:</h4>
                    <p class="text-3xl font-bold text-green-600">{{ \App\Models\Report::count() }}</p>
                </div>
            </div>
</x-app-layout>
