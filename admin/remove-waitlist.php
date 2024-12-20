

<?php
session_start();
include('../connection.php');

$waitlist_id = $_GET['id'];

// Fetch the book ID associated with the waiting list entry
$fetch_book_query = mysqli_query($conn, "SELECT book_id FROM tbl_waiting_list WHERE id = '$waitlist_id'");
$book = mysqli_fetch_assoc($fetch_book_query);

if ($book) {
    $book_id = $book['book_id'];

    // Delete the waiting list entry
    $query = mysqli_query($conn, "DELETE FROM tbl_waiting_list WHERE id = '$waitlist_id'");

    if ($query) {
        // Update the book availability to 1
        $update_book_query = mysqli_query($conn, "UPDATE tbl_book SET availability = 1 , quantity = 1 WHERE id = '$book_id'");

        if ($update_book_query) {
            echo "<script>alert('User removed from the waiting list successfully, and book availability updated.'); window.location.href='manage-waiting-list.php';</script>";
        } else {
            echo "<script>alert('Failed to update book availability.'); window.location.href='manage-waiting-list.php';</script>";
        }
    } else {
        echo "<script>alert('Failed to remove user from the waiting list.'); window.location.href='manage-waiting-list.php';</script>";
    }
} else {
    echo "<script>alert('Invalid waiting list ID.'); window.location.href='manage-waiting-list.php';</script>";
}
?>
