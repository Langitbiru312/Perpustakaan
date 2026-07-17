<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="card shadow-lg p-3">
        <form action="{{ route('publisher.update', $publisher) }}" method="post">
            @csrf @method('PUT')
                        <div class="mb-3">
                <label for="name" class="form-label required">Nama Penerbit</label>
                <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name" required value="{{ old('name', $publisher->name) }}">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>            <div class="mb-3">
                <label for="address" class="form-label required">Alamat</label>
                <input class="form-control @error('address') is-invalid @enderror" type="text" id="address" name="address" required value="{{ old('address', $publisher->address) }}">
                @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="text-end">
                <a href="{{ route('publisher.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</x-app>