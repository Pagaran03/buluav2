<?php
// Include your database configuration file
include_once ('../../../config.php');

$date = date('Y-m-d');

if (isset($_GET['date'])) {
    $selected_date = date('Y-m-d', strtotime($_GET['date']));
    $date = $selected_date;
}

$sql = "SELECT *, consultations.id AS id, CONCAT(patients.last_name, ',', patients.first_name) AS full_name
        FROM consultations
        JOIN patients ON consultations.patient_id = patients.id
        WHERE consultations.is_active = 0 AND consultations.is_deleted = 0 AND checkup_date = '$date'";


$result = $conn->query($sql);

$myData = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $myData[] = $row;
    }
}

// Close the database connection
$conn->close();


echo json_encode($myData);
?>