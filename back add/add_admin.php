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

// Generate base username
$currentYear = date('y'); // Get current year in two-digit format
$birthDateFormatted = date('dm', strtotime($birthdate)); // Format birthdate as ddmm
$base_username = $currentYear . $birthDateFormatted;

// Start a transaction to ensure data consistency
$conn->begin_transaction();
$role = 'Admin';

// Check if a username starting with the base exists and generate a unique one
$check_username_sql = "SELECT username FROM users WHERE username LIKE ?";
$check_username_stmt = $conn->prepare($check_username_sql);
$check_username_like = $base_username . '%';
$check_username_stmt->bind_param("s", $check_username_like);
$check_username_stmt->execute();
$check_username_result = $check_username_stmt->get_result();

$username = $base_username;
if ($check_username_result->num_rows > 0) {
    $usernames = [];
    while ($row = $check_username_result->fetch_assoc()) {
        $usernames[] = $row['username'];
    }
    // Append a number to base_username to make it unique
    $i = 1;
    while (in_array($username, $usernames)) {
        $username = $base_username . str_pad($i, 2, '0', STR_PAD_LEFT);
        $i++;
    }
}

// Insert data into the "users" table
$user_sql = "INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)";
$user_stmt = $conn->prepare($user_sql);
$user_stmt->bind_param("ssss", $username, $hashed_password, $email, $role);

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
}

// Close prepared statements and the database connection
$check_username_stmt->close();
$user_stmt->close();
$conn->close();
?>