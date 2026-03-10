<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        // Optional: search by title/author
        $q = request('q');
        $books = Book::when($q, fn($query) =>
                    $query->where('title','like',"%$q%")
                          ->orWhere('author','like',"%$q%")
                )
                ->orderBy('created_at','desc')
                ->paginate(10);

        return view('Book.indexbooks', compact('books','q'));
    }

    public function show(Book $book){
        return view('Book.showbooks', compact('book'));

    }

    public function create(Book $books)
    {
        return view('Book.createbooks', compact('books'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'  => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'type'   => 'required|in:normal,special',
            'isbn'   => 'required|string|max:50|unique:books,isbn',
        ]);

        Book::create($data);
        return redirect()->route('books.index')->with('success','Book created successfully.');
    }

    public function edit(Book $book)
    {
        return view('Book.editbooks', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'title'  => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'type'   => 'required|in:normal,special',
            'isbn'   => 'required|string|max:50|unique:books,isbn,'.$book->id,
        ]);

        $book->update($data);
        return redirect()->route('books.index')->with('success','Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success','Book deleted successfully.');
    }
}
