@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
    @php $activeMenu = request('menu', 'menu_daftar_artikel'); @endphp

    @if($activeMenu === 'menu_add_post')
        {{-- ── Form Tambah Artikel ── --}}
        @include('dashboard.artikel.create')

    @elseif($activeMenu === 'menu_daftar_artikel')
        {{-- ── Daftar Artikel ── --}}
        @include('dashboard.artikel.index')

    @elseif($activeMenu === 'menu_laporan')
        {{-- ── Laporan ── --}}
        @include('dashboard.laporan.index')

    @elseif($activeMenu === 'menu_komentar')
        {{-- ── Komentar ── --}}
        @include('dashboard.komentar.index')

    @else
        <div class="p-5 text-muted text-center">Menu tidak ditemukan.</div>
    @endif
@endsection
