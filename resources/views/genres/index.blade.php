@extends('layouts.app')

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <h2 class="fw-bold m-0">Browse by Genre</h2>
    <a href="{{ route('genres.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Add Genre
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
    @forelse($genres as $genre)
        <div class="col">
            <div class="card h-100 position-relative">
                <a href="{{ route('genres.show', $genre->id) }}" class="text-decoration-none text-dark">
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
                                <div class="d-flex flex-wrap gap-2 book-list" style="max-height: 4.5rem; overflow: hidden;">
                                    @foreach($genre->books as $book)
                                        <span class="badge bg-secondary bg-opacity-10 text-dark">{{ $book->title }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <p class="text-muted small mb-3">No books in this genre yet</p>
                        @endif
                    </div>
                </a>

                <div class="position-absolute top-0 end-0 p-3">
                    <div class="dropdown">
                        <button class="btn btn-link text-dark p-0" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('genres.edit', $genre->id) }}">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                            </li>
                            <li>
                                <form action="{{ route('genres.destroy', $genre->id) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this genre?')">
                                    @csrf
                                    @method('DELETE')
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

<div class="d-flex justify-content-center mt-4">
    {{ $genres->links('pagination::bootstrap-5') }}
</div>
@endsection
