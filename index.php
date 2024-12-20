<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer classes
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

session_start();
include('connection.php');

if (isset($_REQUEST['login_btn'])) {
  $uname = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['pwd']);
  $upwd = md5($password);

  $select_query = mysqli_query($conn, "SELECT * FROM tbl_users WHERE emailid='$uname' AND password='$upwd' AND role=2");
  $username = mysqli_fetch_assoc($select_query);

  if (!empty($username)) {
    $_SESSION['user_name'] = $username['user_name'];
    $_SESSION['id'] = $username['id'];
  }
  $rows = mysqli_num_rows($select_query);
  if ($rows > 0) {
    if ($username['status'] == 0) {
      echo "<script>alert('Your account is disabled. Please contact support.');</script>";
    } else {
      header("Location: dashboard.php");
    }
  } else {
    echo "<script>alert('You have entered wrong emailid or password.');</script>";
  }
}


if (isset($_REQUEST['register_btn'])) {
  $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['pwd']);
  $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_pwd']);

  if ($password === $confirm_password) {
    $upwd = md5($password);
    $check_query = mysqli_query($conn, "SELECT id FROM tbl_users WHERE emailid='$email'");
    if (mysqli_num_rows($check_query) > 0) {
      echo "<script>alert('Email is already registered.');</script>";
    } else {
      $insert_query = mysqli_query($conn, "INSERT INTO tbl_users (user_name, emailid, password, role, status) VALUES ('$full_name', '$email', '$upwd', 2, 1)");
      if ($insert_query) {
        sendEmailNotification($email, $full_name); // Call the email function
        echo "<script>alert('Registration successful. Please login.');</script>";
      } else {
        echo "<script>alert('Registration failed. Please try again.');</script>";
      }
    }
  } else {
    echo "<script>alert('Passwords do not match.');</script>";
  }
}

// Function to send email
function sendEmailNotification($toEmail, $fullName)
{
  // $mail = new PHPMailer(true);
  try {
    // Server settings
    // $mail->SMTPDebug = 2; // Set to 0 to disable debugging
    // $mail->Debugoutput = 'html';


    // $mail->isSMTP();
    // $mail->Host = 'smtp.gmail.com';
    // $mail->SMTPAuth =false;
    // $mail->Username = 'devcoder4822@gmail.com'; // Replace with your Gmail address
    // $mail->Password = '#Mohali123'; // Replace with your Gmail password or App Password
    // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    // $mail->Port = 587;


    // Looking to send emails in production? Check out our Email API/SMTP product!
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'sandbox.smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->Port = 2525;
    $mail->Username = '945abcb18f915b';
    $mail->Password = 'df129c52ba741d';

    // Recipients
    $mail->setFrom('devcoder4822@gmail.com', 'Library Management System'); // Replace with your email
    $mail->addAddress($toEmail, $fullName);

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Welcome to Library Management System';
    $mail->Body    = "<h1>Welcome, $fullName!</h1><p>Thank you for registering with our Library Management System. We're glad to have you on board!</p>";
    $mail->AltBody = "Welcome, $fullName! Thank you for registering with our Library Management System.";

    $mail->send();
    echo "<script>alert('Email notification sent successfully.');</script>";
  } catch (Exception $e) {
    echo "<script>alert('Email notification could not be sent. Error: {$mail->ErrorInfo}');</script>";
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Library Management System</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="css/sb-admin.css" rel="stylesheet">
  <link href="css/custom_style.css?ver=1.1" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css' rel='stylesheet' />
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
</head>

<body class="bg-dark" style="background: url(img/library-img-bg.jpg) no-repeat; background-size: cover;">
  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="login-tab" data-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="true">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="register-tab" data-toggle="tab" href="#register" role="tab" aria-controls="register" aria-selected="false">Register</a>
          </li>
        </ul>
      </div>
      <div class="card-body tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
          <h2>
            <center style="color:coral;">User Login</center>
          </h2>
          <form name="login" method="post" action="">
            <div class="form-group">
              <div class="form-label-group">
                <input type="email" id="inputEmail" class="form-control" name="email" placeholder="Email address" required="required" autofocus="autofocus">
                <label for="inputEmail">Email address</label>
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
                <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="pwd" required="required">
                <label for="inputPassword">Password</label>
              </div>
            </div>
            <input type="submit" class="btn btn-primary btn-block" name="login_btn" value="Login">
          </form>
        </div>
        <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
          <h2>
            <center style="color:coral;">User Registration</center>
          </h2>
          <form name="register" method="post" action="">
            <div class="form-group">
              <div class="form-label-group">
                <input type="text" id="fullName" class="form-control" name="full_name" placeholder="Full Name" required="required">
                <label for="fullName">User Name</label>
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
                <input type="email" id="registerEmail" class="form-control" name="email" placeholder="Email address" required="required">
                <label for="registerEmail">Email address</label>
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
                <input type="password" id="registerPassword" class="form-control" name="pwd" placeholder="Password" required="required">
                <label for="registerPassword">Password</label>
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
                <input type="password" id="confirmPassword" class="form-control" name="confirm_pwd" placeholder="Confirm Password" required="required">
                <label for="confirmPassword">Confirm Password</label>
              </div>
            </div>
            <input type="submit" class="btn btn-primary btn-block" name="register_btn" value="Register">
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#myTab a').on('click', function(e) {
        e.preventDefault();
        $(this).tab('show');
      });
    });
  </script>
</body>

</html>