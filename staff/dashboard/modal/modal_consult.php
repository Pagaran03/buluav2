<?php

$zones = range(1, 12);
$fp_consultation = [];
$prenatal_consultation = [];
$consultations = [];
$immunization = [];

foreach ($zones as $zone) {
  $fp_query = "SELECT COUNT(*) as count FROM fp_consultation INNER JOIN patients ON fp_consultation.patient_id = patients.id WHERE patients.address = 'Zone $zone'";
  $fp_result = $conn->query($fp_query);
  $fp_row = $fp_result->fetch_assoc();
  $fp_consultation[] = $fp_row['count'];

  $prenatal_query = "SELECT COUNT(*) as count FROM prenatal_consultation INNER JOIN patients ON prenatal_consultation.patient_id = patients.id WHERE patients.address = 'Zone $zone'";
  $prenatal_result = $conn->query($prenatal_query);
  $prenatal_row = $prenatal_result->fetch_assoc();
  $prenatal_consultation[] = $prenatal_row['count'];

  $consultations_query = "SELECT COUNT(*) as count FROM consultations INNER JOIN patients ON consultations.patient_id = patients.id WHERE patients.address = 'Zone $zone'";
  $consultations_result = $conn->query($consultations_query);
  $consultations_row = $consultations_result->fetch_assoc();
  $consultations[] = $consultations_row['count'];

  $immunization_query = "SELECT COUNT(*) as count FROM immunization INNER JOIN patients ON immunization.patient_id = patients.id WHERE patients.address = 'Zone $zone'";
  $immunization_result = $conn->query($immunization_query);
  $immunization_row = $immunization_result->fetch_assoc();
  $immunization[] = $immunization_row['count'];
}

$zones_json = json_encode($zones);
$fp_consultation_json = json_encode($fp_consultation);
$prenatal_consultation_json = json_encode($prenatal_consultation);
$consultations_json = json_encode($consultations);
$immunization_json = json_encode($immunization);



?>


<!-- Modal -->
<div class="modal fade" id="consultationmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Consult Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <canvas id="consult"></canvas>
        <script>
          document.addEventListener('DOMContentLoaded', function() {
            // Get context of the canvas element
            var ctx = document.getElementById("consult").getContext('2d');

            // Initialize Chart.js chart with initial data
            var consultationChart = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: ["Zone <?php echo implode('", "Zone ', json_decode($zones_json)); ?>"],
                datasets: [{
                    label: 'Consultation Counts',
                    data: <?php echo $consultations_json; ?>,
                    backgroundColor: 'rgba(153, 255, 51, 0.5)',
                    borderColor: 'rgba(153, 255, 51, 1)',
                    borderWidth: 1
                  }, {
                    label: 'Family Planning Consultation Counts',
                    data: <?php echo $fp_consultation_json; ?>,
                    backgroundColor: 'rgba(153, 255, 51, 0.5)',
                    borderColor: 'rgba(153, 255, 51, 1)',
                    borderWidth: 1
                  },
                  {
                    label: 'Prenatal Consultation Counts',
                    data: <?php echo $prenatal_consultation_json; ?>,
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                  },
                  {
                    label: 'Immunization Counts',
                    data: <?php echo $immunization_json; ?>,
                    backgroundColor: 'rgba(255, 206, 86, 0.5)',
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1
                  }
                ]
              },
              options: {
                scales: {
                  y: {
                    beginAtZero: true // Start y-axis at 0
                  }
                }
              }
            });
          });
        </script>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>