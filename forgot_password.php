<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Path to autoload.php of PHPMailer

// Function to generate a random string
function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the username from the form
    $username = $_POST["username"];

    // Connect to your database
    $servername = "localhost";
    $username_db = "root";
    $password_db = "";
    $dbname = "brgy_db";

    // Create connection
    $conn = new mysqli($servername, $username_db, $password_db, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute SQL query to fetch email and role associated with the username
    $sql = "SELECT email, role FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // If username exists, send email with temporary password and update password in database
    if ($result->num_rows > 0) {
        // Fetch email from the result set
        $row = $result->fetch_assoc();
        $email = $row["email"];
        $role = $row["role"];

        // Generate a temporary password
        $temp_password = generateRandomString(10);

        // Hash the temporary password
        $hashed_password = password_hash($temp_password, PASSWORD_DEFAULT);

        // Update password in the database
        $update_sql = "UPDATE users SET password = ? WHERE username = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ss", $hashed_password, $username);
        $update_stmt->execute();

        // Send email with temporary password
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host = 'smtp.gmail.com';                       // Set the SMTP server to send through
            $mail->SMTPAuth = true;                                   // Enable SMTP authentication
            $mail->Username = 'buluahealthc@gmail.com';              // SMTP username
            $mail->Password = 'ooef yhpe fqkg rmyg';                     // SMTP password
            $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            // Recipients
            $mail->setFrom('buluahealthc@gmail.com', 'Brgy Bulua Health Center'); // Set From address and name
            $mail->addAddress($email, 'Recipient Name');  // Add a recipient

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Password Reset';
            $mail->Body = "
            <p><b>Dear! $role </b></p>
                    <p>You are receiving this email because we received a password reset request for your account.</p>
                    <br>
            Your temporary password is: $temp_password <br>
           Please use this password to log into your account.<br>
            ";

            $mail->send();

            // Set session variable for success message
            $_SESSION['message'] = 'Temporary Password has been sent to your Gmail.';
            $_SESSION['message_type'] = 'success';
        } catch (Exception $e) {
            // Set session variable for error message
            $_SESSION['message'] = 'Email could not be sent. Mailer Error: ' . $mail->ErrorInfo;
            $_SESSION['message_type'] = 'error';
        }
    } else {
        // Set session variable for error message
        $_SESSION['message'] = 'Username not found.';
        $_SESSION['message_type'] = 'error';
    }

    // Close database connections
    $stmt->close();
    $update_stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/login.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css"
        integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="myform">
            <h1>Forgot Password</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="form-group">
                    <input type="text" class="form-control" id="username" name="username"
                        placeholder="Enter your Username" required>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Reset Password</button>
            </form>
        </div>
    </div>

    <!-- SweetAlert2 Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Show SweetAlert2 when message is set in session
        <?php if (isset($_SESSION['message'])): ?>
            Swal.fire({
                title: 'Message',
                text: '<?php echo $_SESSION['message']; ?>',
                icon: '<?php echo ($_SESSION['message_type'] === 'success') ? 'success' : 'error'; ?>',
                confirmButtonText: 'Close'
            }).then((result) => {
                if (result.isConfirmed) {
                    redirectToIndex();
                }
            });
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        function redirectToIndex() {
            window.location.href = 'index.php'; // Change 'index.php' to the desired location
        }
    </script>

</body>

</html>