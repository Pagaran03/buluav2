<?php
// Include your database configuration file
include_once ('config.php');
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




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css"
        integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">
    <style>
        body {
            background: url('assets/images/register.png') no-repeat center center fixed;
            background-size: cover;
        }
    </style>
</head>

<body>
    <h1 class="text-center font-weight-semibold mt-4" style="margin-top: 20px;">Register</h1>
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
                </select>
                <!-- <div id="editStatus_error" class="error"></div> -->
            </div>

            <div class="row">
                <div class="col-md-6">
                    <!-- Adjusted column size for small screens -->
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
                        <input type="text" class="form-control" id="middle_name" name="middle_name" required>
                        <div id="middle_name_error" class="error"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="suffix">Suffix</label>
                        <input type="text" class="form-control" id="suffix" name="suffix" required>
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
                        <label for="age">Age</label>
                        <p id="age" class="form-control" name="age"></p>
                        <div id="age_error" class="error"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="serial_no">Serial No</label>
                        <input type="text" class="form-control" id="serial_no" name="serial_no"
                            value="<?php echo $newSerial; ?>" required readonly>
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
                        <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                        <div id="address_error" class="error"></div>
                    </div>
                </div>
            </div>



        </form>
    </div>
    <div class="modal-footer">
        <!-- <button type="button" class="btn btn-warning" id="NoneChildButton"
                        onclick="setNoneForChild()">Doesn't Have a Child</button> -->
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeModalButton">Close</button>
        <button type="button" class="btn btn-primary" id="addPatientButton">Save</button>
    </div>
    </div>

    <!-- Bootstrap and Popper.js scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Include SweetAlert CSS and JS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- Script to clear form entries -->
    <script>
        function clearForm() {
            document.getElementById("serial_number").value = "";
            document.getElementById("firstname").value = "";
            document.getElementById("lastname").value = "";
            document.getElementById("middlename").value = "";
            document.getElementById("age").value = "";
            document.getElementById("contact_no").value = "";
            document.getElementById("civilStatus").value = "";
            document.getElementById("religion").value = "";
            document.getElementById("birthdate").value = "";
            document.getElementById("address").value = "";
        }
    </script>
    <script>
        function calculateAge() {
            const birthdate = new Date(document.getElementById("birthdate").value);
            const today = new Date();
            let ages = today.getFullYear() - birthdate.getFullYear();

            // Check if the birthday has occurred this year
            if (
                today.getMonth() < birthdate.getMonth() ||
                (today.getMonth() === birthdate.getMonth() && today.getDate() < birthdate.getDate())
            ) {
                ages--;
            }

            // Update the age display
            document.getElementById("age").innerText = ages;
        }

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


            $('#editContact_no').on('input', function () {
                var editcontactNo = $(this).val();
                if (editcontactNo.length < script script script 10) {
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
        setInterval(updateSerialNumber, 5000); // Update every 5 seconds (adjust as needed)

        // Event listener for displaying child details modal
        $('#patientTableBody').on('click', '.childbtn', function () {
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
        document.getElementById('openModalButton').addEventListener('click', function () {
            $('#addPatientModal').modal('show'); // Show the modal
        });

        // Check if there are rows in the PHP-generated table
        <?php if ($result->num_rows > 0): ?>
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
                    render: function (data, type, row) {
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

        <?php else: ?>
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



        $('#addPatientButton').click(function () {

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
                        render: function (data, type, row) {
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
                    success: function (response) {

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
                    error: function (error) {
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
    });
    </>
</body >

</html >