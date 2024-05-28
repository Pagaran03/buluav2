 <?php

    $query = "SELECT address, gender, COUNT(*) AS count 
    FROM patients 
    GROUP BY address, gender
    ORDER BY 
      CAST(SUBSTRING(address, 6) AS UNSIGNED), -- Extract the numeric part and convert to number
      gender;
    ";
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
    WHERE patients.address = 'Zone 1'";
    $result = $conn->query($queryZone1);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone1_count = $row['zone1_count'];
    } else {
        $zone1_count = 0;
    }

    $queryZone1Con = "SELECT COUNT(*) AS zone1_count FROM consultations
     INNER JOIN patients ON consultations.patient_id = patients.id
     WHERE patients.address = 'Zone 1'";
    $result = $conn->query($queryZone1Con);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone1_count_consult = $row['zone1_count'];
    } else {
        $zone1_count_consult = 0;
    }

    $queryZone1Prenatal = "SELECT COUNT(*) AS zone1_count FROM prenatal_subjective
     INNER JOIN patients ON prenatal_subjective.patient_id = patients.id
     WHERE patients.address = 'Zone 1'";
    $result = $conn->query($queryZone1Prenatal);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone1_count_prenatal = $row['zone1_count'];
    } else {
        $zone1_count_prenatal = 0;
    }

    $queryZone1fp = "SELECT COUNT(*) AS zone1_count_fp FROM fp_information
     INNER JOIN patients ON fp_information.patient_id = patients.id
     WHERE patients.address = 'Zone 1'";
    $result = $conn->query($queryZone1fp);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone1_count_fp = $row['zone1_count_fp'];
    } else {
        $zone1_count_fp = 0;
    }

    // zone 2

    $queryZone2 = "SELECT COUNT(*) AS zone2_count FROM immunization
    INNER JOIN patients ON immunization.patient_id = patients.id
    WHERE patients.address = 'Zone 2'";
    $result = $conn->query($queryZone2);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone2_count = $row['zone2_count'];
    } else {
        $zone2_count = 0;
    }

    $queryZone2Con = "SELECT COUNT(*) AS zone2_count FROM consultations
     INNER JOIN patients ON consultations.patient_id = patients.id
     WHERE patients.address = 'Zone 2'";
    $result = $conn->query($queryZone2Con);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone2_count_consult = $row['zone2_count'];
    } else {
        $zone2_count_consult = 0;
    }

    $queryZone2Prenatal = "SELECT COUNT(*) AS zone2_count FROM prenatal_subjective
     INNER JOIN patients ON prenatal_subjective.patient_id = patients.id
     WHERE patients.address = 'Zone 2'";
    $result = $conn->query($queryZone2Prenatal);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone2_count_prenatal = $row['zone2_count'];
    } else {
        $zone2_count_prenatal = 0;
    }

    $queryZone2fp = "SELECT COUNT(*) AS zone2_count_fp FROM fp_information
     INNER JOIN patients ON fp_information.patient_id = patients.id
     WHERE patients.address = 'Zone 2'";
    $result = $conn->query($queryZone2fp);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone2_count_fp = $row['zone2_count_fp'];
    } else {
        $zone2_count_fp = 0;
    }

    // zone 3


    $queryZone3 = "SELECT COUNT(*) AS zone3_count FROM immunization
    INNER JOIN patients ON immunization.patient_id = patients.id
    WHERE patients.address = 'Zone 3'";
    $result = $conn->query($queryZone3);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone3_count = $row['zone3_count'];
    } else {
        $zone3_count = 0;
    }

    $queryZone3Con = "SELECT COUNT(*) AS zone3_count FROM consultations
     INNER JOIN patients ON consultations.patient_id = patients.id
     WHERE patients.address = 'Zone 3'";
    $result = $conn->query($queryZone3Con);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone3_count_consult = $row['zone3_count'];
    } else {
        $zone3_count_consult = 0;
    }

    $queryZone3Prenatal = "SELECT COUNT(*) AS zone3_count FROM prenatal_subjective
     INNER JOIN patients ON prenatal_subjective.patient_id = patients.id
     WHERE patients.address = 'Zone 3'";
    $result = $conn->query($queryZone3Prenatal);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone3_count_prenatal = $row['zone3_count'];
    } else {
        $zone3_count_prenatal = 0;
    }

    $queryZone3fp = "SELECT COUNT(*) AS zone3_count_fp FROM fp_information
     INNER JOIN patients ON fp_information.patient_id = patients.id
     WHERE patients.address = 'Zone 3'";
    $result = $conn->query($queryZone3fp);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone3_count_fp = $row['zone3_count_fp'];
    } else {
        $zone3_count_fp = 0;
    }

    //zone 4


    $queryZone4 = "SELECT COUNT(*) AS zone4_count FROM immunization
    INNER JOIN patients ON immunization.patient_id = patients.id
    WHERE patients.address = 'Zone 4'";
    $result = $conn->query($queryZone4);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone4_count = $row['zone4_count'];
    } else {
        $zone4_count = 0;
    }

    $queryZone4Con = "SELECT COUNT(*) AS zone4_count FROM consultations
     INNER JOIN patients ON consultations.patient_id = patients.id
     WHERE patients.address = 'Zone 4'";
    $result = $conn->query($queryZone4Con);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone4_count_consult = $row['zone4_count'];
    } else {
        $zone4_count_consult = 0;
    }

    $queryZone4Prenatal = "SELECT COUNT(*) AS zone4_count FROM prenatal_subjective
     INNER JOIN patients ON prenatal_subjective.patient_id = patients.id
     WHERE patients.address = 'Zone 4'";
    $result = $conn->query($queryZone4Prenatal);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone4_count_prenatal = $row['zone4_count'];
    } else {
        $zone4_count_prenatal = 0;
    }

    $queryZone4fp = "SELECT COUNT(*) AS zone4_count_fp FROM fp_information
     INNER JOIN patients ON fp_information.patient_id = patients.id
     WHERE patients.address = 'Zone 4'";
    $result = $conn->query($queryZone4fp);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone4_count_fp = $row['zone4_count_fp'];
    } else {
        $zone4_count_fp = 0;
    }

    //zone 5

    $queryZone5 = "SELECT COUNT(*) AS zone5_count FROM immunization
    INNER JOIN patients ON immunization.patient_id = patients.id
    WHERE patients.address = 'Zone 5'";
    $result = $conn->query($queryZone5);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone5_count = $row['zone5_count'];
    } else {
        $zone5_count = 0;
    }

    $queryZone5Con = "SELECT COUNT(*) AS zone5_count FROM consultations
     INNER JOIN patients ON consultations.patient_id = patients.id
     WHERE patients.address = 'Zone 5'";
    $result = $conn->query($queryZone5Con);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone5_count_consult = $row['zone5_count'];
    } else {
        $zone5_count_consult = 0;
    }

    $queryZone5Prenatal = "SELECT COUNT(*) AS zone5_count FROM prenatal_subjective
     INNER JOIN patients ON prenatal_subjective.patient_id = patients.id
     WHERE patients.address = 'Zone 5'";
    $result = $conn->query($queryZone5Prenatal);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone5_count_prenatal = $row['zone5_count'];
    } else {
        $zone5_count_prenatal = 0;
    }

    $queryZone5fp = "SELECT COUNT(*) AS zone5_count_fp FROM fp_information
     INNER JOIN patients ON fp_information.patient_id = patients.id
     WHERE patients.address = 'Zone 5'";
    $result = $conn->query($queryZone5fp);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone5_count_fp = $row['zone5_count_fp'];
    } else {
        $zone5_count_fp = 0;
    }

    //zone 6

    $queryZone6 = "SELECT COUNT(*) AS zone6_count FROM immunization
    INNER JOIN patients ON immunization.patient_id = patients.id
    WHERE patients.address = 'Zone 6'";
    $result = $conn->query($queryZone6);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone6_count = $row['zone6_count'];
    } else {
        $zone6_count = 0;
    }

    $queryZone6Con = "SELECT COUNT(*) AS zone6_count FROM consultations
     INNER JOIN patients ON consultations.patient_id = patients.id
     WHERE patients.address = 'Zone 6'";
    $result = $conn->query($queryZone6Con);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone6_count_consult = $row['zone6_count'];
    } else {
        $zone6_count_consult = 0;
    }

    $queryZone6Prenatal = "SELECT COUNT(*) AS zone6_count FROM prenatal_subjective
     INNER JOIN patients ON prenatal_subjective.patient_id = patients.id
     WHERE patients.address = 'Zone 6'";
    $result = $conn->query($queryZone6Prenatal);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone6_count_prenatal = $row['zone6_count'];
    } else {
        $zone6_count_prenatal = 0;
    }

    $queryZone6fp = "SELECT COUNT(*) AS zone6_count_fp FROM fp_information
     INNER JOIN patients ON fp_information.patient_id = patients.id
     WHERE patients.address = 'Zone 6'";
    $result = $conn->query($queryZone6fp);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone6_count_fp = $row['zone6_count_fp'];
    } else {
        $zone6_count_fp = 0;
    }

    //zone 7

    $queryZone7 = "SELECT COUNT(*) AS zone7_count FROM immunization
    INNER JOIN patients ON immunization.patient_id = patients.id
    WHERE patients.address = 'Zone 7'";
    $result = $conn->query($queryZone7);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone7_count = $row['zone7_count'];
    } else {
        $zone7_count = 0;
    }

    $queryZone7Con = "SELECT COUNT(*) AS zone7_count FROM consultations
     INNER JOIN patients ON consultations.patient_id = patients.id
     WHERE patients.address = 'Zone 7'";
    $result = $conn->query($queryZone7Con);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone7_count_consult = $row['zone7_count'];
    } else {
        $zone7_count_consult = 0;
    }

    $queryZone7Prenatal = "SELECT COUNT(*) AS zone7_count FROM prenatal_subjective
     INNER JOIN patients ON prenatal_subjective.patient_id = patients.id
     WHERE patients.address = 'Zone 7'";
    $result = $conn->query($queryZone7Prenatal);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone7_count_prenatal = $row['zone7_count'];
    } else {
        $zone7_count_prenatal = 0;
    }

    $queryZone7fp = "SELECT COUNT(*) AS zone7_count_fp FROM fp_information
     INNER JOIN patients ON fp_information.patient_id = patients.id
     WHERE patients.address = 'Zone 7'";
    $result = $conn->query($queryZone7fp);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone7_count_fp = $row['zone7_count_fp'];
    } else {
        $zone7_count_fp = 0;
    }

    // zone 8
    $queryZone8 = "SELECT COUNT(*) AS zone8_count FROM immunization
    INNER JOIN patients ON immunization.patient_id = patients.id
    WHERE patients.address = 'Zone 8'";
    $result = $conn->query($queryZone8);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone8_count = $row['zone8_count'];
    } else {
        $zone8_count = 0;
    }

    $queryZone8Con = "SELECT COUNT(*) AS zone8_count FROM consultations
     INNER JOIN patients ON consultations.patient_id = patients.id
     WHERE patients.address = 'Zone 8'";
    $result = $conn->query($queryZone8Con);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone8_count_consult = $row['zone8_count'];
    } else {
        $zone8_count_consult = 0;
    }

    $queryZone8Prenatal = "SELECT COUNT(*) AS zone8_count FROM prenatal_subjective
     INNER JOIN patients ON prenatal_subjective.patient_id = patients.id
     WHERE patients.address = 'Zone 8'";
    $result = $conn->query($queryZone8Prenatal);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone8_count_prenatal = $row['zone8_count'];
    } else {
        $zone8_count_prenatal = 0;
    }

    $queryZone8fp = "SELECT COUNT(*) AS zone8_count_fp FROM fp_information
     INNER JOIN patients ON fp_information.patient_id = patients.id
     WHERE patients.address = 'Zone 8'";
    $result = $conn->query($queryZone8fp);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone8_count_fp = $row['zone8_count_fp'];
    } else {
        $zone8_count_fp = 0;
    }

    //zone 9
    $queryZone9 = "SELECT COUNT(*) AS zone9_count FROM immunization
    INNER JOIN patients ON immunization.patient_id = patients.id
    WHERE patients.address = 'Zone 9'";
    $result = $conn->query($queryZone9);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone9_count = $row['zone9_count'];
    } else {
        $zone9_count = 0;
    }

    $queryZone9Con = "SELECT COUNT(*) AS zone9_count FROM consultations
     INNER JOIN patients ON consultations.patient_id = patients.id
     WHERE patients.address = 'Zone 9'";
    $result = $conn->query($queryZone9Con);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone9_count_consult = $row['zone9_count'];
    } else {
        $zone9_count_consult = 0;
    }

    $queryZone9Prenatal = "SELECT COUNT(*) AS zone9_count FROM prenatal_subjective
     INNER JOIN patients ON prenatal_subjective.patient_id = patients.id
     WHERE patients.address = 'Zone 9'";
    $result = $conn->query($queryZone9Prenatal);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone9_count_prenatal = $row['zone9_count'];
    } else {
        $zone9_count_prenatal = 0;
    }

    $queryZone9fp = "SELECT COUNT(*) AS zone9_count_fp FROM fp_information
     INNER JOIN patients ON fp_information.patient_id = patients.id
     WHERE patients.address = 'Zone 9'";
    $result = $conn->query($queryZone9fp);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone9_count_fp = $row['zone9_count_fp'];
    } else {
        $zone9_count_fp = 0;
    }

    //zone 10
    $queryZone10 = "SELECT COUNT(*) AS zone10_count FROM immunization
    INNER JOIN patients ON immunization.patient_id = patients.id
    WHERE patients.address = 'Zone 10'";
    $result = $conn->query($queryZone10);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone10_count = $row['zone10_count'];
    } else {
        $zone10_count = 0;
    }

    $queryZone10Con = "SELECT COUNT(*) AS zone10_count FROM consultations
     INNER JOIN patients ON consultations.patient_id = patients.id
     WHERE patients.address = 'Zone 10'";
    $result = $conn->query($queryZone10Con);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone10_count_consult = $row['zone10_count'];
    } else {
        $zone10_count_consult = 0;
    }

    $queryZone10Prenatal = "SELECT COUNT(*) AS zone10_count FROM prenatal_subjective
     INNER JOIN patients ON prenatal_subjective.patient_id = patients.id
     WHERE patients.address = 'Zone 10'";
    $result = $conn->query($queryZone10Prenatal);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone10_count_prenatal = $row['zone10_count'];
    } else {
        $zone10_count_prenatal = 0;
    }

    $queryZone10fp = "SELECT COUNT(*) AS zone10_count_fp FROM fp_information
     INNER JOIN patients ON fp_information.patient_id = patients.id
     WHERE patients.address = 'Zone 10'";
    $result = $conn->query($queryZone10fp);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone10_count_fp = $row['zone10_count_fp'];
    } else {
        $zone10_count_fp = 0;
    }

    //zone 11
    $queryZone11 = "SELECT COUNT(*) AS zone11_count FROM immunization
    INNER JOIN patients ON immunization.patient_id = patients.id
    WHERE patients.address = 'Zone 11'";
    $result = $conn->query($queryZone11);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone11_count = $row['zone11_count'];
    } else {
        $zone11_count = 0;
    }

    $queryZone11Con = "SELECT COUNT(*) AS zone11_count FROM consultations
     INNER JOIN patients ON consultations.patient_id = patients.id
     WHERE patients.address = 'Zone 11'";
    $result = $conn->query($queryZone11Con);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone11_count_consult = $row['zone11_count'];
    } else {
        $zone11_count_consult = 0;
    }

    $queryZone11Prenatal = "SELECT COUNT(*) AS zone11_count FROM prenatal_subjective
     INNER JOIN patients ON prenatal_subjective.patient_id = patients.id
     WHERE patients.address = 'Zone 11'";
    $result = $conn->query($queryZone11Prenatal);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone11_count_prenatal = $row['zone11_count'];
    } else {
        $zone11_count_prenatal = 0;
    }

    $queryZone11fp = "SELECT COUNT(*) AS zone11_count_fp FROM fp_information
     INNER JOIN patients ON fp_information.patient_id = patients.id
     WHERE patients.address = 'Zone 11'";
    $result = $conn->query($queryZone11fp);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone11_count_fp = $row['zone11_count_fp'];
    } else {
        $zone11_count_fp = 0;
    }

    //zone 12
    $queryZone12 = "SELECT COUNT(*) AS zone12_count FROM immunization
    INNER JOIN patients ON immunization.patient_id = patients.id
    WHERE patients.address = 'Zone 12'";
    $result = $conn->query($queryZone12);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone12_count = $row['zone12_count'];
    } else {
        $zone12_count = 0;
    }

    $queryZone12Con = "SELECT COUNT(*) AS zone12_count FROM consultations
     INNER JOIN patients ON consultations.patient_id = patients.id
     WHERE patients.address = 'Zone 12'";
    $result = $conn->query($queryZone12Con);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone12_count_consult = $row['zone12_count'];
    } else {
        $zone12_count_consult = 0;
    }

    $queryZone12Prenatal = "SELECT COUNT(*) AS zone12_count FROM prenatal_subjective
     INNER JOIN patients ON prenatal_subjective.patient_id = patients.id
     WHERE patients.address = 'Zone 12'";
    $result = $conn->query($queryZone12Prenatal);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone12_count_prenatal = $row['zone12_count'];
    } else {
        $zone12_count_prenatal = 0;
    }

    $queryZone12fp = "SELECT COUNT(*) AS zone12_count_fp FROM fp_information
     INNER JOIN patients ON fp_information.patient_id = patients.id
     WHERE patients.address = 'Zone 12'";
    $result = $conn->query($queryZone12fp);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $zone12_count_fp = $row['zone12_count_fp'];
    } else {
        $zone12_count_fp = 0;
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
                 <select name="" id="zonalSelect" onchange="changeChart()" hidden>
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
                             document.getElementById("zonalSelect").setAttribute("hidden", "hidden");

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
                                                 data: [<?php echo json_encode($zone2_count_consult); ?>],
                                                 backgroundColor: "rgba(153,255,51,1)"
                                             },
                                             {
                                                 label: 'Immunization',
                                                 data: [<?php echo json_encode($zone2_count); ?>],
                                                 backgroundColor: "rgba(255,153,0,1)"
                                             },
                                             {
                                                 label: 'Prenatal',
                                                 data: [<?php echo json_encode($zone2_count_prenatal); ?>],
                                                 backgroundColor: "rgba(69, 219, 255, 0.8)"
                                             },
                                             {
                                                 label: 'Family Planning',
                                                 data: [<?php echo json_encode($zone2_count_fp); ?>],
                                                 backgroundColor: "rgba(69, 55, 255, 0.66)"
                                             },
                                         ]
                                     }
                                 });
                             } else if (zon == "Zone 3") {
                                 myChart = new Chart(ctx, {
                                     type: 'bar',
                                     data: {
                                         labels: ["Consultation, Immunization, Prenatal, Family Planning"],
                                         datasets: [{
                                                 label: 'Consultation',
                                                 data: [<?php echo json_encode($zone3_count_consult); ?>],
                                                 backgroundColor: "rgba(153,255,51,1)"
                                             },
                                             {
                                                 label: 'Immunization',
                                                 data: [<?php echo json_encode($zone3_count); ?>],
                                                 backgroundColor: "rgba(255,153,0,1)"
                                             },
                                             {
                                                 label: 'Prenatal',
                                                 data: [<?php echo json_encode($zone3_count_prenatal); ?>],
                                                 backgroundColor: "rgba(69, 219, 355, 0.8)"
                                             },
                                             {
                                                 label: 'Family Planning',
                                                 data: [<?php echo json_encode($zone3_count_fp); ?>],
                                                 backgroundColor: "rgba(69, 55, 255, 0.66)"
                                             },
                                         ]
                                     }
                                 });
                             } else if (zon == "Zone 4") {
                                 myChart = new Chart(ctx, {
                                     type: 'bar',
                                     data: {
                                         labels: ["Consultation, Immunization, Prenatal, Family Planning"],
                                         datasets: [{
                                                 label: 'Consultation',
                                                 data: [<?php echo json_encode($zone4_count_consult); ?>],
                                                 backgroundColor: "rgba(153,255,51,1)"
                                             },
                                             {
                                                 label: 'Immunization',
                                                 data: [<?php echo json_encode($zone4_count); ?>],
                                                 backgroundColor: "rgba(255,153,0,1)"
                                             },
                                             {
                                                 label: 'Prenatal',
                                                 data: [<?php echo json_encode($zone4_count_prenatal); ?>],
                                                 backgroundColor: "rgba(69, 219, 355, 0.8)"
                                             },
                                             {
                                                 label: 'Family Planning',
                                                 data: [<?php echo json_encode($zone4_count_fp); ?>],
                                                 backgroundColor: "rgba(69, 55, 255, 0.66)"
                                             },
                                         ]
                                     }
                                 });
                             } else if (zon == "Zone 5") {
                                 myChart = new Chart(ctx, {
                                     type: 'bar',
                                     data: {
                                         labels: ["Consultation, Immunization, Prenatal, Family Planning"],
                                         datasets: [{
                                                 label: 'Consultation',
                                                 data: [<?php echo json_encode($zone5_count_consult); ?>],
                                                 backgroundColor: "rgba(153,255,51,1)"
                                             },
                                             {
                                                 label: 'Immunization',
                                                 data: [<?php echo json_encode($zone5_count); ?>],
                                                 backgroundColor: "rgba(255,153,0,1)"
                                             },
                                             {
                                                 label: 'Prenatal',
                                                 data: [<?php echo json_encode($zone5_count_prenatal); ?>],
                                                 backgroundColor: "rgba(69, 219, 355, 0.8)"
                                             },
                                             {
                                                 label: 'Family Planning',
                                                 data: [<?php echo json_encode($zone5_count_fp); ?>],
                                                 backgroundColor: "rgba(69, 55, 255, 0.66)"
                                             },
                                         ]
                                     }
                                 });
                             } else if (zon == "Zone 6") {
                                 myChart = new Chart(ctx, {
                                     type: 'bar',
                                     data: {
                                         labels: ["Consultation, Immunization, Prenatal, Family Planning"],
                                         datasets: [{
                                                 label: 'Consultation',
                                                 data: [<?php echo json_encode($zone6_count_consult); ?>],
                                                 backgroundColor: "rgba(153,255,51,1)"
                                             },
                                             {
                                                 label: 'Immunization',
                                                 data: [<?php echo json_encode($zone6_count); ?>],
                                                 backgroundColor: "rgba(255,153,0,1)"
                                             },
                                             {
                                                 label: 'Prenatal',
                                                 data: [<?php echo json_encode($zone6_count_prenatal); ?>],
                                                 backgroundColor: "rgba(69, 219, 355, 0.8)"
                                             },
                                             {
                                                 label: 'Family Planning',
                                                 data: [<?php echo json_encode($zone6_count_fp); ?>],
                                                 backgroundColor: "rgba(69, 55, 255, 0.66)"
                                             },
                                         ]
                                     }
                                 });
                             } else if (zon == "Zone 7") {
                                 myChart = new Chart(ctx, {
                                     type: 'bar',
                                     data: {
                                         labels: ["Consultation, Immunization, Prenatal, Family Planning"],
                                         datasets: [{
                                                 label: 'Consultation',
                                                 data: [<?php echo json_encode($zone7_count_consult); ?>],
                                                 backgroundColor: "rgba(153,255,51,1)"
                                             },
                                             {
                                                 label: 'Immunization',
                                                 data: [<?php echo json_encode($zone7_count); ?>],
                                                 backgroundColor: "rgba(255,153,0,1)"
                                             },
                                             {
                                                 label: 'Prenatal',
                                                 data: [<?php echo json_encode($zone7_count_prenatal); ?>],
                                                 backgroundColor: "rgba(69, 219, 355, 0.8)"
                                             },
                                             {
                                                 label: 'Family Planning',
                                                 data: [<?php echo json_encode($zone7_count_fp); ?>],
                                                 backgroundColor: "rgba(69, 55, 255, 0.66)"
                                             },
                                         ]
                                     }
                                 });
                             } else if (zon == "Zone 8") {
                                 myChart = new Chart(ctx, {
                                     type: 'bar',
                                     data: {
                                         labels: ["Consultation, Immunization, Prenatal, Family Planning"],
                                         datasets: [{
                                                 label: 'Consultation',
                                                 data: [<?php echo json_encode($zone8_count_consult); ?>],
                                                 backgroundColor: "rgba(153,255,51,1)"
                                             },
                                             {
                                                 label: 'Immunization',
                                                 data: [<?php echo json_encode($zone8_count); ?>],
                                                 backgroundColor: "rgba(255,153,0,1)"
                                             },
                                             {
                                                 label: 'Prenatal',
                                                 data: [<?php echo json_encode($zone8_count_prenatal); ?>],
                                                 backgroundColor: "rgba(69, 219, 355, 0.8)"
                                             },
                                             {
                                                 label: 'Family Planning',
                                                 data: [<?php echo json_encode($zone8_count_fp); ?>],
                                                 backgroundColor: "rgba(69, 55, 255, 0.66)"
                                             },
                                         ]
                                     }
                                 });
                             } else if (zon == "Zone 9") {
                                 myChart = new Chart(ctx, {
                                     type: 'bar',
                                     data: {
                                         labels: ["Consultation, Immunization, Prenatal, Family Planning"],
                                         datasets: [{
                                                 label: 'Consultation',
                                                 data: [<?php echo json_encode($zone9_count_consult); ?>],
                                                 backgroundColor: "rgba(153,255,51,1)"
                                             },
                                             {
                                                 label: 'Immunization',
                                                 data: [<?php echo json_encode($zone9_count); ?>],
                                                 backgroundColor: "rgba(255,153,0,1)"
                                             },
                                             {
                                                 label: 'Prenatal',
                                                 data: [<?php echo json_encode($zone9_count_prenatal); ?>],
                                                 backgroundColor: "rgba(69, 219, 355, 0.8)"
                                             },
                                             {
                                                 label: 'Family Planning',
                                                 data: [<?php echo json_encode($zone9_count_fp); ?>],
                                                 backgroundColor: "rgba(69, 55, 255, 0.66)"
                                             },
                                         ]
                                     }
                                 });
                             } else if (zon == "Zone 10") {
                                 myChart = new Chart(ctx, {
                                     type: 'bar',
                                     data: {
                                         labels: ["Consultation, Immunization, Prenatal, Family Planning"],
                                         datasets: [{
                                                 label: 'Consultation',
                                                 data: [<?php echo json_encode($zone10_count_consult); ?>],
                                                 backgroundColor: "rgba(153,255,51,1)"
                                             },
                                             {
                                                 label: 'Immunization',
                                                 data: [<?php echo json_encode($zone10_count); ?>],
                                                 backgroundColor: "rgba(255,153,0,1)"
                                             },
                                             {
                                                 label: 'Prenatal',
                                                 data: [<?php echo json_encode($zone10_count_prenatal); ?>],
                                                 backgroundColor: "rgba(69, 219, 355, 0.8)"
                                             },
                                             {
                                                 label: 'Family Planning',
                                                 data: [<?php echo json_encode($zone10_count_fp); ?>],
                                                 backgroundColor: "rgba(69, 55, 255, 0.66)"
                                             },
                                         ]
                                     }
                                 });
                             } else if (zon == "Zone 11") {
                                 myChart = new Chart(ctx, {
                                     type: 'bar',
                                     data: {
                                         labels: ["Consultation, Immunization, Prenatal, Family Planning"],
                                         datasets: [{
                                                 label: 'Consultation',
                                                 data: [<?php echo json_encode($zone11_count_consult); ?>],
                                                 backgroundColor: "rgba(153,255,51,1)"
                                             },
                                             {
                                                 label: 'Immunization',
                                                 data: [<?php echo json_encode($zone11_count); ?>],
                                                 backgroundColor: "rgba(255,153,0,1)"
                                             },
                                             {
                                                 label: 'Prenatal',
                                                 data: [<?php echo json_encode($zone11_count_prenatal); ?>],
                                                 backgroundColor: "rgba(69, 219, 355, 0.8)"
                                             },
                                             {
                                                 label: 'Family Planning',
                                                 data: [<?php echo json_encode($zone11_count_fp); ?>],
                                                 backgroundColor: "rgba(69, 55, 255, 0.66)"
                                             },
                                         ]
                                     }
                                 });
                             } else if (zon == "Zone 12") {
                                 myChart = new Chart(ctx, {
                                     type: 'bar',
                                     data: {
                                         labels: ["Consultation, Immunization, Prenatal, Family Planning"],
                                         datasets: [{
                                                 label: 'Consultation',
                                                 data: [<?php echo json_encode($zone12_count_consult); ?>],
                                                 backgroundColor: "rgba(153,255,51,1)"
                                             },
                                             {
                                                 label: 'Immunization',
                                                 data: [<?php echo json_encode($zone12_count); ?>],
                                                 backgroundColor: "rgba(255,153,0,1)"
                                             },
                                             {
                                                 label: 'Prenatal',
                                                 data: [<?php echo json_encode($zone12_count_prenatal); ?>],
                                                 backgroundColor: "rgba(69, 219, 355, 0.8)"
                                             },
                                             {
                                                 label: 'Family Planning',
                                                 data: [<?php echo json_encode($zone12_count_fp); ?>],
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