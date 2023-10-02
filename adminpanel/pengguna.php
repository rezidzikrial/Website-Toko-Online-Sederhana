<?php 

include '../koneksi.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)) {
    header('location:../login.php');
}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM user WHERE id = '$delete_id'") or die('query failed');
    header('location:pengguna.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengguna</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
 <?php include 'navbar.php' ?>

      <!--banner-->
<div class="container-fluid banner-produk d-flex align-items-center">
    <div class="container text-center">
        <h1 class="text-white"><a class="no-decoration" href="index.php">Home</a> | Detail pengguna</h1>
    </div>
</div>
<!--banner-->

 <div class="container-fluid py-5">
    <div class="container">
        <h1 class="text-center">TOTAL PENGGUNA</h1>

        <div class="row mt-5">
        <?php
        $queryAkun = mysqli_query($conn, "SELECT * FROM user") or die ('query failed');    
        while($akun = mysqli_fetch_assoc($queryAkun)){ 
            ?>
            <div class="col-sm-6 col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body">
                <p class="card-text text-truncate">User id : <?php echo $akun['id']; ?></p>
                <p class="card-text text-truncate">Nama : <?php echo $akun ['nama']; ?></p>
                <p class="card-text text-truncate">Username : <?php echo $akun ['username']; ?></p>
                <p class="card-text text-truncate">User type : <?php echo $akun['user_type']; ?></p>
                <a href="pengguna.php?delete=<?php echo $akun['id']; ?>" onclick="return confirm('hapus akun ini?');" class="btn btn-danger">hapus</a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<!-- Produk -->


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script>"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"</script>
</body>
</html>