@extends('layouts.app')

@section('content')
<div class="container">
    <div class="alert alert-danger">
        <h4 class="alert-heading">Error!</h4>
        <p>{{ $message }}</p>
        @if(config('app.debug'))
            <hr>
            <p class="mb-0">File: {{ $file }}</p>
            <p class="mb-0">Line: {{ $line }}</p>
        @endif
    </div>
    <a href="{{ route('dashboard') }}" class="btn btn-primary">Coba Lagi</a>
</div>
@endsection