<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;

class ReportController extends Controller
{
    public function index()
    {
        $totalBooks = Book::count();
        $totalAuthors = Author::count();
        $totalCategories = Category::count();

        $authors = Author::withCount('books')->orderBy('name')->get();

        return view('report.index', compact('totalBooks', 'totalAuthors', 'totalCategories', 'authors'));
    }
}
