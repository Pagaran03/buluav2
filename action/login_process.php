<?php
session_start();
include_once('../config.php');

define('ADMIN_DASHBOARD', '../admin/dashboard/dashboard.php');
define('SUPERADMIN_DASHBOARD', '../superadmin/dashboard/dashboard.php');
define('NURSE_DASHBOARD', '../nurse/dashboard/dashboard.php');
define('MIDWIFE_DASHBOARD', '../midwife/dashboard/dashboard.php');
define('STAFF_DASHBOARD', '../staff/dashboard/dashboard.php');

// Check if the user has already visited the website in this session
if (isset($_SESSION['visited'])) {
    // Redirect the user to the index page or any other appropriate page
    header("Location: ../index.php");
    exit;
}

// Check if the ban has been triggered
if (isset($_SESSION['ban_timestamp']) && time() - $_SESSION['ban_timestamp'] < 20) {
    // Ban is still active, redirect the user back to the index page
    $_SESSION['login_error'] = "Too many failed login attempts. Please try again later.";
    header("Location: ../index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT id, role, password, is_deleted FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the username is found
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashed_password = $row["password"];
        $is_deleted = $row["is_deleted"];

        // Check if the account is already marked as deleted
        if ($is_deleted == 1) {
            echo "This account has been deactivated. Please contact support.";
            exit;
        }

        // Verify the entered password with the hashed password from the database
        if (password_verify($password, $hashed_password)) {
            // Successful login, reset login attempts and ban timestamp
            unset($_SESSION['login_attempts']);
            unset($_SESSION['ban_timestamp']);

            // Save login information to the logs table
            $user_id = $row["id"];
            date_default_timezone_set('Asia/Manila');
            $login_time = date("Y-m-d h:i:s a");

            $login_date = date("Y-m-d");
            $login_type = "login";

            $sql = "INSERT INTO logs (user_id, time, date, type) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("isss", $user_id, $login_time, $login_date, $login_type);

                if ($stmt->execute()) {
                    // Successful insertion
                    echo 'Success';

                    // Set session variables
                    $_SESSION["username"] = $username;
                    $_SESSION["role"] = $row["role"];
                    $_SESSION["user_id"] = $user_id;

                    // Mark the user as visited
                    $_SESSION['visited'] = true;

                    switch ($_SESSION["role"]) {
                        case "admin":
                            header("Location: " . ADMIN_DASHBOARD);
                            exit;
                        case "superadmin":
                            header("Location: " . SUPERADMIN_DASHBOARD);
                            exit;
                        case "nurse":
                            header("Location: " . NURSE_DASHBOARD);
                            exit;
                        case "midwife":
                            header("Location: " . MIDWIFE_DASHBOARD);
                            exit;
                        case "staff":
                            header("Location: " . STAFF_DASHBOARD);
                            exit;
                        default:
                            echo "Invalid role!";
                            exit;
                    }
                } else {
                    // Error handling for execute
                    echo 'Error: ' . $stmt->error;
                }

                $stmt->close();
            } else {
                // Error handling for prepare
                echo 'Error preparing statement: ' . $conn->error;
            }
        } else {
            // Failed login attempt
            trigger_ban();
        }
    } else {
        // Username not found
        trigger_ban();
    }
}

// Authentication failed
$_SESSION['login_error'] = "Invalid Username or Password";
header("Location: ../index.php");
exit;


$conn->close();

function trigger_ban()
{
    if (!isset($_SESSION['login_attempts'])) {
        // Initialize the session for login attempts
        $_SESSION['login_attempts'] = array(
            'count' => 1
        );
    } else {
        // Increment the login attempts counter
        $_SESSION['login_attempts']['count']++;
    }

    // Check if the number of attempts exceeds 3
    if ($_SESSION['login_attempts']['count'] > 2) {
        // Set the ban timestamp in the session
        $_SESSION['ban_timestamp'] = time();
        $_SESSION['login_error'] = "Too many failed login attempts. Please try again later.";
        header("Location: ../index.php");
        exit;
    }
}
?>
