@extends('layouts.app')

@section('title', 'Mading Online JeWePe | ' . $artikel->judul_artikel)

@section('content')
<div style="background:#fffee6;">
    {{-- Judul Artikel --}}
    <div class="d-flex justify-content-center">
        <div class="text-center w-100 p-5">
            <h1 class="mb-3">{{ $artikel->judul_artikel }}</h1>
            <p class="text-muted">oleh {{ $artikel->admin->nama }}</p>
            <br />
            @if($artikel->gambar && $artikel->gambar !== 'none')
                <img src="{{ $artikel->gambar }}" class="img-thumbnail" style="height:300px; object-fit:cover;"
                    onerror="this.onerror=null; this.src='https://via.placeholder.com/400x300?text=No+Image';" />
            @endif
        </div>
    </div>

    {{-- Isi Artikel --}}
    <div class="d-flex justify-content-center mb-5">
        <div class="w-50">
            {!! str_replace('<p>&nbsp;</p>', '', $artikel->isi_artikel) !!}
        </div>
    </div>

    {{-- Bottom Section --}}
    <div class="content d-flex justify-content-center mb-3">
        <div class="w-75 d-flex justify-content-between border-bottom ps-5 pe-5">
            <div class="h5">{{ $artikel->jumlah_komentar }} komentar</div>
            <p>Diunggah: {{ \Carbon\Carbon::parse($artikel->tanggal_posting)->format('d-m-Y') }}</p>
        </div>
    </div>

    {{-- Comment Section --}}
    @if($artikel->status_komentar)
        <div class="container w-75" id="comment_section">
            <div class="row">
                {{-- Form Komentar --}}
                <div class="d-flex pt-2 col justify-content-start">
                    <i class="bi bi-person-circle me-3" style="font-size:70px;"></i>
                    <form method="POST" action="{{ route('komentar.store', $artikel->id_artikel) }}">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" class="form-control form-control-lg bg-light fs-6"
                                name="nama_user" placeholder="Nama*" required />
                        </div>
                        <div class="input-group mb-3">
                            <input type="email" class="form-control form-control-lg bg-light fs-6"
                                name="email_user" placeholder="Email*" required />
                        </div>
                        <div class="input-group mb-3">
                            <textarea name="komentar_user" class="form-control form-control-lg bg-light"
                                placeholder="Komentar..." rows="5" required maxlength="280"></textarea>
                        </div>
                        <div class="input-group mb-5">
                            <button name="post_komentar" class="btn btn-lg btn-warning w-100 fs-6 poppins">
                                POST
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Daftar Komentar --}}
                <div class="col">
                    @forelse($artikel->komentarsAktif as $komentar)
                        <div class="d-flex flex-row mb-3">
                            <i class="bi bi-person-circle me-3" style="font-size:30px;"></i>
                            <div class="d-flex flex-column">
                                <div>
                                    {{ $komentar->nama_user }}
                                    - <span class="text-muted">
                                        {{ \Carbon\Carbon::parse($komentar->tanggal_komentar)->format('d/m/Y') }}
                                    </span>
                                </div>
                                <div class="d-inline-flex p-3 bg-warning rounded-4 text-break text-wrap"
                                    style="max-width:500px;">
                                    {{ $komentar->isi_komentar }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mt-3">No comments.</p>
                    @endforelse
                </div>
            </div>
        </div>
    @endif

    {{-- Footer spacing --}}
    <div class="py-5"></div>
</div>
@endsection
