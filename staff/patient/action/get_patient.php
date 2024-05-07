<?php
// Include your database configuration file
include_once ('../../../config.php');

// Fetch the latest patient data from the "patients" table

$sql = "SELECT *,CONCAT(patients.last_name, ', ', patients.first_name) AS full_name,CONCAT(children.last_name_child, ', ', children.first_name_child) AS Child
FROM patients 
JOIN children ON patients.id = children.id
WHERE is_active = 0 AND patients.is_deleted = 0 ORDER BY serial_no DESC";

$result = $conn->query($sql);

$patients = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $patients[] = $row;
    }
}

// Close the database connection
$conn->close();

// Return the patient data as JSON
echo json_encode($patients);
?>