<?php
// Include your database configuration file
include_once ('../../config.php');


$sql = "SELECT *,
CONCAT(patients.last_name,', ',patients.first_name) as full_name,
fp_information.id as id,
nurses.first_name as first_name2,
nurses.last_name as last_name2, 
fp_obstetrical_history.fp_information_id as fp_information_id
FROM fp_information
JOIN patients ON fp_information.patient_id = patients.id
JOIN fp_consultation ON fp_consultation.fp_information_id = fp_information.id
JOIN fp_obstetrical_history ON fp_information.id =  fp_obstetrical_history.fp_information_id
JOIN nurses ON fp_information.nurse_id = nurses.id 
WHERE fp_information.is_deleted = 0
GROUP BY full_name
ORDER BY status
";


$result = $conn->query($sql);

if ($result === false) {
    die("Query failed: " . $conn->error);
}

?>
<style>
    .filter-container {
        display: flex;
        /* margin-left: px; */

    }

    #filterSelect {
        padding: 10px;
        font-size: 16px;
        border-radius: 5px;
        border: 1px solid #ccc;
        outline: none;
        transition: border-color 0.3s;
    }

    #filterSelect:focus {
        border-color: #007BFF;
    }

    .item {
        display: none;
        padding: 15px;
        margin: 10px 0;
        border-radius: 5px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .item[data-status="Complete"] {
        border-left: 5px solid #28a745;
    }

    .item[data-status="Pending"] {
        border-left: 5px solid #ffc107;
    }
</style>
<div class="container-fluid">


    <div style="text-align: left; float: left;">
        <button type="button" id="openModalButton" class="btn btn-primary" style="display:none">
            Add Family Planning
        </button>
    </div>



    <div class="filter-container">
        <a href="archive.php">
            <button type="button" class="btn btn-danger ml-1">
                View Archive
            </button>
        </a>
        <select id="filterSelect" onchange="selectStatus()" class="ml-2">
            <option value="All" selected>Show All</option>
            <option value="Complete">Complete</option>
            <option value="Pending">Pending</option>
        </select>
    </div>



    <!-- <a href="history_consultation.php">
        <button type="button" id="openModalButton" class="btn btn-warning ml-1">
            View History
        </button>
    </a> -->
    <br><br>


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
                            <th>Serial Number</th>
                            <th>Patient Name</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th class="tago">Patient ID</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tableData">
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td class="align-middle tago">
                                        <?php echo $row['id']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo $row['serial_no']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo $row['full_name']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo $row['checkup_date']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php echo $row['status']; ?>
                                    </td>
                                    <td class="tago">
                                        <?php echo $row['patient_id']; ?>
                                    </td>
                                    <td class="align-middle">
                                        <a href="history_consultation.php?patient_id=<?php echo $row['patient_id']; ?>"><button
                                                type="button" class="btn btn-warning ml-1">View History</button></a>

                                        <button type="button" class="btn btn-info editbtn"
                                            data-row-id="<?php echo $row['id']; ?>">
                                            <i class="fas fa-eye"></i> View Record
                                        </button>
                                        <button type="button" class="btn btn-success editbtn2"
                                            data-row-id="<?php echo $row['id']; ?>"><i class="fas fa-edit"></i> Add
                                            Consultation
                                        </button>


                                        <button type="button" class="btn btn-danger deletebtn" data-id="' + row.id + '"><i
                                                class="fas fa-trash"></i> Delete</button>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td class="align-middle"></td>
                                <td class="align-middle">No Family Planning Found</td>
                                <td class="align-middle">
                                <td>
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

    <!-- modal add consult -->

    <div class="modal fade" id="editModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Family Planning Consultation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm">

                        <input type="hidden" id="editdataId" name="primary_id">
                        <!-- Form fields go here -->


                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Family Planning Method</label>
                                        <select class="form-control" id="editMethod" name="method" id="method" required>
                                            <option value="" disabled selected hidden>Select a Method</option>
                                            <option value="BTL">BTL</option>
                                            <option value="NSV">NSV</option>
                                            <option value="Condom">Condom</option>
                                            <option value="Pills">Pills</option>
                                            <option value="Pills-POP">Pills-POP</option>
                                            <option value="Pills-COC">Pills-COC</option>
                                            <option value="Injectables (DMPA/POI)">Injectables (DMPA/POI)</option>
                                            <option value="Implant">Implant</option>
                                            <option value="IUD">IUD</option>
                                            <option value="IUD-I">IUD-I</option>
                                            <option value="IUD-PP">IUD-PP</option>
                                            <option value="NFP-LAM">NFP-LAM</option>
                                            <option value="NFP-BBT">NFP-BBT</option>
                                            <option value="NFP-CMM">NFP-CMM</option>
                                            <option value="NFP-STM">NFP-STM</option>
                                            <option value="NFP-SDM">NFP-SDM</option>
                                            <!-- <option value="Cervical cap">Cervical cap</option>
                                            <option value="Contraceptive sponge">Contraceptive sponge</option>
                                            <option value="Birth control ring">Birth control ring</option>
                                            <option value="Hormonal IUD">Hormonal IUD</option>
                                            <option value="Emergency contraceptive pills">Emergency contraceptive pills
                                            </option>
                                            <option value="Sterilization">Sterilization</option> -->
                                        </select>
                                        <div id="civil_status_error" class="error"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Status</label>
                                        <select class="form-control" name="status" id="editstatus2" required>
                                            <option value="" disabled selected hidden>Select a Status</option>
                                            <option value="Complete">Complete</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Progress">Progress</option>
                                        </select>
                                        <div id="editStatus_error" class="error"></div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="form-group">
                            <label for="">Description</label>
                            <textarea class="form-control" id="editDescription" name="description" rows="3"
                                required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Diagnosis</label>
                            <textarea class="form-control" id="editDiagnosis" name="diagnosis" rows="3"
                                required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Prescription</label>
                            <textarea class="form-control" id="editMedicine" name="medicine" rows="3"
                                required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateButton2">Update</button>
                </div>
            </div>
        </div>
    </div>




    <!-- modal view -->

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="patient_name">Patient Name</label>
                                    <input list="patients" class="form-control" name="patient_name" id="patient_name"
                                        disabled required>
                                    <datalist id="patients">
                                        <?php
                                        // Query to fetch patients from the database
                                        $sql2 = "SELECT serial_no, first_name, last_name, age FROM patients ORDER BY id DESC";
                                        $result2 = $conn->query($sql2);

                                        if ($result2->num_rows > 0) {
                                            while ($row2 = $result2->fetch_assoc()) {
                                                $patientSerialNo = $row2['serial_no'];
                                                $firstName = $row2['first_name'];
                                                $lastName = $row2['last_name'];
                                                $age = $row2['age'];

                                                // Only add patient to the options if they are 18 or older
                                                if ($age >= 18) {
                                                    // Output an option element for each patient with the serial_no as the value
                                                    echo "<option value='$patientSerialNo'>$firstName $lastName</option>";
                                                }
                                            }
                                        } else {
                                            echo "<option disabled>No patients found</option>";
                                        }
                                        ?>
                                    </datalist>
                                    <input type="hidden" name="patient_id" id="patient_id" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="">No. of Living Children</label>
                                    <input type="text" class="form-control" id="no_of_children2" name="no_of_children"
                                        required>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="">Average Monthly Income</label>
                                    <input type="number" class="form-control" id="income2" name="income" required>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="plan_to_have_more_children">Plan to Have More Children?</label>
                                    <br>
                                    <div style="display: inline-block;" class="mt-1">
                                        <input type="radio" id="plan_to_have_more_children_yes"
                                            name="plan_to_have_more_children2" value="Yes" class="radio-input" required>
                                        <label for="plan_to_have_more_children_yes" class="radio-label"
                                            style="margin-left: 5px;">Yes</label>
                                    </div>
                                    <div style="display: inline-block;">
                                        <input type="radio" id="plan_to_have_more_children_no"
                                            name="plan_to_have_more_children2" value="No" class="radio-input" required>
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
                                            value="New Acceptor" class="radio-input" required>
                                        <label for="client_type_new" class="radio-label" style="margin-left: 5px;">New
                                            Acceptor</label>
                                    </div>
                                    <div style="display: inline-block;">
                                        <input type="radio" id="client_type_change" name="client_type2"
                                            value="Changing Method" class="radio-input" required>
                                        <label for="client_type_change" class="radio-label">Changing
                                            Method</label>
                                    </div>
                                    <div style="display: inline-block;">
                                        <input type="radio" id="client_type_change_clinic" name="client_type2"
                                            value="Changing Clinic" class="radio-input" required>
                                        <label for="client_type_change_clinic" class="radio-label">Changing
                                            Clinic</label>
                                    </div>
                                    <div style="display: inline-block;">
                                        <input type="radio" id="client_type_dropout_restart" name="client_type2"
                                            value="Dropout/Restart" class="radio-input" required>
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
                                            value="spacing" class="radio-input" required>
                                        <label for="reason_for_fp_spacing" class="radio-label"
                                            style="margin-left: 5px;">Spacing</label>
                                    </div>
                                    <div style="display: inline-block;">
                                        <input type="radio" id="reason_for_fp_limiting" name="reason_for_fp2"
                                            value="limiting" class="radio-input" required>
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
                                                        name="medical_condition" value="severe_headaches">
                                                    <label class="checkbox-label">severe
                                                        headaches/migraine</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox"
                                                        id="history_stroke_heart_attack_hypertension2"
                                                        name="medical_condition"
                                                        value="history_stroke_heart_attack_hypertension">
                                                    <label class="checkbox-label">history of stroke / heart
                                                        attack /
                                                        hypertension</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="hematoma_bruising_gum_bleeding2"
                                                        name="medical_condition" value="hematoma_bruising_gum_bleeding">
                                                    <label class="checkbox-label">non-traumatic hematoma /
                                                        frequent
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
                                                        value="jaundice">
                                                    <label class="checkbox-label">jaundice</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="vaginal_bleeding2"
                                                        name="medical_condition" value="vaginal_bleeding">
                                                    <label class="checkbox-label">unexplained vaginal
                                                        bleeding</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="vaginal_discharge2"
                                                        name="medical_condition" value="vaginal_discharge">
                                                    <label class="checkbox-label">abnormal vaginal
                                                        discharge</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="phenobarbital_rifampicin2"
                                                        name="medical_condition" value="phenobarbital_rifampicin">
                                                    <label class="checkbox-label">intake of phenobarbital
                                                        (anti-seizure)
                                                        or rifampicin (anti-TB)</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="smoker2" name="medical_condition"
                                                        value="smoker">
                                                    <label class="checkbox-label">Is the client a
                                                        SMOKER?</label>
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

                                <hr>
                                <h5>III OBSTERICAL HISTORY</h5>
                                <hr>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">No of Pregnancies</label>
                                            <input type="number" class="form-control" id="no_of_pregnancies2"
                                                name="no_of_pregnancies2" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Date of Last Delivery</label>
                                            <input type="date" class="form-control" id="date_of_last_delivery2"
                                                name="date_of_last_delivery2" required>
                                        </div>
                                    </div>


                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Last Menstrual Period</label>
                                            <input type="date" class="form-control" id="last_period2"
                                                name="last_period2" required>
                                        </div>
                                    </div>

                                </div>


                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="">Type of Last Delivery</label>
                                            <br>

                                            <select id="type_of_last_delivery2" name="type_of_last_delivery2"
                                                class="form-control" required>
                                                <option value="" disabled selected>Select one</option>
                                                <option value="None">None</option>
                                                <option value="Vaginal">Vaginal</option>
                                                <option value="Cesarean Section">Cesarean Section</option>
                                            </select>

                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <label for="">Menstrual Flow</label>
                                        <br>
                                        <select id="mens_type2" name="mens_type2" class="form-control" required>
                                            <option value="" disabled selected>Select a Menstrual Flow</option>
                                            <option value="None">None</option>
                                            <option value="Scanty">Scanty</option>
                                            <option value="Moderate">Moderate</option>
                                            <option value="Heavy">Heavy</option>
                                        </select>
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
                                                    name="abnormal_discharge2" value="abnormal_discharge">
                                                <label class="checkbox-label">abnormal discharge from the
                                                    genital
                                                    area</label>
                                            </div>
                                            <div class="checkbox-item">
                                                <input type="checkbox" id="genital_sores_ulcers2"
                                                    name="genital_sores_ulcers2" value="genital_sores_ulcers">
                                                <label class="checkbox-label">sores or ulcers in the genital
                                                    area</label>
                                            </div>
                                            <div class="checkbox-item">
                                                <input type="checkbox" id="genital_pain_burning_sensation2"
                                                    name="genital_pain_burning_sensation2"
                                                    value="genital_pain_burning_sensation">
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
                                                    value="treatment_for_sti">
                                                <label class="checkbox-label">history of treatment for sexually
                                                    transmitted infections</label>
                                            </div>
                                            <div class="checkbox-item">
                                                <input type="checkbox" id="hiv_aids_pid2" name="hiv_aids_pid2"
                                                    value="hiv_aids_pid">
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
                                                    name="unpleasant_relationship2" value="unpleasant_relationship">
                                                <label class="checkbox-label">Create an unpleasant relationship
                                                    with
                                                    partner</label>
                                            </div>
                                            <div class="checkbox-item">
                                                <input type="checkbox" id="partner_does_not_approve2"
                                                    name="partner_does_not_approve2" value="partner_does_not_approve">
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
                                                    value="domestic_violence">
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
                                        <label for="weight2">Weight</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="weight2" name="weight2"
                                                required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">kg</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <label for="bp2">Blood Pressure</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="bp2" name="bp2" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">bp</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="height2">Height</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="height2" name="height2"
                                                required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">cm</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <label for="pulse2">Pulse Rate</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="pulse2" name="pulse2" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">bpm</span>
                                            </div>
                                        </div>
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
                                                class="radio-input" required>
                                            <label for="normalSkinRadio" class="radio-label"
                                                style="margin-left: 5px;">Normal</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="paleSkinRadio" name="skin2" value="Pale"
                                                class="radio-input" required>
                                            <label for="paleSkinRadio" class="radio-label"
                                                style="margin-left: 5px;">Pale</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="yellowishSkinRadio" name="skin2" value="Yellowish"
                                                class="radio-input" required>
                                            <label for="yellowishSkinRadio" class="radio-label"
                                                style="margin-left: 5px;">Yellowish</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="hematomaSkinRadio" name="skin2" value="Hematoma"
                                                class="radio-input" required>
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
                                                class="radio-input" required>
                                            <label for="normalRadio" class="radio-label"
                                                style="margin-left: 5px;">Normal</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="edemaRadio" name="extremities2" value="Edema"
                                                class="radio-input" required>
                                            <label for="edemaRadio" class="radio-label"
                                                style="margin-left: 5px;">Edema</label>
                                        </div>

                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="varicositiesRadio" name="extremities2"
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
                                            <input type="radio" id="normalConjunctivaRadio" name="conjunctiva2"
                                                value="Normal" class="radio-input" required>
                                            <label for="normalConjunctivaRadio" class="radio-label"
                                                style="margin-left: 5px;">Normal</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="paleConjunctivaRadio" name="conjunctiva2"
                                                value="Pale" class="radio-input" required>
                                            <label for="paleConjunctivaRadio" class="radio-label"
                                                style="margin-left: 5px;">Pale</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="yellowishConjunctivaRadio" name="conjunctiva2"
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
                                            <input type="radio" id="normalNeckRadio" name="neck2" value="Normal"
                                                class="radio-input" required>
                                            <label for="normalNeckRadio" class="radio-label"
                                                style="margin-left: 5px;">Normal</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="enlargeLymphNodesRadio" name="neck2"
                                                value="Enlarge Lymph Nodes" class="radio-input" required>
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
                                                class="radio-input" required>
                                            <label for="normalBreastRadio" class="radio-label"
                                                style="margin-left: 5px;">Normal</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="massBreastRadio" name="breast2" value="Mass"
                                                class="radio-input" required>
                                            <label for="massBreastRadio" class="radio-label"
                                                style="margin-left: 5px;">Mass</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="nippleDischargeBreastRadio" name="breast2"
                                                value="Nipple Discharge" class="radio-input" required>
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
                                                class="radio-input" required>
                                            <label for="normalAbdomenRadio" class="radio-label"
                                                style="margin-left: 5px;">Normal</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="abdominalMassRadio" name="abdomen2"
                                                value="Abdominal Mass" class="radio-input" required>
                                            <label for="abdominalMassRadio" class="radio-label"
                                                style="margin-left: 5px;">Abdominal Mass</label>
                                        </div>
                                        <div style="display: inline-block;" class="mt-1">
                                            <input type="radio" id="varicositiesAbdomenRadio" name="abdomen2"
                                                value="Varicosities" class="radio-input" required>
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

    <!-- modal edit -->
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


<script>
    function selectStatus() {
        var selectedValue = document.getElementById("filterSelect").value;
        $.ajax({
            url: 'action/getstatus.php',
            type: 'POST',
            data: {
                status: selectedValue
            },
            success: function (response) {
                document.getElementById("tableData").innerHTML = response;
                console.log("WORK?");
            }
        });
    }
</script>


<script>
    $(document).ready(function () {

        document.getElementById('openModalButton').addEventListener('click', function () {
            $('#addModal').modal('show'); // Show the modal
        });


        <?php if ($result->num_rows > 0): ?>
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
                    data: 'checkup_date'
                },
                {
                    targets: 4,
                    data: 'status'
                },
                {
                    targets: 5,
                    data: 'patient_id',
                    visible: false
                },
                {
                    targets: 6,
                    searchable: false,
                    data: null,
                    render: function (data, type, row) {
                        var viewRec = '<a href="history_consultation.php?patient_id=' + row.patient_id + '"><button type="button" class="btn btn-warning ml-1">View History</button></a>';

                        var editButton = '<button type="button" class="btn btn-info editbtn" data-row-id="' + row.id + '"><i class="fas fa-eye"></i> View Record</button>';
                        var addButton = '<button type="button" class="btn btn-success editbtn2" data-row-id="' + row.id + '"><i class="fas fa-edit"></i> Add Consultation </button>';
                        var deleteButton = '<button type="button" class="btn btn-danger deletebtn" data-id="' + row.id + '"><i class="fas fa-trash"></i> Delete</button>';
                        return viewRec + ' ' + editButton + ' ' + addButton + ' ' + deleteButton;


                    }
                }
                ],
                order: [
                    [0, 'desc']
                ]
            });

        <?php else: ?>
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
                    data: 'checkup_date'
                },
                {
                    targets: 4,
                    data: 'status'
                },
                {
                    targets: 5,
                    data: 'patient_id',
                    visible: false
                },
                ],
                order: [
                    [0, 'desc']
                ]
            });
        <?php endif; ?>


        $('#addButton').click(function () {

            table.destroy();
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
                    data: 'checkup_date'
                },
                {
                    targets: 4,
                    data: 'status'
                },
                {
                    targets: 5,
                    data: 'patient_id',
                    visible: false
                },
                {
                    targets: 6,
                    searchable: false,
                    data: null,
                    render: function (data, type, row) {
                        var viewRec = '<a href="history_consultation.php?patient_id=' + row.patient_id + '"><button type="button" class="btn btn-warning ml-1">View History</button></a>';
                        var editButton = '<button type="button" class="btn btn-info editbtn" data-row-id="' + row.id + '"><i class="fas fa-eye"></i> View Record</button>';
                        var addButton = '<button type="button" class="btn btn-success editbtn2" data-row-id="' + row.id + '"><i class="fas fa-edit"></i> Add Consultation </button>';
                        var deleteButton = '<button type="button" class="btn btn-danger deletebtn" data-id="' + row.id + '"><i class="fas fa-trash"></i> Delete</button>';
                        return viewRec + ' ' + editButton + ' ' + addButton + ' ' + deleteButton;
                    }
                } // Action column
                ],
                // Set the default ordering to 'id' column in descending order
                order: [
                    [0, 'desc']
                ]
            });


            // Get data from the form

            // Capture the values of the additional fields and checkboxes
            var patient_id = $('#serial_no2').val();
            var nurse_id = $('#nurse_id').val();
            var serial = $('#serial').val();
            var method = $('#method').val();
            var no_of_children = $('#no_of_children').val();
            var income = $('#income').val();
            var plan_to_have_more_children = $('#plan_to_have_more_children').val();
            var client_type = $('#client_type').val();
            var reason_for_fp = $('#reason_for_fp').val();
            var severe_headaches = $('#severe_headaches').is(':checked') ? 'Yes' : 'No';
            var history_stroke_heart_attack_hypertension = $('#history_stroke_heart_attack_hypertension').is(':checked') ? 'Yes' : 'No';
            var hematoma_bruising_gum_bleeding = $('#hematoma_bruising_gum_bleeding').is(':checked') ? 'Yes' : 'No';
            var breast_cancer_breast_mass = $('#breast_cancer_breast_mass').is(':checked') ? 'Yes' : 'No';
            var severe_chest_pain = $('#severe_chest_pain').is(':checked') ? 'Yes' : 'No';
            var cough_more_than_14_days = $('#cough_more_than_14_days').is(':checked') ? 'Yes' : 'No';
            var vaginal_bleeding = $('#vaginal_bleeding').is(':checked') ? 'Yes' : 'No';
            var vaginal_discharge = $('#vaginal_discharge').is(':checked') ? 'Yes' : 'No';
            var phenobarbital_rifampicin = $('#phenobarbital_rifampicin').is(':checked') ? 'Yes' : 'No';
            var smoker = $('#smoker').is(':checked') ? 'Yes' : 'No';
            var with_disability = $('#with_disability').is(':checked') ? 'Yes' : 'No';

            // Include the fields for fp_obstetrical_history
            var no_of_pregnancies = $('#no_of_pregnancies').val();
            var date_of_last_delivery = $('#date_of_last_delivery').val();
            var last_period = $('#last_period').val();
            var type_of_last_delivery = $('#type_of_last_delivery').val();
            var mens_type = $('#mens_type').val();

            // Include the fields for fp_physical_examination
            var weight = $('#weight').val();
            var bp = $('#bp').val();
            var height = $('#height').val();
            var pulse = $('#pulse').val();
            var skin = $('#skin').val();
            var extremities = $('#extremities').val();
            var conjunctiva = $('#conjunctiva').val();
            var neck = $('#neck').val();
            var breast = $('#breast').val();
            var abdomen = $('#abdomen').val();
            console.log(patient_id);
            // AJAX request to send data to the server
            $.ajax({
                url: 'action/add_family.php',
                method: 'POST',
                data: {
                    patient_id: patient_id,
                    nurse_id: nurse_id,
                    serial: serial,
                    method: method,
                    no_of_children: no_of_children,
                    income: income,
                    plan_to_have_more_children: plan_to_have_more_children,
                    client_type: client_type,
                    reason_for_fp: reason_for_fp,
                    severe_headaches: severe_headaches,
                    history_stroke_heart_attack_hypertension: history_stroke_heart_attack_hypertension,
                    hematoma_bruising_gum_bleeding: hematoma_bruising_gum_bleeding,
                    breast_cancer_breast_mass: breast_cancer_breast_mass,
                    severe_chest_pain: severe_chest_pain,
                    cough_more_than_14_days: cough_more_than_14_days,
                    vaginal_bleeding: vaginal_bleeding,
                    vaginal_discharge: vaginal_discharge,
                    phenobarbital_rifampicin: phenobarbital_rifampicin,
                    smoker: smoker,
                    with_disability: with_disability,
                    no_of_pregnancies: no_of_pregnancies,
                    date_of_last_delivery: date_of_last_delivery,
                    last_period: last_period,
                    type_of_last_delivery: type_of_last_delivery,
                    mens_type: mens_type,
                    weight: weight,
                    bp: bp,
                    height: height,
                    pulse: pulse,
                    skin: skin,
                    extremities: extremities,
                    conjunctiva: conjunctiva,
                    neck: neck,
                    breast: breast,
                    abdomen: abdomen
                },
                success: function (response) {
                    if (response.trim() === 'Success') {
                        // Clear the form fields
                        $('#patient_id').val('');
                        $('#nurse_id').val('');
                        $('#serial').val('');
                        $('#method').val('');
                        $('#no_of_children').val('');
                        $('#income').val('');
                        $('#plan_to_have_more_children').val('');
                        $('#client_type').val('');
                        $('#reason_for_fp').val('');

                        // Clear the checkboxes
                        $('.checkbox-list input[type="checkbox"]').prop('checked', false);

                        // Clear the additional input fields
                        $('#weight').val('');
                        $('#bp').val('');
                        $('#height').val('');
                        $('#pulse').val('');
                        $('#skin').val('');
                        $('#extremities').val('');
                        $('#conjunctiva').val('');
                        $('#neck').val('');
                        $('#breast').val('');
                        $('#abdomen').val('');



                        updateData();
                        $('#addModal').modal('hide');

                        // Remove the modal backdrop manually
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        // Show a success SweetAlert
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Family Planning added successfully',
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
                url: 'action/get_family.php',
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
                title: 'Confirm Delete',
                text: 'Are you sure you want to delete this data?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'action/delete_family.php',
                        method: 'POST',
                        data: {
                            primary_id: deletedataId
                        },
                        success: function (response) {
                            if (response === 'Success') {

                                updateData();
                                Swal.fire('Deleted', 'The Family Planning has been deleted.', 'success');
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

        $('#tablebod').on('click', '.editbtn2', function () {
            var editId = $(this).data('row-id');

            $.ajax({
                url: 'action/get_consultation_by_id.php', // 
                method: 'POST',
                data: {
                    primary_id: editId
                },
                success: function (data) {
                    console.log(data);
                    var editGetData = data;


                    $('#editModal2 #editdataId').val(editGetData.id);
                    $('#editModal2 #editMethod').val(editGetData.method);
                    $('#editModal2 #editstatus2').val(editGetData.status);
                    $('#editModal2 #editDescription').val(editGetData.description);
                    $('#editModal2 #editDiagnosis').val(editGetData.diagnosis);
                    $('#editModal2 #editMedicine').val(editGetData.medicine);

                    $('#editModal2').modal('show');
                },
                error: function (error) {
                    console.error('Error fetching  data: ' + error);
                },
            });
        });


        $('#updateButton2').click(function () {


            var editId = $('#editdataId').val();
            var description = $('#editDescription').val();
            var diagnosis = $('#editDiagnosis').val();
            var medicine = $('#editMedicine').val();
            var method = $('#editMethod').val();
            var status = $('#editstatus2').val();

            $.ajax({
                url: 'action/update_family2.php',
                method: 'POST',
                data: {
                    primary_id: editId,
                    description: description,
                    method: method,
                    status: status,
                    diagnosis: diagnosis,
                    medicine: medicine,
                },
                success: function (response) {
                    if (response === 'Success') {
                        updateData();
                        $('#editModal2').modal('hide');
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Consultation updated successfully',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
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


        // Edit button click event
        $('#tablebod').on('click', '.editbtn', function () {
            var editId = $(this).data('row-id');
            console.log(editId);
            $.ajax({
                url: 'action/get_family_by_id.php',
                method: 'POST',
                data: {
                    primary_id: editId
                },
                success: function (data) {

                    var editGetData = data;

                    console.log(editGetData);
                    $('#editModal #editdataId').val(editGetData.id);
                    $('#editModal #no_of_children2').val(editGetData.no_of_children);
                    $('#editModal #income2').val(editGetData.income);
                    $('#editModal #nurse_id2').val(editGetData.nurse_id);
                    $('#editModal #patient_name').val(editGetData.full_name);
                    $('#editModal #editstatus').val(editGetData.status);
                    $('#editModal #no_of_pregnancies2').val(editGetData.no_of_pregnancies);
                    $('#editModal #date_of_last_delivery2').val(editGetData.date_of_last_delivery);
                    $('#editModal #last_period2').val(editGetData.last_period);
                    $('#editModal #type_of_last_delivery2').val(editGetData.type_of_last_delivery);
                    $('#editModal #mens_type2').val(editGetData.mens_type);


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
                    // if (editGetData.type_of_last_delivery === "Vaginal") {
                    //     $('#vaginalRadio').prop('checked', true);
                    // } else if (editGetData.type_of_last_delivery === "Cesarean Section") {
                    //     $('#cesareanRadio').prop('checked', true);
                    // }


                    // if (editGetData.mens_type === "Scanty") {
                    //     $('#scantyRadio').prop('checked', true);
                    // } else if (editGetData.mens_type === "Moderate") {
                    //     $('#moderateRadio').prop('checked', true);
                    // } else if (editGetData.mens_type === "Heavy") {
                    //     $('#heavyRadio').prop('checked', true);
                    // }

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
                    $('#editModal').modal('show');
                },
                error: function (error) {
                    console.error('Error fetching  data: ' + error);
                },
            });
        });

        $('#updateButton').click(function () {
            //jaba

            var editId = $('#editdataId').val();


            var abnormal_discharge = $('#abnormal_discharge2').val();
            var nurse_id = $('#nurse_id2').val();
            var status = $('#editstatus').val();
            var serial = $('#serial2').val();
            var method = $('#method2').val();
            var no_of_children = $('#no_of_children2').val();
            var income = $('#income2').val();


            var plan_to_have_more_children = $("input[name='plan_to_have_more_children2']:checked").val();
            var client_type = $("input[name='client_type2']:checked").val();
            var reason_for_fp = $("input[name='reason_for_fp2']:checked").val();
            var type_of_last_delivery = $("input[name='type_of_last_delivery2']:checked").val();
            var mens_type = $("input[name='mens_type2']:checked").val();
            var skin = $("input[name='skin2']:checked").val();
            var extremities = $("input[name='extremities2']:checked").val();
            var conjunctiva = $("input[name='conjunctiva2']:checked").val();
            var neck = $("input[name='neck2']:checked").val();
            var breast = $("input[name='breast2']:checked").val();
            var abdomen = $("input[name='abdomen2']:checked").val();

            var severe_headaches = $('#severe_headaches2').is(':checked') ? 'Yes' : 'No';
            var history_stroke_heart_attack_hypertension = $('#history_stroke_heart_attack_hypertension2').is(':checked') ? 'Yes' : 'No';
            var hematoma_bruising_gum_bleeding = $('#hematoma_bruising_gum_bleeding2').is(':checked') ? 'Yes' : 'No';
            var breast_cancer_breast_mass = $('#breast_cancer_breast_mass2').is(':checked') ? 'Yes' : 'No';
            var severe_chest_pain = $('#severe_chest_pain2').is(':checked') ? 'Yes' : 'No';
            var cough_more_than_14_days = $('#cough_more_than_14_days2').is(':checked') ? 'Yes' : 'No';
            var jaundice = $('#jaundice2').is(':checked') ? 'Yes' : 'No';
            var vaginal_bleeding = $('#vaginal_bleeding2').is(':checked') ? 'Yes' : 'No';
            var vaginal_discharge = $('#vaginal_discharge2').is(':checked') ? 'Yes' : 'No';
            var phenobarbital_rifampicin = $('#phenobarbital_rifampicin2').is(':checked') ? 'Yes' : 'No';
            var smoker = $('#smoker2').is(':checked') ? 'Yes' : 'No';
            var with_disability = $('#with_disability2').is(':checked') ? 'Yes' : 'No';

            // Include the fields for fp_obstetrical_history
            var no_of_pregnancies = $('#no_of_pregnancies2').val();
            var date_of_last_delivery = $('#date_of_last_delivery2').val();
            var last_period = $('#last_period2').val();



            // Include the fields for fp_physical_examination
            var weight = $('#weight2').val();
            var bp = $('#bp2').val();
            var height = $('#height2').val();
            var pulse = $('#pulse2').val();

            // AJAX request to send data to the server
            $.ajax({
                url: 'action/update_family.php',
                method: 'POST',
                data: {
                    abnormal_discharge: abnormal_discharge,
                    primary_id: editId,
                    nurse_id: nurse_id,
                    status: status,
                    serial: serial,
                    method: method,
                    no_of_children: no_of_children,
                    income: income,
                    plan_to_have_more_children: plan_to_have_more_children,
                    client_type: client_type,
                    reason_for_fp: reason_for_fp,
                    severe_headaches: severe_headaches,
                    history_stroke_heart_attack_hypertension: history_stroke_heart_attack_hypertension,
                    hematoma_bruising_gum_bleeding: hematoma_bruising_gum_bleeding,
                    breast_cancer_breast_mass: breast_cancer_breast_mass,
                    severe_chest_pain: severe_chest_pain,
                    cough_more_than_14_days: cough_more_than_14_days,
                    jaundice: jaundice,
                    vaginal_bleeding: vaginal_bleeding,
                    vaginal_discharge: vaginal_discharge,
                    phenobarbital_rifampicin: phenobarbital_rifampicin,
                    smoker: smoker,
                    with_disability: with_disability,
                    no_of_pregnancies: no_of_pregnancies,
                    date_of_last_delivery: date_of_last_delivery,
                    last_period: last_period,
                    type_of_last_delivery: type_of_last_delivery,
                    mens_type: mens_type,
                    weight: weight,
                    bp: bp,
                    height: height,
                    pulse: pulse,
                    skin: skin,
                    extremities: extremities,
                    conjunctiva: conjunctiva,
                    neck: neck,
                    breast: breast,
                    abdomen: abdomen
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
                            text: 'Family Planning updated successfully',
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