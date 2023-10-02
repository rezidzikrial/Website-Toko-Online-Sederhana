<?php 

session_start();

require "koneksi.php";

$queryProduk = mysqli_query($conn, "SELECT id, nama, harga, foto, detail FROM produk LIMIT 6 ");

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

            <meta http-equiv="refresh" content="1; url=index.php" />
<?php
    }else{
        mysqli_query($conn, "INSERT INTO keranjang (user_id, nama, harga, quantity, foto) VALUES('$user_id', '$produkNama', '$produkHarga', '$produkQuantity', '$produkFoto')") or die('query failed');
        ?>
        <div class="alert alert-success mt-3" role="alert">
            berhasil ditambahkan ke keranjang
        </div>

            <meta http-equiv="refresh" content="1; url=index.php" />
<?php
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php require "navbar.php"; ?>

<!-- banner -->
<section class="home">
   <div class="container-fluid banner d-flex align-items-center">
      <div class="container text-center text-white">
        <h1>Toko Online ReZi</h1>
        <div class="col-md-8 offset-md-2">
            <form method="get" action="produk.php">
                <div class="input-group input-group-lg my-4">
                    <input type="text"      class="form-control"                     placeholder="mau cari apa" aria-label="Recipient's" aria-describedby="basic-addon2" name="keyword" autocomplete="off" >
                <button class="btn warna3">Telusuri</button>
                </div>
            </form>
        </div>
      </div>
   </div>
</section>
<!-- banner -->

<!-- highlight kategori -->
<div class="container-fluid py-5">
    <div class="container text-center">
    <h3>Kategori Produk</h3>

    <div class="row mt-5">
        <div class="col-md-4 mb-3">
            <div class="highlighted-kategori kategori-baju-pria d-flex justify-content-center align-items-center">
                <h4 class="text-white"><a class="no-decoration" href="produk.php?kategori=Baju">Baju</a></h4>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="highlighted-kategori kategori-celana d-flex justify-content-center align-items-center">
                <h4 class="text-white"><a class="no-decoration" href="produk.php?kategori=Celana">Celana</a></h4>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="highlighted-kategori kategori-sepatu d-flex justify-content-center align-items-center">
                <h4 class="text-white"><a class="no-decoration" href="produk.php?kategori=Sepatu">Kategori Sepatu</a></h4>
            </div>
        </div>

    </div>
</div>
</div>
<!-- highlight kategori -->

<!-- tentang kami -->
<div class="container-fluid warna3 py-5">
    <div class="container text-center">
        <h3> Tentang Kami </h3>
        <p class="fs-5">
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quia assumenda inventore, reiciendis molestiae saepe perspiciatis deserunt possimus! Reiciendis temporibus debitis incidunt fugiat laboriosam unde eius doloremque reprehenderit dolor dolores, tempore blanditiis impedit odit aliquam amet repudiandae quos, facere praesentium optio vel nam necessitatibus! Modi doloremque sequi ut voluptatibus fugiat beatae eaque necessitatibus quaerat ipsam ducimus itaque aliquam possimus, vero voluptatum eos. Nihil quasi sit quo veritatis tenetur cumque excepturi dolore delectus nemo, officia praesentium quam! Reiciendis repudiandae quae magnam ullam.
        </p>
    </div>
</div>
<!-- tentang kami -->

<!-- Produk -->
<div class="container-fluid py-5">
    <div class="container text-center">
        <h3>Produk</h3>

        <div class="row mt-5">
        <?php while($data = mysqli_fetch_array($queryProduk)){ ?>
            <div class="col-sm-6 col-md-4 mb-3">
            <div class="card h-100">
            <form action="" method="post">
                <div class="image-box">
                    <img src="images/<?php echo $data['foto']; ?>" class="card-img-top" alt="...">
                </div>
                <div class="card-body">
                <h4 class="card-title"><?php echo $data['nama']; ?></h4>
                <p class="card-text text-truncate"><?php echo $data ['detail']; ?></p>
                <p class="card-text text-harga">Rp.<?php echo $data['harga']; ?></p>
                <input type="number" min="1" name="produk_quantity" value="1" class="qty">
                <input type="hidden" name="produk_nama" value="<?php echo $data['nama']; ?>">
                <input type="hidden" name="produk_harga" value="<?php echo $data['harga']; ?>">
                <input type="hidden" name="produk_foto" value="<?php echo $data['foto']; ?>">
                <div>
                <a href="produk-detail.php?nama=<?php echo $data['nama']; ?>" class="btn warna4 text-white mt-2">Detail Produk</a>
                </div>
                <input type="submit" value="tambah keranjang" name="add_cart" class="card-text btn warna4 text-white mb-2 mt-2">
                    </div>
                    </form>
                </div>
            </div>
            <?php } ?>
        </div>
        <a class="btn btn-outline-warning mt-3" href="produk.php">See More</a>
    </div>
</div>
<!-- Produk -->




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script>"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"</script>
</body>
<?php require 'footer.php'; ?>
</html>