<?php
require '../../vendor/autoload.php';
include_once('../../config.php');

$sql = "SELECT * FROM patients";


//1. NO CPAB YET
// $CPAB_Count = "SELECT COUNT(*) FROM "

// Combined query
$sql = "
    SELECT
        COUNT(bgc_date) AS bcg_count,
        COUNT(hepa_date) AS hepB_count,
        COUNT(pentavalent_date1) AS dpt1_count,
        COUNT(pentavalent_date2) AS dpt2_count,
        COUNT(pentavalent_date3) AS dpt3_count,
        COUNT(oral_date1) AS opv1_count,
        COUNT(oral_date2) AS opv2_count,
        COUNT(oral_date3) AS opv3_count,
        COUNT(ipv_date1) AS ipv1_count,
        COUNT(ipv_date2) AS ipv2_count,
        COUNT(pcv_date1) AS pcv1_count,
        COUNT(pcv_date2) AS pcv2_count,
        COUNT(pcv_date3) AS pcv3_count
      
    FROM immunization";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $bcgCount = $row['bcg_count'];
    $hepBCount = $row['hepB_count'];
    $dpt1Count = $row['dpt1_count'];
    $dpt2Count = $row['dpt2_count'];
    $dpt3Count = $row['dpt3_count'];
    $opv1Count = $row['opv1_count'];
    $opv2Count = $row['opv2_count'];
    $opv3Count = $row['opv3_count'];
    $ipv1Count = $row['ipv1_count'];
    $ipv2Count = $row['ipv2_count'];
    $pcv1Count = $row['pcv1_count'];
    $pcv2Count = $row['pcv2_count'];
    $pcv3Count = $row['pcv3_count'];
} else {
    // Handle the case where no data is returned, if necessary
    $bcgCount = $hepBCount = $dpt1Count = $dpt2Count = $dpt3Count = 0;
    $opv1Count = $opv2Count = $opv3Count = $ipv1Count = $ipv2Count = 0;
    $pcv1Count = $pcv2Count = $pcv3Count = 0;
}


$gender_sql_male = "
    SELECT
        COUNT(bgc_date) AS bcg_count,
        COUNT(hepa_date) AS hepB_count,
        COUNT(pentavalent_date1) AS dpt1_count,
        COUNT(pentavalent_date2) AS dpt2_count,
        COUNT(pentavalent_date3) AS dpt3_count,
        COUNT(oral_date1) AS opv1_count,
        COUNT(oral_date2) AS opv2_count,
        COUNT(oral_date3) AS opv3_count,
        COUNT(ipv_date1) AS ipv1_count,
        COUNT(ipv_date2) AS ipv2_count,
        COUNT(pcv_date1) AS pcv1_count,
        COUNT(pcv_date2) AS pcv2_count,
        COUNT(pcv_date3) AS pcv3_count
    FROM immunization
    JOIN patients ON immunization.id = patients.id
    WHERE patients.gender = 'male'";

$result = $conn->query($gender_sql_male);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $male_bcgCount = $row['bcg_count'];
    $male_hepBCount = $row['hepB_count'];
    $male_dpt1Count = $row['dpt1_count'];
    $male_dpt2Count = $row['dpt2_count'];
    $male_dpt3Count = $row['dpt3_count'];
    $male_opv1Count = $row['opv1_count'];
    $male_opv2Count = $row['opv2_count'];
    $male_opv3Count = $row['opv3_count'];
    $male_ipv1Count = $row['ipv1_count'];
    $male_ipv2Count = $row['ipv2_count'];
    $male_pcv1Count = $row['pcv1_count'];
    $male_pcv2Count = $row['pcv2_count'];
    $male_pcv3Count = $row['pcv3_count'];
} else {
    $male_bcgCount = $male_hepBCount = $male_dpt1Count = $male_dpt2Count = $male_dpt3Count = 0;
    $male_opv1Count = $male_opv2Count = $male_opv3Count = $male_ipv1Count = $male_ipv2Count = 0;
    $male_pcv1Count = $male_pcv2Count = $male_pcv3Count = 0;
}

