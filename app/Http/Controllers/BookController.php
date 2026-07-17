<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Author;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with(['category', 'author', 'publisher', 'copies', 'reviews'])->latest();
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhere('isbn', 'like', "%{$request->search}%")
                  ->orWhereHas('author', fn($a) => $a->where('name', 'like', "%{$request->search}%"));
            });
        }
        return view('book.index', [
            'title' => 'Katalog Buku',
            'books' => $query->get()
        ]);
    }

    public function create()
    {
        return view('book.create', [
            'title' => 'Tambah Buku',
            'categories' => Category::all(),
            'authors' => Author::all(),
            'publishers' => Publisher::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'title' => 'required',
            'isbn' => 'nullable|unique:books,isbn',
            'category_id' => 'required',
            'author_id' => 'required',
            'publisher_id' => 'required',
            'publication_year' => 'nullable|integer',
            'synopsis' => 'nullable',
            'cover_image' => 'nullable|image|mimes:png,jpg,jpeg|max:1024',
        ]);

        if ($request->file('cover_image')) {
            $validate['cover_image'] = $request->file('cover_image')->store('books', 'public');
        }

        Book::create($validate);
        return to_route('book.index')->withSuccess('Buku berhasil ditambahkan');
    }

    public function show(Book $book)
    {
        return view('book.show', [
            'title' => 'Detail Buku',
            'book' => $book->load(['category', 'author', 'publisher', 'copies', 'reviews.member.user'])
        ]);
    }

    public function edit(Book $book)
    {
        return view('book.edit', [
            'title' => 'Edit Buku',
            'book' => $book,
            'categories' => Category::all(),
            'authors' => Author::all(),
            'publishers' => Publisher::all(),
        ]);
    }

    public function update(Request $request, Book $book)
    {
        $validate = $request->validate([
            'title' => 'required',
            'isbn' => 'nullable|unique:books,isbn,' . $book->id,
            'category_id' => 'required',
            'author_id' => 'required',
            'publisher_id' => 'required',
            'publication_year' => 'nullable|integer',
            'synopsis' => 'nullable',
            'cover_image' => 'nullable|image|mimes:png,jpg,jpeg|max:1024',
        ]);

        if ($request->file('cover_image')) {
            $validate['cover_image'] = $request->file('cover_image')->store('books', 'public');
            if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
                Storage::disk('public')->delete($book->cover_image);
            }
        }

        $book->update($validate);
        return to_route('book.index')->withSuccess('Buku berhasil diubah');
    }

    public function destroy(Book $book)
    {
        if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
            Storage::disk('public')->delete($book->cover_image);
        }
        $book->delete();
        return to_route('book.index')->withSuccess('Buku berhasil dihapus');
    }
}
