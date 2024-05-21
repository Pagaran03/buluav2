<?php
session_start();

require 'vendor/autoload.php';
require 'config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
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
            // Server settings
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host = 'smtp.gmail.com';                       // Set the SMTP server to send through
            $mail->SMTPAuth = true;                                   // Enable SMTP authentication
            $mail->Username = $_ENV['SMTP_USERNAME'];              // SMTP username from environment variable
            $mail->Password = $_ENV['SMTP_PASSWORD'];              // SMTP password from environment variable
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;    // Enable TLS encryption
            $mail->Port = 587;                                    // TCP port to connect to

            // Recipients
            $mail->setFrom('buluahealthc@gmail.com', 'Brgy Bulua Health Center'); // Set From address and name
            $mail->addAddress($email);  // Add a recipient

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Password Reset';
            $mail->Body = "
            <p><b>Dear $role,</b></p>
            <p>You are receiving this email because we received a password reset request for your account.</p>
            <br>
            Your temporary password is: <b>$temp_password</b><br>
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="./assets/css/login.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="user/register/assets/img/icon.png" rel="icon">
</head>
<body>
  <div class="wrapper">
    <div class="container">
      <div class="myform">
        <h1>Forgot Password</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
          <div class="form-group">
            <input type="text" class="form-control" id="username" name="username" placeholder="Enter your Username" required>
          </div>
          <button type="submit" name="submit" class="btn btn-primary">Reset Password</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Script to handle SweetAlert2 -->
  <script>
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
      window.location.href = 'index.php';
    }
  </script>
</body>

</html>
