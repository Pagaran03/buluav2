 <?php

    $query = "SELECT address, gender, COUNT(*) AS count 
FROM patients 
GROUP BY address, gender";
    $result = $conn->query($query);

    $male_data = [];
    $female_data = [];
    $labels = [];

    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            // Store data in PHP arrays
            $labels[] = $row["address"];
            if ($row["gender"] == "Male") {
                $male_data[] = $row["count"];
            } else {
                $female_data[] = $row["count"];
            }
        }
    } else {
        echo "0 results";
    }

    echo "<script>console.log('Male Data: " . json_encode($male_data) . "');</script>";
    echo "<script>console.log('Female Data: " . json_encode($female_data) . "');</script>";



    $queryAge = "SELECT address, age, COUNT(*) AS count 
FROM patients 
GROUP BY address, age";
    $result = $conn->query($queryAge);

    $age10to14 = [];
    $age15to19 = [];
    $age20Above = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $label_age[] = $row["address"];
            if ($row["age"] > 0 && $row['age'] <= 14) {
                $age10to14[] = $row["count"];
            } elseif ($row["age"] >= 15 && $row['age'] <= 19) {
                $age15to19[] = $row["count"];
            } else {
                $age20Above[] = $row["count"];
            }
        }
    } else {
        echo "0 results";
    }

    $queryZone1 = "SELECT COUNT(*) AS zone1_count FROM immunization
    INNER JOIN patients ON immunization.patient_id = patients.id
    WHERE patients.address = 'Zone 1, Bulua, Cagayan de Oro'";
    $result = $conn->query($queryZone1);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone1_count = $row['zone1_count'];
    } else {
        $zone1_count = 0;
    }

    $queryZone1Con = "SELECT COUNT(*) AS zone1_count FROM consultations
     INNER JOIN patients ON consultations.patient_id = patients.id
     WHERE patients.address = 'Zone 1, Bulua, Cagayan de Oro'";
    $result = $conn->query($queryZone1Con);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone1_count_consult = $row['zone1_count'];
    } else {
        $zone1_count_consult = 0;
    }

    $queryZone1Prenatal = "SELECT COUNT(*) AS zone1_count FROM prenatal_subjective
     INNER JOIN patients ON prenatal_subjective.patient_id = patients.id
     WHERE patients.address = 'Zone 1, Bulua, Cagayan de Oro'";
    $result = $conn->query($queryZone1Prenatal);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone1_count_prenatal = $row['zone1_count'];
    } else {
        $zone1_count_prenatal = 0;
    }

    $queryZone1fp = "SELECT COUNT(*) AS zone1_count_fp FROM fp_information
     INNER JOIN patients ON fp_information.patient_id = patients.id
     WHERE patients.address = 'Zone 1, Bulua, Cagayan de Oro'";
    $result = $conn->query($queryZone1fp);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone1_count_fp = $row['zone1_count_fp'];
    } else {
        $zone1_count_fp = 0;
    }
    ?>
 <!-- Modal -->
 <div class="modal fade" id="patientmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-xl" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Patient Details</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>

             <div class="modal-body">
                 <span>Sort Demographic Data by:</span>
                 <select name="" id="optionSelect" onchange="changeChart()">
                     <option value="Gender" selected>Gender</option>
                     <option value="Age">Age</option>
                     <option value="Services">Services</option>
                 </select>
                 <select name="" id="zonalSelect" hidden>
                     <option value="Zone 1">Zone 1</option>
                     <option value="Zone 2">Zone 2</option>
                     <option value="Zone 3">Zone 3</option>
                     <option value="Zone 4">Zone 4</option>
                     <option value="Zone 5">Zone 5</option>
                     <option value="Zone 6">Zone 6</option>
                     <option value="Zone 7">Zone 7</option>
                     <option value="Zone 8">Zone 8</option>
                     <option value="Zone 9">Zone 9</option>
                     <option value="Zone 10">Zone 10</option>
                 </select>
                 <canvas id="myChart" width="800" height="400"></canvas>

                 <script>
                     var myChart;

                     function changeChart() {
                         // Reset the previous chart if it exists
                         if (myChart) {
                             myChart.destroy();
                         }

                         var opt = document.getElementById("optionSelect").value;
                         var zon = document.getElementById("zonalSelect").value;
                         var ctx = document.getElementById("myChart").getContext('2d');

                         if (opt == "Gender") {
                             myChart = new Chart(ctx, {
                                 type: 'bar',
                                 data: {
                                     labels: ["Zone 1 Bulua", "Zone 2 Bulua", "Zone 3 Bulua", "Zone 4 Bulua", "Zone 5 Bulua", "Zone 6 Bulua", "Zone 7 Bulua", "Zone 8 Bulua", "Zone 9 Bulua", "Zone 10 Bulua", "Zone 11 Bulua", "Zone 12 Bulua"],
                                     datasets: [{
                                             label: 'Male',
                                             data: <?php echo json_encode($male_data); ?>,
                                             backgroundColor: "rgba(153,255,51,1)"
                                         },
                                         {
                                             label: 'Female',
                                             data: <?php echo json_encode($female_data); ?>,
                                             backgroundColor: "rgba(255,153,0,1)"
                                         }
                                     ]
                                 }
                             });
                         } else if (opt == "Age") {
                             document.getElementById("zonalSelect").setAttribute("hidden", "hidden");

                             myChart = new Chart(ctx, {
                                 type: 'bar',
                                 data: {
                                     labels: ["Zone 1 Bulua", "Zone 2 Bulua", "Zone 3 Bulua", "Zone 4 Bulua", "Zone 5 Bulua", "Zone 6 Bulua", "Zone 7 Bulua", "Zone 8 Bulua", "Zone 9 Bulua", "Zone 10 Bulua", "Zone 11 Bulua", "Zone 12 Bulua"],
                                     datasets: [{
                                             label: 'Ages 10-14',
                                             data: <?php echo json_encode($age10to14); ?>,
                                             backgroundColor: "rgba(153,255,51,1)"
                                         },
                                         {
                                             label: 'Ages 15-19',
                                             data: <?php echo json_encode($age15to19); ?>,
                                             backgroundColor: "rgba(255,153,0,1)"
                                         },
                                         {
                                             label: 'Ages 20-Above',
                                             data: <?php echo json_encode($age20Above); ?>,
                                             backgroundColor: "rgba(69, 219, 255, 0.8)"
                                         }
                                     ]
                                 }
                             });
                         } else if (opt == "Services") {
                             document.getElementById("zonalSelect").removeAttribute("hidden");
                             if (zon == "Zone 1") {
                                 myChart = new Chart(ctx, {
                                     type: 'bar',
                                     data: {
                                         labels: ["Consultation, Immunization, Prenatal, Family Planning"],
                                         datasets: [{
                                                 label: 'Consultation',
                                                 data: [<?php echo json_encode($zone1_count_consult); ?>],
                                                 backgroundColor: "rgba(153,255,51,1)"
                                             },
                                             {
                                                 label: 'Immunization',
                                                 data: [<?php echo json_encode($zone1_count); ?>],
                                                 backgroundColor: "rgba(255,153,0,1)"
                                             },
                                             {
                                                 label: 'Prenatal',
                                                 data: [<?php echo json_encode($zone1_count_prenatal); ?>],
                                                 backgroundColor: "rgba(69, 219, 255, 0.8)"
                                             },
                                             {
                                                 label: 'Family Planning',
                                                 data: [<?php echo json_encode($zone1_count_fp); ?>],
                                                 backgroundColor: "rgba(69, 55, 255, 0.66)"
                                             },
                                         ]
                                     }
                                 });
                             } else if (zon == "Zone 2") {
                                 myChart = new Chart(ctx, {
                                     type: 'bar',
                                     data: {
                                         labels: ["Consultation, Immunization, Prenatal, Family Planning"],
                                         datasets: [{
                                                 label: 'Consultation',
                                                 data: 0,
                                                 backgroundColor: "rgba(153,255,51,1)"
                                             },
                                             {
                                                 label: 'Immunization',
                                                 data: [<?php echo json_encode($zone1_count); ?>],
                                                 backgroundColor: "rgba(255,153,0,1)"
                                             },
                                             {
                                                 label: 'Prenatal',
                                                 data: [<?php echo json_encode($zone1_count_prenatal); ?>],
                                                 backgroundColor: "rgba(69, 219, 255, 0.8)"
                                             },
                                             {
                                                 label: 'Family Planning',
                                                 data: [<?php echo json_encode($zone1_count_fp); ?>],
                                                 backgroundColor: "rgba(69, 55, 255, 0.66)"
                                             },
                                         ]
                                     }
                                 });
                             }
                         }
                     }
                 </script>

             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
             </div>
         </div>
     </div>
 </div>