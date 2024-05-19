<?php
// Include your database configuration file
include_once('../../config.php');


$sql = "SELECT *,CONCAT(patients.last_name, ', ', patients.first_name) AS full_name
FROM patients 
WHERE is_active = 0 AND patients.is_deleted = 0 ORDER BY serial_no DESC";

$result = $conn->query($sql);

if ($result === false) {
    die("Query failed: " . $conn->error);
}


$currentYear = date("y");
$defaultSerial = $currentYear . "0001";

// Query to get the latest serial number
$sql2 = "SELECT MAX(serial_no) AS max_serial FROM patients";
$result2 = $conn->query($sql2);

if ($result2->num_rows > 0) {
    $row2 = $result2->fetch_assoc();
    // Get the latest serial number
    $latestSerial = $row2["max_serial"];

    // Extract year from the latest serial number
    $latestYear = substr($latestSerial, 0, 2);

    // Check if the latest serial number is from the current year
    if ($latestYear == $currentYear) {
        // Increment the counting part
        $newCount = intval(substr($latestSerial, -4)) + 1;
        $newSerial = $currentYear . sprintf("%04d", $newCount);
    } else {
        // If the latest serial number is from a different year, start from 0001
        $newSerial = $currentYear . "0001";
    }
} else {
    // If there are no records, use the default serial number
    $newSerial = $defaultSerial;
}
?>

