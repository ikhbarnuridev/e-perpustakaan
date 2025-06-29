@extends('layouts.master')

@section('sidebar')
    @include('part.sidebar')
@endsection

@section('topbar')
    @include('part.topbar')
@endsection

@section('judul')
    <h1 class="text-primary">Edit Profile</h1>
@endsection

@section('content')
    <form action="/profile/{{ $profile->id }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')

        <div class="card pb-5">
            <div class="form-group mx-4 my-2">
                <label for="nama" class="text-md text-primary font-weight-bold mt-2">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                    value="{{ old('nama', $profile->user->nama) }}">

                @error('nama')
                    <span class="invalid-feedback text-left" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mx-4 my-2">
                <label for="nis" class="text-md text-primary font-weight-bold">Nomor Induk Siswa</label>
                <input type="text" name="nis" class="form-control @error('nis') is-invalid @enderror"
                    value="{{ old('nis', $profile->nis) }}">

                @error('nis')
                    <span class="invalid-feedback text-left" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mx-4 my-2">
                <label for="email" class="text-md text-primary font-weight-bold">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email', $profile->user->email) }}">

                @error('email')
                    <span class="invalid-feedback text-left" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mx-4 my-2">
                <label for="foto" class="text-md text-primary font-weight-bold">Foto Profile</label>
                <div class="custom-file">
                    <input type="file" name="foto" id="foto" value="{{ old('foto', $profile->foto) }}">
                </div>
            </div>

            @error('foto')
                <div class="alert-danger"> {{ $message }}</div>
            @enderror

            <div class="button-save d-flex justify-content-end">
                <a href="/profile" class="btn btn-danger mt-4 py-1 px-4">Batal</a>
                <button type="submit"class="btn btn-primary mt-4 mx-2 px-5 py-1">Simpan</button>
    </form>
@endsection
