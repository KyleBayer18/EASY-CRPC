<?php
if($_SESSION["USERNAME"]==""){
    $_SESSION["logout"]="You are not logged in, therefore you cannot logout!";
    header("location:index.php");
}
?>
<?php
session_unset();
session_destroy();
session_start();
$_SESSION['ERROR']='You have been logged out';
$_SESSION['USERNAME']='';
$_SESSION['STATUS']='';
header("location:index.php");
exit();
?>