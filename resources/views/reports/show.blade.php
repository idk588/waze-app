@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Report Details</h1>
    
    <div class="card">
        <div class="card-body">
            <h5>{{ ucfirst($report->type) }}</h5>
            <p><strong>Location:</strong> {{ $report->latitude }}, {{ $report->longitude }}</p>
            <p>{{ $report->description }}</p>
            <p><small>By {{ $report->user->name }} on {{ $report->created_at }}</small></p>
            
            @auth
                @if($report->user_id == auth()->id())
                    <a href="{{ route('reports.edit', $report) }}" class="btn btn-warning">Edit</a>
                    <form method="POST" action="{{ route('reports.destroy', $report) }}" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Delete?')">Delete</button>
                    </form>
                @endif
            @endauth
        </div>
    </div>
    
    <a href="{{ route('reports.index') }}" class="btn btn-primary mt-3">Back to Reports</a>
</div>
@endsection
