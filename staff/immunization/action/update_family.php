<?php
// Include your database configuration file
include_once('../../../config.php');

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
    // $input = preg_replace("/[\x00-\x1F\s]+/", "", $input);
    // Remove script and content characters
    $input = preg_replace("/<script[^>]*>(.*?)<\/script>/is", "", $input);
    return $input;
}

$primary_id = sanitizeInput($_POST['primary_id']);
$status = sanitizeInput($_POST['status']);
$steps = sanitizeInput($_POST['steps']);
$description = sanitizeInput($_POST['description']);
$nurse_id = sanitizeInput($_POST['nurse_id']);
$checkup_date = sanitizeInput($_POST['checkup_date']);
$today_date = date("Y-m-d");
try {
    // Start a transaction
    $conn->begin_transaction();

    $immunizationUpdateSql = "UPDATE immunization SET status=?, steps=?, description=?, nurse_id=?, checkup_date=? WHERE id=?";
    $immunizationStmt = $conn->prepare($immunizationUpdateSql);
    $immunizationStmt->bind_param("sssssi", $status, $steps, $description, $nurse_id, $checkup_date, $primary_id);

    // Execute the update statement
    $immunizationUpdateSuccess = $immunizationStmt->execute();

    $getImmuPID = "SELECT patient_id FROM immunization WHERE id = ?";
    $getImmuPIDStmt = $conn->prepare($getImmuPID);
    $getImmuPIDStmt->bind_param("i", $primary_id);
    $getImmuPIDStmt->execute();
    $getImmuPIDResult = $getImmuPIDStmt->get_result();
    $ImmuPID = $getImmuPIDResult->fetch_assoc();

    // Execute the SQL statement to get patient information
    $getPatientInfoSql = "SELECT contact_no, first_name, last_name FROM patients WHERE id=?";
    $getPatientInfoStmt = $conn->prepare($getPatientInfoSql);
    $getPatientInfoStmt->bind_param("i", $ImmuPID['patient_id']);
    $getPatientInfoStmt->execute();
    $getPatientInfoResult = $getPatientInfoStmt->get_result();
    $patientInfo = $getPatientInfoResult->fetch_assoc();

    if ($immunizationUpdateSuccess) {
        if ($conn->commit()) {
            echo 'Success';
            $contact_no = $patientInfo['contact_no'];
            $first_name = $patientInfo['first_name'];
            $last_name = $patientInfo['last_name'];
            $fullname = $first_name." ".$last_name;
            
            // Check if the checkup date is today and send SMS if it's not
            if ($checkup_date != $today_date) {
                $date = DateTime::createFromFormat('Ymd', $checkup_date);
                $formatted_date = $date->format('Y F d');
                sendSMS($contact_no, $fullname, $formatted_date, $description);
            }

        } else {
            echo 'error';
        }
    } else {
        // Rollback the transaction if the update fails
        $conn->rollback();
        throw new Exception('Error updating data');
    }

    // Close the prepared statements
    $immunizationStmt->close();
    $getPatientInfoStmt->close();

    // Close the database connection
    $conn->close();
} catch (Exception $e) {
    header('HTTP/1.1 500 Internal Server Error');
    echo 'Error: ' . $e->getMessage();
}

function sendSMS($phoneNumber, $patient_name, $date, $vacc)
{
    $ch = curl_init();
    $parameters = array(
        'apikey' => '92a2c5a6f73bab6ad2b179b4e81a4b53',
        'number' => $phoneNumber,
        'message' => 'Hello ' . $patient_name . ' this message is to notify you to comeback on '.$date.' for the '.$vacc.'. Please don`t forget to bring the following: -Child Immunization Record Card',
        'sendername' => 'SEMAPHORE'
    );
    curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
    curl_setopt($ch, CURLOPT_POST, 1);

    //Send the parameters set above with the request
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));

    // Receive response from server
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);

    // Show the server response
    // echo '<script>console.log('.$output.')</script>';
}

