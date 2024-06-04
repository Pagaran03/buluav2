<?php
// Initialize arrays to store the data
$zones = range(1, 12);
$fp_consultation = [];
$prenatal_consultation = [];
$consultations = [];
$immunization = [];

foreach ($zones as $zone) {
    $fp_query = "SELECT COUNT(*) as count FROM fp_consultation WHERE zone = $zone";
    $fp_result = $conn->query($fp_query);
    $fp_row = $fp_result->fetch_assoc();
    $fp_consultation[] = $fp_row['count'];
    
    $prenatal_query = "SELECT COUNT(*) as count FROM prenatal_consultation WHERE zone = $zone";
    $prenatal_result = $conn->query($prenatal_query);
    $prenatal_row = $prenatal_result->fetch_assoc();
    $prenatal_consultation[] = $prenatal_row['count'];
    
    $consultations_query = "SELECT COUNT(*) as count FROM consultations WHERE zone = $zone";
    $consultations_result = $conn->query($consultations_query);
    $consultations_row = $consultations_result->fetch_assoc();
    $consultations[] = $consultations_row['count'];
    
    $immunization_query = "SELECT COUNT(*) as count FROM immunization WHERE zone = $zone";
    $immunization_result = $conn->query($immunization_query);
    $immunization_row = $immunization_result->fetch_assoc();
    $immunization[] = $immunization_row['count'];
}

$conn->close();

// Convert PHP arrays to JSON
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
    document.addEventListener('DOMContentLoaded', function () {
        // Get context of the canvas element
        var ctx = document.getElementById("consult").getContext('2d');

        // Initialize Chart.js chart with initial data
        var consultationChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($consults); ?>, // Labels for x-axis
                datasets: [{
                    label: 'Consultation Counts', // Label for the dataset
                    data: <?php echo json_encode($counters); ?>, // Initial data for the chart
                    backgroundColor: 'rgba(153, 255, 51, 0.5)', // Background color for bars
                    borderColor: 'rgba(153, 255, 51, 1)', // Border color for bars
                    borderWidth: 1 // Border width for bars
                }]
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