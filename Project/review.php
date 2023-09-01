<?php
@include 'config.php';
session_start();
$name = $_SESSION['name'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <meta http-equiv="x-ua-compatible" content="ie=edge">
   <title>Reviews</title>
   <link rel="stylesheet" href="review.css">
   <!-- <link rel="stylesheet" href="style.css"> -->
   <!-- <script src="https://kit.fontawesome.com/44f557ccce.js"></script> -->

</head>

<body>
   <header class="header">

      <div class="flex">

         <p class="logo"><span>LEGACY</span>Sports
         <p>

         <nav class="navbar">

            <a href="admin.php">Return to Main Page</a>

      </div>

   </header>
   <h2 class="title">Review</h2>
   <div class="rev-section">

      <div class="reviews">
         <?php

         $select = mysqli_query($conn, "SELECT * FROM `tblFeedback`");
         if (mysqli_num_rows($select) == 0) {
            echo '<div class="name-review" style="border:2px solid black;">No feed backs have been added!! </div>';
         } else {
            while ($fetch = mysqli_fetch_assoc($select)) {
         ?>
               <div class="review">
                  <div class="body-review">
                     <div class="name-review">
                        <?php echo $fetch['username']; ?>
                     </div>
                     <div class="place-review">
                        <?php echo $fetch['date']; ?>
                     </div>
                     <div class="desc-review">
                        <?php echo $fetch['comment']; ?>
                     </div>
                  </div>
               </div>
            <?php
            }
            ;
         }
         ;
         ?>

         <!-- <div class="review">
    <div class="head-review">
       <img src="https://images.unsplash.com/photo-1463453091185-61582044d556?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" width="250px">
    </div>
    <div class="body-review">
       <div class="name-review">Knee gro</div>
       <div class="place-review">New York</div>
       <div class="rating">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star-half"></i>
       </div>
       <div class="desc-review">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Obcaecati eligendi suscipit illum officia ex eos.</div>
    </div>
 </div> -->


      </div>

   </div>

</body>

</html>