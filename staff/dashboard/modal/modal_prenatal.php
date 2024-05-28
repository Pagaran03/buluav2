 <?php
 // Prenatal
$prenatals = ['abortion', 'stillbirth', 'alive'];
$alive = 'alive';
$counters = array();

foreach ($prenatals as $prenatal) {
    // Count query
    $count_sql = "SELECT COUNT(*) AS count FROM prenatal_subjective WHERE $prenatal IS NOT NULL AND $prenatal <> 0";
    $count_result = $conn->query($count_sql);

    if ($count_result === false) {
        die("Count query failed: " . $conn->error);
    }

    $count_row = $count_result->fetch_assoc();
    $counters[] = $count_row['count'];

    // Sum query
    $sum_sql = "SELECT SUM($alive) AS sum FROM prenatal_subjective WHERE $alive IS NOT NULL AND $alive <> 0";
    $sum_result = $conn->query($sum_sql);

    if ($sum_result === false) {
        die("Sum query failed: " . $conn->error);
    }

    $sum_row = $sum_result->fetch_assoc();
    $counters[] = $sum_row['sum'];
}

 ?>
 
 
 <!-- Modal -->
 <div class="modal fade" id="prenatalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Prenatal Details</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <select name="" id="">
                <option value="">Age</option>
            
              </select>
            <canvas id="prenatal" width="400" height="400"></canvas>
            <script>
  var ctx = document.getElementById("prenatal").getContext('2d');
  var data = <?php echo json_encode($counters); ?>;

  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [
        'abortion', 'alive', 'stillbirth'
      ],
      datasets: [{
        label: 'Prenatal Counts',
        data: data,
        backgroundColor: "rgba(153,255,51,1)"
      }]
    }
  });
</script>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>