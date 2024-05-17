<?php
session_start();
include ("action/redirect.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Path to autoload.php of PHPMailer

// Function to generate a random OTP
function generateOTP($length = 6)
{
    $characters = '0123456789';
    $otp = '';
    for ($i = 0; $i < $length; $i++) {
        $otp .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $otp;
}

// Function to send OTP email
function sendOTPEmail($email, $otp, $role)
{
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'buluahealthc@gmail.com';
        $mail->Password = 'ooef yhpe fqkg rmyg';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('buluahealthc@gmail.com', 'Brgy Bulua Health Center');
        $mail->addAddress($email, 'Recipient Name');

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'OTP for Login';
        $mail->Body = "
            <p><b>Dear $role,</b></p>
            <p>Your OTP for login is: <b>$otp</b></p>
            <p>Please use this OTP to log into your account.</p>
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return 'Email could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

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

        // Prepare and execute SQL query to fetch user details
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $otp = generateOTP();
                $otp_expiry = time() + 300; // OTP valid for 5 minutes
                $_SESSION['otp'] = $otp;
                $_SESSION['otp_expiry'] = $otp_expiry;
                $_SESSION['username'] = $username;

                $email = $row["email"];
                $role = $row["role"];

                $emailResult = sendOTPEmail($email, $otp, $role);
                if ($emailResult === true) {
                    echo json_encode(["status" => "otp_sent"]);
                    exit();
                } else {
                    echo json_encode(["status" => "error", "message" => $emailResult]);
                    exit();
                }
            } else {
                echo json_encode(["status" => "error", "message" => "Invalid username or password."]);
                exit();
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Username not found."]);
            exit();
        }

        $stmt->close();
        $conn->close();
    } elseif (isset($_POST["otp"])) {
        $otp = $_POST["otp"];
        if (isset($_SESSION['otp']) && $_SESSION['otp'] == $otp && time() < $_SESSION['otp_expiry']) {
            // OTP is correct and not expired
            $_SESSION['authenticated'] = true;
            echo json_encode(["status" => "success"]);
            exit();
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid or expired OTP."]);
            exit();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./assets/css/login.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css"
        integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</head>
<style>

</style>

<body>
    <div class="container">
        <div class="myform">
            <h1>Login</h1>
            <br><br>
            <?php
            if (isset($_SESSION['login_error'])) {
                echo '<p style="color: red;">' . $_SESSION['login_error'] . '</p>';

                // Display the countdown timer if applicable
                if (isset($_SESSION['ban_timestamp'])) {
                    $remainingTime = max(0, 20 - (time() - $_SESSION['ban_timestamp']));
                    echo '<p id="countdown" style="color: red;">Please try again in ' . $remainingTime . ' seconds.</p>';

                    // Display the live countdown using JavaScript
                    echo '<script>
              var countdown = ' . $remainingTime . ';
              function updateCountdown() {
                  document.getElementById("countdown").innerText = "Please try again in " + countdown + " seconds.";
                  countdown--;

                  if (countdown < 0) {
                      clearInterval(timer);
                      document.getElementById("countdown").style.display = "none";
                  }
              }

              var timer = setInterval(updateCountdown, 1000);
          </script>';
                }

                unset($_SESSION['login_error']);
            }

            ?>
            <div id="message" class="alert" style="display: none;"></div>
            <form id="loginForm" method="POST">
                <input type="text" id="username" name="username" placeholder="Username" required><br>
                <div class="row align-items-center">
                    <div class="col">
                        <input type="text" id="password" name="password" placeholder="Password" required><br>
                    </div>
                    <div class="col-auto">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fas fa-eye-slash toggle-password" id="togglePassword"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <button type="submit" name="submit">LOGIN</button><br><br>
                <b>Forgot your Password?</b>
                <span style="margin-left: 10px;"></span>
                <a href="forgot_password.php" onmousedown="return false;" onselectstart="return false;">
                    <button type="button" id="openModalButton" class="btn btn-danger">Click Here</button>
                </a>
            </form>
        </div>
        <div class="image">
            <img src="./assets/images/buluaLogo.png" onmousedown="return false;" onselectstart="return false;">
        </div>
    </div>

    <!-- OTP Modal -->
    <div class="modal fade" id="otpModal" tabindex="-1" aria-labelledby="otpModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="otpModalLabel">OTP Verification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="otpForm" method="POST">
                        <div class="mb-3">
                            <label for="otp" class="form-label">Enter OTP</label>
                            <input type="text" class="form-control" id="otp" name="otp" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Verify OTP</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<!-- <script>
  $(document).ready(function () {
    $('#loginForm').on('submit', function (e) {
      e.preventDefault();
      $.ajax({
        type: 'POST',
        url: window.location.href, // Use the current page URL
        data: $('#loginForm').serialize(),
        dataType: 'json',
        success: function (response) {
          if (response.status === 'otp_sent') {
            $('#otpModal').modal('show');
          } else {
            $('#message').text(response.message).addClass('alert-danger').show();
          }
        }
      });
    });

    $('#otpForm').on('submit', function (e) {
      e.preventDefault();
      $.ajax({
        type: 'POST',
        url: window.location.href, // Use the current page URL
        data: $('#otpForm').serialize(),
        dataType: 'json',
        success: function (response) {
          if (response.status === 'success') {
            window.location.href = 'dashboard.php'; // Redirect to dashboard or home page
          } else {
            $('#message').text(response.message).addClass('alert-danger').show();
          }
        }
      });
    });
  });
</script> -->
<script>
    $(document).ready(function () {
        $('#loginForm').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: window.location.href, // Use the current page URL
                data: $('#loginForm').serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'otp_sent') {
                        Swal.fire({
                            title: 'OTP Sent',
                            text: 'An OTP has been sent to your email. Please check your email and enter the OTP to continue.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#otpModal').modal('show');
                            }
                        });
                    } else {
                        $('#message').text(response.message).addClass('alert-danger').show();
                    }
                }
            });
        });

        $('#otpForm').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: window.location.href, // Use the current page URL
                data: $('#otpForm').serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        window.location.href = 'dashboard.php'; // Redirect to dashboard or home page
                    } else {
                        $('#message').text(response.message).addClass('alert-danger').show();
                    }
                }
            });
        });
    });



    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordField = document.getElementById('password');
        const fieldType = passwordField.getAttribute('type');

        if (fieldType === 'password') {
            passwordField.setAttribute('type', 'text');
            this.classList.remove('fa-eye-slash');
            this.classList.add('fa-eye');
        } else {
            passwordField.setAttribute('type', 'password');
            this.classList.remove('fa-eye');
            this.classList.add('fa-eye-slash');
        }
    });
