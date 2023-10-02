<nav class="navbar navbar-expand-lg navbar-dark warna1 d-flex align-items-center">

  <div class="container text-center">
    <a class="navbar-brand" href="index.php">Home</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item me-2">
          <a class="nav-link" href="about.php">Tentang Kami</a>
        </li>
        <li class="nav-item me-2">
          <a class="nav-link" href="produk.php">Produk</a>
        </li>
        </li>
        <li class="nav-item me-2">
          <a class="nav-link" href="order.php">Orderan</a>
        </li>
    <?php 
        $select_cart_number = mysqli_query($conn, "SELECT * FROM keranjang WHERE user_id = '$user_id'") or die('query failed');
        $cart_rows_number = mysqli_num_rows($select_cart_number);
    ?>
        <li class="nav-item me-2">
          <a href="keranjang.php"> <i class=" fas fa-shopping-cart nav-link"></i><span>(<?php echo $cart_rows_number; ?>)</span></a>
        </li>
      </ul>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item me-2">
          <a class="nav-link text-right" href="../adminpanel/logout.php">Logout</a>
        </li>
      </ul>
      </div>
    </div>
  </div>

        <div>
        
        </div>
  
</nav>