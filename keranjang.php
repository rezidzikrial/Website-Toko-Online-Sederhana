<?php 
require 'koneksi.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)) {
    header('location:login.php');
}

if(isset($_POST['update_keranjang'])) {
    $keranjang_id = $_POST['keranjang_id'];
    $jmlhKeranjang = $_POST['jumlah_keranjang'];
    mysqli_query($conn, "UPDATE keranjang SET quantity = '$jmlhKeranjang' WHERE id = '$keranjang_id'") or die ('query failed');
    ?>
           <div class="alert alert-success mt-3" role="alert">
            keranjang berhasil diperbarui
        </div>
        <meta http-equiv="refresh" content="1; url=keranjang.php" />
<?php
}

if(isset($_GET['delete_keranjang'])) {
    $delete_id = $_GET['delete_keranjang'];
    mysqli_query($conn, "DELETE FROM keranjang WHERE id = '$delete_id'") or die('query failed');
    header('location:keranjang.php');
}

if(isset($_GET['delete_semua'])) {
    mysqli_query($conn, "DELETE FROM keranjang WHERE user_id = '$user_id'") or die('query failed');
    header('location:keranjang.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php require "navbar.php"; ?>

<!--banner-->
<div class="container-fluid banner-produk d-flex align-items-center">
    <div class="container text-center">
        <h1 class="text-white"><a class="no-decoration" href="index.php">Home</a> | Keranjang</h1>
    </div>
</div>
<!--banner-->

<div class="container py-5">
    <div class="row">
    <div class="col-lg-9">
        <h1 class="text-center">PRODUK YANG DIPILIH</h1>
        <?php 
                        $grandTotal = 0;
                        $queryKeranjang = mysqli_query($conn, "SELECT * FROM keranjang WHERE user_id = '$user_id'") or die('query failed');
                        if(mysqli_num_rows($queryKeranjang) > 0) {
                            while($fetchKeranjang = mysqli_fetch_assoc($queryKeranjang)){
        ?>
        <div class="card" style="width: 18rem;">
                   
                    <a href="keranjang.php?delete_keranjang=<?php echo $fetchKeranjang['id']; ?>" class="fas fa-times text-danger btn warna4 del-cart" onclick="return confirm('hapus dari keranjang?');"></a>
                    <div class="image-box">
                        <img src="images/<?php echo $fetchKeranjang['foto']; ?>" class="card-img-top mt-3" alt="...">
                    </div>
            <div class="card-body">
                    <p class="card-text text-truncate"><?php echo $fetchKeranjang['nama']; ?></p>
                    <form action="" method="post">
                            <input type="hidden" name="keranjang_id" value="<?php echo $fetchKeranjang['id']; ?>">
                            <input type="number" min="1" name="jumlah_keranjang" value="<?php echo $fetchKeranjang['quantity']; ?>">
                            <input type="submit" name="update_keranjang" value="Ubah" class="btn btn-warning mt-2">
                            <div class="card-text">total harga : <span>Rp.<?php echo $sub_total = ($fetchKeranjang['quantity'] * $fetchKeranjang['harga']); ?></span>/-</div>
                        
                    </form>
            </div>
        </div>
        <?php
            $grandTotal += $sub_total;
                }
                }else{
                    echo '<p class="empty" class="text-center">Keranjang anda kosong</p>';
                }
        ?>
        </div>
    </div>
</div>


<div class="mt-2 text-center">
    <a href="keranjang.php?delete_semua" class="btn btn-danger mb-3 <?php  echo ($grandTotal > 1)?'':'disabled'; ?>"onclick="return confirm('hapus semua dari keranjang');">hapus semua</a>
    <a href="produk.php" class="btn btn-warning mb-3">lanjut pilih jasa</a>
         <a href="checkout.php" class="btn btn-success mb-3 <?php echo ($grandTotal > 1)?'':'disabled'; ?>">lanjutkan pembayaran</a>
</div>

 

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script>"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"</script>
</body>
</html>