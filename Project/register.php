<?php
@include 'config.php';
if(isset($_POST['register'])){
    $name=$_POST['name'];
    $user=$_POST['username'];
    $pass=$_POST['password'];
    $cpass=$_POST['cpass'];
    $addr=$_POST['address'];
    $email=$_POST['email'];
    $utype='user';

    $select = " SELECT * FROM tblLogin WHERE username = '$user'";
    $result=mysqli_query($conn,$select);
    if(mysqli_num_rows($result)>0)
    {
        $error[] ='username already exists!';
    }else{
        if($pass!=$cpass){
            $error[] = 'password not matched!';
        }elseif(strlen($pass)<8){
            $error[]='password must be atleast eight characters';
        }else{
            $insert="INSERT INTO tblRegister(username,name,address,email) VALUES('$user','$name','$addr','$email')";
            mysqli_query($conn, $insert);
            $insert = "INSERT INTO tblLogin(username,password,usertype) VALUES('$user','$pass','$utype')";
            mysqli_query($conn, $insert);
            header('location:login.php');
            
        }
    }
};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <div class="container">
    <h1>Register</h1>
        <form action="" method="post" name="form1">
            <?php
                if(isset($error)){
                   foreach($error as $error){
                    echo '<span class="error-msg">'.$error.'</span>';
                 };
                };
           ?>
            <input type="text" name="name" id="name" pattern="[A-Za-z]+" oninvalid="this.setCustomValidity('Enter only text input')" onchange="this.setCustomValidity('')" required placeholder="Enter the name" maxlength="30">
            <input type="text" name="username" required placeholder="Enter username" maxlength="25">
            <input type="password" name="password" maxlength="8" required placeholder="Enter password" onchange="CheckPassword(document.form1.password)">
            <input type="password" name="cpass" maxlength="8" required placeholder="Confirm password">
            <input type="text" name="address" required placeholder="Enter the Address">
            <input type="email" name="email" required maxlength="50" placeholder="Enter the email">
            <input type="submit" name="register" class="submit">
            <p>already have an account? <a href="login.php">login now</a></p>
        </form>
    </div>
    <script src="js/checkpassword.js"></script>
</body>
</html>


