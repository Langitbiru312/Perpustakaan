<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Member;
use App\Models\User;

class MemberController extends Controller
{
    public function index()
    {
        return view('member.index', [
            'title' => 'Data Anggota',
            'members' => Member::with('user')->latest()->get()
        ]);
    }

    public function create()
    {
        return view('member.create', [
            'title' => 'Tambah Anggota',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|min:6',
            'member_code' => 'required|unique:members,member_code',
            'phone'       => 'nullable',
            'address'     => 'nullable',
            'is_active'   => 'boolean',
        ], [
            'name.required'        => 'Nama wajib diisi.',
            'email.required'       => 'Email wajib diisi.',
            'email.unique'         => 'Email sudah terdaftar.',
            'password.required'    => 'Password wajib diisi.',
            'password.min'         => 'Password minimal 6 karakter.',
            'member_code.required' => 'Kode anggota wajib diisi.',
            'member_code.unique'   => 'Kode anggota sudah digunakan.',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => $request->password,
                'role'     => 'Anggota',
            ]);

            Member::create([
                'user_id'     => $user->id,
                'member_code' => $request->member_code,
                'phone'       => $request->phone,
                'address'     => $request->address,
                'is_active'   => $request->has('is_active'),
            ]);
        });

        return to_route('member.index')->withSuccess('Anggota berhasil ditambahkan.');
    }

    public function show(Member $member)
    {
        return view('member.show', [
            'title'  => 'Detail Anggota',
            'member' => $member->load('user')
        ]);
    }

    public function edit(Member $member)
    {
        return view('member.edit', [
            'title'  => 'Edit Anggota',
            'member' => $member->load('user'),
        ]);
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email,' . $member->user_id,
            'member_code' => 'required|unique:members,member_code,' . $member->id,
            'phone'       => 'nullable',
            'address'     => 'nullable',
        ], [
            'name.required'        => 'Nama wajib diisi.',
            'email.required'       => 'Email wajib diisi.',
            'email.unique'         => 'Email sudah digunakan akun lain.',
            'member_code.required' => 'Kode anggota wajib diisi.',
            'member_code.unique'   => 'Kode anggota sudah digunakan.',
        ]);

        DB::transaction(function () use ($request, $member) {
            $member->user->update([
                'name'  => $request->name,
                'email' => $request->email,
            ]);

            $member->update([
                'member_code' => $request->member_code,
                'phone'       => $request->phone,
                'address'     => $request->address,
                'is_active'   => $request->has('is_active'),
            ]);
        });

        return to_route('member.index')->withSuccess('Data anggota berhasil diubah.');
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return to_route('member.index')->withSuccess('Anggota berhasil dihapus.');
    }
}
