@extends('layouts.app')

@section('title', 'Mading Online JeWePe | Artikel')

@section('content')
<div class="container mb-5">
    <div class="row">
        <div class="col-12 text-center mb-5">
            <h2 class="poppins">ARTIKEL</h2>
        </div>
    </div>

    <div class="row mb-5">
        @forelse($artikels as $artikel)
            <div class="col-4 mb-4">
                <a href="{{ route('artikel.show', $artikel->id_artikel) }}" class="text-decoration-none text-dark">
                    <div class="card" style="height:550px;">
                        <img src="{{ $artikel->gambar }}" class="card-img-top"
                            onerror="this.onerror=null; this.src='https://via.placeholder.com/400x300?text=No+Image';"
                            style="max-height:300px; object-fit:cover;" />
                        <div class="card-body">
                            <h5 class="card-title">{{ $artikel->judul_artikel }}</h5>
                            <p class="card-text text-muted">
                                {{ Str::limit(strip_tags($artikel->isi_artikel), 100) }}
                            </p>
                        </div>
                        <div class="card-footer text-muted d-flex justify-content-between align-items-center">
                            <div>
                                <i class="bi bi-person-circle"></i>
                                <small>{{ $artikel->admin->nama }}</small>
                            </div>
                            <div>
                                <i class="bi bi-chat-right"></i>
                                <small>{{ $artikel->jumlah_komentar }}</small>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12 text-center text-muted py-5">
                <i class="bi bi-journal-x" style="font-size:4rem;"></i>
                <p class="mt-3">Belum ada artikel.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
