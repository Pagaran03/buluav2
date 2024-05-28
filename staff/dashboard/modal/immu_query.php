<?php
// Include the database connection file
include('../../../config.php'); // Replace with your actual database connection file

// Function to return error messages as JSON
function returnError($message)
{
  header('Content-Type: application/json');
  echo json_encode(['error' => $message]);
  exit();
}

// Ensure the connection is successful
if ($conn->connect_error) {
  returnError('Database connection failed: ' . $conn->connect_error);
}

$columns = [
  'bgc_date', 'hepa_date', 'pentavalent_date1', 'pentavalent_date2', 'pentavalent_date3',
  'oral_date1', 'oral_date2', 'oral_date3', 'ipv_date1', 'ipv_date2',
  'pcv_date1', 'pcv_date2', 'pcv_date3', 'mmr_date1', 'mmr_date2',
  'mcv_1', 'mcv_2'
];

// Initialize an array to store the counts
$countss = [];

// Date filter variables
$frmDate = isset($_GET['frmDate']) ? $_GET['frmDate'] : null;
$toDate = isset($_GET['toDate']) ? $_GET['toDate'] : null;
$selectOption = isset($_GET['selectOption']) ? $_GET['selectOption'] : null;

if ($selectOption === 'Date') {
  foreach ($columns as $column) {
    // Construct the SQL query with date filtering
    $sql = "SELECT COUNT(*) AS count FROM immunization WHERE $column IS NOT NULL AND $column <> '0000-00-00'";

    // Add date range filtering if provided
    if (!empty($frmDate) && !empty($toDate)) {
      $sql .= " AND $column BETWEEN '$frmDate' AND '$toDate'";
    }

    $result = $conn->query($sql);

    if ($result === false) {
      returnError('Query failed: ' . $conn->error);
    }

    $row = $result->fetch_assoc();
    $countss[] = $row['count'];
  }
} elseif ($selectOption === 'Gender') {
  // Fetch counts based on gender
  $sqlMale = "SELECT COUNT(*) AS count FROM immunization INNER JOIN patients ON immunization.patient_id = patients.id WHERE patients.gender = 'Male'";
  $sqlFemale = "SELECT COUNT(*) AS count FROM immunization INNER JOIN patients ON immunization.patient_id = patients.id WHERE patients.gender = 'Female'";

  $resultMale = $conn->query($sqlMale);
  $resultFemale = $conn->query($sqlFemale);

  if ($resultMale === false || $resultFemale === false) {
    returnError('Query failed: ' . $conn->error);
  }

  $rowMale = $resultMale->fetch_assoc();
  $rowFemale = $resultFemale->fetch_assoc();

  $countss = [$rowMale['count'], $rowFemale['count']];
}

if($selectOption === 'MAV'){

}

// Output $countss array as JSON for JavaScript use
header('Content-Type: application/json');
echo json_encode($countss);
?>
