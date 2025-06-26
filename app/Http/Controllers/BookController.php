<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with(['author', 'genres'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->paginate(9);
        return view('books.index', compact('books'));
    }

    public function create()
    {
        $authors = Author::all();
        $genres = Genre::all();
        return view('books.create', compact('authors', 'genres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'genres' => 'required|array',
             ],
            ['title.required' => 'The title Must not be Empty.',
            'author_id.required' => 'The author Must not be Empty.',
            'genres.required' => 'The genre Must not be Empty.'
            ]
    );

        $book = Book::create($request->only('title', 'author_id'));
        $book->genres()->sync($request->genres);

        return redirect()->route('books.index')
        ->with('success','Book created successfully.');
    }

    public function show(Book $book)
    {
        $reviewsCount = $book->reviews()->count();
        $averageRating = $book->reviews()->avg('rating');
        $reviews = $book->reviews()->latest()->paginate(5);
        
        $book->load(['author', 'genres']);
        return view('books.show', compact('book', 'reviews', 'reviewsCount', 'averageRating'));
    }

    public function edit(Book $book)
    {
        $authors = Author::all();
        $genres = Genre::all();
        return view('books.edit', compact('book', 'authors', 'genres'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'genres' => 'required|array',
            ],
            ['title.required' => 'The title Must not be Empty.',
            'author_id.required' => 'The author Must not be Empty.',
            'genres.required' => 'The genre Must not be Empty.'
            ]
    );

        $book->update($request->only('title', 'author_id'));
        $book->genres()->sync($request->genres);

        return redirect()->route('books.index')
        ->with('success','Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')
        ->with('success','Book deleted successfully.');
    }
}

