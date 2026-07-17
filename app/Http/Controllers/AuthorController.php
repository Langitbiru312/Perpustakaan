<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Author;

class AuthorController extends Controller
{
    public function index()
    {
        return view('author.index', [
            'title' => 'Penulis',
            'authors' => Author::latest()->get()
        ]);
    }

    public function create()
    {
        return view('author.create', [
            'title' => 'Tambah Penulis'
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'bio' => 'nullable'
        ]);
        Author::create($validate);
        return to_route('author.index')->withSuccess('Penulis berhasil ditambahkan');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Author $author)
    {
        return view('author.edit', [
            'title' => 'Edit Penulis',
            'author' => $author
        ]);
    }

    public function update(Request $request, Author $author)
    {
        $validate = $request->validate([
            'name' => 'required',
            'bio' => 'nullable'
        ]);
        $author->update($validate);
        return to_route('author.index')->withSuccess('Penulis berhasil diubah');
    }

    public function destroy(Author $author)
    {
        $author->delete();
        return to_route('author.index')->withSuccess('Penulis berhasil dihapus');
    }
}
