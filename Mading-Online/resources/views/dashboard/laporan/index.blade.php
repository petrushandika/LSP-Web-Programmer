<div class="content">
    <div class="row">
        <div class="text-center mt-5">
            <h2 class="poppins">LAPORAN</h2>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-5">
        <div class="p-3" style="width:75%;">
            <table class="table table-warning table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col" style="width:80%" class="ps-5 pt-3 pb-3">Judul Artikel</th>
                        <th scope="col" style="width:20%" class="pe-5 pt-3 pb-3">Komentar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporan as $row)
                        <tr>
                            <td class="ps-5 pe-3">{{ $row->judul_artikel }}</td>
                            <td class="pe-5">{{ $row->jumlah_komentar }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted py-4">Belum ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="text-end text-muted">
                Dicetak pada {{ $tanggal }} oleh {{ session('admin_name') }}
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end w-75 pe-3 mt-5">
        <button id="btn-print" type="button" class="btn btn-success align-items-center">
            <i class="bi bi-printer-fill me-2" style="font-size:1.5rem;"></i>
            <span class="h5">Cetak Laporan</span>
        </button>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        $('#btn-print').click(function () {
            $('.content').printThis();
        });
    });
</script>
@endpush
