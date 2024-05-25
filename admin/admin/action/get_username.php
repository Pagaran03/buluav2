<?php
// Include your database configuration file
include_once ('../../../config.php');

// Set appropriate response headers
header('Content-Type: text/plain'); // Set the content type to plain text
header('X-Content-Type-Options: nosniff'); // Prevent browsers from interpreting files as a different MIME type
header('X-Frame-Options: DENY'); // Prevent clickjacking attacks
header('Referrer-Policy: strict-origin-when-cross-origin'); // Control referrer information sent to other sites
header('X-XSS-Protection: 1; mode=block'); // Enable XSS (Cross-Site Scripting) protection
// Function to get the next number
function getNextNumber()
{
    global $conn;

    // Get the current year
    $currentYear = date("y");

    // Extract current month and year
    $currentMonth = date("m");
    $currentYear = date("y");

    // Initialize default number
    $defaultNumber = "01";

    // Get the last username with the same prefix
    $sql = "SELECT username FROM users WHERE username LIKE ? ORDER BY username DESC LIMIT 1";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Query preparation failed: " . htmlspecialchars($conn->error));
    }

    // Bind parameter
    $like_prefix = $currentYear . $currentMonth . "%";
    $stmt->bind_param("s", $like_prefix);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $last_username = $result->fetch_assoc();
        $last_number = intval(substr($last_username['username'], -2));
        $defaultNumber = str_pad($last_number + 1, 2, '0', STR_PAD_LEFT);
    }

    // Close the statement
    $stmt->close();

    // Construct the new serial number
    $newSerial = $currentYear . $currentMonth . $defaultNumber;

    // Check if the new serial number already exists
    $sql_check = "SELECT username FROM users WHERE username = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $newSerial);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    // If the serial number already exists, increment the count until it's unique
    while ($result_check->num_rows > 0) {
        $defaultNumber++;
        $defaultNumber = str_pad($defaultNumber, 2, '0', STR_PAD_LEFT);
        $newSerial = $currentYear . $currentMonth . $defaultNumber;

        // Check again if the new serial number already exists
        $stmt_check->bind_param("s", $newSerial);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
    }

    // Close the statement
    $stmt_check->close();

    // Return the new serial number
    return $newSerial;
}

?>