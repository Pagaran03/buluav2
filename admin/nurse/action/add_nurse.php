<?php
// Set appropriate response headers
header('Content-Type: text/plain'); // Set the content type to plain text
header('X-Content-Type-Options: nosniff'); // Prevent browsers from interpreting files as a different MIME type

// Include your database configuration file
include_once ('../../../config.php');

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

// Function to validate and sanitize user input for SQL queries
function validateAndSanitizeInput($input)
{
    // Implement additional validation if needed
    return sanitize_input($input);
}

try {
    // Get data from the POST request and validate/sanitize
    $first_name = validateAndSanitizeInput($_POST['first_name']);
    $last_name = validateAndSanitizeInput($_POST['last_name']);
    $birthdate = validateAndSanitizeInput($_POST['birthdate']);
    $address = validateAndSanitizeInput($_POST['address']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $username = validateAndSanitizeInput($_POST['username']);
    $password = validateAndSanitizeInput($_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Start a transaction to ensure data consistency
    $conn->begin_transaction();
    $role = 'nurse';

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
    $user_sql = "INSERT INTO users (username, password, email, role) VALUES (?, ?, ?,? )";
    $user_stmt = $conn->prepare($user_sql);
    $user_stmt->bind_param("ssss", $username, $hashed_password, $email, $role);
    if ($user_stmt->execute()) {
        // Get the last inserted user ID
        $user_id = $conn->insert_id;

        // Insert data into the "nurses" table with the user ID as a foreign key
        $nurse_sql = "INSERT INTO nurses (user_id, first_name, last_name, birthdate, address) VALUES (?, ?, ?, ?, ?)";
        $nurse_stmt = $conn->prepare($nurse_sql);
        $nurse_stmt->bind_param("issss", $user_id, $first_name, $last_name, $birthdate, $address);

        if ($nurse_stmt->execute()) {
            // Commit the transaction if both inserts were successful
            $conn->commit();
            echo 'Success';
        } else {
            // Rollback the transaction on failure
            $conn->rollback();
            echo 'Error: ' . $nurse_stmt->error;
        }

        $nurse_stmt->close();
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