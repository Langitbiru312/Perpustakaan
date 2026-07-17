<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    @if(Auth::user()->role == 'Anggota')
        {{-- ===== TAMPILAN KATALOG CARD UNTUK SISWA ===== --}}
        <style>
            .book-card {
                border: none;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 2px 12px rgba(0,0,0,0.1);
                transition: transform 0.25s ease, box-shadow 0.25s ease;
                height: 100%;
            }
            .book-card:hover {
                transform: translateY(-6px);
                box-shadow: 0 12px 28px rgba(0,0,80,0.18);
            }
            .book-card .cover-wrap {
                position: relative;
                overflow: hidden;
                height: 240px;
                background: #f0f0f5;
            }
            .book-card .cover-wrap img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.3s ease;
            }
            .book-card:hover .cover-wrap img {
                transform: scale(1.05);
            }
            .book-card .cover-wrap .status-badge {
                position: absolute;
                top: 10px;
                right: 10px;
            }
            .book-card .rating-stars {
                color: #f5a623;
                font-size: 0.85rem;
            }
            .book-search-bar input {
                border-radius: 50px;
                padding-left: 1.2rem;
            }
        </style>

        {{-- SEARCH & FILTER BAR --}}
        <div class="card shadow-sm border-0 p-3 mb-4">
            <form method="GET" action="{{ route('book.index') }}" class="row g-3 align-items-center">
                <div class="col-md-8">
                    <div class="input-group book-search-bar">
                        <span class="input-group-text bg-white border-end-0 rounded-start-pill">
                            <i class='bx bx-search text-muted'></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0 rounded-end-pill"
                            placeholder="Cari judul buku, ISBN, atau penulis..."
                            value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">
                        <i class='bx bx-search me-1'></i> Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('book.index') }}" class="btn btn-secondary">
                            <i class='bx bx-x'></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- STATS BAR --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <p class="text-muted mb-0">
                Menampilkan <strong>{{ $books->count() }}</strong> buku
                @if(request('search'))
                    untuk pencarian "<strong>{{ request('search') }}</strong>"
                @endif
            </p>
            <small class="text-muted"><i class='bx bx-info-circle me-1'></i>Klik cover untuk detail · Tombol Reservasi untuk booking online</small>
        </div>

        {{-- GRID BOOK CARDS --}}
        @if($books->isEmpty())
            <div class="text-center py-5">
                <i class='bx bx-book-open fs-1 text-muted'></i>
                <p class="text-muted mt-2">Tidak ada buku yang ditemukan.</p>
            </div>
        @else
            <div class="row g-4">
                @foreach ($books as $item)
                    @php
                        $avgRating = $item->reviews->avg('rating');
                        $totalCopies = $item->copies->count();
                        $availableCopies = $item->copies->where('status', 'Tersedia')->count();
                    @endphp
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="book-card card">
                            {{-- COVER --}}
                            <a href="{{ route('book.show', $item) }}" class="text-decoration-none">
                                <div class="cover-wrap">
                                    <img src="{{ $item->cover_image ? asset('storage/' . $item->cover_image) : asset('niceadmin/img/notfound.png') }}"
                                        alt="{{ $item->title }}">
                                    <span class="status-badge badge bg-{{ $availableCopies > 0 ? 'success' : 'danger' }}">
                                        {{ $availableCopies > 0 ? 'Tersedia' : 'Habis' }}
                                    </span>
                                </div>
                            </a>

                            <div class="card-body d-flex flex-column p-3">
                                {{-- JUDUL --}}
                                <a href="{{ route('book.show', $item) }}" class="text-decoration-none text-dark">
                                    <h6 class="fw-bold mb-1 lh-sm" style="font-size: 0.9rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                        {{ $item->title }}
                                    </h6>
                                </a>
                                <p class="text-muted mb-1" style="font-size: 0.78rem;">{{ $item->author->name }}</p>

                                {{-- RATING --}}
                                <div class="rating-stars mb-1">
                                    @if($avgRating)
                                        @for($i = 1; $i <= 5; $i++)
                                            {!! $i <= round($avgRating) ? '&#9733;' : '&#9734;' !!}
                                        @endfor
                                        <small class="text-muted ms-1">({{ $item->reviews->count() }})</small>
                                    @else
                                        <small class="text-muted">Belum ada ulasan</small>
                                    @endif
                                </div>

                                {{-- KATEGORI --}}
                                <span class="badge rounded-pill mb-2" style="background:#000080; font-size:0.7rem; width: fit-content;">
                                    {{ $item->category->name }}
                                </span>

                                {{-- STOK --}}
                                <p class="text-muted mb-2" style="font-size: 0.75rem;">
                                    <i class='bx bx-copy-alt me-1'></i>{{ $availableCopies }}/{{ $totalCopies }} eksemplar tersedia
                                </p>

                                {{-- TOMBOL RESERVASI --}}
                                <div class="mt-auto">
                                    @if($availableCopies > 0)
                                        <form action="{{ route('reservation.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="book_id" value="{{ $item->id }}">
                                            <button type="submit" class="btn btn-primary btn-sm w-100"
                                                onclick="return confirm('Reservasi buku ini?')">
                                                <i class='bx bx-bookmark-plus'></i> Reservasi
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('reservation.store') }}" class="btn btn-outline-secondary btn-sm w-100 disabled">
                                            <i class='bx bx-time'></i> Stok Habis
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    @else
        {{-- ===== TAMPILAN TABEL UNTUK ADMIN/SUPERADMIN ===== --}}
        <div class="card shadow-lg p-3">
            <div class="mb-3 d-flex justify-content-between">
                <a class="btn btn-primary" href="{{ route('book.create') }}" role="button">Tambah Buku</a>
                <form method="GET" action="{{ route('book.index') }}" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control" placeholder="Cari buku..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary"><i class='bx bx-search'></i></button>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped w-100" id="data-table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Cover</th>
                            <th scope="col">Judul</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Penulis</th>
                            <th scope="col">Penerbit</th>
                            <th scope="col">Tahun</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($books as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if($item->cover_image)
                                        <img src="{{ asset('storage/' . $item->cover_image) }}" alt="Cover" width="50">
                                    @else
                                        <img src="{{ asset('niceadmin/img/notfound.png') }}" alt="No Cover" width="50">
                                    @endif
                                </td>
                                <td class="text-start">
                                    <a href="{{ route('book.show', $item) }}" class="text-decoration-none fw-bold">{{ $item->title }}</a>
                                    <br><small class="text-muted">ISBN: {{ $item->isbn ?? '-' }}</small>
                                </td>
                                <td>{{ $item->category->name }}</td>
                                <td>{{ $item->author->name }}</td>
                                <td>{{ $item->publisher->name }}</td>
                                <td>{{ $item->publication_year }}</td>
                                <td>
                                    <a href="{{ route('book.edit', $item) }}" class="btn btn-warning btn-sm">
                                        <i class='bx bx-edit-alt'></i>
                                    </a>
                                    <form action="{{ route('book.destroy', $item) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">
                                            <i class='bx bx-trash'></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</x-app>

