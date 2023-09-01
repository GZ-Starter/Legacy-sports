<?php
@include 'config.php';
session_start();
$name = $_SESSION['name'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="vieworder.css">

</head>

<body>
    <header class="header">

        <div class="flex">

            <p class="logo"><span>LEGACY</span>Sports
            <p>

            <nav class="navbar">

                <a href="home1.php">Continue Shopping</a>

        </div>

    </header>
    <div class="container-fluid my-5  d-flex  justify-content-center">
        <div class="card card-1">
            <div class="card-header bg-white">

                <div class="media flex-sm-row flex-column-reverse justify-content-between  ">
                    <div class="col my-auto">
                        <h1 class="mb-0">
                            <?php

                            $select_cart = mysqli_query($conn, "SELECT * FROM `tblOrder` WHERE username='$name'");
                            if (mysqli_num_rows($select_cart) == 0) {
                                echo "You havn't ordered any Products!";
                            } else {
                                ?>
                                Thanks for your Order,<span class="change-color">
                                    <?php echo $name; ?>
                                </span> !
                            </h1>
                        </div>
                        <!-- <div class="col-auto text-center  my-auto pl-0 pt-sm-4"> <img class="img-fluid my-auto align-items-center mb-0 pt-3"  src="https://i.imgur.com/7q7gIzR.png" width="115" height="115"> <p class="mb-4 pt-0 Glasses">Glasses For Everyone</p>  </div> -->
                    </div>
                </div>
                <div class="card-body">
                    <div class="row justify-content-between mb-3">
                        <div class="col-auto"> <small class="color-1 mb-0 change-color">Receipt</small> </div>
                        <!-- <div class="col-auto  "> <small>Receipt Voucher : 1KAU9-84UIL</small> </div> -->
                    </div>
                    <?php

                    $select_cart = mysqli_query($conn, "SELECT * FROM `tblOrder` WHERE username='$name' AND status !='Canceled'");
                    $grand_total = 0;
                    if (mysqli_num_rows($select_cart) > 0) {
                        while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {

                            $id = $fetch_cart['pid'];
                            $select = mysqli_query($conn, "SELECT * FROM `tblProduct` WHERE pid=$id");
                            $fetch_qty = mysqli_fetch_array($select);
                            ?>
                            <div class="row">
                                <div class="col">
                                    <div class="card card-2">
                                        <div class="card-body">
                                            <div class="media">
                                                <div class="sq align-self-center "> <img
                                                        class="img-fluid  my-auto align-self-center mr-2 mr-md-4 pl-0 p-0 m-0"
                                                        src="img/<?php echo $fetch_qty['image']; ?>" width="135" height="135" />
                                                </div>
                                                <div class="media-body my-auto text-right">
                                                    <div class="row  my-auto flex-column flex-md-row">
                                                        <div class="col my-auto"> <small class="mb-0">
                                                                <?php echo $fetch_qty['pname']; ?>
                                                            </small> </div>
                                                        <div class="col-auto my-auto"> <small>Price :
                                                                <?php echo $sub_total = $fetch_qty['price']; ?>
                                                            </small></div>
                                                        <!-- <div class="col my-auto"> <small>Size : M</small></div> -->
                                                        <div class="col my-auto"> <small>Qty :
                                                                <?php echo $fetch_cart['quantity']; ?>
                                                            </small></div>
                                                        <div class="col my-auto"><small class="mb-0">Total : &#8377;
                                                                <?php echo $sub_total = $fetch_qty['price'] * $fetch_cart['quantity']; ?>
                                                            </small>
                                                            <?php $grand_total += $sub_total;

                                                            $sts = $fetch_cart['status'];
                                                            if ($sts == 'BOOKED' or $sts == '') {
                                                                $sp = 5;
                                                            } elseif ($sts == 'OnWay') {
                                                                $sp = 60;
                                                            } elseif ($sts == 'DELIVERED') {
                                                                $sp = 100;
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="my-3 ">
                                            <div class="row">
                                                <div class="col-md-3 mb-3"> <small> Track Order <span><i class=" ml-2 fa fa-refresh"
                                                                aria-hidden="true"></i></span></small> </div>
                                                <div class="col mt-auto">
                                                    <div class="progress my-auto">
                                                        <div class="progress-bar progress-bar  rounded"
                                                            style="width: <?php echo $sp; ?>%" role="progressbar" aria-valuenow="25"
                                                            aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <div class="media row justify-content-between ">
                                                        <div class="col-auto text-right"><span> <small
                                                                    class="text-right mr-sm-2"></small> <i
                                                                    class="fa fa-circle active"></i> </span></div>
                                                        <div class="flex-col"> <span> <small class="text-right mr-sm-2">Out for
                                                                    delivary</small><i class="fa fa-circle active"></i></span></div>
                                                        <div class="col-auto flex-col-auto"><small
                                                                class="text-right mr-sm-2">Delivered</small><span> <i
                                                                    class="fa fa-circle"></i></span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ;
                    }
                    ;
                    ?>
                    <div class="row mt-4">
                        <div class="col">
                            <div class="row justify-content-between">
                                <?php
                                $select = mysqli_query($conn, "SELECT * FROM `tblOrder` WHERE username='$name'");
                                $fetch = mysqli_fetch_assoc($select);
                                ?>
                                <div class="col-auto">
                                    <p class="mb-1 text-dark"><b>Order Details</b></p>
                                </div>
                                <!-- <div class="flex-sm-col text-right col"> <p class="mb-1"><b>Total</b></p> </div>
                            <div class="flex-sm-col col-auto"> <p class="mb-1">&#8377;4,835</p> </div> -->
                            </div>
                            <div class="row justify-content-between">
                                <div class="flex-sm-col text-right col">
                                    <p class="mb-1"> <b>Discount &nbsp;&nbsp;</b></p>
                                </div>
                                <div class="flex-sm-col col-auto">
                                    <p class="mb-1">&#8377;0</p>
                                </div>
                            </div>
                            <div class="row justify-content-between">
                                <div class="flex-sm-col text-right col">
                                    <p class="mb-1"><b>GST &nbsp;</b></p>
                                </div>
                                <div class="flex-sm-col col-auto">
                                    <p class="mb-1">N/A</p>
                                </div>
                            </div>
                            <div class="row justify-content-between">
                                <div class="flex-sm-col text-right col">
                                    <p class="mb-1"><b>Delivery Charges</b></p>
                                </div>
                                <div class="flex-sm-col col-auto">
                                    <p class="mb-1">Free</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row invoice ">
                        <div class="col">
                            <p class="mb-1"> Invoice Number :
                                <?php echo @$fetch['order_id']; ?>
                            </p>
                            <p class="mb-1">Invoice Date :
                                <?php echo @$fetch['order_date']; ?>
                            </p>
                            <!-- <p class="mb-1">Recepits Voucher:<?php echo ''; ?></p></div> -->
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="jumbotron-fluid">
                            <div class="row justify-content-between ">
                                <div class="col-auto my-auto ">
                                    <h2 class="mb-0 font-weight-bold">TOTAL PAID</h2>
                                </div>
                                
                                <div class="col-auto my-auto ml-auto">
                                    <h1 class="display-3 ">&#8377;
                                        <?php echo $grand_total; ?>
                                    </h1>
                                </div>
                            </div>
                            <div class="row mb-3 mt-3 mt-md-0">
                                <div class="col-auto border-line"> <small class="text-white">PAN:---------</small></div>
                                <div class="col-auto border-line"> <small class="text-white">CIN:UMMC20PTC </small></div>
                                <div class="col-auto "><small class="text-white">GSTN:268FD07EXX </small> </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </body>
    <?php
                            }
                            ;
                            ?>

</html>