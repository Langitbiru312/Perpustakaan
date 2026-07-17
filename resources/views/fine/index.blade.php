<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="card shadow-lg p-3">
        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Anggota</th>
                        <th>Buku (Barcode)</th>
                        <th>Total Denda</th>
                        <th>Status</th>
                        <th>Tgl Lunas</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fines as $fine)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $fine->borrowing->member->user->name }}</strong><br>
                                <small class="text-muted">{{ $fine->borrowing->member->member_code }}</small>
                            </td>
                            <td>
                                <strong>{{ $fine->borrowing->bookCopy->book->title }}</strong><br>
                                <small class="text-muted">{{ $fine->borrowing->bookCopy->barcode }}</small>
                            </td>
                            <td class="text-danger fw-bold">Rp {{ number_format($fine->amount, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-{{ $fine->status == 'Lunas' ? 'success' : 'danger' }}">
                                    {{ $fine->status }}
                                </span>
                            </td>
                            <td>{{ $fine->paid_at ? $fine->paid_at->format('d M Y H:i') : '-' }}</td>
                            <td>
                                @if($fine->status == 'Belum Lunas' && in_array(Auth::user()->role, ['Superadmin', 'Admin']))
                                    <form action="{{ route('fine.pay', $fine) }}" method="POST" class="d-inline">
                                        @csrf @method('PUT')
                                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Tandai denda ini sebagai Lunas?')">
                                            <i class='bx bx-money'></i> Lunasi
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-secondary btn-sm" disabled>Selesai</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app>
