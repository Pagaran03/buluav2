<?php
include('../../../config.php');

$prenatals = ['abortion', 'stillbirth', 'alive', 'trimester'];
$zoneCounts = [];

for ($zone = 1; $zone <= 12; $zone++) {
    $zoneCounts["Zone $zone"] = array_fill_keys($prenatals, 0);
}

$selectOption = isset($_GET['selectOption']) ? $_GET["selectOption"] : null;
$frmDate = isset($_GET['frmDatefp']) ? $_GET['frmDatefp'] : null;
$toDate = isset($_GET['toDatefp']) ? $_GET['toDatefp'] : null;
$zone = isset($_GET['zone']) ? $_GET['zone'] : null;

$forceps = isset($_GET['forceps']);
$smoking = isset($_GET['smoking']);
$alcohol = isset($_GET['alcohol']);
$cesarean = isset($_GET['cesarean']) && $_GET['cesarean'] === '1';
$miscarriages = isset($_GET['3-miscarriages']) && $_GET['3-miscarriages'] === '1';
$ectopic = isset($_GET['ectopic']) && $_GET['ectopic'] === '1';
$postpartumBleed = isset($_GET['postpartum-bleed']) && $_GET['postpartum-bleed'] === '1';
$babyweightgreaterthan4 = isset($_GET['babyweightgreaterthan4']) && $_GET['babyweightgreaterthan4'] === '1';
$asthma = isset($_GET['asthma']) && $_GET['asthma'] === '1';
$goiter = isset($_GET['goiter']) && $_GET['goiter'] === '1';
$premacontract = isset($_GET['premacontract']) && $_GET['premacontract'] === '1';
$diabetismellitus = isset($_GET['diabetismellitus']) && $_GET['diabetismellitus'] === '1';
$heart_disease = isset($_GET['heart_disease']) && $_GET['heart_disease'] === '1';
$obese = isset($_GET['obese']) && $_GET['obese'] === '1';

$response = [];


