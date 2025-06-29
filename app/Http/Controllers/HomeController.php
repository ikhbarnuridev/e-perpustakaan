<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Profile;
use App\Models\Kategori;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title = 'Dashboard';
        $iduser = Auth::id();
        $profile = Profile::where('user_id', $iduser)->first();
        $kategori = Kategori::count();
        $buku = Buku::count();
        $user = User::where('is_admin', '0')->count();
        $riwayat_pinjam = Peminjaman::with(['user', 'buku'])->orderBy('updated_at', 'desc')->get();
        $jumlah_riwayat = Peminjaman::count();
        $pinjamanUser = Peminjaman::where('user_id', $iduser)->where('tanggal_pengembalian', null)->count();

        if (Auth::user()->is_admin == 1) {
            return view('AdminDashboard', compact('title', 'kategori', 'buku', 'user', 'profile', 'riwayat_pinjam', 'jumlah_riwayat'));
        } else {
            return view('AnggotaDashboard', compact('title', 'kategori', 'buku', 'profile', 'user', 'pinjamanUser'));
        }
    }
}