$gender_sql_male = "
    SELECT
        COUNT(bgc_date) AS bcg_count,
        COUNT(hepa_date) AS hepB_count,
        COUNT(pentavalent_date1) AS dpt1_count,
        COUNT(pentavalent_date2) AS dpt2_count,
        COUNT(pentavalent_date3) AS dpt3_count,
        COUNT(oral_date1) AS opv1_count,
        COUNT(oral_date2) AS opv2_count,
        COUNT(oral_date3) AS opv3_count,
        COUNT(ipv_date1) AS ipv1_count,
        COUNT(ipv_date2) AS ipv2_count,
        COUNT(pcv_date1) AS pcv1_count,
        COUNT(pcv_date2) AS pcv2_count,
        COUNT(pcv_date3) AS pcv3_count
    FROM immunization
    JOIN patients ON immunization.id = patients.id
    WHERE patients.gender = 'Male'";

$result = $conn->query($gender_sql_male);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $male_bcgCount = $row['bcg_count'];
    $male_hepBCount = $row['hepB_count'];
    $male_dpt1Count = $row['dpt1_count'];
    $male_dpt2Count = $row['dpt2_count'];
    $male_dpt3Count = $row['dpt3_count'];
    $male_opv1Count = $row['opv1_count'];
    $male_opv2Count = $row['opv2_count'];
    $male_opv3Count = $row['opv3_count'];
    $male_ipv1Count = $row['ipv1_count'];
    $male_ipv2Count = $row['ipv2_count'];
    $male_pcv1Count = $row['pcv1_count'];
    $male_pcv2Count = $row['pcv2_count'];
    $male_pcv3Count = $row['pcv3_count'];
} else {
    $male_bcgCount = $male_hepBCount = $male_dpt1Count = $male_dpt2Count = $male_dpt3Count = 0;
    $male_opv1Count = $male_opv2Count = $male_opv3Count = $male_ipv1Count = $male_ipv2Count = 0;
    $male_pcv1Count = $male_pcv2Count = $male_pcv3Count = 0;
}

$gender_sql_female = "
SELECT
    COUNT(bgc_date) AS bcg_count,
    COUNT(hepa_date) AS hepB_count,
    COUNT(pentavalent_date1) AS dpt1_count,
    COUNT(pentavalent_date2) AS dpt2_count,
    COUNT(pentavalent_date3) AS dpt3_count,
    COUNT(oral_date1) AS opv1_count,
    COUNT(oral_date2) AS opv2_count,
    COUNT(oral_date3) AS opv3_count,
    COUNT(ipv_date1) AS ipv1_count,
    COUNT(ipv_date2) AS ipv2_count,
    COUNT(pcv_date1) AS pcv1_count,
    COUNT(pcv_date2) AS pcv2_count,
    COUNT(pcv_date3) AS pcv3_count
FROM immunization
JOIN patients ON immunization.id = patients.id
WHERE patients.gender = 'Female'";

