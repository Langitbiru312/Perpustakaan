<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="card shadow-lg p-3">
        <div class="mb-3 d-flex justify-content-between">
            @if(Auth::user()->role == 'Superadmin' || Auth::user()->role == 'Admin')
                <a class="btn btn-primary" href="{{ route('book.create') }}" role="button">Tambah Buku</a>
            @else
                <div></div>
            @endif
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
                        @if(Auth::user()->role == 'Superadmin' || Auth::user()->role == 'Admin')
                            <th scope="col">Action</th>
                        @endif
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
                            <td>{{ $item->title }}<br><small class="text-muted">ISBN: {{ $item->isbn ?? '-' }}</small></td>
                            <td>{{ $item->category->name }}</td>
                            <td>{{ $item->author->name }}</td>
                            <td>{{ $item->publisher->name }}</td>
                            <td>{{ $item->publication_year }}</td>
                            @if(Auth::user()->role == 'Superadmin' || Auth::user()->role == 'Admin')
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
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app>
