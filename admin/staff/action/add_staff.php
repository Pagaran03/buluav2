<?php
// Include your database configuration file
include_once ('../../../config.php');

// Set appropriate response headers
header('Content-Type: text/plain'); // Set the content type to plain text
header('X-Content-Type-Options: nosniff'); // Prevent browsers from interpreting files as a different MIME type

// Function to sanitize input
function sanitize_input($input)
{
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

try {
    // Get and sanitize data from the POST request
    $first_name = sanitize_input($_POST['first_name']);
    $last_name = sanitize_input($_POST['last_name']);
    $birthdate = sanitize_input($_POST['birthdate']);
    $address = sanitize_input($_POST['address']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = sanitize_input($_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Start a transaction to ensure data consistency
    $conn->begin_transaction();
    $role = 'staff';

    // Check if the email already exists
    $check_email_sql = "SELECT COUNT(*) FROM users WHERE email = ?";
    $check_email_stmt = $conn->prepare($check_email_sql);
    $check_email_stmt->bind_param("s", $email);
    $check_email_stmt->execute();
    $check_email_result = $check_email_stmt->get_result()->fetch_assoc();

    if ($check_email_result['COUNT(*)'] > 0) {
        // Email already exists, throw an error
        echo 'Invalid Email. Please choose a different one.';
        exit; // Stop execution further
    }

    // Insert data into the "users" table
    $user_sql = "INSERT INTO users (password, email, role) VALUES (?, ?, ?)";
    $user_stmt = $conn->prepare($user_sql);
    $user_stmt->bind_param("sss", $hashed_password, $email, $role);

    if ($user_stmt->execute()) {
        // Get the last inserted user ID
        $user_id = $conn->insert_id;

        // Insert data into the "staffs" table with the user ID as a foreign key
        $staff_sql = "INSERT INTO staffs (user_id, first_name, last_name, birthdate, address) VALUES (?, ?, ?, ?, ?)";
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
    $check_email_stmt->close();
    $conn->close();
} catch (Exception $e) {
    // Handle exceptions
    header('HTTP/1.1 500 Internal Server Error');
    echo 'Error: ' . $e->getMessage();
}
?>
