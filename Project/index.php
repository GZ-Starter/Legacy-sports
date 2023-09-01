<?php

@include 'config.php';

if(isset($_POST['add_to_cart'])){
      $message[] = 'Sign-in/Sign Up to continue shopping';


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css">
</head>
<body>
   
<?php

if(isset($message)){
   foreach($message as $message){
      echo '<div class="message"><span>'.$message.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
      
   };
};

?>

<header class="header">

  <div class="flex">

  <p class="logo"><span>LEGACY</span>Sports</p>

     <nav class="navbar">
     
     <?php  
     $select_rows = mysqli_query($conn, "SELECT * FROM `tblProduct`") or die('query failed');
     $row_count = mysqli_num_rows($select_rows);
     ?>

     <a href="login.php" class="login">Sign-in </a>
</nav>
  </div>
</header>

<div class="container-p">
<section class="products">
   <h1 class="heading">
   <div id="captioned-gallery">
	<figure class="slider">
		<figure>
         <a href="#volleyball">
			<img src="img/volleyball_slide.jpeg" alt>
         </a>
			<!-- <figcaption>Item 1</figcaption> -->
		</figure>
		<figure>
      <a href="#cricket">
                        <img src="img/cricket-slid.jpeg" alt>
                     </a>
                     <!-- <figcaption>Item 2</figcaption> -->
                  </figure>
                  <figure>
                     <a href="#football">
                        <img src="img/football-slid.jpeg" alt>
                     </a>
			<!-- <figcaption>Item 3</figcaption> -->
		</figure>
      
	</figure>
   </div>
   </h1>
   
   <br>
   <br>
   <br>
   <div class="section">
   <?php
      $select_products = mysqli_query($conn, "SELECT * FROM `tblProduct` WHERE category='Cricket'");
      if(mysqli_num_rows($select_products) > 0){
         echo '<h1 class="sub-head" id="cricket">Cricket</h1>';
   ?>
   <div class="box-container">
      <?php
         while($fetch_product = mysqli_fetch_assoc($select_products)){
      ?>
      
      <form action="" method="post">
         <div class="box">
            <img src="img/<?php echo $fetch_product['image']; ?>" alt="">
            <h3><?php echo $fetch_product['pname']; ?></h3>
            <div class="price">₹<?php echo $fetch_product['price']; ?>/-</div>
            <input type="hidden" name="product_id" value="<?php echo $fetch_product['pid']; ?>">
            <input type="hidden" name="product_name" value="<?php echo $fetch_product['pname']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
            <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
            <input type="submit" class="btn" value="add to cart" name="add_to_cart">
         </div>
      </form>

      <?php
         };
      };
      ?>

   </div>
   </div>
   <br>
   <br>
   <br>

   <div class="section">
   <?php
      $select_products = mysqli_query($conn, "SELECT * FROM `tblProduct` WHERE category='Football'");
      if(mysqli_num_rows($select_products) > 0){
         echo '<h1 class="sub-head" id="football">Football</h1>';
      }
   ?>
   <div class="box-container">
      <?php
      
      $select_products = mysqli_query($conn, "SELECT * FROM `tblProduct` WHERE category='Football'");
      if(mysqli_num_rows($select_products) > 0){
         while($fetch_product = mysqli_fetch_assoc($select_products)){
      ?>
      
      <form action="" method="post">
         <div class="box">
            <img src="img/<?php echo $fetch_product['image']; ?>" alt="">
            <h3><?php echo $fetch_product['pname']; ?></h3>
            <div class="price">₹<?php echo $fetch_product['price']; ?>/-</div>
            <input type="hidden" name="product_id" value="<?php echo $fetch_product['pid']; ?>">
            <input type="hidden" name="product_name" value="<?php echo $fetch_product['pname']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
            <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
            <input type="submit" class="btn" value="add to cart" name="add_to_cart">
         </div>
      </form>

      <?php
         };
      };
      ?>

   </div>
   </div>
   <br>
   <br>
   <br>

   <div class="section">
      <?php
      $select_products = mysqli_query($conn, "SELECT * FROM `tblProduct` WHERE category='Volleyball'");
      if(mysqli_num_rows($select_products) > 0){
         echo '<h1 class="sub-head" id="volleyball">Volleyball</h1>';
      }
      ?>
   <div class="box-container">
      <?php
      
      $select_products = mysqli_query($conn, "SELECT * FROM `tblProduct` WHERE category='Volleyball'");
      if(mysqli_num_rows($select_products) > 0){
         while($fetch_product = mysqli_fetch_assoc($select_products)){
      ?>
      
      <form action="" method="post">
         <div class="box">
            <img src="img/<?php echo $fetch_product['image']; ?>" alt="">
            <h3><?php echo $fetch_product['pname']; ?></h3>
            <div class="price">₹<?php echo $fetch_product['price']; ?>/-</div>
            <input type="hidden" name="product_id" value="<?php echo $fetch_product['pid']; ?>">
            <input type="hidden" name="product_name" value="<?php echo $fetch_product['pname']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
            <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
            <input type="submit" class="btn" value="add to cart" name="add_to_cart">
         </div>
      </form>

      <?php
         };
      };
      ?>

   </div>
   </div>

   <br>
   <br>
   <br>
   <div class="section">
   <?php
      $select_products = mysqli_query($conn, "SELECT * FROM `tblProduct` WHERE category='Accesories'");
      if(mysqli_num_rows($select_products) > 0){
         echo '<h1 class="sub-head" id="accessories">Accesories </h1>';
      }
   ?>
   <div class="box-container">
      <?php
      
      $select_products = mysqli_query($conn, "SELECT * FROM `tblProduct` WHERE category='Accesories'");
      if(mysqli_num_rows($select_products) > 0){
         while($fetch_product = mysqli_fetch_assoc($select_products)){
      ?>
      
      <form action="" method="post">
         <div class="box">
            <img src="img/<?php echo $fetch_product['image']; ?>" alt="">
            <h3><?php echo $fetch_product['pname']; ?></h3>
            <div class="price">₹<?php echo $fetch_product['price']; ?>/-</div>
            <input type="hidden" name="product_id" value="<?php echo $fetch_product['pid']; ?>">
            <input type="hidden" name="product_name" value="<?php echo $fetch_product['pname']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
            <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
            <input type="submit" class="btn" value="add to cart" name="add_to_cart">
         </div>
      </form>

      <?php
         };
      };
      ?>

   </div>
   </div>



</section>

</div>
<footer class="feedback" id="feedback">
   <form action="" method="post"></form>
</footer>
<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>