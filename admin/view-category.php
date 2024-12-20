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
          <a href="#">View Category</a>
        </li>

      </ol>

      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-info-circle"></i>
          View Details
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>S.No.</th>
                  <th>Category Name</th>
                  <th>Status</th>
                  <th>Available books</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if (isset($_GET['ids'])) {
                  $id = $_GET['ids'];
                  $delete_query = mysqli_query($conn, "delete from tbl_category where id='$id'");
                }
                $select_query = mysqli_query($conn, "select * from tbl_category");
                $sn = 1;
                while ($row = mysqli_fetch_array($select_query)) {
                  $category_name = $row['category_name'];
                  $book_count_query = mysqli_query($conn, "SELECT book_name FROM tbl_book WHERE category = '$category_name' AND availability = 1");
                  $book_count_result = mysqli_fetch_assoc($book_count_query);

                ?>
                  <tr>
                    <td><?php echo $sn; ?></td>
                    <td><?php echo $row['category_name']; ?></td>

                    <?php if ($row['status'] == 1) {
                    ?><td><span class="badge badge-success">Active</span></td>
                    <?php } else { ?><td><span class="badge badge-danger">Inactive</span></td>
                    <?php } ?>
                    <!-- <td><?php //echo $book_count_result['book_name']; ?></td> -->

                    <td>
                      <?php
                      if ($book_count_result) {
                        echo $book_count_result['book_name'];
                      } else {
                        echo "No book found in this category";
                      }
                      ?>
                    </td>

                    <td>
                      <a href="edit-category.php?id=<?php echo $row['id']; ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                      <a href="view-category.php?ids=<?php echo $row['id']; ?>" onclick="return confirmDelete()"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
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
  <script language="JavaScript" type="text/javascript">
    function confirmDelete() {
      return confirm('Are you sure want to delete this Category?');
    }
  </script>