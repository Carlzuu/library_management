<?php
session_start();
include ('connection.php');
$name = $_SESSION['user_name'];
$ids = $_SESSION['id'];
if(empty($ids))
{
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
            <h2>View Book</h2>
          </li>
          
        </ol>

        <div class="card mb-3">
    <div class="card-header">
        <i class="fa fa-info-circle"></i>
        <div>View Book Details</div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Book Title</th>
                        <th>Category</th>
                        <th>Issue Date</th>
                        <th>Due Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $select_query = mysqli_query($conn, "select tbl_issue.book_id, tbl_book.book_name, tbl_book.category, tbl_issue.issue_date, tbl_issue.due_date from tbl_issue inner join tbl_book on tbl_issue.book_id=tbl_book.id where tbl_issue.user_id='$ids' and tbl_issue.status=1");
                    $sn = 1;
                    while($row = mysqli_fetch_array($select_query)) { 
                        // Get current date and due date
                        $current_date = date('Y-m-d');
                        $due_date = $row['due_date'];
                        ?>
                        <tr>
                            <td><?php echo $sn; ?></td>
                            <td><?php echo $row['book_name']; ?></td>
                            <td><?php echo $row['category']; ?></td>
                            <td><?php echo $row['issue_date']; ?></td>
                            <td>
                                <?php echo $due_date; ?>
                                <?php 
                                // Check if the due date has passed
                                if ($current_date > $due_date) {
                                    echo ' <span class="badge badge-danger">Overdue</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <a href="book-return.php?id=<?php echo $row['book_id']; ?>"><button class="btn btn-success">Return</button></a>
                            </td>
                        </tr>
                        <?php 
                        $sn++;
                    } 
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>
<?php include('include/footer.php'); ?>
