<?php
// Include your database configuration file
include_once ('../../../config.php');


$sql = "SELECT *,consultations.id as id,CONCAT(patients.last_name,',',patients.first_name) AS full_name
FROM consultations
JOIN patients ON consultations.patient_id = patients.id
WHERE consultations.is_active = 0 AND  consultations.is_deleted=0";


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