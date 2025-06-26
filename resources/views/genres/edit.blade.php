@extends('layouts.app')

@section('content')
<a href="{{ url()->previous() }}" class="btn btn-outline-secondary mt-2 mb-3">← Back</a>
<h2>Edit Genre</h2>

<form method="POST" action="{{ route('genres.update', $genre->id) }}">
    @csrf @method('PUT')
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" value="{{ $genre->name }}" class="form-control" required>
    </div>
    <button class="btn btn-primary">Update</button>
</form>
@endsection
