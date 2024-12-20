<?php
session_start();
include('connection.php');
$user_id = $_SESSION['id'];
$book_id = $_GET['id']; // Book ID passed via URL

// Check if user is already on the waiting list for the book
$check_query = mysqli_query($conn, "SELECT * FROM tbl_waiting_list WHERE book_id = '$book_id' AND user_id = '$user_id' AND status = 'pending'");
if (mysqli_num_rows($check_query) > 0) {
    die("<script type='text/javascript'>alert('You are already on the waiting list for this book.');window.location.href = 'book.php';</script>");
}

// Add user to the waiting list
mysqli_query($conn, "INSERT INTO tbl_waiting_list (book_id, user_id) VALUES ('$book_id', '$user_id')");
echo "<script type='text/javascript'> alert('You have been added to the waiting list.');window.location.href = 'book.php';</script>";
?>
