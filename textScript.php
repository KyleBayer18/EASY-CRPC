<?php
	include "./header.php";
?>
<?php
	$to = "2899874118@pcs.rogers.com";
    $subject = "!!IT'S TIME FOR PUSH-UPS!!";
    $message = "Still think you can do this?";
    $message .= "Drop and give me $pushUps Push-Ups!";
    $headers = "From: no-reply@easy-crpc.com";

    $a = mail("$to", " ", "$message");

    if($a){
    	echo "mail sent";
    	echo "$to";
    	echo "$message";
    }else{
    	echo "not sent";
    	echo "$to";
    	echo "$message";
    }
?>