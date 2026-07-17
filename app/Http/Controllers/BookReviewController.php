<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookReview;
use Illuminate\Support\Facades\Auth;

class BookReviewController extends Controller
{
    public function store(Request $request)
    {
        $validate = $request->validate([
            'book_id' => 'required|exists:books,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string',
        ]);

        if (Auth::user()->role !== 'Anggota' || !Auth::user()->member) {
            return back()->withError('Hanya anggota yang dapat memberikan ulasan.');
        }

        $validate['member_id'] = Auth::user()->member->id;

        // Cek apakah sudah pernah review
        $existing = BookReview::where('member_id', $validate['member_id'])
                              ->where('book_id', $validate['book_id'])
                              ->first();

        if ($existing) {
            $existing->update([
                'rating' => $validate['rating'],
                'review' => $validate['review'],
            ]);
            $msg = 'Ulasan berhasil diperbarui.';
        } else {
            BookReview::create($validate);
            $msg = 'Ulasan berhasil ditambahkan.';
        }

        return back()->withSuccess($msg);
    }
}