<div class="container-fluid">
    <button type="button" id="openModalButton" class="btn btn-primary">
        Add Patient
    </button>

    <a href="archive.php">
        <button type="button" class="btn btn-danger ml-1">
            View Archive
        </button>
    </a>
    <br><br>

    <!-- Add Patient Modal -->
    <div class="modal fade" id="addPatientModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Patient</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addPatientForm">
                        <style>
                            .otag {
                                display: none;
                            }
                        </style>
                        <div class="form-group otag">
                            <label for="">Select Step</label>
                            <select class="form-control" name="step" id="step" required class="">
                                <option value="" disabled selected hidden>Select a Step</option>
                                <option value="Walk In">Interview Staff</option>
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
                            <!-- <div id="editStatus_error" class="error"></div> -->
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <!-- Adjusted column size for small screens -->
                                <div class="form-group">
                                    <label for="first_name">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter Your Firstname" required>
                                    <div id="first_name_error" class="error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter your Lastname" required>
                                    <div id="last_name_error" class="error"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="middle_name">Middle Name</label>
                                    <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Enter your Middlename" required>
                                    <div id="middle_name_error" class="error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="suffix">Suffix</label>
                                    <input type="text" class="form-control" id="suffix" name="suffix" placeholder="ex. Jr. and Sr." required>
                                    <div id="suffix_error" class="error"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Add more rows/columns as needed -->

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
                                        <input type="text" class="form-control" id="contact_no" name="contact_no" required>
                                        <div id="contact_error" class="error"></div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Add more rows/columns as needed -->

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="civil_status">Civil Status</label>
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

                        <!-- Add more rows/columns as needed -->

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="age">Age (Click The Birthdate First)</label>
                                    <p id="age" class="form-control" name="age" readonly></p>
                                    <div id="age_error" class="error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="serial_no">Serial No</label>
                                    <input type="text" class="form-control" id="serial_no" name="serial_no" value="<?php echo $newSerial; ?>" required readonly>
                                    <div id="serial_error" class="error"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Add more rows/columns as needed -->

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
                                        <option value="Zone 1, Bulua, Cagayan de Oro">Zone 1, Bulua, Cagayan de Oro, Misamis Oriental</option>
                                        <option value="Zone 2, Bulua, Cagayan de Oro">Zone 2, Bulua, Cagayan de Oro, Misamis Oriental</option>
                                        <option value="Zone 3, Bulua, Cagayan de Oro">Zone 3, Bulua, Cagayan de Oro, Misamis Oriental</option>
                                        <option value="Zone 4, Bulua, Cagayan de Oro">Zone 4, Bulua, Cagayan de Oro, Misamis Oriental</option>
                                        <option value="Zone 5, Bulua, Cagayan de Oro">Zone 5, Bulua, Cagayan de Oro, Misamis Oriental</option>
                                        <option value="Zone 6, Bulua, Cagayan de Oro">Zone 6, Bulua, Cagayan de Oro, Misamis Oriental</option>
                                        <option value="Zone 7, Bulua, Cagayan de Oro">Zone 7, Bulua, Cagayan de Oro, Misamis Oriental</option>
                                        <option value="Zone 8, Bulua, Cagayan de Oro">Zone 8, Bulua, Cagayan de Oro, Misamis Oriental</option>
                                        <option value="Zone 9, Bulua, Cagayan de Oro">Zone 9, Bulua, Cagayan de Oro, Misamis Oriental</option>
                                        <option value="Zone 10, Bulua, Cagayan de Oro">Zone 10, Bulua, Cagayan de Oro, Misamis Oriental</option>
                                        <option value="Zone 11, Bulua, Cagayan de Oro">Zone 11, Bulua, Cagayan de Oro, Misamis Oriental</option>
                                        <option value="Zone 12, Bulua, Cagayan de Oro">Zone 12, Bulua, Cagayan de Oro, Misamis Oriental</option>
                                        <option value="Zone 13, Bulua, Cagayan de Oro">Zone 13, Bulua, Cagayan de Oro, Misamis Oriental</option>
                                        <!-- Add more address options as needed -->
                                    </select>
                                    <div id="address_error" class="error"></div>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea class="form-control" id="address" name="address" rows="3"
                                        required></textarea>
                                    <div id="address_error" class="error"></div>
                                </div>
                            </div>
                        </div> -->
                        <!-- Add more fields here if needed -->
                        <!-- Add a button to trigger the addition of child information -->
                        <!-- <button id="addChildButton" class="btn btn-primary">Add Child Information</button> -->

                        <!-- Placeholder for child information -->
                        <div id="childInformationPlaceholder"></div>

                        <script>
                            // Function to add a new set of child information fields
                            function addChildInformation() {
                                var childInfoHTML = `
            <h5>Child Information</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="first_name_child">First Name</label>
                        <input type="text" class="form-control" name="first_name_child" id="first_name_child" required>
                        <div class="error"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="last_name_child">Last Name</label>
                        <input type="text" class="form-control" name="last_name_child" id="last_name_child" required>
                        <div class="error"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="middle_name_child">Middle Name</label>
                        <input type="text" class="form-control" name="middle_name_child" id="middle_name_child" required>
                        <div class="error"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="suffix_child">Suffix</label>
                        <input type="text" class="form-control" name="suffix_child" id="suffix_child" required>
                        <div class="error"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="gender_child">Select Gender</label>
                        <select class="form-control" name="gender_child" id="gender_child" required>
                            <option value="" disabled selected hidden>Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                        <div class="error"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="birthdate_child">Birthdate</label>
                        <input type="date" class="form-control" name="birthdate_child" id="birthdate_child" required>
                        <div class="error"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="birth_weight">Birth Weight</label>
                        <input type="text" class="form-control" id="birth_weight" name="birth_weight" required>
                        <div class="error"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="birth_height">Birth Height</label>
                        <input type="text" class="form-control" id="birth_height" name="birth_height" required>
                        <div class="error"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="place_of_birth">Place of Birth</label>
                        <textarea class="form-control" id="place_of_birth" name="place_of_birth" rows="3" required></textarea>
                        <div id="place_of_birth_error" class="error"></div>
                    </div>
                </div>
            </div>


        `;

                                // Append the child information fields to the placeholder
                                document.getElementById('childInformationPlaceholder').innerHTML += childInfoHTML;
                            }

                            // Add an event listener to the button to trigger the addition of child information
                            document.getElementById('addChildButton').addEventListener('click', addChildInformation);
                        </script>
                        <script>
                            // Function to set "None" value for all child information fields
                            function setNoneForChild() {
                                // Get all input and textarea elements within the child information section
                                var childInputs = document.querySelectorAll('#childInformationPlaceholder input, #childInformationPlaceholder textarea');

                                // Loop through each input and set its value to "None"
                                childInputs.forEach(function(input) {
                                    input.value = 'None';
                                });
                            }
                        </script>



                    </form>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-warning" id="NoneChildButton"
                        onclick="setNoneForChild()">Doesn't Have a Child</button> -->
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeModalButton">Close</button>
                    <button type="button" class="btn btn-primary" id="addPatientButton">Save</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        // Add an event listener to the Save button
        document.getElementById('addPatientButton').addEventListener('click', function() {
            // Assuming you have a variable `completedStep` that holds the completed step value, e.g., "Step1", "Step2", etc.
            var completedStep = "Walk In"; // Example completed step

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
            document.getElementById("age").innerText = ageDisplay;
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

    <div class="row">
        <div class="col-12">
            <div class="card-body table-responsive p-0" style="z-index: -99999">
                <table id="patientTableBody" class="table table-head-fixed text-nowrap table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th style="display:none;">ID</th>
                            <th>Serial Number</th>
                            <th>Full Name</th>
                            <!-- <th>Child Name</th> -->
                            <th>Birthdate</th>
                            <th>Address</th>
                            <th>Register Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td class="align-middle" style="display: none;">
                                        <?php echo $row['id']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo $row['serial_no']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo $row['full_name']; ?>
                                    </td>
                                    <!-- <td class="align-middle">
                                        <?php echo $row['Child']; ?>
                                    </td> -->
                                    <td class="align-middle">
                                        <?php echo $row['birthdate']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo $row['address']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo $row['step']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <button type="button" class="btn btn-warning editbtns" data-row-id="<?php echo $row['serial_no']; ?>">
                                            <i class="fas fa-eye"></i> View Record
                                        </button>

                                        <button type="button" class="btn btn-success editbtn" data-patient-id="<?php echo $row['serial_no']; ?>">
                                            <i class="fas fa-edit"></i> Update
                                        </button>
                                        <button type="button" class="btn btn-danger deletebtn" data-id="' + row.serial_no + '"><i class="fas fa-user-times"></i> Inactive</button>
                                        <!-- Button trigger modal -->
                                        <!-- <button type="button" class="btn btn-primary childbtn" data-toggle="modal"
                                            data-target="#childModal_<?php echo $row['serial_no']; ?>">
                                            Child Details
                                        </button> -->

                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td class="align-middle"></td>
                                <td class="align-middle">No Patient Found</td>
                                <td class="align-middle">
                                <td>
                                <td class="align-middle"></td>
                                <td class="align-middle"></td>
                                <td class="align-middle"></td>
                                <!-- <td class="align-middle"></td> -->


                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Child Modal -->
    <!-- <div class="modal fade" id="childModal" tabindex="-1" role="dialog" aria-labelledby="childModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="childModalLabel">Child Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"> -->
    <!-- Child details go here -->
    <!-- <p id="childName"></p>
    <p id="childBirthdate"></p>
    <p id="childAddress"></p>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div> -->



    <!-- modal edit -->
    <!-- Edit Patient Modal -->
    <div class="modal fade" id="editPatientModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Patient</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group ">
                        <label for="">Select Process</label>
                        <select class="form-control" name="step" id="editstep" required class="">
                            <option value="" disabled selected hidden>Select a Process</option>
                            <option value="Walk In">Interview Staff</option>
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
                        <!-- <div id="editStatus_error" class="error"></div> -->
                    </div>

                    <form id="editPatientForm">
                        <!-- Form fields for editing patient details -->
                        <input type="hidden" id="editPatientId" name="patient_id">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first_name">First Name</label>
                                    <input type="text" class="form-control" id="editFirstname" name="first_name" required>
                                    <div id="editFirstName_error" class="error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" class="form-control" id="editLastname" name="last_name" required>
                                    <div id="editLastname_error" class="error"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="middle_name">Middle Name</label>
                                    <input type="text" class="form-control" id="editMiddlename" name="middle_name" required>
                                    <div id="editMiddleName_error" class="error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="suffix">Suffix</label>
                                    <input type="text" class="form-control" id="editSuffix" name="suffix" required>
                                    <div id="editSuffixName_error" class="error"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gender">Select Gender</label>
                                    <select class="form-control" name="gender" id="editGender" required>
                                        <option value="" disabled selected hidden>Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                    <div id="editgender_error" class="error"></div>
                                </div>
                            </div>
                            <!-- <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contact_no">Contact No</label>
                                    <input type="number" class="form-control" id="editContact_no" name="contact_no" required>
                                    <div id="editContact_error" class="error"></div>
                                </div>
                            </div> -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contact_no">Contact No</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon3">+63</span>
                                        </div>
                                        <input type="number" class="form-control" id="editContact_no" name="contact_no" required>
                                        <div id="editContact_error" class="error"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="civil_status">Civil Status</label>
                                    <select class="form-control" name="civil_status" id="editCivilstatus" required>
                                        <option value="" disabled selected hidden>Select Civil Status</option>
                                        <option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                        <option value="Divorced">Divorced</option>
                                        <option value="Widowed">Widowed</option>
                                    </select>
                                    <div id="editCivilStatus_error" class="error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="birthdate">Birthdate</label>
                                    <input type="date" class="form-control" id="editBirthdate" name="birthdate" required>
                                    <div id="editBirthDate_error" class="error"></div>
                                </div>
                            </div>
                            <script>
                                const today = new Date();
                                const year = today.getFullYear();
                                const month = String(today.getMonth() + 1).padStart(2, '0'); // Add 1 to month since it's zero-based
                                const day = String(today.getDate()).padStart(2, '0');
                                const maxDate = `${year}-${month}-${day}`;
                                document.getElementById("birthdate").max = maxDate;
                            </script>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="age">Age</label>
                                    <input type="number" class="form-control" id="editAge" name="age" required>
                                    <div id="editAge_error" class="error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="serial_no">Serial No</label>
                                    <input type="text" class="form-control" id="editSerial_no" name="serial_no" required readonly>
                                    <div id="editSerial_error" class="error"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="religion">Religion</label>
                                    <select class="form-control" name="religion" id="editReligion" required>
                                        <option value="" disabled selected hidden>Select Religion</option>
                                        <option value="Roman Catholic">Roman Catholic</option>
                                        <option value="Muslim">Muslim</option>
                                        <option value="Iglesia ni Cristo">Iglesia ni Cristo</option>
                                        <option value="Protestantism">Protestantism</option>
                                        <option value="Other or Non-religious">Other or Non-religious</option>
                                    </select>
                                    <div id="EditReligion_error" class="error"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea class="form-control" id="editAddress" name="address" rows="3" required></textarea>
                                    <div id="EditAddress_error" class="error"></div>
                                </div>
                            </div>
                        </div>
                        <!-- Add more fields here if needed -->
                        <!-- Add a button to trigger the addition of child information -->
                        <button id="UpdateChildButton" class="btn btn-primary">Add Child Information</button>

                        <!-- Placeholder for child information -->
                        <div id="childInformationPlaceholders"></div>

                        <script>
                            // Function to add a new set of child information fields
                            function addChildInformations() {
                                var childsInfoHTML = `
            <h5>Child Information</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="first_name_child">First Name</label>
                        <input type="text" class="form-control" name="first_name_child" id="first_name_child2" required>
                        <div class="error"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="last_name_child">Last Name</label>
                        <input type="text" class="form-control" name="last_name_child" id="last_name_child2" required>
                        <div class="error"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="middle_name_child">Middle Name</label>
                        <input type="text" class="form-control" name="middle_name_child" id="middle_name_child2" required>
                        <div class="error"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="suffix_child">Suffix</label>
                        <input type="text" class="form-control" name="suffix_child" id="suffix_child2" required>
                        <div class="error"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="gender_child">Select Gender</label>
                        <select class="form-control" name="gender_child" id="gender_child2" required>
                            <option value="" disabled selected hidden>Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                        <div class="error"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="birthdate_child">Birthdate</label>
                        <input type="date" class="form-control" name="birthdate_child" id="birthdate_child2" required>
                        <div class="error"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="birth_weight">Birth Weight</label>
                        <input type="text" class="form-control" id="birth_weight2" name="birth_weight" required>
                        <div class="error"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="birth_height">Birth Height</label>
                        <input type="text" class="form-control" id="birth_height2" name="birth_height" required>
                        <div class="error"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="place_of_birth">Place of Birth</label>
                        <textarea class="form-control" id="place_of_birth2" name="place_of_birth" rows="3" required></textarea>
                        <div id="place_of_birth_error" class="error"></div>
                    </div>
                </div>
            </div>


        `;

                                // Append the child information fields to the placeholder
                                document.getElementById('childInformationPlaceholders').innerHTML += childsInfoHTML;
                            }

                            // Add an event listener to the button to trigger the addition of child information
                            document.getElementById('UpdateChildButton').addEventListener('click', addChildInformations);
                        </script>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updatePatientButton">Update</button>
                </div>
            </div>
        </div>
    </div>




    <!-- modal edit -->
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    document.getElementById("contact_no").addEventListener("input", function() {
        var contactInput = document.getElementById("contact_no").value.trim();
        if (contactInput.startsWith("0")) {
            contactInput = contactInput.substring(1);
        }
        document.getElementById("contact_no").value = contactInput;
    });

    $(document).ready(function() {

        $('#contact_no').on('input', function() {
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


        $('#editContact_no').on('input', function() {
            var editcontactNo = $(this).val();
            if (editcontactNo.length < 10) {
                $('#editContact_error').text('\nInvalid Phone number.');
            } else if (!editcontactNo.startsWith("9")) {
                $('#editContact_error').text('\nInvalid Phone number. Phone number should start with 9');
            } else {
                $('#editContact_error').text('');
            }


            if (contactNo.length > 10) {
                $(this).val(contactNo.substring(0, 10));
            }
        });

        var contactInput = document.getElementById("editContact_no").value.trim();

        if (contactInput.startsWith("+63")) {
            contactInput = contactInput.substring(3);
        }

        document.getElementById("editContact_no").value = contactInput;

        function updateSerialNumber() {
            $.ajax({
                url: 'action/get_serial.php',
                type: 'GET',
                success: function(data) {
                    $('#serial_no').val(data);
                },
                error: function() {
                    // Handle errors if any
                    console.log('Error fetching serial number.');
                }
            });
        }

        // Call the function on page load
        updateSerialNumber();

        // Optionally, update the serial number periodically
        setInterval(updateSerialNumber, 2000); // Update every 2 seconds

        // Event listener for displaying child details modal
        $('#patientTableBody').on('click', '.childbtn', function() {
            var childName = $(this).data('name');
            var childBirthdate = $(this).data('birthdate');
            var childAddress = $(this).data('address');

            // Set modal content
            $('#childName').text('Child Name: ' + childName);
            $('#childBirthdate').text('Birthdate: ' + childBirthdate);
            $('#childAddress').text('Address: ' + childAddress);

            // Show the modal
            $('#childModal').modal('show');
        });

        //Modal add Patient
        document.getElementById('openModalButton').addEventListener('click', function() {
            $('#addPatientModal').modal('show'); // Show the modal
        });

        // Check if there are rows in the PHP-generated table
        <?php if ($result->num_rows > 0) : ?>
            var table = $('#patientTableBody').DataTable({
                columnDefs: [{
                        targets: 0,
                        data: 'id',
                        visible: false
                    },
                    {
                        targets: 1,
                        data: 'serial_no'
                    },
                    {
                        targets: 2,
                        data: 'full_name'
                    },
                    // { targets: 3, data: 'Child' },
                    {
                        targets: 3,
                        data: 'birthdate'
                    },
                    {
                        targets: 4,
                        data: 'address'
                    },
                    {
                        targets: 5,
                        data: 'step'
                    },
                    {
                        targets: 6,
                        searchable: false,
                        data: null,
                        render: function(data, type, row) {
                            var viewRec = '<a href="history.php?id=' + row.id + '"><button type="button" class="btn btn-warning ml-1">  <i class="fas fa-eye"></i> View History</button></a>';
                            var editButton = '<button type="button" class="btn btn-success editbtn" data-patient-id="' + row.serial_no + '"><i class="fas fa-edit"></i> Update</button>';
                            var deleteButton = '<button type="button" class="btn btn-danger deletebtn" data-id="' + row.serial_no + '"><i class="fas fa-user-times"></i> Inactive</button>';
                            // var childButton = '<button type="button" class="btn btn-primary childbtn" data-name="' + row.Child + '" data-birthdate="' + row.birthdate + '" data-address="' + row.address + '"><i class="fas fa-user"></i> View Child</button>';
                            return viewRec + ' ' + editButton + ' ' + deleteButton;
                        }
                    } // Action column
                ],
                // Set the default ordering to 'id' column in descending order
                order: [
                    [0, 'desc']
                ]
            });

        <?php else : ?>
            // Initialize DataTable without the "Action" column when no rows are found
            var table = $('#patientTableBody').DataTable({
                columnDefs: [{
                        targets: 0,
                        data: 'id',
                        visible: false
                    },
                    {
                        targets: 1,
                        data: 'serial_no'
                    },
                    {
                        targets: 2,
                        data: 'full_name'
                    },
                    // { targets: 3, data: 'Child' },
                    {
                        targets: 3,
                        data: 'birthdate'
                    },
                    {
                        targets: 4,
                        data: 'address'
                    },
                    {
                        targets: 5,
                        data: 'step'
                    }
                ],
                // Set the default ordering to 'id' column in descending order
                order: [
                    [0, 'desc']
                ]
            });
        <?php endif; ?>



        $('#addPatientButton').click(function() {

            $('.error').text('');

            // Get data from the form
            var step = $('#step').val();
            var first_name = $('#first_name').val();
            var last_name = $('#last_name').val();
            var birthdate = $('#birthdate').val();
            var address = $('#address').val();

            var middle_name = $('#middle_name').val();
            var suffix = $('#suffix').val();
            var gender = $('#gender').val();
            var age = $('#age').val();

            var contact_no = $('#contact_no').val();
            var civil_status = $('#civil_status').val();
            var religion = $('#religion').val();
            var serial_no = $('#serial_no').val();



            // Validate input fields
            var isValid = false;

            if (first_name.trim() === '' || last_name.trim() === '' || birthdate.trim() === '' || address.trim() === '') {
                isValid = false;
                $('#first_name_error').text('Field is required');
            } else {
                isValid = true;
                table.destroy(); // Destroy the existing DataTable
                table = $('#patientTableBody').DataTable({
                    columnDefs: [{
                            targets: 0,
                            data: 'id',
                            visible: false
                        },
                        {
                            targets: 1,
                            data: 'serial_no'
                        },
                        {
                            targets: 2,
                            data: 'full_name'
                        },
                        // { targets: 3, data: 'Child' },
                        {
                            targets: 3,
                            data: 'birthdate'
                        },
                        {
                            targets: 4,
                            data: 'address'
                        },
                        {
                            targets: 5,
                            data: 'step'
                        },
                        {
                            targets: 6,
                            searchable: false,
                            data: null,
                            render: function(data, type, row) {
                                var viewRec = '<a href="history.php?id=' + row.id + '"><button type="button" class="btn btn-warning ml-1">  <i class="fas fa-eye"></i> View History</button></a>';
                                var editButton = '<button type="button" class="btn btn-success editbtn" data-patient-id="' + row.serial_no + '"><i class="fas fa-edit"></i> Update</button>';
                                var deleteButton = '<button type="button" class="btn btn-danger deletebtn" data-id="' + row.serial_no + '"><i class="fas fa-user-times"></i> Inactive</button>';
                                // var childButton = '<button type="button" class="btn btn-primary childbtn" data-name="' + row.Child + '" data-birthdate="' + row.birthdate + '" data-address="' + row.address + '"><i class="fas fa-user"></i> View Child</button>';
                                return viewRec + ' ' + editButton + ' ' + deleteButton;
                            }
                        } // Action column
                    ],
                    // Set the default ordering to 'id' column in descending order
                    order: [
                        [0, 'desc']
                    ]
                });
            }


            if (isValid == true) {
                // AJAX request to send data to the server
                $.ajax({
                    url: 'action/add_patient.php',
                    method: 'POST',
                    data: {
                        step: step,
                        first_name: first_name,
                        last_name: last_name,
                        birthdate: birthdate,
                        address: address,
                        middle_name: middle_name,
                        suffix: suffix,
                        gender: gender,
                        age: age,
                        contact_no: contact_no,
                        civil_status: civil_status,
                        religion: religion,
                        serial_no: serial_no,

                    },
                    success: function(response) {

                        // if (document.getElementById("first_name_child").value != "") {
                        //     addChild();
                        // }

                        // Handle the response
                        if (response === 'Success') {
                            // Clear the form fields
                            $('#first_name').val('');
                            $('#last_name').val('');
                            $('#birthdate').val('');
                            $('#address').val('');

                            updatePatientTable();
                            $('#addPatientModal').modal('hide');

                            // Remove the modal backdrop manually
                            $('body').removeClass('modal-open');
                            $('.modal-backdrop').remove();
                            // Show a success SweetAlert
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Patient added successfully',
                            });

                        } else {
                            // Show an error SweetAlert
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error adding patient: ' + response,
                            });
                        }
                    },
                    error: function(error) {
                        // Handle errors
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error adding patient: ' + error,
                        });
                    },

                });
            }
        });

        // Function to update the patient table
        function updatePatientTable() {
            $.ajax({
                url: 'action/get_patient.php',
                method: 'GET',
                success: function(data) {
                    // Assuming the server returns JSON data, parse it
                    var patients = JSON.parse(data);

                    // Clear the DataTable and redraw with new data
                    table.clear().rows.add(patients).draw();
                },
                error: function(error) {
                    // Handle errors
                    console.error('Error retrieving patients: ' + error);
                }
            });
        }

        // Delete button click event
        $('#patientTableBody').on('click', '.deletebtn', function() {
            var patientId = $(this).data('id');

            // Confirm the deletion with a SweetAlert dialog
            Swal.fire({
                title: 'Confirm Inactive',
                text: 'Are you sure you want to Inactive this patient?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Inactive it'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send an AJAX request to delete the patient
                    $.ajax({
                        url: 'action/delete_patient.php',
                        method: 'POST',
                        data: {
                            patient_id: patientId
                        },
                        success: function(response) {
                            if (response === 'Success') {
                                // Patient deleted successfully, update the table
                                updatePatientTable();
                                Swal.fire('Inactive', 'The patient has been Inactive.', 'success');
                            } else {
                                Swal.fire('Error', 'Error Inactive patient: ' + response, 'error');
                            }
                        },
                        error: function(error) {
                            Swal.fire('Error', 'Error Inactive patient: ' + error, 'error');
                        }
                    });
                }
            });
        });



        // Edit button click event
        $('#patientTableBody').on('click', '.editbtn', function() {
            var patientId = $(this).data('patient-id');

            $.ajax({
                url: 'action/get_patient_by_id.php', // Replace with the actual URL to fetch patient data
                method: 'POST',
                data: {
                    patient_id: patientId
                },
                success: function(data) {

                    var patientData = data;


                    // Populate the Edit Patient Modal with patient details
                    $('#editPatientModal #editPatientId').val(patientData.id);
                    $('#editPatientModal #editstep').val(patientData.step);
                    $('#editPatientModal #editFirstname').val(patientData.first_name);
                    $('#editPatientModal #editLastname').val(patientData.last_name);
                    $('#editPatientModal #editBirthdate').val(patientData.birthdate);
                    $('#editPatientModal #editAddress').val(patientData.address);
                    $('#editPatientModal #editMiddlename').val(patientData.middle_name);
                    $('#editPatientModal #editSuffix').val(patientData.suffix);
                    $('#editPatientModal #editGender').val(patientData.gender);
                    var contactNo = patientData.contact_no.trim().replace(/\D/g, ''); // Remove non-numeric characters
                    $('#editPatientModal #editContact_no').val(contactNo);
                    // $('#editPatientModal #editContact_no').val(patientData.contact_no);
                    $('#editPatientModal #editCivilstatus').val(patientData.civil_status);
                    $('#editPatientModal #editAge').val(patientData.age);
                    $('#editPatientModal #editSerial_no').val(patientData.serial_no);
                    $('#editPatientModal #editReligion').val(patientData.religion);


                    // Show the Edit Patient Modal
                    $('#editPatientModal').modal('show');
                },
                error: function(error) {
                    console.error('Error fetching patient data: ' + error);
                },
            });
        });
        // When the "Update" button in the update modal is clicked
        // When the "Update" button in the update modal is clicked
        $('#updatePatientButton').click(function() {
            event.preventDefault();
            $('.error').text('');
            // Get the updated patient data from the form
            var patientId = $('#editPatientId').val();
            var step = $('#editstep').val();
            var firstName = $('#editFirstname').val();
            var lastName = $('#editLastname').val();
            var birthdate = $('#editBirthdate').val();
            var address = $('#editAddress').val();
            var middleName = $('#editMiddlename').val();
            var Suffix = $('#editSuffix').val();
            var Gender = $('#editGender').val();
            var Contactno = $('#editContact_no').val();
            var Civilstatus = $('#editCivilstatus').val();
            var Age = $('#editAge').val();
            var Serialno = $('#editSerial_no').val();
            var Religion = $('#editReligion').val();


            var isValid = true;

            if (firstName.trim() === '') {
                $('#editFirstName_error').text('Field is required');
                isValid = false;
            }

            if (lastName.trim() === '') {
                $('#editLastname_error').text('Field is required');
                isValid = false;
            }

            if (birthdate.trim() === '') {
                $('#editBirthDate_error').text('Field is required');
                isValid = false;
            }

            if (address.trim() === '') {
                $('#EditAddress_error').text('Field is required');
                isValid = false;
            }

            if (middleName.trim() === '') {
                $('#editMiddleName_error').text('Field is required');
                isValid = false;
            }

            if (Suffix.trim() === '') {
                $('#editSuffixName_error').text('Field is required');
                isValid = false;
            }

            if (Gender.trim() === '') {
                $('#editgender_error').text('Field is required');
                isValid = false;
            }

            if (Contactno.trim() === '') {
                $('#editContact_error').text('Field is required');
                isValid = false;
            }

            if (Civilstatus.trim() === '') {
                $('#editCivilStatus_error').text('Field is required');
                isValid = false;
            }

            if (Age.trim() === '') {
                $('#editAge_error').text('Field is required');
                isValid = false;
            }

            if (Serialno.trim() === '') {
                isValid = false;
            }

            if (Religion.trim() === '') {
                $('#EditReligion_error').text('Field is required');
                isValid = false;
            }

            // Only proceed with AJAX request if all fields are valid
            if (isValid) {

                // Send an AJAX request to update the patient data
                $.ajax({
                    url: 'action/update_patient.php',
                    method: 'POST',
                    data: {
                        patient_id: patientId,
                        step: step,
                        first_name: firstName,
                        last_name: lastName,
                        birthdate: birthdate,
                        address: address,
                        middle_name: middleName,
                        suffix: Suffix,
                        gender: Gender,
                        contact_no: Contactno,
                        civil_status: Civilstatus,
                        age: Age,
                        serial_no: Serialno,
                        religion: Religion
                    },
                    success: function(response) {
                        // Handle the response
                        if (response === 'Success') {
                            updatePatientTable();
                            $('#editPatientModal').modal('hide');
                            // Remove the modal backdrop manually
                            $('body').removeClass('modal-open');
                            $('.modal-backdrop').remove();
                            // Show a success Swal notification
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Patient updated successfully',
                            });
                        } else {
                            // Show an error Swal notification
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error updating patient: ' + response,
                            });
                        }
                    },
                    error: function(error) {
                        // Show an error Swal notification for AJAX errors
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error updating patient: ' + error,
                        });
                    }
                });
            }
        });

    });

    // function addChild() {
    //     var first_name_child = $('#first_name_child').val();
    //     var last_name_child = $('#last_name_child').val();
    //     var middle_name_child = $('#middle_name_child').val();
    //     var suffix_child = $('#suffix_child').val();
    //     var gender_child = $('#gender_child').val();
    //     var birthdate_child = $('#birthdate_child').val();
    //     var birth_weight = $('#birth_weight').val();
    //     var birth_height = $('#birth_height').val();
    //     var place_of_birth = $('#place_of_birth').val();

    //     $.ajax({
    //         url: 'action/add_child.php',
    //         method: 'POST',
    //         data: {
    //             first_name_child: first_name_child,
    //             last_name_child: last_name_child,
    //             middle_name_child: middle_name_child,
    //             suffix_child: suffix_child,
    //             gender_child: gender_child,
    //             birthdate_child: birthdate_child,
    //             birth_weight: birth_weight,
    //             birth_height: birth_height,
    //             place_of_birth: place_of_birth
    //         },
    //         success: function (response) {
    //             // Handle the response
    //             if (response === 'Success') {

    //                 $('#first_name_child').val('');
    //                 $('#last_name_child').val('');
    //                 $('#middle_name_child').val('');
    //                 $('#suffix_child').val('');
    //                 $('#gender_child').val('');
    //                 $('#birthdate_child').val('');
    //                 $('#birth_weight').val('');
    //                 $('#birth_height').val('');
    //                 $('#place_of_birth').val('');

    //                 // Optionally, trigger additional actions or show a success message
    //                 Swal.fire({
    //                     icon: 'success',
    //                     title: 'Success',
    //                     text: 'Child added successfully',
    //                 });
    //             } else {
    //                 // Show an error message
    //                 Swal.fire({
    //                     icon: 'error',
    //                     title: 'Error',
    //                     text: 'Error adding child: ' + response,
    //                 });
    //             }
    //         },
    //         error: function (error) {
    //             // Handle errors
    //             Swal.fire({
    //                 icon: 'error',
    //                 title: 'Error',
    //                 text: 'Error adding child: ' + error,
    //             });
    //         },
    //     });
    // }
</script>

<script>
    // Set the timeout duration (in milliseconds)
    var inactivityTimeout = 360000; // 10 seconds

    // Track user activity
    var activityTimer;

    function resetTimer() {
        clearTimeout(activityTimer);
        activityTimer = setTimeout(logout, inactivityTimeout);
    }

    function logout() {
        // Redirect to logout PHP script
        window.location.href = '../action/logout.php';
    }

    // Add event listeners to reset the timer on user activity
    document.addEventListener('mousemove', resetTimer);
    document.addEventListener('keypress', resetTimer);

    // Initialize the timer on page load
    resetTimer();
</script>