if ($selectOption == "All") {
    foreach ($prenatals as $prenatal) {
        $sql = "SELECT p.address, COUNT(*) AS count FROM prenatal_subjective AS ps 
                INNER JOIN patients AS p ON ps.patient_id = p.id 
                WHERE ps.$prenatal IS NOT NULL AND ps.$prenatal <> 0 AND p.age >= 10";
        $sql .= " GROUP BY p.address";
        $result = $conn->query($sql);
        if ($result === false) {
            die('Query failed: ' . $conn->error);
        }
        while ($row = $result->fetch_assoc()) {
            $zone = $row['address'];
            $zoneCounts[$zone][$prenatal] = $row['count'];
        }
    }
    $response = [
        'zoneCounts' => $zoneCounts
    ];
}
if ($selectOption === "Zonal") {
    if ($forceps) {
        $sql = "SELECT COUNT(*) AS forcep_count FROM prenatal_subjective AS ps 
                INNER JOIN patients AS p ON ps.patient_id = p.id 
                WHERE ps.forceps_delivery IS NOT NULL AND ps.forceps_delivery = 'Yes' AND p.address = '$zone'";

        if ($frmDate && $toDate) {
            $frmDate = $conn->real_escape_string($frmDate);
            $toDate = $conn->real_escape_string($toDate);
            $sql .= " AND ps.checkup_date BETWEEN '$frmDate' AND '$toDate'";
        }

        $result = $conn->query($sql);
        if ($result === false) {
            die('Query failed: ' . $conn->error);
        }
        if ($row = $result->fetch_assoc()) {
            $response['forcepCounts'] = $row['forcep_count'];
        }
    }


    if ($smoking) {
        $sql = "SELECT COUNT(*) AS smoking_count FROM prenatal_subjective AS ps 
                INNER JOIN patients AS p ON ps.patient_id = p.id 
                WHERE ps.smoking IS NOT NULL AND ps.smoking = 'Yes'  AND p.address = '$zone'";

        if ($frmDate && $toDate) {
            $frmDate = $conn->real_escape_string($frmDate);
            $toDate = $conn->real_escape_string($toDate);
            $sql .= " AND ps.checkup_date BETWEEN '$frmDate' AND '$toDate'";
        }
        $result = $conn->query($sql);
        if ($result === false) {
            die('Query failed: ' . $conn->error);
        }
        if ($row = $result->fetch_assoc()) {
            $response['smokingCounts'] = $row['smoking_count'];
        }
    }

    if ($alcohol) {
        $sql = "SELECT COUNT(allergy_alcohol_intake) AS alcohol_count FROM prenatal_subjective AS ps 
                INNER JOIN patients AS p ON ps.patient_id = p.id 
                WHERE ps.allergy_alcohol_intake IS NOT NULL AND ps.allergy_alcohol_intake = 'Yes' AND p.address = '$zone'";

        if ($frmDate && $toDate) {
            $frmDate = $conn->real_escape_string($frmDate);
            $toDate = $conn->real_escape_string($toDate);
            $sql .= " AND ps.checkup_date BETWEEN '$frmDate' AND '$toDate'";
        }

        $result = $conn->query($sql);
        if ($result === false) {
            die('Query failed: ' . $conn->error);
        }
        if ($row = $result->fetch_assoc()) {
            $response['alcoholCounts'] = $row['alcohol_count'];
        }
    }

    if ($cesarean) {
        $sql = "SELECT COUNT(previous_cs) AS cesarean_count FROM prenatal_subjective AS ps 
                INNER JOIN patients AS p ON ps.patient_id = p.id 
                WHERE ps.previous_cs IS NOT NULL AND ps.previous_cs = 'Yes' AND p.address = '$zone'";

        if ($frmDate && $toDate) {
            $frmDate = $conn->real_escape_string($frmDate);
            $toDate = $conn->real_escape_string($toDate);
            $sql .= " AND ps.checkup_date BETWEEN '$frmDate' AND '$toDate'";
        }

        $result = $conn->query($sql);
        if ($result === false) {
            die('Query failed: ' . $conn->error);
        }
        if ($row = $result->fetch_assoc()) {
            $response['cesareanCounts'] = $row['cesarean_count'];
        }
    }

    if ($miscarriages) {
        $sql = "SELECT COUNT(consecutive_miscarriage) AS miscarriages_count FROM prenatal_subjective AS ps 
                INNER JOIN patients AS p ON ps.patient_id = p.id 
                WHERE ps.consecutive_miscarriage IS NOT NULL AND ps.consecutive_miscarriage = 'Yes'  AND p.address = '$zone'";

        if ($frmDate && $toDate) {
            $frmDate = $conn->real_escape_string($frmDate);
            $toDate = $conn->real_escape_string($toDate);
            $sql .= " AND ps.checkup_date BETWEEN '$frmDate' AND '$toDate'";
        }

        $result = $conn->query($sql);
        if ($result === false) {
            die('Query failed: ' . $conn->error);
        }
        if ($row = $result->fetch_assoc()) {
            $response['miscarriagesCounts'] = $row['miscarriages_count'];
        }
    }

    if ($ectopic) {
        $sql = "SELECT COUNT(ectopic_pregnancy_h_mole) AS ectopic_count FROM prenatal_subjective AS ps 
                INNER JOIN patients AS p ON ps.patient_id = p.id 
                WHERE ps.ectopic_pregnancy_h_mole IS NOT NULL AND ps.ectopic_pregnancy_h_mole = 'Yes' AND p.address = '$zone'";

        if ($frmDate && $toDate) {
            $frmDate = $conn->real_escape_string($frmDate);
            $toDate = $conn->real_escape_string($toDate);
            $sql .= " AND ps.checkup_date BETWEEN '$frmDate' AND '$toDate'";
        }

        $result = $conn->query($sql);
        if ($result === false) {
            die('Query failed: ' . $conn->error);
        }
        if ($row = $result->fetch_assoc()) {
            $response['ectopicCounts'] = $row['ectopic_count'];
        }
    }

    if ($postpartumBleed) {
        $sql = "SELECT COUNT(pp_bleeding) AS postpartum_bleed_count FROM prenatal_subjective AS ps 
                INNER JOIN patients AS p ON ps.patient_id = p.id 
                WHERE ps.pp_bleeding IS NOT NULL AND ps.pp_bleeding = 'Yes'  AND p.address = '$zone'";

        if ($frmDate && $toDate) {
            $frmDate = $conn->real_escape_string($frmDate);
            $toDate = $conn->real_escape_string($toDate);
            $sql .= " AND ps.checkup_date BETWEEN '$frmDate' AND '$toDate'";
        }

        $result = $conn->query($sql);
        if ($result === false) {
            die('Query failed: ' . $conn->error);
        }
        if ($row = $result->fetch_assoc()) {
            $response['postpartumBleedCounts'] = $row['postpartum_bleed_count'];
        }
    }

    if ($babyweightgreaterthan4) {
        $sql = "SELECT COUNT(baby_weight_gt_4kgs) AS baby_weight_count FROM prenatal_subjective AS ps 
                INNER JOIN patients AS p ON ps.patient_id = p.id 
                WHERE ps.baby_weight_gt_4kgs IS NOT NULL AND ps.baby_weight_gt_4kgs = 'Yes' AND p.address = '$zone'";

        if ($frmDate && $toDate) {
            $frmDate = $conn->real_escape_string($frmDate);
            $toDate = $conn->real_escape_string($toDate);
            $sql .= " AND ps.checkup_date BETWEEN '$frmDate' AND '$toDate'";
        }

        $result = $conn->query($sql);
        if ($result === false) {
            die('Query failed: ' . $conn->error);
        }
        if ($row = $result->fetch_assoc()) {
            $response['babyWeightCounts'] = $row['baby_weight_count'];
        }
    }

    if ($asthma) {
        $sql = "SELECT COUNT(asthma) AS asthma_count FROM prenatal_subjective AS ps 
                INNER JOIN patients AS p ON ps.patient_id = p.id 
                WHERE ps.asthma IS NOT NULL AND ps.asthma = 'Yes' AND p.address = '$zone'";

        if ($frmDate && $toDate) {
            $frmDate = $conn->real_escape_string($frmDate);
            $toDate = $conn->real_escape_string($toDate);
            $sql .= " AND ps.checkup_date BETWEEN '$frmDate' AND '$toDate'";
        }

        $result = $conn->query($sql);
        if ($result === false) {
            die('Query failed: ' . $conn->error);
        }
        if ($row = $result->fetch_assoc()) {
            $response['asthmaCounts'] = $row['asthma_count'];
        }
    }

    if ($goiter) {
        $sql = "SELECT COUNT(goiter) AS goiter_count FROM prenatal_subjective AS ps 
                INNER JOIN patients AS p ON ps.patient_id = p.id 
                WHERE ps.goiter IS NOT NULL AND ps.goiter = 'Yes' AND p.address = '$zone'";

        if ($frmDate && $toDate) {
            $frmDate = $conn->real_escape_string($frmDate);
            $toDate = $conn->real_escape_string($toDate);
            $sql .= " AND ps.checkup_date BETWEEN '$frmDate' AND '$toDate'";
        }

        $result = $conn->query($sql);
        if ($result === false) {
            die('Query failed: ' . $conn->error);
        }
        if ($row = $result->fetch_assoc()) {
            $response['goiterCounts'] = $row['goiter_count'];
        }
    }

    if ($premacontract) {
        $sql = "SELECT COUNT(premature_contraction) AS premacontract_count FROM prenatal_subjective AS ps 
                INNER JOIN patients AS p ON ps.patient_id = p.id 
                WHERE ps.premature_contraction IS NOT NULL AND ps.premature_contraction = 'Yes' AND p.age >= 14 AND p.address = '$zone'";

        if ($frmDate && $toDate) {
            $frmDate = $conn->real_escape_string($frmDate);
            $toDate = $conn->real_escape_string($toDate);
            $sql .= " AND ps.checkup_date BETWEEN '$frmDate' AND '$toDate'";
        }

        $result = $conn->query($sql);
        if ($result === false) {
            die('Query failed: ' . $conn->error);
        }
        if ($row = $result->fetch_assoc()) {
            $response['premacontractCounts'] = $row['premacontract_count'];
        }
    }

    if ($diabetismellitus) {
        $sql = "SELECT COUNT(dm) AS diabetismellitus_count FROM prenatal_subjective AS ps 
                INNER JOIN patients AS p ON ps.patient_id = p.id 
                WHERE ps.dm IS NOT NULL AND ps.dm = 'Yes' AND p.address = '$zone'";

        if ($frmDate && $toDate) {
            $frmDate = $conn->real_escape_string($frmDate);
            $toDate = $conn->real_escape_string($toDate);
            $sql .= " AND ps.checkup_date BETWEEN '$frmDate' AND '$toDate'";
        }

        $result = $conn->query($sql);
        if ($result === false) {
            die('Query failed: ' . $conn->error);
        }
        if ($row = $result->fetch_assoc()) {
            $response['diabetismellitusCounts'] = $row['diabetismellitus_count'];
        }
    }

    if ($heart_disease) {
        $sql = "SELECT COUNT(heart_disease) AS heart_disease_count FROM prenatal_subjective AS ps 
                INNER JOIN patients AS p ON ps.patient_id = p.id 
                WHERE ps.heart_disease IS NOT NULL AND ps.heart_disease = 'Yes' AND p.address = '$zone'";

        if ($frmDate && $toDate) {
            $frmDate = $conn->real_escape_string($frmDate);
            $toDate = $conn->real_escape_string($toDate);
            $sql .= " AND ps.checkup_date BETWEEN '$frmDate' AND '$toDate'";
        }

        $result = $conn->query($sql);
        if ($result === false) {
            die('Query failed: ' . $conn->error);
        }
        if ($row = $result->fetch_assoc()) {
            $response['heartDiseaseCounts'] = $row['heart_disease_count'];
        }
    }

    if ($obese) {
        $sql = "SELECT COUNT(obesity) AS obese_count FROM prenatal_subjective AS ps 
                INNER JOIN patients AS p ON ps.patient_id = p.id 
                WHERE ps.obesity IS NOT NULL AND ps.obesity = 'Yes' AND p.address = '$zone'";

        if ($frmDate && $toDate) {
            $frmDate = $conn->real_escape_string($frmDate);
            $toDate = $conn->real_escape_string($toDate);
            $sql .= " AND ps.checkup_date BETWEEN '$frmDate' AND '$toDate'";
        }

        $result = $conn->query($sql);
        if ($result === false) {
            die('Query failed: ' . $conn->error);
        }
        if ($row = $result->fetch_assoc()) {
            $response['obeseCounts'] = $row['obese_count'];
        }
    }
}


// Set the content type to JSON
header('Content-Type: application/json');

// Echo the response as JSON
echo json_encode($response);
