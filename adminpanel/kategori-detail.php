<?php 
    require "../koneksi.php";

    session_start();

    $admin_id = $_SESSION['admin_id'];

    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)) {
        header('location:../login.php');
    }

    $id = $_GET['u'];

    $query = mysqli_query($conn, "SELECT * FROM kategori WHERE id=$id");
    $data = mysqli_fetch_array($query);
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kategori</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php require "navbar.php"; ?>

    <div class="container mt-5">
    <h2>Detail Kategori</h2>
    
    <div class="col-12 col-md-6">
    <form action="" method="post">
        <div>
        <label for="kategori">Ubah Nama Kategori : </label>
        <input type="text" name="kategori" id="kategori"value="<?php echo $data['nama']; ?>"   class="form-control">
        </div>

    <div class="mt-5 d-flex justify-content-between">
        <button type="submit" class="btn btn-success" name="ubahBtn">Ubah</button>
        <button type="submit" class="btn btn-danger" name="hapusBtn">Hapus</button>
    </div>
</form>

    <?php 
        if(isset($_POST['ubahBtn'])){
            $kategori = htmlspecialchars($_POST['kategori']);
        
        if($data['nama']==$kategori){
            ?>
            <meta http-equiv="refresh" content="1; url=kategori.php" />
            <?php
        }
        else{
            $query = mysqli_query($conn, "SELECT * FROM kategori WHERE nama='$kategori'");
            $jumlahData = mysqli_num_rows($query);
        
            if($jumlahData > 0){
                ?>
                <div class="alert alert-warning mt-3" role="alert">
                kategori sudah ada
                </div>
                <?php
            }
            else{
                $queryUbah = mysqli_query($conn, "UPDATE kategori SET nama='$kategori' WHERE id='$id'");
                if($queryUbah) {
                    ?>
                     <div class="alert alert-success mt-3" role="alert">
                        kategori berhasil diubah
                        </div>
                        <meta http-equiv="refresh" content="1; url=kategori.php"/>
                        <?php
                }
                else{
                    echo mysqli_error($conn);
                }
            }
        }
    }

    if(isset($_POST['hapusBtn'])){
        $queryCheck = mysqli_query($conn, "SELECT * FROM produk WHERE kategori_id='$id'");
        $dataCount = mysqli_num_rows($queryCheck);

        if($dataCount > 0) {
?>
            <div class="alert alert-warning mt-3" role="alert">
                kategori tidak bisa hihapus karena sudah digunakan pada produk
            </div>
<?php
die();
        }                     

        $queryHapus = mysqli_query($conn, "DELETE FROM kategori WHERE id='$id'");
        
        if($queryHapus){
            ?>
            <div class="alert alert-success mt-3" role="alert">
                        kategori berhasil dihapus
                        </div>
                <meta http-equiv="refresh" content="1; url=kategori.php" />
            <?php
        }
        else{
            echo mysqli_error($conn);
        }
    }
    ?>
<br>
<a href="kategori.php" class="btn btn-primary">Kembali</a>

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>   
</body>
</html>