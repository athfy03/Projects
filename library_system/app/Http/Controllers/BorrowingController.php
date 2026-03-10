<?php

namespace App\Http\Controllers;
use App\Models\Borrowing;
use App\Models\Book;
use App\Models\Member; 
use Illuminate\Http\Request;
use Carbon\Carbon;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with(['member', 'book'])->latest()->get();
        return view('Borrowing.indexborrowing', compact('borrowings'));
    }

    public function create()
    {
        $books = Book::all();
        $members = \App\Models\Member::all();
        return view('Borrowing.createborrowing', compact('books', 'members'));
    }

    public function store(Request $request)
    {
        $request->validate([
        'member_id' => 'required|exists:members,id',
        'book_id' => 'required|exists:books,id',
        'borrowed_at' => 'required|date',
        'due_date' => 'required|date|after_or_equal:borrowed_at',
        ]);

    Borrowing::create([
        'member_id' => $request->member_id,
        'book_id' => $request->book_id,
        'borrowed_at' => now(),
        'due_date' => Carbon::now()->addDays(14), // 2 weeks loan
        'status' => 'Borrowed'
    ]);

    Book::where('id', $request->book_id)->update(['status' => 'borrowed']);

    return redirect()->route('borrowings.index')->with('success', 'Book borrowed successfully.');

    }

    public function returnBook(Borrowing $borrowing)
    {
        $borrowing->update([
            'returned_at' => now(),
            'status' => 'returned'
        ]);

        Book::where('id', $borrowing->book_id)->update(['status' => 'available']);
    }

    public function show(Borrowing $borrowing)
    {
        return view('Borrowing.showborrowing', compact('borrowing'));
    }

    public function edit(Borrowing $borrowing)
    {
        $members = Member::all();
        $books = Book::all();
        return view('Borrowing.editborrowing', compact('borrowing', 'members', 'books'));
    }

    public function update(Request $request, Borrowing $borrowing)
    {
        $borrowing->update($request->all());
        return redirect()->route('borrowings.index')->with('success', 'Borrowing updated!');
    }

    public function destroy(Borrowing $borrowing)
    {
        $borrowing->delete();
        return redirect()->route('borrowings.index')->with('success', 'Borrowing deleted!');
    }

}
