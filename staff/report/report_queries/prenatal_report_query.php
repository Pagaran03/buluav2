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
$percentForPrenatalTotal = $countForPrenatalTotal / 3;
$percentForPrenatalFormatted = number_format($percentForPrenatalTotal, 2);









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

$percentTd2Plus1st = $totalCountForFirstTimePregnantWithTd2Plus / 3;
$percentTd2Plus1stFormatted = number_format($percentTd2Plus1st, 2);

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
$percentTotalSecondTime = $countTotalSecondTime / 3;
$percentTotalSecondTimeFormatted = number_format($percentTotalSecondTime, 2);



//SYPHILIS QUERIES

// Query for ages 10-14
$syphilis10to14 = "SELECT COUNT(vdrl) AS count FROM prenatal_subjective
INNER JOIN patients ON prenatal_subjective.patient_id = patients.id
WHERE vdrl IS NOT NULL AND checkup_date BETWEEN ? AND ? AND patients.age BETWEEN 10 AND 14";

// Prepare and execute the query for ages 10-14
$stmtSyphilis10to14 = $conn->prepare($syphilis10to14);
$stmtSyphilis10to14->bind_param("ss", $fromDate, $toDate);
$stmtSyphilis10to14->execute();
$resultSyphilis10to14 = $stmtSyphilis10to14->get_result();
if ($resultSyphilis10to14->num_rows > 0) {
    $rowSyphilis10to14 = $resultSyphilis10to14->fetch_assoc();
    $countSyphilis10to14 = $rowSyphilis10to14["count"];
} else {
    $countSyphilis10to14 = 0;
}

// Query for ages 15-19
$syphilis15to19 = "SELECT COUNT(vdrl) AS count FROM prenatal_subjective
INNER JOIN patients ON prenatal_subjective.patient_id = patients.id
WHERE vdrl IS NOT NULL  AND checkup_date BETWEEN ? AND ? AND patients.age BETWEEN 15 AND 19";

// Prepare and execute the query for ages 15-19
$stmtSyphilis15to19 = $conn->prepare($syphilis15to19);
$stmtSyphilis15to19->bind_param("ss", $fromDate, $toDate);
$stmtSyphilis15to19->execute();
$resultSyphilis15to19 = $stmtSyphilis15to19->get_result();
if ($resultSyphilis15to19->num_rows > 0) {
    $rowSyphilis15to19 = $resultSyphilis15to19->fetch_assoc();
    $countSyphilis15to19 = $rowSyphilis15to19["count"];
} else {
    $countSyphilis15to19 = 0;
}

// Query for ages 20-49
$syphilis20to49 = "SELECT COUNT(vdrl) AS count FROM prenatal_subjective
INNER JOIN patients ON prenatal_subjective.patient_id = patients.id
WHERE vdrl IS NOT NULL  AND checkup_date BETWEEN ? AND ? AND patients.age BETWEEN 20 AND 49";

// Prepare and execute the query for ages 20-49 
$stmtSyphilis20to49 = $conn->prepare($syphilis20to49);
$stmtSyphilis20to49->bind_param("ss", $fromDate, $toDate);
$stmtSyphilis20to49->execute();
$resultSyphilis20to49 = $stmtSyphilis20to49->get_result();
if ($resultSyphilis20to49->num_rows > 0) {
    $rowSyphilis20to49 = $resultSyphilis20to49->fetch_assoc();
    $countSyphilis20to49 = $rowSyphilis20to49["count"];
} else {
    $countSyphilis20to49 = 0;
}

$totalSyphilisCount = $countSyphilis10to14 + $countSyphilis15to19 + $countSyphilis20to49;
$totalSyphilisCountPercent = $totalSyphilisCount / 3;
$totalSyphilisCountPercentFormatted = number_format($totalSyphilisCountPercent, 2);



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
$cbcTotalPercent = $cbcTotal / 3;
$cbcTotalPercentFormatted = number_format($cbcTotalPercent, 2);


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
$totalAnemiaCountPercent = $totalAnemiaCount / 3;
$totalAnemiaCountPercentFormatted = number_format($totalAnemiaCountPercent, 2);
// GESTATIONAL DIABETES

// WALA PA KO KABALO SA RANGE

// BMI First Trimester

