
<?php
session_start();
include('connection.php');

$user_id = $_SESSION['id'];
$book_id = $_GET['id'];

// Fetch the book issue details
$issue_query = mysqli_query($conn, "SELECT * FROM tbl_issue WHERE book_id = '$book_id' AND user_id = '$user_id' AND status = 1");
$issue = mysqli_fetch_assoc($issue_query);

if (!$issue) {
    echo "Invalid request.";
    exit();
}

// Check if the book is in the waitlist
$waitlist_query = mysqli_query($conn, "SELECT * FROM tbl_waiting_list WHERE book_id = '$book_id'");
if (mysqli_num_rows($waitlist_query) > 0) {
    echo "<script type='text/javascript'> alert('Renewal not allowed: Book is in the waitlist.');window.location.href = 'issued-book.php';</script>";
    exit();
}

// Check if the user has reached the maximum renewal limit
$max_renewals = 2;
if ($issue['renewal_count'] >= $max_renewals) {
    echo "<script type='text/javascript'> alert('Maximum renewal limit reached.');window.location.href = 'issued-book.php';</script>";
    exit();
}

// Add a record to the renewals table
$request_query = "INSERT INTO tbl_renewals (book_id, user_id, requested_at, status) 
                  VALUES ('$book_id', '$user_id', NOW(), 'pending')";
if (!mysqli_query($conn, $request_query)) {
    echo "<script type='text/javascript'> alert('Failed to send renewal request. Please try again.');window.location.href = 'issued-book.php';</script>";
    exit();
}

echo "<script type='text/javascript'> alert('Renewal request sent successfully. Please wait for admin approval.');window.location.href = 'issued-book.php';</script>";
?>
