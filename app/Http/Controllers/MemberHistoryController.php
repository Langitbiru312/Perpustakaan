<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Borrowing;
use App\Models\Fine;
use App\Models\BookReservation;

class MemberHistoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role !== 'Anggota' || !$user->member) {
            return redirect()->route('dashboard.index');
        }

        $member = $user->member;

        // Semua riwayat peminjaman milik anggota ini
        $borrowings = Borrowing::with(['bookCopy.book', 'fine'])
            ->where('member_id', $member->id)
            ->latest()
            ->get();

        // Denda yang belum lunas
        $unpaidFines = Fine::whereHas('borrowing', function ($q) use ($member) {
            $q->where('member_id', $member->id);
        })->where('status', 'Belum Lunas')->with('borrowing.bookCopy.book')->get();

        // Reservasi aktif
        $activeReservations = BookReservation::with('book')
            ->where('member_id', $member->id)
            ->whereIn('status', ['Menunggu', 'Ready'])
            ->latest()
            ->get();

        return view('riwayat.index', [
            'title' => 'Riwayat Saya',
            'borrowings' => $borrowings,
            'unpaidFines' => $unpaidFines,
            'activeReservations' => $activeReservations,
        ]);
    }
}
