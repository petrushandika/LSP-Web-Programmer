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

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Favicon -->
    <link rel="shortcut icon" href="https://img.icons8.com/stickers/100/module.png" type="image/x-icon" />

    <title>@yield('title', 'Mading Online JeWePe')</title>

    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #fffee6; }
        .poppins { font-family: 'Poppins', sans-serif; }
        .logo-text { font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.1rem; }
        .navbar { background-color: #fffee6 !important; }
        footer { background-color: #fffee6; border-top: 1px solid #dee2e6; }
    </style>
    @stack('styles')
</head>
<body>
    {{-- Navbar --}}
    <header>
        <nav class="navbar navbar-light shadow-sm">
            <div class="container-fluid">
                {{-- Logo --}}
                <a class="navbar-brand d-flex align-items-center"
                    href="{{ session('admin_name') ? route('dashboard') : route('home') }}">
                    <img src="https://img.icons8.com/stickers/100/module.png" alt="logo" width="50" height="50"
                        class="d-inline-block align-text-top" />
                    <span class="ms-2 logo-text">Sekolah Tinggi JeWePe</span>
                </a>

                {{-- Nav links --}}
                <ul class="nav justify-content-end align-items-center">
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="{{ route('home') }}">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="{{ route('profil') }}">PROFIL</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="{{ route('artikel.index') }}">ARTIKEL</a>
                    </li>
                    {{-- Search icon --}}
                    <li class="nav-item" id="search-logo" style="cursor:pointer">
                        <i class="bi bi-search nav-link"></i>
                    </li>
                    <li class="nav-item ms-2">
                        @if(session('admin_name'))
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger">LOGOUT</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-primary">LOGIN</a>
                        @endif
                    </li>
                </ul>
            </div>
            {{-- Search box --}}
            <form class="d-flex flex-fill justify-content-end me-5 pe-5" role="search"
                method="POST" action="{{ route('artikel.search') }}">
                @csrf
                <div class="d-flex">
                    <input id="search-input" name="keyword" class="form-control me-2"
                        type="hidden" placeholder="Search" aria-label="Search" />
                    <button name="search" id="search-submit" class="btn btn-outline-dark"
                        type="submit" style="display:none;">Search</button>
                </div>
            </form>
        </nav>
    </header>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Main Content --}}
    @yield('content')

    {{-- Footer --}}
    <footer class="text-center py-3 mt-5">
        <small class="text-muted">© {{ date('Y') }} Mading Online Sekolah Tinggi JeWePe. All rights reserved.</small>
    </footer>

    <script>
        $(document).ready(function () {
            $('#search-logo').click(function () {
                var input = $('#search-input');
                input.toggle(function () {
                    input.attr('type', 'search');
                });
                $('#search-submit').toggle();
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
