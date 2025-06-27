@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold m-0">Discover Books</h2>
    <a href="{{ route('books.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Add Book
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="container">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 justify-content-center">
        @forelse($books as $book)
            <div class="col">
                <div class="card h-100 book-card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">
                            <a href="{{ route('books.show', $book->id) }}" class="text-decoration-none text-dark">
                                {{ $book->title }}
                            </a>
                        </h4>
                        
                        <div class="mb-3">
                            <div class="text-muted mb-2">by 
                                <a href="{{ route('authors.show', $book->author->id) }}" class="text-decoration-none text-dark fw-semibold">
                                    {{ $book->author->name }}
                                </a>
                            </div>
                            
                            @if($book->reviews_count > 0)
                                <div class="d-flex align-items-center gap-2">
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
                                <div class="text-muted small">No reviews yet</div>
                            @endif
                        </div>

                        <div class="mb-3">
                            @forelse($book->genres as $genre)
                                <a href="{{ route('genres.show', $genre->id) }}" class="badge rounded-pill text-decoration-none">
                                    {{ $genre->name }}
                                </a>
                            @empty
                                <span class="text-muted small">No genres assigned</span>
                            @endforelse
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('books.show', $book->id) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-eye"></i> View
                            </a>
                            <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this book?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
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
                    <p class="text-muted mb-4">Start your library by adding some books!</p>
                    <a href="{{ route('books.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i> Add Your First Book
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $books->links('pagination::bootstrap-5') }}
</div>
@endsection
