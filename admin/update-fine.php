<?php
session_start();
include('../connection.php'); // Make sure this includes your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $fineAmount = $_POST['fineAmount'];

    // Validate inputs
    if (!empty($id) && !empty($fineAmount)) {
        // Update the fine amount in the database
        $query = "UPDATE tbl_fines SET fine_amount = ? WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('di', $fineAmount, $id);
        
        if ($stmt->execute()) {
            echo 'Fine updated successfully';
        } else {
            echo 'Error updating fine';
        }

        $stmt->close();
    } else {
        echo 'Invalid input';
    }
}

$conn->close();
?>