  <?php
  $fams = ['method', 'method', 'method', 'method', 'method', 'method', 'method', 'method', 'method', 'method', 'method', 'method', 'method', 'method', 'method', 'method', 'method']; // Added 'method' twice for 'NSV' and 'condom'

  // Initialize an array to store the counts
  $countssss = array();
  
  // Define the methods you want to count
  $methodsToCount = ['BTL', 'NSV', 'condom', 'Pills-POP', 'Pills', 'Pills-COC', 'Injectables (DMPA/POI)', 'Implant', 'Hormonal IUD', 'IUD', 'IUD-I', 'IUD-PP', 'NFP-LAM', 'NFP-BBT', 'NFP-CMM', 'NFP-STM', 'NFP-SDM'];
  
  // Iterate over each method
  foreach ($methodsToCount as $methodToCount) {
      // Construct the SQL query to count occurrences of the method
      $sql = "SELECT COUNT(*) AS count FROM fp_consultation WHERE method = '$methodToCount'";
      $result = $conn->query($sql);
  
      if ($result === false) {
          die("Query failed: " . $conn->error);
      }
  
      // Fetch the count from the result
      $row = $result->fetch_assoc();
      $count = $row['count'];
  
      // Store count with method as key
      $countssss[ucwords($methodToCount)] = $count;
  }
  ?>
  
  
  
  
  <!-- Modal -->
  <div class="modal fade" id="famplanmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Family Planning Method Details</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <select name="" id="">
                        <option value="">Gender</option>
                    </select>
                  <canvas id="fam"></canvas>
                  <script>
  // Define methodsToCount array in JavaScript
  var methodsToCount = <?php echo json_encode($methodsToCount); ?>;

  // PHP variables containing counts should be defined before this script block

  // Ensure data is correctly fetched and available as an associative array in PHP ($countssss)

  // Then, convert PHP associative array to JavaScript object using JSON encoding
  var data = <?php echo json_encode($countssss); ?>;

  // Now, create the Chart using Chart.js
  var ctx = document.getElementById("fam").getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: methodsToCount,
      datasets: [{
        label: 'Immunization Counts',
        data: Object.values(data), // Use Object.values() to get data array from associative array
        backgroundColor: "rgba(153,255,51,1)"
      }]
    }
  });
</script>      </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>