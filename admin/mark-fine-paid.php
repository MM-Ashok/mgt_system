<?php
session_start();
include('../connection.php');

$lost_id = $_GET['id']; // Lost book record ID



mysqli_query($conn, "UPDATE tbl_fines SET fine_amount=0 WHERE user_id='$lost_id'");
// mysqli_query($conn, "DELETE FROM tbl_lost_books WHERE id='$lost_id'");


echo "<script type='text/javascript'>
alert('Fine marked as paid');
window.location.href = 'manage-lost-books.php';
</script>";
?>
