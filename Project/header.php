<header class="header">

   <div class="flex">

      <!-- <a href="#" class="logo"><p>Legacy</p>Sports</a> -->
      <p class="logo"><span>LEGACY</span>Sports<p>
      <nav class="navbar">
         <?php
         @session_start();
         if ($_SESSION['name'] == 'admin') {
            echo '<a href="admin.php">Add products</a>';
         }else{
         
         ?>

         <!-- <a href="#feedback">Feedback</a> -->

      </nav>

      <?php
      $name = $_SESSION['name'];
      $select_rows = mysqli_query($conn, "SELECT * FROM `tblCart` WHERE username='$name'") or die('query failed');
      $row_count = mysqli_num_rows($select_rows);

      ?>

      <a href="cart.php" class="optn"><img class="imgc" src="img/cart2.png" alt=""><span>
            <?php echo $row_count; ?>
         </span> </a>
     
      <!-- <a href="home1.php?change=<?php echo $_SESSION['name']; ?>" class="optn"> <i class="fas fa-edit"></i> change password</a> -->
      <!-- <a href="home1.php?cdetails=<?php echo $_SESSION['name']; ?>" class="optn"> <i class="fas fa-edit"></i>change profile</a> -->
      <!-- <div id="menu-btn" class="fas fa-bars"> -->
      <div class="wrapper">
        <div class="menu-area">
            <ul>
                <li><a href="#" id="menu-btn" class="fas fa-bars"></a>
                    <ul class="menu-items">
                        <li><a href="home1.php?change=<?php echo $_SESSION['name']; ?>" class="optn"><i class="fas fa-edit"></i>change password</a></li>
                        <li> <a href="home1.php?cdetails=<?php echo $_SESSION['name']; ?>" class="optn"><i class="fas fa-edit"></i>change profile</a></li>
                        <li><a href="#feedback"  class="optn">feedback</a></li>
                        <li><a href="logout.php" class="optn">logout</a></li>
                        <li><a href="order.php" class="optn">View Orders</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <?php };
      ?>
      <!-- </div> -->
   </div>

</header>
<script src="js/script.js"></script>