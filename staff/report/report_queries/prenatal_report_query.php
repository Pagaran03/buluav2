<?php
include_once('./../../config.php');


// FOUR PRENATAL CHECKUPS

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


//FIRST TIME PREG WITH TD 2 VACC

$tdVaccstmt10to14 = "
SELECT COUNT(*) as 10to14
FROM (
    SELECT prenatal_consultation.patient_id, COUNT(*) AS cnt
    FROM prenatal_diagnosis
    INNER join patients on prenatal_diagnosis.patient_id = patients.id
    INNER JOIN prenatal_consultation on prenatal_diagnosis.patient_id = prenatal_consultation.patient_id
    INNER JOIN prenatal_subjective ON prenatal_diagnosis.patient_id = prenatal_subjective.patient_id
    WHERE tt2 = 2 and patients.age BETWEEN 10 and 14
    and prenatal_consultation.checkup_date BETWEEN ? AND ?
    and prenatal_subjective.fullterm >= 0
    AND prenatal_subjective.abortion >= 0
    AND prenatal_subjective.preterm >= 0
    AND prenatal_subjective.stillbirth >= 0
    GROUP BY prenatal_diagnosis.patient_id
    HAVING COUNT(*) = 1
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
SELECT COUNT(*) as 15to19
FROM (
    SELECT prenatal_consultation.patient_id, COUNT(*) AS cnt
    FROM prenatal_diagnosis
    INNER join patients on prenatal_diagnosis.patient_id = patients.id
    INNER JOIN prenatal_consultation on prenatal_diagnosis.patient_id = prenatal_consultation.patient_id
    INNER JOIN prenatal_subjective ON prenatal_diagnosis.patient_id = prenatal_subjective.patient_id
    WHERE tt2 = 2 and patients.age BETWEEN 15 and 19
    and prenatal_consultation.checkup_date BETWEEN ? AND ?
    and prenatal_subjective.fullterm >= 0
    AND prenatal_subjective.abortion >= 0
    AND prenatal_subjective.preterm >= 0
    AND prenatal_subjective.stillbirth >= 0
    GROUP BY prenatal_diagnosis.patient_id
    HAVING COUNT(*) = 1
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
SELECT COUNT(*) as 20to49
FROM (
    SELECT prenatal_consultation.patient_id, COUNT(*) AS cnt
    FROM prenatal_diagnosis
    INNER join patients on prenatal_diagnosis.patient_id = patients.id
    INNER JOIN prenatal_consultation on prenatal_diagnosis.patient_id = prenatal_consultation.patient_id
    INNER JOIN prenatal_subjective ON prenatal_diagnosis.patient_id = prenatal_subjective.patient_id
    WHERE tt2 = 2 and patients.age BETWEEN 20 and 49
    and prenatal_consultation.checkup_date BETWEEN ? AND ?
    and prenatal_subjective.fullterm >= 0
    AND prenatal_subjective.abortion >= 0
    AND prenatal_subjective.preterm >= 0
    AND prenatal_subjective.stillbirth >= 0
    GROUP BY prenatal_diagnosis.patient_id
    HAVING COUNT(*) = 1
) AS subquery
;
";

$stmttdVaccstmt20to49 = $conn->prepare($tdVaccstmt20to49);
$stmttdVaccstmt20to49->bind_param("ss", $fromDate, $toDate);
$stmttdVaccstmt20to49->execute();

$result = $stmttdVaccstmt20to49->get_result();


if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $countFirstTimePregnantWithTd2Plus20to49 = $row['20to49'];
}


$totalCountForFirstTimePregnantWithTd2Plus = $countFirstTimePregnantWithTd2Plus10to14 + $countFirstTimePregnantWithTd2Plus15to19 + $countFirstTimePregnantWithTd2Plus20to49;


// 2ND TIME PREG WITH ALTEAST 3 TD VACC


$secondTdvacc10to14 = "
    SELECT COUNT(*) as 10to14
    FROM (
        SELECT prenatal_consultation.patient_id, COUNT(*) AS cnt
        FROM prenatal_diagnosis
        INNER JOIN patients ON prenatal_diagnosis.patient_id = patients.id
        INNER JOIN prenatal_consultation ON prenatal_diagnosis.patient_id = prenatal_consultation.patient_id
        INNER JOIN prenatal_subjective ON prenatal_diagnosis.patient_id = prenatal_subjective.patient_id
        WHERE tt2 >= 3
          AND patients.age BETWEEN 10 AND 14
          AND prenatal_consultation.checkup_date BETWEEN ? AND ?
          AND prenatal_subjective.fullterm >= 0
          AND prenatal_subjective.abortion >= 0
          AND prenatal_subjective.preterm >= 0
          AND prenatal_subjective.stillbirth >= 0
        GROUP BY prenatal_diagnosis.patient_id
        HAVING COUNT(*) = 2
    ) AS subquery";

$stmtSecondTDvacc10to14 = $conn->prepare($secondTdvacc10to14);
$stmtSecondTDvacc10to14->bind_param("ss", $fromDate, $toDate);
$stmtSecondTDvacc10to14->execute();

$result = $stmtSecondTDvacc10to14->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $countSecondTimeTdVacc10to14 = $row["10to14"];
} else {
    $countSecondTimeTdVacc10to14 = 0;
}


