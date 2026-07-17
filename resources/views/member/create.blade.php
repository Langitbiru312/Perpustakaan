<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="card shadow-lg p-3">
        <form action="{{ route('member.store') }}" method="post">
            @csrf

            <h6 class="fw-bold text-primary mb-3 border-bottom pb-2">
                <i class='bx bx-lock-alt me-1'></i> Data Akun Login
            </h6>

            <div class="mb-3">
                <label for="name" class="form-label required">Nama Lengkap</label>
                <input class="form-control @error('name') is-invalid @enderror"
                    type="text" id="name" name="name"
                    placeholder="Masukkan nama lengkap anggota"
                    value="{{ old('name') }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label required">Email</label>
                <input class="form-control @error('email') is-invalid @enderror"
                    type="email" id="email" name="email"
                    placeholder="contoh@gmail.com"
                    value="{{ old('email') }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label required">Password</label>
                <input class="form-control @error('password') is-invalid @enderror"
                    type="password" id="password" name="password"
                    placeholder="Minimal 6 karakter" required>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <h6 class="fw-bold text-primary mb-3 border-bottom pb-2 mt-4">
                <i class='bx bx-id-card me-1'></i> Data Keanggotaan
            </h6>

            <div class="mb-3">
                <label for="member_code" class="form-label required">Kode Anggota</label>
                <input class="form-control @error('member_code') is-invalid @enderror"
                    type="text" id="member_code" name="member_code"
                    required value="{{ old('member_code', 'MBR-' . str_pad(rand(1,9999), 4, '0', STR_PAD_LEFT)) }}">
                @error('member_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">No. HP</label>
                <input class="form-control @error('phone') is-invalid @enderror"
                    type="text" id="phone" name="phone"
                    placeholder="Nomor HP aktif"
                    value="{{ old('phone') }}">
                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Alamat</label>
                <textarea class="form-control @error('address') is-invalid @enderror"
                    id="address" name="address" rows="2"
                    placeholder="Alamat lengkap">{{ old('address') }}</textarea>
                @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3 form-check">
                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" checked>
                <label class="form-check-label" for="is_active">Anggota Aktif</label>
            </div>

            <div class="text-end">
                <a href="{{ route('member.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i class='bx bx-save me-1'></i> Simpan
                </button>
            </div>
        </form>
    </div>
</x-app>
