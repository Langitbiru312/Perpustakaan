# Task 6: Peminjaman dan Pengembalian Buku

## Tujuan
Mengelola transaksi sirkulasi buku.

## Tabel Database
- orrowings (id, member_id, book_copy_id, borrow_date, due_date, return_date, status)

## Rencana Seeder
- 10 transaksi peminjaman (beberapa selesai, beberapa masih berjalan).

## Langkah Implementasi
1. **Migration**: Buat orrowings.
2. **Model**: Setup relasi.
3. **Controller**: Logika pinjam dan kembali, pembaruan status ook_copies.
4. **View**: Antarmuka untuk memindai barcode / memilih buku dan anggota.

## Kriteria Selesai
- Transaksi peminjaman mengurangi jumlah eksemplar tersedia.
