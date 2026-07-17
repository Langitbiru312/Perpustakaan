<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrowing;
use App\Models\Member;
use App\Models\BookCopy;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with(['member.user', 'bookCopy.book'])->latest()->get();
        return view('borrowing.index', [
            'title' => 'Peminjaman Buku',
            'borrowings' => $borrowings,
        ]);
    }

    public function create()
    {
        return view('borrowing.create', [
            'title' => 'Tambah Peminjaman',
            'members' => Member::where('is_active', true)->with('user')->get(),
            'copies' => BookCopy::where('status', 'Tersedia')->with('book')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'member_id' => 'required|exists:members,id',
            'book_copy_id' => 'required|exists:book_copies,id',
            'borrow_date' => 'required|date',
            'due_date' => 'required|date|after:borrow_date',
            'notes' => 'nullable',
        ]);

        $copy = BookCopy::findOrFail($validate['book_copy_id']);
        if ($copy->status !== 'Tersedia') {
            return back()->withError('Eksemplar ini sudah tidak tersedia.')->withInput();
        }

        $validate['status'] = 'Dipinjam';
        Borrowing::create($validate);

        // Ubah status eksemplar jadi Dipinjam
        $copy->update(['status' => 'Dipinjam']);

        return to_route('borrowing.index')->withSuccess('Peminjaman berhasil dicatat');
    }

    public function show(Borrowing $borrowing)
    {
        return view('borrowing.show', [
            'title' => 'Detail Peminjaman',
            'borrowing' => $borrowing->load(['member.user', 'bookCopy.book']),
        ]);
    }

    public function returnBook(Borrowing $borrowing)
    {
        if ($borrowing->status === 'Dikembalikan') {
            return back()->withError('Buku ini sudah dikembalikan.');
        }

        $returnDate = now()->toDateString();
        $isLate = now()->toDateString() > $borrowing->due_date->toDateString();

        $borrowing->update([
            'return_date' => $returnDate,
            'status' => $isLate ? 'Terlambat' : 'Dikembalikan',
        ]);

        // Kembalikan status eksemplar ke Tersedia
        $borrowing->bookCopy->update(['status' => 'Tersedia']);

        return to_route('borrowing.index')->withSuccess('Buku berhasil dikembalikan');
    }

    public function destroy(Borrowing $borrowing)
    {
        if ($borrowing->status === 'Dipinjam') {
            $borrowing->bookCopy->update(['status' => 'Tersedia']);
        }
        $borrowing->delete();
        return to_route('borrowing.index')->withSuccess('Data peminjaman berhasil dihapus');
    }
}
