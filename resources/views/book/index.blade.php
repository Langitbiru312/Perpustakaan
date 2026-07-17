<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    {{-- ===== TAMPILAN KATALOG CARD (UNTUK SEMUA ROLE) ===== --}}
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
                <div class="col-md-5">
                    <div class="input-group book-search-bar">
                        <span class="input-group-text bg-white border-end-0 rounded-start-pill">
                            <i class='bx bx-search text-muted'></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0 rounded-end-pill"
                            placeholder="Cari judul buku, ISBN, atau penulis..."
                            value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">
                        <i class='bx bx-search me-1'></i> Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('book.index') }}" class="btn btn-secondary">
                            <i class='bx bx-x'></i>
                        </a>
                    @endif
                </div>
                @if(in_array(Auth::user()->role, ['Superadmin', 'Admin']))
                <div class="col-md-4 text-end">
                    <a class="btn btn-success" href="{{ route('book.create') }}">
                        <i class='bx bx-plus-circle'></i> Tambah Buku
                    </a>
                </div>
                @endif
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
                                    <img src="{{ $item->cover_image ? asset('storage/' . $item->cover_image) : 'https://ui-avatars.com/api/?name=' . urlencode($item->title) . '&background=random&color=fff&size=300' }}"
                                        class="card-img-top book-cover" alt="{{ $item->title }}">
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

                                {{-- TOMBOL AKSI BERDASARKAN ROLE --}}
                                <div class="mt-auto">
                                    @if(Auth::user()->role == 'Anggota')
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
                                            <a href="#" class="btn btn-outline-secondary btn-sm w-100 disabled">
                                                <i class='bx bx-time'></i> Stok Habis
                                            </a>
                                        @endif
                                    @else
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('book.edit', $item) }}" class="btn btn-warning btn-sm flex-grow-1">
                                                <i class='bx bx-edit-alt'></i> Edit
                                            </a>
                                            <form action="{{ route('book.destroy', $item) }}" method="POST" class="d-inline flex-grow-1">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm w-100" onclick="return confirm('Yakin hapus buku ini?')">
                                                    <i class='bx bx-trash'></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @endif

</x-app>

