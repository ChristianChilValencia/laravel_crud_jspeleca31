@extends('layouts.app')

@section('content')
<a href="{{ url()->previous() }}" class="btn btn-outline-secondary mt-2 mb-3">← Back</a>
<h2>Edit Book</h2>
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<form method="POST" action="{{ route('books.update', $book->id) }}">
    @csrf @method('PUT')

    <div class="mb-3">
        <label>Title</label>
        <input type="text" name="title" value="{{ $book->title }}" class="form-control">
         @error('title') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label>Author</label>
        <select name="author_id" class="form-control" required>
            @foreach($authors as $author)
                <option value="{{ $author->id }}" {{ $book->author_id == $author->id ? 'selected' : '' }}>
                    {{ $author->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Genres</label>
        <select name="genres[]" class="form-control" multiple>
            @foreach($genres as $genre)
                <option value="{{ $genre->id }}" {{ $book->genres->contains($genre->id) ? 'selected' : '' }}>
                    {{ $genre->name }}
                </option>
            @endforeach
        </select>
    </div>

    <button class="btn btn-primary">Update</button>
</form>
@endsection
