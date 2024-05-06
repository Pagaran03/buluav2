<?php
require '../../vendor/autoload.php'; 
include_once ('../../config.php');

$sql = "SELECT * FROM patients"; 

use Dompdf\Dompdf;
use Dompdf\Options;

$pdf = new Dompdf();

$pdf->setPaper('A4', 'landscape');

$result = $conn->query($sql);


$evenRow = false;
$rowNumber = 1;


$htmlContent = '<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Immunization Report</title>
    <style>
    /* Add CSS styles for the table */
    table {
        border-collapse: collapse;
        width: 100%;
        border: 1px solid #000;
    }

    td,
    th {
        border: 1px solid #000;
        /* Border for table cells */
        padding: 8px;
        text-align: center;
    }
</style>
    
</head>

<body>
<table style="width: 100%; margin-left: auto; margin-right: auto;" border="1" cellspacing="5">
    <tbody>
        <tr>
            <td style="width: 25%;">Indicators</td>
            <td style="width: 10%;">Eligible Population</td>
            <td style="width: 10%;">Male</td>
            <td style="width: 10%;">Female</td>
            <td style="width: 10%;">Total</td>
            <td style="width: 10%;">Counts</td>
            <td style="width: 10%;">% (Col.5E.Pop * 100)</td>
            <td style="width: 15%;">Interpretation</td>
            <td style="width: 15%;">Recommendation Action to be taken</td>
        </tr>
        <tr>
            <td>C1 . Immunization Services for Newborns, Infants and School-Aged Children/Adolescents</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>1.CPAB - Total</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>2. BGC - Total</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>3.HepB, within 24 Hours - Total</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>4. DPT HiB-HebB 1 - Total</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>5. DPT HiB-HebB 2 - Total</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>6. DPT HiB-HebB 3 - Total</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>7. OPV 1 - Total</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>8. OPV 2 - Total</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>9. OPV 3 - Total</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>10. IPV - Total</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>11. PCV1 - Total</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>12. PCV2 - Total</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>13. PCV3 - Total</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>14. MCV 1 - Total</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>15. MCV 2 - Total</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>16. FIC - Total</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>17. CIC - Total</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table>

</body>

</html>';


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
?>