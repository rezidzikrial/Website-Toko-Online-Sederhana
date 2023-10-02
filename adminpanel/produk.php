<?php
      session_start();
    require "../koneksi.php";

    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)) {
        header('location:../login.php');
    }

    $queryProduk = mysqli_query($conn, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a. kategori_id=b.id");
    $jmlhProduk = mysqli_num_rows($queryProduk);

    $queryKategori = mysqli_query($conn, "SELECT * FROM kategori");

function generateRandomString($length = 10){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1 )];
    }
    return $randomString;
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<style>
    .no-decoration{
        text-decoration: none;
    }


</style>
<body>
<?php require "navbar.php"; ?>
     <!--banner-->
     <div class="container-fluid banner-produk d-flex align-items-center">
    <div class="container text-center">
        <h1 class="text-white"><a class="no-decoration" href="index.php">Home</a> | Produk</h1>
    </div>
</div>
<!--banner-->
<div class="container mt-5">

<!-- tambah produk -->
<div class="my-5 col-12 md-6">
    <h3>Tambah Produk</h3>

    <form Action="" method="post" enctype="multipart/form-data">
        <div>
        <label for="nama">Nama</label>
        <input type="text" id="nama" name="nama" placeholder="masukan nama" class="form-control" autocomplete="off" required></input>
        </div>
        <div>
            <label for="kategori">Kategori</label>
            <select name="kategori" id="kategori" class="form-control" required>
            <option value="">pilih kategori dibawah</option>
                <?php 
                    while($data=mysqli_fetch_array($queryKategori)) {
                    ?>
                        <option value="<?php echo $data['id']; ?>"><?php echo $data['nama']; ?></option>
                    <?php
                    }
                ?>
            </select>
        </div>
        <div>
            <label for="harga">Harga</label>
            <input type="number" class="form-control" name="harga" required>
        </div>
        <div class="">
            <label for="foto">Masukan Foto Porduk</label>
            <input type="file" name="foto" id="foto" class="form-control">
        </div>
        <div>
            <label for="detail">Detail</label>
            <textarea name="detail" id="detail" cols="2" rows="5" class="form-control"></textarea>
        </div>
        <div>
            <label for="ketersediaan_stok">Ketersediaan Stok</label>
            <select name="ketersediaan_stok" id="ketersediaan_stok" class="form-control">
                <option value="tersedia">tersedia</option>
                <option value="habis">habis</option>
            </select>
        </div>
        <div class="mt-3">
                <button class="btn btn-primary" type="submit" name="simpan">Simpan</button>
        </div>
</form>

    <?php 
     if(isset($_POST['simpan'])) {
        $nama = htmlspecialchars($_POST['nama']);
        $kategori = htmlspecialchars($_POST['kategori']);
        $harga = htmlspecialchars($_POST['harga']);
        $detail = htmlspecialchars($_POST['detail']);
        $ketersediaan_stok = ($_POST['ketersediaan_stok']);

        $target_dir = "../images/";
        $nama_file = basename($_FILES["foto"]["name"]);
        $target_file = $target_dir . $nama_file;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $image_size = $_FILES["foto"]["size"];
        $randomName = generateRandomString(10);
        $new_name = $randomName . "." . $imageFileType;

        if($nama=='' && $kategori=='' && $harga==''){
?>
        <div class="alert alert-warning mt-3" role="alert">
                        Nama, Kategori dan harga wajib diisi
                        </div>
<?php
        }
        else{
            if($nama_file!=''){
                if($image_size>500000){
    ?>
            <div class="alert alert-warning mt-3" role="alert">
                        Foto tidak boleh lebih dari 500kb
                        </div>   
    <?php
                }
                else{
                    if($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'gif') {
    ?>
            <div class="alert alert-warning mt-3" role="alert">
                        File foto wajib bertipe jpg,png, dan gif
                        </div>
    <?php   
                    }
                    else{
                        move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new_name);
                    }
                }
            }

        //query insert tambah produk
        $queryTambah = mysqli_query($conn, "INSERT INTO produk (kategori_id, nama, harga, foto, detail, ketersediaan_stok) VALUES ('$kategori', '$nama', '$harga', '$new_name', '$detail', '$ketersediaan_stok')"); 

        if($queryTambah){
?>
        <div class="alert alert-success mt-3" role="alert">
        Produk berhasil ditambahkan
        </div>

        <meta http-equiv="refresh" content="1; url=produk.php" />
<?php
    }
    else{
        echo mysqli_error($conn);
    }
        }
     }
    ?>

</div>

<div class="mt-3">
     <h2>List Produk</h2>

     <div class="table-responsive mt-7">
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Ketegori</th>
                    <th>Harga</th>
                    <th>Ketersidaan stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if($jmlhProduk==0) {
                    ?>
                    <tr>
                    <td colspan=6 class="text-center"> Data Produk Tidak Tersedia</td>
                    </tr>
                <?php 
                }
                else{
                    $jumlah = 1;
                    while($data = mysqli_fetch_array($queryProduk)){
                ?>
                    <tr>
                        <td><?php echo $jumlah; ?></td>
                        <td><?php echo $data['nama']; ?></td>
                        <td><?php echo $data['nama_kategori']; ?></td>
                        <td><?php echo $data['harga']; ?></td>
                        <td><?php echo $data['ketersediaan_stok']; ?></td>
                        <td>
                            <a href="produk-detail.php?u=<?php echo $data['id']; ?>"
                            class="btn btn-info"><i class="fas fa-exclamation"></i></a>
                        </td>
                    </tr>
                <?php
                    $jumlah++;
                }
            }
                ?>
            </tbody>
        </table>
</div>
</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script> 
</body>
</html>