<?php 
session_start();
include ('connection.php');
$name = $_SESSION['user_name'];
$ids = $_SESSION['id'];
$id = $_GET['id'];

// Fetch book name from tbl_book
$select_book = mysqli_query($conn, "SELECT book_name FROM tbl_book WHERE id='$id'");
$book_data = mysqli_fetch_assoc($select_book);
$book_name = $book_data['book_name'];

// Fetch issue date from tbl_issue
$select_issue = mysqli_query($conn, "SELECT issue_date FROM tbl_issue WHERE book_id='$id' AND user_id='$ids'");
$issue_data = mysqli_fetch_assoc($select_issue);
$issue_date = $issue_data['issue_date'];

$delete_book = mysqli_query($conn, "DELETE FROM tbl_issue WHERE book_id='$id' AND user_id='$ids'");
$return_book = mysqli_query($conn, "INSERT INTO tbl_return (book_id, user_id, user_name, book_name, issue_date, return_date) VALUES ('$id', '$ids', '$name', '$book_name', '$issue_date', CURDATE())");
$select_quantity = mysqli_query($conn, "SELECT quantity FROM tbl_book WHERE id='$id'");
$number = mysqli_fetch_row($select_quantity);
$count = $number[0];
$count = $count + 1;
$update_book = mysqli_query($conn, "UPDATE tbl_book SET quantity='$count' WHERE id='$id'");
$update_issue_status = mysqli_query($conn, "UPDATE tbl_issue SET status=0 WHERE book_id='$id' AND user_id='$ids'");
if($update_book > 0)
{
    ?>
<script type="text/javascript">
alert("Book Returned successfully.");
window.location.href="issued-book.php";
</script>
<?php
}
?>
