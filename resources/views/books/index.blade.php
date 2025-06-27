@extends('layouts.app')

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <h2 class="fw-bold m-0">Discover Books</h2>
    <a href="{{ route('books.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Add Book
    </a>
</div>
@endsection

@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 g-4">
    @forelse($books as $book)
        <div class="col">
            <div class="card h-100 book-card position-relative">
                <a href="{{ route('books.show', $book->id) }}" class="text-decoration-none text-dark">
                    <div class="card-body">
                        <h4 class="card-title mb-3">{{ $book->title }}</h4>
                        
                        <div class="mb-3">
                            <div class="text-muted mb-2">by 
                                <span class="fw-semibold">{{ $book->author->name }}</span>
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
                                <span class="badge rounded-pill">{{ $genre->name }}</span>
                            @empty
                                <span class="text-muted small">No genres assigned</span>
                            @endforelse
                        </div>
                    </div>
                </a>
                
                <div class="position-absolute top-0 end-0 p-3">
                    <div class="dropdown">
                        <button class="btn btn-link text-dark p-0" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('books.edit', $book->id) }}">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                            </li>
                            <li>
                                <form action="{{ route('books.destroy', $book->id) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this book?')">
                                    @csrf @method('DELETE')
                                    <button class="dropdown-item text-danger">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </li>
                        </ul>
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

<div class="d-flex justify-content-center mt-4">
    {{ $books->links('pagination::bootstrap-5') }}
</div>
@endsection
