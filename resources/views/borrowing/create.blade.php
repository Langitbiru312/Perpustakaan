<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="card shadow-lg p-3">
        <form action="{{ route('borrowing.store') }}" method="post">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="member_id" class="form-label required">Anggota Peminjam</label>
                    <select name="member_id" id="member_id" class="form-select @error('member_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Anggota --</option>
                        @foreach($members as $member)
                            <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                {{ $member->member_code }} - {{ $member->user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('member_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="book_copy_id" class="form-label required">Buku (Eksemplar)</label>
                    <select name="book_copy_id" id="book_copy_id" class="form-select @error('book_copy_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Buku (Barcode) --</option>
                        @foreach($copies as $copy)
                            <option value="{{ $copy->id }}" {{ old('book_copy_id') == $copy->id ? 'selected' : '' }}>
                                {{ $copy->barcode }} - {{ $copy->book->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('book_copy_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="borrow_date" class="form-label required">Tanggal Pinjam</label>
                    <input class="form-control @error('borrow_date') is-invalid @enderror" type="date" id="borrow_date" name="borrow_date" required value="{{ old('borrow_date', date('Y-m-d')) }}">
                    @error('borrow_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="due_date" class="form-label required">Tanggal Jatuh Tempo (Max 7 Hari)</label>
                    <input class="form-control @error('due_date') is-invalid @enderror" type="date" id="due_date" name="due_date" required value="{{ old('due_date', date('Y-m-d', strtotime('+7 days'))) }}">
                    @error('due_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="col-md-12 mb-3">
                    <label for="notes" class="form-label">Catatan Tambahan</label>
                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                    @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            
            <div class="text-end">
                <a href="{{ route('borrowing.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
            </div>
        </form>
    </div>
</x-app>
