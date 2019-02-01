<?php
session_start();
include_once './connection.php';
$message_status = "";
$status = "";
$message = "";
$mail_message = "";
if(isset($_POST['submit']))
{
    
    $qry = "select * from users where user_name = '".$_POST["email"]."'";
    $statement = $connect->prepare($qry);
    $statement->execute();
    if($result = $statement->fetch())
    {
        $email=$_POST["email"];
        $status = 1;
        $otp = rand(0000, 9999);
        $_SESSION['otp'] = $otp;
        echo $otp;
        $message = "<p>the OTP for Login is <h3>$otp</h3></p>";
        $subject = "Login OTP";
        $to = $email;
        $header = "MIME-version:1";
        $header .= "Content-type:text/HTML;char-set:8859-1";
        $header .= "From: Ashish Dhiman";
        $header .= "Reply-to: No-Reply";
//        $mail_status = mail($to, $subject, $message);
//        if(true)
//        {
            $mail_message = "<p>OTP Send to Your Email ID</p>";
//        }
//        else 
//        {
 //           $mail_message = "<p>Something Wrong with Mail function </p>";
//        }
    }
    else 
    {
        echo '<script>alert("This User is not register !")</script>';
    }
    
    
}
if(isset($_POST['verify']))
{  
    if($_SESSION['otp'] == $_POST['otp'])
    {
        $message_status = "success";
        $message = "you are successfull login";
        header("Refresh:5,url=profile.php");
    }
    else
    {
        
        $message_status = "fail";
        $message = "you have enter the wrong OTP";
    }
    
}


?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>OTP Verification Via Email</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet" />
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" ></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" ></script>
    </head>
    <body>
        <br /><br />

        <div class="container">
            <h2 class="text-danger" align="center" >Email Verification System Via OTP</h2>
            <br />
            
            <form action="index.php" method="post" class="form-group">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-default">
                        <div class="panel-heading"><i>Login via OTP</i></div>
                    <div class="panel-body">
                        
                        <!-- Error & Success Message show -->
                        <?php if($message_status == 'success'): ?>
                        <div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close" >&times;</a><?= $message; ?></div>
                        <?php elseif($message_status == ''): ?>
                        <div></div>
                        <?php  else: ?>
                        <div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close" >&times;</a> <?= $message; ?></div>
                        <?php endif; ?>
                        
                            
                        <?php if($status == 1): ?>
                        <label>Email</label>
                        <input type="email" name="email" id="email" value="<?php if(isset($email)) echo $email; ?>" class="form-control" placeholder="Enter Email Address" />
                        <br />
                        
                        <div align="center" class="text-primary alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close" >&times;</a><?php if(isset($mail_message)) echo $mail_message;  ?></div>
                        <div id="input_box"><input type="number" id="otp" name="otp" class="form-control" placeholder="Enter OTP Here" /></div>
                        <br />
                        <div align="center"><input type="submit" name="verify" id="verify" value="Verify OTP" class="btn btn-danger"></div>
                        <?php else: ?>
                         <label>Email</label>
                         <input type="email" name="email" id="email" required class="form-control" placeholder="Enter Email Address"  />
                        <br />
                        <div align="center"><input type="submit" name="submit" id="submit" value="Send OTP" class="btn btn-primary"></div>
                        
                        <?php endif; ?>
                    </div>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>
