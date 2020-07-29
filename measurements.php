<?php
include "./header.php";

$conn = db_connect();
    $email = $_SESSION["USERNAME"];

    $sql = "SELECT * FROM measurements WHERE email = '$email'";

    $results = pg_query($conn, $sql);

    $rows = pg_num_rows($results);

    if ($rows != 0) {
        $_SESSION["ERROR"] = "Your measurements have already been set!";
        header("Location:./progress.php");
    }

if($_SESSION["USERNAME"] == ""){
	header("location:./index.php");
}elseif(!isset($_SESSION["USERNAME"])){
	header("location:./index.php");
}
if(isset($_SESSION["STATUS"])){

}else{
    $_SESSION["STATUS"] = "";
    header("location./login.php");
}
if($_SESSION["STATUS"] != "n"){
    header("location./login.php");
}

if($_SESSION["USERNAME"] == ""){
    header("location:./login.php");
}

if($_SERVER["REQUEST_METHOD"] == "GET"){
    $leftBicep = "";
    $rightBicep = "";
    $chest = "";
    $weight = "";
    $email = $_SESSION["USERNAME"];

    $conn = db_connect();

    $sql = "SELECT * FROM measurements WHERE email = '$email'";

    $results = pg_query($conn, $sql);

    $rows = pg_num_rows($results);

    if ($rows != 0) {
        $_SESSION["ERROR"] = "Your measurements have already been set!";
        header("location:./progress.php");
    }
    
}else if($_SERVER["REQUEST_METHOD"] == "POST"){


    $_SESSION["ERROR"] = "";

    $contactMethod = "e";
    $pushUps = trim($_POST["pushUps"]);
    $leftBicep = trim($_POST["leftBicep"]);
    $rightBicep = trim($_POST["rightBicep"]);
    $chest = trim($_POST["chest"]);
    $weight = trim($_POST["weight"]);
    $wakeUp = trim($_POST["wakeUp"]);



    if(!isset($_POST["leftBicep"]) && !isset($_POST["rightBicep"]) && !isset($_POST["chest"]) && !isset($_POST["weight"])){
        $leftBicep = 66;
        $rightBicep = 66;
        $weight = 66;
        $chest = 66;
    }
    if($leftBicep == "" && $rightBicep == "" && $weight == "" && $chest == ""){
        $leftBicep = 66;
        $rightBicep = 66;
        $weight = 66;
        $chest = 66;
    }


    
    if($contactMethod == "p"){
        
        $conn = db_connect();

        $sql = "UPDATE users SET contactmethod = '$contactMethod' WHERE email = '$email'";

        $results = pg_query($conn, $sql);

        if(!$results){
            $_SESSION["ERROR"] .= "There was an error updating your contact method.";
        }
    }
    if($leftBicep == 66 && $rightBicep == 66 && $weight == 66 && $chest == 66){
        if(!($pushUps > 0)){
            $_SESSION["Please enter a number of pushUps that are greater than 0!  I know you can do more than that!"];
        }
        if($wakeUp == ""){
            $_SESSION["ERROR"] .= "Please enter a time at which you normally wake up.  This will be the time used to start your push-up challenge!";
        }
    }else{
        if($pushUps == ""){
            $_SESSION["ERROR"] .= "You need to enter a push-up amount!";
        }
        // if($pushUps < 0){
        //     $_SESSION["Please enter a number of push-ups greater than 0!"];
        // }
        if(!($pushUps > 0)){
            $_SESSION["Please enter a number of pushUps that are greater than 0!  I know you can do more than that!"];
        }
        if($leftBicep == ""){
            $_SESSION["ERROR"] .= "You cannot leave the left bicep field empty, please enter your measurements to track your results!";
        }
        if($leftBicep < 0){
            $_SESSION["ERROR"] .= "How is it possible that your left bicep is negative inches?  Please enter a realistic measurement to help yourself track your progress!";
        }
        if($leftBicep == 0){
            $_SESSION["ERROR"] .= "I know that your left bicep is not 0 inches.  Please either leave the measurements step blank or enter a realistic measurement!";
        }
        if($rightBicep == ""){
            $_SESSION["ERROR"] .= "You cannot leave the right bicep field empty, please enter your measurements to track your results!";
        }
        if($rightBicep < 0){
            $_SESSION["ERROR"] .= "How is it possible that your right bicep is negative inches?  Please enter a realistic measurement to help yourself track your progress!";
        }
        if($rightBicep == 0){
            $_SESSION["ERROR"] .= "I know that your right bicep is not 0 inches.  Please either leave the measurements step blank or enter a realistic measurement!";
        }
        if($leftBicep == ""){
            $_SESSION["ERROR"] .= "You cannot leave the chest field empty, please enter your measurements to track your results!";
        }
        if($chest < 0){
            $_SESSION["ERROR"] .= "How is it possible that your chest is negative inches?  Please enter a realistic measurement to help yourself track your progress!";
        }
        if($chest == 0){
            $_SESSION["ERROR"] .= "I know that your chest is not 0 inches.  Please either leave the measurements step blank or enter a realistic measurement!";
        }
        if($weight == ""){
            $_SESSION["ERROR"] .= "You cannot leave the weight field empty, please enter your measurements to track your results!";
        }
        if($weight < 0){
            $_SESSION["ERROR"] .= "How is it possible that your weight is negative pounds?  Are you doing the challenge in space?  Please enter a realistic measurement to help yourself track your progress!";
        }
        if($weight == 0){
            $_SESSION["ERROR"] .= "I know that your weight is not 0 pounds.  Please either leave the measurements step blank or enter a realistic measurement!";
        }
        if($wakeUp == ""){
            $_SESSION["ERROR"] .= "Please enter a time at which you normally wake up.  This will be the time used to start your push-up challenge!";
        }
    }

    //IF THERE ARE NO PROCESSING ERRORS THEN LET THE MAGIC BEGIN
    if($_SESSION["ERROR"] == ""){


            $conn = db_connect();
            //If the contact method is set to p, the email variable is modified for text.
            if($contactMethod == 'p'){
                $conn = db_connect();
                $email = $_SESSION["USERNAME"];
                $sql = "SELECT * FROM users WHERE email = '$email'";
                $results = pg_query($conn, $sql);
                while($row = pg_fetch_assoc($results)){
                    $provider = $row["phoneprovider"];
                    $phone = $row["phone"];
                    $email = "$phone";
                    $email .= "@";
                    $email .= "$provider";
                }
            }elseif($contactMethod == 'e'){
                $email = $_SESSION["USERNAME"];
            }

            $sql = "INSERT INTO measurements (email, leftBicep, rightBicep, chest, weight, maxpushups, wakeuptime) VALUES ('$email', '$leftBicep', '$rightBicep', '$chest', '$weight', '$pushUps', '$wakeUp')";

            $results = pg_query($conn, $sql);


            if(!$results){
                $_SESSION["ERROR"] .= "An error has occured while inserting your measurements!";
            }

            //This loop calculates all of the possible times for email sending!
            $i = 0;

            $time = $wakeUp;
            $time2 = "01:00:00";
            $secs = strtotime($time2)-strtotime("00:00:00");
            $wakeUp = date("H:i:s",strtotime($time)-$secs);

            while($i <= 9){

                $time = $wakeUp;
                $time2 = "01:00:00";

                $secs = strtotime($time2)-strtotime("00:00:00");

                $result = date("H:i:s",strtotime($time)+$secs);

                $weekDayTimes[$i] = $result;

                $wakeUp = $result;

                $i++;

                echo "$result";
                
            }

            $one = $weekDayTimes[0];
            $two = $weekDayTimes[1];
            $three = $weekDayTimes[2];
            $four = $weekDayTimes[3];
            $five = $weekDayTimes[4];
            $six = $weekDayTimes[5];
            $seven = $weekDayTimes[6];
            $eight = $weekDayTimes[7];
            $nine = $weekDayTimes[8];
            $ten = $weekDayTimes[9];

            $email = $_SESSION["USERNAME"];

            $sql = "INSERT INTO week1 (email, monday1, monday2, monday3, monday4, monday5, monday6, monday7, monday8, monday9, monday10, tuesday1, tuesday2, tuesday3, tuesday4, tuesday5, tuesday6, tuesday7, tuesday8, tuesday9, tuesday10, wednesday1, wednesday2, wednesday3, wednesday4, wednesday5, wednesday6, wednesday7, wednesday8, wednesday9, wednesday10, thursday1, thursday2, thursday3, thursday4, thursday5, thursday6, thursday7, thursday8, thursday9, thursday10, friday1, friday2, friday3, friday4, friday5, friday6, friday7, friday8, friday9, friday10, saturday1, saturday2, saturday3, saturday4, saturday5, saturday6, saturday7, saturday8, saturday9, saturday10, sunday1, sunday2, sunday3, sunday4, sunday5, sunday6, sunday7, sunday8, sunday9, sunday10) VALUES ('$email', '$one', '$two', '$three', '$four', '$five', '$six', '$seven', '$eight', '$nine', '$ten', '$one', '$two', '$three', '$four', '$five', '$six', '$seven', '$eight', '$nine', '$ten', '$one', '$two', '$three', '$four', '$five', '$six', '$seven', '$eight', '$nine', '$ten', '$one', '$two', '$three', '$four', '$five', '$six', '$seven', '$eight', '$nine', '$ten', '$one', '$two', '$three', '$four', '$five', '$six', '$seven', '$eight', '$nine', '$ten', '$one', '$two', '$three', '$four', '$five', '$six', '$seven', '$eight', '$nine', '$ten', '$one', '$two', '$three', '$four', '$five', '$six', '$seven', '$eight', '$nine', '$ten')";

            $results = pg_query($conn, $sql);

            if(!$results){
                $_SESSION["ERROR"] .= "There was an error inserting values into week1";
                header("location:./index.php");
            }

            $sql = "INSERT INTO week2 (email, monday1, monday2, monday3, monday4, monday5, monday6, monday7, monday8, monday9, monday10, tuesday1, tuesday2, tuesday3, tuesday4, tuesday5, tuesday6, tuesday7, tuesday8, tuesday9, tuesday10, wednesday1, wednesday2, wednesday3, wednesday4, wednesday5, wednesday6, wednesday7, wednesday8, wednesday9, wednesday10, thursday1, thursday2, thursday3, thursday4, thursday5, thursday6, thursday7, thursday8, thursday9, thursday10, friday1, friday2, friday3, friday4, friday5, friday6, friday7, friday8, friday9, friday10, saturday1, saturday2, saturday3, saturday4, saturday5, saturday6, saturday7, saturday8, saturday9, saturday10, sunday1, sunday2, sunday3, sunday4, sunday5, sunday6, sunday7, sunday8, sunday9, sunday10) VALUES ('$email', '$one', '$two', '$three', '$four', '$five', '$six', '$seven', '$eight', '$nine', '$ten', '$one', '$two', '$three', '$four', '$five', '$six', '$seven', '$eight', '$nine', '$ten', '$one', '$two', '$three', '$four', '$five', '$six', '$seven', '$eight', '$nine', '$ten', '$one', '$two', '$three', '$four', '$five', '$six', '$seven', '$eight', '$nine', '$ten', '$one', '$two', '$three', '$four', '$five', '$six', '$seven', '$eight', '$nine', '$ten', '$one', '$two', '$three', '$four', '$five', '$six', '$seven', '$eight', '$nine', '$ten', '$one', '$two', '$three', '$four', '$five', '$six', '$seven', '$eight', '$nine', '$ten')";

            $results = pg_query($conn, $sql);

            if(!$results){
                $_SESSION["ERROR"] .= "There was an error inserting values into week2";
                header("location:./index.php");
            }

            $conn = db_connect();

            $email = $_SESSION["USERNAME"];

            $sql = "UPDATE users SET status = 'y' WHERE email = '$email'";

            $results = pg_query($conn, $sql);

            if(!$results){
                $_SESSION["ERROR"] .= "An error occured while updating the user.";
            }

            $_SESSION["STATUS"] = "y";

            if($_SESSION["ERROR"] == ""){
                $_SESSION["ERROR"] .= "You have successfully started the challenge!  The challenge will commence tomorrow at the time you set!";
                header("location:./progress.php");
            }
        
    }else{

        $_SESSION["ERROR"] .= "Please fill in every field, no fields should be left blank!";
    }
    
    // $_SESSION["ERROR"] = "You have successfully started the challenge with no measurements!  The challenge will commence tomorrow at the time you set!";
    //             header("location:./index.php");
} 
?>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" align="center">
	<!-- <div class="jumbotron" style="background-color: var(--primary); box-shadow: var(--shadow);"> -->
    <div class="box">
		<!-- <h1 align="center">Welcome to Easy CRPC</h1>
		<hr style="border-top: 1px solid black;" /> -->
		<ul style="list-style-type:none;">
			<!-- <li><h4>Step One</h4> <p style="color: black;">Select a contact method</p></li>
			<div class="form-group">
            <div class="col-4" style="left:35%;">
            	<input type="text" class="form-control" placeholder=" (e = email, p = phone)" required="required" name="contactMethod" style="text-align: center;">
            </div>
        	</div>
            <br />
            <br /> -->
            <li><h4>Step One</h4> <p>Do as many push-ups as possible in a row and enter your result</p></li>
			<div class="form-group">
            <div class="col-4" style="left:35%;">
            	<input type="text" class="form-control" placeholder="# of push-ups" required="required" name="pushUps" style="text-align: center;">
            </div>
        	</div>
            <br />
            <br />
            
            <li><h4>Step Two (Optional) <input type="checkbox" name="colorCheckbox" value="form-group 1"></h4> 
            <p>Measure your right and left biceps, chest and weight. (Biceps &amp; Chest measurements should be in inches - Weight measurement should be in pounds)</p></li>
            
			<div class="form-group 1">
            	<div class="row">

            		<div class="col-2">
            		</div>
            		<div class="col-4">
		            	<input type="text" class="form-control" placeholder="Left Bicep &Prime;" name="leftBicep" style="text-align: center;">
		            </div>


		            <div class="col-4">
		            	<input type="text" class="form-control" placeholder="Right Bicep &Prime;" name="rightBicep" style="text-align: center;">
		            </div>
            	</div>
                <div class="row">

                    <div class="col-2">
                    </div>
                    <div class="col-4">
                        <input type="text" class="form-control" placeholder="Chest &Prime;" name="chest" style="text-align: center;">
                    </div>


                    <div class="col-4">
                        <input type="text" class="form-control" placeholder="Weight (pounds)" name="weight" style="text-align: center;">
                    </div>
                </div>
            </div>
            <br />
            <br />
            <li><h4>Step Three</h4> <p>Enter a time that you can conisistantly start the challenge each day!  From this start point, the challenge will persist for 10 hours each day!</p></li>
            <div class="form-group">
                <div class="row">

                    <div class="col-4">
                    </div>
                    <div class="col-4">
                        <input type="time" id="wakeUp" name="wakeUp" required>
                    </div>


                    <!-- <div class="col-4">
                        <input type="time" id="sleep" name="sleep" required>
                    </div> -->

                </div>
                <br />
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Submit Information</button>
                </div>
            </div>
        </div>
		</ul>
        </div>
	<!-- </div> -->

</form>
<?php
include "./footer.php";
?>