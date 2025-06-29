<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/home">
        <div class="sidebar-brand-icon d-none d-lg-block">
            <img src="{{ asset('assets//images/logo.png') }}">
        </div>
        <div class="sidebar-brand-text ml-3">e-Perpustakaan</div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item {{ request()->is('home') ? 'active' : '' }}">
        <a class="nav-link" href="/home">
            <i class="fa-solid fa-house"></i>
            <span>Dashboard</span></a>
    </li>

    <li class="nav-item {{ request()->is('buku*') ? 'active' : '' }}">
        <a class="nav-link" href="/buku">
            <i class="fa-solid fa-book"></i>
            <span>Koleksi Buku</span></a>
    </li>

    @if (Auth::user()->is_admin == 1)
        <li class="nav-item {{ request()->is('kategori*') ? 'active' : '' }}">
            <a class="nav-link" href="/kategori">
                <i class="fa-solid fa-book-open"></i>
                <span>Kategori</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTable"
                aria-expanded="true" aria-controls="collapseTable">
                <i class="fa-solid fa-users"></i>
                <span>Anggota</span>
            </a>
            <div id="collapseTable" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Anggota</h6>
                    <a class="collapse-item" href="/anggota">Lihat Anggota</a>
                    <a class="collapse-item" href="/anggota/create">Tambah Anggota</a>
                </div>
            </div>
        </li>
    @endif

    @if (Auth::user()->is_admin == 1)
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePeminjam"
                aria-expanded="true" aria-controls="collapsePeminjam">
                <i class="fa-solid fa-user-pen"></i>
                <span>Peminjaman</span>
            </a>
            <div id="collapsePeminjam" class="collapse" aria-labelledby="headingPeminjam"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Peminjaman</h6>
                    <a class="collapse-item" href="/peminjaman">Riwayat Peminjaman</a>
                    <a class="collapse-item" href="/peminjaman/create">Tambahkan Peminjaman</a>
                    <a class="collapse-item" href="/pengembalian">Kembalikan Buku</a>
                </div>
            </div>
        </li>
    @endif

    @if (Auth::user()->is_admin == 0)
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePeminjam"
                aria-expanded="true" aria-controls="collapsePeminjam">
                <i class="fas fa-fw fa-table"></i>
                <span>Pinjam Buku</span>
            </a>
            <div id="collapsePeminjam" class="collapse" aria-labelledby="headingPeminjam"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Pinjam Buku</h6>
                    <a class="collapse-item" href="/peminjaman/create">Pinjam Buku</a>
                    <a class="collapse-item" href="/peminjaman">Pinjaman Saya</a>
                </div>
            </div>
        </li>
    @endif

</ul>
