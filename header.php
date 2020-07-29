<?php
ob_start();
session_start();

include "./INCLUDES/db.php";
include "./JS/scripts.js";
// include "./includes/functions.js";

$ip = $_SERVER['REMOTE_ADDR'];
$_SESSION["ip"] = $ip;

function getUserIpAddr(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
if(isset($_SESSION["USERNAME"])){

}else{
  $_SESSION["USERNAME"] = "";
}
if(isset($_SESSION["ERROR"])){

}else{
  $_SESSION["ERROR"] = "";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script data-ad-client="ca-pub-7627390993876067" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <link rel="shortcut icon" type="image/x-icon" href="./img/logo.ico" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/64b5f0be18.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="CSS/styles.css">
    <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
    <script>
    $(document).ready(function(){
        $('input[type="checkbox"]').click(function(){
            $(".1").toggle();
        });
    });
    </script>
    <title>Easy - CRPC</title>
</head>
<body>
    <div class="wrapper">
    <!-- navigation -->
    <div class="logo">
        <h1 class="ml1">
            <span class="text-wrapper">
              <span class="line line1" style="background-color: white;"></span>
              <span class="letters" style="color: white;">EASY-CRPC</span>
              <span class="line line2" style="background-color: white;"></span>
            </span>
          </h1>
    </div>
    <div class="main-nav">
        <ul>
            <!-- <li><a href="./login.php">Login</a></li>
            <li><a href="./register.php">Register</a></li>
            <li><a href="./wos.php">Wall of Shame</a></li> -->
            <?php
        if($_SESSION["USERNAME"] != ""){
            echo "<li><a href='./index.php'>Home</a></li>";
            if($_SESSION["STATUS"] == "y"){
                echo "<li><a href='./progress.php'>Progress</a></li>";
            }else{
              echo "<li><a href='./measurements.php'>Measurements</a></li>";
            }
            echo "<li><a href='./logout.php'>Logout</a></li>";
        }else{
          echo "<li><a href='./index.php'>Home</a></li>";
          echo "<li><a href='./login.php'>Login</a></li>";
          echo "<li><a href='./signup.php'>Register</a></li>";
        }

        
        ?>
        </ul>
    </div>
    <?php
        if($_SESSION["ERROR"] == ""){
            
        }else{
            $message = $_SESSION["ERROR"];
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
  $message
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>";
        }
    ?>