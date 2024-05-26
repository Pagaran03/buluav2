<?php
// Include your database configuration file
include_once ('../../../config.php');

$primary_id = $_POST['primary_id'];
$fh = $_POST['fh'];
$fhb = $_POST['fhb'];
$pres = $_POST['pres'];
$plan = $_POST['plan'];
//Prenatal_subjective
$status = $_POST['status'];
$trimester = $_POST['trimester'];
$weight = $_POST['weight'];
$pr = $_POST['pr'];
$rr = $_POST['rr'];
$bp = $_POST['bp'];
$temperature = $_POST['temperature'];
//Prenatal_diagnosis
$aog = $_POST['aog'];

try {
    // Start a transaction
    $conn->begin_transaction();


    $consultationUpdateSql = "UPDATE prenatal_consultation SET fh=?, fhb=?, pres=?, plan=? WHERE id=?";
    $consultationStmt = $conn->prepare($consultationUpdateSql);
    $consultationStmt->bind_param("ssssi", $fh, $fhb, $pres, $plan, $primary_id);
    //Prenatal Subjective
    $subjectivenUpdateSql = "UPDATE prenatal_subjective SET status=?, trimester=?, weight=?, pr=?, rr=?, bp=?, temperature=? WHERE id=?";
    $subjectiveStmt = $conn->prepare($subjectivenUpdateSql);
    $subjectiveStmt->bind_param("sssssssi", $status, $trimester, $weight, $pr, $rr, $bp, $temperature, $primary_id);
    //Prenatal Diagnosis
    $diagnosisUpdateSql = "UPDATE prenatal_diagnosis SET aog=? WHERE id=?";
    $diagnosisStmt = $conn->prepare($diagnosisUpdateSql);
    $diagnosisStmt->bind_param("si", $aog, $primary_id);
    // Execute both update statements
    $consultationUpdateSuccess = $consultationStmt->execute();
    $subjectiveUpdateSuccess = $subjectiveStmt->execute();
    $diagnosisUpdateSuccess = $diagnosisStmt->execute();


    if ($consultationUpdateSuccess && $subjectiveUpdateSuccess && $diagnosisUpdateSuccess) {
        // Commit the transaction if both updates are successful
        $conn->commit();
        echo 'Success';
    } else {
        // Rollback the transaction if any update fails
        $conn->rollback();
        throw new Exception('Error updating data');
    }

    // Close the prepared statements
    $consultationStmt->close();

    // Close the database connection
    $conn->close();
} catch (Exception $e) {
    // Handle exceptions (e.g., log the error and provide a user-friendly message)
    header('HTTP/1.1 500 Internal Server Error');
    echo 'Error: ' . $e->getMessage();
}
?>