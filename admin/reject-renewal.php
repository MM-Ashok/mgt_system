<?php
include('../connection.php');

if (isset($_GET['id'])) {
    $renewal_id = $_GET['id'];
    // Fetch the renewal request details
    $renewal_query = mysqli_query($conn, "SELECT * FROM tbl_renewals WHERE id = '$renewal_id'");
    $renewal = mysqli_fetch_assoc($renewal_query);

    if (!$renewal || $renewal['status'] !== 'pending') {
        echo "Invalid or already processed request.";
        exit();
    }

    // Update the status in tbl_renewals
 mysqli_query($conn, "UPDATE tbl_renewals SET status = 'rejected', processed_at = NOW() WHERE id = '$renewal_id'");
    echo "<script type='text/javascript'> alert('Renewal request rejected successfully.');window.location.href = 'view-renewals.php';</script>";
}
?>
