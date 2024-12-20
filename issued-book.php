<?php
session_start();
include('connection.php');
$name = $_SESSION['user_name'];
$ids = $_SESSION['id'];
if (empty($ids)) {
  header("Location: index.php");
}

$fine_per_day = 1; // $1 per day late

?>

<?php include('include/header.php'); ?>
<div id="wrapper">

  <?php include('include/side-bar.php'); ?>

  <div id="content-wrapper">

    <div class="container-fluid">

      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">View Book</a>
        </li>

      </ol>

      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-info-circle"></i>
          View Book Details
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>S.No.</th>
                  <th>Book Name</th>
                  <th>Category</th>
                  <th>Issue Date</th>
                  <th>Due Date</th>
                  <th>Fine (Rs)</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $select_query = mysqli_query($conn, "
                                      SELECT 
                                          tbl_issue.book_id, 
                                          tbl_book.book_name, 
                                          tbl_book.category, 
                                          tbl_issue.issue_date, 
                                          tbl_issue.due_date, 
                                          tbl_renewals.status AS renewal_status, 
                                          tbl_fines.fine_amount AS fine_amount,
                                          tbl_issue.is_lost
                                      FROM 
                                          tbl_issue 
                                      INNER JOIN 
                                          tbl_book ON tbl_issue.book_id = tbl_book.id 
                                      LEFT JOIN 
                                          tbl_renewals ON tbl_issue.book_id = tbl_renewals.book_id AND tbl_issue.user_id = tbl_renewals.user_id
                                      LEFT JOIN 
                                          tbl_fines ON tbl_fines.book_id = tbl_issue.book_id AND tbl_fines.book_id = tbl_issue.book_id
                                      WHERE 
                                          tbl_issue.user_id = '$ids' AND tbl_issue.status = 1
                                  ");
                $sn = 1;
                while ($row = mysqli_fetch_array($select_query)) {

                  $renew_status_text = "Renew"; // Default
                  if ($row['renewal_status'] === 'pending') {
                    $renew_status_text = "Renewal Requested";
                  } elseif ($row['renewal_status'] === 'approved') {
                    $renew_status_text = "Renewed";



                    
                    // check due date
                    $due_date = strtotime($row['due_date']);
                    $current_date = strtotime(date('Y-m-d'));

                    if ($current_date > $due_date && $row['is_lost'] == 0) {
                      // Calculate the number of days overdue
                      $days_overdue = ($current_date - $due_date) / (60 * 60 * 24);

                      // Calculate the fine
                      $fine_amount = $days_overdue * $fine_per_day;

                      // Update the fine in the database
                      $update_fine_query = "UPDATE tbl_fines SET fine_amount = '$fine_amount' WHERE book_id = '{$row['book_id']}'";
                      mysqli_query($conn, $update_fine_query);
                    }


                    // check due date
                    if (strtotime($row['due_date']) < strtotime(date('Y-m-d'))) {
                      $renew_status_text = "Renew";

                      // Delete the entry from tbl_renewals
                      $delete_query = mysqli_query($conn, "
                          DELETE FROM tbl_renewals 
                          WHERE book_id = '{$row['book_id']}' AND user_id = '$ids'
                      ");

                      if (!$delete_query) {
                        echo "Error deleting renewal record: " . mysqli_error($conn);
                      }
                    }
                  } elseif ($row['renewal_status'] === 'rejected') {
                    $renew_status_text = "Renewal Rejected";
                  }

                ?>
                  <tr>
                    <td><?php echo $sn; ?></td>
                    <td><?php echo $row['book_name']; ?></td>
                    <td><?php echo $row['category']; ?></td>
                    <td><?php echo $row['issue_date']; ?></td>
                    <td><?php echo $row['due_date']; ?></td>
                    <td><?php echo $row['fine_amount']; ?> Rs</td>
                    <td>
                      <a href="book-return.php?id=<?php echo $row['book_id']; ?>"><button class="btn btn-success">Return</button></a>

                      <?php if ($row['is_lost'] == 1) { ?>
                        <button class="btn btn-danger">Book Lost</button>
                      <?php } else { ?>
                        <?php if ($row['is_lost'] === '0') { ?>
                          <a href="report-lost.php?id=<?php echo $row['book_id']; ?>">
                            <button class="btn btn-warning">Report Lost</button>
                          </a>
                        <?php } else { ?>
                          <button class="btn btn-secondary" disabled>Reported</button>
                        <?php } ?>
                      <?php } ?>

                      <?php if ($renew_status_text === "Renew") { ?>
                        <a href="renew-book.php?id=<?php echo $row['book_id']; ?>"><button class="btn btn-primary"><?php echo $renew_status_text; ?></button></a>
                      <?php } else { ?>
                        <button class="btn btn-primary"><?php echo $renew_status_text; ?></button>
                      <?php } ?>
                    </td>

                  </tr>
                <?php $sn++;
                } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
  <?php include('include/footer.php'); ?>