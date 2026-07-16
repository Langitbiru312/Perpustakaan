# Task 2: Master Data Kategori, Penulis, Penerbit

## Tujuan
Mengelola master data yang menjadi dependensi utama bagi katalog buku.

## Tabel Database
- categories (id, name, slug)
- uthors (id, name)
- publishers (id, name, address)

## Rencana Seeder
- Buat seeder dengan minimal: 5 Kategori, 5 Penulis, 5 Penerbit menggunakan Faker.

## Langkah Implementasi
1. **Migration**: Buat tabel categories, uthors, publishers.
2. **Model**: Buat model beserta relasinya nanti ke buku.
3. **Controller**: Buat CRUD Controller masing-masing.
4. **View**: Sediakan halaman index, create, edit.

## Kriteria Selesai
- Semua tabel dibuat.
- Admin bisa mengelola master data ini melalui UI.
