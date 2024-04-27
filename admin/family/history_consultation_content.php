<?php
include_once ('../../config.php');

if (isset($_GET['id']) && isset($_GET['patient_id'])) {
    $user_id = $_GET['id'];

    $sql = "SELECT *, fp_information.id AS id, patients.first_name AS first_name, patients.last_name AS last_name, nurses.first_name AS first_name2, nurses.last_name AS last_name2
    FROM fp_information
    JOIN patients ON fp_information.patient_id = patients.id
    JOIN nurses ON fp_information.nurse_id = nurses.id
    JOIN fp_consultation ON fp_consultation.fp_information_id = fp_information.id
    WHERE fp_information.id = $user_id AND fp_consultation.medicine != ''";
} elseif (isset($_GET['patient_id'])) {
    $patient_id = $_GET['patient_id'];
    $sql = "SELECT *, fp_information.id AS id, patients.first_name AS first_name, patients.last_name AS last_name, nurses.first_name AS first_name2, nurses.last_name AS last_name2
    FROM fp_information
    JOIN patients ON fp_information.patient_id = patients.id
    JOIN nurses ON fp_information.nurse_id = nurses.id
    JOIN fp_consultation ON fp_consultation.fp_information_id = fp_information.id
    WHERE fp_information.patient_id = $patient_id";
} else {
    die("No parameter provided.");
}

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

    <div class="row">
        <div class="col-12">
            <div class="card-body table-responsive p-0" style="z-index: -99999">
                <table id="tablebod" class="table table-head-fixed text-nowrap table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Nurse Name</th>
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
                                    <td class="align-middle"><?php echo $row['id']; ?></td>
                                    <td class="align-middle"> <?php echo $row['last_name2']; ?></td>
                                    <td class="align-middle"><?php echo $row['description']; ?></td>
                                    <td class="align-middle"><?php echo $row['diagnosis']; ?></td>
                                    <td class="align-middle"><?php echo $row['medicine']; ?></td>
                                    <td><button class="btn btn-primary" onclick="recordsBtn(<?php echo $row['id']; ?>)"><i
                                                class="fas fa-eye"></i> View Details</button></td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td class="align-middle">No Consultation Found</td>
                                <td class="align-middle"></td>
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

    <div class="modal fade" id="editModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Family Planning</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="editdataId" name="primary_id">

                        <h5>I PERSONAL INFORMATION</h5>
                        <hr>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="">Select Nurse</label>
                                    <select class="form-control" name="nurse_id2" id="nurse_id2" required disabled>
                                        <option value="" disabled selected hidden>Select A Nurse</option>
                                        <?php
                                        $sql2 = "SELECT id, first_name, last_name FROM nurses
                                WHERE is_active = 0 ORDER BY id DESC";
                                        $result2 = $conn->query($sql2);

                                        if ($result2->num_rows > 0) {
                                            while ($row2 = $result2->fetch_assoc()) {
                                                $patientId = $row2['id'];
                                                $firstName = $row2['first_name'];
                                                $lastName = $row2['last_name'];
                                                echo "<option value='$patientId'>$firstName $lastName</option>";
                                            }
                                        } else {
                                            echo "<option disabled>No patients found</option>";
                                        }
                                        ?>
                                    </select>

                                </div>


                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="">Status</label>
                                    <select class="form-control" name="status" id="editstatus" required disabled>
                                        <option value="" disabled selected hidden>Select a Status</option>
                                        <option value="Complete">Complete</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Progress">Progress</option>
                                    </select>
                                    <!-- <div id="editStatus_error" class="error"></div> -->
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="">No. of Living Children</label>
                                    <input type="text" class="form-control" id="no_of_children2" name="no_of_children"
                                        disabled>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="">Average Monthly Income</label>
                                    <input type="number" class="form-control" id="income2" name="income" disabled>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="plan_to_have_more_children">Plan to Have More Children?</label>
                                    <br>
                                    <div style="display: inline-block;" class="mt-1">
                                        <input type="radio" id="plan_to_have_more_children_yes"
                                            name="plan_to_have_more_children2" value="Yes" class="radio-input" disabled>
                                        <label for="plan_to_have_more_children_yes" class="radio-label"
                                            style="margin-left: 5px;">Yes</label>
                                    </div>
                                    <div style="display: inline-block;">
                                        <input type="radio" id="plan_to_have_more_children_no"
                                            name="plan_to_have_more_children2" value="No" class="radio-input" disabled>
                                        <label for="plan_to_have_more_children_no" class="radio-label">No</label>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Type of Client</label>
                                    <br>
                                    <div style="display: inline-block;" class="mt-1">
                                        <input type="radio" id="client_type_new" name="client_type2"
                                            value="New Acceptor" class="radio-input" disabled>
                                        <label for="client_type_new" class="radio-label" style="margin-left: 5px;">New
                                            Acceptor</label>
                                    </div>
                                    <div style="display: inline-block;">
                                        <input type="radio" id="client_type_change" name="client_type2"
                                            value="Changing Method" class="radio-input" disabled>
                                        <label for="client_type_change" class="radio-label">Changing
                                            Method</label>
                                    </div>
                                    <div style="display: inline-block;">
                                        <input type="radio" id="client_type_change_clinic" name="client_type2"
                                            value="Changing Clinic" class="radio-input" disabled>
                                        <label for="client_type_change_clinic" class="radio-label">Changing
                                            Clinic</label>
                                    </div>
                                    <div style="display: inline-block;">
                                        <input type="radio" id="client_type_dropout_restart" name="client_type2"
                                            value="Dropout/Restart" class="radio-input" disabled>
                                        <label for="client_type_dropout_restart"
                                            class="radio-label">Dropout/Restart</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label for="">Reason for FP</label>
                                    <br>
                                    <div style="display: inline-block;" class="mt-1">
                                        <input type="radio" id="reason_for_fp_spacing" name="reason_for_fp2"
                                            value="spacing" class="radio-input" disabled>
                                        <label for="reason_for_fp_spacing" class="radio-label"
                                            style="margin-left: 5px;">Spacing</label>
                                    </div>
                                    <div style="display: inline-block;">
                                        <input type="radio" id="reason_for_fp_limiting" name="reason_for_fp2"
                                            value="limiting" class="radio-input" disabled>
                                        <label for="reason_for_fp_limiting" class="radio-label">Limiting</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <hr>
                                <h5>II MEDICAL HISTORY</h5>
                                <hr>
                                <div class="row">
                                    <div class="col">
                                        <label for="medical_conditions">Does the client have any of the
                                            following?</label>
                                        <br>
                                        <div class="form-group">

                                            <div class="checkbox-list">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="severe_headaches2"
                                                        name="medical_condition" value="severe_headaches" disabled>
                                                    <label class="checkbox-label">severe
                                                        headaches/migraine</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox"
                                                        id="history_stroke_heart_attack_hypertension2"
                                                        name="medical_condition"
                                                        value="history_stroke_heart_attack_hypertension" disabled>
                                                    <label class="checkbox-label">history of stroke / heart
                                                        attack /
                                                        hypertension</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="hematoma_bruising_gum_bleeding2"
                                                        name="medical_condition" value="hematoma_bruising_gum_bleeding" disabled>
                                                    <label class="checkbox-label">non-traumatic hematoma /
                                                        frequent
                                                        bruising or gum bleeding</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="breast_cancer_breast_mass2"
                                                        name="medical_condition" value="breast_cancer_breast_mass" disabled>
                                                    <label class="checkbox-label">current or history of breast
                                                        cancer/breast mass</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="severe_chest_pain2"
                                                        name="medical_condition" value="severe_chest_pain" disabled>
                                                    <label class="checkbox-label">severe chest pain</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="cough_more_than_14_days2"
                                                        name="medical_condition" value="cough_more_than_14_days" disabled>
                                                    <label class="checkbox-label">cough for more than 14
                                                        days</label>
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
                                                        value="jaundice" disabled>
                                                    <label class="checkbox-label">jaundice</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="vaginal_bleeding2"
                                                        name="medical_condition" value="vaginal_bleeding" disabled>
                                                    <label class="checkbox-label">unexplained vaginal
                                                        bleeding</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="vaginal_discharge2"
                                                        name="medical_condition" value="vaginal_discharge" disabled>
                                                    <label class="checkbox-label">abnormal vaginal
                                                        discharge</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="phenobarbital_rifampicin2"
                                                        name="medical_condition" value="phenobarbital_rifampicin" disabled>
                                                    <label class="checkbox-label">intake of phenobarbital
                                                        (anti-seizure)
                                                        or rifampicin (anti-TB)</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="smoker2" name="medical_condition"
                                                        value="smoker" disabled>
                                                    <label class="checkbox-label">Is the client a
                                                        SMOKER?</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="with_disability2"
                                                        name="medical_condition" value="with_disability" disabled>
                                                    <label class="checkbox-label">With Disability?</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <hr>
                                <h5>III OBSTERICAL HISTORY</h5>
                                <hr>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">No of Pregnancies</label>
                                            <input type="number" class="form-control" id="no_of_pregnancies2"
                                                name="no_of_pregnancies2" disabled>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Date of Last Delivery</label>
                                            <input type="date" class="form-control" id="date_of_last_delivery2"
                                                name="date_of_last_delivery2" disabled>
                                        </div>
                                    </div>


                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Last Menstrual Period</label>
                                            <input type="date" class="form-control" id="last_period2"
                                                name="last_period2" disabled>
                                        </div>
                                    </div>

                                </div>


                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="">Type of Last Delivery</label>
                                            <br>
                                            <div style="display: inline-block;" class="mt-1">
                                                <input type="radio" id="vaginalRadio" name="type_of_last_delivery2"
                                                    value="Vaginal" class="radio-input" disabled>
                                                <label for="vaginalRadio" class="radio-label"
                                                    style="margin-left: 5px;">Vaginal</label>
                                            </div>
                                            <div style="display: inline-block;">
                                                <input type="radio" id="cesareanRadio" name="type_of_last_delivery2"
                                                    value="Cesarean Section" class="radio-input" disabled>
                                                <label for="cesareanRadio" class="radio-label">Cesarean
                                                    Section</label>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-4">
                                        <label for="">Menstrual Flow</label>
                                        <br>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="scantyRadio" name="mens_type2" value="Scanty"
                                                class="radio-input" disabled>
                                            <label for="scantyRadio" class="radio-label"
                                                style="margin-left: 5px;">Scanty</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="moderateRadio" name="mens_type2" value="Moderate"
                                                class="radio-input" disabled>
                                            <label for="moderateRadio" class="radio-label"
                                                style="margin-left: 5px;">Moderate</label>
                                        </div>

                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="heavyRadio" name="mens_type2" value="Heavy"
                                                class="radio-input" disabled>
                                            <label for="heavyRadio" class="radio-label"
                                                style="margin-left: 5px;">Heavy</label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr>
                            <h5>IV RISK FOR SEXUALITY TRANSMITTED INFECTIONS</h5>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="medical_conditions">Does the client have any of the
                                            following?</label>
                                        <br>
                                        <div class="checkbox-list">
                                            <div class="checkbox-item">
                                                <input type="checkbox" id="abnormal_discharge2"
                                                    name="abnormal_discharge2" value="abnormal_discharge" disabled>
                                                <label class="checkbox-label">abnormal discharge from the
                                                    genital
                                                    area</label>
                                            </div>
                                            <div class="checkbox-item">
                                                <input type="checkbox" id="genital_sores_ulcers2"
                                                    name="genital_sores_ulcers2" value="genital_sores_ulcers" disabled>
                                                <label class="checkbox-label">sores or ulcers in the genital
                                                    area</label>
                                            </div>
                                            <div class="checkbox-item">
                                                <input type="checkbox" id="genital_pain_burning_sensation2"
                                                    name="genital_pain_burning_sensation2"
                                                    value="genital_pain_burning_sensation" disabled>
                                                <label class="checkbox-label">pain or burning sensation in the
                                                    genital
                                                    area</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">

                                        <br>
                                        <div class="checkbox-list">
                                            <div class="checkbox-item">
                                                <input type="checkbox" id="treatment_for_sti2" name="treatment_for_sti2"
                                                    value="treatment_for_sti" disabled>
                                                <label class="checkbox-label">history of treatment for sexually
                                                    transmitted infections</label>
                                            </div>
                                            <div class="checkbox-item">
                                                <input type="checkbox" id="hiv_aids_pid2" name="hiv_aids_pid2"
                                                    value="hiv_aids_pid" disabled>
                                                <label class="checkbox-label">HIV/AIDS/Pelvic inflammatory
                                                    disease</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>


                        </div>

                        <!-- other col -->
                        <div class="col-12">

                            <hr>
                            <h5>V RISK FOR VIOLENCE AGAINST WOMEN</h5>
                            <hr>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="relationship_status">Please indicate the following:</label>
                                        <br>

                                        <div class="checkbox-list">
                                            <div class="checkbox-item">
                                                <input type="checkbox" id="unpleasant_relationship2"
                                                    name="unpleasant_relationship2" value="unpleasant_relationship" disabled>
                                                <label class="checkbox-label">Create an unpleasant relationship
                                                    with
                                                    partner</label>
                                            </div>
                                            <div class="checkbox-item">
                                                <input type="checkbox" id="partner_does_not_approve2"
                                                    name="partner_does_not_approve2" value="partner_does_not_approve" disabled>
                                                <label class="checkbox-label">Partner does not approve of the
                                                    visit to
                                                    FP clinic</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <br>
                                        <div class="checkbox-list">
                                            <div class="checkbox-item">
                                                <input type="checkbox" id="domestic_violence2" name="domestic_violence2"
                                                    value="domestic_violence" disabled>
                                                <label class="checkbox-label">History of domestic violence or
                                                    VAW</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <hr>
                            <h5>VI PHYSICAL EXAMINATION</h5>
                            <hr>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">Weight</label>
                                        <input type="nutextmber" class="form-control" id="weight2" name="weight2"
                                            disabled>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <label for="">Blood Pressure</label>
                                        <input type="text" class="form-control" id="bp2" name="bp2" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">Height</label>
                                        <input type="text" class="form-control" id="height2" name="height2" disabled>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <label for="">Pulse Rate</label>
                                        <input type="text" class="form-control" id="pulse2" name="pulse2" disabled>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">Skin</label>
                                        <br>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="normalSkinRadio" name="skin2" value="Normal"
                                                class="radio-input" disabled>
                                            <label for="normalSkinRadio" class="radio-label"
                                                style="margin-left: 5px;">Normal</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="paleSkinRadio" name="skin2" value="Pale"
                                                class="radio-input" disabled>
                                            <label for="paleSkinRadio" class="radio-label"
                                                style="margin-left: 5px;">Pale</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="yellowishSkinRadio" name="skin2" value="Yellowish"
                                                class="radio-input" disabled>
                                            <label for="yellowishSkinRadio" class="radio-label"
                                                style="margin-left: 5px;">Yellowish</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="hematomaSkinRadio" name="skin2" value="Hematoma"
                                                class="radio-input" disabled>
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
                                            <input type="radio" id="normalRadio" name="extremities2" value="Normal"
                                                class="radio-input" disabled>
                                            <label for="normalRadio" class="radio-label"
                                                style="margin-left: 5px;">Normal</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="edemaRadio" name="extremities2" value="Edema"
                                                class="radio-input" disabled>
                                            <label for="edemaRadio" class="radio-label"
                                                style="margin-left: 5px;">Edema</label>
                                        </div>

                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="varicositiesRadio" name="extremities2"
                                                value="Varicosities" class="radio-input" disabled>
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
                                            <input type="radio" id="normalConjunctivaRadio" name="conjunctiva2"
                                                value="Normal" class="radio-input" disabled>
                                            <label for="normalConjunctivaRadio" class="radio-label"
                                                style="margin-left: 5px;">Normal</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="paleConjunctivaRadio" name="conjunctiva2"
                                                value="Pale" class="radio-input" disabled>
                                            <label for="paleConjunctivaRadio" class="radio-label"
                                                style="margin-left: 5px;">Pale</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="yellowishConjunctivaRadio" name="conjunctiva2"
                                                value="Yellowish" class="radio-input" disabled>
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
                                            <input type="radio" id="normalNeckRadio" name="neck2" value="Normal"
                                                class="radio-input" disabled>
                                            <label for="normalNeckRadio" class="radio-label"
                                                style="margin-left: 5px;">Normal</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="enlargeLymphNodesRadio" name="neck2"
                                                value="Enlarge Lymph Nodes" class="radio-input" disabled>
                                            <label for="enlargeLymphNodesRadio" class="radio-label"
                                                style="margin-left: 5px;">Enlarge Lymph Nodes</label>
                                        </div>
                                    </div>
                                </div>

                            </div>



                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">Breast</label>
                                        <br>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="normalBreastRadio" name="breast2" value="Normal"
                                                class="radio-input" disabled>
                                            <label for="normalBreastRadio" class="radio-label"
                                                style="margin-left: 5px;">Normal</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="massBreastRadio" name="breast2" value="Mass"
                                                class="radio-input" disabled>
                                            <label for="massBreastRadio" class="radio-label"
                                                style="margin-left: 5px;">Mass</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="nippleDischargeBreastRadio" name="breast2"
                                                value="Nipple Discharge" class="radio-input" disabled>
                                            <label for="nippleDischargeBreastRadio" class="radio-label"
                                                style="margin-left: 5px;">Nipple Discharge</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <label for="">Abdomen</label>
                                        <br>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="normalAbdomenRadio" name="abdomen2" value="Normal"
                                                class="radio-input" disabled>
                                            <label for="normalAbdomenRadio" class="radio-label"
                                                style="margin-left: 5px;">Normal</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="abdominalMassRadio" name="abdomen2"
                                                value="Abdominal Mass" class="radio-input" disabled>
                                            <label for="abdominalMassRadio" class="radio-label"
                                                style="margin-left: 5px;">Abdominal Mass</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="varicositiesAbdomenRadio" name="abdomen2"
                                                value="Varicosities" class="radio-input" disabled>
                                            <label for="varicositiesAbdomenRadio" class="radio-label"
                                                style="margin-left: 5px;">Varicosities</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary" id="updateButton">Update</button> -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal edit -->
