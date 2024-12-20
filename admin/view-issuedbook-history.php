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
                    <a href="#">View Book Issue History</a>
                </li>
            </ol>
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fa fa-info-circle"></i>
                    Issue History
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Book Name</th>
                                    <th>User Name</th>
                                    <th>Issue Date</th>
                                    <th>Return Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $select_query = mysqli_query($conn, "select tbl_issue.status, tbl_issue.book_id, tbl_book.book_name, tbl_issue.id, tbl_issue.user_name, tbl_book.quantity , tbl_issue.issue_date,tbl_issue.due_date from tbl_issue inner join tbl_book on tbl_book.id=tbl_issue.book_id");
                                $sn = 1;
                                while ($row = mysqli_fetch_array($select_query)) { ?>
                                    <tr>
                                        <td><?php echo $sn; ?></td>
                                        <td><?php echo $row['book_name']; ?></td>
                                        <td><?php echo $row['user_name']; ?></td>
                                        <td><?php echo $row['issue_date']; ?></td>
                                        <td><?php echo $row['due_date']; ?></td>
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