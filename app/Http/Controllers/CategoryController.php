<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        return view('category.index', [
            'title' => 'Kategori Buku',
            'categories' => Category::latest()->get()
        ]);
    }

    public function create()
    {
        return view('category.create', [
            'title' => 'Tambah Kategori'
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|unique:categories,name'
        ]);
        $validate['slug'] = Str::slug($validate['name']);
        Category::create($validate);
        return to_route('category.index')->withSuccess('Kategori berhasil ditambahkan');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Category $category)
    {
        return view('category.edit', [
            'title' => 'Edit Kategori',
            'category' => $category
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $validate = $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id
        ]);
        $validate['slug'] = Str::slug($validate['name']);
        $category->update($validate);
        return to_route('category.index')->withSuccess('Kategori berhasil diubah');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return to_route('category.index')->withSuccess('Kategori berhasil dihapus');
    }
}
