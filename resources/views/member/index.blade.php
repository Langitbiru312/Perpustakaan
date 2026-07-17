<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="card shadow-lg p-3">
        <div class="mb-3">
            <a class="btn btn-primary" href="{{ route('member.create') }}" role="button">Tambah Anggota</a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Anggota</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. HP</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $member)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><span class="badge bg-secondary">{{ $member->member_code }}</span></td>
                            <td>{{ $member->user->name }}</td>
                            <td>{{ $member->user->email }}</td>
                            <td>{{ $member->phone ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $member->is_active ? 'success' : 'danger' }}">
                                    {{ $member->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('member.edit', $member) }}" class="btn btn-warning btn-sm">
                                    <i class='bx bx-edit-alt'></i>
                                </a>
                                <form action="{{ route('member.destroy', $member) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus anggota ini?')">
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
</x-app>
