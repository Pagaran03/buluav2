<?php
// Set appropriate response headers
header("Content-Security-Policy: default-src 'self';"); // Set Content Security Policy header to restrict resource loading
header('Content-Type: text/plain'); // Set the content type to plain text
header('X-Content-Type-Options: nosniff'); // Prevent browsers from interpreting files as a different MIME type
header('X-Frame-Options: DENY'); // Prevent clickjacking attacks
header('Referrer-Policy: strict-origin-when-cross-origin'); // Control referrer information sent to other sites
header('X-XSS-Protection: 1; mode=block'); // Enable XSS (Cross-Site Scripting) protection

// Include your database configuration file
include_once ('../../../config.php');
session_start();

// Function to sanitize user input
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
    $input = preg_replace("/[\x00-\x1F\s]+/", "", $input);
    // Remove script and content characters
    $input = preg_replace("/<script[^>]*>(.*?)<\/script>/is", "", $input);
    return $input;
}


// Get data from the POST request and sanitize it
$serial_no = sanitizeInput($_POST['patient_id']);
$subjective = sanitizeInput($_POST['subjective']);
$objective = sanitizeInput($_POST['objective']);
$assessment = sanitizeInput($_POST['assessment']);
$plan = sanitizeInput($_POST['plan']);
$status = sanitizeInput($_POST['status']);
$date = date('Y-m-d');
$doctor_id = sanitizeInput($_POST['doctor_id']);

$severe_headaches = sanitizeInput($_POST['severe_headaches']);
$history_stroke_heart_attack_hypertension = sanitizeInput($_POST['history_stroke_heart_attack_hypertension']);
$hematoma_bruising_gum_bleeding = sanitizeInput($_POST['hematoma_bruising_gum_bleeding']);
$breast_cancer_breast_mass = sanitizeInput($_POST['breast_cancer_breast_mass']);
$severe_chest_pain = sanitizeInput($_POST['severe_chest_pain']);
$cough_more_than_14_days = sanitizeInput($_POST['cough_more_than_14_days']);
$vaginal_bleeding = sanitizeInput($_POST['vaginal_bleeding']);
$vaginal_discharge = sanitizeInput($_POST['vaginal_discharge']);
$phenobarbital_rifampicin = sanitizeInput($_POST['phenobarbital_rifampicin']);
$smoker = sanitizeInput($_POST['smoker']);
$with_disability = sanitizeInput($_POST['with_disability']);
$jaundice = sanitizeInput($_POST['jaundice']);

$weight = sanitizeInput($_POST['weight']);
$bp = sanitizeInput($_POST['bp']);
$height = sanitizeInput($_POST['height']);
$pulse = sanitizeInput($_POST['pulse']);
$skin = sanitizeInput($_POST['skin']);
$extremities = sanitizeInput($_POST['extremities']);
$conjunctiva = sanitizeInput($_POST['conjunctiva']);
$neck = sanitizeInput($_POST['neck']);

// Query to find the patient_id based on the serial_no
$sql_patient_id = "SELECT id FROM patients WHERE serial_no = ?";
$stmt_patient_id = $conn->prepare($sql_patient_id);
$stmt_patient_id->bind_param("s", $serial_no);

if ($stmt_patient_id->execute()) {
    $stmt_patient_id->bind_result($patient_id);
    if ($stmt_patient_id->fetch()) {
        // Now you have the sanitized patient_id
        $stmt_patient_id->close();

        // Insert data into the consultations table
        $sql_insert = "INSERT INTO consultations (patient_id, subjective, objective, assessment, plan, checkup_date, status, doctor_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("ssssssss", $patient_id, $subjective, $objective, $assessment, $plan, $date, $status, $doctor_id);
        if ($stmt_insert->execute()) {
            $last_inserted_id = $conn->insert_id;
            $sql2 = "INSERT INTO fp_medical_history (consultation_id, patient_id, severe_headaches, history_stroke_heart_attack_hypertension, hematoma_bruising_gum_bleeding, breast_cancer_breast_mass, severe_chest_pain, cough_more_than_14_days, vaginal_bleeding, vaginal_discharge, phenobarbital_rifampicin, smoker, with_disability, jaundice)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param("dsssssssssssss", $last_inserted_id, $patient_id, $severe_headaches, $history_stroke_heart_attack_hypertension, $hematoma_bruising_gum_bleeding, $breast_cancer_breast_mass, $severe_chest_pain, $cough_more_than_14_days, $vaginal_bleeding, $vaginal_discharge, $phenobarbital_rifampicin, $smoker, $with_disability, $jaundice);

            // Execute the SQL statement to insert into fp_medical_history
            if ($stmt2->execute()) {
                // Prepare and execute the SQL statement to insert into fp_physical_examination
                $sql6 = "INSERT INTO fp_physical_examination (consultation_id, weight, bp, height, pulse, skin, extremities, conjunctiva, neck, breast, abdomen)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt6 = $conn->prepare($sql6);
                $stmt6->bind_param("dssssssssss", $last_inserted_id, $weight, $bp, $height, $pulse, $skin, $extremities, $conjunctiva, $neck, $breast, $abdomen);

                // Execute the SQL statement to insert into fp_physical_examination
                if ($stmt6->execute()) {
                    // Successful insertion
                    echo 'Success';
                } else {
                    // Error handling for the sixth insert
                    echo 'Error in fp_physical_examination: ' . $conn->error;
                }
            } else {
                // Error handling for the fifth insert
                echo 'Error in fp_medical_history: ' . $conn->error;
            }
        } else {
            // Error handling for the fourth insert
            echo 'Error: ' . $conn->error;
        }
        $stmt_insert->close();
    } else {
        // Patient with the provided serial_no not found
        echo 'Error: Patient not found';
    }
} else {
    // Error executing the query
    echo 'Error: ' . $conn->error;
}

// Close the database connection
$conn->close();
?>