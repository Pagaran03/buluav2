<?php
include_once('./../../config.php');

// Query for ages 10-14
$stmt10to14 = $conn->prepare("SELECT COUNT(*) as four_prenatalCheckups_ages10to14_count
FROM (
    SELECT p.id
    FROM patients p
    JOIN (
        SELECT patient_id
        FROM prenatal_consultation
        WHERE checkup_date BETWEEN ? AND ?
        GROUP BY patient_id
        HAVING COUNT(*) = 4
    ) pc ON p.id = pc.patient_id
    WHERE p.age BETWEEN 10 AND 14
) AS subquery");

$stmt10to14->bind_param("ss", $startDate, $endDate);
$stmt10to14->execute();
$result10to14 = $stmt10to14->get_result();
$countForPrenatal10to14 = 0;

if ($result10to14->num_rows > 0) {
    $row = $result10to14->fetch_assoc();
    $countForPrenatal10to14 = $row['four_prenatalCheckups_ages10to14_count'];
}

// Query for ages 15-19
$stmt15to19 = $conn->prepare("SELECT COUNT(*) as four_prenatalCheckups_ages15to19_count
FROM (
    SELECT p.id
    FROM patients p
    JOIN (
        SELECT patient_id
        FROM prenatal_consultation
        WHERE checkup_date BETWEEN ? AND ?
        GROUP BY patient_id
        HAVING COUNT(*) = 4
    ) pc ON p.id = pc.patient_id
    WHERE p.age BETWEEN 15 AND 19
) AS subquery");

$stmt15to19->bind_param("ss", $startDate, $endDate);
$stmt15to19->execute();
$result15to19 = $stmt15to19->get_result();
$countForPrenatal15to19 = 0;

if ($result15to19->num_rows > 0) {
    $row = $result15to19->fetch_assoc();
    $countForPrenatal15to19 = $row['four_prenatalCheckups_ages15to19_count'];
}

// Query for ages 20-49
$stmt20to49 = $conn->prepare("SELECT COUNT(*) as four_prenatalCheckups_ages20to49_count
FROM (
    SELECT p.id
    FROM patients p
    JOIN (
        SELECT patient_id
        FROM prenatal_consultation
        WHERE checkup_date BETWEEN ? AND ?
        GROUP BY patient_id
        HAVING COUNT(*) = 4
    ) pc ON p.id = pc.patient_id
    WHERE p.age BETWEEN 20 AND 49
) AS subquery");

$stmt20to49->bind_param("ss", $startDate, $endDate);
$stmt20to49->execute();
$result20to49 = $stmt20to49->get_result();
$countForPrenatal20to49 = 0;

if ($result20to49->num_rows > 0) {
    $row = $result20to49->fetch_assoc();
    $countForPrenatal20to49 = $row['four_prenatalCheckups_ages20to49_count'];
}

$countForPrenatalTotal = $countForPrenatal10to14 + $countForPrenatal15to19 + $countForPrenatal20to49;


// Query for ages 10-14
$tdVaccstmt10to14 = "
SELECT COUNT(tt2) AS 10to14
FROM (
    SELECT prenatal_diagnosis.patient_id AS tt2
    FROM prenatal_diagnosis
    INNER JOIN prenatal_consultation ON prenatal_diagnosis.patient_id = prenatal_consultation.patient_id
    INNER JOIN patients ON prenatal_consultation.patient_id = patients.id
    WHERE patients.age BETWEEN 10 AND 14 AND tt2 > 1 AND prenatal_consultation.checkup_date BETWEEN ? AND ?
    GROUP BY prenatal_diagnosis.patient_id
    HAVING COUNT(prenatal_diagnosis.patient_id) = 1
) AS subquery;
";

$stmttdVaccstmt10to14 = $conn->prepare($tdVaccstmt10to14);
$stmttdVaccstmt10to14->bind_param("ss", $start_date, $end_date);
$stmttdVaccstmt10to14->execute();

$result = $stmttdVaccstmt10to14->get_result();


if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $countFirstTimePregnantWithTd2Plus10to14 = $row['10to14'];
}

$tdVaccstmt15to19 = "
SELECT COUNT(tt2) AS 15to19
FROM (
    SELECT prenatal_diagnosis.patient_id AS tt2
    FROM prenatal_diagnosis
    INNER JOIN prenatal_consultation ON prenatal_diagnosis.patient_id = prenatal_consultation.patient_id
    INNER JOIN patients ON prenatal_consultation.patient_id = patients.id
     WHERE patients.age BETWEEN 15 AND 19 AND tt2 > 1 AND prenatal_consultation.checkup_date BETWEEN ? AND ?
    GROUP BY prenatal_diagnosis.patient_id
    HAVING COUNT(prenatal_diagnosis.patient_id) = 1
) AS subquery;
";

$stmttdVaccstmt15to19 = $conn->prepare($tdVaccstmt15to19);
$stmttdVaccstmt15to19->bind_param("ss", $start_date, $end_date);
$stmttdVaccstmt15to19->execute();

$result = $stmttdVaccstmt15to19->get_result();


if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $countFirstTimePregnantWithTd2Plus15to19 = $row['15to19'];
}


$tdVaccstmt20to49 = "
SELECT COUNT(tt2) AS 20to49
FROM (
    SELECT prenatal_diagnosis.patient_id AS tt2
    FROM prenatal_diagnosis
    INNER JOIN prenatal_consultation ON prenatal_diagnosis.patient_id = prenatal_consultation.patient_id
    INNER JOIN patients ON prenatal_consultation.patient_id = patients.id
    INNER JOIN prenatal_subjective ON prenatal_diagnosis.patient_id = prenatal_subjective.patient_id
     WHERE patients.age BETWEEN 20 AND 49 
     AND tt2 = 2 
     AND prenatal_subjective.fullterm OR prenatal_subjective.preterm OR prenatal_subjective.abortion OR prenatal_subjective.stillbirth = 0
     AND prenatal_consultation.checkup_date BETWEEN ? AND ?
    GROUP BY prenatal_diagnosis.patient_id
    HAVING COUNT(prenatal_diagnosis.patient_id) = 1
) AS subquery;
";

$stmttdVaccstmt20to49 = $conn->prepare($tdVaccstmt20to49);
$stmttdVaccstmt20to49->bind_param("ss", $fromDate, $toDate);
$stmttdVaccstmt20to49->execute();

$result = $stmttdVaccstmt20to49->get_result();


if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $countFirstTimePregnantWithTd2Plus20to49 = $row['20to49'];
}