// LOW BMI
$BMI10to14 = "
SELECT COUNT(*)
FROM (
    SELECT ps.patient_id,
           ps.height,
           ps.weight,
           p.id AS patient_ids,
           p.age,
           ps.weight / (ps.height / 100.0 * ps.height / 100.0) AS BMI,
           CASE 
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) < 18.5 THEN 'Underweight'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) BETWEEN 18.5 AND 24.9 THEN 'Normal weight'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) BETWEEN 25 AND 29.9 THEN 'Overweight'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) BETWEEN 30 AND 34.9 THEN 'Obese 1'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) BETWEEN 35 AND 39.9 THEN 'Obese 2'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) >= 40 THEN 'Obese 3'
               ELSE 'Obese'
           END AS weight_status,
           CASE
               WHEN p.age BETWEEN 10 AND 14 THEN '1st Trimester (10-14)'
               WHEN p.age BETWEEN 15 AND 19 THEN '1st Trimester (15-19)'
               WHEN p.age BETWEEN 20 AND 49 THEN '1st Trimester (20-49)'
               ELSE 'Age not in range'
           END AS trimester
    FROM prenatal_subjective ps
    INNER JOIN patients p ON ps.patient_id = p.id
    WHERE ps.height IS NOT NULL AND ps.weight IS NOT NULL
      AND p.age BETWEEN 10 AND 14
      AND ps.checkup_date BETWEEN ? AND ?
) AS subquery
WHERE BMI < 18.5;
";

// Prepare and execute the query
$stmtBMI10to14 = $conn->prepare($BMI10to14);

$stmtBMI10to14->bind_param("ss", $fromDate, $toDate);
$stmtBMI10to14->execute();

$resultBMI10to14 = $stmtBMI10to14->get_result();

if ($resultBMI10to14->num_rows > 0) {
    $rowBMI10to14 = $resultBMI10to14->fetch_assoc();
    $countBMI10to14 = $rowBMI10to14["COUNT(*)"];
} else {
    $countBMI10to14 = 0;
}

$BMI15to19 = "
SELECT COUNT(*)
FROM (
    SELECT ps.patient_id,
           ps.height,
           ps.weight,
           p.id AS patient_ids,
           p.age,
           ps.weight / (ps.height / 100.0 * ps.height / 100.0) AS BMI,
           CASE 
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) < 18.5 THEN 'Underweight'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) BETWEEN 18.5 AND 24.9 THEN 'Normal weight'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) BETWEEN 25 AND 29.9 THEN 'Overweight'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) BETWEEN 30 AND 34.9 THEN 'Obese 1'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) BETWEEN 35 AND 39.9 THEN 'Obese 2'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) >= 40 THEN 'Obese 3'
               ELSE 'Obese'
           END AS weight_status,
           CASE
               WHEN p.age BETWEEN 10 AND 14 THEN '1st Trimester (10-14)'
               WHEN p.age BETWEEN 15 AND 19 THEN '1st Trimester (15-19)'
               WHEN p.age BETWEEN 20 AND 49 THEN '1st Trimester (20-49)'
               ELSE 'Age not in range'
           END AS trimester
    FROM prenatal_subjective ps
    INNER JOIN patients p ON ps.patient_id = p.id
    WHERE ps.height IS NOT NULL AND ps.weight IS NOT NULL
      AND p.age BETWEEN 15 AND 19
      AND ps.checkup_date BETWEEN ? AND ?
) AS subquery
WHERE BMI < 18.5;
";

// Prepare and execute the query
$stmtBMI15to19 = $conn->prepare($BMI15to19);

$stmtBMI15to19->bind_param("ss", $fromDate, $toDate);
$stmtBMI15to19->execute();

$resultBMI15to19 = $stmtBMI15to19->get_result();

if ($resultBMI15to19->num_rows > 0) {
    $rowBMI15to19 = $resultBMI15to19->fetch_assoc();
    $countBMI15to19 = $rowBMI15to19["COUNT(*)"];
} else {
    $countBMI15to19 = 0;
}

