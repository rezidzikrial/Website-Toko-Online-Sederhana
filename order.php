<?php 

require 'koneksi.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orderan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php require 'navbar.php'; ?>

    <!--banner-->
<div class="container-fluid banner-produk d-flex align-items-center">
    <div class="container text-center">
        <h1 class="text-white"><a class="no-decoration" href="index.php">Home</a> | Order</h1>
    </div>
</div>
<!--banner-->



<div class="container py-5">
<h1 class="text-center warna6 mb-5">ORDERAN</h1>
    <div class="card mb-5 col-lg-4">
    <?php
         $query = mysqli_query($conn, "SELECT * FROM `order` WHERE user_id = '$user_id'") or die('query failed');
         if(mysqli_num_rows($query) > 0){
            while($fetch_orders = mysqli_fetch_assoc($query)){
      ?>
        <div class="card-header text-center warna1 text-white">
            Data Pembayaran Customer
        </div>
        <div class="card-body">
            <p class="card-text"> tanggal order : <span class="text-daftar"><?php echo $fetch_orders['placed_on']; ?></span> </p>
            <p class="card-text">nama : <span class="text-daftar"><?php echo $fetch_orders['nama']; ?></span> </p>
            <p class="card-text">no hp : <span class="text-daftar"><?php echo $fetch_orders['no_hp']; ?></span> </p>
            <p class="card-text">email : <span class="text-daftar"><?php echo $fetch_orders['email']; ?></span> </p>
            <p class="card-text">alamat pengiriman : <span class="text-daftar"><?php echo $fetch_orders['alamat']; ?></span> </p>
            <p class="card-text">metode pembayaran : <span class="text-daftar"><?php echo $fetch_orders['metode_pembayaran']; ?></span> </p>
            <p class="card-text">membeli produk : <span class="text-daftar"><?php echo $fetch_orders['total_produk']; ?></span> </p>
            <p class="card-text">status pengerjaan : <span style="color:<?php if($fetch_orders['status_pembayaran'] == 'pending'){ echo 'red'; }else{ echo 'green'; } ?>;"><?php echo $fetch_orders['status_pembayaran']; ?></span> </p>
        </div>
        <?php
       }
      }else{
         echo '<p class="empty">belum ada orderan!</p>';
      }
      ?>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script>"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"</script>
</body>
<?php require 'footer.php'; ?>
</html>