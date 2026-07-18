<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookBorrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LibraryController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        if ($request->search) {
            $query->where('title', 'like', "%{$request->search}%")
                  ->orWhere('author', 'like', "%{$request->search}%");
        }

        $books = $query->latest()->paginate(20);
        return view('library.index', compact('books'));
    }

    public function create()
    {
        return view('library.create');
    }

    public function store(Request $request)
    {
        $data = $request->only(['title', 'author', 'category', 'description']);

        if ($request->hasFile('pdf_file')) {
            $data['pdf_file'] = $request->file('pdf_file')->store('books/pdfs', 'public');
        }

        Book::create($data);
        return redirect()->route('admin.library.index')->with('success', 'Book added successfully.');
    }

    public function show(Book $book)
    {
        return view('library.show', compact('book'));
    }

    public function edit(Book $book)
    {
        return view('library.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $data = $request->only(['title', 'author', 'category', 'description']);

        if ($request->hasFile('pdf_file')) {
            if ($book->pdf_file && Storage::disk('public')->exists($book->pdf_file)) {
                Storage::disk('public')->delete($book->pdf_file);
            }
            $data['pdf_file'] = $request->file('pdf_file')->store('books/pdfs', 'public');
        }

        $book->update($data);
        return redirect()->route('admin.library.show', $book)->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        if ($book->pdf_file && Storage::disk('public')->exists($book->pdf_file)) {
            Storage::disk('public')->delete($book->pdf_file);
        }
        $book->delete();
        return redirect()->route('admin.library.index')->with('success', 'Book deleted successfully.');
    }

    public function borrowings(Request $request)
    {
        $query = BookBorrowing::with(['book', 'student.user']);

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->date_from) {
            $query->whereDate('borrow_date', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('borrow_date', '<=', $request->date_to);
        }

        $borrowings = $query->latest()->paginate(20);
        return view('library.borrowings', compact('borrowings'));
    }

    public function returnBook(BookBorrowing $borrowing)
    {
        $borrowing->update([
            'status' => 'returned',
            'return_date' => now(),
        ]);

        $book = $borrowing->book;
        $book->available = $book->available + 1;
        $book->save();

        return back()->with('success', 'Book returned successfully.');
    }
}
