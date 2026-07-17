<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <!-- Welcome Card -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3 class="fw-bold mb-3">
                        <i class='bx bx-smile text-primary me-2'></i>
                        Selamat Datang, {{ Auth::user()->name }}!
                    </h3>
                    <p class="text-muted mb-0">
                        Anda login sebagai <span class="badge bg-primary">{{ Auth::user()->role }}</span>
                    </p>
                    <p class="text-muted mt-2">
                        <i class='bx bx-time-five me-1'></i>
                        {{ now()->isoFormat('dddd, D MMMM YYYY - HH:mm') }}
                    </p>
                </div>
                <div class="col-md-4 text-center">
                    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('niceadmin/img/noprofil.png') }}"
                        alt="Avatar" class="img-fluid rounded-circle border border-3 border-primary"
                        style="max-width: 150px;">
                </div>
            </div>
        </div>
    </div>

    @if(Auth::user()->role == 'Anggota')
        <!-- DASHBOARD SISWA -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Buku Sedang Dipinjam</p>
                                <h2 class="fw-bold mb-0">{{ $activeBorrowings }}</h2>
                            </div>
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                <i class='bx bx-book-reader fs-2 text-primary'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Reservasi Aktif</p>
                                <h2 class="fw-bold mb-0">{{ $activeReservations }}</h2>
                            </div>
                            <div class="bg-info bg-opacity-10 rounded-circle p-3">
                                <i class='bx bx-bookmark-plus fs-2 text-info'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Total Denda Belum Lunas</p>
                                <h2 class="fw-bold mb-0 text-danger">Rp {{ number_format($unpaidFines, 0, ',', '.') }}</h2>
                            </div>
                            <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                                <i class='bx bx-wallet fs-2 text-danger'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom">
                <h6 class="mb-0 fw-bold">
                    <i class='bx bx-history me-2 text-primary'></i>
                    Riwayat Peminjaman Terakhir
                </h6>
            </div>
            <div class="card-body">
                @if($recentBorrowings->isEmpty())
                    <p class="text-muted text-center my-4">Belum ada riwayat peminjaman.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Buku</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Batas Kembali</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentBorrowings as $borrow)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $borrow->bookCopy->book->title }} ({{ $borrow->bookCopy->copy_number }})</td>
                                        <td>{{ $borrow->borrow_date->format('d/m/Y') }}</td>
                                        <td>{{ $borrow->due_date->format('d/m/Y') }}</td>
                                        <td>
                                            @if($borrow->return_date)
                                                <span class="badge bg-success">Dikembalikan</span>
                                            @else
                                                <span class="badge bg-warning">Dipinjam</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                <div class="text-end mt-3">
                    <a href="{{ route('riwayat.index') }}" class="btn btn-primary btn-sm">Lihat Semua Riwayat</a>
                </div>
            </div>
        </div>
    @else
        <!-- DASHBOARD ADMIN / SUPERADMIN -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Total Buku</p>
                                <h2 class="fw-bold mb-0">{{ $stats['books'] }}</h2>
                            </div>
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                <i class='bx bx-book fs-2 text-primary'></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-primary bg-opacity-10 border-0 py-2">
                        <a href="{{ route('book.index') }}" class="text-primary fw-semibold text-decoration-none small">Lihat Detail <i class='bx bx-right-arrow-alt'></i></a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Total Anggota</p>
                                <h2 class="fw-bold mb-0">{{ $stats['members'] }}</h2>
                            </div>
                            <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                <i class='bx bx-id-card fs-2 text-success'></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-success bg-opacity-10 border-0 py-2">
                        <a href="{{ route('member.index') }}" class="text-success fw-semibold text-decoration-none small">Lihat Detail <i class='bx bx-right-arrow-alt'></i></a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Total Peminjaman</p>
                                <h2 class="fw-bold mb-0">{{ $stats['borrowings'] }}</h2>
                            </div>
                            <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                                <i class='bx bx-transfer fs-2 text-warning'></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-warning bg-opacity-10 border-0 py-2">
                        <a href="{{ route('borrowing.index') }}" class="text-warning fw-semibold text-decoration-none small">Lihat Detail <i class='bx bx-right-arrow-alt'></i></a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1 small">Total Reservasi</p>
                                <h2 class="fw-bold mb-0">{{ $stats['reservations'] }}</h2>
                            </div>
                            <div class="bg-info bg-opacity-10 rounded-circle p-3">
                                <i class='bx bx-bookmark-plus fs-2 text-info'></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-info bg-opacity-10 border-0 py-2">
                        <a href="{{ route('reservation.index') }}" class="text-info fw-semibold text-decoration-none small">Lihat Detail <i class='bx bx-right-arrow-alt'></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0 fw-bold">
                    <i class='bx bx-rocket me-2 text-primary'></i>
                    Akses Cepat
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3 mt-2">
                    <div class="col-md-3">
                        <a href="{{ route('user.index') }}" class="text-decoration-none">
                            <div class="card border border-primary border-opacity-25 h-100 hover-shadow">
                                <div class="card-body text-center mt-4">
                                    <i class='bx bx-user-plus fs-1 text-primary mb-2'></i>
                                    <h6 class="mb-0">Kelola Pengguna</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('setting.index') }}" class="text-decoration-none">
                            <div class="card border border-success border-opacity-25 h-100 hover-shadow">
                                <div class="card-body text-center mt-4">
                                    <i class='bx bx-cog fs-1 text-success mb-2'></i>
                                    <h6 class="mb-0">Pengaturan</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('dashboard.show') }}" class="text-decoration-none">
                            <div class="card border border-info border-opacity-25 h-100 hover-shadow">
                                <div class="card-body text-center mt-4">
                                    <i class='bx bx-user-circle fs-1 text-info mb-2'></i>
                                    <h6 class="mb-0">Profil Saya</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('dashboard.edit') }}" class="text-decoration-none">
                            <div class="card border border-warning border-opacity-25 h-100 hover-shadow">
                                <div class="card-body text-center mt-4">
                                    <i class='bx bx-edit fs-1 text-warning mb-2'></i>
                                    <h6 class="mb-0">Edit Profil</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Information -->
        <div class="row g-3">
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0 fw-bold">
                            <i class='bx bx-info-circle me-2 text-primary'></i>
                            Informasi Sistem
                        </h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0 pt-4">
                            <li class="mb-2">
                                <i class='bx bx-check-circle text-success me-2'></i>
                                <strong>Versi Laravel:</strong> {{ app()->version() }}
                            </li>
                            <li class="mb-2">
                                <i class='bx bx-check-circle text-success me-2'></i>
                                <strong>Versi PHP:</strong> {{ PHP_VERSION }}
                            </li>
                            <li class="mb-2">
                                <i class='bx bx-check-circle text-success me-2'></i>
                                <strong>Environment:</strong> {{ config('app.env') }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm border-0 pt-4">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0 fw-bold">
                            <i class='bx bx-user me-2 text-primary'></i>
                            Akun Anda
                        </h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class='bx bx-envelope text-primary me-2'></i>
                                <strong>Email:</strong> {{ Auth::user()->email }}
                            </li>
                            <li class="mb-2">
                                <i class='bx bx-calendar text-primary me-2'></i>
                                <strong>Terdaftar Sejak:</strong> {{ Auth::user()->created_at->format('d M Y') }}
                            </li>
                            <li class="mb-2">
                                <i class='bx bx-time text-primary me-2'></i>
                                <strong>Terakhir Diperbarui:</strong> {{ Auth::user()->updated_at->diffForHumans() }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

</x-app>
