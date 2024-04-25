<?php
// Include your database configuration file
include_once ('../../../config.php');
try {
    $dataId = $_POST['primary_id'];

    // Start a transaction
    $conn->begin_transaction();

    // First, fetch the associated user ID
    $fetchUserIdSql = "SELECT user_id FROM admins WHERE id = ?";
    $fetchUserIdStmt = $conn->prepare($fetchUserIdSql);
    $fetchUserIdStmt->bind_param("i", $dataId);
    $fetchUserIdStmt->execute();
    $fetchUserIdResult = $fetchUserIdStmt->get_result();
    $userId = $fetchUserIdResult->fetch_assoc()['user_id'];

    // Second, delete the admin record
    $adminDeleteSql = "DELETE FROM admins WHERE id = ?";
    $adminStmt = $conn->prepare($adminDeleteSql);
    $adminStmt->bind_param("i", $dataId);

    // Third, delete the associated user record
    $userDeleteSql = "DELETE FROM users WHERE id = ?";
    $userStmt = $conn->prepare($userDeleteSql);
    $userStmt->bind_param("i", $userId);

    // Execute all delete statements
    $adminDeleteSuccess = $adminStmt->execute();
    $userDeleteSuccess = $userStmt->execute();

    if ($adminDeleteSuccess && $userDeleteSuccess) {
        // Commit the transaction if both deletions are successful
        $conn->commit();
        echo 'Success';
    } else {
        // Rollback the transaction if any deletion fails
        $conn->rollback();
        throw new Exception('Error deleting data');
    }

    // Close the prepared statements
    $fetchUserIdStmt->close();
    $adminStmt->close();
    $userStmt->close();

    // Close the database connection
    $conn->close();
} catch (Exception $e) {
    // Handle exceptions (e.g., log the error and provide a user-friendly message)
    echo 'Error: ' . $e->getMessage();
}
?>