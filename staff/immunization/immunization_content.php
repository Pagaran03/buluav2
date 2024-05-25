<?php
// Include your database configuration file
include_once('../../config.php');


$sql = "SELECT *,immunization.id as id,CONCAT(patients.last_name,',',patients.first_name) AS full_name,immunization.description as description
FROM immunization
JOIN patients ON immunization.patient_id = patients.id WHERE immunization.is_deleted = 0";

$result = $conn->query($sql);

if ($result === false) {
    die("Query failed: " . $conn->error);
}

?>

<style>
    .hidden {
        display: none;
    }

    input[type="date"]:invalid {
        background-color: #fdd;
    }
</style>

<div class="container-fluid">


    <div style="text-align: left; float: left;">
        <button type="button" id="openModalButton" class="btn btn-primary">
            Add Child Immunization Record
        </button>
    </div>

    <a href="archive.php">
        <button type="button" class="btn btn-danger ml-1">
            View Archive
        </button>
    </a>

    <a href="history_consultation.php">
        <button type="button" id="openModalButton" class="btn btn-warning ml-1">
            View History
        </button>
    </a>
    <a href="queuing.php">
        <button type="button" id="openModalButton" class="btn btn-info ml-1">
            Queuing
        </button>
    </a>
    <br><br>


    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Child Immunization Schedule</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addForm">
                        <datalist id="patients">
                            <?php
                            // Query to fetch patients from the database
                            $sql2 = "SELECT serial_no, first_name, last_name 
                                                FROM patients 
                                                WHERE age <= 5
                                                ORDER BY id DESC;";
                            $result2 = $conn->query($sql2);

                            if ($result2->num_rows > 0) {
                                while ($row2 = $result2->fetch_assoc()) {
                                    $patientSerialNo = $row2['serial_no'];
                                    $firstName = $row2['first_name'];
                                    $lastName = $row2['last_name'];

                                    // Output an option element for each patient with the serial_no as the value
                                    echo "<option value='$patientSerialNo'>$firstName $lastName</option>";
                                }
                            } else {
                                echo "<option disabled>No patients found</option>";
                            }
                            ?>
                        </datalist>

                        <div class="row">
                            <div class="col">
                                <div class="row">
                                    <div class="col-sm">
                                        <div class="form-group">
                                            <label for="patient">Select Patient</label><span style="color: red; font-size: 22px;">*</span>
                                            <input list="patients" class="form-control" name="patient_id" id="patient_id" required>
                                            <datalist id="patients">
                                                <?php
                                                // Query to fetch patients from the database
                                                $sql2 = "SELECT serial_no, first_name, last_name, birthdate FROM patients ORDER BY id DESC";
                                                $result2 = $conn->query($sql2);

                                                if ($result2->num_rows > 0) {
                                                    while ($row2 = $result2->fetch_assoc()) {
                                                        $patientSerialNo = $row2['serial_no'];
                                                        $firstName = $row2['first_name'];
                                                        $lastName = $row2['last_name'];
                                                        $dateOfBirth = $row2['birthdate'];

                                                        // Calculate the age of the patient
                                                        $dateOfBirthDateTime = new DateTime($dateOfBirth);
                                                        $currentDateTime = new DateTime();
                                                        $ageInterval = $currentDateTime->diff($dateOfBirthDateTime);
                                                        $ageInYears = $ageInterval->y;
                                                        $ageInMonths = $ageInterval->m;

                                                        // Output an option element for each patient with the serial_no as the value
                                                        // Filter for patients aged 0-1 year
                                                        if ($ageInYears == 0) {
                                                            if ($ageInMonths <= 1) {
                                                                // Display age in days if less than or equal to 30 days
                                                                if ($ageInterval->days <= 30) {
                                                                    // Adjust the condition to handle 0 or 1 day without "s"
                                                                    $ageString = ($ageInterval->days == 1 || $ageInterval->days == 0) ? "day" : "days";
                                                                    echo "<option value='$patientSerialNo'>$firstName $lastName (Age: $ageInterval->days $ageString)</option>";
                                                                }


                                                                // Display age in weeks if less than or equal to 8 weeks
                                                                elseif ($ageInterval->days <= 60) {
                                                                    $ageInWeeks = ceil($ageInterval->days / 7);
                                                                    $ageString = ($ageInWeeks == 1) ? "week" : "weeks";
                                                                    echo "<option value='$patientSerialNo'>$firstName $lastName (Age: $ageInWeeks $ageString)</option>";
                                                                }
                                                                // Display age in months
                                                                else {
                                                                    echo "<option value='$patientSerialNo'>$firstName $lastName (Age: $ageInMonths months)</option>";
                                                                }
                                                            }
                                                            // Display age in months if less than 12 months
                                                            elseif ($ageInMonths < 12) {
                                                                echo "<option value='$patientSerialNo'>$firstName $lastName (Age: $ageInMonths months)</option>";
                                                            }
                                                        }
                                                    }
                                                } else {
                                                    echo "<option disabled>No patients found</option>";
                                                }
                                                ?>
                                            </datalist>
                                            <input type="hidden" name="serial_no2" id="serial_no2">
                                            <div id="serial_no2_error" class="error"></div>


                                        </div>
                                    </div>
                                    <style>
                                        .tago {
                                            display: none;
                                        }
                                    </style>
                                    <div class="col-4 tago">
                                        <div class="form-group">
                                            <label for="">Select Status</label>
                                            <select class="form-control" name="status" id="status" required>
                                                <option value="" disabled selected hidden>Select a Status</option>
                                                <!-- <option value="Complete">Complete</option> -->
                                                <option value="Pending">Pending</option>
                                                <option value="Progress">Progress</option>
                                            </select>
                                            <div id="editStatus_error" class="error"></div>
                                        </div>
                                    </div>
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
                                </div>

                                <script>
                                    // Add a JavaScript event listener to update the input field
                                    const patientInput = document.getElementById('patient_id');
                                    patientInput.addEventListener('input', function() {
                                        const selectedOption = document.querySelector('datalist#patients option[value="' + this.value + '"]');
                                        if (selectedOption) {
                                            this.value = selectedOption.innerText;
                                            patient_id = selectedOption.value;
                                            $('#serial_no2').val(patient_id);
                                        }
                                    });
                                </script>


                                <div class="form-group">
                                    <label for="">Select Nurse</label><span style="color: red; font-size: 22px;">*</span>
                                    <select class="form-control" name="nurse_id" id="nurse_id" required>
                                        <option value="" disabled selected hidden>Select Nurse</option>
                                        <?php

                                        // Query to fetch patients from the database
                                        $sql2 = "SELECT id, first_name, last_name FROM nurses ORDER BY id DESC";
                                        $result2 = $conn->query($sql2);

                                        if ($result2->num_rows > 0) {
                                            while ($row2 = $result2->fetch_assoc()) {
                                                $patientId = $row2['id'];
                                                $firstName = $row2['first_name'];
                                                $lastName = $row2['last_name'];

                                                // Output an option element for each patient
                                                echo "<option value='$patientId'>$firstName $lastName</option>";
                                            }
                                        } else {
                                            echo "<option disabled>No patients found</option>";
                                        }

                                        // Close the database connection

                                        ?>
                                    </select>
                                    <div id="nurse_id_error" class="error"></div>

                                </div>


                                <div class="form-group">
                                    <label for="vaccine">Select Vaccine</label>
                                    <select class="form-control" id="description" name="description" required>
                                        <option value="" disabled selected hidden>Select a Vaccine</option>
                                        <option value="BCG Vaccine">BCG Vaccine</option>
                                        <option value="Hepatitis B Vaccine">Hepatitis B Vaccine</option>
                                        <option value="Pentavalent Vaccine">Pentavalent Vaccine</option>
                                        <option value="Oral Polio Vaccine">Oral Polio Vaccine</option>
                                        <option value="Inactived Polio Vaccine">Inactived Polio Vaccine</option>
                                        <option value="Pneumococcal Conjugate Vaccine">Pneumococcal Conjugate Vaccine</option>
                                        <option value="Measles, Mumps, Rubella Vaccine">Measles, Mumps, Rubella Vaccine</option>
                                        <option value="Measles Containing Vaccine">Measles Containing Vaccine</option>
                                    </select>
                                    <div id="description_error" class="error"></div>
                                </div>
                                <div id="blank_dates"></div>

                                <div class="form-group">
                                    <label for="checkup_date">To Comeback</label><span style="color: red; font-size: 22px;">*</span>
                                    <input type="date" class="form-control" id="checkup_date" name="checkup_date" required>
                                    <div id="checkup_date_error" class="error"></div>
                                </div>

                                <script>
                                    document.getElementById('checkup_date').addEventListener('input', function(event) {
                                        const input = event.target;
                                        const date = new Date(input.value);
                                        const day = date.getUTCDay();

                                        // Day 0 is Sunday and Day 6 is Saturday
                                        if (day === 0 || day === 6) {
                                            // If the selected day is Saturday or Sunday, clear the input
                                            input.value = '';
                                        }
                                    });

                                    // Disabling weekends in the calendar picker
                                    const checkupDateInput = document.getElementById('checkup_date');
                                    checkupDateInput.addEventListener('click', function() {
                                        const dates = this.value;
                                        const date = new Date(dates);
                                        const day = date.getUTCDay();

                                        // Day 0 is Sunday and Day 6 is Saturday
                                        if (day === 0 || day === 6) {
                                            this.value = '';
                                        }
                                    });

                                    checkupDateInput.addEventListener('change', function() {
                                        const dates = this.value;
                                        const date = new Date(dates);
                                        const day = date.getUTCDay();

                                        // Day 0 is Sunday and Day 6 is Saturday
                                        if (day === 0 || day === 6) {
                                            this.value = '';
                                        }
                                    });
                                </script>
                                <!-- 
                                <script>
                                    // Get the current date
                                    var today = new Date();

                                    // Calculate the date for tomorrow
                                    today.setDate(today.getDate() + 1);

                                    // Format the date to match the input type="date" format (YYYY-MM-DD)
                                    var tomorrow = today.toISOString().split('T')[0];

                                    // Set the minimum date for the input element
                                    document.getElementById('checkup_date').setAttribute('min', tomorrow);
                                </script> -->



                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeModalButton">Close</button>
                    <button type="submit" class="btn btn-primary" id="addButton">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Add an event listener to the Save button
    document.getElementById('addButton').addEventListener('click', function() {
        // Assuming you have a variable `completedStep` that holds the completed step value, e.g., "Step1", "Step2", etc.
        var completedStep = "Immunization"; // Example completed step

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
    // Add an event listener to the Save button
    document.getElementById('addButton').addEventListener('click', function() {
        // Assuming you have a variable `completedStep` that holds the completed step value, e.g., "Step1", "Step2", etc.
        var completedStep = "Pending"; // Example completed step

        var selectStep = document.getElementById('status');

        for (var i = 0; i < selectStep.options.length; i++) {
            if (selectStep.options[i].value === completedStep) {
                selectStep.options[i].setAttribute('selected', 'selected');
                break;
            }
        }
    });
</script>
</div>
<div class="row">
    <div class="col-12">
        <div class="card-body table-responsive p-0" style="z-index: -99999">
            <table id="tablebod" class="table table-head-fixed text-nowrap table-striped">
                <thead class="thead-light">
                    <tr>
                        <th class="hidden">ID</th>
                        <th>Family Number</th>
                        <th>Patient Name</th>
                        <th>Vaccine</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Progress</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                    ?>
                            <tr>
                                <td class="align-middle hidden">
                                    <?php echo $row['id']; ?>
                                </td>
                                <td class="align-middle">
                                    <?php echo $row['serial_no']; ?>
                                </td>
                                <td class="align-middle">
                                    <?php echo $row['full_name']; ?>
                                </td>
                                <td class="align-middle">
                                    <?php echo $row['description']; ?>
                                </td>
                                <td class="align-middle">
                                    <?php echo $row['checkup_date']; ?>
                                </td>
                                <td class="align-middle">
                                    <?php echo $row['status']; ?>
                                </td>
                                <td class="align-middle">
                                    <?php echo $row['steps']; ?>
                                </td>
                                <td class="align-middle"> <button type="button" class="btn btn-success editbtn" data-row-id="<?php echo $row['id']; ?>">
                                        <i class="fas fa-edit"></i> Update
                                    </button>
                                    <button type="button" class="btn btn-danger deletebtn" data-id="' + row.id + '"><i class="fas fa-user-times"></i> Inactive</button>
                                </td>
                            </tr>
                        <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td class="align-middle"></td>
                            <td class="align-middle">No Immunization Found</td>
                            <td class="align-middle">
                            <td>
                            <td class="align-middle"></td>
                            <td class="align-middle"></td>
                            <td class="align-middle"></td>
                            <td class="align-middle"></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- modal edit -->

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Immunization</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <input type="hidden" id="editdataId" name="primary_id">
                    
                    <div class="form-group">
                        <label for="nurse_id2">Select Nurse</label>
                        <select class="form-control" name="nurse_id2" id="nurse_id2" required>
                            <option value="" disabled selected hidden>Select Nurse</option>
                            <?php
                            // Query to fetch nurses from the database
                            $sql2 = "SELECT id, first_name, last_name FROM nurses ORDER BY id DESC";
                            $result2 = $conn->query($sql2);

                            if ($result2->num_rows > 0) {
                                while ($row2 = $result2->fetch_assoc()) {
                                    $nurseId = $row2['id'];
                                    $firstName = $row2['first_name'];
                                    $lastName = $row2['last_name'];
                                    echo "<option value='$nurseId'>$firstName $lastName</option>";
                                }
                            } else {
                                echo "<option disabled>No nurses found</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="status2">Select Status</label>
                        <select class="form-control" name="status2" id="status2" required>
                            <option value="" disabled selected hidden>Select a Status</option>
                            <option value="Complete">Complete</option>
                            <option value="Pending">Pending</option>
                            <option value="Progress">Progress</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="step2">Select Step</label>
                        <select class="form-control" name="step2" id="step2" required>
                            <option value="" disabled selected hidden>Select a Step</option>
                            <option value="Interview Staff">Interview Staff</option>
                            <option value="Consultation">Consultation</option>
                            <option value="Immunization">Immunization</option>
                            <option value="Prenatal">Prenatal</option>
                            <option value="Family Planning">Family Planning</option>
                            <option value="Doctor">Doctor</option>
                            <option value="Already Nurse">Nurse</option>
                            <option value="Midwife">Midwife</option>
                            <option value="Head Nurse">Head Nurse</option>
                            <option value="Prescription">Prescription</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="description2">Select Vaccine</label>
                        <select class="form-control" id="description2" name="description2" required>
                            <option value="" disabled selected hidden>Select a Vaccine</option>
                            <!-- Options will be populated dynamically -->
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="checkup_date2">Checkup Date</label>
                        <input type="date" class="form-control" id="checkup_date2" name="checkup_date2" required>
                    </div>

                    <script>
                        // Set the minimum date for the checkup_date2 input
                        var today = new Date();
                        today.setDate(today.getDate() + 1);
                        var tomorrow = today.toISOString().split('T')[0];
                        document.getElementById('checkup_date2').min = tomorrow;
                    </script>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="updateButton">Update</button>
            </div>
        </div>
    </div>
</div>
<div id="result"></div>

<!-- modal edit -->
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    $(document).ready(function() {
        $('#tablebod').on('click', '.editbtn', function() {

            var patientId = $(this).data('row-id');
            console.log("Patient ID:", patientId);

            $.ajax({
                url: 'action/get_novacc.php',
                type: 'GET',
                data: {
                    patient_id: patientId
                },
                success: function(response) {
                    console.log("AJAX Success:", response);
                    var vaccines = JSON.parse(response);
                    var vaccineSelect = $('#description2');
                    vaccineSelect.empty(); 
                    if (vaccines.length > 0) {
                        vaccineSelect.append('<option value="" disabled selected hidden>Select a Vaccine</option>');
                        vaccines.forEach(function(vaccine) {
                            vaccineSelect.append('<option value="' + vaccine + '">' + vaccine + '</option>');
                        });
                    } else {
                        vaccineSelect.append('<option value="" disabled>No applicable vaccine</option>');
                    }
                    $('#editModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });
        });
    });
</script>



<script>
    $(document).ready(function() {

        document.getElementById('openModalButton').addEventListener('click', function() {
            $('#addModal').modal('show'); // Show the modal
        });

        <?php if ($result->num_rows > 0) : ?>
            var table = $('#tablebod').DataTable({
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
                    {
                        targets: 3,
                        data: 'description'
                    },
                    {
                        targets: 4,
                        data: 'checkup_date'
                    },
                    {
                        targets: 5,
                        data: 'status'
                    },
                    {
                        targets: 6,
                        data: 'steps'
                    },
                    {
                        targets: 7,
                        searchable: false,
                        data: null,
                        render: function(data, type, row) {
                            var editButton = '<button type="button" class="btn btn-success editbtn" data-row-id="' + row.id + '"><i class="fas fa-edit"></i> Update</button>';
                            var deleteButton = '<button type="button" class="btn btn-danger deletebtn" data-id="' + row.id + '"><i class="fas fa-user-times"></i> Inactive</button>';
                            return editButton + ' ' + deleteButton;
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
            var table = $('#tablebod').DataTable({
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
                    {
                        targets: 3,
                        data: 'description'
                    },
                    {
                        targets: 4,
                        data: 'checkup_date'
                    },
                    {
                        targets: 5,
                        data: 'status'
                    },
                    {
                        targets: 6,
                        data: 'steps'
                    },
                ],
                // Set the default ordering to 'id' column in descending order
                order: [
                    [0, 'desc']
                ]
            });
        <?php endif; ?>

        $('#addButton').click(function() {
            // Clear previous error messages
            $('.error').text('');

            // Get data from the form
            var patient_id = $('#serial_no2').val();
            var nurse_id = $('#nurse_id').val();
            var status = $('#status').val();
            var steps = $('#step').val();
            var description = $('#description').val();
            var checkup_date = $('#checkup_date').val();

            // Validate form fields
            var isValid = true;

            if (!patient_id) {
                $('#serial_no2_error').text("Please select a patient.");
                isValid = false;
            }
            if (!nurse_id) {
                $('#nurse_id_error').text("Please select a nurse.");
                isValid = false;
            }
            if (!status) {
                $('#editStatus_error').text("Please select a status.");
                isValid = false;
            }
            if (!steps) {
                $('#steps_error').text("Please enter the steps.");
                isValid = false;
            }
            if (!description) {
                $('#description_error').text("Please select a vaccine.");
                isValid = false;
            }
            if (!checkup_date) {
                $('#checkup_date_error').text("Please select a checkup date.");
                isValid = false;
            }

            // Proceed with table update if validation passes
            if (isValid) {
                table.destroy(); // Destroy the existing DataTable
                table = $('#tablebod').DataTable({
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
                        {
                            targets: 3,
                            data: 'description'
                        },
                        {
                            targets: 4,
                            data: 'checkup_date'
                        },
                        {
                            targets: 5,
                            data: 'status'
                        },
                        {
                            targets: 6,
                            data: 'steps'
                        },
                        {
                            targets: 7,
                            searchable: false,
                            data: null,
                            render: function(data, type, row) {
                                var editButton = '<button type="button" class="btn btn-success editbtn" data-row-id="' + row.id + '"><i class="fas fa-edit"></i> Update</button>';
                                var deleteButton = '<button type="button" class="btn btn-danger deletebtn" data-id="' + row.id + '"><i class="fas fa-user-times"></i> Inactive</button>';
                                return editButton + ' ' + deleteButton;
                            }
                        } // Action column
                    ],
                    // Set the default ordering to 'id' column in descending order
                    order: [
                        [0, 'desc']
                    ]
                });
            }




            // Get data from the form

            var patient_id = $('#serial_no2').val();
            var nurse_id = $('#nurse_id').val();
            var status = $('#status').val();
            var steps = $('#step').val();
            var description = $('#description').val();
            var checkup_date = $('#checkup_date').val();

            // AJAX request to send data to the server
            $.ajax({
                url: 'action/add_family.php',
                method: 'POST',
                data: {
                    patient_id: patient_id,
                    nurse_id: nurse_id,
                    status: status,
                    steps: steps,
                    description: description,
                    checkup_date: checkup_date,

                },
                success: function(response) {
                    if (response.trim() === 'Success') {
                        // Clear the form fields
                        $('#patient_id').val('');
                        $('#nurse_id').val('');
                        $('#status').val('');
                        $('#step').val('');
                        $('#description').val('');
                        $('#checkup_date').val('');



                        updateData();
                        $('#addModal').modal('hide');

                        // Remove the modal backdrop manually
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        // Show a success SweetAlert
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Immunization schedule successfully',
                        });

                    } else {
                        // Show an error SweetAlert
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error adding data: ' + response,
                        });
                    }
                },
                error: function(error) {
                    // Handle errors
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error adding data: ' + error,
                    });
                },

            });
        });


        function updateData() {
            $.ajax({
                url: 'action/get_family.php',
                method: 'GET',
                success: function(data) {
                    // Assuming the server returns JSON data, parse it
                    var get_data = JSON.parse(data);

                    // Clear the DataTable and redraw with new data
                    table.clear().rows.add(get_data).draw();
                },
                error: function(error) {
                    // Handle errors
                    console.error('Error retrieving data: ' + error);
                }
            });
        }

        // Delete button click event
        $('#tablebod').on('click', '.deletebtn', function() {
            var deletedataId = $(this).data('id');

            // Confirm the deletion with a SweetAlert dialog
            Swal.fire({
                title: 'Confirm Inactive',
                text: 'Are you sure you want to inactive this data?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, inactive it'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'action/delete_family.php',
                        method: 'POST',
                        data: {
                            primary_id: deletedataId
                        },
                        success: function(response) {
                            if (response === 'Success') {

                                updateData();
                                Swal.fire('Inactive', 'The Immunization Patient has been inactive.', 'success');
                            } else {
                                Swal.fire('Error', 'Error deleting data: ' + response, 'error');
                            }
                        },
                        error: function(error) {
                            Swal.fire('Error', 'Error deleting data: ' + error, 'error');
                        }
                    });
                }
            });
        });




        // Edit button click event
        $('#tablebod').on('click', '.editbtn', function() {
            var editId = $(this).data('row-id');
            //console.log(editId);
            $.ajax({
                url: 'action/get_family_by_id.php', // 
                method: 'POST',
                data: {
                    primary_id: editId
                },
                success: function(data) {

                    var editGetData = data;
                    //console.log(editGetData);
                    $('#editModal #editdataId').val(editGetData.id);
                    $('#editModal #nurse_id2').val(editGetData.nurse_id);
                    $('#editModal #status2').val(editGetData.status);
                    $('#editModal #step2').val(editGetData.steps);
                    $('#editModal #description2').val(editGetData.description);
                    $('#editModal #checkup_date2').val(editGetData.checkup_date);
                    $('#editModal').modal('show');
                },
                error: function(error) {
                    console.error('Error fetching  data: ' + error);
                },
            });
        });

        $('#updateButton').click(function() {
            var editId = $('#editdataId').val();
            var nurse_id = $('#nurse_id2').val();
            var status = $('#status2').val();
            var steps = $('#step2').val();
            var description = $('#description2').val();
            var checkup_date = $('#checkup_date2').val();

            $.ajax({
                url: 'action/update_family.php',
                method: 'POST',
                data: {
                    primary_id: editId,
                    nurse_id: nurse_id,
                    status: status,
                    steps: steps,
                    description: description,
                    checkup_date: checkup_date,
                },
                success: function(response) {
                    if (response.trim() === 'Success') {
                        if (response === 'Success') {

                            updateData();
                            Swal.fire('Updated', 'The Immunization has been updated.', 'success');
                        } else {
                            Swal.fire('Error', 'Error deleting data: ' + response, 'error');
                        }
                        $('#editModal').modal('hide');
                        // You may also want to refresh or update the data on your page.
                    } else {
                        // Handle error response if needed.
                        console.error('Error updating data: ' + response);
                    }
                },
                error: function(error) {
                    console.error('Error updating data: ' + error);
                },
            });
        });





    });
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