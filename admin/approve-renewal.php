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

    $book_id = $renewal['book_id'];
    $user_id = $renewal['user_id'];

    // Update the due date in tbl_issue
    $issue_query = mysqli_query($conn, "SELECT * FROM tbl_issue WHERE book_id = '$book_id' AND user_id = '$user_id'");
    $issue = mysqli_fetch_assoc($issue_query);

    if ($issue) {
        $new_due_date = date('Y-m-d', strtotime($issue['due_date'] . ' +7 days'));
        $renewal_count = $issue['renewal_count'] + 1;

        mysqli_query($conn, "UPDATE tbl_issue SET due_date = '$new_due_date', renewal_count = $renewal_count WHERE book_id = '$book_id' AND user_id = '$user_id'");
    }

    // Update the status in tbl_renewals
    mysqli_query($conn, "UPDATE tbl_renewals SET status = 'approved', processed_at = NOW() WHERE id = '$renewal_id'");

    echo "<script type='text/javascript'> alert('Renewal request approved successfully.');window.location.href = 'view-renewals.php';</script>";
}
?>
