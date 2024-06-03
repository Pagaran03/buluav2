<?php
include('../../../config.php');

// Set default values if parameters are not provided
$selectOption = isset($_GET['selectOption']) ? $_GET['selectOption'] : 'Date';
$frmDate = isset($_GET['frmDatefp']) ? $_GET['frmDatefp'] : null;
$toDate = isset($_GET['toDatefp']) ? $_GET['toDatefp'] : null;
$zone = isset($_GET['zone']) ? $_GET['zone'] : 'Zone 1';

// Define method array
$methods = [
    'BTL', 'NSV', 'condom', 'Pills-POP', 'Pills', 'Pills-COC', 'Injectables (DMPA/POI)', 
    'Implant', 'Hormonal IUD', 'IUD', 'IUD-I', 'IUD-PP', 'NFP-LAM', 'NFP-BBT', 
    'NFP-CMM', 'NFP-STM', 'NFP-SDM'
];

// Set default date range if not provided
if (($selectOption === "Date" || $selectOption === 'Gender') && (!$frmDate || !$toDate)) {
    $currentMonth = date('Y-m');
    $frmDate = $currentMonth . '-01';
    $toDate = date('Y-m-t', strtotime($currentMonth));
}

// Prepare to collect method counts
$methodCounts = [];
$maleCounts = [];
$femaleCounts = [];

// Function to execute and fetch count
function getCount($conn, $sql, $params = []) {
    $stmt = $conn->prepare($sql);
    if (!empty($params)) {
        $stmt->bind_param(str_repeat('s', count($params)), ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result === false) {
        die("Query failed: " . $conn->error);
    }
    $row = $result->fetch_assoc();
    return $row ? $row['count'] : 0;
}

// Handle the MAFP case
if ($selectOption === "MAFP") {
    foreach ($methods as $method) {
        $sqlMethodZone = "
            SELECT COUNT(*) AS count 
            FROM fp_consultation 
            INNER JOIN patients ON fp_consultation.patient_id = patients.id 
            WHERE method = ? 
              AND patients.address = ? 
              AND MONTH(checkup_date) = MONTH(CURDATE() + 1) 
              AND YEAR(checkup_date) = YEAR(CURDATE())
        ";
        $methodCounts[$method] = getCount($conn, $sqlMethodZone, [$method, $zone]);
    }
    arsort($methodCounts);
    $topMethods = array_slice($methodCounts, 0, 5, true);
    echo json_encode(['zone' => $zone, 'count' => $topMethods]);
    exit();
}

// Handle general method counting
foreach ($methods as $methodToCount) {
    $sqlMethod = "
        SELECT COUNT(*) AS count 
        FROM fp_consultation 
        INNER JOIN patients ON fp_consultation.patient_id = patients.id 
        WHERE method = ?
    ";

    // Add additional filters based on selectOption, frmDate, toDate, and zone
    $params = [$methodToCount];
    if ($selectOption === "Date" && $frmDate && $toDate) {
        $sqlMethod .= " AND checkup_date BETWEEN ? AND ?";
        array_push($params, $frmDate, $toDate);
    } elseif ($selectOption === 'Gender') {
        // Fetch counts based on gender and zone
        $sqlMale = $sqlMethod . " AND patients.gender = 'Male' AND patients.address = ? AND checkup_date BETWEEN ? AND ?";
        $sqlFemale = $sqlMethod . " AND patients.gender = 'Female' AND patients.address = ? AND checkup_date BETWEEN ? AND ?";
        
        $maleCounts[$methodToCount] = getCount($conn, $sqlMale, array_merge($params, [$zone, $frmDate, $toDate]));
        $femaleCounts[$methodToCount] = getCount($conn, $sqlFemale, array_merge($params, [$zone, $frmDate, $toDate]));
    }

    // Execute query for method count
    if ($selectOption !== 'Gender') {
        $methodCounts[$methodToCount] = getCount($conn, $sqlMethod, $params);
    }
}

// Prepare response array based on selectOption
$responseData = [];
if ($selectOption === "Date") {
    $responseData = [
        'methods' => $methodCounts
    ]; // For date option, send method counts
} elseif ($selectOption === 'Gender') {
    $responseData = [
        'male' => $maleCounts,
        'female' => $femaleCounts
    ]; // For gender option, send male and female counts
}

// Output response as JSON
header('Content-Type: application/json');
echo json_encode($responseData);
?>
