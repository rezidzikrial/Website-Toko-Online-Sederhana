<?php 
        session_start();
    require "../koneksi.php";

    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)) {
        header('location:../login.php');
    }

    $id = $_GET['u'];

    $query = mysqli_query($conn, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a. kategori_id=b.id WHERE a.id='$id'");
    $data = mysqli_fetch_array($query);

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
    <title>Produk Detail</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<style>
    form div{
        margin-top: 10px;
    }
</style>

<body>
<?php require "navbar.php"; ?>
   <!--banner-->
   <div class="container-fluid banner-produk d-flex align-items-center">
    <div class="container text-center">
        <h1 class="text-white"><a class="no-decoration" href="index.php">Home</a> | Produk detail</h1>
    </div>
</div>
<!--banner-->

    <div class="container mt-5">
        <h2>Detail Produk</h2>

    <div class="col-12 col-md-6">
        <form action="" method="post" enctype="multipart/form-data">
    <div>
        <label for="kategori">Ubah Nama Produk : </label>
        <input type="text" name="nama" id="nama"      value="<?php echo $data['nama']; ?>"   class="form-control" autocomplete="off">
    </div>
    <div>
            <label for="kategori">Kategori :</label>
            <select name="kategori" id="kategori" class="form-control" required>
            <option value="<?php echo $data['kategori_id']; ?>"><?php echo $data['nama_kategori']; ?></option>
                <?php 
                    while($dataKategori=mysqli_fetch_array($queryKategori)) {
                    ?>
                        <option value="<?php echo $dataKategori['id']; ?>"> <?php echo $dataKategori['nama']; ?>
                        </option>
                    <?php
                    }
                ?>
            </select>
        </div>
        <div>
            <label for="harga">Harga :</label>
            <input type="number" class="form-control"
            value="<?php echo $data['harga'] ?>" name="harga" required>
        </div>
        <div>
            <label for="currentFoto">Foto Porduk saat ini :</label>
            <img src="../images/<?php echo $data['foto'] ?>" alt="" width="300px">
        </div>
        <div class="">
            <label for="foto">Foto</label>
            <input type="file" name="foto" id="foto" class="form-control">
        </div>
        <div>
            <label for="detail">Detail :</label>
            <textarea name="detail" id="detail" cols="2" rows="5" class="form-control">
                <?php echo $data['detail']?>
            </textarea>
        </div>
        <div>
            <label for="ketersediaan_stok">Ketersediaan Stok :</label>
            <select name="ketersediaan_stok" id="ketersediaan_stok" class="form-control">
                <option value="<?php echo $data['ketersediaan_stok']; ?>"><?php echo $data['ketersediaan_stok']; ?></option>
                <?php 
                    if($data['ketesediaan_stok'] == 'tersedia') {
                ?>
                    <option value="habis">habis</option>
                <?php 
                    }
                    else {
                ?>
                    <option value="tersedia">tersedia</option>
                <?php 
                    }
                ?>
            </select>
        </div>
        <div class="mt-5 d-flex justify-content-between">
                <button class="btn btn-success" type="submit" name="simpan">Ubah</button>
                <button class="btn btn-danger" type="submit" name="hapus">Hapus</button>
        </div>
    </form>

    <?php 
        if(isset($_POST['simpan'])){
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
        $queryUpdate = mysqli_query($conn, "UPDATE produk  SET kategori_id='$kategori', nama='$nama',harga='$harga', detail='$detail', ketersediaan_stok='$ketersediaan_stok' WHERE id='$id'");

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
            move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir .  $new_name);

            $queryUpdate = mysqli_query($conn, "UPDATE produk SET foto='$new_name' WHERE id='$id'");

            if($queryUpdate) {

?>
           <div class="alert alert-success mt-3" role="alert">
            produk berhasil diubah
        </div>

        <meta http-equiv="refresh" content="1; url=produk.php" />
<?php
            }
            else{
                echo mysqli_error($conn);
            }
        }
      }
    }
  }
}

    if(isset($_POST['hapus'])){
        $queryHapus = mysqli_query($conn, "DELETE FROM produk WHERE id='$id'");

        if($queryHapus) {
?>
        <div class="alert alert-success mt-3" role="alert">
            produk berhasil dihapus
        </div>

            <meta http-equiv="refresh" content="1; url=produk.php" />
<?php

    }
}
?>

<div class="mt-3">
<a href="produk.php" class="btn btn-primary">Kembali</a>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>     
</body>
</html>