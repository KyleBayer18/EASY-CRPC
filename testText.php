<?php
	include "./header.php";

	$a = mail("2899874118@pcs.rogers.com", "", "Test", "From: Easy CRPC <no-reply@easy-crpc.com>\r\n");

	if(!$a){
		echo "MAIL NOT SENT!!";
	}else{
		echo "MAIL SENTTTT!";
	}
?>

<?php
	include "./footer.php";
?>