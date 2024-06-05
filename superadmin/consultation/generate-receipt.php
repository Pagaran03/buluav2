<?php
require '../../vendor/autoload.php'; // Include Dompdf's autoloader
include_once('../../config.php');

use Dompdf\Dompdf;
use Dompdf\Options;

// Retrieve the consultation ID from the GET request
$id = $_GET['id'];
$dateNow = date("Y/m/d");
// Create SQL query to fetch consultation details
$sql = "SELECT 
            *, 
            superadmins.first_name as d_first_name, 
            superadmins.last_name as d_last_name, 
            patients.first_name as p_first_name, 
            patients.last_name as p_last_name,
            patients.address as p_address,
            patients.age as p_age
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
$htmlContent = '
<div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="bg-white shadow-lg rounded p-5">
                    <div class="row mb-4">
                        <img class="float-right" style="width: 100px; height: auto; margin-left: 80%;" src= ' . $imageSrc . ' alt="Doctor">
                       
                    </div>
                    <h1 class="text-center mb-4">Doctor`s Prescription</h1>

';

$evenRow = false; // Initialize the even row status
$rowNumber = 1;  // Initialize the row number

while ($row = $result->fetch_assoc()) {
    $rowColorStyle = $evenRow ? 'background-color: #f2f2f2;' : '';
    $htmlContent .= '<div style=" padding: 10px; margin: 10px; ' . $rowColorStyle . '">
    <div class="row mb-4">
                        <div class="col-sm">
                            <p class="text-sm"><span class="font-weight-bold">Patient Name:</span> ' . $row['p_first_name'] . ' ' . $row['p_last_name'] . '</p>
                            <p class="text-sm"><span class="font-weight-bold">Age:</span> ' . $row['p_age'] . '</p>
                            <p class="text-sm"><span class="font-weight-bold">Date:</span> ' . $dateNow . '</p>
                        </div>
                        <div class="col-sm">
                            <p class="text-sm"><span class="font-weight-bold">Doctor Name:</span> ' . $row['d_first_name'] . ' ' . $row['d_last_name'] . '</p>
                            <p class="text-sm"><span class="font-weight-bold">License No:</span> '. $row['license_number'] .'</p>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-center font-weight-bold mb-3">Medications:<p>'. $row['medicine'] .'</p></h2>
                    </div>
                </div>
            </div>
        </div>
        </br>
        </br>
        </br>
        </br>
        </br>
        </br>
        </br>
        </br>
        </br>
        </br>
        </br>
        </br>
        </br>
        </br>
        </br>
        </br>
        </br>
        </br>
        </br>
        </br>
        </br>
        <hr style="width: 50%; margin-top 100%;"></hr>
        <center><label>Doctor`s Signature</label></center>
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

// Get the PDF content
$pdfContent = $pdf->output();

// Send the appropriate headers for a PDF file
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="patients_report.pdf"');

// Output the PDF content
echo $pdfContent;

// Close the connection
$conn->close();

// Script to open PDF in a new tab
echo '<script>
var blob = new Blob([' . json_encode($pdfContent) . '], {type: "application/pdf"});
var url = URL.createObjectURL(blob);
window.open(url, "_blank");
</script>';
