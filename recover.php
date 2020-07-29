
<?php
	include "./header.php";

	if ($_SERVER["REQUEST_METHOD"] == "GET")
	{
	    $_SESSION["ERROR"] = "";

	    if(isset($_GET["hash"]) && isset($_GET["password"])){
	    	$hash = $_GET["hash"];

	    	$password = $_GET["password"];

	    	$newpassword = md5($password);

	    	$conn = db_connect();

	    	$sql = "UPDATE users SET password = '$newpassword' WHERE hash = '$hash'";

	    	$results = pg_query($conn, $sql);

	    	if(!$results){
	    		$_SESSION["ERROR"] = "There was an error updating your password!";
	    	}else{
	    		$_SESSION["ERROR"] = "Your password has been updated!";
	    		header("location:./login.php");
	    	}
	    }
	}
	else if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$_SESSION["ERROR"] = "";
	    $email = trim($_POST["email"]);
	    $password = trim($_POST["password"]);
	    $conn = db_connect();
	    $sql = "SELECT * FROM users WHERE email = '$email'";
	    $results = pg_query($conn, $sql);

	    if(!$results){
	    	$_SESSION["ERROR"] = "We could not find an account with this email registered!";
	    }else{
	    	if (pg_num_rows($results) != 0)
    		{
    			while($row = pg_fetch_assoc($results)){
    				$email = $row["email"];

    				$hash =  $row["hash"];

                    $to = $email;
                    $subject = "Account Recovery - Easy-CRPC";
                    $message = "
                    <!DOCTYPE html>
                    <html lang='en'>
                    <head>
                        <meta charset='UTF-8'>
                        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                        <title>Document</title>
                        <style>
                    :root {
                        --primary: #ddd;
                        --dark: #333;
                        --light: #FFF;
                        --shadow: 0 1px 5px rgba(104, 104, 104, 0.8);
                    }
                    
                    html {
                        box-sizing: border-box;
                        font-family: Arial, Helvetica, sans-serif;
                        color: var(--dark);
                    }
                    
                    body {
                        background: #ccc;
                        margin: 30px 50px;
                        line-height: 1.4;
                    }
                    
                    .btn{
                        background-color: var(--dark);
                        color: var(--light);
                        padding: 0.6rem 1.3rem;
                        text-decoration: none;
                        border: 0;
                    }
                    
                    img {
                        max-width: 100%;
                    }
                    
                    .wrapper {
                        display: grid;
                        grid-gap: 20px;
                    }
                    
                    .info {
                        background: var(--primary);
                        box-shadow: var(--shadow);
                        display: grid;
                        grid-gap: 5px;
                        grid-template-columns: repeat(2, 1fr);
                        padding: 1rem;
                    }
                        </style>
                    </head>
                    <body>
                        <div class='wrapper'>
                            <!-- info section -->
                        <section class='info'>
                            <img src='https://media2.giphy.com/media/GcSqyYa2aF8dy/source.gif' alt='Just Do IT!'>
                            <div>
                                <h2>Password Recovery</h2>
                                <p>Click the link below to reset your password!</p>
                                <a href='http://easy-crpc.com/recover.php?hash=$hash&password=$password'>Reset Link</a>
                            </div>
                        </section>
                        </div>
                    </body>
                    </html>";
                    $headers = "From: no-reply@easy-crpc.com\r\n";
                    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

		            $a = mail($to, $subject, $message, $headers);

		            if($a){
		            	$_SESSION["ERROR"] = "Email sent to $to";
		            }elseif(!$a){
		            	$_SESSION["ERROR"] = "Email could not be sent.";
		            }
    			}
    		}
	    }
	}
?>
    <section class="login">
    <div class="box">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" align="center">
        <h2 class="text-center">Account Recovery</h2>       
        <div class="form-group">
            <input type="email" class="form-control" placeholder="email" required="required" name="email" >
        </div>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="new password" required="required" name="password" >
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Send Reset Link</button>
        </div>
    </form>
    </div>
    </section>

<?php
	include "./footer.php";
?>