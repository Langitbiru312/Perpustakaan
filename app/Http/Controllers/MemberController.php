<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
            'users' => User::where('role', 'Anggota')->whereDoesntHave('member')->get()
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'user_id' => 'required|exists:users,id|unique:members,user_id',
            'member_code' => 'required|unique:members,member_code',
            'phone' => 'nullable',
            'address' => 'nullable',
            'is_active' => 'boolean',
        ]);
        $validate['is_active'] = $request->has('is_active');
        Member::create($validate);
        return to_route('member.index')->withSuccess('Anggota berhasil ditambahkan');
    }

    public function show(Member $member)
    {
        return view('member.show', [
            'title' => 'Detail Anggota',
            'member' => $member->load('user')
        ]);
    }

    public function edit(Member $member)
    {
        return view('member.edit', [
            'title' => 'Edit Anggota',
            'member' => $member,
            'users' => User::where('role', 'Anggota')->get()
        ]);
    }

    public function update(Request $request, Member $member)
    {
        $validate = $request->validate([
            'member_code' => 'required|unique:members,member_code,' . $member->id,
            'phone' => 'nullable',
            'address' => 'nullable',
        ]);
        $validate['is_active'] = $request->has('is_active');
        $member->update($validate);
        return to_route('member.index')->withSuccess('Anggota berhasil diubah');
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return to_route('member.index')->withSuccess('Anggota berhasil dihapus');
    }
}
