# Task 8: Reservasi Buku

## Tujuan
Anggota bisa booking buku secara online.

## Tabel Database
- ook_reservations (id, member_id, book_id, reservation_date, expiry_date, status)

## Rencana Seeder
- 5 data reservasi dummy.

## Langkah Implementasi
1. **Migration**: Buat tabel ook_reservations.
2. **Model**: Setup relasi.
3. **Controller**: Cek ketersediaan eksemplar, jika ada ubah status jadi Ready, jika tidak Menunggu.
4. **View**: Tombol reservasi di katalog anggota.

## Kriteria Selesai
- Anggota bisa mereservasi.
- Status eksemplar menyesuaikan.
