<?php
session_start();
include('connection.php');

if (isset($_GET['id'])) {
    $book_id = $_GET['id'];
    $user_id = $_SESSION['id'];

    // Mark the book as lost
    $update_query = "
        UPDATE tbl_issue 
        SET is_lost = 1 
        WHERE book_id = '$book_id' AND user_id = '$user_id'
    ";
    if (mysqli_query($conn, $update_query)) {

        $lost_fine = 0;
        // Insert fine record
        $fine_query = "
            INSERT INTO tbl_fines (book_id, user_id, fine_amount) 
            VALUES ('$book_id', '$user_id', '$lost_fine')
        ";
        mysqli_query($conn, $fine_query);
        $_SESSION['success'] = "Book marked as lost and fine added.";
    } else {
        $_SESSION['error'] = "Failed to report the lost book: " . mysqli_error($conn);
    }
    echo "<script type='text/javascript'>
           alert('Book reported as lost. Fine: $$fine.');
          window.location.href = 'issued-book.php';
            </script>";
}
