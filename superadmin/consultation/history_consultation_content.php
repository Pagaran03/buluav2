<?php
// Include your database configuration file
include_once ('../../config.php');

$user_id = $_GET['id'];


$sql = "SELECT *,consultations.id as id,CONCAT(patients.first_name, ' ', patients.last_name) AS full_name
FROM consultations
JOIN patients ON consultations.patient_id = patients.id
JOIN superadmins ON superadmins.id = consultations.doctor_id
WHERE consultations.id = $user_id AND consultations.is_active = 0 AND consultations.is_deleted = 0 AND consultations.is_print = 0";


$result = $conn->query($sql);

if ($result === false) {
    die("Query failed: " . $conn->error);
}

?>

<div class="container-fluid">
    <button type="button" class="btn btn-primary" onclick="goBack()">
        <i class="fa fa-arrow-circle-left"></i> Back
    </button>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>

    <br><br>


    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Consultation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addForm">
                        <!-- Form fields go here -->
                        <div class="form-group">
                            <label for="patient">Select Patient</label>
                            <input list="patients" class="form-control" name="patient_id" id="patient_id" required>
                            <datalist id="patients">
                                <?php
                                // Query to fetch patients from the database
                                $sql2 = "SELECT serial_no, first_name, last_name FROM patients ORDER BY id DESC";
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
                            <input type="hidden" name="serial_no2" id="serial_no2">


                        </div>

                        <script>
                            // Add a JavaScript event listener to update the input field
                            const patientInput = document.getElementById('patient_id');
                            patientInput.addEventListener('input', function () {
                                const selectedOption = document.querySelector('datalist#patients option[value="' + this.value + '"]');
                                if (selectedOption) {
                                    this.value = selectedOption.innerText; // Update the input text
                                    patient_id = selectedOption.value; // Set patient_id to the value of the selected option (serial_no)
                                    $('#serial_no2').val(patient_id);
                                }
                            });
                        </script>


                        <div class="form-group">
                            <label for="">Select Doctor</label>
                            <select class="form-control" name="doctor_id" id="doctor_id" required>
                                <option value="" disabled selected hidden>Select Doctor</option>
                                <?php

                                // Query to fetch patients from the database
                                $sql2 = "SELECT id, first_name, last_name FROM superadmins ORDER BY id DESC";
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
                                    echo "<option disabled>No Doctor Found</option>";
                                }

                                // Close the database connection
                                
                                ?>
                            </select>

                        </div>
                        <div class="form-group">
                            <label for="">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"
                                required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Checkup Date</label>
                            <input type="date" class="form-control" id="checkup_date" name="checkup_date" required>
                        </div>

                        <script>
                            // Get the current date
                            var today = new Date();

                            // Calculate the date for tomorrow
                            today.setDate(today.getDate() + 1);

                            // Format the date to match the input type="date" format (YYYY-MM-DD)
                            var tomorrow = today.toISOString().split('T')[0];

                            // Set the minimum date for the input element
                            document.getElementById('checkup_date').min = tomorrow;
                        </script>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        id="closeModalButton">Close</button>
                    <button type="submit" class="btn btn-primary" id="addButton">Save</button>
                </div>
            </div>
        </div>
    </div>
    <style>
        .tago {
            display: none;
        }
    </style>
    <div class="row">
        <div class="col-12">
            <div class="card-body table-responsive p-0" style="z-index: -99999">
                <table id="tablebod" class="table table-head-fixed text-nowrap table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th class="tago">ID</th>
                            <th>Doctor Name</th>
                            <th>Description</th>
                            <th>Diagnosis</th>
                            <th>Medicine</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td class="align-middle tago">
                                        <?php echo $row['id']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo $row['last_name']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo $row['subjective']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo $row['diagnosis']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo $row['medicine']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <button type="button" class="btn btn-info editbtn2"
                                            data-row-id="<?php echo $row['serial_no']; ?>">
                                            <i class="fas fa-eye"></i> View Assestment Record
                                        </button>
                                    </td>

                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td class="align-middle"></td>
                                <td class="align-middle">No Consultation Found</td>
                                <td class="align-middle">
                                <td>
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

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Consultation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm">

                        <input type="hidden" id="editdataId" name="primary_id">
                        <!-- Form fields go here -->

                        <div class="form-group">
                            <label for="">Select Doctor</label>
                            <select class="form-control" name="doctor_id" id="editDoctor" required>
                                <option value="" disabled selected hidden>Select Doctor</option>
                                <?php

                                // Query to fetch patients from the database
                                $sql2 = "SELECT id, first_name, last_name FROM superadmins ORDER BY id DESC";
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
                                    echo "<option disabled>No Doctor Found</option>";
                                }

                                // Close the database connection
                                
                                ?>
                            </select>

                        </div>
                        <div class="form-group">
                            <label for="">Description</label>
                            <textarea class="form-control" id="editDescription" name="description" rows="3"
                                required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Checkup Date</label>
                            <input type="date" class="form-control" id="editCheckup" name="checkup_date" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateButton">Update</button>
                </div>
            </div>
        </div>
    </div>

    <!-- modal edit -->
    <div class="modal fade" id="editModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">View Consultation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm">

                        <input type="hidden" id="editdataId" name="primary_id">
                        <!-- Form fields go here -->
                        <div class="row">


                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="">Select Doctor</label>
                                    <select class="form-control" name="doctor_id2" id="doctor_id2" required>
                                        <option value="" disabled selected hidden>Select Doctor</option>
                                        <?php

                                        // Query to fetch patients from the database
                                        $sql2 = "SELECT id, first_name, last_name FROM superadmins ORDER BY id DESC";
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
                                            echo "<option disabled>No Doctor Found</option>";
                                        }

                                        // Close the database connection
                                        
                                        ?>
                                    </select>

                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="">Checkup Date</label>
                                    <input type="date" class="form-control" id="checkup_date2" name="checkup_date2"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">

                                <div class="form-group">
                                    <label for="">Subjective</label>
                                    <textarea class="form-control" id="subjective2" name="subjective2" rows="3"
                                        required></textarea>
                                </div>
                            </div>
                            <div class="col-sm">

                                <div class="form-group">
                                    <label for="">Objective</label>
                                    <textarea class="form-control" id="objective2" name="objective2" rows="3"
                                        required></textarea>
                                </div>
                            </div>
                            <div class="col-sm">

                                <div class="form-group">
                                    <label for="">Assesment</label>
                                    <textarea class="form-control" id="assesment2" name="assesment2" rows="3"
                                        required></textarea>
                                </div>
                            </div>
                            <div class="col-sm">

                                <div class="form-group">
                                    <label for="">Plan</label>
                                    <textarea class="form-control" id="plan2" name="plan2" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">

                                <hr>
                                <h5>PHYSICAL EXAMINATION</h5>
                                <hr>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Weight</label>
                                            <input type="nutextmber" class="form-control" id="weight2" name="weight2"
                                                required>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Blood Pressure</label>
                                            <input type="text" class="form-control" id="bp2" name="bp2" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Height</label>
                                            <input type="text" class="form-control" id="height2" name="height2"
                                                required>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Pulse Rate</label>
                                            <input type="text" class="form-control" id="pulse2" name="pulse2" required>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Skin</label>
                                            <br>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="normalSkinRadio2" name="skin2" value="Normal"
                                                    class="radio-input" required>
                                                <label for="normalSkinRadio" class="radio-label"
                                                    style="margin-left: 5px;">Normal</label>
                                            </div>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="paleSkinRadio2" name="skin2" value="Pale"
                                                    class="radio-input" required>
                                                <label for="paleSkinRadio" class="radio-label"
                                                    style="margin-left: 5px;">Pale</label>
                                            </div>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="yellowishSkinRadio2" name="skin2"
                                                    value="Yellowish" class="radio-input" required>
                                                <label for="yellowishSkinRadio" class="radio-label"
                                                    style="margin-left: 5px;">Yellowish</label>
                                            </div>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="hematomaSkinRadio2" name="skin2"
                                                    value="Hematoma" class="radio-input" required>
                                                <label for="hematomaSkinRadio" class="radio-label"
                                                    style="margin-left: 5px;">Hematoma</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Extremities</label>
                                            <br>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="normalRadio2" name="extremities2" value="Normal"
                                                    class="radio-input" required>
                                                <label for="normalRadio" class="radio-label"
                                                    style="margin-left: 5px;">Normal</label>
                                            </div>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="edemaRadio2" name="extremities2" value="Edema"
                                                    class="radio-input" required>
                                                <label for="edemaRadio" class="radio-label"
                                                    style="margin-left: 5px;">Edema</label>
                                            </div>

                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="varicositiesRadio2" name="extremities2"
                                                    value="Varicosities" class="radio-input" required>
                                                <label for="varicositiesRadio" class="radio-label"
                                                    style="margin-left: 5px;">Varicosities</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Conjunctiva</label>
                                            <br>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="normalConjunctivaRadio2" name="conjunctiva2"
                                                    value="Normal" class="radio-input" required>
                                                <label for="normalConjunctivaRadio" class="radio-label"
                                                    style="margin-left: 5px;">Normal</label>
                                            </div>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="paleConjunctivaRadio2" name="conjunctiva2"
                                                    value="Pale" class="radio-input" required>
                                                <label for="paleConjunctivaRadio" class="radio-label"
                                                    style="margin-left: 5px;">Pale</label>
                                            </div>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="yellowishConjunctivaRadio2" name="conjunctiva2"
                                                    value="Yellowish" class="radio-input" required>
                                                <label for="yellowishConjunctivaRadio" class="radio-label"
                                                    style="margin-left: 5px;">Yellowish</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Neck</label>
                                            <br>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="normalNeckRadio2" name="neck2" value="Normal"
                                                    class="radio-input" required>
                                                <label for="normalNeckRadio" class="radio-label"
                                                    style="margin-left: 5px;">Normal</label>
                                            </div>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="enlargeLymphNodesRadio2" name="neck2"
                                                    value="Enlarge Lymph Nodes" class="radio-input" required>
                                                <label for="enlargeLymphNodesRadio" class="radio-label"
                                                    style="margin-left: 5px;">Enlarge Lymph Nodes</label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <hr>
                        <h5>FAMILY HISTORY</h5>
                        <hr>
                        <div class="row">
                            <div class="col-sm">
                                <div class="row">
                                    <div class="col">
                                        <label for="medical_conditions">Does the client have any of the
                                            following?</label>
                                        <br>
                                        <div class="form-group">

                                            <div class="checkbox-list">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="severe_headaches2"
                                                        name="medical_condition" value="severe_headaches">
                                                    <label class="checkbox-label">severe headaches/migraine</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox"
                                                        id="history_stroke_heart_attack_hypertension2"
                                                        name="medical_condition"
                                                        value="history_stroke_heart_attack_hypertension">
                                                    <label class="checkbox-label">history of stroke / heart attack /
                                                        hypertension</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="hematoma_bruising_gum_bleeding2"
                                                        name="medical_condition" value="hematoma_bruising_gum_bleeding">
                                                    <label class="checkbox-label">non-traumatic hematoma / frequent
                                                        bruising or gum bleeding</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="breast_cancer_breast_mass2"
                                                        name="medical_condition" value="breast_cancer_breast_mass">
                                                    <label class="checkbox-label">current or history of breast
                                                        cancer/breast mass</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="severe_chest_pain2"
                                                        name="medical_condition" value="severe_chest_pain">
                                                    <label class="checkbox-label">severe chest pain</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="cough_more_than_14_days2"
                                                        name="medical_condition" value="cough_more_than_14_days">
                                                    <label class="checkbox-label">cough for more than 14 days</label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <div class="checkbox-list">
                                                <br>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="jaundice2" name="medical_condition"
                                                        value="jaundice">
                                                    <label class="checkbox-label">jaundice</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="vaginal_bleeding2"
                                                        name="medical_condition" value="vaginal_bleeding">
                                                    <label class="checkbox-label">unexplained vaginal bleeding</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="vaginal_discharge2"
                                                        name="medical_condition" value="vaginal_discharge">
                                                    <label class="checkbox-label">abnormal vaginal discharge</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="phenobarbital_rifampicin2"
                                                        name="medical_condition" value="phenobarbital_rifampicin">
                                                    <label class="checkbox-label">intake of phenobarbital (anti-seizure)
                                                        or rifampicin (anti-TB)</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="smoker2" name="medical_condition"
                                                        value="smoker">
                                                    <label class="checkbox-label">Is the client a SMOKER?</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="with_disability2"
                                                        name="medical_condition" value="with_disability">
                                                    <label class="checkbox-label">With Disability?</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <script>
                            // Get the current date
                            var today = new Date();

                            // Calculate the date for tomorrow
                            today.setDate(today.getDate() + 1);

                            // Format the date to match the input type="date" format (YYYY-MM-DD)
                            var tomorrow = today.toISOString().split('T')[0];

                            // Set the minimum date for the input element
                            document.getElementById('checkup_date').min = tomorrow;
                        </script>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    $(document).ready(function () {




        <?php if ($result->num_rows > 0): ?>
            var table = $('#tablebod').DataTable({
                columnDefs: [
                    { targets: 0, data: 'id', visible: false },
                    { targets: 1, data: 'last_name' },
                    { targets: 2, data: 'description' },
                    { targets: 3, data: 'diagnosis' },
                    { targets: 4, data: 'medicine' },
                    {
                        targets: 5,
                        searchable: false,
                        data: null,
                        render: function (data, type, row) {
                            var editButton2 = '<button type="button" class="btn btn-info editbtn2" data-row-id="' + row.id + '"><i class="fas fa-eye"></i>  View Consultation Assesment</button>';
                            return editButton2;
                        }
                    } // Action column
                ],
                // Set the default ordering to 'id' column in descending order
                order: [[0, 'desc']]
            });
        <?php else: ?>
            // Initialize DataTable without the "Action" column when no rows are found
            var table = $('#tablebod').DataTable({
                columnDefs: [
                    { targets: 0, data: 'id', visible: false },
                    { targets: 1, data: 'last_name' },
                    { targets: 2, data: 'description' },
                    { targets: 3, data: 'diagnosis' },
                    { targets: 4, data: 'medicine' },
                ],
                // Set the default ordering to 'id' column in descending order
                order: [[0, 'desc']]
            });
        <?php endif; ?>

        $('#addButton').click(function () {

            console.log(patient_id);
            table.destroy(); // Destroy the existing DataTable
            table = $('#tablebod').DataTable({
                columnDefs: [
                    { targets: 0, data: 'id', visible: false },
                    { targets: 1, data: 'last_name' },
                    { targets: 2, data: 'description' },
                    { targets: 3, data: 'diagnosis' },
                    { targets: 4, data: 'medicine' },
                    {
                        targets: 5,
                        searchable: false,
                        data: null,
                        render: function (data, type, row) {
                            var editButton2 = '<button type="button" class="btn btn-info editbtn2" data-row-id="' + row.id + '"><i class="fas fa-eye"></i>  View Consultation Assesment</button>';
                            return editButton2;
                        }
                    } // Action column
                ],
                // Set the default ordering to 'id' column in descending order
                order: [[0, 'desc']]
            });

            // Get data from the form

            var patient_id = $('#serial_no2').val();
            var description = $('#description').val();
            var checkup_date = $('#checkup_date').val();
            var doctor_id = $('#doctor_id').val();

            console.log(patient_id);

            // AJAX request to send data to the server
            $.ajax({
                url: 'action/add_consultation.php',
                method: 'POST',
                data: {
                    patient_id: patient_id,
                    description: description,
                    doctor_id: doctor_id,
                    checkup_date: checkup_date,
                },
                success: function (response) {

                    if (response.trim() === 'Success') {


                        // Clear the form fields
                        $('#patient_id').val('');
                        $('#description').val('');
                        $('#doctor_id').val('');
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
                            text: 'Consultation added successfully',
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
                error: function (error) {
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
                url: 'action/get_active.php',
                method: 'GET',
                success: function (data) {
                    // Assuming the server returns JSON data, parse it
                    var get_data = JSON.parse(data);

                    // Clear the DataTable and redraw with new data
                    table.clear().rows.add(get_data).draw();
                },
                error: function (error) {
                    // Handle errors
                    console.error('Error retrieving data: ' + error);
                }
            });
        }

        // Delete button click event
        $('#tablebod').on('click', '.deletebtn', function () {
            var deletedataId = $(this).data('id');

            // Confirm the deletion with a SweetAlert dialog
            Swal.fire({
                title: 'Confirm Activation',
                text: 'Are you sure you want to active this data?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, set it as active'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'action/active.php',
                        method: 'POST',
                        data: { primary_id: deletedataId },
                        success: function (response) {
                            if (response === 'Success') {

                                updateData();
                                Swal.fire('Activated', 'The Consultation has been activated.', 'success');
                            } else {
                                Swal.fire('Error', 'Error deleting data: ' + response, 'error');
                            }
                        },
                        error: function (error) {
                            Swal.fire('Error', 'Error deleting data: ' + error, 'error');
                        }
                    });
                }
            });
        });



        // Edit button click event
        $('#tablebod').on('click', '.editbtn', function () {
            var editId = $(this).data('row-id');
            console.log(editId);
            $.ajax({
                url: 'action/get_consultation_by_id.php', // 
                method: 'POST',
                data: { primary_id: editId },
                success: function (data) {

                    var editGetData = data;


                    $('#editModal #editdataId').val(editGetData.id);
                    $('#editModal #editDescription').val(editGetData.description);
                    $('#editModal #editCheckup').val(editGetData.checkup_date);
                    $('#editModal #editDoctor').val(editGetData.doctor_id);

                    $('#editModal').modal('show');
                },
                error: function (error) {
                    console.error('Error fetching  data: ' + error);
                },
            });
        });

        $('#updateButton').click(function () {


            var editId = $('#editdataId').val();
            var description = $('#editDescription').val();
            var doctor_id = $('#editDoctor').val();
            var checkup_date = $('#editCheckup').val();

            $.ajax({
                url: 'action/update_consultation.php',
                method: 'POST',
                data: {
                    primary_id: editId,
                    description: description,
                    doctor_id: doctor_id,
                    checkup_date: checkup_date,
                },
                success: function (response) {
                    // Handle the response
                    if (response === 'Success') {
                        updateData();
                        $('#editModal').modal('hide');
                        // Remove the modal backdrop manually
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        // Show a success Swal notification
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Consultation updated successfully',
                        });
                    } else {
                        // Show an error Swal notification
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error updating data: ' + response,
                        });
                    }
                },
                error: function (error) {
                    // Show an error Swal notification for AJAX errors
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error updating data: ' + error,
                    });
                }
            });
        });



        $('#tablebod').on('click', '.editbtn2', function () {
            var editId = $(this).data('row-id');
            console.log(editId);
            $.ajax({
                url: 'action/get_consultation_by_id2.php', // 
                method: 'POST',
                data: { primary_id: editId },
                success: function (data) {

                    var editGetData = data;

                    console.log(editGetData);
                    $('#editModal2 #editdataId').val(editGetData.id);
                    $('#editModal2 #doctor_id2').val(editGetData.doctor_id);
                    $('#editModal2 #checkup_date2').val(editGetData.checkup_date);
                    $('#editModal2 #subjective2').val(editGetData.subjective);
                    $('#editModal2 #objective2').val(editGetData.objective);
                    $('#editModal2 #assessment2').val(editGetData.assessment);
                    $('#editModal2 #plan2').val(editGetData.plan);
                    $('#editModal2 #weight2').val(editGetData.weight);
                    $('#editModal2 #bp2').val(editGetData.bp);

                    $('#editModal2 #height2').val(editGetData.height);
                    $('#editModal2 #pulse2').val(editGetData.pulse);


                    if (editGetData.skin === "Normal") {
                        $('#normalSkinRadio2').prop('checked', true);
                    } else if (editGetData.skin === "Pale") {
                        $('#paleSkinRadio2').prop('checked', true);
                    } else if (editGetData.skin === "Yellowish") {
                        $('#yellowishSkinRadio2').prop('checked', true);
                    } else if (editGetData.skin === "Hematoma") {
                        $('#hematomaSkinRadio2').prop('checked', true);
                    }

                    if (editGetData.extremities === "Normal") {
                        $('#normalRadio2').prop('checked', true);
                    } else if (editGetData.extremities === "Edema") {
                        $('#edemaRadio2').prop('checked', true);
                    } else if (editGetData.extremities === "Varicosities") {
                        $('#varicositiesRadio2').prop('checked', true);
                    }

                    if (editGetData.conjunctiva === "Normal") {
                        $('#normalConjunctivaRadio2').prop('checked', true);
                    } else if (editGetData.conjunctiva === "Pale") {
                        $('#paleConjunctivaRadio2').prop('checked', true);
                    } else if (editGetData.conjunctiva === "Yellowish") {
                        $('#yellowishConjunctivaRadio2').prop('checked', true);
                    }

                    if (editGetData.neck === "Normal") {
                        $('#normalNeckRadio2').prop('checked', true);
                    } else if (editGetData.neck === "Enlarge Lymph Nodes") {
                        $('#enlargeLymphNodesRadio2').prop('checked', true);
                    }

                    if (editGetData.severe_headaches === 'Yes') {
                        $('#severe_headaches2').prop('checked', true);
                    } else {
                        $('#severe_headaches2').prop('checked', false);
                    }

                    if (editGetData.history_stroke_heart_attack_hypertension === 'Yes') {
                        $('#history_stroke_heart_attack_hypertension2').prop('checked', true);
                    } else {
                        $('#history_stroke_heart_attack_hypertension2').prop('checked', false);
                    }

                    if (editGetData.hematoma_bruising_gum_bleeding === 'Yes') {
                        $('#hematoma_bruising_gum_bleeding2').prop('checked', true);
                    } else {
                        $('#hematoma_bruising_gum_bleeding2').prop('checked', false);
                    }

                    if (editGetData.breast_cancer_breast_mass === 'Yes') {
                        $('#breast_cancer_breast_mass2').prop('checked', true);
                    } else {
                        $('#breast_cancer_breast_mass2').prop('checked', false);
                    }

                    if (editGetData.severe_chest_pain === 'Yes') {
                        $('#severe_chest_pain2').prop('checked', true);
                    } else {
                        $('#severe_chest_pain2').prop('checked', false);
                    }

                    if (editGetData.cough_more_than_14_days === 'Yes') {
                        $('#cough_more_than_14_days2').prop('checked', true);
                    } else {
                        $('#cough_more_than_14_days2').prop('checked', false);
                    }

                    if (editGetData.jaundice === 'Yes') {
                        $('#jaundice2').prop('checked', true);
                    } else {
                        $('#jaundice2').prop('checked', false);
                    }

                    if (editGetData.vaginal_bleeding === 'Yes') {
                        $('#vaginal_bleeding2').prop('checked', true);
                    } else {
                        $('#vaginal_bleeding2').prop('checked', false);
                    }

                    if (editGetData.vaginal_discharge === 'Yes') {
                        $('#vaginal_discharge2').prop('checked', true);
                    } else {
                        $('#vaginal_discharge2').prop('checked', false);
                    }

                    if (editGetData.phenobarbital_rifampicin === 'Yes') {
                        $('#phenobarbital_rifampicin2').prop('checked', true);
                    } else {
                        $('#phenobarbital_rifampicin2').prop('checked', false);
                    }

                    if (editGetData.smoker === 'Yes') {
                        $('#smoker2').prop('checked', true);
                    } else {
                        $('#smoker2').prop('checked', false);
                    }

                    if (editGetData.with_disability === 'Yes') {
                        $('#with_disability2').prop('checked', true);
                    } else {
                        $('#with_disability2').prop('checked', false);
                    }


                    $('#editModal2').modal('show');
                },
                error: function (error) {
                    console.error('Error fetching  data: ' + error);
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