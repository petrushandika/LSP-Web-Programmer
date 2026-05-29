<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.printThis/1.15.0/jquery.printThis.min.js"></script>

    <!-- Favicon -->
    <link rel="shortcut icon" href="https://img.icons8.com/stickers/100/module.png" type="image/x-icon" />

    <title>@yield('title', 'Dashboard') - Mading Online JeWePe</title>
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .poppins { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body>
    {{-- Navbar --}}
    <header>
        <nav class="navbar navbar-light" style="background-color: #fffee6;">
            <div class="container-fluid">
                <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
                    <img src="https://img.icons8.com/stickers/100/module.png" alt="logo" width="50" height="50" />
                    <span class="ms-2" style="font-family:'Poppins';font-weight:700;">Sekolah Tinggi JeWePe</span>
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">LOGOUT</button>
                </form>
            </div>
        </nav>
    </header>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show m-2" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show m-2" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Dashboard Layout --}}
    <div class="container-fluid">
        <div class="row flex-nowrap">
            {{-- Sidebar --}}
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark" style="width: 280px; min-height: 100vh;">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2">
                    <div class="d-flex align-items-center pb-3 mb-3 link-light text-decoration-none mt-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="32" fill="currentColor"
                            class="bi bi-person-circle me-2" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                            <path fill-rule="evenodd"
                                d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                        </svg>
                        <span class="fs-4 fw-bold text-white">{{ session('admin_name') }}</span>
                    </div>

                    <div class="mb-3">
                        <a href="{{ route('dashboard', ['menu' => 'menu_add_post']) }}">
                            <button type="button" class="btn btn-light pt-3 pb-3 ps-5 pe-5 rounded-pill" style="color:orange;">
                                <span class="bi-plus-square-fill"></span>
                                <strong>&nbsp;Buat Artikel</strong>
                            </button>
                        </a>
                    </div>

                    <div class="border-bottom w-100"></div>

                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start w-100 mt-2" id="menu">
                        @php $activeMenu = request('menu', 'menu_daftar_artikel'); @endphp

                        <li class="nav-item w-100">
                            <a href="{{ route('dashboard', ['menu' => 'menu_daftar_artikel']) }}"
                                class="nav-link align-middle px-0 {{ $activeMenu === 'menu_daftar_artikel' ? 'link-warning' : 'link-light' }}">
                                <i class="bi bi-file-earmark-richtext-fill fs-4 me-2"></i>
                                <span class="ms-1 d-none d-sm-inline fs-5 fw-bold">Artikel</span>
                            </a>
                        </li>
                        <li class="w-100">
                            <a href="{{ route('dashboard', ['menu' => 'menu_laporan']) }}"
                                class="nav-link px-0 align-middle {{ $activeMenu === 'menu_laporan' ? 'link-warning' : 'link-light' }}">
                                <i class="bi bi-file-earmark-bar-graph fs-4 me-2"></i>
                                <span class="ms-1 d-none d-sm-inline fs-5 fw-bold">Laporan</span>
                            </a>
                        </li>
                        <li class="w-100">
                            <a href="{{ route('dashboard', ['menu' => 'menu_komentar']) }}"
                                class="nav-link px-0 align-middle {{ $activeMenu === 'menu_komentar' ? 'link-warning' : 'link-light' }}">
                                <i class="bi bi-chat-left-text-fill fs-4 me-2"></i>
                                <span class="ms-1 d-none d-sm-inline fs-5 fw-bold">Komentar</span>
                            </a>
                        </li>
                    </ul>

                    <div class="border-top w-100 mb-3 mt-3"></div>
                    <div class="pb-4">
                        <a href="{{ route('home') }}" target="_blank"
                            class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-light text-decoration-none">
                            <i class="bi bi-box-arrow-up-right me-2"></i>
                            <strong>Lihat Web</strong>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Content Area --}}
            <div class="col py-3">
                @yield('content')
            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
