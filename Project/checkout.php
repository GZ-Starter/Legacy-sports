<?php

@include 'config.php';
session_start();
$uname = $_SESSION['name'];

if (isset($_POST['credit'])) {
   $cn = $_POST['holder'];
   $ch = $_POST['holder'];
   $card = $_POST['cnum'];
   $exp = $_POST['expir'];
   $cvc = $_POST['cvc'];
   // $balance=25000;
   // $insert="INSERT INTO tblBank(holder,cardnum,expr,cvc,balance) VALUES('$cn','$card','$exp','$cvc','$balance')";
   // $query = mysqli_query($conn, $insert);
   $chk = 1;
   $query = mysqli_query($conn, "SELECT * FROM tblBank WHERE holder = '$cn'");
   if (mysqli_num_rows($query) == 0) {
      $error[] = "Invalid Holder name";
      $chk++;
   }
   $query = mysqli_query($conn, "SELECT * FROM tblBank WHERE cardnum = '$card'");
   if (mysqli_num_rows($query) == 0) {
      $error[] = "Invalid credit card number";
      $chk++;
   }
   // $query = mysqli_query($conn, "SELECT * FROM tblBank WHERE holder = '$exp'");
   // if(mysqli_num_rows($query)==0){
   //    $error[]="Invalid Holder name";
   // }
   $query = mysqli_query($conn, "SELECT * FROM tblBank WHERE cvc = '$cvc'");
   if (mysqli_num_rows($query) == 0) {
      $error[] = "Invalid CVC";
      $chk++;
   }
   $query = mysqli_query($conn, "SELECT * FROM tblBank WHERE holder = '$cn'");
   $row = mysqli_fetch_array($query);
   $cart_query = mysqli_query($conn, "SELECT * FROM tblCart WHERE username='$uname'");
   $price_total = 0;
   if (mysqli_num_rows($cart_query) > 0) {
      while ($product_item = mysqli_fetch_assoc($cart_query)) {
         $id = $product_item['pid'];
         $query = mysqli_query($conn, "SELECT * FROM tblproduct WHERE pid=$id");
         $product = mysqli_fetch_assoc($query);
         $product_name[] = $product['pname'] . ' (' . $product_item['quantity'] . ') ';
         $product_price = $product['price'] * $product_item['quantity'];
         $price_total += $product_price;
      }
      ;
   }
   ;
   if ($row['balance'] < $price_total) {
      $error[] = "Insufficient fund";
      $chk++;
   } else {
      $clear = mysqli_query($conn, "UPDATE tblBank SET balance=balance-'$price_total' WHERE holder='$ch'") or die('query failed');
   }
   if ($chk == 1) {
      $cn = '';
   }
}

