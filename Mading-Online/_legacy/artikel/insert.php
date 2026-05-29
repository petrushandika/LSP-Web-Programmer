<?php
require_once 'templates/config/db_connection.php';

if (!isset($_SESSION['name'])) {
    header("Location: index.php");
}

if (isset($_POST['upload'])) {
    $judul_post = $_POST['judul'];
    $gambar_url = $_POST['gambar'];
    $isi_artikel = $_POST['isi_artikel'];
    $status_komentar = (int)$_POST['flexRadioDefault'];
    $id_admin = $_SESSION['id_adm'];

    $query = "INSERT INTO t_artikel (judul_artikel, isi_artikel, gambar, id_admin, status_komentar) VALUES (?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($query);

    $stmt->bind_param("sssii", $judul_post, $isi_artikel, $gambar_url, $id_admin, $status_komentar);

    try {
        $stmt->execute();
        echo "<script>alert('Artikel berhasil dipost.')</script>";
    } catch (Exception $e) {
        echo "<script>alert('Artikel gagal dipost.')</script>";
    }
}

?>

<!-- layout -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="templates/css/style.css" />

    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>

    <!-- text editor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>

    <!-- favicon -->
    <link
      rel="shortcut icon"
      href="https://img.icons8.com/stickers/100/module.png"
      type="image/x-icon"
    />

    <title>Document</title>
  </head>
  <body>
    <div class="p-3 h5" style="width: 100%">
      <form method="post">
        <div class="form-group mb-3">
          <label for="inputArticleTitle" class="poppins">Title</label>
          <input
            type="text"
            class="form-control w-100"
            id="inputArticleTitle"
            name="judul"
            placeholder="Judul Artikel"
          />
        </div>
        <div class="form-group mb-3">
          <label for="inputArticleImg" class="poppins">Image to display</label>
          <input
            type="text"
            class="form-control w-100"
            id="inputArticleImg"
            name="gambar"
            placeholder="https://"
          />
        </div>
        <div class="form-group mb-3">
          <label for="editor" class="poppins">Content</label>
          <textarea
            class="form-control"
            id="editor"
            name="isi_artikel"
          ></textarea>
        </div>
        <div class="form-group mb-3">
          <label for="flexRadioDefault" class="poppins">Status Komentar</label>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" value="1" id="flexRadioDefault1" checked>
            <label class="form-check-label" for="flexRadioDefault1">
              Buka komentar
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" value="0" id="flexRadioDefault2">
            <label class="form-check-label" for="flexRadioDefault2">
              Tutup komentar
            </label>
          </div>
        </div>
        <div class="input-group mb-5">
          <button name="upload" class="btn btn-warning fs-6 poppins">POST</button>
        </div>
      </form>
    </div>

    <!-- custom script -->
    <script src="../templates/js/script.js"></script>
  </body>
</html>
