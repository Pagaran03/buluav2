<?php
// Include your database configuration file
include_once ('../../../config.php');

// Set appropriate response headers
header('Content-Type: text/plain'); // Set the content type to plain text
header('X-Content-Type-Options: nosniff'); // Prevent browsers from interpreting files as a different MIME type
header('X-Frame-Options: DENY'); // Prevent clickjacking attacks
header('Referrer-Policy: strict-origin-when-cross-origin'); // Control referrer information sent to other sites
header('X-XSS-Protection: 1; mode=block'); // Enable XSS (Cross-Site Scripting) protection

function sanitize_input($input)
{
    // Remove all HTML tags using strip_tags
    $input = strip_tags(trim($input));
    // Remove potentially harmful characters using regex
    $input = preg_replace("/[^a-zA-Z0-9.@]/", "", $input);
    // Remove control characters and whitespace
    $input = preg_replace("/[\x00-\x1F\s]+/", "", $input);
    return $input;
}

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
$role = 'Admin';

// Check if the email already exists
$check_email_sql = "SELECT COUNT(*) FROM users WHERE email = ?";
$check_email_stmt = $conn->prepare($check_email_sql);
$check_email_stmt->bind_param("s", $email);
$check_email_stmt->execute();
$check_email_result = $check_email_stmt->get_result()->fetch_assoc();

if ($check_email_result['COUNT(*)'] > 0) {
    // Email already exists, return an error
    echo 'Email already exists. Please use a different one.';
    $conn->rollback();
    exit; // Stop execution further
}

// Insert data into the "users" table
$user_sql = "INSERT INTO users (password, email, role) VALUES (?, ?, ?)";
$user_stmt = $conn->prepare($user_sql);
$user_stmt->bind_param("sss",  $hashed_password, $email, $role);

if ($user_stmt->execute()) {
    // Get the last inserted user ID
    $user_id = $conn->insert_id;

    $staff_sql = "INSERT INTO admins (user_id, first_name, last_name, birthdate, address) VALUES (?, ?, ?, ?, ?)";
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
    $conn->rollback();
}

// Close prepared statements and the database connection
$check_email_stmt->close();
$user_stmt->close();
$conn->close();
?>
