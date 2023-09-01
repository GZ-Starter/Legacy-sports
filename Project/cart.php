<?php

@include 'config.php';
session_start();
$name = $_SESSION['name'];
if (isset($_POST['update_update_btn'])) {
   $update_value = $_POST['update_quantity'];
   $update_id = $_POST['update_quantity_id'];

   $select = mysqli_query($conn, "SELECT * FROM `tblProduct` WHERE pid = '$update_id'");
   $row = mysqli_fetch_array($select);

   if ($row['quantity'] >= $update_value) {
      $select_cart = mysqli_query($conn, "SELECT * FROM `tblCart` WHERE username='$name'");
      $cart = mysqli_fetch_array($select_cart);
      if ($cart['quantity'] < $update_value) {
         $product = mysqli_query($conn, "UPDATE tblProduct SET quantity=quantity-$update_value WHERE pid = '$update_id'");
      } else {
         $qty=$cart['quantity'] - $update_value;
         $product = mysqli_query($conn, "UPDATE tblProduct SET quantity=quantity+$qty WHERE pid = '$update_id'");
      }
      $update_quantity_query = mysqli_query($conn, "UPDATE `tblCart` SET quantity = '$update_value' WHERE pid = '$update_id' AND username='$name'");
      if ($update_quantity_query) {
         header('location:cart.php');
      }
      ;
   } else {
      $message[] = 'Out of stock!';
   }
}
;

if (isset($_GET['remove'])) {
   $remove_id = $_GET['remove'];
   $select_cart = mysqli_query($conn, "SELECT * FROM `tblCart` WHERE pid = '$remove_id' AND username='$name'");
   $cart = mysqli_fetch_array($select_cart);
   $qty=$cart['quantity'];
   mysqli_query($conn, "UPDATE tblProduct SET quantity=quantity+$qty WHERE pid = '$remove_id'");

   mysqli_query($conn, "DELETE FROM `tblCart` WHERE pid = '$remove_id' AND username='$name'");

   header('location:cart.php');
}
;

if (isset($_GET['delete_all'])) {
   $edit_query=mysqli_query($conn, "SELECT * FROM `tblCart` WHERE username='$name'");
   if (mysqli_num_rows($edit_query) > 0) {
      while ($fetch_edit = mysqli_fetch_assoc($edit_query)) {
         $id=$fetch_edit['pid'];
         $qty=$fetch_edit['quantity'];
         $product = mysqli_query($conn, "UPDATE tblProduct SET quantity=quantity+$qty WHERE pid = '$id'");

         mysqli_query($conn, "DELETE FROM `tblCart` WHERE username='$name'");
      }
   }
   header('location:cart.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shopping cart</title>

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
   <header class="header">

      <div class="flex">

         <p class="logo"><span>LEGACY</span>Sports
         <p>

         <nav class="navbar">

            <!-- <div id="menu-btn" class="fas fa-bars"></div> -->

      </div>

   </header>

   <div class="container">

      <section class="shopping-cart">

         <h1 class="heading">shopping cart</h1>

         <table>

            <thead>
               <th>image</th>
               <th>name</th>
               <th>price</th>
               <th>quantity</th>
               <th>total price</th>
               <th>action</th>
            </thead>

            <tbody>

               <?php

               $select_cart = mysqli_query($conn, "SELECT * FROM `tblCart` WHERE username='$name'");
               $grand_total = 0;
               if (mysqli_num_rows($select_cart) > 0) {
                  // $row = mysqli_fetch_array($select_cart);
                  // foreach($row as $pd){
                  // $id=$pd;
                  // $select_cart = mysqli_query($conn, "SELECT * FROM `tblProduct` WHERE pid='$id'");
                  while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {

                     $id = $fetch_cart['pid'];
                     $select = mysqli_query($conn, "SELECT * FROM `tblProduct` WHERE pid=$id");
                     $fetch_qty = mysqli_fetch_array($select);
                     ?>
                     <tr>
                        <td><img src="img/<?php echo $fetch_qty['image']; ?>" height="100" alt=""></td>
                        <td>
                           <?php echo $fetch_qty['pname']; ?>
                        </td>
                        <td>₹
                           <?php echo number_format($fetch_qty['price']); ?>/-
                        </td>
                        <td>
                           <form action="" method="post">
                              <input type="hidden" name="update_quantity_id" value="<?php echo $fetch_cart['pid']; ?>">
                              <?php 
                                 $select = mysqli_query($conn, "SELECT * FROM `tblProduct` WHERE pid = '$id'");
                                 $row = mysqli_fetch_array($select);
                              ?>
                              <input type="number" name="update_quantity" min="1" max="<?php echo $row['quantity']; ?>" value="<?php echo $fetch_cart['quantity']; ?>">
                              <input type="submit" value="update" name="update_update_btn">
                           </form>
                        </td>
                        <td>₹
                           <?php echo $sub_total = $fetch_qty['price'] * $fetch_cart['quantity']; ?>/-
                        </td>
                        <td><a href="cart.php?remove=<?php echo $fetch_cart['pid']; ?>"
                              onclick="return confirm('remove item from cart?')" class="delete-btn"> <i
                                 class="fas fa-trash"></i> remove</a></td>
                     </tr>
                     <?php
                     $grand_total += (float) $sub_total;
                  }
                  ;
               }
               ;
               ?>
               <tr class="table-bottom">
                  <td><a href="home1.php" class="option-btn" style="margin-top: 0;">continue shopping</a></td>
                  <td colspan="3">grand total</td>
                  <td>₹
                     <?php echo $grand_total; ?>/-
                  </td>
                  <td>
                     <?php
                     $select_cart = mysqli_query($conn, "SELECT * FROM `tblCart` WHERE username='$name'");
                     if (mysqli_num_rows($select_cart) > 0) {
                        ?>
                        <a href="cart.php?delete_all" onclick="return confirm('are you sure you want to delete all?');"
                           class="delete-btn"> <i class="fas fa-trash"></i> delete all </a>
                     <?php
                     }
                     ?>
                  </td>
               </tr>

            </tbody>

         </table>

         <div class="checkout-btn">
            <a href="checkout.php" class="btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>">procced to checkout</a>
         </div>

      </section>

   </div>

   <!-- custom js file link  -->
   <script src="js/script.js"></script>

</body>

</html>