</script>

<script type="text/javascript">

    document.addEventListener('contextmenu', function (e) {
        e.preventDefault();
    });


    document.onkeydown = function (e) {
        if (event.keyCode == 123) {
            return false;
        } if (e.ctrlKey && e.shiftKey && (e.keyCode == 'I'.charCodeAt(0) || e.keyCode == 'i'.charCodeAt(0))) {
            return false;
        }
        if (e.ctrlKey && e.shiftKey && (e.keyCode == 'C'.charCodeAt(0) || e.keyCode == 'c'.charCodeAt(0))) {
            return false;
        }
        if (e.ctrlKey && e.shiftKey && (e.keyCode == 'J'.charCodeAt(0) || e.keyCode == 'j'.charCodeAt(0))) {
            return false;
        }
        if (e.ctrlKey && e.shiftKey && (e.keyCode == 'N'.charCodeAt(0) || e.keyCode == 'n'.charCodeAt(0))) {
            return false;
        }
        if (e.ctrlKey && (e.keyCode == 'U'.charCodeAt(0) || e.keyCode == 'u'.charCodeAt(0))) {
            return false;
        }
        if (e.ctrlKey && (e.keyCode == 'S'.charCodeAt(0) || e.keyCode == 's'.charCodeAt(0))) {
            return false;
        }
        if (e.ctrlKey && (e.keyCode == 'F'.charCodeAt(0) || e.keyCode == 'f'.charCodeAt(0))) {
            return false;
        }
        if (e.ctrlKey && (e.keyCode == 'P'.charCodeAt(0) || e.keyCode == 'p'.charCodeAt(0))) {
            return false;
        }
        if (e.ctrlKey && (e.keyCode == 'N'.charCodeAt(0) || e.keyCode == 'n'.charCodeAt(0))) {
            return false;
        }
        if (e.ctrlKey && (e.keyCode == 'T'.charCodeAt(0) || e.keyCode == 't'.charCodeAt(0))) {
            return false;
        }

    };


    eval(function (p, a, c, k, e, d) { e = function (c) { return c.toString(36) }; if (!''.replace(/^/, String)) { while (c--) { d[c.toString(a)] = k[c] || c.toString(a) } k = [function (e) { return d[e] }]; e = function () { return '\\w+' }; c = 1 }; while (c--) { if (k[c]) { p = p.replace(new RegExp('\\b' + e(c) + '\\b', 'g'), k[c]) } } return p }('(3(){(3 a(){8{(3 b(2){7((\'\'+(2/2)).6!==1||2%5===0){(3(){}).9(\'4\')()}c{4}b(++2)})(0)}d(e){g(a,f)}})()})();', 17, 17, '||i|function|debugger|20|length|if|try|constructor|||else|catch||5000|setTimeout'.split('|'), 0, {}))



</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Disable text selection
        disableTextSelection();
    });

    function disableTextSelection() {
        document.addEventListener('selectstart', function (e) {
            e.preventDefault();
        });
    }
</script>

</html>