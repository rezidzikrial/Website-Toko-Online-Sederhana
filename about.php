<?php 

require 'koneksi.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>tentang kami</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php require 'navbar.php'; ?>

<div class="heading">
   <h3 class="text-center">tentang kami</h3>
   <p> <a href="home.php">home</a> / tentang kami </p>
</div>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/home-bg.jpg" alt="">
      </div>

      <div class="content">
         <h3>Kenapa harus pilih kami?</h3>
         <p>Tim kami terdiri dari para ahli yang berbakat dan berpengalaman dalam bidang mereka masing-masing. Dengan pengetahuan mendalam dan keahlian yang terus diperbarui, kami selalu siap untuk menghadapi tantangan baru dan memberikan hasil yang memukau.

         <p>Kami juga memahami bahwa setiap proyek memiliki keunikan dan kebutuhan khusus. Oleh karena itu, kami menempatkan kepuasan pelanggan sebagai prioritas utama kami. Kami senantiasa berusaha untuk mendengarkan dengan saksama dan bekerja sama dengan Anda untuk menghasilkan solusi visual yang sesuai dengan visi dan harapan Anda.

         Selain itu, kami selalu berupaya memanfaatkan teknologi terkini dan perangkat lunak terdepan untuk memastikan kualitas tinggi dan hasil yang memuaskan. Kami berinvestasi dalam peralatan dan sumber daya terbaik untuk memberikan hasil yang memikat..</p>
         </p>
         <a href="contact.php" class="btn">pesan/masukan</a>
      </div>

   </div>

</section>



<section class="authors">

   <h1 class="title">tim kami</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/author-1.jpg" alt="">
         <div class="share">
            <a href="https://www.instagram.com/rchmrove/" class="fab fa-instagram"></a>
            <a href="https://wa.me/6281218824083" class="fab fa-whatsapp"></a>
         
         </div>
         <h3>Putra</h3>
      </div>

      <div class="box">
         <img src="images/author-2.jpg" alt="">
         <div class="share">
            <a href="https://www.instagram.com//" class="fab fa-instagram"></a>
            <a href="https://wa.me/6282117894109" class="fab fa-whatsapp"></a>
         
         </div>
         <h3>Nia</h3>
      </div>

      <div class="box">
         <img src="images/author-3.jpg" alt="">
         <div class="share">
            <a href="https://www.instagram.com/sousagewd/" class="fab fa-instagram" target="_blank"></a>
            <a href="https://wa.me/6281218824083" class="fab fa-whatsapp" target="_blank"></a>
         
         </div>
         <h3>Zaldi</h3>
      </div>

      <div class="box">
         <img src="images/author-4.jpg" alt="">
         <div class="share">
            <a href="https://www.instagram.com//" class="fab fa-instagram"></a>
            <a href="https://wa.me/6281548283102" class="fab fa-whatsapp"></a>
         
         </div>
         <h3>Feranti</h3>
      </div>

      <div class="box">
         <img src="images/author-5.jpg" alt="">
         <div class="share">
            <a href="https://www.instagram.com/rezidzikri/" class="fab fa-instagram"></a>
            <a href="https://wa.me/6281211801713" class="fab fa-whatsapp"></a>
         
         </div>
         <h3>Rezi</h3>
      </div>

   </div>

</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script>"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"</script>
</body>
<?php require 'footer.php'; ?>
</html>