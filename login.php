<?php 
    session_start();
    require "koneksi.php"; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
      height: 300px;
      box-sizing: border-box;
      border-radius: 10px;
      background-color: blueviolet;
    }
</style>

<body>
  <div class="main d-flex flex-column justify-content-center align-items-center">
    <div class="login-box p-5 shadow">
    <form action="" method="post">
        <div>
          <label for="username">Username    :</label>
          <input type="text" class="form-control" name="username" id="username">
        </div>
        <div>
          <label for="password">Password    :</label>
          <input type="password" class="form-control" name="password" id="password">
        </div>
        <div>
          <button class="btn btn-success form-control mt-3 mb-3"type="submit" name="loginbtn">Login</button>
        </div>
        <p class="text-wthite">Belum punya akun? <a href="daftar.php" class="text-daftar">Daftar sekarang</a></p>

        <div class="mt-3" style="width: 400px">
          <?php 
            if(isset($_POST['loginbtn'])){
              $username = mysqli_real_escape_string($conn, $_POST['username']);
              $password = mysqli_real_escape_string($conn, md5($_POST
              ['password']));

              $query = mysqli_query($conn, "SELECT * FROM user WHERE username='$username' AND password = '$password'") or die ('query failed');

              if(mysqli_num_rows($query) > 0) {

              $data = mysqli_fetch_array($query);
                
                if($data['user_type'] == 'admin') {

                  $_SESSION['admin_nama'] = $data['nama'];
                  $_SESSION['admin_username'] = $data['username'];
                  $_SESSION['admin_id'] = $data['id'];
                  header('location:adminpanel/index.php');

                }elseif($data['user_type'] == 'user'){
                  
                  $_SESSION['user_nama'] = $data['nama'];
                  $_SESSION['user_email'] = $data['username'];
                  $_SESSION['user_id'] = $data['id'];
                  header('location:index.php');

                }
                else {
                  ?>
                <div class="alert alert-warning" role="alert">
                  username atau password yang anda masukan salah
                </div>
                <?php
              }
            }
              else{
                ?>
                <div class="alert alert-warning" role="alert">
                  username atau password belum terdaftar
                </div>
                <?php
              }
            }
          ?>
        </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script>"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"</script>
</body>
</html>