<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use Illuminate\Http\Request;

class FineController extends Controller
{
    public function index()
    {
        return view('fine.index', [
            'title' => 'Data Denda',
            'fines' => Fine::with('borrowing.member.user')->latest()->get()
        ]);
    }

    public function pay(Fine $fine)
    {
        $fine->update([
            'status' => 'Lunas',
            'paid_at' => now(),
        ]);

        return back()->withSuccess('Denda berhasil dilunasi');
    }
}
