@extends('layouts.master')

@section('sidebar')
    @include('part.sidebar')
@endsection

@section('topbar')
    @include('part.topbar')
@endsection

@section('judul')
    <h1 class="text-primary font-weight-bold" style="font-size: 28px;">Dashboard</h1>
@endsection

@push('styles')
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/bs4/dt-1.12.1/date-1.1.2/fc-4.1.0/r-2.3.0/sc-2.0.7/datatables.min.css" />
@endpush

@push('scripts')
    <script src="{{ asset('/template/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/template/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
            $('#dataTableHover').DataTable();
        });
    </script>
@endpush

@section('content')
    <div class="row mb-3">
        <!-- Jumlah Buku -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100 bg-gradient-primary">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-sm font-weight-bold text-uppercase mb-1 text-light">Jumlah Buku</div>
                            <div class="h5 mb-0 font-weight-bold text-light">{{ $buku }}</div>
                            <div class="mt-2">
                                <a href="/buku" class="text-light">Lihat</a>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-book fa-3x text-light"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kategori -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100 bg-gradient-info">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-sm font-weight-bold text-uppercase mb-1 text-light">Kategori</div>
                            <div class="h5 mb-0 font-weight-bold text-light">{{ $kategori }}</div>
                            <div class="mt-2">
                                <a href="/kategori" class="text-light">Lihat</a>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-bookmark fa-3x text-light"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Anggota -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100 bg-gradient-success">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-sm font-weight-bold text-uppercase mb-1 text-light">Anggota</div>
                            <div class="h5 mb-0 font-weight-bold text-light">{{ $user }}</div>
                            <div class="mt-2">
                                <a href="/anggota" class="text-light">Lihat</a>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-3x text-light"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Peminjaman -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100 bg-gradient-danger">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-sm font-weight-bold text-uppercase mb-1 text-light" style="font-size:.8rem;">
                                Riwayat Peminjaman</div>
                            <div class="h5 mb-0 font-weight-bold text-light">{{ $jumlah_riwayat }}</div>
                            <div class="mt-2">
                                <a href="#" class="text-light">Lihat</a>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-tie fa-3x text-light"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Riwayat -->
        <div class="col-12">
            <h2 class="text-primary font-weight-bold mb-4" style="font-size: 28px;">Riwayat Peminjaman</h2>
            <div class="card mb-4">
                <div class="table-responsive">
                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <thead class="thead-light">
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Judul Buku</th>
                                <th>Kode Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Wajib Kembali</th>
                                <th>Tanggal Pengembalian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($riwayat_pinjam as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>{{ $item->buku->judul }}</td>
                                    <td>{{ $item->buku->kode_buku }}</td>
                                    <td>{{ $item->tanggal_pinjam }}</td>
                                    <td>{{ $item->tanggal_wajib_kembali }}</td>
                                    <td>{{ $item->tanggal_pengembalian ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Belum ada riwayat peminjaman.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
