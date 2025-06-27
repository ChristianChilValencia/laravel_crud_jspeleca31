<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::withCount('books')
            ->with('books')
            ->paginate(9);
        return view('authors.index', compact('authors'));
    }

    public function create()
    {
        return view('authors.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255'],
        ['name.required' => 'The author name is required.']
    );
        Author::create($request->all());
        return redirect()
        ->route('authors.index')
        ->with('success', 'Author created successfully.');
}

    public function edit(Author $author)
    {
        return view('authors.edit', compact('author'));
    }

    public function update(Request $request, Author $author)
    {
        $request->validate(['name' => 'required|string|max:255'],
        ['name.required' => 'The author name is required.']
    );
        $author->update($request->all());
           return redirect()
        ->route('authors.index', $author->id)
        ->with('success', 'Author updated successfully.');
}

    public function destroy(Author $author)
    {
        $author->delete();
        return redirect()->route('authors.index')
        ->with('success','Author deleted successfully.');
    }

    public function show(Author $author)
    {
        $author->load(['books' => function($query) {
            $query->withCount('reviews')
                  ->withAvg('reviews', 'rating');
        }]);
        return view('authors.show', compact('author'));
    }
}

