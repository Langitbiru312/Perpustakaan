<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="card shadow-lg p-3">
        <form action="{{ route('member.store') }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="user_id" class="form-label required">Akun User (Anggota)</label>
                <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                    <option value="">-- Pilih User --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="member_code" class="form-label required">Kode Anggota</label>
                <input class="form-control @error('member_code') is-invalid @enderror" type="text" id="member_code" name="member_code" required value="{{ old('member_code', 'MBR-' . str_pad(rand(1,9999), 4, '0', STR_PAD_LEFT)) }}">
                @error('member_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">No. HP</label>
                <input class="form-control @error('phone') is-invalid @enderror" type="text" id="phone" name="phone" value="{{ old('phone') }}">
                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Alamat</label>
                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2">{{ old('address') }}</textarea>
                @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3 form-check">
                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" checked>
                <label class="form-check-label" for="is_active">Anggota Aktif</label>
            </div>
            <div class="text-end">
                <a href="{{ route('member.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</x-app>
