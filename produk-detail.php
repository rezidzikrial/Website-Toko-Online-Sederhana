<?php 
    require "koneksi.php";
    session_start();

    $nama = htmlspecialchars($_GET['nama']);
    $queryProduk = mysqli_query($conn, "SELECT * FROM produk WHERE nama='$nama'");
    $produk = mysqli_fetch_array($queryProduk);

    $queryProdukTerkait = mysqli_query($conn, "SELECT * FROM produk WHERE kategori_id='$produk[kategori_id]' AND id!='$produk[id]' LIMIT 4");

    $user_id = $_SESSION['user_id'];

   if(!isset($user_id)){
        header('location:login.php');
   }

    if(isset($_POST['add_cart'])) {
    
        $produkNama = $_POST['produk_nama'];
        $produkHarga = $_POST['produk_harga'];
        $produkFoto = $_POST['produk_foto'];
        $produkQuantity = $_POST['produk_quantity'];
    
        $checkCart = mysqli_query($conn, "SELECT * FROM keranjang WHERE nama = '$produkNama' AND user_id = '$user_id'") or die('query failed');
    
        if(mysqli_num_rows($checkCart) > 0){
            ?>
            <div class="alert alert-success mt-3" role="alert">
                sudah ada dikeranjang
            </div>
    
                <meta http-equiv="refresh" content="1; url=keranjang.php" />
    <?php
        }else{
            mysqli_query($conn, "INSERT INTO keranjang (user_id, nama, harga, quantity, foto) VALUES('$user_id', '$produkNama', '$produkHarga', '$produkQuantity', '$produkFoto')") or die('query failed');
            ?>
            <div class="alert alert-success mt-3" role="alert">
                berhasil ditambahkan ke keranjang
            </div>
    
                <meta http-equiv="refresh" content="1; url=produk.php"/>
    <?php
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk | Detail</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php require "navbar.php"; ?>

<!--banner-->
<div class="container-fluid banner-produk d-flex align-items-center">
    <div class="container text-center">
        <h1 class="text-white"><a class="no-decoration" href="index.php">Home</a> | Detail</h1>
    </div>
</div>
<!--banner-->

<!--body-->
<div class="container-fluid py-5">
<form action="" method="post">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 mb-3">
                <img src="images/<?php echo $produk['foto']; ?>" class="card-img-top" alt="...">
            </div>
            <div class="col-lg-6 offset-lg-1">
                <h1><?php echo $produk['nama']; ?></h1>
                <p><?php echo $produk ['detail']; ?></p>
                <p class="text-harga">Rp.<?php echo $produk['harga']; ?></p>
                <p class="fs-5">Stok : <strong><?php echo $produk['ketersediaan_stok']; ?></strong></p>
                <input type="number" min="1" name="produk_quantity" value="1" class="qty">
                <input type="hidden" name="produk_nama" value="<?php echo $produk['nama']; ?>">
                <input type="hidden" name="produk_harga" value="<?php echo $produk['harga']; ?>">
                <input type="hidden" name="produk_foto" value="<?php echo $produk['foto']; ?>">
                <input type="submit" value="tambah keranjang" name="add_cart" class="card-text btn warna4 text-white mb-2 mt-2">
            </div>
            </form>
        </div>
        <a href="produk.php" class="btn warna4 text-white text-center mt-3">Kembali</a>
    </div>
</div>
<!--body-->

<!--produk terkait-->
<div class="container-fluid py-5 warna5">
    <div class="container">
        <h2 class="text-center text-white mb-5">Produk Terkait</h2>
        <div class="row">
        <?php while($data = mysqli_fetch_array($queryProdukTerkait)) { ?>
            <div class="col-md-6 col-lg-3 mb-3">
                <a href="produk-detail.php?nama=<?php echo $data['nama']; ?>">
                <img src="images/<?php echo $data['foto'];?>" class="img-fluid img-thumbnail produk-terkait-image" alt="">
                </a>
            </div>
            <?php  } ?>
        </div>
    </div>
</div>
<!--produk terkait-->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script>"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"</script>
</body>
<?php require "footer.php"; ?>
</html>