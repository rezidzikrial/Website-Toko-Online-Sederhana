<?php 

require "koneksi.php";
session_start();


$queryKategori = mysqli_query($conn, "SELECT * FROM kategori");

// get produk by nama produk/keyword
if(isset($_GET['keyword'])) {
    $queryProduk = mysqli_query($conn, "SELECT * FROM produk WHERE nama LIKE '%$_GET[keyword]%'");
}

// get produk by kategori
else if(isset($_GET['kategori'])) {
    $queryGetKategoriId = mysqli_query($conn, "SELECT id FROM kategori WHERE nama='$_GET[kategori]'");
    $kategoriId = mysqli_fetch_array($queryGetKategoriId);
    
    $queryProduk = mysqli_query($conn, "SELECT * FROM produk WHERE kategori_id='$kategoriId[id]'");
}

// get produk default
else {
    $queryProduk = mysqli_query($conn, "SELECT * FROM produk");
}

$countData = mysqli_num_rows($queryProduk);

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

            <meta http-equiv="refresh" content="1; url=produk.php" />
<?php
    }else{
        mysqli_query($conn, "INSERT INTO keranjang (user_id, nama, harga, quantity, foto) VALUES('$user_id', '$produkNama', '$produkHarga', '$produkQuantity', '$produkFoto')") or die('query failed');
        ?>
        <div class="alert alert-success mt-3" role="alert">
            berhasil ditambahkan ke keranjang
        </div>

            <meta http-equiv="refresh" content="1; url=produk.php" />
<?php
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online | Produk</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php require 'navbar.php'; ?>

<!--banner-->
<div class="container-fluid banner-produk d-flex align-items-center">
    <div class="container text-center">
        <h1 class="text-white"><a class="no-decoration" href="index.php">Home</a> | Produk</h1>
    </div>
</div>
<!--banner-->

<!--body-->
<div class="container py-5">
    <div class="row">
        <div class="col-lg-3 mb-5">
            <h3 class="text-warning">Kategori Produk</h3>
        <ul class="list-group">
            <?php while($kategori = mysqli_fetch_array($queryKategori)) { ?>
            <a class="no-decoration" href="produk.php?kategori=<?php echo $kategori['nama'];?>">
            <li class="list-group-item"><?php echo $kategori['nama'];?></li>
            </a>
            <?php } ?>
        </ul>
        </div>
        <div class="col-lg-9 ">
            <h3 class="text-center text-warning">Produk</h3>
            <div class="row">
                <?php 
                 if($countData<1) {
                ?>
                    <h4 class="text-center my-5">Produk tidak tersedia</h4>
                <?php 
                  }
                ?>
                <?php while($produk = mysqli_fetch_array($queryProduk)) { ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                    <form action="" method="post">
                        <div class="image-box">
                    <img src="images/<?php echo $produk['foto']; ?>" class="card-img-top" alt="..."></div>
                        <div class="card-body">
                            <div class="card-title"><?php echo $produk['nama']; ?></div>
                            <p class="card-text text-truncate"><?php echo $produk ['detail']; ?></p>
                            <p class="card-text text-harga">Rp.<?php echo $produk['harga']; ?></p>
                            <input type="number" min="1" name="produk_quantity" value="1" class="qty">
                            <input type="hidden" name="produk_nama" value="<?php echo $produk['nama']; ?>">
                            <input type="hidden" name="produk_harga" value="<?php echo $produk['harga']; ?>">
                            <input type="hidden" name="produk_foto" value="<?php echo $produk['foto']; ?>">
                            <a href="produk-detail.php?nama=<?php echo $produk['nama']; ?>" class="btn warna4 text-white mb-2 mt-2">Detail</a>
                            <input type="submit" value="tambah keranjang" name="add_cart" class="card-text btn warna4 text-white mb-2 mt-2">
                        </div>
                        </form>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<!--body-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script>"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"</script>
</body>
<?php require 'footer.php'; ?>
</html>