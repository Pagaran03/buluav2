<?php
// Include your database configuration file
include_once ('../../../config.php');


$sql = "SELECT *,prenatal_subjective.id as id,CONCAT(patients.last_name, ' , ', patients.first_name) AS full_name,patients.serial_no as serial_no
FROM prenatal_subjective
JOIN patients ON prenatal_subjective.patient_id = patients.id WHERE prenatal_subjective.is_deleted = 0";

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