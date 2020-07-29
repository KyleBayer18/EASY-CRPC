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
    $email = "";
    $pass = "";
}
else if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $_SESSION["ERROR"] = "";
    $email = trim($_POST["email"]);
    $password1 = trim($_POST["password"]);
    $conn = db_connect();
    $sql = "SELECT email, password, status, verified FROM
        users WHERE email = '$email' AND password= '" . md5($password1) . "'";
    $results = pg_query($conn, $sql);
    setcookie("EMAIL", "$email", time()+2*24*60*60);
    setcookie("PASSWORD", "$password1", time()+2*24*60*60);
    if (pg_num_rows($results) != 0)
    { //not zero means something was found
        $_SESSION["USERNAME"] = $email;
        $_SESSION["ERROR"] = "Welcome Back $email!";
        while ($row = pg_fetch_assoc($results))
        {
            $status = $row["status"];
            $_SESSION["STATUS"] = $status;
            $verified = $row["verified"];
            if($verified == 'NO'){
                header("location:./verify.php");
            }else{
                if ($status == "n")
                {
                    header("location:./measurements.php");
                }
                elseif ($status == "y")
                {
                    header("location:./progress.php");
                }
            }
            
        }

    }
    else
    {
        $_SESSION['ERROR'] = "Invalid email and password combination!";
    }
}

?>
<section class="login">
        <div class="box">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" align="center">
            <h2 class="text-center">Log in</h2>       
            <div class="form-group">
                <input type="email" class="form-control" placeholder="email" required="required" name="email" value="<?php if(isset($_COOKIE['EMAIL'])){$email = $_COOKIE['EMAIL']; echo $email;}?>">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="password" required="required" name="password" value="<?php if(isset($_COOKIE['EMAIL'])){$password = $_COOKIE['PASSWORD']; echo $password;} ?>">
            </div>
            <div class="form-group">
                <button type="submit" class="btn">Log in</button>
            </div>
            <div class="clearfix">
                <p class="text-center"><a href="./signup.php">Create an Account</a></p>
                <p class="text-center"><a href="./recover.php">Forgot Password?</a></p>
            </div>        
        </form>
        </div>
</section>

<?php
include "./footer.php";
?>
