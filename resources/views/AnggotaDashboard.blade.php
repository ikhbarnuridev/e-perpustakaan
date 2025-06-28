@extends('layouts.master')

@section('topbar')
    @include('part.topbar')
@endsection

@section('sidebar')
    @include('part.sidebar')
@endsection

@section('judul')
    <h2 class="text-primary"> Selamat Datang, {{ Auth::user()->name }}</h2>
@endsection

@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <div class="card bg-gradient-secondary">
                <div class="container">
                    <h3 class="text-light"> <i class="fa-solid fa-circle-info text-light my-3"></i> Informasi Aturan
                        Peminjaaman
                    </h3>
                    <ol class=text-light>
                        <li class=text-light>Waktu peminjaman maksimal 1 minggu</li>
                        <li class=text-light>Setiap anggota hanya dapat meminjam maksima 3 buku</li>
                        <li class=text-light>Jika pengenbalian buku lebih dari waktu yang ditentukan akan diberikan denda
                            setiap
                            buku Rp.15.000/minggu.</li>
                        <li class=text-light>Jika telah meminjam buku,silahkan ke tempat petugas untuk melakukan konfirmasi
                        </li>
                        <li class=text-light>Jika Terlambat mengembalikan buku dan mendapat denda, maka wajib langsung
                            membayar pada
                            petugas saat mengembalikan buku</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection
