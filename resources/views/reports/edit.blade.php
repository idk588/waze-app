@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Report</h1>
    
    <form method="POST" action="{{ route('reports.update', $report) }}">
        @csrf @method('PUT')
        
        {{-- Same form fields as create, but with values --}}
        <div class="mb-3">
            <label>Type:</label>
            <select name="type" class="form-control" required>
                <option value="accident" {{ $report->type == 'accident' ? 'selected' : '' }}>Accident</option>
                <option value="hazard" {{ $report->type == 'hazard' ? 'selected' : '' }}>Hazard</option>
                <option value="police" {{ $report->type == 'police' ? 'selected' : '' }}>Police</option>
                <option value="closure" {{ $report->type == 'closure' ? 'selected' : '' }}>Road Closure</option>
            </select>
            @error('type') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        
        <div class="mb-3">
            <label>Latitude:</label>
            <input type="number" step="any" name="latitude" value="{{ $report->latitude }}" class="form-control" required>
            @error('latitude') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        
        <div class="mb-3">
            <label>Longitude:</label>
            <input type="number" step="any" name="longitude" value="{{ $report->longitude }}" class="form-control" required>
            @error('longitude') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        
        <div class="mb-3">
            <label>Description:</label>
            <textarea name="description" class="form-control" rows="4" required>{{ $report->description }}</textarea>
            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        
        <button type="submit" class="btn btn-success">Update Report</button>
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
