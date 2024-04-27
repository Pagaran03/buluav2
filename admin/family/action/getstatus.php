<?php
require ("../../../config.php");

if (isset($_POST['status'])) {

    $status = $_POST['status'];

    if ($status == 'All') {
        $sql = "SELECT *,fp_information.id as id,CONCAT(patients.last_name,' ',patients.first_name) as full_name,nurses.first_name as first_name2,nurses.last_name as last_name2, fp_obstetrical_history.fp_information_id as fp_information_id
        FROM fp_information
        JOIN patients ON fp_information.patient_id = patients.id
        JOIN fp_consultation ON fp_consultation.fp_information_id = fp_information.id
        JOIN fp_obstetrical_history ON fp_information.id =  fp_obstetrical_history.fp_information_id
        JOIN nurses ON fp_information.nurse_id = nurses.id";
    } else {
        $sql = "SELECT *,fp_information.id as id,CONCAT(patients.last_name,' ',patients.first_name) as full_name,nurses.first_name as first_name2,nurses.last_name as last_name2, fp_obstetrical_history.fp_information_id as fp_information_id
        FROM fp_information
        JOIN patients ON fp_information.patient_id = patients.id
        JOIN fp_consultation ON fp_consultation.fp_information_id = fp_information.id
        JOIN fp_obstetrical_history ON fp_information.id =  fp_obstetrical_history.fp_information_id
        JOIN nurses ON fp_information.nurse_id = nurses.id WHERE status = '$status'
        GROUP BY full_name";
    }

    // Execute the SQL query
    $result = $conn->query($sql);

    // Check if query was successful
    if ($result) {
        // Check if there are rows returned
        if ($result->num_rows > 0) {
            // Initialize an empty string to store the HTML table rows
            $tableRows = '';

            // Fetch data from the result set
            while ($row = $result->fetch_assoc()) {
                // Append HTML table row for each fetched row
                $tableRows .= '<tr>';
                $tableRows .= '<td class="align-middle tago">' . $row['id'] . '</td>';
                $tableRows .= '<td class="align-middle">' . $row['serial_no'] . '</td>';
                $tableRows .= '<td class="align-middle">' . $row['full_name'] . '</td>';
                $tableRows .= '<td class="align-middle">' . $row['checkup_date'] . '</td>';
                $tableRows .= '<td class="align-middle">' . $row['status'] . '</td>';
                $tableRows .= '<td class="align-middle tago">' . $row['patient_id'] . '</td>';
                $tableRows .= '<td class="align-middle">';
                $tableRows .= '<a href="history_consultation.php?patient_id=' . $row['patient_id'] . '"><button type="button" class="btn btn-warning ml-1">View History</button></a>';
                $tableRows .= '<button type="button" class="btn btn-info editbtn" data-row-id="' . $row['id'] . '"><i class="fas fa-eye"></i> View Record</button>';
                $tableRows .= '<button type="button" class="btn btn-success editbtn2" data-row-id="' . $row['id'] . '"><i class="fas fa-edit"></i> Add Consultation</button>';
                $tableRows .= '<button type="button" class="btn btn-danger deletebtn" data-id="' . $row['id'] . '"><i class="fas fa-trash"></i> Delete</button>';
                $tableRows .= '</td>';
                $tableRows .= '</tr>';
            }

            echo $tableRows;
        } else {

            echo "<tr><td colspan='6'>No data found</td></tr>";
        }
    } else {
        // Handle query error
        echo "Error: " . $conn->error;
    }
} else {
    // Handle if 'status' key is not set in $_POST
    echo "No status received.";
}

// Close the database connection
$conn->close();
?>