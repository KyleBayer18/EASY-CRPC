<?php
    include "./header.php";
    
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        $_SESSION["ERROR"] = "";
    }
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $email = trim($_POST["email"]);
        $subject = trim($_POST["subject"]);
        $content = trim($_POST["message"]);
        
        $message = "<!DOCTYPE html>
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
                                    <div>
                                        <h2>$email : $subject</h2>
                                        <p>$content</p>
                                    </div>
                                </div>
                            </body>
                            </html>";
        
        
                            $headers = "From: no-reply@easy-crpc.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        
        
        if($email != "" && $subject != "" && $message != ""){
            $a = mail('easycrpc@gmail.com', 'Customer Inquiry',  $message, $headers);
            
            if($a){
                $_SESSION["ERROR"] = "Email has been sent!";
            }else{
                $_SESSION["ERROR"] = "Email not sent.";
            }
        }
    }
    
?>

    <!-- Top Container -->
    <section class="top-container">
        <header class="showcase">
            <h1>Easy - CRPC</h1>
            <p>Increase muscle mass in your biceps and chest in two weeks!</p>
            <a href="#" class="btn" data-toggle="modal" data-target="#exampleModal">Read More</a>
            <!--POP UP-->
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">What is EASY-CRPC ?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <p style="color:black; font-size:15px;">EASY-CRPC is a tool built to help with the completion of the 'Crazy Russian Pushup Program'.</p>
                    <p style="color:black; font-size:15px;">This challenge lasts 14 days, and throughout each day you will be required to do 10 sets of push-ups in one hour durations.</p>
                    <p style="color:black; font-size:15px;">The amount of push-ups done each day is calculated using your maximum push-up count.</p>
                    <p style="color:black; font-size:15px;">This program requires the participant be commited as you will find yourself doing push-ups throughout your dailey routine.</p>
                    
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
        </header>
        <div class="top-box top-box-a">
            <h4>Membership</h4>
            <p class="price">$0</p>
            <p class="membership-description">This tool will always be free for those determined enough to compelete it!</p>
            <a href="./signup.php" class="btn">Register</a>
        </div>
        <!-- <div class="top-box top-box-b">
            <h4>Special Membership</h4>
            <p class="price">$?</p>
            <a href="" class="btn">Buy Now</a>
        </div> -->
    </section>

    <!-- boxes section -->
    <section class="boxes">
        <div class="box one">
            <i class="fas fa-chart-pie fa-4x"></i>
            <h3>Anallytics</h3>
            <p>Your progress will be tracked throughout the two weeks and you will be able to compare your results with your starting measurements!</p>
        </div>
        <div class="box one">
            <i class="fas fa-paper-plane fa-4x"></i>
            <h3>Email Notifications</h3>
            <p>Throughout the duration of the two week challenge you will recieve daily email reminders to complete your push ups.</p>
        </div>
        <div class="box one">
            <i class="fas fa-smile-beam fa-4x"></i>
            <h3>Easy Setup</h3>
            <p>The setup process is very simple and easy to complete.  Ensure you are able to record measurements for your biceps, chest and weight.</p>
        </div>
        <div class="box one">
            <i class="fas fa-users fa-4x"></i>
            <h3>Support</h3>
            <p>For any bug reports, suggestions or if other assistance is required, you can reach us any time via the 'Contact Us' form below!</p>
        </div>
    </section>

    <!-- info section -->
    <section class="info">
        <img src="img/pic1.jpg" alt="Team Challenge">
        <div>
            <h2>Challenge your Friends</h2>
            <p>Configure your challenge starting time with your friends to synchorinize your challenge!</p>
            <p>Misery loves company!</p>
            <!--<a href="" class="btn">Learn More</a>-->
        </div>
    </section>
    <section class="info" style="align-items:center;">
        <img src="https://s7d2.scene7.com/is/image/honeywell/contact-us_help-support?wid=1000&hei=668" alt="Team Challenge" >
        <div>
            <h2>Contact Us</h2>
            <p>Please fill out the contact form and submit your message. </p>
            <p>You will receieve a response within 24 hours.</p>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="form-group" >
                    <input type="email" class="form-control" placeholder="Enter your email" required="required" name="email" maxlength="70">
                </div>
                <div class="form-group" >
                    <input type="text" class="form-control" placeholder="Enter a subject" required="required" name="subject" maxlength="40">
                </div>
                <div class="form-group" >
                    <textarea class="form-control" name="message" rows="5" maxlength="1000" placeholder="Enter your message"></textarea>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn" />
                </div>
            </form>
        </div>
        
    </section>

    <!-- Portfolio Section -->
    <!-- <section class="portfolio">
        <img src="https://source.unsplash.com/random/200x200" alt="">
        <img src="https://source.unsplash.com/random/200x201" alt="">
        <img src="https://source.unsplash.com/random/200x202" alt="">
        <img src="https://source.unsplash.com/random/200x203" alt="">
        <img src="https://source.unsplash.com/random/200x204" alt="">
        <img src="https://source.unsplash.com/random/200x205" alt="">
        <img src="https://source.unsplash.com/random/200x206" alt="">
        <img src="https://source.unsplash.com/random/200x207" alt="">
    </section> -->

 <?php
 include "./footer.php";
 ?>