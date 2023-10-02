<?php
    session_start();
    require "../koneksi.php";

    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)) {
        header('location:../login.php');
    }

    $queryKategori = mysqli_query($conn, "SELECT * FROM kategori");
    $jmlhKategori = mysqli_num_rows($queryKategori);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori</title>
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
<div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="../adminpanel/index.php" class="no-decoration text-muted">
                        <i class="fas fa-house"></i> Home </a>
                 </li>
                 <li class="breadcrumb-item active" aria-current="page">
                Kategori
                 </li>
            </ol>
         </nav>

        <div class="my-5 col-12 md-6">
            <h3>Tambah Kategori</h3>

            <form Action="" method="post">
            <div>
                <label for="kategori"></label>
                <input type="text" id="kategori" name="kategori" placeholder="input nama kategori" class="form-control" autocomplete="off" required> <br>
            </div>
            <div>
                <button class="btn btn-primary" type="submit" name="tambah">Simpan</button>
            </div>
            </form>
                
            <?php 
                if(isset($_POST['tambah'])){
                    $kategori = htmlspecialchars($_POST['kategori']);

                    $queryExist = mysqli_query($conn, "SELECT * FROM kategori WHERE nama='$kategori'");
                    $jumlahDataKategoriBaru = mysqli_num_rows($queryExist);

                    if($jumlahDataKategoriBaru > 0){
                        ?>
                    <div class="alert alert-warning mt-3" role="alert">
                        kategori sudah ada
                        </div>
                    <?php 
                    }
                    else{
                        $queryTambah = mysqli_query($conn, "INSERT INTO kategori (nama) VALUES ('$kategori')");
                        if($queryTambah){
                            ?>
                        <div class="alert alert-success mt-3" role="alert">
                        kategori berhasil ditambahkan
                        </div>

                        <meta http-equiv="refresh" content="1; url=kategori.php" />
                        <?php
                        }else{
                            echo mysqli_error($conn);
                        }
                    }
                }
            ?>
        </div>

    <div class="mt-3">
     <h2>List Kategori</h2>

     <div class="table-responsive mt-7">
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if($jmlhKategori==0){
                ?>
                    <tr>
                        <td colspan=3 class="text-center">Kategori Tidak Tersedia</td>
                    </tr>
                <?php 
                    }
                    else{   
                        $jumlah = 1;
                    while($data = mysqli_fetch_array($queryKategori)){
                ?>
                    <tr>
                        <td><?php echo $jumlah; ?></td>
                        <td><?php echo $data['nama']; ?></td>
                        <td>
                            <a href="kategori-detail.php?u=<?php echo $data['id']; ?>"
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


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>    
</body>
</html>