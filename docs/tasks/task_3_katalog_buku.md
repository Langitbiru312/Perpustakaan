# Task 3: Katalog Buku

## Tujuan
Membuat fitur katalog buku yang menggabungkan data master.

## Tabel Database
- ooks (id, title, isbn, category_id, author_id, publisher_id, publication_year, synopsis, cover_image)

## Rencana Seeder
- BookSeeder.php menggunakan data dummy 20 buku dengan relasi ke data master.

## Langkah Implementasi
1. **Migration**: Buat tabel ooks dengan foreign keys.
2. **Model**: Setup relasi di model Book.php.
3. **Controller**: BookController dengan logika pencarian/filter.
4. **View**: Tampilan katalog yang rapi untuk Admin dan Anggota.

## Kriteria Selesai
- Buku bisa di-CRUD.
- Pencarian berfungsi.
