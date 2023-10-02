<?php 
require 'koneksi.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['pesanan'])){

    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $noHp = $_POST['no_hp'];
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $pembayaran = mysqli_real_escape_string($conn, $_POST['pembayaran']);

    $placed_on = date('d-M-Y');

    $totalHarga = 0;
    $produkKeranjang[] = '';

    $queryKeranjang = mysqli_query($conn, "SELECT * FROM keranjang WHERE user_id = '$user_id'") or die('query failed');

    if(mysqli_num_rows($queryKeranjang) > 0){
        while($keranjang = mysqli_fetch_assoc($queryKeranjang)) {
            $produkKeranjang[] = $keranjang['nama'].' ('.$keranjang['quantity'].') ';
            $sub_total = ($keranjang['harga'] * $keranjang['quantity']);
            $totalHarga += $sub_total;
        }
    }

    $totalProduk = implode(', ',$produkKeranjang);

    $orderQuery = mysqli_query($conn, "SELECT * FROM `order` WHERE nama = '$nama' AND no_hp = '$noHp' AND email = '$email' AND alamat = '$alamat' AND metode_pembayaran = '$pembayaran' AND total_produk = '$totalProduk' AND total_harga = '$totalHarga'") or die('query failed');

    if($totalHarga == 0){
        ?>
        <div class="alert alert-success mt-3" role="alert">
            keranjang anda kosong
        </div>

            <meta http-equiv="refresh" content="1; url=checkout.php"/>
        <?php
    }else{
        if(mysqli_num_rows($orderQuery) > 0){
            ?>
        <div class="alert alert-success mt-3" role="alert">
            pesanan anda sudah ada
        </div>

            <meta http-equiv="refresh" content="1; url=checkout.php" />
        <?php
        }else{
            mysqli_query($conn, "INSERT INTO `order` (user_id, nama, no_hp, email, alamat, metode_pembayaran, total_produk, total_harga, placed_on) VALUES('$user_id', '$nama', '$noHp', '$email', '$alamat', '$pembayaran', '$totalProduk', '$totalHarga', '$placed_on')") or die('query failed');
        ?>
        <div class="alert alert-success mt-3" role="alert">
            pemesanan anda berhasil
        </div>

            <meta http-equiv="refresh" content="1; url=checkout.php"/>
        <?php
        mysqli_query($conn, "DELETE FROM keranjang WHERE user_id = '$user_id'") or die('query failed');
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php require 'navbar.php'; ?>

<!--banner-->
<div class="container-fluid banner-produk d-flex align-items-center">
    <div class="container text-center">
        <h1 class="text-white"><a class="no-decoration" href="index.php">Home</a> | Pembayaran</h1>
    </div>
</div>
<!--banner-->

<section class="display-order">
<h1 class="mt-3 mb-3">Checkout Pembayaran</h1>
   <?php  
      $grandTotal = 0;
      $queryKeranjang = mysqli_query($conn, "SELECT * FROM keranjang WHERE user_id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($queryKeranjang) > 0){
         while($fetchKeranjang = mysqli_fetch_assoc($queryKeranjang)){
            $hargaTotal = ($fetchKeranjang['harga'] * $fetchKeranjang['quantity']);
            $grandTotal += $hargaTotal;
   ?>
   <p> <?php echo $fetchKeranjang['nama']; ?> <span>(<?php echo 'Rp.'.$fetchKeranjang['harga'].'/-'.' x '. $fetchKeranjang['quantity']; ?>)</span> </p>
   <?php
      }
   }else{
      echo '<p class="empty">keranjang anda kosong</p>';
   }
   ?>
</section>

<div class="container">
<h1 class="mt-3 mb-3">Isi data</h1>
    <form action="" method="post">
        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" name="nama" placeholder="Masukkan Nama Anda" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Namor Hp</label>
            <input type="number" class="form-control" name="no_hp" placeholder="Masukkan Nomor Hp anda" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Alamat Email</label>
            <input type="email" class="form-control" name="email" placeholder="example@example.com" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Alamat Pengiriman</label>
            <textarea class="form-control" name="alamat" rows="3" placeholder="Masukkan Alamat Pengiriman Anda" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Metode Pembayaran</label>
            <select class="form-select" name="pembayaran">
                <option value="" selected disabled>Pilih metode pembayaran</option>
                <option value="transfer">Transfer Bank</option>
                <option value="kartuKredit">Kartu Kredit</option>
                <option value="eWallet">E-Wallet</option>
            </select>
        </div>
       
        <input type="submit" value="pesan sekarang" class="btn btn-success mb-3" name="pesanan">
    </form>
</div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script>"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"</script>
</body>
<?php require 'footer.php'; ?>
</html>