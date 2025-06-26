@extends('layouts.app')

@section('content')
<a href="{{ url()->previous() }}" class="btn btn-outline-secondary mt-2 mb-3">← Back</a>
<h2>Add New Author</h2>
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<form method="POST" action="{{ route('authors.store') }}">
    @csrf
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control">
        @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
    <button class="btn btn-success">Save</button>
</form>
@endsection
