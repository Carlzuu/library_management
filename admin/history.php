<?php
session_start();
include ('../connection.php');
$name = $_SESSION['name'];
$id = $_SESSION['id'];
if(empty($id))
{
    header("Location: index.php"); 
}

// Include header
include('include/header.php');

// Check if book has been returned and update history
if(isset($_GET['book_id']) && isset($_GET['user_id']) && isset($_GET['return_date'])) {
    $book_id = $_GET['book_id'];
    $user_id = $_GET['user_id'];
    $return_date = $_GET['return_date'];
    
    // Update borrowed book history with return date and status
    $update_query = mysqli_query($conn, "UPDATE tbl_return SET return_date='$return_date', status='returned' WHERE book_id='$book_id' AND user_id='$user_id'");
    if(!$update_query) {
        echo "Error updating borrowed book history: " . mysqli_error($conn);
    }
}

?>

<div id="wrapper">
    <?php include('include/side-bar.php'); ?>

    <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <h2>Returned Books History</h2>
                </li>
            </ol>

            <!-- Search input -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <input type="search" class="form-control form-control-sm" id="searchInput" placeholder="Search" aria-controls="dataTable">
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    <i class="fa fa-info-circle"></i>
                    Borrowed Books History
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Book Name</th>
                                    <th>Borrower Name</th>
                                    <th>Borrowed Date</th>
                                    <th>Return Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                            $select_query = mysqli_query($conn, "SELECT * FROM tbl_return");
                            $sn = 1;
                            while($row = mysqli_fetch_array($select_query))
                            { 
                            ?>
                                <tr>
                                    <td><?php echo $sn; ?></td>
                                    <td><?php echo $row['book_name']; ?></td>
                                    <td><?php echo $row['user_name']; ?></td>
                                    <td><?php echo $row['issue_date']; ?></td>
                                    <td><?php echo $row['return_date']; ?></td>
                                </tr>
                            <?php $sn++; } ?>
                            </tbody>
                        </table>
                    </div>
                </div>                   
            </div>
        </div>
    </div>
</div>

<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<?php include('include/footer.php'); ?>

<script>
    // Filter table rows based on search input
    document.getElementById("searchInput").addEventListener("input", function() {
        var input, filter, table, tr, td, i, txtValue;
        input = this.value.toLowerCase();
        table = document.getElementById("dataTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td");
            var found = false;
            for (var j = 1; j < td.length; j++) {
                txtValue = td[j].textContent || td[j].innerText;
                if (txtValue.toLowerCase().indexOf(input) > -1) {
                    found = true;
                    break;
                }
            }
            if (found) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    });
</script>
