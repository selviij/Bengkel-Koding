<?php
//cek apakah sudah login

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    header("Location: index.php?page=loginuser");
    exit;
}


include "koneksi.php";

// Fungsi untuk mencegah input karakter salah
function input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['page']) && $_GET['page'] == 'obat') {
    $nama_obat = input($_POST["nama_obat"]);
    $kemasan = input($_POST["kemasan"]);
    $harga = input($_POST["harga"]);

    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        // update data
        $sql = "UPDATE obat SET nama_obat='$nama_obat', kemasan='$kemasan', harga='$harga' WHERE id='$id'";
        $hasil = mysqli_query($mysqli, $sql);

        if ($hasil) {
            header("Location:index.php?page=obat");
        } else {
            echo "<div class='alert alert-danger'>Data gagal disimpan.</div>";
        }
    } else {
        // Jika tidak ada 'id', lakukan operasi insert data baru
        $sql = "INSERT INTO obat (nama_obat, kemasan, harga) VALUES ('$nama_obat','$kemasan','$harga')";
        $hasil = mysqli_query($mysqli, $sql);

        if ($hasil) {
            header("Location:index.php?page=obat");
        } else {
            echo "<div class='alert alert-danger'>Data gagal disimpan.</div>";
        }
    }
}

// Hapus data 
if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM obat WHERE id='$id'";
    $hasil = mysqli_query($mysqli, $sql);
    if ($hasil) {
        header("Location:index.php?page=obat");
    } else {
        echo "<div class='alert alert-danger'>Gagal menghapus data.</div>";
    }
}

// Jika ada parameter 'id' di URL, ambil data obat yang sesuai
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $ambil = mysqli_query($mysqli, "SELECT * FROM obat WHERE id='$id'");
    while ($row = mysqli_fetch_array($ambil)) {
        $nama_obat = $row['nama_obat'];
        $kemasan = $row['kemasan'];
        $harga = $row['harga'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poliklinik - Obat</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <form action="index.php?page=obat" method="post" enctype="multipart/form-data">
            <?php if (isset($_GET['id'])): ?>
                <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
            <?php endif; ?>
            <div class="form-group">
                <label>Nama Obat:</label>
                <input type="text" name="nama_obat" class="form-control" placeholder="Masukkan Nama Obat" value="<?php echo isset($nama_obat) ? $nama_obat : ''; ?>" required />
            </div>
            <div class="form-group">
                <label>Kemasan:</label>
                <input type="text" name="kemasan" class="form-control" placeholder="Masukkan Kemasan" value="<?php echo isset($kemasan) ? $kemasan : ''; ?>" required />
            </div>
            <div class="form-group">
                <label>Harga:</label>
                <input type="number" name="harga" class="form-control" placeholder="Masukkan Harga" value="<?php echo isset($harga) ? $harga : ''; ?>" required />
            </div>
            <button type="submit" name="submit" class="btn btn-primary"><?php echo isset($_GET['id']) ? 'Simpan' : 'Submit'; ?></button>
        </form>

        <div class="table-responsive mt-5">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Obat</th>
                        <th scope="col">Kemasan</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = mysqli_query($mysqli, "SELECT * FROM obat");
                    $no = 1;
                    while ($data = mysqli_fetch_array($result)) {
                    ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $data['nama_obat'] ?></td>
                            <td><?php echo $data['kemasan'] ?></td>
                            <td><?php echo $data['harga'] ?></td>
                            <td>
                                <a class="btn btn-success rounded-pill px-3" href="index.php?page=obat&id=<?php echo $data['id'] ?>">Ubah</a>
                                <a class="btn btn-danger rounded-pill px-3" href="index.php?page=obat&id=<?php echo $data['id'] ?>&aksi=hapus">Hapus</a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
