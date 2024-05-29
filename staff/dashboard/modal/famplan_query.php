<?php
include('../../../config.php'); // Include your database connection or configuration file

// Fetch parameters from GET request
$selectOption = isset($_GET['selectOption']) ? $_GET['selectOption'] : null;
$frmDate = isset($_GET['frmDatefp']) ? $_GET['frmDatefp'] : null;
$toDate = isset($_GET['toDatefp']) ? $_GET['toDatefp'] : null;
$zone = isset($_GET['zone']) ? $_GET['zone'] : null;

// Initialize arrays to store the counts
$methodCounts = [];
$maleCounts = [];
$femaleCounts = [];

// Define the methods you want to count
$methodsToCount = ['BTL', 'NSV', 'condom', 'Pills-POP', 'Pills', 'Pills-COC', 'Injectables (DMPA/POI)', 'Implant', 'Hormonal IUD', 'IUD', 'IUD-I', 'IUD-PP', 'NFP-LAM', 'NFP-BBT', 'NFP-CMM', 'NFP-STM', 'NFP-SDM'];

// Check if selectOption is "Date" and set default dates to current month if not provided
if ($selectOption === "Date" && (!$frmDate || !$toDate)) {
    $currentMonth = date('Y-m'); // Get current year and month
    $frmDate = $currentMonth . '-01'; // Start from the first day of the current month
    $toDate = date('Y-m-t', strtotime($currentMonth)); // End at the last day of the current month
}

if ($selectOption === "MAFP") {
    $methods = [
        "BTL", "NSV", "condom", "Pills-POP", "Pills", "Pills-COC",
        "Injectables (DMPA/POI)", "Implant", "Hormonal IUD", "IUD",
        "IUD-I", "IUD-PP", "NFP-LAM", "NFP-BBT", "NFP-CMM", "NFP-STM", "NFP-SDM"
    ];
    $methodCounts = [];

    foreach ($methods as $method) {
        $sqlMethodZone = "SELECT COUNT(*) AS count 
                          FROM fp_consultation 
                          INNER JOIN patients ON fp_consultation.patient_id = patients.id 
                          WHERE method = ? 
                            AND patients.address = ? 
                            AND fp_consultation.checkup_date BETWEEN ? AND ?";

        $stmt = $conn->prepare($sqlMethodZone);
        $stmt->bind_param("ssss", $method, $zone, $frmDate, $toDate);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result === false) {
            die("Query failed: " . $conn->error);
        }

        $row = $result->fetch_assoc();
        $count = $row ? $row['count'] : 0;
        $methodCounts[$method] = $count;
    }

    // Sort the methods by count in descending order and get the top 5
    arsort($methodCounts);
    $topMethods = array_slice($methodCounts, 0, 5, true);

    echo json_encode(['zone' => $zone, 'count' => $topMethods]);
    exit();
}

// Iterate over each method and fetch the count for Date and Gender options
foreach ($methodsToCount as $methodToCount) {
    // Construct the SQL query to count occurrences of the method
    $sqlMethod = "SELECT COUNT(*) AS count FROM fp_consultation INNER JOIN patients ON fp_consultation.patient_id = patients.id WHERE method = '$methodToCount'";

    // Add additional filters based on selectOption, frmDate, toDate, and zone
    if ($selectOption === "Date" && $frmDate && $toDate) {
        $sqlMethod .= " AND checkup_date BETWEEN '$frmDate' AND '$toDate'";
    } elseif ($selectOption === 'Gender') {
        // Fetch counts based on gender and zone
        $sqlMale = "SELECT COUNT(*) AS count FROM fp_consultation INNER JOIN patients ON fp_consultation.patient_id = patients.id WHERE patients.gender = 'Male' AND patients.address = '$zone' AND method = '$methodToCount' AND fp_consultation.checkup_date BETWEEN '$frmDate' AND '$toDate'";
        $sqlFemale = "SELECT COUNT(*) AS count FROM fp_consultation INNER JOIN patients ON fp_consultation.patient_id = patients.id WHERE patients.gender = 'Female' AND patients.address = '$zone' AND method = '$methodToCount' AND fp_consultation.checkup_date BETWEEN '$frmDate' AND '$toDate'";

        // Execute queries for male and female counts
        $resultMale = $conn->query($sqlMale);
        $resultFemale = $conn->query($sqlFemale);

        if ($resultMale === false || $resultFemale === false) {
            die("Query failed: " . $conn->error);
        }

        // Fetch the counts from the results
        $rowMale = $resultMale->fetch_assoc();
        $rowFemale = $resultFemale->fetch_assoc();

        // Store male and female counts for each method
        $maleCounts[$methodToCount] = $rowMale['count'];
        $femaleCounts[$methodToCount] = $rowFemale['count'];
    }

    // Execute query for method count
    $resultMethod = $conn->query($sqlMethod);

    if ($resultMethod === false) {
        die("Query failed: " . $conn->error);
    }

    // Fetch the count from the result
    $rowMethod = $resultMethod->fetch_assoc();
    $countMethod = $rowMethod ? $rowMethod['count'] : 0;

    // Store count with method as key
    $methodCounts[$methodToCount] = $countMethod;
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
} elseif ($selectOption === "MAFP") {
    // The MAFP part is handled separately above
}

// Output response as JSON
header('Content-Type: application/json');
echo json_encode($responseData);
?>
