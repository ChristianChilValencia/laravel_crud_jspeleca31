@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold m-0">Browse by Genre</h2>
    <a href="{{ route('genres.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Add Genre
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
        @forelse($genres as $genre)
            <div class="col">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-secondary bg-opacity-10 rounded d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px">
                                <i class="bi bi-bookmark text-muted"></i>
                            </div>
                            <h4 class="card-title mb-0">{{ $genre->name }}</h4>
                        </div>

                        @if ($genre->books_count > 0)
                            <div class="mb-3">
                                <h6 class="text-muted mb-2">{{ $genre->books_count }} {{ Str::plural('Book', $genre->books_count) }}</h6>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($genre->books as $book)
                                        <a href="{{ route('books.show', $book->id) }}" class="text-decoration-none">
                                            <span class="badge bg-secondary bg-opacity-10 text-dark">{{ $book->title }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <p class="text-muted small mb-3">No books in this genre yet</p>
                        @endif

                        <div class="d-flex gap-2">
                            <a href="{{ route('genres.edit', $genre->id) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('genres.destroy', $genre->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this genre?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i> Delete
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
                        <i class="bi bi-bookmark"></i>
                    </div>
                    <h3 class="h4 mb-3">No genres yet</h3>
                    <p class="text-muted mb-4">Start organizing your books by adding some genres!</p>
                    <a href="{{ route('genres.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i> Create Your First Genre
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $genres->links('pagination::bootstrap-5') }}
</div>
@endsection
