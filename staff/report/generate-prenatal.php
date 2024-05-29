<?php
require '../../vendor/autoload.php';
include_once('../../config.php');

use Dompdf\Dompdf;
use Dompdf\Options;

$fromDate = $_GET['fromDate'];
$toDate = $_GET['toDate'];

$fromDate = $conn->real_escape_string($fromDate);
$toDate = $conn->real_escape_string($toDate);

$fromDateTime = new DateTime($fromDate);
$toDateTime = new DateTime($toDate);

$currentMonth = $fromDateTime->format('F');
$currentYear = $fromDateTime->format('Y');

$fromDate = mysqli_real_escape_string($conn, $fromDate);
$toDate = mysqli_real_escape_string($conn, $toDate);


include('report_queries/prenatal_report_query.php');

// Create a new Dompdf instance
$pdf = new Dompdf();

// (Optional) Set PDF options, like paper size and orientation
$pdf->setPaper('A4', 'landscape');


// Generate the HTML content for the PDF
$htmlContent = '
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prenatal Care Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 6px;
            text-align: center;
            font-size: 10px;
        }
        th {
            background-color: #f2f2f2;
        }
      
    </style>
</head>
<body>
<table>
    <thead>
        <tr>
            <th rowspan="2">Indicators</th>
            <th rowspan="2">Eligible Population</th>
            <th colspan="8">Age of Pregnant/Postpartum Women</th>
        </tr>
        <tr>
            <th colspan="2">10-14</th>
            <th colspan="2">15-19</th>
            <th colspan="2">20-49</th>
            <th colspan="2">Total</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td></td>
            <td rowspan="22"></td>
            <td>No.</td>
            <td>%</td>
            <td>No.</td>
            <td>%</td>
            <td>No.</td>
            <td>%</td>
            <td>No.</td>
            <td>%</td>
        </tr>
        <tr>
        <td>No. of pregnant women at least 4 prenatal check-ups - Total</td>
            <td>'.$countForPrenatal10to14.'</td>
            <td>%</td>
            <td>'.$countForPrenatal15to19.'</td>
            <td>%</td>
            <td>'.$countForPrenatal20to49.'</td>
            <td>%</td>
            <td>'.$countForPrenatalTotal.'</td>
            <td>%</td>
            
        </tr>
        <tr>
            <td>No. of pregnant women assessed of their nutritional status during the 1st trimester - Total</td>
            <td></td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            
        </tr>
        <tr>
            <td>a. No. of pregnant women seen in the first trimester who have normal BMI - Total</td>
            <td></td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
        </tr>
        <tr>
            <td>b. No. of pregnant women seen in the first trimester who have low BMI - Total</td>
            <td></td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
        </tr>
        <tr>
            <td>c. No. of pregnant women seen in the first trimester who have high BMI - Total</td>
            <td></td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
        </tr>
        <tr>
            <td>No. of pregnant women for the first time given at least 2 doses of Td vaccination (Td2 Plus) - Total</td>
            <td>'.$countFirstTimePregnantWithTd2Plus10to14.'</td>
            <td>%</td>
            <td>'.$countFirstTimePregnantWithTd2Plus15to19.'</td>
            <td>%</td>
            <td>'.$countFirstTimePregnantWithTd2Plus20to49.'</td>
            <td>%</td>
            <td>'.$totalCountForFirstTimePregnantWithTd2Plus.'</td>
            <td>%</td>
        </tr>
        <tr>
            <td>No. of pregnant women for the 2nd or more times given at least 3 doses of Td vaccination (Td2 Plus) - Total</td>
            <td>'.$countSecondTimeTdVacc10to14.'</td>
            <td>%</td>
            <td>'.$countSecondTimeTdVacc15to19.'</td>
            <td>%</td>
            <td>'.$countSecondTimeTdVacc20to49.'</td>
            <td>%</td>
            <td>'.$countTotalSecondTime.'</td>
            <td>'.$countTotalSecondTime.'</td>
        </tr>
        <tr>
            <td>No. of pregnant women who completed the dose of iron with folic acid supplementation - Total</td>
            <td></td>
            <td>0</td>
            <td>7</td>
            <td>40</td>
            <td>47</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
        </tr>
        <tr>
            <td>No. of pregnant women who completed doses of calcium carbonate supplementation - Total</td>
            <td></td>
            <td>0</td>
            <td>7</td>
            <td>45</td>
            <td>52</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
        </tr>
        <tr>
            <td>No. of pregnant women given iodine capsules - Total</td>
            <td></td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
        </tr>
        <tr>
            <td>No. of pregnant women given one dose of deworming tablet - Total</td>
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
            <td>No. of pregnant women given two doses of deworming tablet - Total</td>
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
            <td>No. of pregnant women screened for syphilis - Total</td>
            <td></td>
            <td>0</td>
            <td>2</td>
            <td>20</td>
            <td>22</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
        </tr>
        <tr>
            <td>No. of pregnant women tested positive for syphilis - Total</td>
            <td></td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            </tr>
            <tr>
            <td>No. of pregnant women screened for Hepatitis B - Total</td>
            <td></td>
            <td>0</td>
            <td>2</td>
            <td>20</td>
            <td>22</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            </tr>
            <tr>
            <td>No. of pregnant women tested positive for Hepatitis B - Total</td>
            <td></td>
            <td>0</td>
            <td>1</td>
            <td>0</td>
            <td>1</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            </tr>
            <tr>
            <td>No. of pregnant women screened for HIV - Total</td>
            <td></td>
            <td>0</td>
            <td>2</td>
            <td>20</td>
            <td>22</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            </tr>
            <tr>
            <td>No. of pregnant women tested positive for HIV - Total</td>
            <td></td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            </tr>
            <tr>
            <td>No. of pregnant women tested for CBC or Hgb&Hct count - Total</td>
            <td>'.$countCbc10to14.'</td>
            <td>%</td>
            <td>'.$countCbc15to19.'</td>
            <td>%</td>
            <td>'.$countCbc20to49.'</td>
            <td>%</td>
            <td>'.$cbcTotal .'</td>
            <td>%</td>
            </tr>
            <tr>
            <td>No. of pregnant women tested for CBC or Hgb&Hct count diagnosed with anemia - Total</td>
            <td>'.$countAnemia10to14.'</td>
            <td>%</td>
            <td>'.$countAnemia15to19.'</td>
            <td>%</td>
            <td>'.$countAnemia20to49.'</td>
            <td>%</td>
            <td>'.$totalAnemiaCount.'</td>
            <td>%</td>
            </tr>
            <tr>
            <td>No. of pregnant women screened for gestational diabetes - Total</td>
            <td></td>
            <td>0</td>
            <td>1</td>
            <td>0</td>
            <td>1</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            </tr>
            </tbody>
            </table>
            </body>
            </html>';
// Load HTML content into Dompdf
$pdf->loadHtml($htmlContent);

// Render the HTML to PDF
$pdf->render();

// Get the PDF content
$pdfContent = $pdf->output();

// Send the appropriate headers for a PDF file
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="prenatal_report.pdf"');

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
