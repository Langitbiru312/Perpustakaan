<?php

namespace App\Http\Controllers;

use App\Models\BookReservation;
use App\Models\Book;
use App\Models\BookCopy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookReservationController extends Controller
{
    public function index()
    {
        $query = BookReservation::with(['member.user', 'book', 'bookCopy']);
        if (Auth::user()->role === 'Anggota') {
            $query->whereHas('member', function ($q) {
                $q->where('user_id', Auth::id());
            });
        }
        return view('reservation.index', [
            'title' => 'Reservasi Buku',
            'reservations' => $query->latest()->get()
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $user = Auth::user();
        if ($user->role !== 'Anggota' || !$user->member) {
            return back()->withError('Hanya anggota yang dapat melakukan reservasi.');
        }

        // Cek ketersediaan eksemplar
        $availableCopy = BookCopy::where('book_id', $validate['book_id'])
                                 ->where('status', 'Tersedia')
                                 ->first();

        $status = 'Menunggu';
        $copyId = null;

        if ($availableCopy) {
            $status = 'Ready';
            $copyId = $availableCopy->id;
            $availableCopy->update(['status' => 'Direservasi']);
        }

        BookReservation::create([
            'member_id' => $user->member->id,
            'book_id' => $validate['book_id'],
            'book_copy_id' => $copyId,
            'reservation_date' => now(),
            'expiry_date' => now()->addDays(2),
            'status' => $status,
        ]);

        return to_route('reservation.index')->withSuccess('Reservasi berhasil dibuat. Status: ' . $status);
    }

    public function cancel(BookReservation $reservation)
    {
        if (Auth::user()->role === 'Anggota' && Auth::user()->member->id !== $reservation->member_id) {
            return abort(403);
        }

        if ($reservation->status === 'Ready' && $reservation->book_copy_id) {
            $reservation->bookCopy->update(['status' => 'Tersedia']);
        }

        $reservation->update(['status' => 'Batal']);
        return back()->withSuccess('Reservasi berhasil dibatalkan.');
    }
}