$BMI20to49 = "
SELECT COUNT(*)
FROM (
    SELECT ps.patient_id,
           ps.height,
           ps.weight,
           p.id AS patient_ids,
           p.age,
           ps.weight / (ps.height / 100.0 * ps.height / 100.0) AS BMI,
           CASE 
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) < 18.5 THEN 'Underweight'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) BETWEEN 18.5 AND 24.9 THEN 'Normal weight'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) BETWEEN 25 AND 29.9 THEN 'Overweight'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) BETWEEN 30 AND 34.9 THEN 'Obese 1'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) BETWEEN 35 AND 39.9 THEN 'Obese 2'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) >= 40 THEN 'Obese 3'
               ELSE 'Obese'
           END AS weight_status,
           CASE
               WHEN p.age BETWEEN 10 AND 14 THEN '1st Trimester (10-14)'
               WHEN p.age BETWEEN 15 AND 19 THEN '1st Trimester (15-19)'
               WHEN p.age BETWEEN 20 AND 49 THEN '1st Trimester (20-49)'
               ELSE 'Age not in range'
           END AS trimester
    FROM prenatal_subjective ps
    INNER JOIN patients p ON ps.patient_id = p.id
    WHERE ps.height IS NOT NULL AND ps.weight IS NOT NULL
      AND p.age BETWEEN 20 AND 49
      AND ps.checkup_date BETWEEN ? AND ?
) AS subquery
WHERE BMI < 18.5;
";

// Prepare and execute the query
$stmtBMI20to49 = $conn->prepare($BMI20to49);

$stmtBMI20to49->bind_param("ss", $fromDate, $toDate);
$stmtBMI20to49->execute();

$resultBMI20to49 = $stmtBMI20to49->get_result();

if ($resultBMI20to49->num_rows > 0) {
    $rowBMI20to49 = $resultBMI20to49->fetch_assoc();
    $countBMI20to49 = $rowBMI20to49["COUNT(*)"];
} else {
    $countBMI20to49 = 0;
}


$totalLowBMI = $countBMI10to14 + $countBMI15to19 + $countBMI20to49;
$percentLowBmi = $totalLowBMI / 3;
$percentLowBmiFormatted = number_format($percentLowBmi, 2);

// Average BMI QUERIES

$ABMI10to14 = "
SELECT COUNT(*)
FROM (
    SELECT ps.patient_id,
           ps.height,
           ps.weight,
           p.id AS patient_ids,
           p.age,
           ps.weight / (ps.height / 100.0 * ps.height / 100.0) AS BMI,
           CASE 
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) < 18.5 THEN 'Underweight'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) BETWEEN 18.5 AND 24.9 THEN 'Normal weight'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) BETWEEN 25 AND 29.9 THEN 'Overweight'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) BETWEEN 30 AND 34.9 THEN 'Obese 1'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) BETWEEN 35 AND 39.9 THEN 'Obese 2'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) >= 40 THEN 'Obese 3'
               ELSE 'Obese'
           END AS weight_status,
           CASE
               WHEN p.age BETWEEN 10 AND 14 THEN '1st Trimester (10-14)'
               WHEN p.age BETWEEN 15 AND 19 THEN '1st Trimester (15-19)'
               WHEN p.age BETWEEN 20 AND 49 THEN '1st Trimester (20-49)'
               ELSE 'Age not in range'
           END AS trimester
    FROM prenatal_subjective ps
    INNER JOIN patients p ON ps.patient_id = p.id
    WHERE ps.height IS NOT NULL AND ps.weight IS NOT NULL
      AND p.age BETWEEN 10 AND 14
      AND ps.checkup_date BETWEEN ? AND ?
) AS subquery
WHERE BMI > 18.5 AND BMI < 24.9;
";

// Prepare and execute the query
$stmtABMI10to14 = $conn->prepare($ABMI10to14);

$stmtABMI10to14->bind_param("ss", $fromDate, $toDate);
$stmtABMI10to14->execute();

$resultABMI10to14 = $stmtABMI10to14->get_result();

if ($resultABMI10to14->num_rows > 0) {
    $rowABMI10to14 = $resultABMI10to14->fetch_assoc();
    $countABMI10to14 = $rowABMI10to14["COUNT(*)"];
} else {
    $countABMI10to14 = 0;
}

