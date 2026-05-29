<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
    <link rel="shortcut icon" href="https://img.icons8.com/stickers/100/module.png" type="image/x-icon" />
    <title>LOGIN - Mading Online JeWePe</title>
    <style>
        body { font-family: 'Poppins', sans-serif; margin: 0; background-color: #fffee6; }
        .logo-text { font-family: 'Poppins'; font-weight: 700; font-size: 1.2rem; color: #333; }
        .header-text { font-family: 'Poppins'; }
    </style>
</head>
<body>
    {{-- Navbar --}}
    <nav class="navbar" style="background-color:#fffee6;">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="https://img.icons8.com/stickers/100/module.png" alt="logo" width="50" height="50" />
                <span class="ms-2 logo-text">Sekolah Tinggi JeWePe</span>
            </a>
        </div>
    </nav>

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border rounded-5 p-3 bg-white shadow box-area" style="max-width:800px; width:100%;">
            {{-- Left --}}
            <div class="col-md-6 left-box">
                <div class="row align-items-center">
                    <div class="mt-3 mb-3 text-center">
                        <img src="https://img.icons8.com/stickers/50/module.png" alt="logo" />
                        <p class="logo-text">Sekolah Tinggi JeWePe</p>
                        <h2 class="header-text mt-5 mb-3">Selamat Datang!</h2>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf
                        <p class="mb-1 fw-semibold">Email</p>
                        <div class="input-group mb-4">
                            <input type="email" class="form-control form-control-lg bg-light fs-6"
                                name="email" placeholder="name@example.com" required />
                        </div>
                        <p class="mb-1 fw-semibold">Password</p>
                        <div class="input-group mb-1">
                            <input type="password" class="form-control form-control-lg bg-light fs-6"
                                name="password" placeholder="********" required />
                        </div>
                        <div class="input-group mb-5 mt-5">
                            <button type="submit" class="btn btn-lg btn-warning w-100 fs-6">LOGIN</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Right --}}
            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column"
                style="background:#ffdb00;">
                <div class="featured-image mb-5 mt-5">
                    <img src="https://img.icons8.com/clouds/250/comics-magazine.png"
                        class="img-fluid" alt="comics-magazine" />
                </div>
            </div>
        </div>
    </div>
</body>
</html>
