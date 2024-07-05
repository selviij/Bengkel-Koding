<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Poliklinik - Register</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
            .container {
                max-width: 600px;
            }
        </style>
</head>
<body>
  <div class="container mt-5">

    <?php
    include "koneksi.php";

    function input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = input($_POST["username"]);
        $password = input($_POST["password"]);
        $confirm_password = input($_POST["confirm_password"]);
    
        // cek apakah username sudah ada
        $check_username_query = "SELECT * FROM user WHERE username = '$username'";
        $check_username_result = mysqli_query($mysqli, $check_username_query);
    
        // cek apakah username sudah ada dalam database
        if (mysqli_num_rows($check_username_result) > 0) {
            echo "<div class='alert alert-danger'>Username tersebut sudah ada, silahkan buat dengan username lain</div>";
        } else {
            if ($password !== $confirm_password) {
                echo "<div class='alert alert-danger'>Konfirmasi password tidak sesuai.</div>";
            } else {
                // Hash password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
                $sql = "INSERT INTO user (username, password) VALUES ('$username', '$hashed_password')";
    
                $hasil = mysqli_query($mysqli, $sql);
    
                if ($hasil) {
                    echo "<script>alert('User berhasil ditambahkan');</script>";
                } else {
                    echo "<div class='alert alert-danger'>Data Gagal disimpan.</div>";
                }
            }
        }
    }
    
    ?>

    <form action="index.php?page=registeruser" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" name="username" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      <div class="form-group">
        <label for="confirm_password">Confirm Password</label>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
      </div>
      <button type="submit" class="btn btn-primary btn-block" name="submit">Register</button>
    </form>
    <center><p class="mt-2">Sudah punya akun? <a href="index.php?page=loginuser">Login</a></p></center>
  </div>
</body>
</html>
