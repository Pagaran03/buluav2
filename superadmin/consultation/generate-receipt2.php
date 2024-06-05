<!-- <?php
        session_start();
        require '../../vendor/autoload.php';
        include_once('../../config.php');

        use Dompdf\Dompdf;


        $pdf = new Dompdf();

        $pdf->setPaper('A4', 'Portrait');

        $path = '../../assets/images/rx.jpg';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $id = $_GET['id'];
        $dateNow = date("Y/m/d");
        
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

        $htmlContent = '
        <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="bg-white shadow-lg rounded p-5">
                    <div class="row mb-4">
                        <img class="float-right" style="width: 100px; height: auto; margin-left: 80%;" src= ' . $base64 . ' alt="Doctor">
                       
                    </div>
                    <h1 class="text-center mb-4">Doctor`s Prescription</h1>
                    <div class="row mb-4">
                        <div class="col-sm">
                            <p class="text-sm"><span class="font-weight-bold">Patient Name:</span> ' . $row['p_first_name'] . ' ' . $row['p_last_name'] . '</p>
                            <p class="text-sm"><span class="font-weight-bold">Age:</span> ' . $row['p_age'] . '</p>
                            <p class="text-sm"><span class="font-weight-bold">Date:</span> '.$dateNow.'</p>
                        </div>
                        <div class="col-sm">
                            <p class="text-sm"><span class="font-weight-bold">Doctor Name:</span> ' . $row['d_first_name'] . ' ' . $row['d_last_name'] . '</p>
                            <p class="text-sm"><span class="font-weight-bold">License No:</span> 12345</p>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-center font-weight-bold mb-3">Medications:</h2>
                        <ul>
                           
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    

';

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
        ?> -->