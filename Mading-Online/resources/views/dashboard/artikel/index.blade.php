<div class="p-3" style="width:100%;">
    <table class="table table-warning table-striped table-hover">
        <thead>
            <tr>
                <th scope="col" style="width:10%">#</th>
                <th scope="col" style="width:35%">Title</th>
                <th scope="col" style="width:15%">Author</th>
                <th scope="col" style="width:15%">Kolom Komentar</th>
                <th scope="col" style="width:25%">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($artikels as $artikel)
                <tr>
                    <th scope="row">
                        <img src="{{ $artikel->gambar }}" width="75" height="75" class="img-thumbnail"
                            onerror="this.onerror=null; this.src='https://via.placeholder.com/75?text=N/A';" />
                    </th>
                    <td>
                        <a href="{{ route('artikel.show', $artikel->id_artikel) }}"
                            class="text-decoration-none text-dark" target="_blank">
                            {{ $artikel->judul_artikel }}
                        </a>
                    </td>
                    <td>{{ $artikel->admin->nama }}</td>
                    <td>
                        <span class="badge {{ $artikel->status_komentar ? 'bg-success' : 'bg-secondary' }}">
                            {{ $artikel->status_komentar ? 'Buka' : 'Tutup' }}
                        </span>
                    </td>
                    <td>
                        {{-- Hapus --}}
                        <form action="{{ route('artikel.destroy', $artikel->id_artikel) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm poppins">HAPUS</button>
                        </form>
                        <br />
                        {{-- Toggle Komentar --}}
                        <form action="{{ route('artikel.toggleKomentar', $artikel->id_artikel) }}" method="POST"
                            class="d-inline mt-1"
                            onsubmit="return confirm('Ubah status komentar artikel ini?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-primary btn-sm m-1 poppins">
                                Buka/Tutup Komentar
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">Belum ada artikel.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
