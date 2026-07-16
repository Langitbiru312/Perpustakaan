# Task 4: Manajemen Eksemplar Buku

## Tujuan
Mengelola jumlah salinan fisik dari setiap judul buku.

## Tabel Database
- ook_copies (id, book_id, barcode, condition, status)

## Rencana Seeder
- Masing-masing buku di-*seed* minimal 3 eksemplar.

## Langkah Implementasi
1. **Migration**: Buat ook_copies.
2. **Model**: Relasi ke Book.
3. **Controller**: CRUD khusus eksemplar di bawah detail buku.
4. **View**: Halaman detail buku memuat daftar eksemplar dan generator barcode.

## Kriteria Selesai
- Eksemplar tercatat unik berdasarkan barcode.
