<?php

@include 'config.php';
// session_start();

if (isset($_POST['add_to_cart'])) {
   $pid = $_POST['product_id'];
   // $product_name = $_POST['product_name'];
   // $product_price = $_POST['product_price'];
   // $product_image = $_POST['product_image'];
   $product_quantity = 1;
   session_start();
   $name = $_SESSION['name'];
   $select = mysqli_query($conn, "SELECT * FROM `tblProduct` WHERE pid = '$pid'");
   $row=mysqli_fetch_array($select);

   if($row['quantity']>0){
   $select_cart = mysqli_query($conn, "SELECT * FROM `tblCart` WHERE pid = '$pid' and username='$name'");

   if (mysqli_num_rows($select_cart) > 0) {
      $insert_product = mysqli_query($conn, "UPDATE tblCart SET quantity=quantity+1 WHERE pid = '$pid' and username='$name'");
      mysqli_query($conn, "UPDATE tblProduct SET quantity=quantity-1 WHERE pid = '$pid'");
   } else {
      $insert_product = mysqli_query($conn, "INSERT INTO tblCart(pid, username, quantity) VALUES('$pid', '$name', '$product_quantity')");
      mysqli_query($conn, "UPDATE tblProduct SET quantity=quantity-1 WHERE pid = '$pid'");

      $message[] = 'product added to cart succesfully';
   }
}else{
   $message[] = 'Out of stock!';
}
}

if (isset($_POST['update'])) {
   $uname = $_POST['uname'];
   $pass = $_POST['pass'];
   $cpass = $_POST['cpass'];
   if ($pass != $cpass) {
      $error = 'password not matched!';
   } else {
      $update_query = mysqli_query($conn, "UPDATE `tblLogin` SET password = '$pass' WHERE username = '$uname'");

      if ($update_query) {
         $message[] = 'password updated succesfully';
         header('location:home1.php');
      } else {
         $message[] = 'failed to update password';
         header('location:home1.php');
      }
   }
}
if (isset($_POST['details'])) {
   $username = $_POST['ouname'];
   $uname = $_POST['uname'];
   $name = $_POST['name'];
   $addr = $_POST['addr'];
   $email = $_POST['email'];
   $update_query = mysqli_query($conn, "UPDATE `tblRegister` SET name = '$name', address = '$addr',email = '$email' WHERE username = '$username'");

   if ($update_query) {
      $message[] = 'password updated succesfully';
      header('location:home1.php');
   } else {
      $message[] = 'failed to update password';
      header('location:home1.php');
   }
}


