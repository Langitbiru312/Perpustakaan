<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="card shadow-lg p-3">
        <form action="{{ route('book.update', $book) }}" method="post" enctype="multipart/form-data">
            @csrf @method('PUT')
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="title" class="form-label required">Judul Buku</label>
                    <input class="form-control @error('title') is-invalid @enderror" type="text" id="title" name="title" required value="{{ old('title', $book->title) }}">
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="isbn" class="form-label">ISBN</label>
                    <input class="form-control @error('isbn') is-invalid @enderror" type="text" id="isbn" name="isbn" value="{{ old('isbn', $book->isbn) }}">
                    @error('isbn')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="category_id" class="form-label required">Kategori</label>
                    <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="author_id" class="form-label required">Penulis</label>
                    <select name="author_id" id="author_id" class="form-select @error('author_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Penulis --</option>
                        @foreach($authors as $author)
                            <option value="{{ $author->id }}" {{ old('author_id', $book->author_id) == $author->id ? 'selected' : '' }}>{{ $author->name }}</option>
                        @endforeach
                    </select>
                    @error('author_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="publisher_id" class="form-label required">Penerbit</label>
                    <select name="publisher_id" id="publisher_id" class="form-select @error('publisher_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Penerbit --</option>
                        @foreach($publishers as $publisher)
                            <option value="{{ $publisher->id }}" {{ old('publisher_id', $book->publisher_id) == $publisher->id ? 'selected' : '' }}>{{ $publisher->name }}</option>
                        @endforeach
                    </select>
                    @error('publisher_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label for="publication_year" class="form-label">Tahun Terbit</label>
                    <input class="form-control @error('publication_year') is-invalid @enderror" type="number" id="publication_year" name="publication_year" value="{{ old('publication_year', $book->publication_year) }}">
                    @error('publication_year')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label for="synopsis" class="form-label">Sinopsis</label>
                    <textarea class="form-control @error('synopsis') is-invalid @enderror" id="synopsis" name="synopsis" rows="3">{{ old('synopsis', $book->synopsis) }}</textarea>
                    @error('synopsis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label for="cover_image" class="form-label">Cover Buku (JPG/PNG)</label>
                    <input class="form-control @error('cover_image') is-invalid @enderror" type="file" id="upload" name="cover_image" accept="image/*">
                    @error('cover_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <div class="mt-2">
                        <img id="preview" src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : '' }}" alt="Preview Cover" style="max-height: 150px;">
                    </div>
                </div>

            </div>
            
            <div class="text-end">
                <a href="{{ route('book.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</x-app>
