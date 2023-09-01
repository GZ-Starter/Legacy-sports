<?php

@include 'config.php';

session_start();
if (isset($_POST['Add'])) {
   $check = mysqli_query($conn, "SELECT MAX(sid) from `tblSuppliers`");
   $row = mysqli_fetch_array($check);

   if ($row[0] == '') {
      $id = 100;
   } else {
      $id = $row[0] + 1;
   }


   $name = $_POST['sname'];
   $addr = $_POST['addr'];
   $category = $_POST['category'];
   $status = 'active';
   $insert = mysqli_query($conn, "INSERT INTO `tblSuppliers`(sid, sname, address,category, status) VALUES('$id','$name','$addr','$category', '$status')") or die('query failed');

   if ($insert) {
      $message[] = 'Record inserted succesfully';
   } else {
      $message[] = 'could not add the records';
   }
}
;

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   $delete_query = mysqli_query($conn, "UPDATE `tblSuppliers` set status='inactive' WHERE sid = $delete_id ") or die('query failed');
   if ($delete_query) {
      header('location:suppliers.php');
      $message[] = 'Record has been deleted';
   } else {
      header('location:suppliers.php');
      $message[] = 'Record could not be deleted';
   }
   ;
}
;

if (isset($_POST['update'])) {
   $update_s_id = $_POST['update_s_id'];
   $update_s_name = $_POST['update_s_name'];
   $addr=$_POST['update_address'];
   $cat = $_POST['slt'];

   $update_query = mysqli_query($conn, "UPDATE `tblSuppliers` SET sname = '$update_s_name', address = '$addr', category='$cat' WHERE sid = '$update_s_id'");

   if ($update_query) {
      move_uploaded_file($update_p_image_tmp_name, $update_p_image_folder);
      $message[] = 'records updated succesfully';
      header('location:suppliers.php');
   } else {
      $message[] = 'records could not be updated';
      header('location:suppliers.php');
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
                        <li><a href="admin.php">Add Products</a></li>
                        <li><a href="logout.php">logout</a></li>                       
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
      <form action="" method="post" class="add-product-form" id="sectionForm">
         <h3>Add Supplier details</h3>
         <!-- <input type="number" name="sid" placeholder="enter the Supplier ID" class="box" required> -->
         <input type="text" name="sname" placeholder="enter the Supplier name" class="box" pattern="[A-Za-z]+" oninvalid="this.setCustomValidity('Enter only text input')" onchange="this.setCustomValidity('')" required>
         <!-- <input type="text" name="addr" placeholder="enter the Supplier Address" class="box" required> -->
         <textarea name="addr" id="" placeholder="enter the Supplier Address" cols="69" rows="6" required></textarea ><br>
         <label for="slct" class="lbl">Select Product Category: </label>
         <select name="category" id="slct">
            <option value="Cricket">Cricket</option>
            <option value="Football">Football</option>
            <option value="Volleyball">Volleyball</option>
            <option value="Accesories">Accesories</option>
         </select>
         <!-- <section class="chk-container" id="slct">
         <p class="chk"><input type="checkbox" id="checkbox1" name="cat" value="Cricket" required>Cricket</p>
         <p class="chk"><input type="checkbox" id="checkbox2" name="cat" value="Football" required>Football</p>
         <p class="chk"><input type="checkbox" id="checkbox3" name="cat" value="Volleyball" required>Volleyball</p>
         <p class="chk"><input type="checkbox" id="checkbox4" name="cat" value="Accesories" required>Accesories</p>
      </section> -->
         <input type="submit" value="Add" name="Add" class="btn">
      </form>
   </section>

   <section class="display-product-table">
      <table>
         <thead>
            <th>Supplier ID</th>
            <th>Supplier Name</th>
            <th>Address</th>
            <th>Category</th>
            <th>Action</th>
         </thead>
         <tbody>
            <?php

            $select_products = mysqli_query($conn, "SELECT * FROM `tblSuppliers` WHERE status!='inactive'");
            if (mysqli_num_rows($select_products) > 0) {
               while ($row = mysqli_fetch_assoc($select_products)) {
                  ?>

                  <tr>
                     <td>
                        <?php echo $row['sid']; ?>
                     </td>
                     <td>
                        <?php echo $row['sname']; ?>
                     </td>
                     <td>
                        <?php echo $row['address']; ?>
                     </td>
                     <td>
                        <?php echo $row['category']; ?>
                     </td>
                     <td>
                        <a href="suppliers.php?delete=<?php echo $row['sid']; ?>" class="delete-btn"
                           onclick="return confirm('are your sure you want to delete this?');"> <i class="fas fa-trash"></i>
                           delete </a>
                        <a href="suppliers.php?edit=<?php echo $row['sid']; ?>" class="option-btn"> <i class="fas fa-edit"></i>
                           update </a>
                     </td>
                  </tr>

                  <?php
               }
               ;
            }else{
               echo "<div class='empty'>no records added</div>";
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
         $edit_query = mysqli_query($conn, "SELECT * FROM `tblSuppliers` WHERE sid = $edit_id");
         if (mysqli_num_rows($edit_query) > 0) {
            while ($fetch_edit = mysqli_fetch_assoc($edit_query)) {
               ?>
               <form action="suppliers.php" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="update_s_id" value="<?php echo $fetch_edit['sid']; ?>">
                  <input type="text" class="box" required pattern="[A-Za-z]+" oninvalid="this.setCustomValidity('Enter only text input')" onchange="this.setCustomValidity('')" name="update_s_name" value="<?php echo $fetch_edit['sname']; ?>">
                  <textarea name="update_address" id="" style="border:2px solid black" cols="67" rows="6" required ><?php echo $fetch_edit['address']; ?></textarea><br>
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
                  <input type="submit" value="update Details" name="update" class="btn">
                  <!-- <input type="reset" value="cancel" id="close-edit" class="option-btn"> -->
                  <a href="suppliers.php" id="close-edit" class="option-btn">Cancel</a>
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

   </div>

   <script src="js/script.js"></script>
</body>

</html>