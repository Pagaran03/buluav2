<?php
session_start();
include_once('../../../config.php'); // Ensure this file correctly sets up $conn

if (isset($_GET['patient_id'])) {
    $patient_id = $_GET['patient_id'];

    $date_fields = [
        'bgc_date' => 'BCG Vaccine',
        'hepa_date' => 'Hepatitis B Vaccine',
        'pentavalent_date1' => 'Pentavalent Vaccine Dose 1',
        'pentavalent_date2' => 'Pentavalent Vaccine Dose 2',
        'pentavalent_date3' => 'Pentavalent Vaccine Dose 3',
        'oral_date1' => 'Oral Polio Vaccine Dose 1',
        'oral_date2' => 'Oral Polio Vaccine Dose 2',
        'oral_date3' => 'Oral Polio Vaccine Dose 3',
        'ipv_date1' => 'Inactivated Polio Vaccine Dose 1',
        'ipv_date2' => 'Inactivated Polio Vaccine Dose 2',
        'pcv_date1' => 'Pneumococcal Conjugate Vaccine Dose 1',
        'pcv_date2' => 'Pneumococcal Conjugate Vaccine Dose 2',
        'pcv_date3' => 'Pneumococcal Conjugate Vaccine Dose 3',
        'mmr_date1' => 'Measles, Mumps, Rubella Vaccine Dose 1',
        'mmr_date2' => 'Measles, Mumps, Rubella Vaccine Dose 2',
        'MCV_1' => 'Measles Containing Vaccine Dose 1',
        'MCV_2' => 'Measles Containing Vaccine Dose 2'
    ];

    $where_conditions = [];
    foreach ($date_fields as $field => $label) {
        $where_conditions[] = "($field IS NULL OR $field = '0000-00-00')";
    }

    $where_clause = implode(' OR ', $where_conditions);

    $sql = "
        SELECT 
            " . implode(", ", array_keys($date_fields)) . " 
        FROM 
            `immunization` 
        WHERE 
            `id` = ? AND ($where_clause)
    ";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('Prepare failed: ' . $conn->error);
    }

    $stmt->bind_param('s', $patient_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $data = [];
    if ($row = $result->fetch_assoc()) {
        foreach ($date_fields as $field => $label) {
            if (is_null($row[$field]) || $row[$field] === '0000-00-00') {
                $data[] = $label;
            }
        }
    }

    echo json_encode($data);

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['error' => 'No patient_id provided']);
}
?>
