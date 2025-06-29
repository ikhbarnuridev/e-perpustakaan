@extends('layouts.master')

@section('sidebar')
    @include('part.sidebar')
@endsection

@section('topbar')
    @include('part.topbar')
@endsection

@section('judul')
    <h1 class="text-primary">Profile</h1>
@endsection

@section('content')
    <div class="card pt-4">
        <div class="row">
            <div class="col-auto ml-5 mr-5 my-4">
                @if ($profile->foto != null)
                    <img src="{{ asset('/images/foto/' . $profile->foto) }}"
                        style="width:150px;height:150px;border-radius:100px">
                @else
                    <img src="{{ asset('assets/template/img/boy.png') }}" style="width:100px;height:100px;border-radius:50px">
                @endif
            </div>
            <div class="col-auto mx-4">
                <div class="form-group mb-3">
                    <label for="nama" class="text-lg text-primary font-weight-bold">Nama Lengkap</label>
                    <h4>{{ $profile->user->nama }}</h4>
                </div>

                <div class="form-group mb-3">
                    <label for="nis" class="text-lg text-primary font-weight-bold">Nomor Induk Siswa</label>
                    <h4>{{ $profile->nis }}</h4>
                </div>

                <div class="form-group mb-3">
                    <label for="email" class="text-lg text-primary font-weight-bold">Email</label>
                    <h4>{{ $profile->user->email }}</h4>
                </div>
            </div>
        </div>

        <div class="edit d-flex justify-content-end my-4 mx-4">
            <a href="/profile/{{ $profile->id }}/edit" class="btn btn-primary px-5">Edit Profile</a>
        </div>
    </div>
@endsection
