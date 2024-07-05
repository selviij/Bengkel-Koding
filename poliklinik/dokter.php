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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['page']) && $_GET['page'] == 'dokter') {
    $nama = input($_POST["nama"]);
    $alamat = input($_POST["alamat"]);
    $no_hp = input($_POST["no_hp"]);

    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        // update data
        $sql = "UPDATE dokter SET nama='$nama', alamat='$alamat', no_hp='$no_hp' WHERE id='$id'";
        $hasil = mysqli_query($mysqli, $sql);

        if ($hasil) {
            header("Location:index.php?page=dokter");
        } else {
            echo "<div class='alert alert-danger'>Data gagal disimpan.</div>";
        }
    } else {
        // Jika tidak ada 'id', lakukan operasi insert data baru
        $sql = "INSERT INTO dokter (nama, alamat, no_hp) VALUES ('$nama','$alamat','$no_hp')";
        $hasil = mysqli_query($mysqli, $sql);

        if ($hasil) {
            header("Location:index.php?page=dokter");
        } else {
            echo "<div class='alert alert-danger'>Data gagal disimpan.</div>";
        }
    }
}

// Hapus data 
if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM dokter WHERE id='$id'";
    $hasil = mysqli_query($mysqli, $sql);
    if ($hasil) {
        header("Location:index.php?page=dokter");
    } else {
        echo "<div class='alert alert-danger'>Gagal menghapus data.</div>";
    }
}

// Jika ada parameter 'id' di URL, ambil data dokter yang sesuai
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $ambil = mysqli_query($mysqli, "SELECT * FROM dokter WHERE id='$id'");
    while ($row = mysqli_fetch_array($ambil)) {
        $nama = $row['nama'];
        $alamat = $row['alamat'];
        $no_hp = $row['no_hp'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poliklinik - Dokter</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <form action="index.php?page=dokter" method="post" enctype="multipart/form-data">
            <?php if (isset($_GET['id'])): ?>
                <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
            <?php endif; ?>
            <div class="form-group">
                <label>Nama:</label>
                <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama" value="<?php echo isset($nama) ? $nama : ''; ?>" required />
            </div>
            <div class="form-group">
                <label>Alamat:</label>
                <input type="text" name="alamat" class="form-control" placeholder="Masukkan Alamat" value="<?php echo isset($alamat) ? $alamat : ''; ?>" required />
            </div>
            <div class="form-group">
                <label>No HP:</label>
                <input type="number" name="no_hp" class="form-control" placeholder="Masukkan No HP" value="<?php echo isset($no_hp) ? $no_hp : ''; ?>" required />
            </div>
            <button type="submit" name="submit" class="btn btn-primary"><?php echo isset($_GET['id']) ? 'Simpan' : 'Submit'; ?></button>
        </form>

        <div class="table-responsive mt-5">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">No HP</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = mysqli_query($mysqli, "SELECT * FROM dokter");
                    $no = 1;
                    while ($data = mysqli_fetch_array($result)) {
                    ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $data['nama'] ?></td>
                            <td><?php echo $data['alamat'] ?></td>
                            <td><?php echo $data['no_hp'] ?></td>
                            <td>
                                <a class="btn btn-success rounded-pill px-3" href="index.php?page=dokter&id=<?php echo $data['id'] ?>">Ubah</a>
                                <a class="btn btn-danger rounded-pill px-3" href="index.php?page=dokter&id=<?php echo $data['id'] ?>&aksi=hapus">Hapus</a>
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