$ABMI15to19 = "
SELECT COUNT(*)
FROM (
    SELECT ps.patient_id,
           ps.height,
           ps.weight,
           p.id AS patient_ids,
           p.age,
           ps.weight / (ps.height / 100.0 * ps.height / 100.0) AS BMI,
           CASE 
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) < 18.5 THEN 'Underweight'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) BETWEEN 18.5 AND 24.9 THEN 'Normal weight'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) BETWEEN 25 AND 29.9 THEN 'Overweight'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) BETWEEN 30 AND 34.9 THEN 'Obese 1'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) BETWEEN 35 AND 39.9 THEN 'Obese 2'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) >= 40 THEN 'Obese 3'
               ELSE 'Obese'
           END AS weight_status,
           CASE
               WHEN p.age BETWEEN 10 AND 14 THEN '1st Trimester (10-14)'
               WHEN p.age BETWEEN 15 AND 19 THEN '1st Trimester (15-19)'
               WHEN p.age BETWEEN 20 AND 49 THEN '1st Trimester (20-49)'
               ELSE 'Age not in range'
           END AS trimester
    FROM prenatal_subjective ps
    INNER JOIN patients p ON ps.patient_id = p.id
    WHERE ps.height IS NOT NULL AND ps.weight IS NOT NULL
      AND p.age BETWEEN 15 AND 19
      AND ps.checkup_date BETWEEN ? AND ?
) AS subquery
WHERE BMI > 18.5 AND BMI < 24.9;
";

// Prepare and execute the query
$stmtABMI15to19 = $conn->prepare($ABMI15to19);
$stmtABMI15to19->bind_param("ss", $fromDate, $toDate);
$stmtABMI15to19->execute();

$resultABMI15to19 = $stmtABMI15to19->get_result();

if ($resultABMI15to19->num_rows > 0) {
    $rowABMI15to19 = $resultABMI15to19->fetch_assoc();
    $countABMI15to19 = $rowABMI15to19["COUNT(*)"];
} else {
    $countABMI15to19 = 0;
}


$ABMI20to49 = "
SELECT COUNT(*)
FROM (
    SELECT ps.patient_id,
           ps.height,
           ps.weight,
           p.id AS patient_ids,
           p.age,
           ps.weight / (ps.height / 100.0 * ps.height / 100.0) AS BMI,
           CASE 
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) < 18.5 THEN 'Underweight'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) BETWEEN 18.5 AND 24.9 THEN 'Normal weight'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) BETWEEN 25 AND 29.9 THEN 'Overweight'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) BETWEEN 30 AND 34.9 THEN 'Obese 1'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) BETWEEN 35 AND 39.9 THEN 'Obese 2'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) >= 40 THEN 'Obese 3'
               ELSE 'Obese'
           END AS weight_status,
           CASE
               WHEN p.age BETWEEN 10 AND 14 THEN '1st Trimester (10-14)'
               WHEN p.age BETWEEN 15 AND 19 THEN '1st Trimester (15-19)'
               WHEN p.age BETWEEN 20 AND 49 THEN '1st Trimester (20-49)'
               ELSE 'Age not in range'
           END AS trimester
    FROM prenatal_subjective ps
    INNER JOIN patients p ON ps.patient_id = p.id
    WHERE ps.height IS NOT NULL AND ps.weight IS NOT NULL
      AND p.age BETWEEN 20 AND 49
      AND ps.checkup_date BETWEEN ? AND ?
) AS subquery
WHERE BMI > 18.5 AND BMI < 24.9;
";

// Prepare and execute the query
$stmtABMI20to49 = $conn->prepare($ABMI20to49);
$stmtABMI20to49->bind_param("ss", $fromDate, $toDate);
$stmtABMI20to49->execute();

$resultABMI20to49 = $stmtABMI20to49->get_result();

if ($resultABMI20to49->num_rows > 0) {
    $rowABMI20to49 = $resultABMI20to49->fetch_assoc();
    $countABMI20to49 = $rowABMI20to49["COUNT(*)"];
} else {
    $countABMI20to49 = 0;
}

$countTotalABMI = $countABMI10to14 + $countABMI15to19 + $countABMI20to49;
$percentABIMI = $countTotalABMI / 3;
$percentABMIFormatted = number_format($percentABIMI, 2);


// HIGH BMI

$HighBMI10to14 = "
SELECT COUNT(*)
FROM (
    SELECT ps.patient_id,
           ps.height,
           ps.weight,
           p.id AS patient_ids,
           p.age,
           ps.weight / (ps.height / 100.0 * ps.height / 100.0) AS BMI,
           CASE 
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) < 18.5 THEN 'Underweight'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) BETWEEN 18.5 AND 24.9 THEN 'Normal weight'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) BETWEEN 25 AND 29.9 THEN 'Overweight'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) BETWEEN 30 AND 34.9 THEN 'Obese 1'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) BETWEEN 35 AND 39.9 THEN 'Obese 2'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) >= 40 THEN 'Obese 3'
               ELSE 'Obese'
           END AS weight_status,
           CASE
               WHEN p.age BETWEEN 10 AND 14 THEN '1st Trimester (10-14)'
               WHEN p.age BETWEEN 15 AND 19 THEN '1st Trimester (15-19)'
               WHEN p.age BETWEEN 20 AND 49 THEN '1st Trimester (20-49)'
               ELSE 'Age not in range'
           END AS trimester
    FROM prenatal_subjective ps
    INNER JOIN patients p ON ps.patient_id = p.id
    WHERE ps.height IS NOT NULL AND ps.weight IS NOT NULL
      AND p.age BETWEEN 10 AND 14
      AND ps.checkup_date BETWEEN ? AND ?
) AS subquery
WHERE BMI >= 25.0;
";

