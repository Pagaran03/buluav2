<?php
require '../../vendor/autoload.php'; // Include Dompdf's autoloader
include_once('../../config.php');

use Dompdf\Dompdf;
use Dompdf\Options;

// Retrieve the consultation ID from the GET request
$id = $_GET['id'];

// Create SQL query to fetch consultation details
$sql = "SELECT 
            *, 
            superadmins.first_name as d_first_name, 
            superadmins.last_name as d_last_name, 
            patients.first_name as p_first_name, 
            patients.last_name as p_last_name 
        FROM consultations 
        JOIN patients ON patients.id = consultations.patient_id
        JOIN superadmins ON superadmins.id = consultations.doctor_id
        WHERE consultations.id = $id"; 

// Create a new Dompdf instance
$options = new Options();
$options->set('isRemoteEnabled', true); // Enable loading of remote content
$pdf = new Dompdf($options);

// Set PDF options, like paper size and orientation
$pdf->setPaper('A4', 'portrait');

// Fetch patient data using MySQLi (assuming you have a $conn object)
$result = $conn->query($sql);

// Convert image to base64
$imagePath = '../../assets/images/rx.jpg';
$imageData = base64_encode(file_get_contents($imagePath));
$imageSrc = 'data:image/jpeg;base64,' . $imageData;

// Get current date
$currentDate = date("Y-m-d");

// Generate the HTML content for the PDF
$htmlContent = '<html>
<head></head>
<body>
<h2>Prescription</h2>

<br>
<img src="' . $imageSrc . '" width="140" height="140">

';

$evenRow = false; // Initialize the even row status
$rowNumber = 1;  // Initialize the row number

while ($row = $result->fetch_assoc()) {
    $rowColorStyle = $evenRow ? 'background-color: #f2f2f2;' : '';
    $htmlContent .= '<div style="border: 1px solid #dddddd; padding: 10px; margin: 10px; ' . $rowColorStyle . '">
    <p><strong>Patient Name:</strong> ' . $row['p_first_name'] .' ' . $row['p_last_name'] .'</p>
    <p><strong>Patient Address:</strong> ' . $row['address'] .'</p>
    <p><strong>Patient Serial No:</strong> ' . $row['serial_no'] .'</p>
    <br>
    <p><strong>Description:</strong> ' . $row['description'] . '</p>
    <p><strong>Diagnosis:</strong> ' . $row['diagnosis'] . '</p>
    <p><strong>Medicine:</strong> ' . $row['medicine'] . '</p>
    <p><b>Date: ' . $currentDate . '</b></p>

    
    <div style="float: right;">
        <p>
    <hr style="clear: both; border: none; border-top: 2px solid #000; width: 100%;">
        <strong>Doctor:</strong> ' . $row['d_first_name'] .' '. $row['d_last_name'] . '</p>
    </div>
    
</div>';

    // Update the consultation record to mark it as printed
    $updateIsPrintSql = "UPDATE consultations SET is_print = 1 WHERE id = ?";
    $updateIsPrintStmt = $conn->prepare($updateIsPrintSql);
    $updateIsPrintStmt->bind_param("i", $id);
    $updateIsPrintStmt->execute();

    $evenRow = !$evenRow; // Toggle the row color for alternation
}

$htmlContent .= '</body></html>';

// Load HTML content into Dompdf
$pdf->loadHtml($htmlContent);

// Render the HTML to PDF
$pdf->render();

// Generate the PDF and trigger a download
$pdfData = $pdf->output();
file_put_contents('prescription.pdf', $pdfData);
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="prescription.pdf"');
readfile('prescription.pdf');
?>
