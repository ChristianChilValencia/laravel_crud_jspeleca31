<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Libretto - Your Digital Library</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700&family=Source+Sans+Pro:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

    <style>
        :root {
            --goodreads-brown: #382110;
            --goodreads-tan: #F4F1EA;
            --goodreads-green: #3B8B6B;
            --goodreads-success: #28a745;
            --goodreads-error: #dc3545;
        }
        
        body {
            font-family: 'Source Sans Pro', sans-serif;
            background-color: var(--goodreads-tan);
            padding-top: 60px;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Merriweather', serif;
            color: var(--goodreads-brown);
        }

        .navbar {
            background-color: var(--goodreads-brown) !important;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
        }

        .navbar-brand {
            font-family: 'Merriweather', serif;
            font-weight: 700;
        }

        .nav-link {
            color: rgba(255,255,255,0.8) !important;
            font-weight: 400;
            position: relative;
        }

        .nav-link:hover {
            color: white !important;
        }

        .nav-link.active {
            font-weight: 600;
            color: white !important;
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: white;
        }

        .btn-primary {
            background-color: var(--goodreads-green);
            border-color: var(--goodreads-green);
        }

        .btn-primary:hover {
            background-color: #2d6b52;
            border-color: #2d6b52;
        }

        .card {
            border: none;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .book-card {
            transition: transform 0.2s;
        }

        .book-card:hover {
            transform: translateY(-5px);
        }

        .card-title {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            min-height: 3rem;
        }

        .badge {
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .rating {
            color: #FF9529;
        }

        .rating-input {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
        }

        .rating-input i {
            cursor: pointer;
            font-size: 1.5rem;
            padding: 0.2rem;
            color: #ddd;
        }

        .rating-input i:hover,
        .rating-input i:hover ~ i,
        .rating-input input:checked ~ i {
            color: #FF9529;
        }

        .rating-input input {
            display: none;
        }

        .badge {
            background-color: var(--goodreads-brown);
            color: white;
        }

        .alert-success {
            background-color: rgba(59, 139, 107, 0.1);
            border: none;
            border-left: 4px solid var(--goodreads-green);
            color: var(--goodreads-green);
            border-radius: 0;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            position: relative;
            animation: slideIn 0.3s ease-out;
        }

        .alert-danger {
            background-color: rgba(220, 53, 69, 0.1);
            border: none;
            border-left: 4px solid var(--goodreads-error);
            color: var(--goodreads-error);
            border-radius: 0;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            position: relative;
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .page-header {
            position: sticky;
            top: 60px;
            background-color: var(--goodreads-tan);
            padding: 1rem 0;
            margin: -1rem 0 1rem;
            z-index: 1020;
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }

        .container {
            padding-top: 1rem;
        }

        /* Pagination Styling */
        .page-link {
            color: var(--goodreads-green);
            background-color: #fff;
            border-color: #dee2e6;
        }

        .page-link:hover {
            color: #2d6b52;
            background-color: #e9ecef;
            border-color: #dee2e6;
        }

        .page-item.active .page-link {
            background-color: var(--goodreads-green);
            border-color: var(--goodreads-green);
            color: #fff;
        }

        .page-item.disabled .page-link {
            color: #6c757d;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('books.index') }}">📖 Libretto: Good<b>Reads<b></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="nav ms-auto">
                    <a href="{{ route('books.index') }}" class="nav-link {{ request()->is('books*') ? 'active' : '' }}">
                        <i class="bi bi-book"></i> Books
                    </a>
                    <a href="{{ route('authors.index') }}" class="nav-link {{ request()->is('authors*') ? 'active' : '' }}">
                        <i class="bi bi-person"></i> Authors
                    </a>
                    <a href="{{ route('genres.index') }}" class="nav-link {{ request()->is('genres*') ? 'active' : '' }}">
                        <i class="bi bi-tags"></i> Genres
                    </a>
                    <a href="{{ route('reviews.index') }}" class="nav-link {{ request()->is('reviews*') ? 'active' : '' }}">
                        <i class="bi bi-star"></i> Reviews
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        @hasSection('header')
            <div class="page-header">
                @yield('header')
            </div>
        @endif
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
