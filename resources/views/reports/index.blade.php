@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Traffic Reports</h1>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <a href="{{ route('reports.create') }}" class="btn btn-primary mb-3">
        Report Issue (Login required)
    </a>
    
    @if($reports->count())
        @foreach($reports as $report)
            <div class="card mb-3">
                <div class="card-body">
                    <h5>{{ ucfirst($report->type) }} - {{ $report->user->name }}</h5>
                    <p>{{ $report->description }}</p>
                    <small>{{ $report->created_at->diffForHumans() }}</small>
                    <a href="{{ route('reports.show', $report) }}" class="btn btn-sm btn-info">View</a>
                </div>
            </div>
        @endforeach
    @else
        <p>No active reports.</p>
    @endif
</div>
@endsection
