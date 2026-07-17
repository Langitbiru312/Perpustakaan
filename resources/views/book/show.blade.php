<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>
    
    <div class="row">
        <!-- Book Details -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-lg p-3 text-center">
                @if($book->cover_image)
                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Cover" class="img-fluid rounded mb-3" style="max-height: 300px;">
                @else
                    <img src="{{ asset('niceadmin/img/notfound.png') }}" alt="No Cover" class="img-fluid rounded mb-3" style="max-height: 300px;">
                @endif
                <h4 class="fw-bold">{{ $book->title }}</h4>
                <p class="text-muted mb-1">ISBN: {{ $book->isbn ?? '-' }}</p>
                <div class="text-start mt-3">
                    <p><strong>Kategori:</strong> {{ $book->category->name }}</p>
                    <p><strong>Penulis:</strong> {{ $book->author->name }}</p>
                    <p><strong>Penerbit:</strong> {{ $book->publisher->name }}</p>
                    <p><strong>Tahun Terbit:</strong> {{ $book->publication_year ?? '-' }}</p>
                    <p><strong>Sinopsis:</strong><br>{{ $book->synopsis ?? '-' }}</p>
                </div>
                <a href="{{ route('book.index') }}" class="btn btn-secondary mt-3">Kembali</a>
            </div>
        </div>

        <!-- Book Copies -->
        <div class="col-md-8 mb-4">
            <div class="card shadow-lg p-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="m-0 fw-bold">Eksemplar Buku</h5>
                    @if(in_array(Auth::user()->role, ['Superadmin', 'Admin']))
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addCopyModal">Tambah Eksemplar</button>
                    @endif
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Barcode</th>
                                <th>Kondisi</th>
                                <th>Status</th>
                                @if(in_array(Auth::user()->role, ['Superadmin', 'Admin']))
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($book->copies as $copy)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-center">
                                        <svg class="barcode"
                                            jsbarcode-format="CODE128"
                                            jsbarcode-value="{{ $copy->barcode }}"
                                            jsbarcode-textmargin="0"
                                            jsbarcode-height="40"
                                            jsbarcode-width="1.5"
                                            jsbarcode-fontsize="12">
                                        </svg>
                                    </td>
                                    <td>{{ $copy->condition }}</td>
                                    <td>
                                        <span class="badge bg-{{ $copy->status == 'Tersedia' ? 'success' : ($copy->status == 'Dipinjam' ? 'warning' : 'danger') }}">
                                            {{ $copy->status }}
                                        </span>
                                    </td>
                                    @if(in_array(Auth::user()->role, ['Superadmin', 'Admin']))
                                        <td>
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editCopyModal{{ $copy->id }}">
                                                <i class='bx bx-edit-alt'></i>
                                            </button>
                                            <form action="{{ route('book.copy.destroy', [$book, $copy]) }}" method="POST" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus eksemplar ini?')">
                                                    <i class='bx bx-trash'></i>
                                                </button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editCopyModal{{ $copy->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('book.copy.update', [$book, $copy]) }}" method="POST">
                                                @csrf @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Eksemplar</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body text-start">
                                                    <div class="mb-3">
                                                        <label class="form-label required">Barcode</label>
                                                        <input type="text" class="form-control" name="barcode" value="{{ $copy->barcode }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label required">Kondisi</label>
                                                        <select name="condition" class="form-select" required>
                                                            <option value="Baik" {{ $copy->condition == 'Baik' ? 'selected' : '' }}>Baik</option>
                                                            <option value="Rusak Sedang" {{ $copy->condition == 'Rusak Sedang' ? 'selected' : '' }}>Rusak Sedang</option>
                                                            <option value="Rusak Berat" {{ $copy->condition == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label required">Status</label>
                                                        <select name="status" class="form-select" required>
                                                            <option value="Tersedia" {{ $copy->status == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                                            <option value="Dipinjam" {{ $copy->status == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                                            <option value="Hilang" {{ $copy->status == 'Hilang' ? 'selected' : '' }}>Hilang</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada eksemplar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addCopyModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('book.copy.store', $book) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Eksemplar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-start">
                        <div class="mb-3">
                            <label class="form-label required">Barcode</label>
                            <input type="text" class="form-control" name="barcode" value="B{{ str_pad($book->id, 4, '0', STR_PAD_LEFT) }}-{{ time() % 10000 }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">Kondisi</label>
                            <select name="condition" class="form-select" required>
                                <option value="Baik">Baik</option>
                                <option value="Rusak Sedang">Rusak Sedang</option>
                                <option value="Rusak Berat">Rusak Berat</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="Tersedia">Tersedia</option>
                                <option value="Dipinjam">Dipinjam</option>
                                <option value="Hilang">Hilang</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
    <script>
        JsBarcode(".barcode").init();
    </script>
    @endpush
</x-app>
