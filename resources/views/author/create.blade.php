<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="card shadow-lg p-3">
        <form action="{{ route('author.store') }}" method="post">
            @csrf
                        <div class="mb-3">
                <label for="name" class="form-label required">Nama Penulis</label>
                <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name" required value="{{ old('name') }}">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>            <div class="mb-3">
                <label for="bio" class="form-label required">Biografi</label>
                <input class="form-control @error('bio') is-invalid @enderror" type="text" id="bio" name="bio" required value="{{ old('bio') }}">
                @error('bio')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="text-end">
                <a href="{{ route('author.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</x-app>