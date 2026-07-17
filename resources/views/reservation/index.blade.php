<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="card shadow-lg p-3">
        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Anggota</th>
                        <th>Buku</th>
                        <th>Tgl Reservasi</th>
                        <th>Batas Ambil</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservations as $reservation)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $reservation->member->user->name }}</strong><br>
                                <small class="text-muted">{{ $reservation->member->member_code }}</small>
                            </td>
                            <td>
                                <strong>{{ $reservation->book->title }}</strong><br>
                                @if($reservation->bookCopy)
                                    <small class="text-success">Barcode: {{ $reservation->bookCopy->barcode }}</small>
                                @else
                                    <small class="text-warning">Menunggu Ketersediaan</small>
                                @endif
                            </td>
                            <td>{{ $reservation->reservation_date->format('d M Y') }}</td>
                            <td>{{ $reservation->expiry_date->format('d M Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $reservation->status == 'Ready' ? 'success' : ($reservation->status == 'Menunggu' ? 'warning' : 'secondary') }}">
                                    {{ $reservation->status }}
                                </span>
                            </td>
                            <td>
                                @if(in_array($reservation->status, ['Menunggu', 'Ready']) && (Auth::user()->role !== 'Anggota' || Auth::user()->member->id == $reservation->member_id))
                                    <form action="{{ route('reservation.cancel', $reservation) }}" method="POST" class="d-inline">
                                        @csrf @method('PUT')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Batalkan reservasi ini?')">
                                            <i class='bx bx-x'></i> Batal
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
