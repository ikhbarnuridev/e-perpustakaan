<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.tampil', [
            'title' => 'Profile',
            'profile' => auth()->user()->profile
        ]);
    }

    public function edit()
    {
        return view('profile.edit', [
            'title' => 'Edit Profile',
            'profile' => auth()->user()->profile
        ]);
    }

    public function update(request $request, $id)
    {
        $request->validate(
            [
                'nama' => 'required',
                'nis' => 'required',
                'email' => 'required',
                'foto' => 'nullable|mimes:jpg,jpeg,png|max:2048'
            ]
        );

        $iduser = Auth::id();
        $profile = Profile::where('user_id', $iduser)->first();
        $user = User::where('id', $iduser)->first();

        if ($request->has('foto')) {
            $path = 'images/foto/';

            File::delete($path . $profile->foto);

            $namaGambar = time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('images/foto'), $namaGambar);
            $profile->foto = $namaGambar;
            $profile->save();
        }

        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->save();

        $profile->nis = $request->nis;
        $profile->save();

        Alert::success('Sukses', 'Berhasil Mengubah Profile');

        return redirect('/profile');
    }
}
