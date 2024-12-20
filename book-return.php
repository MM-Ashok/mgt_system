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
$id = $_GET['id'];

$delete_book = mysqli_query($conn, "delete from tbl_issue where book_id='$id' and  user_id='$ids'");
$return_book = mysqli_query($conn, "insert into tbl_return set book_id='$id', user_id='$ids', user_name='$name', return_date=CURDATE()");
$select_quantity = mysqli_query($conn, "select quantity from tbl_book where id='$id'");
$number = mysqli_fetch_row($select_quantity);
$count = $number[0];
$count = $count + 1;
$update_book = mysqli_query($conn, "update tbl_book set quantity='$count' where id='$id'");
$update_issue_status = mysqli_query($conn, "update tbl_issue set status=0 where book_id='$id'");
$delete_renewals = mysqli_query($conn, "DELETE FROM tbl_renewals WHERE book_id='$id' AND user_id='$ids'");

// if ($update_book > 0) {
// 
?>
<!-- <script type="text/javascript">
         alert("Book Returned successfully.");
         window.location.href = "issued-book.php";
     </script> -->
<?php
// }


if ($update_book > 0 && $delete_renewals ) {

    // $mail = new PHPMailer(true);

    try {
        //Server settings
        // $mail->isSMTP();
        // $mail->Host = 'smtp.example.com'; // SMTP server address
        // $mail->SMTPAuth = true;
        // $mail->Username = 'your-email@example.com'; // SMTP username
        // $mail->Password = 'your-email-password'; // SMTP password
        // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        // $mail->Port = 587; // SMTP port


        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '945abcb18f915b';
        $mail->Password = 'df129c52ba741d';

        //Recipients
        $mail->setFrom('no-reply@example.com', 'Library');
        $mail->addAddress('admin@library.com'); // Admin email address

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Book Return Notification';
        $mail->Body    = "User $name has returned the book with ID $id.";

        // Send the email
        $mail->send();

        echo "<script type='text/javascript'>
                alert('Book returned successfully and email notification has been sent.');
                window.location.href = 'issued-book.php';
              </script>";
    } catch (Exception $e) {
        echo "<script type='text/javascript'>
                alert('Book returned successfully but failed to send email notification: {$mail->ErrorInfo}');
                window.location.href = 'issued-book.php';
              </script>";
    }
} else {
    echo "<script type='text/javascript'>
            alert('Failed to return the book.');
            window.location.href = 'issued-book.php';
          </script>";
}

?>