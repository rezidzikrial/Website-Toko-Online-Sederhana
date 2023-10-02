<?php

require '../koneksi.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

if(isset($_POST['ubah_orderan'])) {

    $ubahOrderanId = $_POST['order_id'];
    $ubahPembayaran = $_POST['ubah_pembayaran'];
    mysqli_query($conn, "UPDATE `order` SET status_pembayaran = '$ubahPembayaran' WHERE id = '$ubahOrderanId'") or die('query failed');
    ?>
    <div class="alert alert-warning" role="alert">
      status telah diubah

      <meta http-equiv="refresh" content="1; url=admin-order.php" />
    </div>
    <?php
}

if(isset($_GET['hapus'])){
    $hapusId = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM `order` WHERE id = '$hapusId'") or die('query failed');
    header('location:admin-order.php');
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pesanan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php require 'navbar.php'; ?>

<section class="orders">

   <h1 class="title text-center">ORDERAN/PESANAN</h1>

   <div class="box-container">
      <?php
      $queryPesanan = mysqli_query($conn, "SELECT * FROM `order`") or die('query failed');
      if(mysqli_num_rows($queryPesanan) > 0){
         while($orderan = mysqli_fetch_assoc($queryPesanan)){
      ?>
      <div class="box">
         <p> user id : <span><?php echo $orderan['user_id']; ?></span> </p>
         <p> pada tanggal : <span><?php echo $orderan['placed_on']; ?></span> </p>
         <p> nama : <span><?php echo $orderan['nama']; ?></span> </p>
         <p> no hp : <span><?php echo $orderan['no_hp']; ?></span> </p>
         <p> email : <span><?php echo $orderan['email']; ?></span> </p>
         <p> alamat : <span><?php echo $orderan['alamat']; ?></span> </p>
         <p> jumlah produk dipesan : <span><?php echo $orderan['total_produk']; ?></span> </p>
         <p> pembayaran : <span><?php echo $orderan['metode_pembayaran']; ?></span> </p>
         <form action="" method="post">
            <input type="hidden" name="order_id" value="<?php echo $orderan['id']; ?>">
            <select name="ubah_pembayaran">
               <option value="" selected disabled><?php echo $orderan['status_pembayaran']; ?></option>
               <option value="pending">pending</option>
               <option value="on progress">on progress</option>
               <option value="completed">completed</option>
            </select>
            <input type="submit" value="ubah" name="ubah_orderan" class="option-btn">
            <a href="admin-order.php?hapus=<?php echo $orderan['id']; ?>" onclick="return confirm('hapus pesanan ini?');" class="delete-btn">hapus</a>
         </form>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">belum ada pesanan</p>';
      }
      ?>
   </div>

</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script>"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"</script>
</body>
</html>