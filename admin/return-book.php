<?php
session_start();
include('../connection.php');
$loan_id = $_GET['loan_id']; // Loan ID passed via URL

// Fetch loan and book details
$loan_query = mysqli_query($conn, "SELECT * FROM tbl_loans WHERE id = '$loan_id'");
$loan = mysqli_fetch_assoc($loan_query);

$book_id = $loan['book_id'];

// Update loan status to returned
mysqli_query($conn, "UPDATE tbl_loans SET status = 'returned' WHERE id = '$loan_id'");

// Update book availability
mysqli_query($conn, "UPDATE tbl_book SET copies_available = copies_available + 1 WHERE id = '$book_id'");

// Notify the next user in the waiting list
$waiting_query = mysqli_query($conn, "SELECT * FROM tbl_waiting_list WHERE book_id = '$book_id' AND status = 'pending' ORDER BY added_on ASC LIMIT 1");
if (mysqli_num_rows($waiting_query) > 0) {
    $next_user = mysqli_fetch_assoc($waiting_query);
    $next_user_id = $next_user['user_id'];

    // Send notification (mock email function)
    $user_query = mysqli_query($conn, "SELECT email FROM tbl_users WHERE id = '$next_user_id'");
    $user = mysqli_fetch_assoc($user_query);
    $email = $user['email'];
    mail($email, "Book Available", "The book you were waiting for is now available!");

    // Update waiting list status
    mysqli_query($conn, "UPDATE tbl_waiting_list SET status = 'fulfilled' WHERE id = '{$next_user['id']}'");
}
?>
