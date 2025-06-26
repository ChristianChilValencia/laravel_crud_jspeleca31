@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8">
        <a href="{{ route('books.index') }}" class="btn btn-link text-muted px-0 mb-3">
            <i class="bi bi-arrow-left"></i> Back to Books
        </a>
        
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-4 mb-md-0">
                        <!-- Placeholder for book cover -->
                        <div class="bg-secondary bg-opacity-10 rounded d-flex align-items-center justify-content-center" style="height: 300px">
                            <i class="bi bi-book text-muted" style="font-size: 4rem;"></i>
                        </div>
                    </div>
                    
                    <div class="col-md-8">
                        <h1 class="h2 mb-2">{{ $book->title }}</h1>
                        <h2 class="h5 text-muted mb-4">by {{ $book->author->name }}</h2>
                        
                        <div class="mb-4">
                            @foreach($book->genres as $genre)
                                <span class="badge rounded-pill me-1">{{ $genre->name }}</span>
                            @endforeach
                        </div>

                        @if($reviewsCount > 0)
                            <div class="mb-4">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <div class="rating" style="font-size: 1.2rem;">
                                        @php
                                            $rating = round($averageRating * 2) / 2;
                                            $fullStars = floor($rating);
                                            $halfStar = $rating - $fullStars >= 0.5;
                                        @endphp
                                        
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $fullStars)
                                                <i class="bi bi-star-fill"></i>
                                            @elseif($i == ceil($rating) && $halfStar)
                                                <i class="bi bi-star-half"></i>
                                            @else
                                                <i class="bi bi-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="fs-4">{{ number_format($rating, 1) }}</span>
                                </div>
                                <div class="text-muted">
                                    {{ $reviewsCount }} {{ Str::plural('rating', $reviewsCount) }} · 
                                    {{ $reviewsCount }} {{ Str::plural('review', $reviewsCount) }}
                                </div>
                            </div>
                        @endif

                        <div class="d-flex gap-2">
                            <a href="{{ route('books.edit', $book->id) }}" class="btn btn-outline-secondary">
                                <i class="bi bi-pencil"></i> Edit Book
                            </a>
                            <form action="{{ route('books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this book?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="mt-5">
            <h3 class="mb-4">Community Reviews</h3>
            
            <!-- Add Review Form -->
            <div class="card mb-4">
                <div class="card-body">
                    <h4 class="h5 mb-3">Write a Review</h4>
                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        
                        <div class="mb-3">
                            <label class="form-label">Rating</label>
                            <div class="rating-input">
                                @for ($i = 5; $i >= 1; $i--)
                                    <input type="radio" name="rating" id="rating{{ $i }}" value="{{ $i }}" required>
                                    <i class="bi bi-star-fill" onclick="document.getElementById('rating{{ $i }}').checked=true"></i>
                                @endfor
                            </div>
                            @error('rating') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Review</label>
                            <textarea name="content" class="form-control" rows="4" placeholder="What did you think?" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send"></i> Post Review
                        </button>
                    </form>
                </div>
            </div>

            <!-- Reviews List -->
            @forelse($reviews as $review)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="rating">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <i class="bi bi-star-fill"></i>
                                    @else
                                        <i class="bi bi-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <div class="text-muted small">
                                {{ $review->created_at->diffForHumans() }}
                            </div>
                        </div>

                        <p class="card-text mb-3">{{ $review->content }}</p>

                        <div class="d-flex gap-2">
                            <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-muted my-5">
                    <i class="bi bi-book h1"></i>
                    <p class="mt-3">No reviews yet. Be the first to review this book!</p>
                </div>
            @endforelse

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $reviews->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Author Info -->
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title h5 mb-3">About the Author</h4>
                <h5 class="h6 mb-3">{{ $book->author->name }}</h5>
                <a href="{{ route('authors.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-person"></i> View Author Profile
                </a>
            </div>
        </div>

        <!-- Genre Info -->
        <div class="card">
            <div class="card-body">
                <h4 class="card-title h5 mb-3">Genres</h4>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($book->genres as $genre)
                        <a href="{{ route('genres.index') }}" class="badge rounded-pill text-decoration-none">
                            {{ $genre->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
