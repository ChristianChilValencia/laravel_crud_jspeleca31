@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold m-0">Authors</h2>
    <a href="{{ route('authors.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Add Author
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
        @forelse($authors as $author)
            <div class="col">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px">
                                <i class="bi bi-person text-muted" style="font-size: 1.5rem;"></i>
                            </div>
                            <h4 class="card-title mb-0">{{ $author->name }}</h4>
                        </div>

                        <div class="mb-3">
                            <h6 class="text-muted mb-2">Published Books ({{ $author->books_count }})</h6>
                            @if ($author->books_count > 0)
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($author->books as $book)
                                        <a href="{{ route('books.show', $book->id) }}" class="text-decoration-none">
                                            <span class="badge bg-secondary bg-opacity-10 text-dark">{{ $book->title }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted small mb-0">No books published yet</p>
                            @endif
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('authors.edit', $author->id) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('authors.destroy', $author->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this author?')">
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
                        <i class="bi bi-person"></i>
                    </div>
                    <h3 class="h4 mb-3">No authors yet</h3>
                    <p class="text-muted mb-4">Add authors to start building your library!</p>
                    <a href="{{ route('authors.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i> Add Your First Author
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $authors->links('pagination::bootstrap-5') }}
</div>
@endsection
