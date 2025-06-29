@extends('layouts.welcome') @section('content')
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header text-lg text-dark">
                        {{ __('Registrasi') }}
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}"
                            {{ env('APP_ENV') != 'production' ? 'novalidate' : '' }}>
                            @csrf
                            <div class="row mb-3">
                                <label for="nama"
                                    class="col-md-4 col-form-label text-left text-md-right text-dark">{{ __('Nama Lengkap') }}</label>

                                <div class="col-md-6">
                                    <input id="nama" type="text"
                                        class="form-control @error('nama') is-invalid @enderror" name="nama"
                                        value="{{ old('nama') }}" required />

                                    @error('nama')
                                        <span class="invalid-feedback text-left" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="nis"
                                    class="col-md-4 col-form-label text-left text-md-right text-dark">{{ __('NIS') }}</label>

                                <div class="col-md-6">
                                    <input id="nis" type="text"
                                        class="form-control @error('nis') is-invalid @enderror" name="nis"
                                        value="{{ old('nis') }}" required />

                                    @error('nis')
                                        <span class="invalid-feedback text-left" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-left text-md-right text-dark">{{ __('Email') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required />

                                    @error('email')
                                        <span class="invalid-feedback text-left" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-left text-md-right text-dark"
                                    required>{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password" />

                                    @error('password')
                                        <span class="invalid-feedback text-left" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-left text-md-right text-dark">{{ __('Konfirmasi Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" />
                                </div>
                            </div>
                            <div class="row mb-0">
                                <span class="mb-3 text-center text-dark">
                                    Sudah punya akun?
                                    <a href="{{ route('login') }}" class="p-0">
                                        Login sekarang
                                    </a>
                                </span>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-5 offset-md-4">
                                    <button type="submit" class="btn btn-primary px-5">
                                        {{ __('Registrasi') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