if (isset($_POST['order_btn'])) {

   $name = $_POST['name'];
   $number = $_POST['number'];
   $method = $_POST['method'];
   $flat = $_POST['flat'];
   $street = $_POST['street'];
   $city = $_POST['city'];
   $state = $_POST['state'];
   $pin_code = $_POST['pin_code'];
   $check = mysqli_query($conn, "SELECT MAX(order_id) from `tblDelivery`");
   $row = mysqli_fetch_array($check);
   if ($row[0] == '') {
      $oid = 1;
   } else {
      $oid = $row[0] + 1;
   }


   $cart_query = mysqli_query($conn, "SELECT * FROM tblCart WHERE username='$uname'");
   $price_total = 0;
   if (mysqli_num_rows($cart_query) > 0) {
      while ($product_item = mysqli_fetch_assoc($cart_query)) {
         $id = $product_item['pid'];
         $query = mysqli_query($conn, "SELECT * FROM tblproduct WHERE pid=$id");
         $product = mysqli_fetch_assoc($query);
         $product_name[] = $product['pname'] . ' (' . $product_item['quantity'] . ') ';
         $product_price = $product['price'] * $product_item['quantity'];
         $price_total += $product_price;
      }
      ;
   }
   ;

   $total_product = implode(',', $product_name);
   $detail_query = mysqli_query($conn, "INSERT INTO `tblDelivery`(order_id,name,username, phone, flat, street, city, pincode,state,method) VALUES('$oid','$name','$uname','$number','$flat','$street','$city','$pin_code','$state','$method')") or die('query failed');
   $select_products = mysqli_query($conn, "SELECT * FROM tblCart WHERE username='$uname' ");

   if (mysqli_num_rows($select_products) > 0) {
      while ($row = mysqli_fetch_assoc($select_products)) {
         $idp = $row['pid'];
         $un = $row['username'];
         $qty = $row['quantity'];
         $insert = mysqli_query($conn, "INSERT INTO `tblOrder`(order_id,pid,username,quantity,status) VALUES('$oid','$idp','$un','$qty','BOOKED')") or die('query failed');
      }
   }
   // if($method=="credit card"){
   //    $clear = mysqli_query($conn, "UPDATE tblBank SET balance=balance-'$price_total' WHERE holder='$ch'") or die('query failed');
   // }
   $clear = mysqli_query($conn, "DELETE FROM tblCart WHERE username='$uname'") or die('query failed');

   if ($cart_query && $detail_query) {
      echo "
      <div class='order-message-container'>
      <div class='message-container'>
         <h3>Thank you for shopping!</h3>
         <div class='order-detail'>
            <span>" . $total_product . "</span>
            <span class='total'> total : ₹" . $price_total . "/-  </span>
         </div>
         <div class='customer-details'>
            <p>&nbsp;&nbsp;&nbsp; your name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span>" . $name . "</span> </p>
            <p>&nbsp;&nbsp;&nbsp; your number&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span>" . $number . "</span> </p>
            <p>&nbsp;&nbsp;&nbsp; your address&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span>" . $flat . ", " . $street . ", " . $city . ", " . $state . " - " . $pin_code . "</span> </p>
            <p>&nbsp;&nbsp;&nbsp; your payment mode : <span>" . $method . "</span> </p>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(*pay when product arrives*)</p>
         </div>
            <a href='home1.php' class='btn'>continue shopping</a>
         </div>
      </div>
      ";
   }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css">

</head>

<body>
   <header class="header">

      <div class="flex">

         <p class="logo"><span>LEGACY</span>Sports
         <p>

         <nav class="navbar">

            <!-- <div id="menu-btn" class="fas fa-bars"></div> -->

      </div>

   </header>

   <div class="container">

      <section class="checkout-form">

         <h1 class="heading">complete your order</h1>
         <?php
         $edit_query = mysqli_query($conn, "SELECT * FROM tblDelivery WHERE username= '$uname'");
         if (mysqli_num_rows($edit_query) >= 0) {
            $fetch_edit = mysqli_fetch_assoc($edit_query)
               ?>
            <form action="" method="post">

               <div class="display-order">
                  <?php
                  $select_cart = mysqli_query($conn, "SELECT * FROM tblCart WHERE username='$uname'");
                  $total = 0;
                  $grand_total = 0;
                  if (mysqli_num_rows($select_cart) > 0) {

                     while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                        $id = $fetch_cart['pid'];

                        $query = mysqli_query($conn, "SELECT * FROM tblProduct WHERE pid='$id'");
                        $product = mysqli_fetch_assoc($query);
                        $total_price = $product['price'] * $fetch_cart['quantity'];
                        $grand_total = $total += $total_price;
                        ?>
                        <span>
                           <?= $product['pname']; ?>(
                           <?= $fetch_cart['quantity']; ?>)
                        </span>
                        <?php
                     }
                  } else {
                     echo "<div class='display-order'><span>your cart is empty!</span></div>";
                  }
                  ?> -
                  <p class="grand-total"> grand total : ₹
                     <?= $grand_total; ?>/-
                  </p>
                  <a href='home1.php' class='btn'>continue shopping</a>
               </div>

               <div class="flex">
                  <div class="inputBox">
                     <span>your name</span>
                     <input type="text" placeholder="enter your name" name="name" pattern="[A-Za-z ]+" maxlength="30"
                        oninvalid="this.setCustomValidity('Enter only text input')" onchange="this.setCustomValidity('')"
                        value="<?php echo @$fetch_edit['name']; ?>" required>
                  </div>
                  <div class="inputBox">
                     <span>your number</span>
                     <input type="tel" placeholder="enter your number  (xxxxxxxxxx)" pattern="[0-9]{10}" name="number"
                        maxlength="10" value="<?php echo @$fetch_edit['phone']; ?>" required>
                  </div>
                  <!-- <div class="inputBox">
                     <span>your email</span>
                     <input type="email" placeholder="enter your email" name="email" required>
                  </div> -->
                  <div class="inputBox">
                     <span>payment method</span>
                     <select name="method" id="mtd">
                        <option value="cash on delivery">cash on delivery</option>
                        <option value="credit card" <?php if (@$chk == 1) {
                           echo 'selected';
                        } ?>>Credit card</option>
                        <!-- <option value="paypal">paypal</option> -->
                     </select>
                  </div>
                  <div class="inputBox">
                     <span>address line 1</span>
                     <input type="text" placeholder="e.g. flat/home no." name="flat"
                        value="<?php echo @$fetch_edit['flat']; ?>" required>
                  </div>
                  <div class="inputBox">
                     <span>address line 2</span>
                     <input type="text" placeholder="e.g. street name" name="street"
                        value="<?php echo @$fetch_edit['street']; ?>" required>
                  </div>
                  <div class="inputBox">
                     <span>city</span>
                     <input type="text" placeholder="e.g. udupi" name="city" pattern="[A-Za-z ]+"
                        oninvalid="this.setCustomValidity('Enter only text input')" onchange="this.setCustomValidity('')"
                        value="<?php echo @$fetch_edit['city']; ?>" required>
                  </div>
                  <div class="inputBox">
                     <span>state</span>
                     <!-- <input type="text" placeholder="e.g. karnataka" name="state" pattern="[A-Za-z ]+" oninvalid="this.setCustomValidity('Enter only text input')" onchange="this.setCustomValidity('')" value="<?php echo @$fetch_edit['state']; ?>" required> -->
                     <select id="country-state" name="state">
                        <option value="<?php echo @$fetch_edit['state']; ?>"><?php echo @$fetch_edit['state']; ?></option>
                        <!-- <option value="AN">Andaman and Nicobar Islands</option> -->
                        <option value="Andhra Pradesh">Andhra Pradesh</option>
                        <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                        <option value="Assam">Assam</option>
                        <option value="Bihar">Bihar</option>
                        <option value="Chandigarh">Chandigarh</option>
                        <option value="Chhattisgarh">Chhattisgarh</option>
                        <option value="Delhi">Delhi</option>
                        <option value="Goa">Goa</option>
                        <option value="Gujarat">Gujarat</option>
                        <option value="Haryana">Haryana</option>
                        <option value="Himachal Pradesh">Himachal Pradesh</option>
                        <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                        <option value="Jharkhand">Jharkhand</option>
                        <option value="Karnataka">Karnataka</option>
                        <option value="Kerala">Kerala</option>
                        <option value="Ladakh">Ladakh</option>
                        <option value="Maharashtra">Maharashtra</option>
                        <option value="Manipur">Manipur</option>
                        <option value="Meghalaya">Meghalaya</option>
                        <option value="Mizoram">Mizoram</option>
                        <option value="NL">Nagaland</option>
                        <option value="Nagaland">Odisha</option>
                        <option value="Puducherry">Puducherry</option>
                        <option value="Punjab">Punjab</option>
                        <option value="Rajasthan">Rajasthan</option>
                        <option value="Sikkim">Sikkim</option>
                        <option value="Tamil Nadu">Tamil Nadu</option>
                        <option value="Telangana">Telangana</option>
                        <option value="Uttar Pradesh">Uttar Pradesh</option>
                        <option value="Uttarakhand">Uttarakhand</option>
                        <option value="West Bengal">West Bengal</option>
                     </select>
                  </div>
                  <div class="inputBox">
                     <span>pin code</span>
                     <input type="tel" placeholder="e.g. 123456" name="pin_code" pattern="[0-9]{6}"
                        value="<?php echo @$fetch_edit['pincode']; ?>" required>
                  </div>
               </div>
               <input type="submit" value="order now" name="order_btn" class="btn">
            </form>
            <?php
         }
         ;
         ?>
      </section>
      <section class="edit-form-container">

         <form action="" method="post">
            <h1>
               <?php
               if (isset($error)) {
                  foreach ($error as $error) {
                     echo '<span class="error-msg">' . $error . '</span>';
                  }
               }
               ;
               ?>
            </h1>
            <table style="text-align:left">
               <tr>
                  <td> <label class="lbl">Card holder:</label></td>
                  <td> <input type="text" class="box" name="holder" placeholder="Coding Market" required></td>

               </tr>
               <tr>
                  <td>
                     <label class="lbl">Card number:</label>
                  </td>
                  <td><input type="text" class="box" name="cnum" data-mask="0000 0000 0000 0000"
                        placeholder="Card Number" required>
                  </td>
               </tr>
               <tr>
                  <td><label class="lbl">Expiry date:</label><input type="text" style="width:90px" class="box"
                        data-mask="00 / 00" name="expir" placeholder="00 / 00" required>
                  </td>
                  <td style="float:right"><label class="lbl">CVC:</label>&nbsp;&nbsp;&nbsp;<input type="text"
                        class="box" style="width:70px" data-mask="000" name="cvc" placeholder="000" required>

                  </td>
               </tr>
            </table>
            <input type="submit" class="btn" name="credit" value="Pay">
            <a href="checkout.php" id="close-edit" class="option-btn">Cancel</a>
         </form>
         <?php
         if ($cn != '') {
            echo "<script>document.querySelector('.edit-form-container').style.display = 'flex';</script>";
         } else {
            echo "<script>document.querySelector('.edit-form-container').style.display = 'none';</script>";

         }
         ?>
      </section>
   </div>

   <!-- custom js file link  -->
   <script src="js/payment.js"></script>
   <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
</body>

</html>