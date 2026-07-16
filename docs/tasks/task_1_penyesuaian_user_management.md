# Task 1: Penyesuaian Sistem Autentikasi dan Manajemen Pengguna

## Tujuan
Menyesuaikan modul autentikasi dan manajemen pengguna (user management) bawaan agar selaras dengan kebutuhan PRD, khususnya untuk 3 role pengguna: Superadmin, Admin (pustakawan), dan Anggota (siswa/guru).

## Tabel Database
- users: Memastikan kolom ole mendukung Superadmin, Admin, dan Anggota.

## Rencana Seeder
- Update UserSeeder.php dengan data:
  - 1 Superadmin
  - 1 Admin
  - 5 Anggota

## Langkah Implementasi
1. **Migration**: Periksa migration users. Tambahkan kolom role jika belum ideal.
2. **Model**: Update User.php menambahkan konvensi constants untuk ROLE.
3. **Controller**: Update UserController menyesuaikan validasi form role baru.
4. **View**: Update form user/create & user/edit untuk memasukkan opsi role Anggota.

## Kriteria Selesai
- Role baru bisa dipilih dari form.
- Seeder berhasil berjalan.
