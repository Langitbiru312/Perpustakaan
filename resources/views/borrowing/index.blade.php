<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="card shadow-lg p-3">
        <div class="mb-3 d-flex justify-content-between">
            <a class="btn btn-primary" href="{{ route('borrowing.create') }}" role="button">Tambah Transaksi</a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Anggota</th>
                        <th>Buku (Barcode)</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($borrowings as $borrowing)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $borrowing->member->user->name }}</strong><br>
                                <small class="text-muted">{{ $borrowing->member->member_code }}</small>
                            </td>
                            <td>
                                <strong>{{ $borrowing->bookCopy->book->title }}</strong><br>
                                <small class="text-muted">{{ $borrowing->bookCopy->barcode }}</small>
                            </td>
                            <td>{{ $borrowing->borrow_date->format('d M Y') }}</td>
                            <td>{{ $borrowing->due_date->format('d M Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $borrowing->status == 'Dipinjam' ? 'warning' : ($borrowing->status == 'Dikembalikan' ? 'success' : 'danger') }}">
                                    {{ $borrowing->status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('borrowing.show', $borrowing) }}" class="btn btn-info btn-sm text-white">
                                    <i class='bx bx-show'></i> Detail
                                </a>
                                @if($borrowing->status == 'Dipinjam' || $borrowing->status == 'Terlambat')
                                    <form action="{{ route('borrowing.return', $borrowing) }}" method="POST" class="d-inline">
                                        @csrf @method('PUT')
                                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Proses pengembalian buku?')">
                                            <i class='bx bx-check'></i> Kembali
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app>
