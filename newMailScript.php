<?php
include "./header.php";

//get all measurement table data
$conn = db_connect();

$sql = "SELECT * FROM measurements";

$measurementsTable = pg_query($conn, $sql);

if (!$measurementsTable)
{
    $_SESSION["ERROR"] .= "There was an error getting measurement data";
}

//perform actions on all measurement table records
while ($row = pg_fetch_assoc($measurementsTable))
{

    //these variables store data for individual user's measurements.  All users will be looped through
    $email = $row["email"];
    $pushUpMax = $row["maxpushups"];
    $status = $row["is_started"];
    $startDate = $row["started_at"];

    //TODAY'S DATE AND TIME
    date_default_timezone_set('America/Toronto');
    $todays_date = date("Y-m-d");
    $todays_time = date("H:i:s");
    
    $day1 = date('Y-m-d', strtotime('+1 day', strtotime($startDate)));
    $day2 = date('Y-m-d', strtotime('+2 day', strtotime($startDate)));
    $day3 = date('Y-m-d', strtotime('+3 day', strtotime($startDate)));
    $day4 = date('Y-m-d', strtotime('+4 day', strtotime($startDate)));
    $day5 = date('Y-m-d', strtotime('+5 day', strtotime($startDate)));
    $day6 = date('Y-m-d', strtotime('+6 day', strtotime($startDate)));
    $day7 = date('Y-m-d', strtotime('+7 day', strtotime($startDate)));
    $day8 = date('Y-m-d', strtotime('+8 day', strtotime($startDate)));
    $day9 = date('Y-m-d', strtotime('+9 day', strtotime($startDate)));
    $day10 = date('Y-m-d', strtotime('+10 day', strtotime($startDate)));
    $day11 = date('Y-m-d', strtotime('+11 day', strtotime($startDate)));
    $day12 = date('Y-m-d', strtotime('+12 day', strtotime($startDate)));
    $day13 = date('Y-m-d', strtotime('+13 day', strtotime($startDate)));
    $day14 = date('Y-m-d', strtotime('+14 day', strtotime($startDate)));

    echo "-------------- $todays_time------------- $email";
    //If today's date is greater than the start date then do
    if ($todays_date == $startDate)
    {
        echo "$email , your challenge will start tomorrow!";

    }
    if ($todays_date > $startDate)
    {
        //if status == no, the user has not started the challenge
        if ($status == "NO")
        {
            //set challenge to start on monday week1
            echo "$email , Your challenge has started!";
            $newStatus = "1Monday";

            $conn = db_connect();

            $sql = "UPDATE measurements SET is_started = '$newStatus' WHERE email = '$email'";

            $results = pg_query($conn, $sql);

            if (!$results)
            {
                $_SESSION["ERROR"] .= "There was an error updating your status.";
            }
        }
        elseif ($status == "1Monday" && $todays_date == $day1)
        {
            $conn = db_connect();

            $sql1 = "SELECT * FROM week1 WHERE email = '$email'";

            //RESULTS OF ALL WEEK1 USER DATA
            $week1 = pg_query($conn, $sql1);

            echo "$email you have status == 1Monday";
            if (!$week1)
            {
                $_SESSION["ERROR"] = "There was an error recieving data from week1";
            }
            

            //PUTTING ALL WEEK1 DATA FOR SPECIFIC USER IN VARIABLES.
            while ($row = pg_fetch_assoc($week1))
            {
                $email = $row["email"];
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
echo "$email $monday1 monday1";
                if ($monday1 != "YES")
                {
                    echo "$email -- line 106";
                    if ($monday1 < $todays_time)
                    {
                        echo "$email -- line 109";
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .30);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

                            $a = mail($to, $subject, $message, $headers);
                        
                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET monday1 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 monday1";
                            }
                        }

                    }
                }
                elseif ($monday2 != "YES")
                {
                    if ($monday2 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .30);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET monday2 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 monday1";
                            }
                        }

                    }
                }
                elseif ($monday3 != "YES")
                {
                    if ($monday3 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .30);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET monday3 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 monday3";
                            }
                        }
                    }

                }
                elseif ($monday4 != "YES")
                {
                    if ($monday4 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .30);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET monday4 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 monday4";
                            }
                        }
                    }
                }
                elseif ($monday5 != "YES")
                {
                    if ($monday5 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .30);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET monday5 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 monday5";
                            }
                        }
                    }
                }
                elseif ($monday6 != "YES")
                {
                    if ($monday6 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .30);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            
                            
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET monday6 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 monday6";
                            }
                        }
                    }
                }
                elseif ($monday7 != "YES")
                {
                    if ($monday7 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .30);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET monday7 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 monday7";
                            }
                        }
                    }
                }
                elseif ($monday8 != "YES")
                {
                    if ($monday8 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .30);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET monday8 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 monday8";
                            }
                        }
                    }
                }
                elseif ($monday9 != "YES")
                {
                    if ($monday9 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .30);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET monday9 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 monday9";
                            }
                        }
                    }
                }
                elseif ($monday10 != "YES")
                {
                    if ($monday10 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .30);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $status = "1Tuesday";

                            $sql = "UPDATE week1 SET monday10 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 monday10";
                            }

                            $sql = "UPDATE measurements SET is_started = '$status' WHERE email = '$email'";

                            $result = pg_query($conn, $sql);

                            if (!$result)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating your measurement status.";
                            }
                        }
                    }
                }
            }
        }
        elseif ($status == "1Tuesday" && $todays_date == $day2)
        {
            $conn = db_connect();

            $sql1 = "SELECT * FROM week1 WHERE email = '$email'";
            // echo "SQL LINE 653: $sql1";
            //RESULTS OF ALL WEEK1 USER DATA
            $week1 = pg_query($conn, $sql1);

            if (!$week1)
            {
                echo "There was an error recieving data from week1";
            }

            //PUTTING ALL WEEK1 DATA FOR SPECIFIC USER IN VARIABLES.
            while ($row = pg_fetch_assoc($week1))
            {
                // print_r(array_values($row));
                $email = $row["email"];
                echo "| EMAIL!!! $email |";
                $tuesday1 = $row["tuesday1"];
                echo "|Tuesday1 $tuesday1 |";
                $tuesday2 = $row["tuesday2"];
                $tuesday3 = $row["tuesday3"];
                $tuesday4 = $row["tuesday4"];
                $tuesday5 = $row["tuesday5"];
                $tuesday6 = $row["tuesday6"];
                $tuesday7 = $row["tuesday7"];
                $tuesday8 = $row["tuesday8"];
                $tuesday9 = $row["tuesday9"];
                $tuesday10 = $row["tuesday10"];

                if ($tuesday1 != "YES")
                {
                    if ($tuesday1 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .50);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET tuesday1 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 tuesday1";
                            }
                        }

                    }
                }
                elseif ($tuesday2 != "YES")
                {
                    if ($tuesday2 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .50);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET tuesday2 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                echo "There was an error updating week1 tuesday2";
                            }
                        }

                    }
                }
                elseif ($tuesday3 != "YES")
                {
                    if ($tuesday3 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .50);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET tuesday3 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 tuesday3";
                            }
                        }

                    }

                }
                elseif ($tuesday4 != "YES")
                {
                    if ($tuesday4 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .50);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET tuesday4 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 tuesday4";
                            }
                        }

                    }
                }
                elseif ($tuesday5 != "YES")
                {
                    if ($tuesday5 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .50);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET tuesday5 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 tuesday5";
                            }
                        }

                    }
                }
                elseif ($tuesday6 != "YES")
                {
                    if ($tuesday6 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .50);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET tuesday6 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 tuesday6";
                            }
                        }

                    }
                }
                elseif ($tuesday7 != "YES")
                {
                    if ($tuesday7 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .50);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET tuesday7 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 tuesday7";
                            }
                        }

                    }
                }
                elseif ($tuesday8 != "YES")
                {
                    if ($tuesday8 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .50);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET tuesday8 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 tuesday8";
                            }
                        }

                    }
                }
                elseif ($tuesday9 != "YES")
                {
                    if ($tuesday9 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .50);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET tuesday9 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 tuesday9";
                            }
                        }

                    }
                }
                elseif ($tuesday10 != "YES")
                {
                    if ($tuesday10 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .50);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $status = "1Wednesday";

                            $sql = "UPDATE week1 SET tuesday10 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 tuesday10";
                            }

                            $sql = "UPDATE measurements SET is_started = '$status' WHERE email = '$email'";

                            $result = pg_query($conn, $sql);

                            if (!$result)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating your measurement status.";
                            }
                        }

                    }
                }
            }
        }
        elseif ($status == "1Wednesday" && $todays_date == $day3)
        {
            $sql1 = "SELECT * FROM week1 WHERE email = '$email'";

            //RESULTS OF ALL WEEK1 USER DATA
            $week1 = pg_query($conn, $sql1);

            if (!$week1)
            {
                $_SESSION["ERROR"] = "There was an error recieving data from week1";
            }

            //PUTTING ALL WEEK1 DATA FOR SPECIFIC USER IN VARIABLES.
            while ($row = pg_fetch_assoc($week1))
            {
                $email = $row["email"];
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

                if ($wednesday1 != "YES")
                {
                    if ($wednesday1 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .25);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET wednesday1 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 wednesday1";
                            }
                        }

                    }
                }
                elseif ($wednesday2 != "YES")
                {
                    if ($wednesday2 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .25);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET wednesday2 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 wednesday2";
                            }
                        }

                    }
                }
                elseif ($wednesday3 != "YES")
                {
                    if ($wednesday3 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .25);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET wednesday3 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 wednesday3";
                            }
                        }
                    }

                }
                elseif ($wednesday4 != "YES")
                {
                    if ($wednesday4 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .25);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET wednesday4 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 wednesday4";
                            }
                        }
                    }
                }
                elseif ($wednesday5 != "YES")
                {
                    if ($wednesday5 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .25);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET wednesday5 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 wednesday5";
                            }
                        }
                    }
                }
                elseif ($wednesday6 != "YES")
                {
                    if ($wednesday6 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .25);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET wednesday6 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 wednesday6";
                            }
                        }
                    }
                }
                elseif ($wednesday7 != "YES")
                {
                    if ($wednesday7 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .25);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET wednesday7 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 wednesday7";
                            }
                        }
                    }
                }
                elseif ($wednesday8 != "YES")
                {
                    if ($wednesday8 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .25);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET wednesday8 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 wednesday8";
                            }
                        }
                    }
                }
                elseif ($wednesday9 != "YES")
                {
                    if ($wednesday9 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .25);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET wednesday9 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 wednesday9";
                            }
                        }
                    }
                }
                elseif ($wednesday10 != "YES")
                {
                    if ($wednesday10 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .25);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $status = "1Thursday";

                            $sql = "UPDATE week1 SET wednesday10 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 wednesday10";
                            }

                            $sql = "UPDATE measurements SET is_started = '$status' WHERE email = '$email'";

                            $result = pg_query($conn, $sql);

                            if (!$result)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating your measurement status.";
                            }
                        }
                    }
                }
            }
        }
        elseif ($status == "1Thursday" && $todays_date == $day4)
        {
            $sql1 = "SELECT * FROM week1 WHERE email = '$email'";

            //RESULTS OF ALL WEEK1 USER DATA
            $week1 = pg_query($conn, $sql1);

            if (!$week1)
            {
                $_SESSION["ERROR"] = "There was an error recieving data from week1";
            }

            //PUTTING ALL WEEK1 DATA FOR SPECIFIC USER IN VARIABLES.
            while ($row = pg_fetch_assoc($week1))
            {
                $email = $row["email"];
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

                if ($thursday1 != "YES")
                {
                    if ($thursday1 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .25);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET thursday1 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 thursday1";
                            }
                        }
                    }
                }
                elseif ($thursday2 != "YES")
                {
                    if ($thursday2 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .25);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET thursday2 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 thursday2";
                            }
                        }

                    }
                }
                elseif ($thursday3 != "YES")
                {
                    if ($thursday3 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .25);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET thursday3 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 thursday3";
                            }
                        }
                    }

                }
                elseif ($thursday4 != "YES")
                {
                    if ($thursday4 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .25);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET thursday4 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 thursday4";
                            }
                        }
                    }
                }
                elseif ($thursday5 != "YES")
                {
                    if ($thursday5 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .25);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET thursday5 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 thursday5";
                            }
                        }
                    }
                }
                elseif ($thursday6 != "YES")
                {
                    if ($thursday6 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .25);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET thursday6 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 thursday6";
                            }
                        }
                    }
                }
                elseif ($thursday7 != "YES")
                {
                    if ($thursday7 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .25);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET thursday7 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 thursday7";
                            }
                        }
                    }
                }
                elseif ($thursday8 != "YES")
                {
                    if ($thursday8 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .25);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET thursday8 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 thursday8";
                            }
                        }
                    }
                }
                elseif ($thursday9 != "YES")
                {
                    if ($thursday9 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .25);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET thursday9 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 thursday9";
                            }
                        }
                    }
                }
                elseif ($thursday10 != "YES")
                {
                    if ($thursday10 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .25);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $status = "1Friday";

                            $sql = "UPDATE week1 SET thursday10 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 thursday10";
                            }

                            $sql = "UPDATE measurements SET is_started = '$status' WHERE email = '$email'";

                            $result = pg_query($conn, $sql);

                            if (!$result)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating your measurement status.";
                            }
                        }

                    }
                }
            }
        }
        elseif ($status == "1Friday" && $todays_date == $day5)
        {
            $sql1 = "SELECT * FROM week1 WHERE email = '$email'";

            //RESULTS OF ALL WEEK1 USER DATA
            $week1 = pg_query($conn, $sql1);

            if (!$week1)
            {
                $_SESSION["ERROR"] = "There was an error recieving data from week1";
            }

            //PUTTING ALL WEEK1 DATA FOR SPECIFIC USER IN VARIABLES.
            while ($row = pg_fetch_assoc($week1))
            {
                $email = $row["email"];
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

                if ($friday1 != "YES")
                {
                    if ($friday1 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .45);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET friday1 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 friday1";
                            }
                        }

                    }
                }
                elseif ($friday2 != "YES")
                {
                    if ($friday2 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .45);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET friday2 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 friday2";
                            }
                        }

                    }
                }
                elseif ($friday3 != "YES")
                {
                    if ($friday3 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .45);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET friday3 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 friday3";
                            }
                        }

                    }

                }
                elseif ($friday4 != "YES")
                {
                    if ($friday4 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .45);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET friday4 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 friday4";
                            }
                        }

                    }
                }
                elseif ($friday5 != "YES")
                {
                    if ($friday5 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .45);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET friday5 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 friday5";
                            }
                        }

                    }
                }
                elseif ($friday6 != "YES")
                {
                    if ($friday6 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .45);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET friday6 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 friday6";
                            }
                        }

                    }
                }
                elseif ($friday7 != "YES")
                {
                    if ($friday7 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .45);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET friday7 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 friday7";
                            }
                        }

                    }
                }
                elseif ($friday8 != "YES")
                {
                    if ($friday8 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .45);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET friday8 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 friday8";
                            }
                        }

                    }
                }
                elseif ($friday9 != "YES")
                {
                    if ($friday9 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .45);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET friday9 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 friday9";
                            }
                        }

                    }
                }
                elseif ($friday10 != "YES")
                {
                    if ($friday10 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .45);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $status = "1Saturday";

                            $sql = "UPDATE week1 SET friday10 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 friday10";
                            }

                            $sql = "UPDATE measurements SET is_started = '$status' WHERE email = '$email'";

                            $result = pg_query($conn, $sql);

                            if (!$result)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating your measurement status.";
                            }
                        }
                    }
                }
            }
        }
        elseif ($status == "1Saturday" && $todays_date == $day6)
        {
            $sql1 = "SELECT * FROM week1 WHERE email = '$email'";

            //RESULTS OF ALL WEEK1 USER DATA
            $week1 = pg_query($conn, $sql1);

            if (!$week1)
            {
                $_SESSION["ERROR"] = "There was an error recieving data from week1";
            }

            //PUTTING ALL WEEK1 DATA FOR SPECIFIC USER IN VARIABLES.
            while ($row = pg_fetch_assoc($week1))
            {
                $email = $row["email"];
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

                if ($saturday1 != "YES")
                {
                    if ($saturday1 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .40);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET saturday1 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 saturday1";
                            }
                        }

                    }
                }
                elseif ($saturday2 != "YES")
                {
                    if ($saturday2 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .40);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET saturday2 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 saturday2";
                            }
                        }

                    }
                }
                elseif ($saturday3 != "YES")
                {
                    if ($saturday3 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .40);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET saturday3 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 saturday3";
                            }
                        }
                    }

                }
                elseif ($saturday4 != "YES")
                {
                    if ($saturday4 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .40);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET saturday4 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 saturday4";
                            }
                        }
                    }
                }
                elseif ($saturday5 != "YES")
                {
                    if ($saturday5 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .40);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET saturday5 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 saturday5";
                            }
                        }
                    }
                }
                elseif ($saturday6 != "YES")
                {
                    if ($saturday6 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .40);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET saturday6 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 saturday6";
                            }
                        }
                    }
                }
                elseif ($saturday7 != "YES")
                {
                    if ($saturday7 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .40);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET saturday7 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 saturday7";
                            }
                        }
                    }
                }
                elseif ($saturday8 != "YES")
                {
                    if ($saturday8 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .40);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET saturday8 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 saturday8";
                            }
                        }
                    }
                }
                elseif ($saturday9 != "YES")
                {
                    if ($saturday9 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .40);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET saturday9 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 saturday9";
                            }
                        }
                    }
                }
                elseif ($saturday10 != "YES")
                {
                    if ($saturday10 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .40);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $status = "1Sunday";

                            $sql = "UPDATE week1 SET saturday10 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 saturday10";
                            }

                            $sql = "UPDATE measurements SET is_started = '$status' WHERE email = '$email'";

                            $result = pg_query($conn, $sql);

                            if (!$result)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating your measurement status.";
                            }
                        }
                    }
                }
            }
        }
        elseif ($status == "1Sunday" && $todays_date == $day7)
        {
            $sql1 = "SELECT * FROM week1 WHERE email = '$email'";

            //RESULTS OF ALL WEEK1 USER DATA
            $week1 = pg_query($conn, $sql1);

            if (!$week1)
            {
                $_SESSION["ERROR"] = "There was an error recieving data from week1";
            }

            //PUTTING ALL WEEK1 DATA FOR SPECIFIC USER IN VARIABLES.
            while ($row = pg_fetch_assoc($week1))
            {
                $email = $row["email"];
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

                if ($sunday1 != "YES")
                {
                    if ($sunday1 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .20);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET sunday1 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 sunday1";
                            }
                        }

                    }
                }
                elseif ($sunday2 != "YES")
                {
                    if ($sunday2 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .20);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET sunday2 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 sunday2";
                            }
                        }

                    }
                }
                elseif ($sunday3 != "YES")
                {
                    if ($sunday3 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .20);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET sunday3 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 sunday3";
                            }
                        }
                    }

                }
                elseif ($sunday4 != "YES")
                {
                    if ($sunday4 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .20);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET sunday4 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 sunday4";
                            }
                        }
                    }
                }
                elseif ($sunday5 != "YES")
                {
                    if ($sunday5 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .20);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET sunday5 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 sunday5";
                            }
                        }
                    }
                }
                elseif ($sunday6 != "YES")
                {
                    if ($sunday6 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .20);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET sunday6 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 sunday6";
                            }
                        }
                    }
                }
                elseif ($sunday7 != "YES")
                {
                    if ($sunday7 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .20);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET sunday7 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 sunday7";
                            }
                        }
                    }
                }
                elseif ($sunday8 != "YES")
                {
                    if ($sunday8 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .20);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET sunday8 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 sunday8";
                            }
                        }
                    }
                }
                elseif ($sunday9 != "YES")
                {
                    if ($sunday9 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .20);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week1 SET sunday9 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 sunday9";
                            }
                        }
                    }
                }
                elseif ($sunday10 != "YES")
                {
                    if ($sunday10 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .20);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $status = "2Monday";

                            $sql = "UPDATE week1 SET sunday10 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 sunday10";
                            }

                            $sql = "UPDATE measurements SET is_started = '$status' WHERE email = '$email'";

                            $result = pg_query($conn, $sql);

                            if (!$result)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating your measurement status.";
                            }

                            $sql = "UPDATE week1 SET finished = 'YES' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                echo "There was an error updating week1 finished";
                            }
                        }
                    }
                }
            }
        }
        elseif ($status == "2Monday" && $todays_date == $day8)
        {
            $sql1 = "SELECT * FROM week2 WHERE email = '$email'";

            //RESULTS OF ALL week2 USER DATA
            $week2 = pg_query($conn, $sql1);

            if (!$week2)
            {
                $_SESSION["ERROR"] = "There was an error recieving data from week2";
            }

            //PUTTING ALL week2 DATA FOR SPECIFIC USER IN VARIABLES.
            while ($row = pg_fetch_assoc($week2))
            {
                $email = $row["email"];
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
                $finished = $row["finished"];

                if ($monday1 != "YES")
                {
                    if ($monday1 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .35);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET monday1 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 monday1";
                            }
                        }

                    }
                }
                elseif ($monday2 != "YES")
                {
                    if ($monday2 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .35);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET monday2 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 monday2";
                            }
                        }

                    }
                }
                elseif ($monday3 != "YES")
                {
                    if ($monday3 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .35);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET monday3 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 monday3";
                            }
                        }
                    }

                }
                elseif ($monday4 != "YES")
                {
                    if ($monday4 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .35);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET monday4 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 monday4";
                            }
                        }
                    }
                }
                elseif ($monday5 != "YES")
                {
                    if ($monday5 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .35);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET monday5 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 monday5";
                            }
                        }
                    }
                }
                elseif ($monday6 != "YES")
                {
                    if ($monday6 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .35);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET monday6 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 monday6";
                            }
                        }
                    }
                }
                elseif ($monday7 != "YES")
                {
                    if ($monday7 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .35);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET monday7 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 monday7";
                            }
                        }
                    }
                }
                elseif ($monday8 != "YES")
                {
                    if ($monday8 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .35);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET monday8 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 monday8";
                            }
                        }
                    }
                }
                elseif ($monday9 != "YES")
                {
                    if ($monday9 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .35);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET monday9 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 monday9";
                            }
                        }
                    }
                }
                elseif ($monday10 != "YES")
                {
                    if ($monday10 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .35);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $status = "2Tuesday";

                            $sql = "UPDATE week2 SET monday10 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 monday10";
                            }

                            $sql = "UPDATE measurements SET is_started = '$status' WHERE email = '$email'";

                            $result = pg_query($conn, $sql);

                            if (!$result)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating your measurement status.";
                            }
                        }
                    }
                }
            }
        }
        elseif ($status == "2Tuesday" && $todays_date == $day9)
        {
            $sql1 = "SELECT * FROM week2 WHERE email = '$email'";

            //RESULTS OF ALL week2 USER DATA
            $week2 = pg_query($conn, $sql1);

            if (!$week2)
            {
                $_SESSION["ERROR"] = "There was an error recieving data from week2";
            }

            //PUTTING ALL week2 DATA FOR SPECIFIC USER IN VARIABLES.
            while ($row = pg_fetch_assoc($week2))
            {
                $email = $row["email"];
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
                $finished = $row["finished"];

                if ($tuesday1 != "YES")
                {
                    if ($tuesday1 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .55);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET tuesday1 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 tuesday1";
                            }
                        }

                    }
                }
                elseif ($tuesday2 != "YES")
                {
                    if ($tuesday2 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .55);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET tuesday2 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 tuesday2";
                            }
                        }

                    }
                }
                elseif ($tuesday3 != "YES")
                {
                    if ($tuesday3 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .55);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET tuesday3 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 tuesday3";
                            }
                        }
                    }

                }
                elseif ($tuesday4 != "YES")
                {
                    if ($tuesday4 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .55);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET tuesday4 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 tuesday4";
                            }
                        }
                    }
                }
                elseif ($tuesday5 != "YES")
                {
                    if ($tuesday5 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .55);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET tuesday5 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 tuesday5";
                            }
                        }
                    }
                }
                elseif ($tuesday6 != "YES")
                {
                    if ($tuesday6 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .55);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET tuesday6 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 tuesday6";
                            }
                        }
                    }
                }
                elseif ($tuesday7 != "YES")
                {
                    if ($tuesday7 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .55);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET tuesday7 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 tuesday7";
                            }
                        }
                    }
                }
                elseif ($tuesday8 != "YES")
                {
                    if ($tuesday8 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .55);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET tuesday8 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 tuesday8";
                            }
                        }
                    }
                }
                elseif ($tuesday9 != "YES")
                {
                    if ($tuesday9 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .55);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET tuesday9 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 tuesday9";
                            }
                        }
                    }
                }
                elseif ($tuesday10 != "YES")
                {
                    if ($tuesday10 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .55);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $status = "2Wednesday";

                            $sql = "UPDATE week2 SET tuesday10 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 tuesday10";
                            }

                            $sql = "UPDATE measurements SET is_started = '$status' WHERE email = '$email'";

                            $result = pg_query($conn, $sql);

                            if (!$result)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating your measurement status.";
                            }
                        }
                    }
                }
            }
        }
        elseif ($status == "2Wednesday" && $todays_date == $day10)
        {
            $sql1 = "SELECT * FROM week2 WHERE email = '$email'";

            //RESULTS OF ALL week2 USER DATA
            $week2 = pg_query($conn, $sql1);

            if (!$week2)
            {
                $_SESSION["ERROR"] = "There was an error recieving data from week2";
            }

            //PUTTING ALL week2 DATA FOR SPECIFIC USER IN VARIABLES.
            while ($row = pg_fetch_assoc($week2))
            {
                $email = $row["email"];
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
                $finished = $row["finished"];

                if ($wednesday1 != "YES")
                {
                    if ($wednesday1 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .30);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET wednesday1 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 wednesday1";
                            }
                        }

                    }
                }
                elseif ($wednesday2 != "YES")
                {
                    if ($wednesday2 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .30);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET wednesday2 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 wednesday2";
                            }
                        }

                    }
                }
                elseif ($wednesday3 != "YES")
                {
                    if ($wednesday3 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .30);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET wednesday3 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 wednesday3";
                            }
                        }
                    }

                }
                elseif ($wednesday4 != "YES")
                {
                    if ($wednesday4 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .30);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET wednesday4 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 wednesday4";
                            }
                        }
                    }
                }
                elseif ($wednesday5 != "YES")
                {
                    if ($wednesday5 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .30);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET wednesday5 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 wednesday5";
                            }
                        }
                    }
                }
                elseif ($wednesday6 != "YES")
                {
                    if ($wednesday6 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .30);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET wednesday6 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 wednesday6";
                            }
                        }
                    }
                }
                elseif ($wednesday7 != "YES")
                {
                    if ($wednesday7 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .30);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET wednesday7 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 wednesday7";
                            }
                        }
                    }
                }
                elseif ($wednesday8 != "YES")
                {
                    if ($wednesday8 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .30);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET wednesday8 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 wednesday8";
                            }
                        }
                    }
                }
                elseif ($wednesday9 != "YES")
                {
                    if ($wednesday9 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .30);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET wednesday9 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 wednesday9";
                            }
                        }
                    }
                }
                elseif ($wednesday10 != "YES")
                {
                    if ($wednesday10 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .30);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $status = "2Thursday";

                            $sql = "UPDATE week2 SET wednesday10 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 wednesday10";
                            }

                            $sql = "UPDATE measurements SET is_started = '$status' WHERE email = '$email'";

                            $result = pg_query($conn, $sql);

                            if (!$result)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating your measurement status.";
                            }
                        }
                    }
                }
            }
        }
        elseif ($status == "2Thursday" && $todays_date == $day11)
        {
            $sql1 = "SELECT * FROM week2 WHERE email = '$email'";

            //RESULTS OF ALL week2 USER DATA
            $week2 = pg_query($conn, $sql1);

            if (!$week2)
            {
                $_SESSION["ERROR"] = "There was an error recieving data from week2";
            }

            //PUTTING ALL week2 DATA FOR SPECIFIC USER IN VARIABLES.
            while ($row = pg_fetch_assoc($week2))
            {
                $email = $row["email"];
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
                $finished = $row["finished"];

                if ($thursday1 != "YES")
                {
                    if ($thursday1 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .65);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET thursday1 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 thursday1";
                            }
                        }

                    }
                }
                elseif ($thursday2 != "YES")
                {
                    if ($thursday2 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .65);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET thursday2 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 thursday2";
                            }
                        }

                    }
                }
                elseif ($thursday3 != "YES")
                {
                    if ($thursday3 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .65);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET thursday3 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 thursday3";
                            }
                        }

                    }

                }
                elseif ($thursday4 != "YES")
                {
                    if ($thursday4 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .65);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET thursday4 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 thursday4";
                            }
                        }

                    }
                }
                elseif ($thursday5 != "YES")
                {
                    if ($thursday5 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .65);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET thursday5 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 thursday5";
                            }
                        }

                    }
                }
                elseif ($thursday6 != "YES")
                {
                    if ($thursday6 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .65);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET thursday6 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 thursday6";
                            }
                        }

                    }
                }
                elseif ($thursday7 != "YES")
                {
                    if ($thursday7 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .65);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET thursday7 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 thursday7";
                            }
                        }

                    }
                }
                elseif ($thursday8 != "YES")
                {
                    if ($thursday8 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .65);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET thursday8 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 thursday8";
                            }
                        }

                    }
                }
                elseif ($thursday9 != "YES")
                {
                    if ($thursday9 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .65);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET thursday9 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 thursday9";
                            }
                        }

                    }
                }
                elseif ($thursday10 != "YES")
                {
                    if ($thursday10 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .65);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $status = "2Friday";

                            $sql = "UPDATE week2 SET thursday10 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 thursday10";
                            }

                            $sql = "UPDATE measurements SET is_started = '$status' WHERE email = '$email'";

                            $result = pg_query($conn, $sql);

                            if (!$result)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating your measurement status.";
                            }
                        }
                    }
                }
            }
        }
        elseif ($status == "2Friday" && $todays_date == $day12)
        {
            $sql1 = "SELECT * FROM week2 WHERE email = '$email'";

            //RESULTS OF ALL week2 USER DATA
            $week2 = pg_query($conn, $sql1);

            if (!$week2)
            {
                $_SESSION["ERROR"] = "There was an error recieving data from week2";
            }

            //PUTTING ALL week2 DATA FOR SPECIFIC USER IN VARIABLES.
            while ($row = pg_fetch_assoc($week2))
            {
                $email = $row["email"];
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
                $finished = $row["finished"];

                if ($friday1 != "YES")
                {
                    if ($friday1 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .35);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET friday1 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 friday1";
                            }
                        }

                    }
                }
                elseif ($friday2 != "YES")
                {
                    if ($friday2 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .35);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET friday2 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 friday2";
                            }
                        }

                    }
                }
                elseif ($friday3 != "YES")
                {
                    if ($friday3 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .35);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET friday3 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 friday3";
                            }
                        }
                    }

                }
                elseif ($friday4 != "YES")
                {
                    if ($friday4 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .35);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET friday4 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 friday4";
                            }
                        }
                    }
                }
                elseif ($friday5 != "YES")
                {
                    if ($friday5 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .35);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET friday5 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 friday5";
                            }
                        }
                    }
                }
                elseif ($friday6 != "YES")
                {
                    if ($friday6 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .35);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET friday6 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 friday6";
                            }
                        }
                    }
                }
                elseif ($friday7 != "YES")
                {
                    if ($friday7 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .35);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET friday7 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 friday7";
                            }
                        }
                    }
                }
                elseif ($friday8 != "YES")
                {
                    if ($friday8 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .35);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET friday8 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 friday8";
                            }
                        }
                    }
                }
                elseif ($friday9 != "YES")
                {
                    if ($friday9 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .35);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET friday9 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 friday9";
                            }
                        }
                    }
                }
                elseif ($friday10 != "YES")
                {
                    if ($friday10 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .35);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $status = "2Saturday";

                            $sql = "UPDATE week2 SET friday10 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 friday10";
                            }

                            $sql = "UPDATE measurements SET is_started = '$status' WHERE email = '$email'";

                            $result = pg_query($conn, $sql);

                            if (!$result)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating your measurement status.";
                            }
                        }
                    }
                }
            }
        }
        elseif ($status == "2Saturday" && $todays_date == $day13)
        {
            $sql1 = "SELECT * FROM week2 WHERE email = '$email'";

            //RESULTS OF ALL week2 USER DATA
            $week2 = pg_query($conn, $sql1);

            if (!$week2)
            {
                $_SESSION["ERROR"] = "There was an error recieving data from week2";
            }

            //PUTTING ALL week2 DATA FOR SPECIFIC USER IN VARIABLES.
            while ($row = pg_fetch_assoc($week2))
            {
                $email = $row["email"];
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
                $finished = $row["finished"];

                if ($saturday1 != "YES")
                {
                    if ($saturday1 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .45);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET saturday1 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 saturday1";
                            }
                        }
                    }
                }
                elseif ($saturday2 != "YES")
                {
                    if ($saturday2 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .45);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET saturday2 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 saturday2";
                            }
                        }

                    }
                }
                elseif ($saturday3 != "YES")
                {
                    if ($saturday3 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .45);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET saturday3 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 saturday3";
                            }
                        }
                    }

                }
                elseif ($saturday4 != "YES")
                {
                    if ($saturday4 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .45);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET saturday4 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 saturday4";
                            }
                        }
                    }
                }
                elseif ($saturday5 != "YES")
                {
                    if ($saturday5 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .45);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET saturday5 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 saturday5";
                            }
                        }
                    }
                }
                elseif ($saturday6 != "YES")
                {
                    if ($saturday6 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .45);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET saturday6 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 saturday6";
                            }
                        }
                    }
                }
                elseif ($saturday7 != "YES")
                {
                    if ($saturday7 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .45);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET saturday7 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 saturday7";
                            }
                        }
                    }
                }
                elseif ($saturday8 != "YES")
                {
                    if ($saturday8 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .45);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET saturday8 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 saturday8";
                            }
                        }
                    }
                }
                elseif ($saturday9 != "YES")
                {
                    if ($saturday9 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .45);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET saturday9 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 saturday9";
                            }
                        }
                    }
                }
                elseif ($saturday10 != "YES")
                {
                    if ($saturday10 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .45);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $status = "2Sunday";

                            $sql = "UPDATE week2 SET saturday10 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 saturday10";
                            }

                            $sql = "UPDATE measurements SET is_started = '$status' WHERE email = '$email'";

                            $result = pg_query($conn, $sql);

                            if (!$result)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating your measurement status.";
                            }
                        }
                    }
                }
            }
        }
        elseif ($status == "2Sunday" && $todays_date == $day14)
        {
            $sql1 = "SELECT * FROM week2 WHERE email = '$email'";

            //RESULTS OF ALL week2 USER DATA
            $week2 = pg_query($conn, $sql1);

            if (!$week2)
            {
                $_SESSION["ERROR"] = "There was an error recieving data from week2";
            }

            //PUTTING ALL week2 DATA FOR SPECIFIC USER IN VARIABLES.
            while ($row = pg_fetch_assoc($week2))
            {
                $email = $row["email"];
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

                if ($sunday1 != "YES")
                {
                    if ($sunday1 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .25);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET sunday1 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 sunday1";
                            }
                        }

                    }
                }
                elseif ($sunday2 != "YES")
                {
                    if ($sunday2 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .25);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET sunday2 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 sunday2";
                            }
                        }

                    }
                }
                elseif ($sunday3 != "YES")
                {
                    if ($sunday3 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .25);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET sunday3 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 sunday3";
                            }
                        }
                    }

                }
                elseif ($sunday4 != "YES")
                {
                    if ($sunday4 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .25);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET sunday4 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 sunday4";
                            }
                        }
                    }
                }
                elseif ($sunday5 != "YES")
                {
                    if ($sunday5 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .25);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET sunday5 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 sunday5";
                            }
                        }
                    }
                }
                elseif ($sunday6 != "YES")
                {
                    if ($sunday6 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .25);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET sunday6 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 sunday6";
                            }
                        }
                    }
                }
                elseif ($sunday7 != "YES")
                {
                    if ($sunday7 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .25);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET sunday7 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 sunday7";
                            }
                        }
                    }
                }
                elseif ($sunday8 != "YES")
                {
                    if ($sunday8 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .25);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET sunday8 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 sunday8";
                            }
                        }
                    }
                }
                elseif ($sunday9 != "YES")
                {
                    if ($sunday9 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .25);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $sql = "UPDATE week2 SET sunday9 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 sunday9";
                            }
                        }
                    }
                }
                elseif ($sunday10 != "YES")
                {
                    if ($sunday10 < $todays_time)
                    {
                        $conn = db_connect();

                        $sql = "SELECT * FROM measurements WHERE email = '$email'";

                        $results = pg_query($conn, $sql);

                        if (!$results)
                        {

                            $_SESSION["ERROR"] = "There was an error searching the measurements table";

                            echo "ERROR ON LINE 107";
                        }

                        while ($row = pg_fetch_assoc($results))
                        {

                            $email = $row["email"];

                            $maxPushUps = $row["maxpushups"];

                            $pushUps = ceil($maxPushUps * .25);

                            $to = $email;
                            $subject = "!!IT'S TIME FOR PUSH-UPS!!";
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
                                        <h2>Still think you can do this?</h2>
                                        <p>Drop and give me $pushUps push-ups!</p>
                                    </div>
                                </section>
                                </div>
                            </body>
                            </html>";
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                            //i was rounding up pushUps
                            echo "$to --to";
                            echo "$message --message";

                            $a = mail($to, $subject, $message, $headers);

                            if ($a)
                            {
                                echo "MAIL SENT";
                            }
                            else
                            {
                                echo "MAIL NOT SENT";
                            }

                            $timeSlot = "YES";

                            $status = "FINISH";

                            $sql = "UPDATE week2 SET sunday10 = '$timeSlot' WHERE email = '$email'";

                            $results = pg_query($conn, $sql);

                            if (!$results)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating week1 sunday1";
                            }

                            $sql = "UPDATE measurements SET is_started = '$status' WHERE email = '$email'";

                            $result = pg_query($conn, $sql);

                            if (!$result)
                            {
                                $_SESSION["ERROR"] .= "There was an error updating your measurement status.";
                            }

                            $sql = "UPDATE week2 SET finished = 'YES' WHERE email = '$email'";
                            $results = pg_query($conn, $sql);
                            if (!$results)
                            {
                                echo "There was an error updating week2 to finished!";
                            }
                        }
                    }
                }
            }

        }

        //end of while loop
        
    }

}

// include "./footer.php";

?>
pp