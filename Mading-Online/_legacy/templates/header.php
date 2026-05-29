<?php
$homeUrl = '/project_jwp/index.php';
$logoUrl = $homeUrl;
$btnUrl = '/project_jwp/login.php';
$btnText = 'LOGIN';
$btnClass = "btn btn-outline-primary";

$activePage = basename($_SERVER['PHP_SELF']);
if ($activePage === 'dashboard.php') {
  $homeUrl = 'dashboard.php';
}

if (isset($_SESSION['name'])) {
  $logoUrl = '/project_jwp/dashboard.php';
  $btnUrl = '/project_jwp/logout.php';
  $btnText = 'LOGOUT';
  $btnClass = "btn btn-danger";
}
?>

<!-- layout -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="templates/css/style.css" />

    <!-- Bootstrap Icons CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css"
      rel="stylesheet"
    />

    <!-- google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
      $(document).ready(function() {
        $("#search-logo").click(function() {
          var input = $("#search-input");
          input.toggle(function() {
            input.attr("type", "search");
          });

          $("#search-submit").toggle();
        });
      });
    </script>

    <title>Document</title>
  </head>
  <body>
    <header>
      <nav
        class="navbar navbar-light autohide"
        style="background-color: #fffee6"
      >
        <div class="container-fluid">
          <!-- school logo -->
          <a
            class="navbar-brand d-flex align-items-center"
            href="<?php echo $logoUrl; ?>"
          >
            <img
              src="https://img.icons8.com/stickers/100/module.png"
              alt=""
              width="50"
              height="50"
              class="d-inline-block align-text-top"
            />
            <span class="ms-2 logo-text">Sekolah Tinggi JeWePe</span>
          </a>

          <ul class="nav justify-content-end">
            <li class="nav-item">
              <a
                class="nav-link active"
                aria-current="page"
                href="<?php echo $homeUrl; ?>"
                >HOME</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/project_jwp/profil.php">PROFIL</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/project_jwp/artikel">ARTIKEL</a>
            </li>
            <li class="nav-item" id="search-logo">
                <i class="bi bi-search nav-link"></i>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link"></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo $btnUrl; ?>">
                <button type="button" class="<?php echo $btnClass; ?>">
                  <?php echo $btnText; ?>
                </button>
              </a>
            </li>
          </ul>
        </div>
        <!-- search box -->
        <form class="d-flex flex-fill justify-content-end me-5 pe-5" role="search" method="post" action="/project_jwp/artikel/index.php">
          <div class="d-flex">
            
            <input id="search-input" name="keyword" class="form-control me-2" type="hidden" placeholder="Search" aria-label="Search">
            <button name="search" id="search-submit" class="btn btn-outline-dark" type="submit" style="display: none;">Search</button>

          </div>
        </form>
      </nav>
    </header>
  </body>
</html>
