<?php
// Include your database configuration file
include_once ('../../config.php');
// header("Content-Security-Policy: default-src 'self';"); // Set Content Security Policy header to restrict resource loading
// header('Content-Type: text/plain'); // Set the content type to plain text
header('X-Content-Type-Options: nosniff'); // Prevent browsers from interpreting files as a different MIME type
header('X-Frame-Options: DENY'); // Prevent clickjacking attacks
header('Referrer-Policy: strict-origin-when-cross-origin'); // Control referrer information sent to other sites
header('X-XSS-Protection: 1; mode=block'); // Enable XSS (Cross-Site Scripting) protection


require __DIR__ . '/../vendor/autoload.php';

use Twilio\Rest\Client;
use Dotenv\Dotenv;


// Function to process form submission
function processFormSubmission($conn)
{
    function sanitizeInput($input)
    {
        // Remove all HTML tags using preg_replace
        $input = preg_replace("/<[^>]*>/", "", trim($input));
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
        // $input = preg_replace("/[\x00-\x1F\s]+/", "", $input);
        // Remove script and content characters
        $input = preg_replace("/<script[^>]*>(.*?)<\/script>/is", "", $input);
        return $input;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate and sanitize input data
        $step = sanitizeInput($_POST['step']);
        $first_name = sanitizeInput($_POST['first_name']);
        $last_name = sanitizeInput($_POST['last_name']);
        $middle_name = sanitizeInput($_POST['middle_name']);
        $suffix = sanitizeInput($_POST['suffix']);
        $gender = sanitizeInput($_POST['gender']);
        $contact_nos = sanitizeInput($_POST['contact_no']);
        $civil_status = sanitizeInput($_POST['civil_status']);
        $birthdate = sanitizeInput($_POST['birthdate']);
        $serial_no = sanitizeInput($_POST['serial_no']);
        $religion = sanitizeInput($_POST['religion']);
        $address = sanitizeInput($_POST['address']);
        $contact_no = "+63$contact_nos";

        // Create a DateTime object for the user's birthdate
        $birthDateObj = new DateTime($birthdate);

        // Get the current date
        $currentDateObj = new DateTime();

        // Calculate the interval between the user's birthdate and the current date
        $interval = $currentDateObj->diff($birthDateObj);

        // Get the years from the interval
        $age = $interval->y;

        // Check for duplicates
        $stmt_check = $conn->prepare("SELECT * FROM patients WHERE first_name = ? AND last_name = ? AND middle_name = ?");
        $stmt_check->bind_param("sss", $first_name, $last_name, $middle_name);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            // Return JSON response for duplicate entry
            $response = array("status" => "error", "message" => "Duplicate entry found: A patient with the same first name, last name, and middle name already exists.");
            echo json_encode($response);
            exit();
        } else {
            // Prepare SQL statement
            $stmt = $conn->prepare("INSERT INTO patients (step, first_name, last_name, middle_name, suffix, gender, contact_no, civil_status, birthdate, age, serial_no, religion, address) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssssssss", $step, $first_name, $last_name, $middle_name, $suffix, $gender, $contact_no, $civil_status, $birthdate, $age, $serial_no, $religion, $address);

            if ($stmt->execute()) {
                $response = array("status" => "success", "message" => "New record created successfully");
                echo json_encode($response);
                sendSMS($contact_no);
            } else {
                // Return JSON response for error
                $response = array("status" => "error", "message" => "Error: " . $stmt->error);
                echo json_encode($response);
            }

            $stmt->close();
            exit();
        }

        $stmt_check->close();
    }
}

function sendSMS($phoneNumber)
{
    // Load environment variables from .env file
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->safeLoad();

    // Check if the variables are set correctly
    $account_sid = $_ENV['TWILIO_ACCOUNT_SID'];
    $auth_token = $_ENV['TWILIO_AUTH_TOKEN'];
    $twilio_number = $_ENV['TWILIO_PHONE_NUMBER'];

    if (!$account_sid || !$auth_token) {
        die('Twilio Account SID and Auth Token are not set.');
    }

    if (!$account_sid || !$auth_token) {
        die('Twilio Account SID and Auth Token are not set.');
    }

    $client = new Client($account_sid, $auth_token);
    $client->messages->create(
        $phoneNumber,
        array(
            'from' => $twilio_number,
            'body' => "Bulua Health Center Notif:\n\nYou are scheduled for tomorrow's consultation at Barangay Bulua Health Center. To verify your information, please bring the following:\n- Zone Certificate or Valid ID."
        )
    );
}


// Fetch inactive and non-deleted patients
$sql = "SELECT *, CONCAT(patients.last_name, ', ', patients.first_name) AS full_name FROM patients WHERE is_active = 0 AND patients.is_deleted = 0 ORDER BY serial_no DESC";
$result = $conn->query($sql);

if ($result === false) {
    die("Query failed: " . $conn->error);
}

$currentYear = date("y");
$defaultSerial = $currentYear . "0001";

// Get the latest serial number
$sql2 = "SELECT MAX(serial_no) AS max_serial FROM patients";
$result2 = $conn->query($sql2);

