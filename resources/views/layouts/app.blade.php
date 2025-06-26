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
        }
        
        body {
            font-family: 'Source Sans Pro', sans-serif;
            background-color: var(--goodreads-tan);
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Merriweather', serif;
            color: var(--goodreads-brown);
        }

        .navbar {
            background-color: var(--goodreads-brown) !important;
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
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
