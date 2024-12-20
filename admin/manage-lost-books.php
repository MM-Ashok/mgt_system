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
                    <a href="#">View Lost Books</a>
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
                                    <th>S.No</th>
                                    <th>Book Name</th>
                                    <th>Fine (Rs)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                              
                                $query = mysqli_query($conn, "SELECT tbl_issue.book_id, tbl_book.book_name, tbl_issue.user_id, tbl_fines.fine_amount FROM tbl_issue 
                                INNER JOIN tbl_book ON tbl_issue.book_id = tbl_book.id LEFT JOIN tbl_fines ON tbl_issue.book_id = tbl_fines.book_id WHERE tbl_issue.is_lost = 1");
                                $sn = 1;
                                while ($row = mysqli_fetch_assoc($query)) {
                                ?>
                                    <tr>
                                        <td><?php echo $sn; ?></td>
                                        <td><?php echo $row['book_name']; ?></td>
                                        <td>
                                            <span id="fine-<?php echo $row['user_id']; ?>"><?php echo $row['fine_amount']; ?></span>
                                            <a href="#" class="edit-fine" data-id="<?php echo $row['user_id']; ?>" data-fine="<?php echo $row['fine_amount']; ?>"><i class="fa fa-pencil m-r-5"></i>Edit</a>
                                        </td>
                                        <td>
                                            <a href="mark-fine-paid.php?id=<?php echo $row['user_id']; ?>"><i class="fa fa-pencil m-r-5"></i>Mark Fine as Paid</a>
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


<!-- Modal for editing fine amount -->
<div id="editFineModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form id="editFineForm">
            <input type="hidden" id="fineId" name="id">
            <label for="fineAmount">Fine Amount (Rs):</label>
            <input type="text" id="fineAmount" name="fineAmount">
            <button type="submit">Save</button>
        </form>
    </div>
</div>

<!-- Modal CSS for center alignment -->
<style>
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    width: 300px;
    background-color: #fff;
    padding: 20px;
    border: 1px solid #888;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    box-sizing: border-box;
    height: 20% !important;
}

.modal-content {
    text-align: center;
}

.close {
    position: absolute;
    right: 10px;
    top: 10px;
    cursor: pointer;
}

input[type="text"] {
    width: 100%;
    padding: 8px;
    margin: 8px 0;
}

button {
    padding: 10px 20px;
    background-color: #28a745;
    border: none;
    color: white;
    cursor: pointer;
}

button:hover {
    background-color: #218838;
}
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // When the user clicks on the Edit link, open the modal
    $('.edit-fine').on('click', function(event) {
        event.preventDefault();
        var id = $(this).data('id');
        var fine = $(this).data('fine');
        $('#fineId').val(id);
        $('#fineAmount').val(fine);
        $('#editFineModal').show();
    });

    // When the user clicks on <span> (x), close the modal
    $('.close').on('click', function() {
        $('#editFineModal').hide();
    });

    // When the user submits the form, update the fine amount
    $('#editFineForm').on('submit', function(e) {
        e.preventDefault();
        var id = $('#fineId').val();
        var fine = $('#fineAmount').val();
        console.log(id);
        console.log(fine);

        // Ajax request to update fine amount in database
        $.ajax({
            type: 'POST',
            url: 'update-fine.php',
            data: { id: id, fineAmount: fine },
            success: function(response) {
                // On success, update the fine amount in the table without reloading
                $('#fine-' + id).text(fine);
                $('#editFineModal').hide();
            },
            error: function() {
                alert('Error updating fine amount');
            }
        });
    });
});
</script>