$result = $conn->query($gender_sql_female);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $female_bcgCount = $row['bcg_count'];
    $female_hepBCount = $row['hepB_count'];
    $female_dpt1Count = $row['dpt1_count'];
    $female_dpt2Count = $row['dpt2_count'];
    $female_dpt3Count = $row['dpt3_count'];
    $female_opv1Count = $row['opv1_count'];
    $female_opv2Count = $row['opv2_count'];
    $female_opv3Count = $row['opv3_count'];
    $female_ipv1Count = $row['ipv1_count'];
    $female_ipv2Count = $row['ipv2_count'];
    $female_pcv1Count = $row['pcv1_count'];
    $female_pcv2Count = $row['pcv2_count'];
    $female_pcv3Count = $row['pcv3_count'];
} else {
    $female_bcgCount = $female_hepBCount = $female_dpt1Count = $female_dpt2Count = $female_dpt3Count = 0;
    $female_opv1Count = $female_opv2Count = $female_opv3Count = $female_ipv1Count = $female_ipv2Count = 0;
    $female_pcv1Count = $female_pcv2Count = $female_pcv3Count = 0;
}


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
            <td style="width: 10%;">% (Col.5E.Pop * 100)</td>
            <td style="width: 15%;">Interpretation</td>
            <td style="width: 15%;">Recommendation Action to be taken</td>
        </tr>
        <tr>
            <td colspan="8" style="text-align: center;"><b>Immunization Services for Newborns, Infants and School-Aged Children/Adolescents</b></td>
        </tr>
        <tr>
            <td>1. CPAB - Total</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>2. BCG - Total</td>
            <td></td>
            <td>' . $male_bcgCount . '</td>
            <td>' . $female_bcgCount . '</td>
            <td>' . $bcgCount . '</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>3. HepB, within 24 Hours - Total</td>
            <td></td>
            <td>' . $male_hepBCount . '</td>
            <td>' . $female_hepBCount . '</td>
            <td>' . $hepBCount . '</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>4. DPT HiB-HebB 1 - Total</td>
            <td></td>
            <td>' . $male_dpt1Count . '</td>
            <td>' . $female_dpt1Count . '</td>
            <td>' . $dpt1Count . '</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>5. DPT HiB-HebB 2 - Total</td>
            <td></td>
            <td>' . $male_dpt2Count . '</td>
            <td>' . $female_dpt2Count . '</td>
            <td>' . $dpt2Count . '</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>6. DPT HiB-HebB 3 - Total</td>
            <td></td>
            <td>' . $male_dpt3Count . '</td>
            <td>' . $female_dpt3Count . '</td>
            <td>' . $dpt3Count . '</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>7. OPV 1 - Total</td>
            <td></td>
            <td>' . $male_opv1Count . '</td>
            <td>' . $female_opv1Count . '</td>
            <td>' . $opv1Count . '</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>8. OPV 2 - Total</td>
            <td></td>
            <td>' . $male_opv2Count . '</td>
            <td>' . $female_opv2Count . '</td>
            <td>' . $opv2Count . '</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>9. OPV 3 - Total</td>
            <td></td>
            <td>' . $male_opv3Count . '</td>
            <td>' . $female_opv3Count . '</td>
            <td>' . $opv3Count . '</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>10. IPV1 - Total</td>
            <td></td>
            <td>' . $male_ipv1Count . '</td>
            <td>' . $female_ipv1Count . '</td>
            <td>' . $ipv1Count . '</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>11. IPV2 - Total</td>
            <td></td>
            <td>' . $male_ipv2Count . '</td>
            <td>' . $female_ipv2Count . '</td>
            <td>' . $ipv2Count . '</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>12. IPV2 catch-up - Total</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>13. PCV1 - Total</td>
            <td></td>
            <td>' . $male_pcv1Count . '</td>
            <td>' . $female_pcv1Count . '</td>
            <td>' . $pcv1Count . '</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>14. PCV2 - Total</td>
            <td></td>
            <td>' . $male_pcv2Count . '</td>
            <td>' . $female_pcv2Count . '</td>
            <td>' . $pcv2Count . '</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>15. PCV3 - Total</td>
            <td></td>
            <td>' . $male_pcv3Count . '</td>
            <td>' . $female_pcv3Count . '</td>
            <td>' . $pcv3Count . '</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>16. MCV1 - Total</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>17. MCV2 - Total</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>18. FIC - Total</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>19. CIC - Total</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>20. Td, Grade 1 (Month) - Total</td>
            <td></td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>21. MR, Grade 1 (Month) - Total</td>
            <td></td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>22. Td, Grade 2 (Month) - Total</td>
            <td></td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>23. Td, Grade 2 (Month) - Total</td>
            <td></td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>24. HPV 9-14 - Total</td>
            <td></td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>25. HPV 15-40 - Total</td>
            <td></td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
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