$secondTdvacc15to19 = "
    SELECT COUNT(*) as 15to19
    FROM (
        SELECT prenatal_consultation.patient_id, COUNT(*) AS cnt
        FROM prenatal_diagnosis
        INNER JOIN patients ON prenatal_diagnosis.patient_id = patients.id
        INNER JOIN prenatal_consultation ON prenatal_diagnosis.patient_id = prenatal_consultation.patient_id
        INNER JOIN prenatal_subjective ON prenatal_diagnosis.patient_id = prenatal_subjective.patient_id
        WHERE tt2 >= 3
          AND patients.age BETWEEN 15 AND 19
          AND prenatal_consultation.checkup_date BETWEEN ? AND ?
          AND prenatal_subjective.fullterm >= 0
          AND prenatal_subjective.abortion >= 0
          AND prenatal_subjective.preterm >= 0
          AND prenatal_subjective.stillbirth >= 0
        GROUP BY prenatal_diagnosis.patient_id
        HAVING COUNT(*) = 2
    ) AS subquery";

$stmtSecondTDvacc15to19 = $conn->prepare($secondTdvacc15to19);
$stmtSecondTDvacc15to19->bind_param("ss", $fromDate, $toDate);
$stmtSecondTDvacc15to19->execute();

$result = $stmtSecondTDvacc15to19->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $countSecondTimeTdVacc15to19 = $row["15to19"];
} else {
    $countSecondTimeTdVacc15to19 = 0;
}


$secondTdvacc20to49 = "
    SELECT COUNT(*) as 20to49
    FROM (
        SELECT prenatal_consultation.patient_id, COUNT(*) AS cnt
        FROM prenatal_diagnosis
        INNER JOIN patients ON prenatal_diagnosis.patient_id = patients.id
        INNER JOIN prenatal_consultation ON prenatal_diagnosis.patient_id = prenatal_consultation.patient_id
        INNER JOIN prenatal_subjective ON prenatal_diagnosis.patient_id = prenatal_subjective.patient_id
        WHERE tt2 >= 3
          AND patients.age BETWEEN 20 AND 49
          AND prenatal_consultation.checkup_date BETWEEN ? AND ?
          AND prenatal_subjective.fullterm >= 0
          AND prenatal_subjective.abortion >= 0
          AND prenatal_subjective.preterm >= 0
          AND prenatal_subjective.stillbirth >= 0
        GROUP BY prenatal_diagnosis.patient_id
        HAVING COUNT(*) = 2
    ) AS subquery";

$stmtSecondTDvacc20to49 = $conn->prepare($secondTdvacc20to49);
$stmtSecondTDvacc20to49->bind_param("ss", $fromDate, $toDate);
$stmtSecondTDvacc20to49->execute();

$result = $stmtSecondTDvacc20to49->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $countSecondTimeTdVacc20to49 = $row["20to49"];
} else {
    $countSecondTimeTdVacc20to49 = 0;
}

$countTotalSecondTime = $countSecondTimeTdVacc10to14 + $countSecondTimeTdVacc15to19 + $countSecondTimeTdVacc20to49;


//SYPHILIS QUERIES

$syphilis10to14 = "";



// HEPATITS B QUERIES

$hbsagtest10to14 = "";

// CBC QUERIES

// Age Group 10 to 14
$cbc10to14 = "
    SELECT COUNT(*) 
    FROM `prenatal_subjective`
    INNER JOIN patients ON prenatal_subjective.patient_id = patients.id
    WHERE hgb IS NOT NULL AND hgb != 0 
      AND patients.age BETWEEN 10 AND 14
      AND checkup_date BETWEEN ? AND ?";

$stmtcbc10to14 = $conn->prepare($cbc10to14);
$stmtcbc10to14->bind_param("ss", $fromDate, $toDate);
$stmtcbc10to14->execute();

$result10to14 = $stmtcbc10to14->get_result();

if ($result10to14->num_rows > 0) {
    $row10to14 = $result10to14->fetch_assoc();
    $countCbc10to14 = $row10to14["COUNT(*)"];
} else {
    $countCbc10to14 = 0;
}

