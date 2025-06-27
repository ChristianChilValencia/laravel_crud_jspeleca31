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
        <div class="genre-chips d-flex flex-wrap gap-2 mb-2">
            @foreach($genres as $genre)
                <div class="genre-chip">
                    <input type="checkbox" name="genres[]" value="{{ $genre->id }}" 
                           id="genre{{ $genre->id }}" class="btn-check"
                           {{ $book->genres->contains($genre->id) ? 'checked' : '' }}>
                    <label for="genre{{ $genre->id }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                        {{ $genre->name }}
                    </label>
                </div>
            @endforeach
        </div>
        @error('genres') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <button class="btn btn-primary">Update</button>
</form>

<style>
    .genre-chip input[type="checkbox"]:checked + label {
        background-color: var(--goodreads-brown);
        color: white;
        border-color: var(--goodreads-brown);
    }
    .genre-chip label:hover {
        background-color: var(--goodreads-brown);
        color: white;
        border-color: var(--goodreads-brown);
    }
</style>
@endsection
