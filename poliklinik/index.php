<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Poliklinik</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
        Sistem Informasi Poliklinik
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="index.php">
              Home
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Data Master
            </a>
            <ul class="dropdown-menu">
              <li>
                <a class="dropdown-item" href="index.php?page=dokter">
                  Dokter
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="index.php?page=pasien">
                  Pasien
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="index.php?page=obat">
                  Obat
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="index.php?page=periksa">
              Periksa
            </a>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto">
          <?php if (isset($_SESSION['is_login'])) : ?>
            <li class="nav-item">
              <a class="nav-link" href="index.php?page=logout">
                Logout
              </a>
            </li>
          <?php else : ?>
            <li class="nav-item">
              <a class="nav-link" href="index.php?page=registeruser">
                Register
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php?page=loginuser">
                Login
              </a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <main role="main" class="container mt-5">
    <?php
    if (isset($_GET['page'])) {
    ?>
      <h2><?php echo ucwords($_GET['page']) ?></h2>
    <?php
      include($_GET['page'] . ".php");
    } else {
      echo "Selamat Datang di Sistem Informasi Poliklinik";
    }
    ?>
    <?php
    echo '<img src="image/kesehatan.jpg" width="1000" height="1000" alt="deskripsi_gambar">';
    ?>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>