<?php
// Include your database configuration file
include_once ('../../../config.php');
session_start();

// Set appropriate response headers
header("Content-Security-Policy: default-src 'self';"); // Set Content Security Policy header to restrict resource loading
header('Content-Type: text/plain'); // Set the content type to plain text
header('X-Content-Type-Options: nosniff'); // Prevent browsers from interpreting files as a different MIME type
header('X-Frame-Options: DENY'); // Prevent clickjacking attacks
header('Referrer-Policy: strict-origin-when-cross-origin'); // Control referrer information sent to other sites
header('X-XSS-Protection: 1; mode=block'); // Enable XSS (Cross-Site Scripting) protection

// Function to sanitize user input
function sanitizeInput($input)
{
    // Remove all HTML tags using preg_replace
    $input = preg_replace("/<[^>]*>/", "", trim($input));
    // Use regular expression to remove potentially harmful characters
    $input = preg_replace("/[^a-zA-Z0-9\s]/", "", $input);
    // Remove SQL injection characters
    $input = preg_replace("/[;#\*--]/", "", $input);
    // Remove Javascript injection characters
    $input = preg_replace("/[<>\"\']/", "", $input);
    // Remove Shell injection characters
    $input = preg_replace("/[|&\$\>\<'`\"]/", "", $input);
    // Remove URL injection characters
    $input = preg_replace("/[&\?=]/", "", $input);
    // Remove File Path injection characters
    $input = preg_replace("/[\/\\\\\.\.]/", "", $input);
    // Remove control characters and whitespace
    $input = preg_replace("/[\x00-\x1F\s]+/", "", $input);
    // Remove script and content characters
    $input = preg_replace("/<script[^>]*>(.*?)<\/script>/is", "", $input);
    return $input;
}

// Get data from the POST request and sanitize input
$serial_no = sanitizeInput(strip_tags($_POST['patient_id']));
$status = sanitizeInput(strip_tags($_POST['status']));
$description = sanitizeInput(strip_tags($_POST['description']));
$nurse_id = sanitizeInput(strip_tags($_POST['nurse_id']));
$checkup_date = sanitizeInput(strip_tags($_POST['checkup_date']));

$date = date('Y-m-d');
$doctor_id = $_SESSION['user_id'];

// Validate input data if needed
// Add your validation logic here

$sql_patient_id = "SELECT id FROM patients WHERE serial_no = ?";
$stmt_patient_id = $conn->prepare($sql_patient_id);
$stmt_patient_id->bind_param("s", $serial_no);

if ($stmt_patient_id->execute()) {
    $stmt_patient_id->bind_result($patient_id);
    if ($stmt_patient_id->fetch()) {
        // Now you have the patient_id
        $stmt_patient_id->close();

        $sql = "INSERT INTO immunization (patient_id, status, description, nurse_id, checkup_date) 
        VALUES (?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "sssss",
            $patient_id,
            $status,
            $description,
            $nurse_id,
            $checkup_date
        );

        if ($stmt->execute()) {
            // Successful insertion
            echo 'Success';
        } else {
            // Error handling
            echo 'Error: ' . $conn->error;
        }

        // Close the database connection
        $stmt->close();
        $conn->close();
    } else {
        // Patient with the provided serial_no not found
        echo 'Error: Patient not found';
    }
} else {
    // Error executing the query
    echo 'Error: ' . $conn->error;
}
?>