if ($result2->num_rows > 0) {
    $row2 = $result2->fetch_assoc();
    $latestSerial = $row2["max_serial"];
    $latestYear = substr($latestSerial, 0, 2);

    if ($latestYear == $currentYear) {
        $newCount = intval(substr($latestSerial, -4)) + 1;
        $newSerial = $currentYear . sprintf("%04d", $newCount);
    } else {
        $newSerial = $defaultSerial;
    }
} else {
    $newSerial = $defaultSerial;
}
processFormSubmission($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Barangay Bulua Health Center</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top">
        <div class="container d-flex align-items-center justify-content-between">

            <h1 class="logo"><a href="index.html">Bulua Health Center</a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="index.html" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
                    <li><a class="nav-link scrollto" href="#about">About</a></li>
                    <li><a class="nav-link scrollto" href="#services">Services</a></li>
                    <li><a class="nav-link scrollto" href="#team">Team</a></li>
                    <li><a class="getstarted scrollto" href="#" data-toggle="modal"
                            data-target="#registerModal">Consultation Registration</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->


    <!-- Modal Structure -->
    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel"
        aria-hidden="true">
        <style>
            .modal-lg-custom {
                max-width: 90%;
                /* Adjust for smaller screens */
            }

            @media (min-width: 768px) {
                .modal-lg-custom {
                    max-width: 60%;
                }
            }

            @media (min-width: 992px) {
                .modal-lg-custom {
                    max-width: 45%;
                }
            }

            .custom-header-img {
                height: 200px;
                object-fit: cover;
            }
        </style>

        <div class="modal-dialog modal-lg-custom" role="document">
            <div class="modal-content">
                <div class="modal-header p-0">
                    <!-- Image in the modal header -->
                    <img src="assets/img/hero-bg.jpg" alt="Header Image" class="img-fluid w-100 custom-header-img">
                    <button type="button" class="close position-absolute" style="right: 10px; top: 10px;"
                        data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h1 class="mb-5 mt-5 ml-2"><b>Registration Info</b></h1>
                    <form id="addPatientForm" method="POST"
                        action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <style>
                            .otag {
                                display: none;
                            }
                        </style>
                        <div class="form-group otag">
                            <label for="step">Select Step</label>
                            <select class="form-control" name="step" id="step" required>
                                <option value="" disabled selected hidden>Select a Step</option>
                                <option value="Interview Staff">Interview Staff</option>
                                <option value="Consultation">Consultation</option>
                                <option value="Immunization">Immunization</option>
                                <option value="Prenatal">Prenatal</option>
                                <option value="Family Planning">Family Planning</option>
                                <option value="Doctor">Doctor</option>
                                <option value="Nurse">Nurse</option>
                                <option value="Midwife">Midwife</option>
                                <option value="Head Nurse">Head Nurse</option>
                                <option value="Prescription">Prescription</option>
                                <option value="Online Register">Online Register</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first_name">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                                    <div id="first_name_error" class="error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                                    <div id="last_name_error" class="error"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="middle_name">Middle Name</label>
                                    <input type="text" class="form-control" id="middle_name" name="middle_name"
                                        required>
                                    <div id="middle_name_error" class="error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="suffix">Suffix</label>
                                    <input type="text" class="form-control" id="suffix" name="suffix">
                                    <div id="suffix_error" class="error"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gender">Select Gender</label>
                                    <select class="form-control" name="gender" id="gender" required>
                                        <option value="" disabled selected hidden>Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                    <div id="gender_error" class="error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contact_no">Contact No</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon3">+63</span>
                                        </div>
                                        <input type="text" class="form-control" id="contact_no" name="contact_no"
                                            required>
                                        <div id="contact_error" class="error"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="civil_status">Select Civil Status</label>
                                    <select class="form-control" name="civil_status" id="civil_status" required>
                                        <option value="" disabled selected hidden>Select Civil Status</option>
                                        <option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                        <option value="Divorced">Divorced</option>
                                        <option value="Widowed">Widowed</option>
                                    </select>
                                    <div id="civil_status_error" class="error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="birthdate">Birthdate</label>
                                    <input type="date" class="form-control" id="birthdate" name="birthdate" required>
                                    <div id="birthdate_error" class="error"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="age">Age (Click The Birthdate First)</label>
                                    <p id="age_display" class="form-control" readonly></p>
                                    <input type="hidden" id="age" name="age">
                                    <div id="age_error" class="error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="serial_no">Serial No</label>
                                    <input type="text" class="form-control" id="serial_no" name="serial_no"
                                        value="<?php echo $newSerial; ?>" readonly>
                                    <div id="serial_error" class="error"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="religion">Religion</label>
                                    <select class="form-control" name="religion" id="religion" required>
                                        <option value="" disabled selected hidden>Select Religion</option>
                                        <option value="Roman Catholic">Roman Catholic</option>
                                        <option value="Muslim">Muslim</option>
                                        <option value="Iglesia ni Cristo">Iglesia ni Cristo</option>
                                        <option value="Protestantism">Protestantism</option>
                                        <option value="Other or Non-religious">Other or Non-religious</option>
                                    </select>
                                    <div id="religion_error" class="error"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <select class="form-control" id="address" name="address" required>
                                        <option value="" disabled selected>Select your address</option>
                                        <option value="Zone 1, Bulua, Cagayan de Oro">Zone 1, Bulua, Cagayan de Oro,
                                            Misamis Oriental</option>
                                        <option value="Zone 2, Bulua, Cagayan de Oro">Zone 2, Bulua, Cagayan de Oro,
                                            Misamis Oriental</option>
                                        <option value="Zone 3, Bulua, Cagayan de Oro">Zone 3, Bulua, Cagayan de Oro,
                                            Misamis Oriental</option>
                                        <option value="Zone 4, Bulua, Cagayan de Oro">Zone 4, Bulua, Cagayan de Oro,
                                            Misamis Oriental</option>
                                        <option value="Zone 5, Bulua, Cagayan de Oro">Zone 5, Bulua, Cagayan de Oro,
                                            Misamis Oriental</option>
                                        <option value="Zone 6, Bulua, Cagayan de Oro">Zone 6, Bulua, Cagayan de Oro,
                                            Misamis Oriental</option>
                                        <option value="Zone 7, Bulua, Cagayan de Oro">Zone 7, Bulua, Cagayan de Oro,
                                            Misamis Oriental</option>
                                        <option value="Zone 8, Bulua, Cagayan de Oro">Zone 8, Bulua, Cagayan de Oro,
                                            Misamis Oriental</option>
                                        <option value="Zone 9, Bulua, Cagayan de Oro">Zone 9, Bulua, Cagayan de Oro,
                                            Misamis Oriental</option>
                                        <option value="Zone 10, Bulua, Cagayan de Oro">Zone 10, Bulua, Cagayan de Oro,
                                            Misamis Oriental</option>
                                        <option value="Zone 11, Bulua, Cagayan de Oro">Zone 11, Bulua, Cagayan de Oro,
                                            Misamis Oriental</option>
                                        <option value="Zone 12, Bulua, Cagayan de Oro">Zone 12, Bulua, Cagayan de Oro,
                                            Misamis Oriental</option>
                                        <option value="Zone 13, Bulua, Cagayan de Oro">Zone 13, Bulua, Cagayan de Oro,
                                            Misamis Oriental</option>
                                    </select>
                                    <div id="address_error" class="error"></div>
                                </div>
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="button" class="btn btn-danger" onclick="clearForm()">Clear Data</button>
                            <button type="submit" class="btn btn-success" id="addPatientButton">
                                Register
                                <span id="spinner" class="spinner-border spinner-border-sm" role="status"
                                    aria-hidden="true" style="display: none;"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- END MODAL -->


    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center">
        <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-9 text-center">
                    <h1>Barangay Bulua Health Center</h1>
                    <h2>“Your Health, Our Priority”</h2>
                </div>
            </div>
            <div class="text-center">
                <a href="#about" class="btn-get-started scrollto">Get Started</a>
            </div>

            <div class="row icon-boxes">
            </div>
        </div>
    </section><!-- End Hero -->

    <main id="main">

        <!-- ======= About Section ======= -->
        <section id="about" class="about">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>About Us</h2>
                    <p>Caring for Our Community' s Health</p>
                </div>

                <div class="row content">
                    <div class="col-lg-6">
                        <p>
                            Welcome to Barangay Bulua Health Center, your trusted healthcare partner in promoting
                            wellness within our
                            community. We are proud to serve the residents of Barangay Bulua with quality healthcare
                            services
                            delivered with care and compassion.
                        </p>
                        <ul>
                            <li><i class="ri-check-double-line"></i> Accessible and affordable healthcare services for
                                all</li>
                            <li><i class="ri-check-double-line"></i> Dedicated healthcare professionals committed to
                                your well-being
                            </li>
                            <li><i class="ri-check-double-line"></i> Focus on preventive care and health education</li>
                        </ul>
                    </div>
                    <div class="col-lg-6 pt-4 pt-lg-0">
                        <p>
                            Our mission is to improve the health and quality of life of every member of our community.
                            Whether you
                            need routine check-ups, vaccinations, maternal and child health services, or health
                            education, our doors
                            are always open to provide you with the care and support you deserve.
                        </p>
                        <a href="#" class="btn-learn-more">Learn More</a>
                    </div>
                </div>

            </div>
        </section><!-- End About Section -->

        <!-- ======= About Video Section ======= -->
        <section id="about-video" class="about-video">
            <div class="container" data-aos="fade-up">

                <div class="row">

                    <div class="col-lg-6 video-box align-self-baseline position-relative" data-aos="fade-right"
                        data-aos-delay="100">
                        <img src="assets/img/about-video.jpg" class="img-fluid" alt="">
                        <!-- <a href="https://www.youtube.com/watch?v=jDDaplaOz7Q" class="glightbox play-btn mb-4" data-vbtype="video"
              data-autoplay="true"></a> -->
                    </div>

                    <div class="col-lg-6 pt-3 pt-lg-0 content" data-aos="fade-left" data-aos-delay="100">
                        <h3>Bulua Health Center is dedicated to serving our community with accessible and compassionate
                            healthcare
                            services.</h3>
                        <p class="fst-italic">
                            We understand the importance of personalized care and strive to meet the unique needs of
                            each individual
                            we serve.
                        </p>
                        <ul>
                            <li><i class="bx bx-check-double"></i> Commitment to excellence in patient care.</li>
                            <li><i class="bx bx-check-double"></i> Collaboration with local organizations and healthcare
                                providers.
                            </li>
                            <li><i class="bx bx-check-double"></i> Promotion of health education and preventive care
                                initiatives.</li>
                        </ul>
                        <p>
                            Our experienced team of healthcare professionals is dedicated to promoting wellness and
                            enhancing the
                            quality of life for individuals and families in our community. We believe that everyone
                            deserves access to
                            quality healthcare, and we are proud to play a role in improving the health and well-being
                            of those we
                            serve.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <!-- End About Video Section -->

        <!-- ======= Services Section ======= -->
        <section id="services" class="services section-bg">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Services</h2>
                    <p>At Bulua Health Center, we provide a comprehensive range of healthcare services tailored to meet
                        the
                        diverse needs of our community. Our commitment to excellence ensures that you receive the
                        highest quality
                        care in a compassionate and supportive environment.</p>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
                        <div class="icon-box iconbox-blue">
                            <div class="icon">
                                <svg width="100" height="100" viewBox="0 0 600 600" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke="none" stroke-width="0" fill="#f5f5f5"
                                        d="M300,521.0016835830174C376.1290562159157,517.8887921683347,466.0731472004068,529.7835943286574,510.70327084640275,468.03025145048787C554.3714126377745,407.6079735673963,508.03601936045806,328.9844924480964,491.2728898941984,256.3432110539036C474.5976632858925,184.082847569629,479.9380746630129,96.60480741107993,416.23090153303,58.64404602377083C348.86323505073057,18.502131276798302,261.93793281208167,40.57373210992963,193.5410806939664,78.93577620505333C130.42746243093433,114.334589627462,98.30271207620316,179.96522072025542,76.75703585869454,249.04625023123273C51.97151888228291,328.5150500222984,13.704378332031375,421.85034740162234,66.52175969318436,486.19268352777647C119.04800174914682,550.1803526380478,217.28368757567262,524.383925680826,300,521.0016835830174">
                                    </path>
                                </svg>
                                <i class='bx bx-plus-medical'></i>
                            </div>
                            <h4><a href="">Consultation</a></h4>
                            <p>Expert guidance and personalized care to address your health concerns and provide
                                treatment
                                recommendations.</p>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in"
                        data-aos-delay="200">
                        <div class="icon-box iconbox-orange ">
                            <div class="icon">
                                <svg width="100" height="100" viewBox="0 0 600 600" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke="none" stroke-width="0" fill="#f5f5f5"
                                        d="M300,582.0697525312426C382.5290701553225,586.8405444964366,449.9789794690241,525.3245884688669,502.5850820975895,461.55621195738473C556.606425686781,396.0723002908107,615.8543463187945,314.28637112970534,586.6730223649479,234.56875336149918C558.9533121215079,158.8439757836574,454.9685369536778,164.00468322053177,381.49747125262974,130.76875717737553C312.15926192815925,99.40240125094834,248.97055460311594,18.661163978235184,179.8680185752513,50.54337015887873C110.5421016452524,82.52863877960104,119.82277516462835,180.83849132639028,109.12597500060166,256.43424936330496C100.08760227029461,320.3096726198365,92.17705696193138,384.0621239912766,124.79988738764834,439.7174275375508C164.83382741302287,508.01625554203684,220.96474134820875,577.5009287672846,300,582.0697525312426">
                                    </path>
                                </svg>
                                <i class='bx bx-injection'></i>
                            </div>
                            <h4><a href="">Immunization (Including Pediatric Vaccinations)</a></h4>
                            <p>Ensure your child's health and well-being with our comprehensive immunization program,
                                providing
                                protection against a range of diseases from infancy through childhood.</p>

                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 d-flex align-items-stretch mt-4 mt-lg-4" data-aos="zoom-in"
                        data-aos-delay="300">
                        <div class="icon-box iconbox-pink">
                            <div class="icon">
                                <svg width="100" height="100" viewBox="0 0 600 600" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke="none" stroke-width="0" fill="#f5f5f5"
                                        d="M300,541.5067337569781C382.14930387511276,545.0595476570109,479.8736841581634,548.3450877840088,526.4010558755058,480.5488172755941C571.5218469581645,414.80211281144784,517.5187510058486,332.0715597781072,496.52539010469104,255.14436215662573C477.37192572678356,184.95920475031193,473.57363656557914,105.61284051026155,413.0603344069578,65.22779650032875C343.27470386102294,18.654635553484475,251.2091493199835,5.337323636656869,175.0934190732945,40.62881213300186C97.87086631185822,76.43348514350839,51.98124368387456,156.15599469081315,36.44837278890362,239.84606092416172C21.716077023791087,319.22268207091537,43.775223500013084,401.1760424656574,96.891909868211,461.97329694683043C147.22146801428983,519.5804099606455,223.5754009179313,538.201503339737,300,541.5067337569781">
                                    </path>
                                </svg>
                                <i class='bx bxs-baby-carriage'></i>
                            </div>
                            <h4><a href="">Prenatal Care</a></h4>
                            <p>Comprehensive care and support for expectant mothers to ensure a healthy pregnancy and
                                childbirth
                                experience.</p>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 d-flex align-items-stretch mt-4" data-aos="zoom-in"
                        data-aos-delay="100">
                        <div class="icon-box iconbox-yellow">
                            <div class="icon">
                                <svg width="100" height="100" viewBox="0 0 600 600" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke="none" stroke-width="0" fill="#f5f5f5"
                                        d="M300,503.46388370962813C374.79870501325706,506.71871716319447,464.8034551963731,527.1746412648533,510.4981551193396,467.86667711651364C555.9287308511215,408.9015244558933,512.6030010748507,327.5744911775523,490.211057578863,256.5855673507754C471.097692560561,195.9906835881958,447.69079081568157,138.11976852964426,395.19560036434837,102.3242989838813C329.3053358748298,57.3949838291264,248.02791733380457,8.279543830951368,175.87071277845988,42.242879143198664C103.41431057327972,76.34704239035025,93.79494320519305,170.9812938413882,81.28167332365135,250.07896920659033C70.17666984294237,320.27484674793965,64.84698225790005,396.69656628748305,111.28512138212992,450.4950937839243C156.20124167950087,502.5303643271138,231.32542653798444,500.4755392045468,300,503.46388370962813">
                                    </path>
                                </svg>
                                <i class='bx bx-calendar-heart'></i>
                            </div>
                            <h4><a href="">Family Planning</a></h4>
                            <p>Empowering individuals and couples to make informed decisions about contraception and
                                reproductive
                                health.</p>

                        </div>
                    </div>
                </div>

            </div>
        </section><!-- End Sevices Section -->

        <!-- ======= Team Section ======= -->
        <section id="team" class="team section-bg">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>MCP Organizational Members - Bulua Health Center And Lying-In Clinic</h2>
                    <p>Dedicated professionals committed to providing exceptional healthcare with empathy and expertise.
                    </p>
                </div>
                <div class="row">

                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                        <div class="member">
                            <div class="member-img">
                                <img src="https://placehold.co/600x400.png" class="img-fluid" alt="">
                                <!-- <div class="social">
                  <a href=""><i class="bi bi-twitter"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div> -->
                            </div>
                            <div class="member-info">
                                <h4>Katrina Ann Pangadlin</h4>
                                <span>Nurse</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
                        <div class="member">
                            <div class="member-img">
                                <img src="https://placehold.co/600x400.png" class="img-fluid" alt="">
                                <!-- <div class="social">
                  <a href=""><i class="bi bi-twitter"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div> -->
                            </div>
                            <div class="member-info">
                                <h4>Annaliza P. Acaso</h4>
                                <span>Midwife</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="300">
                        <div class="member">
                            <div class="member-img">
                                <img src="https://placehold.co/600x400.png" class="img-fluid" alt="">
                                <!-- <div class="social">
                  <a href=""><i class="bi bi-twitter"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div> -->
                            </div>
                            <div class="member-info">
                                <h4>Mary Sunshine D. Abrogar</h4>
                                <span>Midwife</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="400">
                        <div class="member">
                            <div class="member-img">
                                <img src="https://placehold.co/600x400.png" class="img-fluid" alt="">
                                <!-- <div class="social">
                  <a href=""><i class="bi bi-twitter"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div> -->
                            </div>
                            <div class="member-info">
                                <h4>Amanda Jepson</h4>
                                <span>Accountant</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="500">
                        <div class="member">
                            <div class="member-img">
                                <img src="https://placehold.co/600x400.png" class="img-fluid" alt="">
                                <!-- <div class="social">
                  <a href=""><i class="bi bi-twitter"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div> -->
                            </div>
                            <div class="member-info">
                                <h4>Amanda Jepson</h4>
                                <span>Accountant</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="600">
                        <div class="member">
                            <div class="member-img">
                                <img src="https://placehold.co/600x400.png" class="img-fluid" alt="">
                                <!-- <div class="social">
                  <a href=""><i class="bi bi-twitter"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div> -->
                            </div>
                            <div class="member-info">
                                <h4>Amanda Jepson</h4>
                                <span>Accountant</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="700">
                        <div class="member">
                            <div class="member-img">
                                <img src="https://placehold.co/600x400.png" class="img-fluid" alt="">
                                <!-- <div class="social">
                  <a href=""><i class="bi bi-twitter"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div> -->
                            </div>
                            <div class="member-info">
                                <h4>Amanda Jepson</h4>
                                <span>Accountant</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="800">
                        <div class="member">
                            <div class="member-img">
                                <img src="https://placehold.co/600x400.png" class="img-fluid" alt="">
                                <!-- <div class="social">
                  <a href=""><i class="bi bi-twitter"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div> -->
                            </div>
                            <div class="member-info">
                                <h4>Aileen Mendoza</h4>
                                <span>Midwife</span>
                            </div>
                        </div>
                    </div>



                </div>

            </div>
        </section><!-- End Team Section -->

        <!-- ======= Frequently Asked Questions Section ======= -->
        <section id="faq" class="faq section-bg">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Frequently Asked Questions</h2>
                    <p>Description Here.</p>
                </div>

                <div class="faq-list">
                    <ul>
                        <li data-aos="fade-up">
                            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" class="collapse"
                                data-bs-target="#faq-list-1">QUESTION 1 <i class="bx bx-chevron-down icon-show"></i><i
                                    class="bx bx-chevron-up icon-close"></i></a>
                            <div id="faq-list-1" class="collapse show" data-bs-parent=".faq-list">
                                <p>
                                    Feugiat pretium nibh ipsum consequat. Tempus iaculis urna id volutpat lacus laoreet
                                    non curabitur
                                    gravida. Venenatis lectus magna fringilla urna porttitor rhoncus dolor purus non.
                                </p>
                            </div>
                        </li>

                        <li data-aos="fade-up" data-aos-delay="100">
                            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse"
                                data-bs-target="#faq-list-2" class="collapsed">QUESTION 2 <i
                                    class="bx bx-chevron-down icon-show"></i><i
                                    class="bx bx-chevron-up icon-close"></i></a>
                            <div id="faq-list-2" class="collapse" data-bs-parent=".faq-list">
                                <p>
                                    Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum
                                    velit laoreet id
                                    donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec pretium. Est
                                    pellentesque elit
                                    ullamcorper dignissim. Mauris ultrices eros in cursus turpis massa tincidunt dui.
                                </p>
                            </div>
                        </li>

                        <li data-aos="fade-up" data-aos-delay="200">
                            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse"
                                data-bs-target="#faq-list-3" class="collapsed">QUESTION 3 <i
                                    class="bx bx-chevron-down icon-show"></i><i
                                    class="bx bx-chevron-up icon-close"></i></a>
                            <div id="faq-list-3" class="collapse" data-bs-parent=".faq-list">
                                <p>
                                    Eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis orci. Faucibus
                                    pulvinar elementum
                                    integer enim. Sem nulla pharetra diam sit amet nisl suscipit. Rutrum tellus
                                    pellentesque eu tincidunt.
                                    Lectus urna duis convallis convallis tellus. Urna molestie at elementum eu facilisis
                                    sed odio morbi
                                    quis
                                </p>
                            </div>
                        </li>

                        <li data-aos="fade-up" data-aos-delay="300">
                            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse"
                                data-bs-target="#faq-list-4" class="collapsed">QUESTION 3 <i
                                    class="bx bx-chevron-down icon-show"></i><i
                                    class="bx bx-chevron-up icon-close"></i></a>
                            <div id="faq-list-4" class="collapse" data-bs-parent=".faq-list">
                                <p>
                                    Molestie a iaculis at erat pellentesque adipiscing commodo. Dignissim suspendisse in
                                    est ante in. Nunc
                                    vel risus commodo viverra maecenas accumsan. Sit amet nisl suscipit adipiscing
                                    bibendum est. Purus
                                    gravida quis blandit turpis cursus in.
                                </p>
                            </div>
                        </li>

                        <li data-aos="fade-up" data-aos-delay="400">
                            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse"
                                data-bs-target="#faq-list-5" class="collapsed">QUESTION 4 <i
                                    class="bx bx-chevron-down icon-show"></i><i
                                    class="bx bx-chevron-up icon-close"></i></a>
                            <div id="faq-list-5" class="collapse" data-bs-parent=".faq-list">
                                <!-- <p>
                  Laoreet sit amet cursus sit amet dictum sit amet justo. Mauris vitae ultricies leo integer malesuada
                  nunc vel. Tincidunt eget nullam non nisi est sit amet. Turpis nunc eget lorem dolor sed. Ut venenatis
                  tellus in metus vulputate eu scelerisque.
                </p> -->
                                <img src="https://i0.wp.com/bloody-disgusting.com/wp-content/uploads/2020/03/gonjiam-2.png"
                                    alt="hehe">
                            </div>
                        </li>

                    </ul>
                </div>

            </div>
        </section><!-- End Frequently Asked Questions Section -->

        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Contact</h2>
                    <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit
                        sint
                        consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea.
                        Quia fugiat sit
                        in iste officiis commodi quidem hic quas.</p>
                </div>

                <div>
                    <iframe style="border:0; width: 100%; height: 600px;"
                        src="https://www.google.com/maps/embed?pb=!4v1716099952381!6m8!1m7!1sbBQt8tDknHjHmqyEBEbyLA!2m2!1d8.504315632326485!2d124.6142346343979!3f354.00483150744043!4f-4.632092321095996!5f0.7820865974627469"
                        frameborder="0" allowfullscreen></iframe>
                </div>

                <section id="services" class="services section-bg">

                    <div class="container" data-aos="fade-up">

                        <div class="row">

                            <div class="col-lg-4 col-md-5 d-flex align-items-stretch" data-aos="zoom-in"
                                data-aos-delay="100">
                                <div class="icon-box iconbox-blue">
                                    <div class="icon">
                                        <svg width="100" height="100" viewBox="0 0 600 600"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke="none" stroke-width="0" fill="#f5f5f5"
                                                d="M300,521.0016835830174C376.1290562159157,517.8887921683347,466.0731472004068,529.7835943286574,510.70327084640275,468.03025145048787C554.3714126377745,407.6079735673963,508.03601936045806,328.9844924480964,491.2728898941984,256.3432110539036C474.5976632858925,184.082847569629,479.9380746630129,96.60480741107993,416.23090153303,58.64404602377083C348.86323505073057,18.502131276798302,261.93793281208167,40.57373210992963,193.5410806939664,78.93577620505333C130.42746243093433,114.334589627462,98.30271207620316,179.96522072025542,76.75703585869454,249.04625023123273C51.97151888228291,328.5150500222984,13.704378332031375,421.85034740162234,66.52175969318436,486.19268352777647C119.04800174914682,550.1803526380478,217.28368757567262,524.383925680826,300,521.0016835830174">
                                            </path>
                                        </svg>
                                        <i class="bi bi-geo-alt"></i>
                                    </div>
                                    <h4>Location:</h4>
                                    <p>GJ37+QMP, Butuan - Cagayan de Oro - Iligan Rd, Butuan, Cagayan de Oro, 9000
                                        Misamis Oriental</p>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-5 d-flex align-items-stretch" data-aos="zoom-in"
                                data-aos-delay="250">
                                <div class="icon-box iconbox-pink">
                                    <div class="icon">
                                        <svg width="100" height="100" viewBox="0 0 600 600"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke="none" stroke-width="0" fill="#f5f5f5"
                                                d="M300,521.0016835830174C376.1290562159157,517.8887921683347,466.0731472004068,529.7835943286574,510.70327084640275,468.03025145048787C554.3714126377745,407.6079735673963,508.03601936045806,328.9844924480964,491.2728898941984,256.3432110539036C474.5976632858925,184.082847569629,479.9380746630129,96.60480741107993,416.23090153303,58.64404602377083C348.86323505073057,18.502131276798302,261.93793281208167,40.57373210992963,193.5410806939664,78.93577620505333C130.42746243093433,114.334589627462,98.30271207620316,179.96522072025542,76.75703585869454,249.04625023123273C51.97151888228291,328.5150500222984,13.704378332031375,421.85034740162234,66.52175969318436,486.19268352777647C119.04800174914682,550.1803526380478,217.28368757567262,524.383925680826,300,521.0016835830174">
                                            </path>
                                        </svg>
                                        <i class="bi bi-envelope"></i>
                                    </div>

                                    <h4>Email:</h4>
                                    <p>You can email us at our email: bulua.healthcenter011815@gmail.com</p>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-5 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in"
                                data-aos-delay="200">
                                <div class="icon-box iconbox-orange ">
                                    <div class="icon">
                                        <svg width="100" height="100" viewBox="0 0 600 600"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke="none" stroke-width="0" fill="#f5f5f5"
                                                d="M300,582.0697525312426C382.5290701553225,586.8405444964366,449.9789794690241,525.3245884688669,502.5850820975895,461.55621195738473C556.606425686781,396.0723002908107,615.8543463187945,314.28637112970534,586.6730223649479,234.56875336149918C558.9533121215079,158.8439757836574,454.9685369536778,164.00468322053177,381.49747125262974,130.76875717737553C312.15926192815925,99.40240125094834,248.97055460311594,18.661163978235184,179.8680185752513,50.54337015887873C110.5421016452524,82.52863877960104,119.82277516462835,180.83849132639028,109.12597500060166,256.43424936330496C100.08760227029461,320.3096726198365,92.17705696193138,384.0621239912766,124.79988738764834,439.7174275375508C164.83382741302287,508.01625554203684,220.96474134820875,577.5009287672846,300,582.0697525312426">
                                            </path>
                                        </svg>
                                        <i class="bi bi-phone"></i>
                                    </div>
                                    <h4>Phone:</h4>
                                    <p>Or you can also call us at our Mobile Hotline: 0916 859 3510</p>
                                </div>
                            </div>


                        </div>
                    </div>
                </section>
            </div>
        </section>
        <!-- End Contact Section -->

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer">

        <div class="container d-md-flex py-4">

            <div class="me-md-auto text-center text-md-start">
                <div class="copyright">
                    &copy; Copyright <strong><span>Bulua Health Center</span></strong>. All Rights Reserved
                    <?php echo date("Y"); ?>
                </div>
            </div>
        </div>
    </footer>
    <!-- End Footer -->

    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>



    <!-- Vendor JS Files -->
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>






    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <!-- Script to clear form entries -->

    <script>
        function clearForm() {

            document.getElementById("first_name").value = "";
            document.getElementById("last_name").value = "";
            document.getElementById("middle_name").value = "";
            document.getElementById("age_display").value = "";
            document.getElementById("suffix").value = "";
            document.getElementById("gender").value = "";
            document.getElementById("contact_no").value = "";
            document.getElementById("civil_status").value = "";
            document.getElementById("birthdate").value = "";
            document.getElementById("age").value = "";
            document.getElementById("religion").value = "";
            document.getElementById("address").value = "";
        }
    </script>
    <script>
        // Add an event listener to the Save button
        document.getElementById('addPatientButton').addEventListener('click', function () {
            var completedStep = "Online Register";
            // Get the select element
            var selectStep = document.getElementById('step');

            // Loop through options and set selected attribute if value matches completedStep
            for (var i = 0; i < selectStep.options.length; i++) {
                if (selectStep.options[i].value === completedStep) {
                    selectStep.options[i].setAttribute('selected', 'selected');
                    break; // Exit loop once selected option is found
                }
            }
        });
        document.getElementById("contact_no").addEventListener("input", function () {
            var contactInput = document.getElementById("contact_no").value.trim();
            if (contactInput.startsWith("0")) {
                contactInput = contactInput.substring(1);
            }
            document.getElementById("contact_no").value = contactInput;
        });

        $(document).ready(function () {

            $('#contact_no').on('input', function () {
                var contactNo = $(this).val();
                if (contactNo.length < 10) {
                    $('#contact_error').text('\nInvalid Phone number.');
                } else if (!contactNo.startsWith("9")) {
                    $('#contact_error').text('\nInvalid Phone number. Phone number should start with 9');
                } else {
                    $('#contact_error').text('');
                }


                if (contactNo.length > 10) {
                    $(this).val(contactNo.substring(0, 10));
                }
            });


            if (contactInput.startsWith("+63")) {
                contactInput = contactInput.substring(3);
            }
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#addPatientForm').on('submit', function (event) {
                event.preventDefault();
                var form = $(this);
                var submitBtn = $('#addPatientButton');
                var spinner = $('#spinner');

                // Show spinner and disable button
                spinner.show();
                submitBtn.prop('disabled', true);

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: form.serialize(),
                    dataType: 'json',
                    success: function (response) {
                        // Hide spinner and re-enable button
                        spinner.hide();
                        submitBtn.prop('disabled', false);

                        // Check status from the response
                        if (response.status === "success") {
                            swal.fire('Success', response.message, 'success');
                            // $('#registerModal').modal('hide');
                            clearForm();
                        } else {
                            swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function (xhr, status, error) {
                        // Hide spinner and re-enable button
                        spinner.hide();
                        submitBtn.prop('disabled', false);

                        console.error(xhr.responseText);
                        swal.fire('Error', 'An error occurred. Please try again.', 'error');
                    }
                });
            });
        });
    </script>

    <script>
        function calculateAge() {
            const birthdate = new Date(document.getElementById("birthdate").value);
            const today = new Date();

            let years = today.getFullYear() - birthdate.getFullYear();
            let months = today.getMonth() - birthdate.getMonth();
            let days = today.getDate() - birthdate.getDate();

            // Adjust for negative days and months
            if (days < 0) {
                months--;
                const daysInPreviousMonth = new Date(today.getFullYear(), today.getMonth(), 0).getDate();
                days += daysInPreviousMonth;
            }

            if (months < 0) {
                years--;
                months += 12;
            }

            let ageDisplay;

            if (years > 0) {
                ageDisplay = `${years} ${years === 1 ? "year" : "years"} old`;
                if (months > 0 || days > 0) {
                    ageDisplay += `, ${months} ${months === 1 ? "month" : "months"} and ${days} ${days === 1 ? "day" : "days"}`;
                }
            } else if (years === 1 && months === 0 && days >= 0) {
                ageDisplay = "1 year old";
            } else if (months > 0) {
                ageDisplay = `${months} ${months === 1 ? "month" : "months"} and ${days} ${days === 1 ? "day" : "days"}`;
            } else {
                const diffTime = today - birthdate;
                const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
                if (diffDays < 7) {
                    ageDisplay = `${diffDays} ${diffDays === 1 ? "day" : "days"}`;
                } else {
                    const weeks = Math.floor(diffDays / 7);
                    const remainingDays = diffDays % 7;
                    ageDisplay = `${weeks} ${weeks === 1 ? "week" : "weeks"} and ${remainingDays} ${remainingDays === 1 ? "day" : "days"}`;
                }
            }

            // Update the age display
            document.getElementById("age_display").innerText = ageDisplay;
            document.getElementById("age").value = `${years} years, ${months} months, ${days} days`; // Example format
        }

        // Set the max date for the birthdate input to today
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0'); // Add 1 to month since it's zero-based
        const day = String(today.getDate()).padStart(2, '0');
        const maxDate = `${year}-${month}-${day}`;

        document.getElementById("birthdate").max = maxDate;

        // Attach the calculateAge function to the input's change event
        document.getElementById("birthdate").addEventListener("change", calculateAge);
    </script>
    <script>
        // Function to update the serial number
        function updateSerialNumber() {
            $.ajax({
                url: 'action/get_serial.php',
                type: 'GET',
                success: function (data) {
                    $('#serial_no').val(data);
                },
                error: function () {
                    // Handle errors if any
                    console.log('Error fetching serial number.');
                }
            });
        }

        // Call the function on page load
        updateSerialNumber();

        // Optionally, update the serial number periodically
        setInterval(updateSerialNumber, 2000); // Update every 2 seconds
    </script>

</body>

</html>