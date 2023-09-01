<?php

@include 'config.php';

session_start();
if (isset($_POST['add_product'])) {
   $check = mysqli_query($conn, "SELECT MAX(pid) from `tblProduct`");
   $row = mysqli_fetch_array($check);

   if ($row[0] == '') {
      $pid = 1000;
   } else {
      $pid = $row[0] + 1;
   }


   $p_name = $_POST['pname'];
   $p_price = $_POST['price'];
   $qty = $_POST['qty'];
   // $p_image = $_FILES['p_image']['name'];
   $p_image = $_POST['p_image'];
   //$p_image_tmp_name = $_FILES['p_image']['tmp_name'];
   // $p_image_folder = 'img/' . $p_image;
   $category = $_POST['category'];
   $status = 'active';
   $insert = mysqli_query($conn, "INSERT INTO `tblProduct`(pid, pname, price, quantity, image, category, status) VALUES('$pid', '$p_name', '$p_price', '$qty', '$p_image', '$category', '$status')") or die('query failed');

   if ($insert) {
      // move_uploaded_file($p_image_tmp_name, $p_image_folder);
      $message[] = 'product added succesfully';
   } else {
      $message[] = 'could not add the product';
   }
}
;

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   $delete_query = mysqli_query($conn, "UPDATE `tblProduct` set status='inactive' WHERE pid = $delete_id ") or die('query failed');
   if ($delete_query) {
      header('location:admin.php');
      $message[] = 'product has been deleted';
   } else {
      header('location:admin.php');
      $message[] = 'product could not be deleted';
   }
   ;
}
;

if (isset($_POST['update_product'])) {
   $update_p_id = $_POST['update_p_id'];
   $update_p_name = $_POST['update_p_name'];
   $update_p_price = $_POST['update_p_price'];
   $update_p_qty = $_POST['update_p_qty'];
   $update_p_image = $_FILES['update_p_image']['name'];
   $update_p_image_tmp_name = $_FILES['update_p_image']['tmp_name'];
   $update_p_image_folder = 'img/' . $update_p_image;
   $cat = $_POST['slt'];

   if ($update_p_image == '') {
      $update_p_image = $_POST['image'];
   }
   $update_query = mysqli_query($conn, "UPDATE `tblProduct` SET pname = '$update_p_name', price = '$update_p_price', quantity='$update_p_qty', image = '$update_p_image', category='$cat' WHERE pid = '$update_p_id'");

   if ($update_query) {
      move_uploaded_file($update_p_image_tmp_name, $update_p_image_folder);
      $message[] = 'product updated succesfully';
      header('location:admin.php');
   } else {
      $message[] = 'product could not be updated';
      header('location:admin.php');
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
         header('location:admin.php');
      } else {
         $message[] = 'failed to update password';
         header('location:admin.php');
      }
   }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Welcome Admin</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="style.css">
   <header class="header">

      <div class="flex">
         <p class="logo"><span>LEGACY</span>Sports</p>
         <!-- <nav class="navbar">
           
         </nav> -->
         <div class="wrapper">
        <div class="menu-area">
            <ul>
                <li><a href="#" id="menu-btn" class="fas fa-bars"></a>
                    <ul class="menu-items">
                        <li><a href="home1.php">View home page</a></li>
                        <li><a href="vieworder.php">view orders</a></li>
                        <li><a href="review.php">Review</a></li>
                        <li><a href="suppliers.php">Manage Suppliers</a></li>
                        <li><a href="logout.php">logout</a></li>
                        <li> <a href="admin.php?change=<?php echo $_SESSION['name']; ?>"> <i class="fas fa-edit"></i> change password</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
      </div>
      
   </header>
   
</head>

<body class="admin-form">
   <section>
      <form action="" method="post" class="add-product-form">
         <h3>Add a new product</h3>
         <input type="text" name="pname" maxlength="50" placeholder="enter the product name" class="box" required>
         <input type="number" name="price" min="10" max="50000" placeholder="enter the product price" class="box" required>
         <input type="number" name="qty" min="1" max="100" placeholder="enter the product quantity" class="box" required>
         <input type="file" name="p_image" accept="image/png, image/jpg, image/jpeg" class="box" required>
         <label for="slct" class="lbl">Category: </label>
         <select name="category" id="slct">
            <option value="Cricket">Cricket</option>
            <option value="Football">Football</option>
            <option value="Volleyball">Volleyball</option>
            <option value="Accesories">Accesories</option>
         </select>
         <input type="submit" value="Add" name="add_product" class="btn">
      </form>
   </section>

   <section class="display-product-table">
      <table>
         <thead>
            <th>Product Id</th>
            <th>Image</th>
            <th>Product name</th>
            <th>Price</th>
            <th>Category</th>
            <th>Quantity</th>
            <th>Action</th>
         </thead>
         <tbody>
            <?php

            $select_products = mysqli_query($conn, "SELECT * FROM `tblProduct` WHERE status!='inactive'");
            if (mysqli_num_rows($select_products) > 0) {
               while ($row = mysqli_fetch_assoc($select_products)) {
                  ?>

                  <tr>
                  <td>
                        <?php echo $row['pid']; ?>
                     </td>
                     <td><img src="img/<?php echo $row['image']; ?>" height="100" alt=""></td>
                     <td>
                        <?php echo $row['pname']; ?>
                     </td>
                     <td>₹
                        <?php echo $row['price']; ?>/-
                     </td>
                     <td>
                        <?php echo $row['category']; ?>
                     </td>
                     <td>
                        <?php echo $row['quantity']; ?>
                     </td>
                     <td>
                        <a href="admin.php?delete=<?php echo $row['pid']; ?>" class="delete-btn"
                           onclick="return confirm('are your sure you want to delete this?');"> <i class="fas fa-trash"></i>
                           delete </a>
                        <a href="admin.php?edit=<?php echo $row['pid']; ?>" class="option-btn"> <i class="fas fa-edit"></i>
                           update </a>
                     </td>
                  </tr>

                  <?php
               }
               ;
            } else {
               echo "<div class='empty'>no product added</div>";
            }
            ;
            ?>
         </tbody>
      </table>

   </section>

   <section class="edit-form-container">

      <?php

