<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testing</title>
</head>
<body>
<?php
    //Include file koneksi, untuk koneksikan ke database
    include "koneksi.php";

    //Fungsi untuk mencegah inputan karakter yang tidak sesuai
    function input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    //Cek apakah ada kiriman form dari method post
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $nama=input($_POST["nama"]);
        $alamat=input($_POST["alamat"]);
        $no_hp=input($_POST["no_hp"]);


        //Query input menginput data kedalam tabel anggota
        $sql="insert into dokter (nama,alamat,no_hp) values
		('$nama','$alamat','$no_hp')";

        //Mengeksekusi/menjalankan query diatas
        $hasil=mysqli_query($mysqli,$sql);

        //Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
        if ($hasil) {
            header("Location:index.php?page=dokter");
        }
        else {
            echo "<div class='alert alert-danger'> Data Gagal disimpan.</div>";

        }

    }
    ?>

    <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Nama:</label>
            <input type="text" name="nama" class="form-control" placeholder="Masukan Nama" required />
        </div>
        <div class="form-group">
            <label>Alamat:</label>
            <input type="text" name="alamat" class="form-control" placeholder="Masukan Alamat" required/>
        </div>
       <div class="form-group">
            <label>NO_HP</label>
            <input type="number" name="no_hp" class="form-control" placeholder="Masukan NO_HP" required/>
        </div>
     

        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</body>
</html>