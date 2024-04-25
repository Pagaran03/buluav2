<?php
// Include your database configuration file
include_once ('../../../config.php');

// Set appropriate response headers
header('Content-Type: text/plain'); // Set the content type to plain text
header('X-Content-Type-Options: nosniff'); // Prevent browsers from interpreting files as a different MIME type
header('X-Frame-Options: DENY'); // Prevent clickjacking attacks
header('Referrer-Policy: strict-origin-when-cross-origin'); // Control referrer information sent to other sites
header('X-XSS-Protection: 1; mode=block'); // Enable XSS (Cross-Site Scripting) protection
// Function to sanitize input
function sanitize_input($input)
{
    //   // Remove all HTML tags using preg_replace
    //   $input = preg_replace("/<[^>]*>/", "", trim($input));
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
      //Remove script and content characters
      $input = preg_replace("/<script[^>]*>(.*?)<\/script>/is", "", $input);
      return $input;
}

try {
    // Retrieve and sanitize data from the POST request
    $primary_id = sanitize_input($_POST['primary_id']);
    $firstName = sanitize_input($_POST['first_name']);
    $lastName = sanitize_input($_POST['last_name']);
    $birthdate = sanitize_input($_POST['birthdate']);
    $address = sanitize_input($_POST['address']);
    $username = sanitize_input($_POST['username']);
    $password = ($_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Start a transaction
    $conn->begin_transaction();

    // Check if the new username already exists
    $check_username_sql = "SELECT COUNT(*) FROM users WHERE username = ? AND id != (SELECT user_id FROM staffs WHERE id = ?)";
    $check_username_stmt = $conn->prepare($check_username_sql);
    if (!$check_username_stmt) {
        throw new Exception("Failed to prepare statement: " . $conn->error);
    }
    $check_username_stmt->bind_param("si", $username, $primary_id);
    $check_username_stmt->execute();
    $check_username_result = $check_username_stmt->get_result()->fetch_assoc();

    if ($check_username_result['COUNT(*)'] > 0) {
        // Username already exists, throw an error
        echo 'Invalid Username. Please choose a different one.';
        exit; // Stop execution further
    }

    // Prepare and execute the update statement for the staffs table
    $staffsUpdateSql = "UPDATE staffs SET first_name=?, last_name=?, birthdate=?, address=? WHERE id=?";
    $staffsStmt = $conn->prepare($staffsUpdateSql);
    if (!$staffsStmt) {
        throw new Exception("Failed to prepare statement: " . $conn->error);
    }
    $staffsStmt->bind_param("ssssi", $firstName, $lastName, $birthdate, $address, $primary_id);
    $staffsUpdateSuccess = $staffsStmt->execute();

    $usersUpdateSuccess = false; // Initialize variable

    if (!empty ($password)) {
        // If password is provided, update the users table with username and password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $usersUpdateSql = "UPDATE users SET username=?, password=? WHERE id=(SELECT user_id FROM staffs WHERE id=?)";
        $usersStmt = $conn->prepare($usersUpdateSql);
        if (!$usersStmt) {
            throw new Exception("Failed to prepare statement: " . $conn->error);
        }
        $usersStmt->bind_param("ssi", $username, $hashed_password, $primary_id);
        $usersUpdateSuccess = $usersStmt->execute();
    } else {
        // If password is not provided, update the users table with username only
        $usersUpdateSql = "UPDATE users SET username=? WHERE id=(SELECT user_id FROM staffs WHERE id=?)";
        $usersStmt = $conn->prepare($usersUpdateSql);
        if (!$usersStmt) {
            throw new Exception("Failed to prepare statement: " . $conn->error);
        }
        $usersStmt->bind_param("si", $username, $primary_id);
        $usersUpdateSuccess = $usersStmt->execute();
    }

    if ($staffsUpdateSuccess && $usersUpdateSuccess) {
        // Commit the transaction if both updates are successful
        $conn->commit();
        echo 'Success';
    } else {
        // Rollback the transaction if any update fails
        $conn->rollback();
        throw new Exception('Error updating data');
    }

    // Close the prepared statements
    $staffsStmt->close();
    $usersStmt->close();
    $check_username_stmt->close();

    // Close the database connection
    $conn->close();
} catch (Exception $e) {
    // Handle exceptions
    header('HTTP/1.1 500 Internal Server Error');
    echo 'Error: ' . $e->getMessage();
}
?>