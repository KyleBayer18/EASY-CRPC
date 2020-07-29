<?php
include "./header.php";

$output = "";
$type = "";
$user_id = "";
$email_address = "";
$enrol_date = "";
$last_access = "";
if ($_SERVER["REQUEST_METHOD"] == "GET")
{
    
    if(!isset($_SESSION["USERNAME"]) || $_SESSION["USERNAME"] == ""){
        header("location:./login.php");
    }
    if(isset($_GET["id"])){
        $email = $_GET["id"];

        $conn = db_connect();

        $sql = "SELECT * FROM users WHERE email = '$email'";

        $results = pg_query($conn, $sql);

        if(!$results){
            $_SESSION["ERROR"] = "There was an error getting your information!";
        }else{
            while($row = pg_fetch_assoc($results)){
                $email = $row["email"];
                $hash = $row["hash"];

                $to = $email;

                $subject = 'Easy CRPC - Email Verification';

                $message = 'Enter the following code to verify your account: ';
                
                $message .= $hash;

                $header = 'From: no-reply@easy-crpc.com';

                $a = mail($to, $subject, $message, $header);

                if($a){
                    $_SESSION["ERROR"] = "EMAIL SENT";
                    // ECHO "EMAIL SENT";
                }else{
                    $_SESSION["ERROR"] = "EMAIL NOT SENT";
                    // ECHO "EMAIL NOT SENT";
                }
            }
        }
    }
    $conn = db_connect();

    $email = $_SESSION["USERNAME"];

    $sql = "SELECT * FROM users WHERE email = '$email'";

    $results = pg_query($conn, $sql);

    if(!$results){

    }

    while($row = pg_fetch_assoc($results)){
        $verified = $row["verified"];

        if($verified == "YES"){
            header("location:./measurements.php");
        }
    }
    
}
else if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $conn = db_connect();
    $_SESSION["ERROR"] = "";
    $code = trim($_POST["verify"]);
    $email = $_SESSION["USERNAME"];
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $results = pg_query($conn, $sql);
    if (pg_num_rows($results) != 0)
    { //not zero means something was found
        $_SESSION["USERNAME"] = $email;
        
        while ($row = pg_fetch_assoc($results))
        {
            $hash = $row["hash"];

            $status = $row["status"];

            if($code == $hash)
            {
                $conn = db_connect();

                $sql = "UPDATE users SET verified = 'YES' WHERE email = '$email'";

                $result = pg_query($conn, $sql);

                if(!$result){
                    $_SESSION["ERROR"] .= "There was an error updating the validity of your account!";
                }else{
                    if ($status == "n")
                    {
                        header("location:./measurements.php");
                    }
                    elseif ($status == "y")
                    {
                        header("location./progress.php");
                    }
                }
            }

        }

    }
    else
    {
        $_SESSION['ERROR'] = "The code you entered did not match!";
    }
}

?>
<p><?php 
    $error = $_SESSION["ERROR"];
    $email = $_SESSION["USERNAME"];
    if($error == ""){
        $_SESSION["ERROR"] = "The verification code was sent to $email";
    }else{
        $_SESSION["ERROR"] = "$error";
    }
?>
    <section class="login">
    <div class="box">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" align="center">
        <h2 class="text-center">Verify Account</h2>    
        <br>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Verification Code" name="verify">
        </div>
        <!-- <div class="form-group">
            <input type="password" class="form-control" placeholder="password" required="required" name="password">
        </div> -->
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Verify</button>
        </div>
        <div class="form-group">
            <?php 
                echo "<a href='./verify.php?id=$email'>Resend Email</a>";
            ?>
        </div>
    </form>
    </div>
    </section>


<?php
include "./footer.php";
?>
