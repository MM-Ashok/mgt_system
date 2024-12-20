<?php
session_start();
include('../connection.php');
$name = $_SESSION['name'];
$id = $_SESSION['id'];
if (empty($id)) {
  header("Location: index.php");
}
?>
<?php include('include/header.php'); ?>
<div id="wrapper">
  <?php include('include/side-bar.php'); ?>
  <div id="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">View Waiting list</a>
        </li>
      </ol>
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-info-circle"></i>
          Waiting list
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>S.No.</th>
                  <th>Book Name</th>
                  <th>User Name</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php

                $select_query = mysqli_query($conn, "SELECT tbl_waiting_list.id, tbl_waiting_list.status,tbl_waiting_list.book_id, tbl_waiting_list.user_id, tbl_waiting_list.added_on,tbl_book.book_name, tbl_users.user_name FROM tbl_waiting_list INNER JOIN tbl_book ON tbl_waiting_list.book_id = tbl_book.id INNER JOIN tbl_users ON tbl_waiting_list.user_id = tbl_users.id ORDER BY tbl_waiting_list.added_on DESC;");


                $sn = 1;
                while ($row = mysqli_fetch_array($select_query)) { ?>
                  <tr>
                    <td><?php echo $sn; ?></td>
                    <td><?php echo $row['book_name']; ?></td>
                    <td><?php echo $row['user_name']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td><a href="remove-waitlist.php?id=<?php echo $row['id']; ?>"><button class="btn btn-danger">Remove</button></a></td>
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