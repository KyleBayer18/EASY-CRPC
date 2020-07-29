<?php
include "./header.php";

$email = $_SESSION["USERNAME"];

$conn = db_connect();

$sql = "SELECT * FROM measurements WHERE email = '$email'";

$results = pg_query($conn, $sql);

while($row = pg_fetch_assoc($results)){
    $isStarted = $row["is_started"];
}

$rows = pg_num_rows($results);

if($_SESSION["USERNAME"] == ""){
	header("location:./index.php");
}elseif(!isset($_SESSION["USERNAME"])){
	header("location:./index.php");
}

if($rows == 0){
	header("location:./measurements.php");
}

// echo "IS STARTED !! $isStarted";

if ($_SERVER["REQUEST_METHOD"] == "GET")
{
    
}
else if ($_SERVER["REQUEST_METHOD"] == "POST"){
	$_SESSION["ERROR"] = "";
	if(isset($_POST["leftBicep"])){
		$newLB = trim($_POST["leftBicep"]);
		$newRB = trim($_POST["rightBicep"]);
		$newC = trim($_POST["chest"]);
		$newW = trim($_POST["weight"]);
		$email = $_SESSION["USERNAME"];

		if($newLB < 1){
			$_SESSION["ERROR"] .= "Pleae enter a valid number for left bicep. <br />";
		}
		if($newRB < 1){
			$_SESSION["ERROR"] .= "Plese enter a valid number for right bicep. <br />";
		}
		if($newC < 1){
			$_SESSION["ERROR"] .= "Plese enter a valid number for chest. <br />";
		}
		if($newW < 1){
			$_SESSION["ERROR"] .= "Please enter a valid number for weight. <br />.";
		}

		$conn = db_connect();

		$sql = "SELECT * FROM measurements WHERE email = '$email'";

		$results = pg_query($conn, $sql);

		while($row = pg_fetch_assoc($results)){
			$leftBicep = $row["leftbicep"];
			$rightBicep = $row["rightbicep"];
			$chest = $row["chest"];
			$weight = $row["weight"];
		}
		$newLB = $newLB - $leftBicep;
		$newRB = $newRB - $rightBicep;
		$newC = $newC - $chest;
		$newW = $newW - $weight;

		if($_SESSION["ERROR"] == ""){
			$_SESSION["twitter"] = "YES";
		}else{
			$_SESSION["twitter"] = "NO";
			header("Refresh:0");
		}
	}else{
		
    
		$username = $_SESSION["USERNAME"];

		$conn = db_connect();

		$sql = "UPDATE measurements SET is_started = 'CANCEL' WHERE email = '$username'";

		$results = pg_query($conn, $sql);

		if(!$results){
			$_SESSION["ERROR"] = "There was an error while canceling your challenge!";
		}else{
			$_SESSION["ERROR"] = "Your challenge has been canceled!";
		}
		
		$sqlWeek1 = "UPDATE week1 SET monday1 = 'YES', monday2 = 'YES', monday3 = 'YES', monday4 = 'YES', monday5 = 'YES', monday6 = 'YES', monday7 = 'YES', monday8 = 'YES', monday9 = 'YES', monday10 = 'YES', tuesday1 = 'YES', tuesday2 = 'YES', tuesday3 = 'YES', tuesday4 = 'YES', tuesday5 = 'YES', tuesday6 = 'YES', tuesday7 = 'YES', tuesday8 = 'YES', tuesday9 = 'YES', tuesday10 = 'YES', wednesday1 = 'YES', wednesday2 = 'YES', wednesday3 = 'YES', wednesday4 = 'YES', wednesday5 = 'YES', wednesday6 = 'YES', wednesday7 = 'YES', wednesday8 = 'YES', wednesday9 = 'YES', wednesday10 = 'YES', thursday1 = 'YES', thursday2 = 'YES', thursday3 = 'YES', thursday4 = 'YES', thursday5 = 'YES', thursday6 = 'YES', thursday7 = 'YES', thursday8 = 'YES', thursday9 = 'YES', thursday10 = 'YES', friday1 = 'YES', friday2 = 'YES', friday3 = 'YES', friday4 = 'YES', friday5 = 'YES', friday6 = 'YES', friday7 = 'YES', friday8 = 'YES', friday9 = 'YES', friday10 = 'YES', saturday1 = 'YES', saturday2 = 'YES', saturday3 = 'YES', saturday4 = 'YES', saturday5 = 'YES', saturday6 = 'YES', saturday7 = 'YES', saturday8 = 'YES', saturday9 = 'YES', saturday10 = 'YES', sunday1 = 'YES', sunday2 = 'YES', sunday3 = 'YES', sunday4 = 'YES', sunday5 = 'YES', sunday6 = 'YES', sunday7 = 'YES', sunday8 = 'YES', sunday9 = 'YES', sunday10 = 'YES', finished = 'CANCEL'";
		
		$results = pg_query($conn, $sqlWeek1);
		
		if(!$results){
			$_SESSION["ERROR"] = "There was an error updating week1";
		}
		
		$sqlWeek2 = "UPDATE week2 SET monday1 = 'YES', monday2 = 'YES', monday3 = 'YES', monday4 = 'YES', monday5 = 'YES', monday6 = 'YES', monday7 = 'YES', monday8 = 'YES', monday9 = 'YES', monday10 = 'YES', tuesday1 = 'YES', tuesday2 = 'YES', tuesday3 = 'YES', tuesday4 = 'YES', tuesday5 = 'YES', tuesday6 = 'YES', tuesday7 = 'YES', tuesday8 = 'YES', tuesday9 = 'YES', tuesday10 = 'YES', wednesday1 = 'YES', wednesday2 = 'YES', wednesday3 = 'YES', wednesday4 = 'YES', wednesday5 = 'YES', wednesday6 = 'YES', wednesday7 = 'YES', wednesday8 = 'YES', wednesday9 = 'YES', wednesday10 = 'YES', thursday1 = 'YES', thursday2 = 'YES', thursday3 = 'YES', thursday4 = 'YES', thursday5 = 'YES', thursday6 = 'YES', thursday7 = 'YES', thursday8 = 'YES', thursday9 = 'YES', thursday10 = 'YES', friday1 = 'YES', friday2 = 'YES', friday3 = 'YES', friday4 = 'YES', friday5 = 'YES', friday6 = 'YES', friday7 = 'YES', friday8 = 'YES', friday9 = 'YES', friday10 = 'YES', saturday1 = 'YES', saturday2 = 'YES', saturday3 = 'YES', saturday4 = 'YES', saturday5 = 'YES', saturday6 = 'YES', saturday7 = 'YES', saturday8 = 'YES', saturday9 = 'YES', saturday10 = 'YES', sunday1 = 'YES', sunday2 = 'YES', sunday3 = 'YES', sunday4 = 'YES', sunday5 = 'YES', sunday6 = 'YES', sunday7 = 'YES', sunday8 = 'YES', sunday9 = 'YES', sunday10 = 'YES', finished = 'CANCEL'";

		$results = pg_query($conn, $sqlWeek2);
		
		if(!$results){
			$_SESSION["ERROR"] .= "There was an error updating week2";
		}else{
			$_SESSION["ERROR"] = "Wow, we really had faith in you.. Welp, see you on the wall of shame!";
		}
		
		header("Refresh:0");
		}

		$Twitter = $_SESSION["twitter"];
    
}
?>
<div class="container">
	<div class="row">
		<div class="col-md">
			<div class="box">
				<h1 align="center">Week 1</h1>
				<hr />
				<?php
					$email = $_SESSION["USERNAME"];

					$conn = db_connect();

					$sql = "SELECT * FROM week1 WHERE email = '$email'";

					$results = pg_query($conn, $sql);

					if(!$results){
						$_SESSION["ERROR"] .= "There was an error retreiving your week 1 statistics.";
					}

					while($row = pg_fetch_assoc($results)){
						$monday1 = $row["monday1"];
						$monday2 = $row["monday2"];
						$monday3 = $row["monday3"];
						$monday4 = $row["monday4"];
						$monday5 = $row["monday5"];
						$monday6 = $row["monday6"];
						$monday7 = $row["monday7"];
						$monday8 = $row["monday8"];
						$monday9 = $row["monday9"];
						$monday10 = $row["monday10"];

						$tuesday1 = $row["tuesday1"];
						$tuesday2 = $row["tuesday2"];
						$tuesday3 = $row["tuesday3"];
						$tuesday4 = $row["tuesday4"];
						$tuesday5 = $row["tuesday5"];
						$tuesday6 = $row["tuesday6"];
						$tuesday7 = $row["tuesday7"];
						$tuesday8 = $row["tuesday8"];
						$tuesday9 = $row["tuesday9"];
						$tuesday10 = $row["tuesday10"];

						$wednesday1 = $row["wednesday1"];
						$wednesday2 = $row["wednesday2"];
						$wednesday3 = $row["wednesday3"];
						$wednesday4 = $row["wednesday4"];
						$wednesday5 = $row["wednesday5"];
						$wednesday6 = $row["wednesday6"];
						$wednesday7 = $row["wednesday7"];
						$wednesday8 = $row["wednesday8"];
						$wednesday9 = $row["wednesday9"];
						$wednesday10 = $row["wednesday10"];

						$thursday1 = $row["thursday1"];
						$thursday2 = $row["thursday2"];
						$thursday3 = $row["thursday3"];
						$thursday4 = $row["thursday4"];
						$thursday5 = $row["thursday5"];
						$thursday6 = $row["thursday6"];
						$thursday7 = $row["thursday7"];
						$thursday8 = $row["thursday8"];
						$thursday9 = $row["thursday9"];
						$thursday10 = $row["thursday10"];

						$friday1 = $row["friday1"];
						$friday2 = $row["friday2"];
						$friday3 = $row["friday3"];
						$friday4 = $row["friday4"];
						$friday5 = $row["friday5"];
						$friday6 = $row["friday6"];
						$friday7 = $row["friday7"];
						$friday8 = $row["friday8"];
						$friday9 = $row["friday9"];
						$friday10 = $row["friday10"];

						$saturday1 = $row["saturday1"];
						$saturday2 = $row["saturday2"];
						$saturday3 = $row["saturday3"];
						$saturday4 = $row["saturday4"];
						$saturday5 = $row["saturday5"];
						$saturday6 = $row["saturday6"];
						$saturday7 = $row["saturday7"];
						$saturday8 = $row["saturday8"];
						$saturday9 = $row["saturday9"];
						$saturday10 = $row["saturday10"];

						$sunday1 = $row["sunday1"];
						$sunday2 = $row["sunday2"];
						$sunday3 = $row["sunday3"];
						$sunday4 = $row["sunday4"];
						$sunday5 = $row["sunday5"];
						$sunday6 = $row["sunday6"];
						$sunday7 = $row["sunday7"];
						$sunday8 = $row["sunday8"];
						$sunday9 = $row["sunday9"];
						$sunday10 = $row["sunday10"];

						$finished = $row["finished"];
						
                        if($finished == "CANCEL"){
						    echo "<div class='progress'>
								  <div class='progress-bar bg-danger' role='progressbar' aria-valuenow='100'
								  aria-valuemin='0' aria-valuemax='100' style='width:100%'>
								    <span class='sr-only'>100% Complete</span>
								  </div>
								</div>";
						}elseif($monday1 != "YES"){
							echo "<h6 align='center'>Your challenge has not started yet!</h6>";
						}elseif($monday1 == "YES" && $monday10 != "YES"){
							echo "<div class='progress'>
								  <div class='progress-bar bg-danger' role='progressbar' aria-valuenow='14'
								  aria-valuemin='0' aria-valuemax='100' style='width:14%'>
								    <span class='sr-only'>14% Complete</span>
								  </div>
								</div>";
						}elseif($tuesday1 == "YES" && $wednesday10 != "YES"){
							echo "<div class='progress'>
								  <div class='progress-bar bg-warning' role='progressbar' aria-valuenow='28'
								  aria-valuemin='0' aria-valuemax='100' style='width:28%'>
								    <span class='sr-only'>28% Complete</span>
								  </div>
								</div>";
						}elseif($wednesday1 == "YES" && $thursday10 != "YES"){
							echo "<div class='progress'>
								  <div class='progress-bar bg-warning' role='progressbar' aria-valuenow='42'
								  aria-valuemin='0' aria-valuemax='100' style='width:42%'>
								    <span class='sr-only'>42% Complete</span>
								  </div>
								</div>";
						}elseif($thursday1 == "YES" && $friday10 != "YES"){
							echo "<div class='progress'>
								  <div class='progress-bar bg-info' role='progressbar' aria-valuenow='57'
								  aria-valuemin='0' aria-valuemax='100' style='width:57%'>
								    <span class='sr-only'>57% Complete</span>
								  </div>
								</div>";
						}elseif($friday1 == "YES" && $friday10 != "YES"){
							echo "<div class='progress'>
								  <div class='progress-bar bg-success' role='progressbar' aria-valuenow='71'
								  aria-valuemin='0' aria-valuemax='100' style='width:71%'>
								    <span class='sr-only'>71% Complete</span>
								  </div>
								</div>";
						}elseif($saturday1 == "YES" && $sunday10 != "YES"){
							echo "<div class='progress'>
								  <div class='progress-bar bg-success' role='progressbar' aria-valuenow='85'
								  aria-valuemin='0' aria-valuemax='100' style='width:85%'>
								    <span class='sr-only'>85% Complete</span>
								  </div>
								</div>";
						}elseif($sunday1 == "YES" && $finished != "YES"){
							echo "<div class='progress'>
								  <div class='progress-bar bg-success' role='progressbar' aria-valuenow='92'
								  aria-valuemin='0' aria-valuemax='100' style='width:92%'>
								    <span class='sr-only'>92% Complete</span>
								  </div>
								</div>";
						}elseif($finished == "YES"){
							echo "<div class='progress'>
								  <div class='progress-bar bg-success' role='progressbar' aria-valuenow='100'
								  aria-valuemin='0' aria-valuemax='100' style='width:100%'>
								    <span class='sr-only'>100% Complete</span>
								  </div>
								</div>";
						}
					}

				?>
				<hr />
			</div>
		</div>
		<div class="col-md">
			<div class="box">
				<h1 align="center">Week 2</h1>
				<hr />
				<?php
					$email = $_SESSION["USERNAME"];

					$conn = db_connect();

					$sql = "SELECT * FROM week2 WHERE email = '$email'";

					$results = pg_query($conn, $sql);

					if(!$results){
						$_SESSION["ERROR"] .= "There was an error retreiving your week 1 statistics.";
					}

					while($row = pg_fetch_assoc($results)){
						$monday1 = $row["monday1"];
						$monday2 = $row["monday2"];
						$monday3 = $row["monday3"];
						$monday4 = $row["monday4"];
						$monday5 = $row["monday5"];
						$monday6 = $row["monday6"];
						$monday7 = $row["monday7"];
						$monday8 = $row["monday8"];
						$monday9 = $row["monday9"];
						$monday10 = $row["monday10"];

						$tuesday1 = $row["tuesday1"];
						$tuesday2 = $row["tuesday2"];
						$tuesday3 = $row["tuesday3"];
						$tuesday4 = $row["tuesday4"];
						$tuesday5 = $row["tuesday5"];
						$tuesday6 = $row["tuesday6"];
						$tuesday7 = $row["tuesday7"];
						$tuesday8 = $row["tuesday8"];
						$tuesday9 = $row["tuesday9"];
						$tuesday10 = $row["tuesday10"];

						$wednesday1 = $row["wednesday1"];
						$wednesday2 = $row["wednesday2"];
						$wednesday3 = $row["wednesday3"];
						$wednesday4 = $row["wednesday4"];
						$wednesday5 = $row["wednesday5"];
						$wednesday6 = $row["wednesday6"];
						$wednesday7 = $row["wednesday7"];
						$wednesday8 = $row["wednesday8"];
						$wednesday9 = $row["wednesday9"];
						$wednesday10 = $row["wednesday10"];

						$thursday1 = $row["thursday1"];
						$thursday2 = $row["thursday2"];
						$thursday3 = $row["thursday3"];
						$thursday4 = $row["thursday4"];
						$thursday5 = $row["thursday5"];
						$thursday6 = $row["thursday6"];
						$thursday7 = $row["thursday7"];
						$thursday8 = $row["thursday8"];
						$thursday9 = $row["thursday9"];
						$thursday10 = $row["thursday10"];

						$friday1 = $row["friday1"];
						$friday2 = $row["friday2"];
						$friday3 = $row["friday3"];
						$friday4 = $row["friday4"];
						$friday5 = $row["friday5"];
						$friday6 = $row["friday6"];
						$friday7 = $row["friday7"];
						$friday8 = $row["friday8"];
						$friday9 = $row["friday9"];
						$friday10 = $row["friday10"];

						$saturday1 = $row["saturday1"];
						$saturday2 = $row["saturday2"];
						$saturday3 = $row["saturday3"];
						$saturday4 = $row["saturday4"];
						$saturday5 = $row["saturday5"];
						$saturday6 = $row["saturday6"];
						$saturday7 = $row["saturday7"];
						$saturday8 = $row["saturday8"];
						$saturday9 = $row["saturday9"];
						$saturday10 = $row["saturday10"];

						$sunday1 = $row["sunday1"];
						$sunday2 = $row["sunday2"];
						$sunday3 = $row["sunday3"];
						$sunday4 = $row["sunday4"];
						$sunday5 = $row["sunday5"];
						$sunday6 = $row["sunday6"];
						$sunday7 = $row["sunday7"];
						$sunday8 = $row["sunday8"];
						$sunday9 = $row["sunday9"];
						$sunday10 = $row["sunday10"];

						$finished = $row["finished"];

						if($finished == "CANCEL"){
						    echo "<div class='progress'>
								  <div class='progress-bar bg-danger' role='progressbar' aria-valuenow='100'
								  aria-valuemin='0' aria-valuemax='100' style='width:100%'>
								    <span class='sr-only'>100% Complete</span>
								  </div>
								</div>";
						}elseif($monday1 != "YES"){
							echo "<h6 align='center'>Week two has not started yet!</h6>";
						}elseif($monday1 == "YES" && $monday10 != "YES"){
							echo "<div class='progress'>
								  <div class='progress-bar bg-danger' role='progressbar' aria-valuenow='14'
								  aria-valuemin='0' aria-valuemax='100' style='width:14%'>
								    <span class='sr-only'>14% Complete</span>
								  </div>
								</div>";
						}elseif($tuesday1 == "YES" && $wednesday10 != "YES"){
							echo "<div class='progress'>
								  <div class='progress-bar bg-warning' role='progressbar' aria-valuenow='28'
								  aria-valuemin='0' aria-valuemax='100' style='width:28%'>
								    <span class='sr-only'>28% Complete</span>
								  </div>
								</div>";
						}elseif($wednesday1 == "YES" && $thursday10 != "YES"){
							echo "<div class='progress'>
								  <div class='progress-bar bg-warning' role='progressbar' aria-valuenow='42'
								  aria-valuemin='0' aria-valuemax='100' style='width:42%'>
								    <span class='sr-only'>42% Complete</span>
								  </div>
								</div>";
						}elseif($thursday1 == "YES" && $friday10 != "YES"){
							echo "<div class='progress'>
								  <div class='progress-bar bg-info' role='progressbar' aria-valuenow='57'
								  aria-valuemin='0' aria-valuemax='100' style='width:57%'>
								    <span class='sr-only'>57% Complete</span>
								  </div>
								</div>";
						}elseif($friday1 == "YES" && $friday10 != "YES"){
							echo "<div class='progress'>
								  <div class='progress-bar bg-success' role='progressbar' aria-valuenow='71'
								  aria-valuemin='0' aria-valuemax='100' style='width:71%'>
								    <span class='sr-only'>71% Complete</span>
								  </div>
								</div>";
						}elseif($saturday1 == "YES" && $sunday10 != "YES"){
							echo "<div class='progress'>
								  <div class='progress-bar bg-success' role='progressbar' aria-valuenow='85'
								  aria-valuemin='0' aria-valuemax='100' style='width:85%'>
								    <span class='sr-only'>85% Complete</span>
								  </div>
								</div>";
						}elseif($sunday1 == "YES" && $finished != "YES"){
							echo "<div class='progress'>
								  <div class='progress-bar bg-success' role='progressbar' aria-valuenow='92'
								  aria-valuemin='0' aria-valuemax='100' style='width:92%'>
								    <span class='sr-only'>92% Complete</span>
								  </div>
								</div>";
						}elseif($finished == "YES"){
							echo "<div class='progress'>
								  <div class='progress-bar bg-success' role='progressbar' aria-valuenow='100'
								  aria-valuemin='0' aria-valuemax='100' style='width:100%'>
								    <span class='sr-only'>100% Complete</span>
								  </div>
								</div>";
						}
					}
				?>
				<hr />
			</div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col text-center">
    		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" align="center">
				<div class="form-group">
					<?php
					    $conn = db_connect();
					    
					    $sql = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
					    
					    $results = pg_query($conn, $sql);
					    
					    while($row = pg_fetch_assoc($results)){
					        $hash = $row["hash"];
					        if($isStarted == "FINISH" && $Twitter != "YES"){
								echo "<div class='box'><h4 class='text-center'>Update Finished Measurements</h4>       
							<div class='form-group'>
								<input type='text' class='form-control' placeholder='Left Bicep' required='required' name='leftBicep'>
							</div>
							<div class='form-group'>
								<input type='text' class='form-control' placeholder='Right Bicep' required='required' name='rightBicep'>
							</div>
							<div class='form-group'>
								<input type='text' class='form-control' placeholder='Chest' required='required' name='chest'>
							</div>
							<div class='form-group'>
								<input type='text' class='form-control' placeholder='Weight' required='required' name='weight'>
							</div>
							<div class='form-group'>
								<button type='submit' class='btn'>Submit</button>
							</div></div>";
							}elseif($Twitter == "YES"){
							}elseif($isStarted == "CANCEL"){
                            echo "<a href='./delete.php?id=$hash' class='btn' style='width:100%;'>DELETE ACCOUNT</a>";
    						}else{
    							echo "<button type='submit' class='btn btn-danger btn-block' style='width: 100%;'>Cancel Program</button>";
    						}
					    }
					?>
		            
		        </div>
		    </form>
		</div>
	</div>
	<div class="row">
		<div class="col-lg">
			<div class="box">
				<h1 align="center">Your Challenge Data</h1>
				<hr />
				<?php
					$email = $_SESSION["USERNAME"];

					$conn = db_connect();

					$sql = "SELECT * FROM measurements WHERE email = '$email'";

					$results = pg_query($conn, $sql);

					if(!$results){
						$_SESSION["ERROR"] .= "There was an error retreiving your measurements!";
					}

					while($row = pg_fetch_assoc($results)){
						$leftBicep = $row["leftbicep"];
						$rightBicep = $row["rightbicep"];
						$chest = $row["chest"];
						$weight = $row["weight"];
						$maxPushUps = $row["maxpushups"];
						$startTime = $row["wakeuptime"];
						$startDate = $row["started_at"];
						$isStarted = $row["is_started"];

						if($isStarted == "FINISH" && $leftBicep == "66" && $rightBicep == "66"){
							echo "<h4>Congrats on Completion!  Share your success below!</h4>";
							echo "<a href='https://twitter.com/intent/tweet?button_hashtag=EASYCRPC&ref_src=twsrc%5Etfw' class='twitter-hashtag-button' data-text='I&#39;ve just completed the &#39;Crazy Russian Push-up Program&#39; with EASY-CRPC. http://easy-crpc.com' data-show-count='false'>Tweet #EASYCRPC</a><script async src='https://platform.twitter.com/widgets.js' charset='utf-8'></script>";
						}elseif($isStarted == "FINISH" && $leftBicep != "66" && $rightBicep != "66"){
							echo "<h4>Congrats on Completion!  Share your success below!</h4>";
							echo "<a href='https://twitter.com/intent/tweet?button_hashtag=EASYCRPC&ref_src=twsrc%5Etfw' class='twitter-hashtag-button' data-text='I&#39;ve just completed the &#39;Crazy Russian Push-up Program&#39; with EASY-CRPC http://easy-crpc.com.  Statistics - Left Bicep: +$newLB &quot;, Right Bicep: +$newRB &quot;, Chest: +$newC &quot; Weight: +$newW &quot;' data-show-count='false'>Tweet #EASYCRPC</a><script async src='https://platform.twitter.com/widgets.js' charset='utf-8'></script>";
						
						}else{
							if($leftBicep == "66" && $rightBicep == "66"){
								echo "<h6 align='center'>Maximum Pushups: $maxPushUps </h6>";
								echo "<h6 align='center'>Starting Time: $startTime (24 hour format)</h6>";
								echo "<h6 align='center'>Start Date: $startDate </h6>";
							}else {
								echo "<h6 align='center'>Left Bicep: $leftBicep &Prime;</h6>";
								echo "<h6 align='center'>Right Bicep: $rightBicep &Prime;</h6>";
								echo "<h6 align='center'>Chest: $chest &Prime;</h6>";
								echo "<h6 align='center'>Weight: $weight Lb</h6>";
								echo "<h6 align='center'>Maximum Pushups: $maxPushUps </h6>";
								echo "<h6 align='center'>Starting Time: $startTime (24 hour format)</h6>";
								echo "<h6 align='center'>Start Date: $startDate </h6>";
							}
							
	
							if($isStarted == "NO"){
								$message = "Your challenge will start tomorrow!";
							}elseif($isStarted == "YES"){
								$message = "Your challenge has already started.";
							}elseif($isStarted == "CANCEL"){
								$message = "Wow, you canceled so soon? Feelsbad..";
								echo "";
							}elseif($isStarted == "FINISH"){
								$message = "Congratulations on completing the program!";
							}else{
								$message = "Your challenge is currently in progress!";
							}
							echo "<h6 align='center'>Has your challenge started?: $message </h6>";
						}
                        

					}
				?>
			</div>
			</div>
		</div>
	</div>

</div>
<?php
include "./footer.php";
?>