if (isset($_GET['edit'])) {
         $edit_id = $_GET['edit'];
         $edit_query = mysqli_query($conn, "SELECT * FROM `tblProduct` WHERE pid = $edit_id");
         if (mysqli_num_rows($edit_query) > 0) {
            while ($fetch_edit = mysqli_fetch_assoc($edit_query)) {
               ?>

               <form action="" method="post" enctype="multipart/form-data">
                  <img src="img/<?php echo $fetch_edit['image']; ?>" height="200" alt="">
                  <input type="hidden" name="update_p_id" value="<?php echo $fetch_edit['pid']; ?>">
                  <input type="text" class="box" required name="update_p_name" maxlength="50" value="<?php echo $fetch_edit['pname']; ?>">
                  <input type="number" min="1" max="50000" class="box" required name="update_p_price" value="<?php echo $fetch_edit['price']; ?>">
                  <input type="number" min="1" max="100" class="box" required name="update_p_qty" value="<?php echo $fetch_edit['quantity']; ?>">
                  <input type="file" class="box" name="update_p_image" accept="image/png, image/jpg, image/jpeg">
                  <input type="hidden" name="image" value="<?php echo $fetch_edit['image']; ?>">
                  <label for="slct" class="lbl">Category</label>
                  <select name="slt" id="slct">
                  <?php 
                     $ctg=$fetch_edit['category'];
                     if($ctg=="Cricket"){
                        echo '<option value="Cricket" selected>Cricket</option>';
                        echo '<option value="Football">Football</option>';
                        echo '<option value="Volleyball">Volleyball</option>';
                        echo '<option value="Accesories">Accesories</option>';
                     }elseif($ctg=="Football"){
                        echo '<option value="Cricket">Cricket</option>';
                        echo '<option value="Football" selected>Football</option>';
                        echo '<option value="Volleyball">Volleyball</option>';
                        echo '<option value="Accesories">Accesories</option>';
                     }elseif($ctg=="Volleyball"){
                        echo '<option value="Cricket">Cricket</option>';
                        echo '<option value="Football">Football</option>';
                        echo '<option value="Volleyball" selected>Volleyball</option>';
                        echo '<option value="Accesories">Accesories</option>';
                     }else{
                        echo '<option value="Cricket">Cricket</option>';
                        echo '<option value="Football">Football</option>';
                        echo '<option value="Volleyball" >Volleyball</option>';
                        echo '<option value="Accesories" selected>Accesories</option>';
                     }
                  ?>
                  </select>
                  <input type="submit" value="update the product" name="update_product" class="btn">
                  <!-- <input type="reset" value="cancel" id="close-edit" class="option-btn"> -->
                  <a href="admin.php" id="close-edit" class="option-btn">Cancel</a>
               </form>

               <?php
            }
            ;
         }
         ;
         echo "<script>document.querySelector('.edit-form-container').style.display = 'flex';</script>";
      }
      ;
      ?>

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
                  <input type="text" class="box" id="pwd" maxlength="10" required name="pass" value="<?php echo $fetch_edit['password']; ?>">
                  <br>
                  <label for="cpwd">Confirm Password:&nbsp;&nbsp;&nbsp;</label>
                  <input type="text" class="box" id="cpwd" required  maxlength="10" name="cpass">
                  <input type="submit" value="change password" name="update" class="btn">
                  <!-- <input type="reset" value="cancel" id="close-edit" class="option-btn"> -->
                  <a href="admin.php" id="close-edit" class="option-btn">Cancel</a>
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

   </div>

   <footer id="review">
      <!-- <?php
      $select_products = mysqli_query($conn, "SELECT * FROM `tblFeedback`");
      if (mysqli_num_rows($select_products) > 0) {
         while ($row = mysqli_fetch_assoc($select_products)) {
            echo '<div>' . $row['username'] . '</div>';
            echo '<div>' . $row['comment'] . '</div>';
         }
      } else {
         echo "<div class='empty'>no feedbacks added</div>";
      }
      ;
      ?> -->
   </footer>
   <script src="js/script.js"></script>
</body>

</html>