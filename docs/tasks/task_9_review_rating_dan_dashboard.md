# Task 9: Review, Rating, dan Dashboard Laporan

## Tujuan
Memberi ulasan buku dan membuat dashboard statistik untuk admin.

## Tabel Database
- ook_reviews (id, member_id, book_id, rating, review)

## Rencana Seeder
- Ulasan acak untuk beberapa buku.

## Langkah Implementasi
1. **Migration**: Buat ook_reviews.
2. **Model**: Setup relasi.
3. **Controller**:
   - ReviewController untuk submit rating.
   - DashboardController untuk *query* statistik.
4. **View**:
   - Bintang rating di halaman detail buku.
   - Dashboard admin menampilkan grafik/angka ringkasan.

## Kriteria Selesai
- Dashboard tampil sempurna.
- Rating buku ditampilkan secara agregat.
