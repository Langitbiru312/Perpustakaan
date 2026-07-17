<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BookCopy;

class BookCopyController extends Controller
{
    public function store(Request $request, Book $book)
    {
        $validate = $request->validate([
            'barcode' => 'required|unique:book_copies,barcode',
            'condition' => 'required',
            'status' => 'required',
        ]);

        $book->copies()->create($validate);
        return redirect()->route('book.show', $book)->withSuccess('Eksemplar berhasil ditambahkan');
    }

    public function update(Request $request, Book $book, BookCopy $copy)
    {
        $validate = $request->validate([
            'barcode' => 'required|unique:book_copies,barcode,' . $copy->id,
            'condition' => 'required',
            'status' => 'required',
        ]);

        $copy->update($validate);
        return redirect()->route('book.show', $book)->withSuccess('Eksemplar berhasil diubah');
    }

    public function destroy(Book $book, BookCopy $copy)
    {
        $copy->delete();
        return redirect()->route('book.show', $book)->withSuccess('Eksemplar berhasil dihapus');
    }
}
