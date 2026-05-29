<?php
session_start();
?>

<!-- layout -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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

    <!-- favicon -->
    <link
      rel="shortcut icon"
      href="https://img.icons8.com/stickers/100/module.png"
      type="image/x-icon"
    />

    <title>Mading Online JeWePe | Profil</title>
</head>
<body>
    <!-- header -->
    <?php
    include('templates/header.php');
    ?>

    <!-- content -->
    <div class="d-flex" style="position: relative; text-align:center">
        <img
            src="https://images.unsplash.com/photo-1542404937-2132aa1fa6fc"
            style="width: 100%; height: 100%; opacity: 0.3; overflow: hidden; object-fit: cover;"
            alt="gedung | Photo by Eric Sharp on Unsplash"
        />
        <div class="poppins" style="position: absolute; top:50%; left:50%; transform:translate(-50%,-50%)">
            <h1>PROFIL</h1>
            <p>Sekolah Tinggi JeWePe adalah lembaga pendidikan yang peduli akan komunikasi informal antara para peserta didiknya. Untuk memenuhi kebutuhan ini, kami hadir dengan mading online, sebuah platform interaktif yang dikelola oleh admin dan dapat diakses oleh semua peserta didik.</p>
            <p>Mading online ini merupakan media komunikasi yang memberikan informasi secara tidak resmi, menciptakan ruang untuk berbagi dan mendapatkan berita terkini. Kami berkomitmen untuk memberikan pengalaman berharga dan memperkuat komunitas kami melalui mading online ini.</p>
        </div>
    </div>
    

    <!-- footer -->
    <?php
    include('templates/footer.php');
    ?>
</body>
</html>