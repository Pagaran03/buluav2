<?php
// Include your database configuration file
include_once('../../../config.php');

// Set appropriate response headers
header('Content-Type: text/plain'); // Set the content type to plain text
header('X-Content-Type-Options: nosniff'); // Prevent browsers from interpreting files as a different MIME type

// Function to sanitize user input
function sanitizeInput($input)
{
    // Allow only specific HTML tags (in this case, <h1> is allowed)
    $allowedTags = '<h1>';
    return htmlspecialchars(strip_tags(trim($input), $allowedTags), ENT_QUOTES, 'UTF-8');
}

// Function to validate and sanitize user input for SQL queries
function validateAndSanitizeInput($input)
{
    // Implement additional validation if needed
    return sanitizeInput($input);
}

// Get data from the POST request and sanitize it
$first_name_child = validateAndSanitizeInput($_POST['first_name_child']);
$last_name_child = validateAndSanitizeInput($_POST['last_name_child']);
$middle_name_child = validateAndSanitizeInput($_POST['middle_name_child']);
$suffix_child = validateAndSanitizeInput($_POST['suffix_child']);
$gender_child = validateAndSanitizeInput($_POST['gender_child']);
$birthdate_child = validateAndSanitizeInput($_POST['birthdate_child']);
$birth_weight = validateAndSanitizeInput($_POST['birth_weight']);
$birth_height = validateAndSanitizeInput($_POST['birth_height']);
$place_of_birth = validateAndSanitizeInput($_POST['place_of_birth']);

// Check if all required fields are filled
if (empty($first_name_child) || empty($last_name_child) || empty($middle_name_child) || empty($gender_child) || empty($birthdate_child) || empty($birth_weight) || empty($birth_height) || empty($place_of_birth)) {
    echo 'Error: All fields are required';
} else {
    // Insert the child information into the database
    $sql = "INSERT INTO children (first_name, last_name, middle_name, suffix, gender, birthdate, birth_weight, birth_height, place_of_birth) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $first_name_child, $last_name_child, $middle_name_child, $suffix_child, $gender_child, $birthdate_child, $birth_weight, $birth_height, $place_of_birth);

    if ($stmt->execute()) {
        // Successful insertion
        echo 'Success';
    } else {
        // Error handling
        error_log('Error: Database error - ' . $stmt->error);
        echo 'Error: Database error';
    }
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
