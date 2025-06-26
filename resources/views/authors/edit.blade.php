@extends('layouts.app')

@section('content')
<a href="{{ url()->previous() }}" class="btn btn-outline-secondary mt-2 mb-3">← Back</a>
<h2>Edit Author</h2>
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<form method="POST" action="{{ route('authors.update', $author->id) }}">
    @csrf @method('PUT')
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" value="{{ $author->name }}" class="form-control">
        @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
    <button class="btn btn-primary">Update</button>
</form>
@endsection
