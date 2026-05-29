<div class="p-3 h5" style="width:100%;">
    <form method="POST" action="{{ route('artikel.store') }}">
        @csrf
        <div class="form-group mb-3">
            <label for="inputArticleTitle" class="poppins">Title</label>
            <input type="text" class="form-control w-100" id="inputArticleTitle"
                name="judul" placeholder="Judul Artikel" required />
        </div>
        <div class="form-group mb-3">
            <label for="inputArticleImg" class="poppins">Image URL</label>
            <input type="text" class="form-control w-100" id="inputArticleImg"
                name="gambar" placeholder="https://..." />
        </div>
        <div class="form-group mb-3">
            <label for="editor" class="poppins">Content</label>
            <textarea class="form-control" id="editor" name="isi_artikel"></textarea>
        </div>
        <div class="form-group mb-3">
            <label class="poppins">Status Komentar</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status_komentar"
                    value="1" id="radioOpen" checked>
                <label class="form-check-label" for="radioOpen">Buka komentar</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status_komentar"
                    value="0" id="radioClose">
                <label class="form-check-label" for="radioClose">Tutup komentar</label>
            </div>
        </div>
        <div class="input-group mb-5">
            <button type="submit" class="btn btn-warning fs-6 poppins">POST</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    ClassicEditor.create(document.querySelector('#editor'))
        .catch(error => { console.error(error); });
</script>
@endpush
