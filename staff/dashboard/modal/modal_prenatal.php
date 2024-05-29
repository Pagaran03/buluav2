<?php
// Include the database connection file
include('../../config.php'); // Replace with your actual database connection file

$prenatals = ['abortion', 'stillbirth', 'alive', 'trimester'];
$counters = [];

foreach ($prenatals as $prenatal) {
    // Construct the SQL query with date and age range filtering
    $sql = "SELECT COUNT(*) AS count FROM prenatal_subjective AS ps 
            INNER JOIN patients AS p ON ps.patient_id = p.id 
            WHERE ps.$prenatal IS NOT NULL AND ps.$prenatal <> 0";

    // Add age range condition (14 and above)
    $sql .= " AND p.age >= 14";

    // Execute the query
    $result = $conn->query($sql);

    // Check for query execution failure
    if ($result === false) {
        returnError('Query failed: ' . $conn->error);
    }

    // Fetch the count row
    $row = $result->fetch_assoc();
    $counters[] = $row['count'];
}

// Output $counters array as JSON
// echo json_encode($counters);
?>



 <!-- Modal -->
<!-- Modal for displaying prenatal details -->
<div class="modal fade" id="prenatalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Prenatal Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="ageSelect">Filter by</label>
            <select name="" id="ageSelect" class="form-control">
              <option value="">Age</option>
            </select>
          </div>
          <div class="form-group col-md-4">
            <label for="fromDatePicker">From Date</label>
            <input type="date" id="fromDatePicker" class="form-control">
          </div>
          <div class="form-group col-md-4">
            <label for="toDatePicker">To Date</label>
            <input type="date" id="toDatePicker" class="form-control">
          </div>
        </div>
        <canvas id="prenatalChart" width="400" height="150"></canvas>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get context of the canvas element
    var ctx = document.getElementById("prenatalChart").getContext('2d');

    // Function to update chart data based on selected date range
    function updateChartData(startDate, endDate) {
        // This is where you would handle the AJAX request to your server
        // and fetch updated data based on the selected date range
        // Once you have the data, update the chart as shown below

        // Example:
        var newData = [/* New data array based on selected date range */];

        // Update chart data
        prenatalChart.data.datasets[0].data = newData;
        prenatalChart.update();
    }

    // Initialize Chart.js chart with initial data
    var prenatalChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Abortion', 'Alive', 'Stillbirth', 'trimester'], // Labels for x-axis
            datasets: [{
                label: 'Prenatal Counts', // Label for the dataset
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

    // Event listener for date inputs change
    $('#fromDatePicker, #toDatePicker').change(function() {
        var startDate = $('#fromDatePicker').val();
        var endDate = $('#toDatePicker').val();
        // Check if both start and end dates are selected
        if (startDate && endDate) {
            updateChartData(startDate, endDate);
        }
    });
});

</script>

