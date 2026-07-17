<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    {{-- NOTIFIKASI DENDA BELUM LUNAS --}}
    @if($unpaidFines->count() > 0)
        <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center gap-3 mb-4" role="alert">
            <i class='bx bx-error-circle fs-3 text-danger'></i>
            <div>
                <strong>Perhatian! Anda memiliki {{ $unpaidFines->count() }} tagihan denda yang belum dilunasi.</strong><br>
                <small>Total: <strong>Rp {{ number_format($unpaidFines->sum('amount'), 0, ',', '.') }}</strong>. Segera hubungi pustakawan untuk pembayaran.</small>
            </div>
        </div>
    @endif

    <div class="row g-4">
        {{-- KARTU RINGKASAN --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-center p-3 h-100">
                <div class="card-body">
                    <i class='bx bx-book-open fs-1 text-primary mb-2'></i>
                    <h2 class="fw-bold">{{ $borrowings->where('status', 'Dipinjam')->count() }}</h2>
                    <p class="text-muted mb-0">Buku Sedang Dipinjam</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-center p-3 h-100">
                <div class="card-body">
                    <i class='bx bx-time-five fs-1 text-danger mb-2'></i>
                    <h2 class="fw-bold text-danger">{{ $borrowings->where('status', 'Terlambat')->count() }}</h2>
                    <p class="text-muted mb-0">Terlambat Dikembalikan</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-center p-3 h-100">
                <div class="card-body">
                    <i class='bx bx-money fs-1 text-warning mb-2'></i>
                    <h2 class="fw-bold text-warning">Rp {{ number_format($unpaidFines->sum('amount'), 0, ',', '.') }}</h2>
                    <p class="text-muted mb-0">Total Denda Belum Lunas</p>
                </div>
            </div>
        </div>

        {{-- RIWAYAT PEMINJAMAN --}}
        <div class="col-md-12">
            <div class="card shadow-lg p-3">
                <h5 class="fw-bold mb-3 border-bottom pb-2"><i class='bx bx-transfer me-2'></i> Riwayat Peminjaman Buku</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped w-100" id="data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Buku</th>
                                <th>Barcode</th>
                                <th>Tgl Pinjam</th>
                                <th>Batas Kembali</th>
                                <th>Tgl Kembali</th>
                                <th>Status</th>
                                <th>Denda</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($borrowings as $borrowing)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-start">
                                        <strong>{{ $borrowing->bookCopy->book->title }}</strong>
                                    </td>
                                    <td>{{ $borrowing->bookCopy->barcode }}</td>
                                    <td>{{ $borrowing->borrow_date->format('d M Y') }}</td>
                                    <td>
                                        {{ $borrowing->due_date->format('d M Y') }}
                                        @if(in_array($borrowing->status, ['Dipinjam', 'Terlambat']) && now() > $borrowing->due_date)
                                            <br><small class="text-danger">
                                                (Lewat {{ now()->startOfDay()->diffInDays($borrowing->due_date->startOfDay()) }} hari)
                                            </small>
                                        @endif
                                    </td>
                                    <td>{{ $borrowing->return_date ? \Carbon\Carbon::parse($borrowing->return_date)->format('d M Y') : '-' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $borrowing->status == 'Dipinjam' ? 'warning' : ($borrowing->status == 'Dikembalikan' ? 'success' : 'danger') }}">
                                            {{ $borrowing->status }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($borrowing->fine)
                                            <span class="text-{{ $borrowing->fine->status == 'Lunas' ? 'success' : 'danger' }} fw-bold">
                                                Rp {{ number_format($borrowing->fine->amount, 0, ',', '.') }}<br>
                                                <small class="badge bg-{{ $borrowing->fine->status == 'Lunas' ? 'success' : 'danger' }}">
                                                    {{ $borrowing->fine->status }}
                                                </small>
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">Anda belum pernah meminjam buku.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- RESERVASI AKTIF --}}
        @if($activeReservations->count() > 0)
        <div class="col-md-12">
            <div class="card shadow-lg p-3">
                <h5 class="fw-bold mb-3 border-bottom pb-2"><i class='bx bx-bookmark-plus me-2'></i> Reservasi Aktif</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Buku</th>
                                <th>Tgl Reservasi</th>
                                <th>Batas Ambil</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($activeReservations as $reservation)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-start"><strong>{{ $reservation->book->title }}</strong></td>
                                    <td>{{ $reservation->reservation_date->format('d M Y') }}</td>
                                    <td>{{ $reservation->expiry_date->format('d M Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $reservation->status == 'Ready' ? 'success' : 'warning' }}">
                                            {{ $reservation->status == 'Ready' ? '✓ Siap Diambil' : 'Menunggu Stok' }}
                                        </span>
                                    </td>
                                    <td>
                                        <form action="{{ route('reservation.cancel', $reservation) }}" method="POST" class="d-inline">
                                            @csrf @method('PUT')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Batalkan reservasi ini?')">
                                                <i class='bx bx-x'></i> Batalkan
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
</x-app>
