<?php
// Include your database configuration file
include_once ('../../../config.php');


$dataId = $_POST['primary_id'];

try {

    $sql = "SELECT *,consultations.id as id,CONCAT(patients.first_name, ' ', patients.last_name) AS full_name
    FROM consultations
    JOIN superadmins ON consultations.doctor_id = superadmins.id
    JOIN patients ON consultations.patient_id = patients.id
    LEFT JOIN fp_physical_examination ON fp_physical_examination.consultation_id = consultations.id
    LEFT JOIN fp_medical_history ON fp_medical_history.consultation_id = consultations.id
    WHERE consultations.id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $dataId);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $myData = $result->fetch_assoc();


        header('Content-Type: application/json');
        echo json_encode($myData);
    } else {
        throw new Exception('Error fetching  data: ' . $stmt->error);
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    // Handle exceptions (e.g., log the error and provide a user-friendly message)
    header('HTTP/1.1 500 Internal Server Error');
    echo 'Error: ' . $e->getMessage();
}
?>