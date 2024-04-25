<?php
// Assuming you have a database connection established already

// Retrieve the selected status from the AJAX request
$status = $_POST['status'];

// Construct your SQL query based on the selected status
if ($status == 'All') {
    $sql = "SELECT * FROM fp_consultation";
} else {
    $sql = "SELECT * FROM fp_consultation WHERE status = '$status'";
}


// Close the database connection
$conn->close();
?>