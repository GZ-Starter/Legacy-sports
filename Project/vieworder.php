<?php
@include 'config.php';

if (isset($_POST['update'])) {
   $id = $_POST['pid'];
   $oid = $_POST['oid'];
   $sts = $_POST['slct'];
   $update = mysqli_query($conn, "UPDATE `tblOrder` SET status = '$sts' WHERE order_id='$oid' AND pid = '$id'");
   if ($update) {
      header('location:vieworder.php');
   }
   ;
}
;

if (isset($_GET['delete'])) {
   $oid = $_GET['delete'];
   $id = $_GET['del'];
   mysqli_query($conn, "UPDATE `tblOrder` SET status = 'Canceled' WHERE order_id='$oid' AND pid = '$id'");
   header('location:vieworder.php');
}
;
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Orders</title>
   <link rel="stylesheet" href="style.css">
   <header class="header">

      <div class="flex">
         <p class="logo"><span>LEGACY</span>Sports</p>
         <nav class="navbar">
            <a href="admin.php">Manage Products</a>
            <a href="logout.php">logout</a>
            <Style>
               .sts {
                  background-color: orange;
                  height: 40px;
                  width: 100px;
                  border-radius: 5px;
                  color: white;
                  font-size: 19px;
               }
            </Style>
         </nav>
      </div>
   </header>
</head>

<body>
   <section class="display-product-table">
      <table>
         <thead>
            <th>Order ID</th>
            <th>Product ID</th>
            <th>Product name</th>
            <th>Username</th>
            <th>Quantity</th>
            <th>Status</th>
            <th>Order Date</th>
            <th>Action</th>

         </thead>
         <tbody>
            <?php

            $select_products = mysqli_query($conn, "SELECT * FROM `tblOrder` WHERE status != 'Canceled'");
            if (mysqli_num_rows($select_products) > 0) {
               while ($row = mysqli_fetch_assoc($select_products)) {
                  ?>

                  <tr>
                     <td>
                        <?php echo $row['order_id']; ?>
                     </td>
                     <td>
                        <?php echo $row['pid']; ?>
                     </td>
                     <td>
                        <?php
                        $id=$row['pid'];
                        $select = mysqli_query($conn, "SELECT * FROM `tblProduct` WHERE pid = $id");
                        $r = mysqli_fetch_assoc($select);
                        echo $r['pname']; ?>
                     </td>
                     <td>
                        <?php echo $row['username']; ?>
                     </td>
                     <td>
                        <?php echo $row['quantity']; ?>
                     </td>
                     <td>
                        <form action="" method="post">
                           <input type="hidden" name="pid" value="<?php echo $row['pid']; ?>">
                           <input type="hidden" name="oid" value="<?php echo $row['order_id']; ?>">
                           <select name="slct" id="">
                              <?php $slct = $row['status'];
                              if ($slct == "BOOKED") {
                                 echo '<option value="BOOKED" selected>BOOKED</option>';
                                 echo '<option value="OnWay">On The Way</option>';
                                 echo '<option value="DELIVERED">DELIVERED</option>';
                              } elseif ($slct == "OnWay") {
                                 echo '<option value="BOOKED">BOOKED</option>';
                                 echo '<option value="OnWay" selected>On The Way</option>';
                                 echo '<option value="DELIVERED">DELIVERED</option>';
                              } else {
                                 echo '<option value="BOOKED">BOOKED</option>';
                                 echo '<option value="OnWay">On The Way</option>';
                                 echo '<option value="DELIVERED" selected>DELIVERED</option>';
                              }
                              ?>
                           </select>
                           <input type="submit" value="update" name="update" class="sts">
                        </form>
                        <!-- <?php echo $row['status']; ?><a href="vieworder.php?edit=<?php echo $row['pid'] ?>&order=<?php echo $row['order_id']; ?>" class="option-btn"> <i class="fas fa-edit"></i>update </a> -->
                     </td>
                     <td>
                        <?php echo $row['order_date']; ?>
                     </td>
                     <td>
                        <a href="vieworder.php?delete=<?php echo $row['order_id']; ?>&del=<?php echo $row['pid']; ?>"
                           class="delete-btn" onclick="return confirm('are your sure you want to cancel this?');"> <i
                              class="fas fa-trash"></i>
                           Cancel Order</a>
                        <a href="vieworder.php?edit=<?php echo $row['order_id']; ?>" class="option-btn"> <i
                              class="fas fa-edit"></i>Details</a>
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
         $edit_query = mysqli_query($conn, "SELECT * FROM `tblDelivery` WHERE order_id = $edit_id");
         if (mysqli_num_rows($edit_query) > 0) {
            while ($fetch_edit = mysqli_fetch_assoc($edit_query)) {
               ?>
               <form action="" method="" enctype="multipart/form-data">
                  <input type="hidden" name="update_s_id" value="<?php echo $fetch_edit['order_id']; ?>">
                  <!-- <div class="flex"> -->
               <table>
<tr>
                     <div class="inputBox">
                        <td><span style="font-size:19px;" >customer name</span></td>
                        <td><input type="text" style="width:130%" class="box" value="<?php echo @$fetch_edit['name']; ?>"></td>
                     </div>
            </tr><tr>
                     <div class="inputBox">
                        <td><span style="font-size:19px;">phone number</span></td>
                        <td><input type="tel" class="box" style="width:130%" value="<?php echo @$fetch_edit['phone']; ?>"></td>
                     </div>
                     </tr>   <tr> 
                     <div class="inputBox">
                        <td><span style="font-size:19px;">payment method</span></td>
                        <td><input type="text" style="width:130%" class="box" value="<?php echo @$fetch_edit['method']; ?>"></td>
                     </div>
                     
                     </tr><tr>
                  <div class="inputBox">
                     <td><span style="font-size:19px;">address line 1</span></td>
                     <td><input type="text" style="width:130%" class="box" value="<?php echo @$fetch_edit['flat']; ?>"></td>
                  </div>
                  </tr><tr>
                  <div class="inputBox">
                     <td><span style="font-size:19px;">address line 2</span></td>
                     <td><input type="text" style="width:130%" class="box" value="<?php echo @$fetch_edit['street']; ?>"></td>
                  </div>
                  </tr><tr>
                  <div class="inputBox">
                     <td><span style="font-size:19px;">city</span></td>
                     <td><input type="text" style="width:130%" class="box" value="<?php echo @$fetch_edit['city']; ?>"></td>
                  </div>
                  </tr><tr>
                  <div class="inputBox">
                     <td><span style="font-size:19px;">state</span></td>
                     <td><input type="text" style="width:130%" class="box" value="<?php echo @$fetch_edit['state']; ?>"></td>
                  </div>
                  </tr><tr>
                  <div class="inputBox">
                     <td><span style="font-size:19px;">pin code</span></td>
                     <td><input type="tel" style="width:130%" class="box" value="<?php echo @$fetch_edit['pincode']; ?>"></td>
                  </div>
                  </tr>
                  </table>
               </div>
                  
                  <a href="vieworder.php" id="close-edit" class="option-btn">Cancel</a>
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
</body>

</html>