// Prepare and execute the query
$stmtHighBMI10to14 = $conn->prepare($HighBMI10to14);
$stmtHighBMI10to14->bind_param("ss", $fromDate, $toDate);
$stmtHighBMI10to14->execute();

$resultHighBMI10to14 = $stmtHighBMI10to14->get_result();

if ($resultHighBMI10to14->num_rows > 0) {
    $rowHighBMI10to14 = $resultHighBMI10to14->fetch_assoc();
    $countHighBMI10to14 = $rowHighBMI10to14["COUNT(*)"];
} else {
    $countHighBMI10to14 = 0;
}


$HighBMI15to19 = "
SELECT COUNT(*)
FROM (
    SELECT ps.patient_id,
           ps.height,
           ps.weight,
           p.id AS patient_ids,
           p.age,
           ps.weight / (ps.height / 100.0 * ps.height / 100.0) AS BMI,
           CASE 
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) < 18.5 THEN 'Underweight'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) BETWEEN 18.5 AND 24.9 THEN 'Normal weight'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) BETWEEN 25 AND 29.9 THEN 'Overweight'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) BETWEEN 30 AND 34.9 THEN 'Obese 1'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) BETWEEN 35 AND 39.9 THEN 'Obese 2'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) >= 40 THEN 'Obese 3'
               ELSE 'Obese'
           END AS weight_status,
           CASE
               WHEN p.age BETWEEN 10 AND 14 THEN '1st Trimester (10-14)'
               WHEN p.age BETWEEN 15 AND 19 THEN '1st Trimester (15-19)'
               WHEN p.age BETWEEN 20 AND 49 THEN '1st Trimester (20-49)'
               ELSE 'Age not in range'
           END AS trimester
    FROM prenatal_subjective ps
    INNER JOIN patients p ON ps.patient_id = p.id
    WHERE ps.height IS NOT NULL AND ps.weight IS NOT NULL
      AND p.age BETWEEN 15 AND 19
      AND ps.checkup_date BETWEEN ? AND ?
) AS subquery
WHERE BMI >= 25.0;
";

// Prepare and execute the query
$stmtHighBMI15to19 = $conn->prepare($HighBMI15to19);
$stmtHighBMI15to19->bind_param("ss", $fromDate, $toDate);
$stmtHighBMI15to19->execute();

$resultHighBMI15to19 = $stmtHighBMI15to19->get_result();

if ($resultHighBMI15to19->num_rows > 0) {
    $rowHighBMI15to19 = $resultHighBMI15to19->fetch_assoc();
    $countHighBMI15to19 = $rowHighBMI15to19["COUNT(*)"];
} else {
    $countHighBMI15to19 = 0;
}


$HighBMI20to49 = "
SELECT COUNT(*)
FROM (
    SELECT ps.patient_id,
           ps.height,
           ps.weight,
           p.id AS patient_ids,
           p.age,
           ps.weight / (ps.height / 100.0 * ps.height / 100.0) AS BMI,
           CASE 
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) < 18.5 THEN 'Underweight'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) BETWEEN 18.5 AND 24.9 THEN 'Normal weight'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) BETWEEN 25 AND 29.9 THEN 'Overweight'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) BETWEEN 30 AND 34.9 THEN 'Obese 1'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) BETWEEN 35 AND 39.9 THEN 'Obese 2'
               WHEN ps.weight / (ps.height / 100.0 * ps.height / 100.0) >= 40 THEN 'Obese 3'
               ELSE 'Obese'
           END AS weight_status,
           CASE
               WHEN p.age BETWEEN 10 AND 14 THEN '1st Trimester (10-14)'
               WHEN p.age BETWEEN 15 AND 19 THEN '1st Trimester (15-19)'
               WHEN p.age BETWEEN 20 AND 49 THEN '1st Trimester (20-49)'
               ELSE 'Age not in range'
           END AS trimester
    FROM prenatal_subjective ps
    INNER JOIN patients p ON ps.patient_id = p.id
    WHERE ps.height IS NOT NULL AND ps.weight IS NOT NULL
      AND p.age BETWEEN 20 AND 49
      AND ps.checkup_date BETWEEN ? AND ?
) AS subquery
WHERE BMI >= 25.0;
";