// Age Group 15 to 19
$cbc15to19 = "
    SELECT COUNT(*)
    FROM `prenatal_subjective`
    INNER JOIN patients ON prenatal_subjective.patient_id = patients.id
    WHERE hgb IS NOT NULL AND hgb != 0 
      AND patients.age BETWEEN 15 AND 19
      AND checkup_date BETWEEN ? AND ?";

$stmtcbc15to19 = $conn->prepare($cbc15to19);
$stmtcbc15to19->bind_param("ss", $fromDate, $toDate);
$stmtcbc15to19->execute();

$result15to19 = $stmtcbc15to19->get_result();

if ($result15to19->num_rows > 0) {
    $row15to19 = $result15to19->fetch_assoc();
    $countCbc15to19 = $row15to19["COUNT(*)"];
} else {
    $countCbc15to19 = 0;
}

// Age Group 20 to 49
$cbc20to49 = "
    SELECT COUNT(*) 
    FROM `prenatal_subjective`
    INNER JOIN patients ON prenatal_subjective.patient_id = patients.id
    WHERE hgb IS NOT NULL AND hgb != 0 
      AND patients.age BETWEEN 20 AND 49
      AND checkup_date BETWEEN ? AND ?";

$stmtcbc20to49 = $conn->prepare($cbc20to49);
$stmtcbc20to49->bind_param("ss", $fromDate, $toDate);
$stmtcbc20to49->execute();

$result20to49 = $stmtcbc20to49->get_result();

if ($result20to49->num_rows > 0) {
    $row20to49 = $result20to49->fetch_assoc();
    $countCbc20to49 = $row20to49["COUNT(*)"];
} else {
    $countCbc20to49 = 0;
}

$cbcTotal = $countCbc10to14 + $countCbc15to19 + $countCbc20to49;


// ANEMIA POSITIVE QUERIES

$anemia10to14 = "
    SELECT COUNT(*) 
    FROM `prenatal_subjective`
    INNER JOIN patients ON prenatal_subjective.patient_id = patients.id
    WHERE hgb IS NOT NULL 
      AND hgb != 0 
      AND hgb <= 12  -- Adjust the threshold for anemia if necessary
      AND patients.age BETWEEN 10 AND 14
      AND checkup_date BETWEEN ? AND ?";

$stmtAnemia10to14 = $conn->prepare($anemia10to14);
$stmtAnemia10to14->bind_param("ss", $fromDate, $toDate);
$stmtAnemia10to14->execute();

$resultAnemia10to14 = $stmtAnemia10to14->get_result();

if ($resultAnemia10to14->num_rows > 0) {
    $rowAnemia10to14 = $resultAnemia10to14->fetch_assoc();
    $countAnemia10to14 = $rowAnemia10to14["COUNT(*)"];
} else {
    $countAnemia10to14 = 0;
}

$anemia15to19 = "
    SELECT COUNT(*) 
    FROM `prenatal_subjective`
    INNER JOIN patients ON prenatal_subjective.patient_id = patients.id
    WHERE hgb IS NOT NULL 
      AND hgb != 0 
      AND hgb <= 12
      AND patients.age BETWEEN 15 AND 19
      AND checkup_date BETWEEN ? AND ?";

$stmtAnemia15to19 = $conn->prepare($anemia15to19);
$stmtAnemia15to19->bind_param("ss", $fromDate, $toDate);
$stmtAnemia15to19->execute();

$resultAnemia15to19 = $stmtAnemia15to19->get_result();

if ($resultAnemia15to19->num_rows > 0) {
    $rowAnemia15to19 = $resultAnemia15to19->fetch_assoc();
    $countAnemia15to19 = $rowAnemia15to19["COUNT(*)"];
} else {
    $countAnemia15to19 = 0;
}

$anemia20to49 = "
    SELECT COUNT(*) 
    FROM `prenatal_subjective`
    INNER JOIN patients ON prenatal_subjective.patient_id = patients.id
    WHERE hgb IS NOT NULL 
      AND hgb != 0 
      AND hgb <= 12
      AND patients.age BETWEEN 20 AND 49
      AND checkup_date BETWEEN ? AND ?";

$stmtAnemia20to49 = $conn->prepare($anemia20to49);
$stmtAnemia20to49->bind_param("ss", $fromDate, $toDate);
$stmtAnemia20to49->execute();

$resultAnemia20to49 = $stmtAnemia20to49->get_result();

if ($resultAnemia20to49->num_rows > 0) {
    $rowAnemia20to49 = $resultAnemia20to49->fetch_assoc();
    $countAnemia20to49 = $rowAnemia20to49["COUNT(*)"];
} else {
    $countAnemia20to49 = 0;
}

$totalAnemiaCount = $countAnemia10to14 + $countAnemia15to19 + $countAnemia20to49;


// GESTATIONAL DIABETES

// WALA PA KO KABALO SA RANGE