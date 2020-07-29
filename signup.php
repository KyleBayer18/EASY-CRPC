<?php
include "./header.php";

if ($_SERVER["REQUEST_METHOD"] == "GET")
{
    $email = "";
    $password1 = "";
    $password2 = "";
    if (isset($_SESSION["USERNAME"]))
    {

    }
    else
    {
        $_SESSION["USERNAME"] = "";
    }

    if ($_SESSION["USERNAME"] != "")
    {
        header("location:./index.php");
        $_SESSION["ERROR"] = "You are already logged in!";
    }
}
else if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    //recieve values from the form
    $_SESSION["ERROR"] = "";
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password1 = trim($_POST['password1']);
    $password2 = trim($_POST['password2']);
    $phoneCarrier = $_POST['phoneCarrier'];

    

    //field validation
    if ($email == "")
    {
        $_SESSION["ERROR"] = "You have not entered a username!" . "<br/>";
    }
    if ($password1 == "")
    {
        $_SESSION['ERROR'] .= "You have not entered a password!" . "<br/>";
    }
    if ($password2 == "")
    {
        $_SESSION['ERROR'] .= "You have not entered a second password!" . "<br/>";
    }

    if ($password1 != $password2)
    {
        $_SESSION['ERROR'] .= "Your passwords do not match!" . "<br/>";
    }

    $password = md5($password1);

    $hash = md5(rand(0, 1000));

    $sql = "INSERT INTO users (email, phone, phoneprovider, password, hash) VALUES ('$email', '$phone', '$phoneCarrier', '$password', '$hash')";

    $conn = db_connect();
    
    $SQL1 = "SELECT * FROM users WHERE email = '$email'";
    
    $isExist = pg_query($conn, $SQL1);
    
    $ROWS = pg_num_rows($isExist);
    
    if($ROWS > 0){
        $_SESSION["ERROR"] .= "This email is already registered to an account!";
        header("Refresh:0");
        // $_SESSION["ERROR"] = "";
    }

    if ($_SESSION["ERROR"] == "")
    {

        $results = pg_query($conn, $sql);

        if ($results)
        {

            $_SESSION["ERROR"] = "Your account has been created, please enter the code sent to your email!";

            $to = $email;

            $subject = "Easy CRPC - Email Verification";
            
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
                        <h2>Email Verification</h2>
                        <p>Enter this code to verify your account: $hash </p>
                    </div>
                </section>
                </div>
            </body>
            </html>";
            
            // $message .= $hash;
            
            $headers = "From: no-reply@easy-crpc.com\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            
            $a = mail($to, $subject, $message, $headers);

            if($a){
                $_SESSION["ERROR"] = "Check your email, you have been sent a verification code!";
                ECHO "EMAIL SENT";
            }else{
                $_SESSION["ERROR"] = "EMAIL NOT SENT";
                ECHO "EMAIL NOT SENT";
            }

            header("location:./login.php");

        }
        else
        {
            $_SESSION['ERROR'] = "This user already exists, please select a different username! " . " <br />";
            
            // header("location:./register.php");
            
        }
    }

}

?>



        <div class="login">
        <div class="box">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <h2 class="text-center">Sign Up</h2>      
        <p>(case sensitive)</p>
        <div class="form-group">
            <input type="email" class="form-control" placeholder="Email" required="required" name="email" maxlength="70">
        </div>
        <!-- <div class="form-group">
            <input type="text" class="form-control" placeholder="Phone Number" name="phone" minlength="10" maxlength="10">
        </div>
        <div class="form-group">
            <label>Select your phone carrier: </label><span>   <button type="button" data-toggle="modal" data-target="#myModal"><i class="fa fa-question-circle-o" style="font-size:24px"></i></button> </span>
            <select name="phoneCarrier"> -->
        <?php
            // $conn = db_connect();

            // $sql = "SELECT * FROM phoneCarriers";

            // $results = pg_query($conn, $sql);

            // if(!$results){
            //     $_SESSION["ERROR"] = "There was an error collecting phone carriers";
            // }

            // while($row = pg_fetch_assoc($results)){
            //     $providerName = $row["providername"];
            //     $providerCode = $row["providercode"];
            //     echo "<option value='$providerCode'>$providerName</option>";
            // }



        ?>
            <!-- </select>

        </div> -->
        <div class="form-group">
            <input type="password" class="form-control" placeholder="Password" required="required" name="password1" minlength="4">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="Confirm Password" required="required" name="password2" minlength="4">
        </div>
        <!-- <div class="form-group">
            <input type="password" class="form-control" placeholder="Recovery Pin" required="required" name="pin">
        </div> -->
        <div class="form-group">
            <button type="submit" class="btn">Sign Up</button>
        </div>
        

    </form>
    </div>
    </div>



<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Why do you need my phone carrier?</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>

      </div>
      <div class="modal-body">
        <ul>
            <li>If you are planning on recieving notifications vis SMS this is absolutley necessary to ensure your messages are delivered!</li>
            <li>If you are unsure about which carrier you are with, <a href="https://www.carrierlookup.com/">click here</a>.  This tool will be able to tell you which provider you are with.
        </ul>
      </div>
      <<!-- div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div> -->
    </div>

  </div>
</div>


<?php
include "./footer.php";
?>
