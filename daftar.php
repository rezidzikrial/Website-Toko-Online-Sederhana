<?php 
require "koneksi.php"; 

if(isset($_POST['daftarbtn'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
    $user_type = $_POST['user_type'];

    $query = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username' AND password = '$pass'") or die ('query failed');

    if(mysqli_num_rows($query) > 0) {
        ?>
        <div class="alert alert-warning" role="alert">
          username atau password yang anda masukan salah
        </div>
        <?php
    }else{
        mysqli_query($conn, "INSERT INTO user (nama, username, password, user_type) VALUES('$nama','$username', '$pass', '$user_type')") or die ('query failed');
        ?>
        <div class="alert alert-warning" role="alert">
          akun berhasi terdaftar
        </div>
        <?php
        header('location:login.php');
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<style>
    .main{
      height: 100vh;
      background-color: black;
    }

    .login-box{
      width: 500px;
      height: 500px;
      box-sizing: border-box;
      border-radius: 10px;
      background-color: blueviolet;
    }
</style>
<body>
<div class="main d-flex flex-column justify-content-center align-items-center">
    <div class="login-box p-5 shadow">
    <form action="" method="post">
        <h3 class="text-daftar text-center">Daftar</h3>
        <div>
          <label for="nama">Nama    :</label>
          <input type="text" class="form-control" name="nama" id="nama" placeholder="masukan nama anda">
        </div>
        <div>
          <label for="username">Username    :</label>
          <input type="text" class="form-control" name="username" id="username" placeholder="masukan username">
        </div>
        <div>
          <label for="password">Password    :</label>
          <input type="password" class="form-control" name="password" id="password" placeholder="masukan password">
        </div>
        <div>
            <select name="user_type" class="form-control mt-3">
            <option value="user">Pengguna</option>
            
        </select>
        </div>
        <div>
          <button class="btn btn-success form-control mt-3 mb-3"type="submit" name="daftarbtn" value="daftar sekarang">Daftar</button>
        </div>
        <p class="text-wthite">Sudah Punya akun? <a href="login.php" class="text-daftar">Login sekarang</a></p>
    </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script>"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"</script>
</body>
</html>