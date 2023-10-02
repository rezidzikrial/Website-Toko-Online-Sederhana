<?php
    require "../koneksi.php";

    session_start();

    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)) {
        header('location:../login.php');
    }

    $queryKategori = mysqli_query($conn, "SELECT * FROM kategori");
    $jmlhKategori = mysqli_num_rows($queryKategori);

    $queryProduk = mysqli_query($conn, "SELECT * FROM Produk");
    $jmlhProduk = mysqli_num_rows($queryProduk);

    $queryAkun = mysqli_query($conn, "SELECT * FROM user");
    $jmlhAkun = mysqli_num_rows($queryAkun);
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<style>
    .kotak{
        border: solid;
    }
    
    .summary-kategori{
        background-color: #037367;
        border-radius: 15px;
    }

    .summary-produk{
        background-color: #BEA42E;
        border-radius: 15px;
    }
    .summary-akun{
        background-color: #BEA42E;
        border-radius: 15px;
    }
    .no-decoration{
        text-decoration: none;
    }
    
    .no-decoration:hover{
       color: #037367;
    }
     
</style>

<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fas fa-house"></i> Home
                 </li>
            </ol>
         </nav>
     <h2>halo <?php echo $_SESSION['admin_nama']?></h2>
    </div>

        <div class="container mt-5">    
            <div class="row">


            <div class="col-lg-4 col-md-6 col-12 mb-3">
                    <div class="summary-produk p-2">
                        <div class="row">
                            <div class="col-6">
                                    <h1 class="fs-4 text-white text-center"></h1>
                                    <p class="fs-4 text-white"><?php 
                                    $totalPending = 0;
                                    $selectPending = mysqli_query($conn, "SELECT total_harga FROM 
                                `order` WHERE status_pembayaran = 'pending'") or die ('query failed');
                                if(mysqli_num_rows($selectPending) > 0){
                                    while($fetchPending = mysqli_fetch_assoc($selectPending)){
                                        $totalHarga = $fetchPending['total_harga'
                                    ];
                                    $totalPending += $totalHarga;
                                    };
                                };
                                     ?> Rp.<?php echo $totalPending; ?></p>
                                    <p class="text-white">harga pesanan masuk</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-12 mb-3">
                    <div class="summary-produk p-2">
                        <div class="row">
                            <div class="col-6">
                                    <h1 class="fs-4 text-white text-center"></h1>
                                    <p class="fs-4 text-white"><?php 
                                    $totalComplete = 0;
                                    $selectComplete = mysqli_query($conn, "SELECT total_harga FROM 
                                `order` WHERE status_pembayaran = 'pending'") or die ('query failed');
                                if(mysqli_num_rows($selectComplete) > 0){
                                    while($fetchComplete = mysqli_fetch_assoc($selectComplete)){
                                        $totalHarga = $fetchComplete['total_harga'
                                    ];
                                    $totalComplete += $totalHarga;
                                    };
                                };
                                     ?> Rp.<?php echo $totalPending; ?></p>
                                    <p class="text-white">Total pendapatan</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-12 mb-3">
                    <div class="summary-kategori p-2">
                        <div class="row">
                            <div class="col-6">
                                <i class="fa-solid fa-table-list fa-7x text-black-50"></i>
                            </div>
                            <div class="col-6">
                                <h3 class="fs-4 text-white">Kategori</h3>
                                <p class="fs-4 text-white"><?php echo $jmlhKategori ?> Kategori</p>
                                <p><a href="kategori.php" class="text-white no-decoration">Lihat Detail</a></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-12 mb-3">
                    <div class="summary-produk p-2">
                        <div class="row">
                            <div class="col-6">
                               <i class="fa-solid fa-table-list fa-7x text-black-50"></i>
                            </div>
                            <div class="col-6">
                                    <h3 class="fs-4 text-white">Produk</h3>
                                    <p class="fs-4 text-white"><?php echo $jmlhProduk ?> Produk</p>
                                    <p><a href="produk.php" class="text-white no-decoration">Lihat Detail</a></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-12 mb-3">
                    <div class="summary-akun p-2">
                        <div class="row">
                            <div class="col-6">
                               <i class="fa-solid fas fa-user fa-7x text-black-50"></i>
                            </div>
                            <div class="col-6">
                                    <h3 class="fs-4 text-white">Pengguna</h3>
                                    <p class="fs-4 text-white"><?php echo $jmlhAkun ?> Pengguna</p>
                                    <p><a href="pengguna.php" class="text-white no-decoration">Detail Pengguna</a></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-12 mb-3">
                    <div class="summary-akun p-2">
                        <div class="row">
                            <div class="col-6">
                               <i class="fa-solid fas fa-suitcase fa-7x text-black-50"></i>
                            </div>
                            <div class="col-6">
                                <?php 
                                    $pesanan = mysqli_query($conn, "SELECT * FROM `order`") or die('query failed');
                                    $totalPesanan = mysqli_num_rows($pesanan);

                                ?>
                                    <h3 class="fs-4 text-white">Pesanan</h3>
                                    <p class="fs-4 text-white"><?php echo $totalPesanan ?> Pesanan</p>
                                    <p><a href="admin-order.php" class="text-white no-decoration">Detail Pesanan</a></p>
                            </div>
                        </div>
                    </div>
                </div>


                    
            </div>
        </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script>"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"</script>
</body>
</html>