@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold m-0">Community Reviews</h2>
    <a href="{{ route('reviews.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Write Review
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@forelse($reviews as $review)
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex gap-4 mb-3">
                <!-- Book Cover Placeholder -->
                <div class="bg-secondary bg-opacity-10 rounded d-flex align-items-center justify-content-center" style="min-width: 100px; height: 150px">
                    <i class="bi bi-book text-muted" style="font-size: 2rem;"></i>
                </div>
                
                <div class="flex-grow-1">
                    <h4 class="card-title mb-1">
                        <a href="{{ route('books.show', $review->book->id) }}" class="text-decoration-none text-dark">
                            {{ $review->book->title }}
                        </a>
                    </h4>
                    <p class="text-muted mb-3">by {{ $review->book->author->name }}</p>
                    
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="rating">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <i class="bi bi-star-fill"></i>
                                @else
                                    <i class="bi bi-star"></i>
                                @endif
                            @endfor
                        </div>
                        <span class="text-muted small">Rated {{ $review->rating }} stars</span>
                    </div>

                    <div class="review-content mb-3">
                        <p class="mb-0">{{ $review->content }}</p>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this review?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="text-center my-5">
        <div class="display-1 text-muted mb-4">
            <i class="bi bi-book"></i>
        </div>
        <h3 class="h4 mb-3">No reviews yet</h3>
        <p class="text-muted mb-4">Share your thoughts on the books you've read!</p>
        <a href="{{ route('reviews.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Write Your First Review
        </a>
    </div>
@endforelse

<div class="d-flex justify-content-center">
    {{ $reviews->links('pagination::bootstrap-5') }}
</div>
@endsection
