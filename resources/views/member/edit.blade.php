<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="card shadow-lg p-3">
        <form action="{{ route('member.update', $member) }}" method="post">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Akun User</label>
                <input class="form-control" type="text" value="{{ $member->user->name }} ({{ $member->user->email }})" disabled>
            </div>
            <div class="mb-3">
                <label for="member_code" class="form-label required">Kode Anggota</label>
                <input class="form-control @error('member_code') is-invalid @enderror" type="text" id="member_code" name="member_code" required value="{{ old('member_code', $member->member_code) }}">
                @error('member_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">No. HP</label>
                <input class="form-control @error('phone') is-invalid @enderror" type="text" id="phone" name="phone" value="{{ old('phone', $member->phone) }}">
                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Alamat</label>
                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2">{{ old('address', $member->address) }}</textarea>
                @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3 form-check">
                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{ $member->is_active ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Anggota Aktif</label>
            </div>
            <div class="text-end">
                <a href="{{ route('member.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</x-app>