if (isset($_POST['feedback'])) {
   session_start();
   $name = $_SESSION['name'];
   if($_POST['msg']!=''){
   $msg = $_POST['msg'];
   $feedback = mysqli_query($conn, $insert = "INSERT into tblFeedback(username,comment) values('$name','$msg')");
   }
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

   if (isset($message)) {
      foreach (@$message as $message) {
         echo '<div class="message"><span>' . $message . '</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';

      }
      ;
   }
   ;

   ?>

   <?php include 'header.php'; ?>

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
            $select_products = mysqli_query($conn, "SELECT * FROM `tblProduct` WHERE category='Cricket' AND status!='inactive'");
            if (mysqli_num_rows($select_products) > 0) {
               echo '<h1 class="sub-head" id="cricket">Cricket</h1>';
            }
            ?>
            <div class="box-container">
               <?php

               $select_products = mysqli_query($conn, "SELECT * FROM `tblProduct` WHERE category='Cricket' AND status!='inactive'");
               if (mysqli_num_rows($select_products) > 0) {
                  while ($fetch_product = mysqli_fetch_assoc($select_products)) {
                     ?>

                     <form action="" method="post">
                        <div class="box">
                           <img src="img/<?php echo $fetch_product['image']; ?>" alt="">
                           <h3>
                              <?php echo $fetch_product['pname']; ?>
                           </h3>
                           <div class="price">₹
                              <?php echo $fetch_product['price']; ?>/-
                           </div>
                           <div class="price"><small>In stock:</small>
                              <?php echo $fetch_product['quantity']; ?>
                           </div>
                           <input type="hidden" name="product_id" value="<?php echo $fetch_product['pid']; ?>">
                           <input type="hidden" name="product_name" value="<?php echo $fetch_product['pname']; ?>">
                           <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                           <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                           <input type="submit" class="btn" value="add to cart" name="add_to_cart">
                        </div>
                     </form>

                     <?php
                  }
                  ;
               }
               ;
               ?>

            </div>
         </div>
         <br>
         <br>
         <br>

         <div class="section">
            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `tblProduct` WHERE category='Football' AND status!='inactive'");
            if (mysqli_num_rows($select_products) > 0) {
               echo '<h1 class="sub-head" id="football">Football</h1>';
            }
            ?>
            <div class="box-container">
               <?php

               $select_products = mysqli_query($conn, "SELECT * FROM `tblProduct` WHERE category='Football' AND status!='inactive'");
               if (mysqli_num_rows($select_products) > 0) {
                  while ($fetch_product = mysqli_fetch_assoc($select_products)) {
                     ?>

                     <form action="" method="post">
                        <div class="box">
                           <img src="img/<?php echo $fetch_product['image']; ?>" alt="">
                           <h3>
                              <?php echo $fetch_product['pname']; ?>
                           </h3>
                           <div class="price">₹
                              <?php echo $fetch_product['price']; ?>/-
                           </div>
                           <div class="price"><small>In stock:</small>
                              <?php echo $fetch_product['quantity']; ?>
                           </div>
                           <input type="hidden" name="product_id" value="<?php echo $fetch_product['pid']; ?>">
                           <input type="hidden" name="product_name" value="<?php echo $fetch_product['pname']; ?>">
                           <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                           <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                           <input type="submit" class="btn" value="add to cart" name="add_to_cart">
                        </div>
                     </form>

                     <?php
                  }
                  ;
               }
               ;
               ?>

            </div>
         </div>
         <br>
         <br>
         <br>

         <div class="section">
            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `tblProduct` WHERE category='Volleyball' AND status!='inactive'");
            if (mysqli_num_rows($select_products) > 0) {
               echo '<h1 class="sub-head" id="volleyball">Volleyball</h1>';
            }
            ?>
            <div class="box-container">
               <?php

               $select_products = mysqli_query($conn, "SELECT * FROM `tblProduct` WHERE category='Volleyball' AND status!='inactive'");
               if (mysqli_num_rows($select_products) > 0) {
                  while ($fetch_product = mysqli_fetch_assoc($select_products)) {
                     ?>

                     <form action="" method="post">
                        <div class="box">
                           <img src="img/<?php echo $fetch_product['image']; ?>" alt="">
                           <h3>
                              <?php echo $fetch_product['pname']; ?>
                           </h3>
                           <div class="price">₹
                              <?php echo $fetch_product['price']; ?>/-
                           </div>
                           <div class="price"><small>In stock:</small>
                              <?php echo $fetch_product['quantity']; ?>
                           </div>
                           <input type="hidden" name="product_id" value="<?php echo $fetch_product['pid']; ?>">
                           <input type="hidden" name="product_name" value="<?php echo $fetch_product['pname']; ?>">
                           <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                           <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                           <input type="submit" class="btn" value="add to cart" name="add_to_cart">
                        </div>
                     </form>

                     <?php
                  }
                  ;
               }
               ;
               ?>

            </div>
         </div>

         <br>
         <br>
         <br>
         <div class="section">
            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `tblProduct` WHERE category='Accesories' AND status!='inactive'");
            if (mysqli_num_rows($select_products) > 0) {
               echo '<h1 class="sub-head" id="accessories">Accesories </h1>';
            }
            ?>
            <div class="box-container">
               <?php

               $select_products = mysqli_query($conn, "SELECT * FROM `tblProduct` WHERE category='Accesories' AND status!='inactive'");
               if (mysqli_num_rows($select_products) > 0) {
                  while ($fetch_product = mysqli_fetch_assoc($select_products)) {
                     ?>

                     <form action="" method="post">
                        <div class="box">
                           <img src="img/<?php echo $fetch_product['image']; ?>" alt="">
                           <h3>
                              <?php echo $fetch_product['pname']; ?>
                           </h3>
                           <div class="price">₹
                              <?php echo $fetch_product['price']; ?>/-
                           </div>
                           <div class="price"><small>In stock:</small>
                              <?php echo $fetch_product['quantity']; ?>
                           </div>
                           <input type="hidden" name="product_id" value="<?php echo $fetch_product['pid']; ?>">
                           <input type="hidden" name="product_name" value="<?php echo $fetch_product['pname']; ?>">
                           <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                           <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                           <input type="submit" class="btn" value="add to cart" name="add_to_cart">
                        </div>
                     </form>

                     <?php
                  }
                  ;
               }
               ;
               ?>

            </div>
         </div>
      </section>
      <section class="change-password" id="change-details">
         <?php

         if (isset($_GET['change'])) {
            $edit_id = $_GET['change'];
            $edit_query = mysqli_query($conn, "SELECT * FROM tblLogin WHERE username= '$edit_id'");
            if (mysqli_num_rows($edit_query) > 0) {
               while ($fetch_edit = mysqli_fetch_assoc($edit_query)) {
                  ?>

                  <form action="" method="post" enctype="multipart/form-data">

                     <input type="hidden" name="uname" value="<?php echo $fetch_edit['username']; ?>">
                     <?php
                     if (isset($error)) {
                        echo '<span class="error-msg">' . $error . '</span>';
                     }
                     ;
                     ?>
                     <label for="pwd">Enter new password:</label>
                     <input type="text" class="box" id="pwd"  maxlength="10" required name="pass" value="<?php echo $fetch_edit['password']; ?>">
                     <br>
                     <label for="cpwd">Confirm Password:&nbsp;&nbsp;&nbsp;</label>
                     <input type="text" class="box" id="cpwd"  maxlength="10" required name="cpass">
                     <input type="submit" value="change password" name="update" class="btn">
                     <!-- <input type="reset" value="cancel" id="close-edit" class="option-btn"> -->
                     <a href="home1.php" id="close-edit" class="option-btn">Cancel</a>
                  </form>

                  <?php
               }
               ;
            }
            ;
            echo "<script>document.querySelector('.change-password').style.display = 'flex';</script>";
         }
         ;
         ?>
      </section>
      <section class="edit-details" id="change-details">
         <?php

         if (isset($_GET['cdetails'])) {
            $edit_id = $_GET['cdetails'];
            $edit_query = mysqli_query($conn, "SELECT * FROM tblRegister WHERE username= '$edit_id'");
            if (mysqli_num_rows($edit_query) > 0) {
               while ($fetch_edit = mysqli_fetch_assoc($edit_query)) {
                  ?>

                  <form action="" method="post" enctype="multipart/form-data">

                     <input type="hidden" name="ouname" value="<?php echo $fetch_edit['username']; ?>">
                     <?php
                     if (isset($error)) {
                        echo '<span class="error-msg">' . $error . '</span>';
                     }
                     ;
                     ?>
                     
                     <label for="addr">Enter new Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;</label>
                     <input type="text" class="box" id="name" required name="name" maxlength="25" value="<?php echo $fetch_edit['name']; ?>">
                     <label for="addr">Enter new Address&nbsp;&nbsp;&nbsp;:&nbsp;</label>
                     <input type="text" class="box" id="addr" required name="addr" maxlength="50" value="<?php echo $fetch_edit['address']; ?>">

                     <label for="email">Enter new Email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;</label>
                     <input type="email" class="box" id="email" maxlength="25" required name="email" value="<?php echo $fetch_edit['email']; ?>">
                     <input type="submit" value="Save" name="details" class="btn">
                     <!-- <input type="reset" value="cancel" id="close-edit" class="option-btn"> -->
                     <a href="home1.php" id="close-edit" class="option-btn">Cancel</a>
                  </form>

                  <?php
               }
               ;
            }
            ;
            echo "<script>document.querySelector('.edit-details').style.display = 'flex';</script>";
         }
         ;
         ?>
      </section>

   </div>
   <footer id="feedback" class="footer">
      <form action="" method="post">
         <div class="feedback">
            <textarea name="msg" id="" cols="30" required rows="10" placeholder="feedback"></textarea>
            <input type="submit" value="Submit" name="feedback">
         </div>

      </form>
 
      <div class="box" style="background:black;">
        <h3>contact info</h3><a href=""></a><a href=""></a><a href=""></a>
        <a href="#"> <i class="fas fa-phone"></i> 6360027450</a>
        <a href="#"> <i class="fas fa-phone"></i> 9785453546 </a>
        <a href="#"> <i class="fas fa-envelope"></i>admin@gmail.com </a>
        <a href="#"> <i class="fas fa-map"></i> Udupi, Karnataka - 050 </a>
      </div>
   </footer>
   <!-- custom js file link  -->
   <script src="js/script.js"></script>

</body>

</html>