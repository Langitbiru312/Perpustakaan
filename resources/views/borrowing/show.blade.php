<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-lg p-4 h-100">
                <h5 class="fw-bold mb-3 border-bottom pb-2"><i class='bx bx-user me-2'></i> Data Peminjam</h5>
                <p class="mb-1"><strong>Kode Anggota:</strong> {{ $borrowing->member->member_code }}</p>
                <p class="mb-1"><strong>Nama Lengkap:</strong> {{ $borrowing->member->user->name }}</p>
                <p class="mb-1"><strong>Email:</strong> {{ $borrowing->member->user->email }}</p>
                <p class="mb-1"><strong>No. HP:</strong> {{ $borrowing->member->phone ?? '-' }}</p>
                <p class="mb-0"><strong>Alamat:</strong> {{ $borrowing->member->address ?? '-' }}</p>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow-lg p-4 h-100">
                <h5 class="fw-bold mb-3 border-bottom pb-2"><i class='bx bx-book-alt me-2'></i> Data Buku</h5>
                <p class="mb-1"><strong>Barcode Eksemplar:</strong> <span class="badge bg-secondary">{{ $borrowing->bookCopy->barcode }}</span></p>
                <p class="mb-1"><strong>Judul Buku:</strong> {{ $borrowing->bookCopy->book->title }}</p>
                <p class="mb-1"><strong>Kategori:</strong> {{ $borrowing->bookCopy->book->category->name }}</p>
                <p class="mb-1"><strong>Kondisi Saat Ini:</strong> {{ $borrowing->bookCopy->condition }}</p>
                <p class="mb-0"><strong>Tahun Terbit:</strong> {{ $borrowing->bookCopy->book->publication_year ?? '-' }}</p>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card shadow-lg p-4 text-center">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Status Transaksi</h5>
                <div class="row justify-content-center">
                    <div class="col-md-3 mb-3">
                        <div class="p-3 border rounded bg-light">
                            <small class="text-muted d-block">Tanggal Pinjam</small>
                            <strong>{{ $borrowing->borrow_date->format('d M Y') }}</strong>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="p-3 border rounded bg-light">
                            <small class="text-muted d-block">Batas Pengembalian</small>
                            <strong>{{ $borrowing->due_date->format('d M Y') }}</strong>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="p-3 border rounded bg-light">
                            <small class="text-muted d-block">Tanggal Kembali</small>
                            <strong>{{ $borrowing->return_date ? $borrowing->return_date->format('d M Y') : '-' }}</strong>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="p-3 border rounded bg-light">
                            <small class="text-muted d-block">Status</small>
                            <span class="badge fs-6 mt-1 bg-{{ $borrowing->status == 'Dipinjam' ? 'warning' : ($borrowing->status == 'Dikembalikan' ? 'success' : 'danger') }}">
                                {{ $borrowing->status }}
                            </span>
                        </div>
                    </div>
                </div>

                @if($borrowing->notes)
                <div class="mt-3 text-start bg-light p-3 rounded">
                    <strong>Catatan:</strong><br>
                    {{ $borrowing->notes }}
                </div>
                @endif

                <div class="mt-4">
                    <a href="{{ route('borrowing.index') }}" class="btn btn-secondary me-2">Kembali</a>
                    
                    @if($borrowing->status == 'Dipinjam' || $borrowing->status == 'Terlambat')
                        <form action="{{ route('borrowing.return', $borrowing) }}" method="POST" class="d-inline">
                            @csrf @method('PUT')
                            <button type="submit" class="btn btn-success" onclick="return confirm('Proses pengembalian buku ini?')">
                                <i class='bx bx-check'></i> Proses Pengembalian
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app>
