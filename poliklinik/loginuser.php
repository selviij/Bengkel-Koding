

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Poliklinik - Login</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
        <style>
            .container {
                max-width: 600px;
            }
        </style>
    </head>
    <body>
        <div class="page-wrappers login-body">
            <div class="login-wrapper">
            	<div class="container">
                	<div class="loginbox">
                        <div class="login-right">
							<div class="login-right-wrap">
								<p class="account-subtitle">Login terlebih dahulu untuk akses poliklinik</p>
                                <?php
                                include "koneksi.php";

                                $login_message = "";

                                if(isset($_SESSION["is_login"])){
                                    header("location: index.php");
                                }

                                if(isset($_POST['login'])){
                                    $username = $_POST['username'];
                                    $password_plain = $_POST['password']; // Password yang belum di-hash

                                    // Query hanya mengambil username dan password hash
                                    $sql = "SELECT username, password FROM user WHERE username='$username'"; 

                                    $result = $mysqli->query($sql);
                                    if($result->num_rows > 0){
                                        $data = $result->fetch_assoc();
                                        $password_hash = $data['password']; 

                                        // cek apakah password yang dimasukkan cocok dengan hash yang tersimpan
                                        if(password_verify($password_plain, $password_hash)) {
                                            $_SESSION['username'] = $data['username'];

                                            $_SESSION['is_login'] = true;
                                            header("location: index.php");
                                        } else {
                                            echo "<div class='alert alert-danger'>Username atau Password salah</div>";
                                        }
                                    } else {
                                        echo "<div class='alert alert-danger'>Username atau Password salah</div>";
                                    }
                                }
                                ?>
								<form action="index.php?page=loginuser" method="POST"">
									<div class="form-group">
                                        <label for="username">Username</label>
										<input class="form-control" name="username" type="text">
									</div>
									<div class="form-group">
                                        <label for="username">Password</label>
										<input class="form-control" type="password" name="password">
									</div>
									<div class="form-group">
										<button class="btn btn-primary btn-block" name="login" type="submit">Login</button>
									</div>
								</form>		
                                <center><p class="mt-2">Belum punya akun? <a href="index.php?page=registeruser">Register</a></p></center>
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>
</html>