<?php

@include 'config.php';

session_start();

if(isset($_POST['submit'])){

   $uname =$_POST['username'];
   $pass =$_POST['password'];

   $select = " SELECT * FROM tblLogin WHERE username = '$uname' && password = '$pass' ";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $row = mysqli_fetch_array($result);

      if($row['usertype'] == 'admin'){

         $_SESSION['name'] = $row['usertype'];
         header('location:.//admin.php');
         
      }elseif($row['usertype'] == 'user'){

         $_SESSION['name'] = $row['username'];
         header('location:.//home1.php');
      
      }
     
   }else{
      $error= 'incorrect email or password!';
   }

};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-form">
        <h1>Login</h1>
        <form method="post">
        <?php
        if(isset($error)){
         //   foreach($error as $error){
              echo '<span class="error-msg">'.$error.'</span>';
         //   };
        };
        ?>         
        
        <input type="text" name="username" required placeholder="Enter the username" />
        <input type="password" name="password" required placeholder="Password" />
        <button type="submit" name="submit">Login</button>
        <div class="forgot-signup">
            <!-- <a href="#" class="forgot-pwd">Forgot password?
               
            </a> -->
            <p>Dont have an account? <a href="register.php" class="signup">Sign Up</a></p>
        </div>
        </form>
    </div>
</body>
</html>