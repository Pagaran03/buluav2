 <?php
 $consults = ['subjective', 'objective', 'assessment', 'plan'];

 // Initialize an array to store the counts
 $countsss = array();
 
 foreach ($consults as $consult) {
   // Assuming $conn is your database connection
   $sql = "SELECT COUNT($consult) AS count FROM consultations"; // Replace 'your_table' with your actual table name
   $result = $conn->query($sql);
 
   if ($result === false) {
     die("Query failed: " . $conn->error);
   }
 
   $row = $result->fetch_assoc();
   $countsss[] = $row['count'];
 }
 
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