<!-- 
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
    </div> -->

<!-- modal edit -->





<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    $(document).ready(function () {




        <?php if ($result->num_rows > 0): ?>
            var table = $('#tablebod').DataTable({
                columnDefs: [
                    { targets: 0, data: 'id' },
                    { targets: 1, data: 'last_name' },
                    { targets: 2, data: 'description' },
                    { targets: 3, data: 'diagnosis' },
                    { targets: 4, data: 'medicine' },
                ],
                // Set the default ordering to 'id' column in descending order
                order: [[0, 'desc']]
            });
        <?php else: ?>
            // Initialize DataTable without the "Action" column when no rows are found
            var table = $('#tablebod').DataTable({
                columnDefs: [
                    { targets: 0, data: 'id' },
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
                    { targets: 0, data: 'id' },
                    { targets: 1, data: 'last_name' },
                    { targets: 2, data: 'description' },
                    { targets: 3, data: 'diagnosis' },
                    { targets: 4, data: 'medicine' },
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

<script>

    function recordsBtn(Keydata) {
        console.log(Keydata);
        $.ajax({
            url: 'action/get_family_by_id.php',
            method: 'POST',
            data: {
                primary_id: Keydata
            },
            success: function (data) {

                var editGetData = data;

                console.log(editGetData);

                $('#editModal2 #editdataId1').val(editGetData.id);
                $('#editModal2 #no_of_children2').val(editGetData.no_of_children);
                $('#editModal2 #income2').val(editGetData.income);
                $('#editModal2 #nurse_id2').val(editGetData.nurse_id);
                $('#editModal2 #editstatus').val(editGetData.status);
                $('#editModal2 #no_of_pregnancies2').val(editGetData.no_of_pregnancies);
                $('#editModal2 #date_of_last_delivery2').val(editGetData.date_of_last_delivery);
                $('#editModal2 #last_period2').val(editGetData.last_period);


                // Assuming editGetData.plan_to_have_more_children contains the value "Yes" or "No"
                if (editGetData.plan_to_have_more_children === "Yes") {
                    $('#plan_to_have_more_children_yes').prop('checked', true);
                } else if (editGetData.plan_to_have_more_children === "No") {
                    $('#plan_to_have_more_children_no').prop('checked', true);
                }

                // Assuming editGetData.client_type contains the value like "New Acceptor", "Changing Method", etc.
                if (editGetData.client_type === "New Acceptor") {
                    $('#client_type_new').prop('checked', true);
                } else if (editGetData.client_type === "Changing Method") {
                    $('#client_type_change').prop('checked', true);
                } else if (editGetData.client_type === "Changing Clinic") {
                    $('#client_type_change_clinic').prop('checked', true);
                } else if (editGetData.client_type === "Dropout/Restart") {
                    $('#client_type_dropout_restart').prop('checked', true);
                }

                // Assuming editGetData.reason_for_fp contains the value like "spacing" or "limiting"
                if (editGetData.reason_for_fp === "spacing") {
                    $('#reason_for_fp_spacing').prop('checked', true);
                } else if (editGetData.reason_for_fp === "limiting") {
                    $('#reason_for_fp_limiting').prop('checked', true);
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

                // Check the appropriate radio button based on the value
                if (editGetData.type_of_last_delivery === "Vaginal") {
                    $('#vaginalRadio').prop('checked', true);
                } else if (editGetData.type_of_last_delivery === "Cesarean Section") {
                    $('#cesareanRadio').prop('checked', true);
                }


                if (editGetData.mens_type === "Scanty") {
                    $('#scantyRadio').prop('checked', true);
                } else if (editGetData.mens_type === "Moderate") {
                    $('#moderateRadio').prop('checked', true);
                } else if (editGetData.mens_type === "Heavy") {
                    $('#heavyRadio').prop('checked', true);
                }

                if (editGetData.abnormal_discharge === 'Yes') {
                    $('#abnormal_discharge2').prop('checked', true);
                } else {
                    $('#abnormal_discharge2').prop('checked', false);
                }

                if (editGetData.genital_sores_ulcers === 'Yes') {
                    $('#genital_sores_ulcers2').prop('checked', true);
                } else {
                    $('#genital_sores_ulcers2').prop('checked', false);
                }

                if (editGetData.genital_pain_burning_sensation === 'Yes') {
                    $('#genital_pain_burning_sensation2').prop('checked', true);
                } else {
                    $('#genital_pain_burning_sensation2').prop('checked', false);
                }


                if (editGetData.treatment_for_sti === 'Yes') {
                    $('#treatment_for_sti2').prop('checked', true);
                } else {
                    $('#treatment_for_sti2').prop('checked', false);
                }

                if (editGetData.hiv_aids_pid === 'Yes') {
                    $('#hiv_aids_pid2').prop('checked', true);
                } else {
                    $('#hiv_aids_pid2').prop('checked', false);
                }

                if (editGetData.treatment_for_sti === 'Yes') {
                    $('#treatment_for_sti2').prop('checked', true);
                } else {
                    $('#treatment_for_sti2').prop('checked', false);
                }

                if (editGetData.hiv_aids_pid === 'Yes') {
                    $('#hiv_aids_pid2').prop('checked', true);
                } else {
                    $('#hiv_aids_pid2').prop('checked', false);
                }


                if (editGetData.unpleasant_relationship === 'Yes') {
                    $('#unpleasant_relationship2').prop('checked', true);
                } else {
                    $('#unpleasant_relationship2').prop('checked', false);
                }

                if (editGetData.partner_does_not_approve === 'Yes') {
                    $('#partner_does_not_approve2').prop('checked', true);
                } else {
                    $('#partner_does_not_approve2').prop('checked', false);
                }

                if (editGetData.domestic_violence === 'Yes') {
                    $('#domestic_violence2').prop('checked', true);
                } else {
                    $('#domestic_violence2').prop('checked', false);
                }


                $('#editModal #weight2').val(editGetData.weight);
                $('#editModal #bp2').val(editGetData.bp);
                $('#editModal #height2').val(editGetData.height);
                $('#editModal #pulse2').val(editGetData.pulse);

                // Check the appropriate radio button based on the value
                if (editGetData.extremities === "Normal") {
                    $('#normalRadio').prop('checked', true);
                } else if (editGetData.extremities === "Edema") {
                    $('#edemaRadio').prop('checked', true);
                } else if (editGetData.extremities === "Varicosities") {
                    $('#varicositiesRadio').prop('checked', true);
                }



                // Check the appropriate radio button based on the value
                if (editGetData.skin === "Normal") {
                    $('#normalSkinRadio').prop('checked', true);
                } else if (editGetData.skin === "Pale") {
                    $('#paleSkinRadio').prop('checked', true);
                } else if (editGetData.skin === "Yellowish") {
                    $('#yellowishSkinRadio').prop('checked', true);
                } else if (editGetData.skin === "Hematoma") {
                    $('#hematomaSkinRadio').prop('checked', true);
                }




                // Check the appropriate radio button based on the value
                if (editGetData.conjunctiva === "Normal") {
                    $('#normalConjunctivaRadio').prop('checked', true);
                } else if (editGetData.conjunctiva === "Pale") {
                    $('#paleConjunctivaRadio').prop('checked', true);
                } else if (editGetData.conjunctiva === "Yellowish") {
                    $('#yellowishConjunctivaRadio').prop('checked', true);
                }




                // Check the appropriate radio button based on the value
                if (editGetData.neck === "Normal") {
                    $('#normalNeckRadio').prop('checked', true);
                } else if (editGetData.neck === "Enlarge Lymph Nodes") {
                    $('#enlargeLymphNodesRadio').prop('checked', true);
                }



                // Check the appropriate radio button based on the value
                if (editGetData.breast === "Normal") {
                    $('#normalBreastRadio').prop('checked', true);
                } else if (editGetData.breast === "Mass") {
                    $('#massBreastRadio').prop('checked', true);
                } else if (editGetData.breast === "Nipple Discharge") {
                    $('#nippleDischargeBreastRadio').prop('checked', true);
                }



                // Check the appropriate radio button based on the value
                if (editGetData.abdomen === "Normal") {
                    $('#normalAbdomenRadio').prop('checked', true);
                } else if (editGetData.abdomen === "Abdominal Mass") {
                    $('#abdominalMassRadio').prop('checked', true);
                } else if (editGetData.abdomen === "Varicosities") {
                    $('#varicositiesAbdomenRadio').prop('checked', true);
                }
                $('#editModal2').modal('show');
            },
            error: function (error) {
                console.error('Error fetching  data: ' + error);
            },
        });
    }


</script>