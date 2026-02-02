@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Traffic Report</h1>
    
    <form method="POST" action="{{ route('reports.store') }}">
        @csrf
        
        <div class="mb-3">
            <label>Type:</label>
            <select name="type" class="form-control" required>
                <option value="accident">Accident</option>
                <option value="hazard">Hazard</option>
                <option value="police">Police</option>
                <option value="closure">Road Closure</option>
            </select>
            @error('type') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        
        <div class="mb-3">
            <label>Latitude:</label>
            <input type="number" step="any" name="latitude" class="form-control" required>
            @error('latitude') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        
        <div class="mb-3">
            <label>Longitude:</label>
            <input type="number" step="any" name="longitude" class="form-control" required>
            @error('longitude') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        
        <div class="mb-3">
            <label>Description:</label>
            <textarea name="description" class="form-control" rows="4" required></textarea>
            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        
        <button type="submit" class="btn btn-success">Submit Report</button>
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