// Prepare and execute the query
$stmtHighBMI20to49 = $conn->prepare($HighBMI20to49);
$stmtHighBMI20to49->bind_param("ss", $fromDate, $toDate);
$stmtHighBMI20to49->execute();

$resultHighBMI20to49 = $stmtHighBMI20to49->get_result();

if ($resultHighBMI20to49->num_rows > 0) {
    $rowHighBMI20to49 = $resultHighBMI20to49->fetch_assoc();
    $countHighBMI20to49 = $rowHighBMI20to49["COUNT(*)"];
} else {
    $countHighBMI20to49 = 0;
}


$totalHighBMI = $countHighBMI10to14 + $countHighBMI15to19 + $countHighBMI20to49;
$percentHighBMI = $totalHighBMI / 3;
$percentHighBMIFormatted = number_format($percentHighBMI, 2);


// Prepare and execute the query for ages 10-14
$vdrl10to14 = "
SELECT COUNT(*)
FROM prenatal_subjective ps
INNER JOIN patients p ON ps.patient_id = p.id
WHERE ps.vdrl IS NOT NULL 
  AND ps.vdrl != ''
  AND ps.vdrl NOT LIKE '0%'
  AND p.age BETWEEN 10 AND 14 
  AND ps.checkup_date BETWEEN ? AND ?;
";
$stmtVDRL10to14 = $conn->prepare($vdrl10to14);
$stmtVDRL10to14->bind_param("ss", $fromDate, $toDate);
$stmtVDRL10to14->execute();
$stmtVDRL10to14->bind_result($countVDRL10to14);
$stmtVDRL10to14->fetch();
$stmtVDRL10to14->close();

// Prepare and execute the query for ages 15-19
$vdrl15to19 = "
SELECT COUNT(*)
FROM prenatal_subjective ps
INNER JOIN patients p ON ps.patient_id = p.id
WHERE ps.vdrl IS NOT NULL 
  AND ps.vdrl != ''
  AND ps.vdrl NOT LIKE '0%'
  AND p.age BETWEEN 15 AND 19 
  AND ps.checkup_date BETWEEN ? AND ?;
";
$stmtVDRL15to19 = $conn->prepare($vdrl15to19);
$stmtVDRL15to19->bind_param("ss", $fromDate, $toDate);
$stmtVDRL15to19->execute();
$stmtVDRL15to19->bind_result($countVDRL15to19);
$stmtVDRL15to19->fetch();
$stmtVDRL15to19->close();

// Prepare and execute the query for ages 20-49
$vdrl20to49 = "
SELECT COUNT(*)
FROM prenatal_subjective ps
INNER JOIN patients p ON ps.patient_id = p.id
WHERE ps.vdrl IS NOT NULL 
  AND ps.vdrl != ''
  AND ps.vdrl NOT LIKE '0%'
  AND p.age BETWEEN 20 AND 49 
  AND ps.checkup_date BETWEEN ? AND ?;
";
$stmtVDRL20to49 = $conn->prepare($vdrl20to49);
$stmtVDRL20to49->bind_param("ss", $fromDate, $toDate);
$stmtVDRL20to49->execute();
$stmtVDRL20to49->bind_result($countVDRL20to49);
$stmtVDRL20to49->fetch();
$stmtVDRL20to49->close();

if ($countVDRL10to14 == 0) {
    $countVDRL10to14 = 0;
}

if ($countVDRL15to19 == 0) {
    $countVDRL15to19 = 0;
}
if ($countVDRL20to49 == 0) {
    $countVDRL20to49 = 0;
}

$totalVdrlCount = $countVDRL10to14 +
    $countVDRL15to19 +
    $countVDRL20to49;

$totalVdrlCountPercent = $totalVdrlCount / 3;
$totalVdrlCountPercentFormatted = number_format($totalVdrlCountPercent, 2);

