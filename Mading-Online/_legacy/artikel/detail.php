<?php
require_once '../templates/config/db_connection.php';

session_start();

if (!isset($_GET['id_artikel'])) {
  header("Location: ../index.php");
}

$id_artikel = $_GET['id_artikel'];

if (!empty($id_artikel) && is_numeric($id_artikel) && is_int((int) $id_artikel)) {
  $id_artikel = (int)$_GET['id_artikel'];
} else {
  header("Location: ../index.php");
}

// get data artikel by id
$query = "SELECT t_admin.nama, t_artikel.*, COUNT(t_komentar.id_komentar) AS jumlah_komentar FROM t_artikel JOIN t_admin ON t_artikel.id_admin = t_admin.id_admin LEFT JOIN t_komentar ON t_artikel.id_artikel = t_komentar.id_artikel WHERE t_artikel.id_artikel = ? GROUP BY t_artikel.id_artikel";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $id_artikel);
$stmt->execute();
$result = $stmt->get_result();

?>

<!-- layout -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../templates/css/style.css" />

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

    <!-- Bootstrap Icons CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css"
      rel="stylesheet"
    />

    <!-- favicon -->
    <link
      rel="shortcut icon"
      href="https://img.icons8.com/stickers/100/module.png"
      type="image/x-icon"
    />

    <?php if ($result->num_rows > 0): ?>
    <?php $row = $result->fetch_assoc(); ?>
    <title>Mading Online JeWePe | <?php echo $row['judul_artikel']; ?></title>
</head>
<body style="background: #fffee6;">
    <!-- header -->
    <?php
    include('../templates/header.php');
    ?>

    <!-- content -->
    <!-- judul artikel -->
    <div class="d-flex justify-content-center">
      <div class="text-center w-100 p-5">
        <h1 mb-5><?php echo $row['judul_artikel']; ?></h1>
        <p class="text-muted">oleh <?php echo $row['nama']; ?></p>
        <br>
        <img src="<?php echo $row['gambar']; ?>" class="img-thumbnail" style="height: 300px;" onerror="this.onerror=null; this.src='../templates/img/picture.png';">
      </div>
    </div>

    <!-- isi artikel -->
    <div class="d-flex justify-content-center mb-5">
      <div class="w-50">
      <?php
      $data = $row['isi_artikel'];
      $data = str_replace('<p>&nbsp;</p>', '', $data);
      echo $data;
      ?>
      </div>
    </div>

    <!-- bottom section -->
    <div class="content d-flex justify-content-center mb-3 ">
      <div class="w-75 d-flex justify-content-between border-bottom ps-5 pe-5">
        <div class="h5"><?php echo $row['jumlah_komentar']; ?> komentar</div>
        <p>Diunggah: <?php
        $tanggal = $row['tanggal_posting'];
        $tanggal_baru = date('d-m-Y', strtotime($tanggal));
        echo $tanggal_baru;
        $stmt->close();
        $result->close(); ?>
        </p>
      </div>
    </div>

    <!-- comment section -->
    <div class="container w-75" id="comment_section" style="display:<?php $status = ($row['status_komentar']) ? 'block' : 'none'; echo $status; ?>">
      <div class="row">
        <!-- post komentar -->
        <div class="d-flex pt-2 col justify-content-start">
          <i class="bi bi-person-circle me-3" style="font-size: 70px;"></i>
          <form method="post" action="../komentar/insert.php?id_artikel=<?php echo $id_artikel; ?>">
            <div class="input-group mb-3">
              <input
                type="text"
                class="form-control form-control-lg bg-light fs-6"
                name="nama_user"
                placeholder="Nama*"
                required
              />
            </div>
            <div class="input-group mb-3">
              <input
                type="text"
                class="form-control form-control-lg bg-light fs-6"
                name="email_user"
                placeholder="Email*"
                required
              />
            </div>
            <div class="input-group mb-3">              
              <textarea name="komentar_user" class="form-control form-control-lg bg-light" placeholder="Komentar..." rows="5" required></textarea>
            </div>
            <div class="input-group mb-5">
              <button name="post_komentar" class="btn btn-lg btn-warning w-100 fs-6 poppins">POST</button>
            </div>
          </form>
        </div>

        <!-- komentar -->
        <div class="col">

          <?php // get comments
          $query = "SELECT * FROM t_artikel JOIN t_komentar ON t_artikel.id_artikel = t_komentar.id_artikel WHERE t_artikel.id_artikel = ? AND t_komentar.status_tampil = 1";
          $stmt = $connection->prepare($query);
          $stmt->bind_param("i", $id_artikel);
          $stmt->execute();
          $result = $stmt->get_result();
          if ($result->num_rows > 0) {
            foreach ($result as $row) {
              $tanggal = $row['tanggal_komentar'];
              $tanggal_baru = date('d-m-Y', strtotime($tanggal));
              $tanggal_baru = str_replace('-', '/', $tanggal_baru);
              echo '
              <div class="d-flex flex-row mb-3">
                <i class="bi bi-person-circle me-3" style="font-size: 30px;"></i>
                <div class="d-flex flex-column">
                  <div>' . $row['nama_user'] . ' - <span class="text-muted">' . $tanggal_baru . '</span></div>
                  <div class="d-inline-flex p-3 bg-warning rounded-4 text-break text-wrap" style="max-width: 500px;">' . $row['isi_komentar'] . '</div>
                </div>
              </div>
              ';
            }
          } else {
            echo "No comments.";
          }
          ?>

        </div>
      </div>
    </div>
    <?php else: include('../templates/no_entry.php'); ?>
    <?php endif; ?>

    <!-- footer -->
    <?php
    include('../templates/footer.php');
    ?>
</body>
</html>