# Task 7: Perhitungan Denda Otomatis

## Tujuan
Menghitung denda secara otomatis jika buku terlambat.

## Tabel Database
- ines (id, borrowing_id, amount, status, paid_at)

## Rencana Seeder
- 3 data peminjaman terlambat dengan denda aktif.

## Langkah Implementasi
1. **Migration**: Buat ines.
2. **Model**: Setup relasi dengan Borrowing.
3. **Controller**: Hitung selisih hari jika terlambat.
4. **View**: Tampilan notifikasi denda di profil anggota dan halaman admin.

## Kriteria Selesai
- Denda ter-*generate* ketika status dipinjam -> kembali terlambat.
