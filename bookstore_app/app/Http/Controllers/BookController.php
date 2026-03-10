<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with(['authors', 'categories'])->latest()->paginate(10);
        return view('books.index', compact('books'));
    }

    public function create()
    {
        $authors = Author::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        return view('books.create', compact('authors', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'isbn' => ['required', 'string', 'max:255', 'unique:books,isbn'],
            'price' => ['required', 'numeric', 'min:0'],
            'authors' => ['nullable', 'array'],
            'authors.*' => ['exists:authors,id'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['exists:categories,id'],
        ]);

        $book = Book::create([
            'title' => $validated['title'],
            'isbn' => $validated['isbn'],
            'price' => $validated['price'],
        ]);

        $book->authors()->sync($validated['authors'] ?? []);
        $book->categories()->sync($validated['categories'] ?? []);

        return redirect()->route('books.index')->with('success', 'Book created successfully.');
    }

    public function edit(Book $book)
    {
        $book->load(['authors', 'categories']);
        $authors = Author::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        $selectedAuthors = $book->authors->pluck('id')->toArray();
        $selectedCategories = $book->categories->pluck('id')->toArray();

        return view('books.edit', compact('book', 'authors', 'categories', 'selectedAuthors', 'selectedCategories'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'isbn' => ['required', 'string', 'max:255', 'unique:books,isbn,' . $book->id],
            'price' => ['required', 'numeric', 'min:0'],
            'authors' => ['nullable', 'array'],
            'authors.*' => ['exists:authors,id'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['exists:categories,id'],
        ]);

        $book->update([
            'title' => $validated['title'],
            'isbn' => $validated['isbn'],
            'price' => $validated['price'],
        ]);

        $book->authors()->sync($validated['authors'] ?? []);
        $book->categories()->sync($validated['categories'] ?? []);

        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }
}
