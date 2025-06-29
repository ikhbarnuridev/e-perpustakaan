@extends('layouts.master')

@section('sidebar')
    @include('part.sidebar')
@endsection

@section('topbar')
    @include('part.topbar')
@endsection

@section('judul')
    <h1 class="text-primary" style="font-weight: bold; font-size: 28px;">Daftar Kategori</h1>
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
            $('#dataTableHover').DataTable();
        });
    </script>
@endpush

@section('content')
    @if (Auth::user()->is_admin)
        <a href="{{ route('kategori.create') }}" class="btn btn-info mb-3">Tambah Kategori</a>
    @endif

    <div class="col-12 p-0">
        <div class="card mb-4">
            <div class="table-responsive">
                <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="text-center" width="5%">No.</th>
                            <th scope="col">Nama Kategori</th>
                            <th scope="col" class="text-center" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kategori as $key => $item)
                            <tr>
                                <th class="text-center">{{ $key + 1 }}</th>
                                <td>{{ $item->nama }}</td>
                                <td class="text-center text-nowrap">
                                    @if (Auth::user()->is_admin)
                                        <a href="{{ route('kategori.show', $item->id) }}" class="btn btn-info text-white">
                                            <i class="fa-solid fa-circle-info"></i>
                                        </a>
                                        <a href="{{ route('kategori.edit', $item->id) }}"
                                            class="btn btn-warning text-white">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <button class="btn btn-danger" data-toggle="modal"
                                            data-target="#DeleteModal{{ $item->id }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="DeleteModal{{ $item->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="ModalLabelDelete" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin menghapus kategori ini?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-primary"
                                                            data-dismiss="modal">Batal</button>
                                                        <form action="{{ route('kategori.destroy', $item->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-outline-danger">Hapus</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Tidak ada data kategori.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
