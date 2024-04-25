<?php
// Include your database configuration file
include_once ('../../../config.php');

// Set appropriate response headers
header('Content-Type: text/plain'); // Set the content type to plain text
header('X-Content-Type-Options: nosniff'); // Prevent browsers from interpreting files as a different MIME type

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
    // Get data from the POST request and sanitize it
    $first_name = sanitize_input($_POST['first_name']);
    $last_name = sanitize_input($_POST['last_name']);
    $birthdate = sanitize_input($_POST['birthdate']);
    $address = sanitize_input($_POST['address']);
    $username = sanitize_input($_POST['username']);
    $password = sanitize_input($_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Start a transaction to ensure data consistency
    $conn->begin_transaction();
    $role = 'Superadmin';

    // Check if the username already exists
    $check_username_sql = "SELECT COUNT(*) FROM users WHERE username = ?";
    $check_username_stmt = $conn->prepare($check_username_sql);
    $check_username_stmt->bind_param("s", $username);
    $check_username_stmt->execute();
    $check_username_result = $check_username_stmt->get_result()->fetch_assoc();

    if ($check_username_result['COUNT(*)'] > 0) {
        // Username already exists, throw an error
        echo 'Invalid Username. Please choose a different one.';
        exit; // Stop execution further
    }

    // Insert data into the "users" table
    $user_sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
    $user_stmt = $conn->prepare($user_sql);
    $user_stmt->bind_param("sss", $username, $hashed_password, $role);

    if ($user_stmt->execute()) {
        // Get the last inserted user ID
        $user_id = $conn->insert_id;

        $staff_sql = "INSERT INTO superadmins (user_id, first_name, last_name, birthdate, address) VALUES (?, ?, ?, ?, ?)";
        $staff_stmt = $conn->prepare($staff_sql);
        $staff_stmt->bind_param("issss", $user_id, $first_name, $last_name, $birthdate, $address);

        if ($staff_stmt->execute()) {
            // Commit the transaction if both inserts were successful
            $conn->commit();
            echo 'Success';
        } else {
            // Rollback the transaction on failure
            $conn->rollback();
            echo 'Error: ' . $staff_stmt->error;
        }

        $staff_stmt->close();
    } else {
        // Error handling for the "users" table insert
        echo 'Error: ' . $user_stmt->error;
    }

    // Close prepared statements and the database connection
    $user_stmt->close();
    $check_username_stmt->close();
    $conn->close();
} catch (Exception $e) {
    // Handle exceptions
    header('HTTP/1.1 500 Internal Server Error');
    echo 'Error: ' . $e->getMessage();
}
?>