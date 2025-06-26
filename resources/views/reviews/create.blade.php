@extends('layouts.app')

@section('content')
<a href="{{ url()->previous() }}" class="btn btn-outline-secondary mt-2 mb-3">← Back</a>
<h2>Add Review</h2>

<form method="POST" action="{{ route('reviews.store') }}">
    @csrf

    <div class="mb-3">
        <label>Book</label>
        <select name="book_id" class="form-control" required>
            @foreach($books as $book)
                <option value="{{ $book->id }}">{{ $book->title }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Rating</label>
        <div class="rating-input">
            @for ($i = 5; $i >= 1; $i--)
                <input type="radio" name="rating" id="rating{{ $i }}" value="{{ $i }}" required>
                <i class="bi bi-star-fill" onclick="document.getElementById('rating{{ $i }}').checked=true"></i>
            @endfor
        </div>
    </div>

    <div class="mb-3">
        <label>Content</label>
        <textarea name="content" class="form-control" required></textarea>
    </div>

    <button class="btn btn-success">Submit</button>
</form>
@endsection
