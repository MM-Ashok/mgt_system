<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer classes
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

session_start();
include('connection.php');
$name = $_SESSION['user_name'];
$ids = $_SESSION['id'];
if (empty($ids)) {
  header("Location: index.php");
  exit();
}

// Fetching book details for the selected book ID
if (isset($_GET['id'])) {
  $book_id = $_GET['id'];
  $book_query = mysqli_query($conn, "SELECT * FROM tbl_book WHERE id='$book_id'");
  $book = mysqli_fetch_assoc($book_query);

  if (!$book) {
    die("Book not found.");
  }
}

if (isset($_REQUEST['isue-book-btn'])) {
  $start_date = $_POST['start_date'];
  $return_date = $_POST['return_date'];

  // Check if dates are set
  if (empty($start_date) || empty($return_date)) {
    echo "Please select both start and return dates.";
  } else {

    $insert_query = mysqli_query($conn, "insert into tbl_issue set book_id='$book_id ', user_id='$ids', user_name='$name', status=3 , issue_date='$start_date', due_date='$return_date' ");

    if ($insert_query > 0) {

      $mail = new PHPMailer();
      $mail->isSMTP();
      $mail->Host = 'sandbox.smtp.mailtrap.io';
      $mail->SMTPAuth = true;
      $mail->Port = 2525;
      $mail->Username = '945abcb18f915b';
      $mail->Password = 'df129c52ba741d';

      //Recipients
      $mail->setFrom('no-reply@example.com', 'Library');
      $mail->addAddress('admin@example.com'); // Admin email address

      // Content
      $mail->isHTML(true);
      $mail->Subject = 'New Book Issue Request';
      $mail->Body    = "User $name has requested for a new book issue with Book ID $id.";
      // Send the email
      $mail->send();

      
      echo "<script type='text/javascript'> alert('Request sent successfully and email notification has been sent');window.location.href = 'book.php';</script>";
    } else {
      echo "<script type='text/javascript'> alert('Failed to send request.');window.location.href = 'book.php';</script>";
    }
  }
}
?>

<?php include('include/header.php'); ?>
<div id="wrapper">

  <?php include('include/side-bar.php'); ?>

  <div id="content-wrapper">

    <div class="container-fluid">

      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Book Issue</a>
        </li>
      </ol>

      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-info-circle"></i>
          Issue Book
        </div>
        <div class="card-body">
          <form method="post" action="">
            <div class="form-group">
              <label for="book_name">Book Name</label>
              <input type="text" class="form-control" id="book_name" value="<?php echo $book['book_name']; ?>" readonly>
            </div>
            <div class="form-group">
              <label for="start_date">Start Date</label>
              <input type="date" class="form-control" id="start_date" name="start_date" required>
            </div>
            <div class="form-group">
              <label for="return_date">Return Date</label>
              <input type="date" class="form-control" id="return_date" name="return_date" required>
            </div>
            <button type="submit" name="isue-book-btn" class="btn btn-success">Issue Book</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
  <?php include('include/footer.php'); ?>
</div>
