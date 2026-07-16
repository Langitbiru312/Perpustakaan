<?php

namespace App\Http\Controllers;

class LibrarianController extends Controller
{
    public function dashboard()
    {
        return view('librarian.dashboard');
    }
}
