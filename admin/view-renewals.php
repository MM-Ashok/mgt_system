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
                    <a href="#">View Renewal Requests</a>
                </li>
            </ol>
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fa fa-info-circle"></i>
                    Renewal Requests
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Book Name</th>
                                    <th>User Name</th>
                                    <th>Requested At</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                               
                               $select_query = mysqli_query($conn, "
                               SELECT tbl_renewals.*, tbl_book.book_name, tbl_users.user_name
                               FROM tbl_renewals
                               INNER JOIN tbl_book ON tbl_renewals.book_id = tbl_book.id
                               INNER JOIN tbl_users ON tbl_renewals.user_id = tbl_users.id;
                               ");
                               

                               
                               
                               $sn = 1;
                                while ($row = mysqli_fetch_assoc($select_query)) { ?>
                                    <tr>
                                        <td><?php echo $sn; ?></td>
                                        <td><?php echo $row['book_name']; ?></td>

                                        <td><?php echo $row['user_name']; ?></td>

                                        <td><?php echo $row['requested_at']; ?></td>
                                        <td><?php echo $row['status']; ?></td>
                                        <?php
                                        if (!empty($row['status']) && $row['status'] == 'approved') { ?>
                                            <td><span class="badge badge-primary">Accepted</span>

                                            </td>
                                        <?php
                                        } else if ($row['status'] == 'rejected') { ?>
                                            <td><span class="badge badge-danger">Rejected</span>
                                                <a href="approve-renewal.php?id=<?php echo $row['id']; ?>"><button class="btn btn-success">Accept</button></a>
                                            </td>
                                        <?php } else { ?>
                                            <td><a href="approve-renewal.php?id=<?php echo $row['id']; ?>"><button class="btn btn-success">Accept</button></a>
                                                <a href="reject-renewal.php?id=<?php echo $row['id']; ?>"><button class="btn btn-danger">Reject</button></a>
                                            </td>
                                        <?php } ?>
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