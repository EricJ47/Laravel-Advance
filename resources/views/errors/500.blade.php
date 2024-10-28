@extends('layouts.app')

@section('content')
<div class="container">
    <div class="alert alert-warning">
        <h4 class="alert-heading">Oops!</h4>
        <p>{{ $message }}</p>
    </div>
    <a href="{{ route('dashboard') }}" class="btn btn-primary">Kembali ke Dashboard</a>
</div>
@endsection