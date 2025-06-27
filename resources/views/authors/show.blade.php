@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('authors.index') }}" class="btn btn-link text-muted px-0 mb-3">
        <i class="bi bi-arrow-left"></i> Back to Authors
    </a>

    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 80px; height: 80px">
                            <i class="bi bi-person text-muted" style="font-size: 2rem;"></i>
                        </div>
                        <div>
                            <h1 class="h2 mb-1">{{ $author->name }}</h1>
                            <p class="text-muted mb-0">{{ $author->books->count() }} {{ Str::plural('Book', $author->books->count()) }}</p>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('authors.edit', $author->id) }}" class="btn btn-outline-secondary">
                            <i class="bi bi-pencil"></i> Edit Author
                        </a>
                        <form action="{{ route('authors.destroy', $author->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this author?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-outline-danger">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <h2 class="h4 mb-4">Books by {{ $author->name }}</h2>
            
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @forelse($author->books as $book)
                    <div class="col">
                        <div class="card h-100 book-card">
                            <div class="card-body">
                                <h4 class="card-title mb-3">
                                    <a href="{{ route('books.show', $book->id) }}" class="text-decoration-none text-dark">
                                        {{ $book->title }}
                                    </a>
                                </h4>

                                @if($book->reviews_count > 0)
                                    <div class="d-flex align-items-center gap-2 mb-3">
                                        <div class="rating">
                                            @php
                                                $rating = round($book->reviews_avg_rating * 2) / 2;
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
                                        <span class="text-muted small">
                                            {{ number_format($rating, 1) }} avg ({{ $book->reviews_count }} {{ Str::plural('review', $book->reviews_count) }})
                                        </span>
                                    </div>
                                @else
                                    <div class="text-muted small mb-3">No reviews yet</div>
                                @endif

                                <div class="d-flex gap-2">
                                    <a href="{{ route('books.show', $book->id) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center my-5">
                            <div class="display-1 text-muted mb-4">
                                <i class="bi bi-book"></i>
                            </div>
                            <h3 class="h4 mb-3">No books yet</h3>
                            <p class="text-muted mb-4">This author hasn't published any books yet.</p>
                            <a href="{{ route('books.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-lg"></i> Add a Book
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection