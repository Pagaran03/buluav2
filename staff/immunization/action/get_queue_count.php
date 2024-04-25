<?php
// Include your database configuration file
include_once ('../../../config.php');
session_start();

// Check if the patient ID is sent via POST request
if (isset($_POST['patient_id'])) {
    // Get the patient ID from the POST request
    $patientId = $_POST['patient_id'];

    try {
        // Fetch patient data from the database by ID
        $sql = "SELECT * FROM immunization WHERE queue_status=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $patientId);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $patientData = $result->fetch_assoc();

            // Check if patient data exists
            if ($patientData) {
                // Return the patient data as JSON
                header('Content-Type: application/json');
                echo json_encode($patientData);
            } else {
                // Patient data not found
                header('HTTP/1.1 404 Not Found');
                echo json_encode(array('error' => 'Patient not found'));
            }
        } else {
            throw new Exception('Error executing query: ' . $stmt->error);
        }

        // Close the database connection
        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        // Handle exceptions (e.g., log the error and provide a user-friendly message)
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(array('error' => 'Internal Server Error'));
    }
} else {
    // Patient ID not provided in the request
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(array('error' => 'Patient ID is required'));
}
?>