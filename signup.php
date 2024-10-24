<?php
session_start();


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception; 
include('includes/config.php');
require 'vendor/autoload.php';
if (isset($_POST['signup'])) {

    //Code for student ID
    $count_my_page = ("studentid.txt");
    $hits = file($count_my_page);
    $hits[0]++;
    $fp = fopen($count_my_page, "w");
    fputs($fp, "$hits[0]");
    fclose($fp);
    $StudentId = $hits[0];
    $fname = $_POST['fullanme'];
    $mobileno = $_POST['mobileno'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $status = 1;
    $sql = "INSERT INTO  tblstudents(StudentId,FullName,MobileNumber,EmailId,Password,Status) VALUES(:StudentId,:fname,:mobileno,:email,:password,:status)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':StudentId', $StudentId, PDO::PARAM_STR);
    $query->bindParam(':fname', $fname, PDO::PARAM_STR);
    $query->bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();



    if ($lastInsertId) {
        
        // echo '<script>alert("Your Registration successfull and your student id is  "+"'.$StudentId.'")</script>';
        try {
            $phpmailer = new PHPMailer();
            $phpmailer->isSMTP();
            $phpmailer->Host = 'smtp.gmail.com';
            $phpmailer->SMTPAuth = true;
            $phpmailer->Username = 'devcoder4822@gmail.com';
            $phpmailer->Password = '#Mohali123';
            $phpmailer->SMTPSecure = 'tls';
            $phpmailer->Port = 587;

            // $phpmailer = new PHPMailer();
            // $phpmailer->isSMTP();
            // $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
            // $phpmailer->SMTPAuth = true;
            // $phpmailer->Port = 2525;
            // $phpmailer->Username = '945abcb18f915b';
            // $phpmailer->Password = 'df129c52ba741d';

            //Recipients
            $phpmailer->setFrom('your-email@example.com', 'Your Name');
            $phpmailer->addAddress($email);
            $phpmailer->addReplyTo('your-email@example.com', 'Information');

            // Content
            $phpmailer->isHTML(true);
            $phpmailer->Subject = 'Registration Successful';
            $phpmailer->Body    = "Dear $fname,<br><br>Thank you for registering! Your Student ID is: <strong>$StudentId</strong>.<br><br>Regards,<br>Your Team";

            // Send the email
            if ($phpmailer->send()) {
                echo '<script>alert("Your registration was successful and an email has been sent with your student ID: ' . $StudentId . '")</script>';
            } else {
                echo '<script>alert("Registration successful, but failed to send email.")</script>';
            }
        } catch (Exception $e) {
            echo "<script>alert('Message could not be sent. Mailer Error: {$phpmailer->ErrorInfo}');</script>";
        }
    } else {
        echo "<script>alert('Something went wrong. Please try again');</script>";
    }
}

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <title> Library Management System | Student Signup</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <script type="text/javascript">
        function valid() {
            if (document.signup.password.value != document.signup.confirmpassword.value) {
                alert("Password and Confirm Password Field do not match  !!");
                document.signup.confirmpassword.focus();
                return false;
            }
            return true;
        }
    </script>
    <script>
        function checkAvailability() {
            $("#loaderIcon").show();
            jQuery.ajax({
                url: "check_availability.php",
                data: 'emailid=' + $("#emailid").val(),
                type: "POST",
                success: function(data) {
                    $("#user-availability-status").html(data);
                    $("#loaderIcon").hide();
                },
                error: function() {}
            });
        }
    </script>

</head>

<body>
    <!------MENU SECTION START-->
    <?php include('includes/header.php'); ?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">User Signup</h4>

                </div>

            </div>
            <div class="row">

                <div class="col-md-9 col-md-offset-1">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            SINGUP FORM
                        </div>
                        <div class="panel-body">
                            <form name="signup" method="post" onSubmit="return valid();">
                                <div class="form-group">
                                    <label>Enter Full Name</label>
                                    <input class="form-control" type="text" name="fullanme" autocomplete="off"
                                        required />
                                </div>


                                <div class="form-group">
                                    <label>Mobile Number :</label>
                                    <input class="form-control" type="text" name="mobileno" maxlength="10"
                                        autocomplete="off" required />
                                </div>

                                <div class="form-group">
                                    <label>Enter Email</label>
                                    <input class="form-control" type="email" name="email" id="emailid"
                                        onBlur="checkAvailability()" autocomplete="off" required />
                                    <span id="user-availability-status" style="font-size:12px;"></span>
                                </div>

                                <div class="form-group">
                                    <label>Enter Password</label>
                                    <input class="form-control" type="password" name="password" autocomplete="off"
                                        required />
                                </div>

                                <div class="form-group">
                                    <label>Confirm Password </label>
                                    <input class="form-control" type="password" name="confirmpassword"
                                        autocomplete="off" required />
                                </div>

                                <button type="submit" name="signup" class="btn btn-danger" id="submit">Register Now
                                </button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php'); ?>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
</body>

</html>