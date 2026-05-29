<div class="p-3" style="width:100%;">
    <table class="table table-warning table-striped table-hover">
        <thead>
            <tr>
                <th scope="col" style="width:50%">Comments</th>
                <th scope="col" style="width:20%">User</th>
                <th scope="col" style="width:10%">Status Tampil</th>
                <th scope="col" style="width:20%">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($komentars as $komentar)
                <tr>
                    <td class="ps-3">
                        <a href="{{ route('artikel.show', $komentar->id_artikel) }}#comment_section"
                            class="text-decoration-none text-dark" target="_blank">
                            <div>{{ $komentar->isi_komentar }}</div>
                            <div class="text-muted">
                                artikel: <span class="h6">{{ $komentar->artikel->judul_artikel }}</span>
                            </div>
                        </a>
                    </td>
                    <td>{{ $komentar->nama_user }}</td>
                    <td>
                        <span class="badge {{ $komentar->status_tampil ? 'bg-success' : 'bg-secondary' }}">
                            {{ $komentar->status_tampil ? 'Tampil' : 'Tidak' }}
                        </span>
                    </td>
                    <td>
                        {{-- Hapus --}}
                        <form action="{{ route('komentar.destroy', $komentar->id_komentar) }}" method="POST"
                            class="d-inline" onsubmit="return confirm('Hapus komentar ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm poppins">HAPUS</button>
                        </form>
                        <br />
                        {{-- Toggle Status --}}
                        <form action="{{ route('komentar.toggleStatus', $komentar->id_komentar) }}" method="POST"
                            class="d-inline mt-1" onsubmit="return confirm('Ubah status tampil komentar ini?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-primary btn-sm poppins m-1">
                                Ubah Status Tampil
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">Belum ada komentar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
