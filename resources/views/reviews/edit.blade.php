@extends('layouts.app')

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<a href="{{ url()->previous() }}" class="btn btn-outline-secondary mt-2 mb-3">← Back</a>

<h2>Edit Review</h2>

<form method="POST" action="{{ route('reviews.update', $review->id) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Rating</label>
        <div class="rating-input">
            @for ($i = 5; $i >= 1; $i--)
                <input type="radio" name="rating" id="rating{{ $i }}" value="{{ $i }}" {{ $review->rating == $i ? 'checked' : '' }} required>
                <i class="bi bi-star-fill" onclick="document.getElementById('rating{{ $i }}').checked=true"></i>
            @endfor
        </div>
        @error('rating') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label>Review Content</label>
        <textarea name="content" class="form-control">{{ $review->content }}</textarea>
        @error('content') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <button type="submit" class="btn btn-primary">Update Review</button>

    <button type="reset" class="btn btn-secondary">Cancel</button>
</form>
@endsection
