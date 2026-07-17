<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Publisher;

class PublisherController extends Controller
{
    public function index()
    {
        return view('publisher.index', [
            'title' => 'Penerbit',
            'publishers' => Publisher::latest()->get()
        ]);
    }

    public function create()
    {
        return view('publisher.create', [
            'title' => 'Tambah Penerbit'
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'address' => 'nullable'
        ]);
        Publisher::create($validate);
        return to_route('publisher.index')->withSuccess('Penerbit berhasil ditambahkan');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Publisher $publisher)
    {
        return view('publisher.edit', [
            'title' => 'Edit Penerbit',
            'publisher' => $publisher
        ]);
    }

    public function update(Request $request, Publisher $publisher)
    {
        $validate = $request->validate([
            'name' => 'required',
            'address' => 'nullable'
        ]);
        $publisher->update($validate);
        return to_route('publisher.index')->withSuccess('Penerbit berhasil diubah');
    }

    public function destroy(Publisher $publisher)
    {
        $publisher->delete();
        return to_route('publisher.index')->withSuccess('Penerbit berhasil dihapus');
    }
}