// Prepare and execute the SQL query for ages 10-14
$query10to14 = "
SELECT COUNT(hbsag) 
FROM prenatal_subjective 
INNER JOIN patients ON prenatal_subjective.patient_id = patients.id 
WHERE patients.age BETWEEN 10 AND 14 
AND checkup_date BETWEEN ? AND ?;
";

$stmt10to14 = $conn->prepare($query10to14);
$stmt10to14->bind_param("ss", $fromDate, $toDate);
$stmt10to14->execute();
$stmt10to14->bind_result($countHbsag10to14);
$stmt10to14->fetch();
$stmt10to14->close();

// Prepare and execute the SQL query for ages 15-19
$query15to19 = "
SELECT COUNT(hbsag) 
FROM prenatal_subjective 
INNER JOIN patients ON prenatal_subjective.patient_id = patients.id 
WHERE patients.age BETWEEN 15 AND 19 
AND checkup_date BETWEEN ? AND ?;
";

$stmt15to19 = $conn->prepare($query15to19);
$stmt15to19->bind_param("ss", $fromDate, $toDate);
$stmt15to19->execute();
$stmt15to19->bind_result($countHbsag15to19);
$stmt15to19->fetch();
$stmt15to19->close();

// Prepare and execute the SQL query for ages 20-49
$query20to49 = "
SELECT COUNT(hbsag) 
FROM prenatal_subjective 
INNER JOIN patients ON prenatal_subjective.patient_id = patients.id 
WHERE patients.age BETWEEN 20 AND 49 
AND checkup_date BETWEEN ? AND ?;
";

$stmt20to49 = $conn->prepare($query20to49);
$stmt20to49->bind_param("ss", $fromDate, $toDate);
$stmt20to49->execute();
$stmt20to49->bind_result($countHbsag20to49);
$stmt20to49->fetch();
$stmt20to49->close();

$TotalcountHbsag = $countHbsag10to14 +
    $countHbsag15to19 +
    $countHbsag20to49;

$TotalcountHbsagPercent = $TotalcountHbsag / 3;
$TotalcountHbsagPercentFormatted = number_format($TotalcountHbsagPercent, 2);

// HBSAG POSITIVE
// Prepare and execute the SQL query for ages 10-14
$query10to14 = "
SELECT COUNT(hbsag) 
FROM prenatal_subjective 
INNER JOIN patients ON prenatal_subjective.patient_id = patients.id 
WHERE patients.age BETWEEN 10 AND 14 
AND checkup_date BETWEEN ? AND ?
AND hbsag > 5;
";

$stmt10to14 = $conn->prepare($query10to14);
$stmt10to14->bind_param("ss", $fromDate, $toDate);
$stmt10to14->execute();
$stmt10to14->bind_result($countHbsagPositive10to14);
$stmt10to14->fetch();
$stmt10to14->close();

// Prepare and execute the SQL query for ages 15-19
$query15to19 = "
SELECT COUNT(hbsag) 
FROM prenatal_subjective 
INNER JOIN patients ON prenatal_subjective.patient_id = patients.id 
WHERE patients.age BETWEEN 15 AND 19 
AND checkup_date BETWEEN ? AND ?
AND hbsag > 5;
";

$stmt15to19 = $conn->prepare($query15to19);
$stmt15to19->bind_param("ss", $fromDate, $toDate);
$stmt15to19->execute();
$stmt15to19->bind_result($countHbsagPositive15to19);
$stmt15to19->fetch();
$stmt15to19->close();

// Prepare and execute the SQL query for ages 20-49
$query20to49 = "
SELECT COUNT(hbsag) 
FROM prenatal_subjective 
INNER JOIN patients ON prenatal_subjective.patient_id = patients.id 
WHERE patients.age BETWEEN 20 AND 49 
AND checkup_date BETWEEN ? AND ?
AND hbsag > 5;
";

$stmt20to49 = $conn->prepare($query20to49);
$stmt20to49->bind_param("ss", $fromDate, $toDate);
$stmt20to49->execute();
$stmt20to49->bind_result($countHbsagPositive20to49);
$stmt20to49->fetch();
$stmt20to49->close();


$totalHbsagPositive = $countHbsagPositive10to14 + $countHbsagPositive15to19 + $countHbsagPositive20to49;
$totalHbsagPositivePercent = $totalHbsagPositive / 3;
$totalHbsagPositivePercentFormatted = number_format($totalHbsagPositivePercent,2);