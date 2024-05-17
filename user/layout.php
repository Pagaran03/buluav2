<?php
// Include your database configuration file
include_once ('../../config.php');

// Function to process form submission
function processFormSubmission($conn)
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate and sanitize input data
        $step = trim($_POST['step']);
        $first_name = trim($_POST['first_name']);
        $last_name = trim($_POST['last_name']);
        $middle_name = trim($_POST['middle_name']);
        $suffix = trim($_POST['suffix']);
        $gender = trim($_POST['gender']);
        $contact_no = trim($_POST['contact_no']);
        $civil_status = trim($_POST['civil_status']);
        $age = trim($_POST['age']);
        $serial_no = trim($_POST['serial_no']);
        $religion = trim($_POST['religion']);
        $address = trim($_POST['address']);
        $birthdate = trim($_POST['birthdate']);

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
            echo "<script>swal.fire('Error', 'Duplicate entry found: A patient with the same first name, last name, and middle name already exists.', 'error');</script>";
        } else {
            // Prepare SQL statement
            $stmt = $conn->prepare("INSERT INTO patients (step, first_name, last_name, middle_name, suffix, gender, contact_no, civil_status, birthdate, age, serial_no, religion, address) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssssssss", $step, $first_name, $last_name, $middle_name, $suffix, $gender, $contact_no, $civil_status, $birthdate, $age, $serial_no, $religion, $address);

            if ($stmt->execute()) {
                echo "<script>swal.fire('Success', 'New record created successfully', 'success');</script>";
            } else {
                echo "<script>swal.fire('Error', 'Error: " . $stmt->error . "', 'error');</script>";
            }

            $stmt->close();
        }

        $stmt_check->close();
    }
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

// Process form submission if POST request
processFormSubmission($conn);

// // Fetch inactive and non-deleted patients
// $sql = "SELECT *, CONCAT(patients.last_name, ', ', patients.first_name) AS full_name FROM patients WHERE is_active = 0 AND patients.is_deleted = 0 ORDER BY serial_no DESC";
// $result = $conn->query($sql);

// if ($result === false) {
//     die("Query failed: " . $conn->error);
// }

// $currentYear = date("y");
// $defaultSerial = $currentYear . "0001";

// // Get the latest serial number
// $sql2 = "SELECT MAX(serial_no) AS max_serial FROM patients";
// $result2 = $conn->query($sql2);

// if ($result2->num_rows > 0) {
//     $row2 = $result2->fetch_assoc();
//     $latestSerial = $row2["max_serial"];
//     $latestYear = substr($latestSerial, 0, 2);

//     if ($latestYear == $currentYear) {
//         $newCount = intval(substr($latestSerial, -4)) + 1;
//         $newSerial = $currentYear . sprintf("%04d", $newCount);
//     } else {
//         $newSerial = $defaultSerial;
//     }
// } else {
//     $newSerial = $defaultSerial;
// }

// // Check for duplicate serial number
// $stmt_check_serial = $conn->prepare("SELECT * FROM patients WHERE serial_no = ?");
// $stmt_check_serial->bind_param("s", $newSerial);
// $stmt_check_serial->execute();
// $result_check_serial = $stmt_check_serial->get_result();

// if ($result_check_serial->num_rows > 0) {
//     echo "<script>swal.fire('Error', 'Duplicate serial number found. Please contact your administrator.', 'error');</script>";
//     exit; // Stop execution if duplicate serial number is found
// }

// $stmt_check_serial->close();

// // Process form submission if POST request
// processFormSubmission($conn);

?>







<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Brgy Health Center</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.1/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="container d-flex justify-content-between">
                <div class="navbar-brand text-left mr-10">
                    <img src="../../assets/images/buluaLogo.png" alt="Brgy Bulua Health Center Logo"
                        style="height:70px; width:70px;">
                    <span class="brand-text font-weight-bold ml-2">Brgy Bulua Health Center</span>
                </div>
                <div class="ml-auto">
                    <a href="#" class="mr-3">Home</a>
                    <a href="#">About</a>
                    <button class="btn btn-primary ml-3" data-toggle="modal"
                        data-target="#registerModal">Register</button>
                </div>
            </div>
        </nav>

        <!-- Content Wrapper -->
        <?php include $contentTemplate; ?>

        <!-- Modal -->
        <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registerModalLabel">Online Register</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
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
                                        <input type="text" class="form-control" id="first_name" name="first_name"
                                            required>
                                        <div id="first_name_error" class="error"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name">Last Name</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name"
                                            required>
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
                                        <input type="date" class="form-control" id="birthdate" name="birthdate"
                                            required>
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
                                        <textarea class="form-control" id="address" name="address" rows="3"
                                            required></textarea>
                                        <div id="address_error" class="error"></div>
                                    </div>
                                </div>
                            </div>



                            <button type="submit" class="btn btn-primary" id="addPatientButton">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="main-footer text-center">
            <strong>&copy; <?php echo date("Y"); ?> <a href="#">Brgy Bulua Health Center</a></strong>. All rights
            reserved.
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script>
        // Add an event listener to the Save button
        document.getElementById('addPatientButton').addEventListener('click', function () {
            // Assuming you have a variable `completedStep` that holds the completed step value, e.g., "Step1", "Step2", etc.
            var completedStep = "Online Register"; // Example completed step

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

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: form.serialize(),
                    success: function (response) {
                        // Assuming the PHP script outputs a SweetAlert script
                        $('body').append(response);
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