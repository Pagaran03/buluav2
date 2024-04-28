<?php
// Include your database configuration file
include_once ('../../../config.php');

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

$primary_id = sanitizeInput($_POST['primary_id']);
$status = sanitizeInput($_POST['status']);
$description = sanitizeInput($_POST['description']);
$nurse_id = sanitizeInput($_POST['nurse_id']);
$checkup_date = sanitizeInput($_POST['checkup_date']);

try {
    // Start a transaction
    $conn->begin_transaction();

    $immunizationUpdateSql = "UPDATE immunization SET status=?, description=?, nurse_id=?, checkup_date=? WHERE id=?";
    $immunizationStmt = $conn->prepare($immunizationUpdateSql);
    $immunizationStmt->bind_param("ssssi", $status, $description, $nurse_id, $checkup_date, $primary_id);

    // Execute the update statement
    $immunizationUpdateSuccess = $immunizationStmt->execute();

    if ($immunizationUpdateSuccess) {
        // Commit the transaction if the update is successful
        $conn->commit();
        echo 'Success';
    } else {
        // Rollback the transaction if the update fails
        $conn->rollback();
        throw new Exception('Error updating data');
    }

    // Close the prepared statement
    $immunizationStmt->close();

    // Close the database connection
    $conn->close();
} catch (Exception $e) {
    // Handle exceptions (e.g., log the error and provide a user-friendly message)
    header('HTTP/1.1 500 Internal Server Error');
    echo 'Error: ' . $e->getMessage();
}
?>