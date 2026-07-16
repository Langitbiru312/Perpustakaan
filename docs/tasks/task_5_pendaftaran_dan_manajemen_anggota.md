# Task 5: Pendaftaran dan Manajemen Anggota

## Tujuan
Mengelola data detail anggota yang terhubung ke akun user.

## Tabel Database
- members (id, user_id, member_code, phone, address, is_active)

## Rencana Seeder
- Generate profil member untuk ke-5 akun user Anggota di Task 1.

## Langkah Implementasi
1. **Migration**: Buat members.
2. **Model**: Relasi Member ke User.
3. **Controller**: Integrasikan MemberController dengan registrasi atau manajemen anggota oleh Admin.
4. **View**: Tampilan daftar anggota untuk admin, dan profil untuk anggota.

## Kriteria Selesai
- User dengan role Anggota wajib punya profil Member.
