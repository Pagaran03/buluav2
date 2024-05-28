<!-- Modal -->
<div class="modal fade" id="immunizationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Immunization Details</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <canvas id="myCharts" width="400" height="190"></canvas>
<script>
  var ctx = document.getElementById("myCharts").getContext('2d');
  var data = <?php echo json_encode($countss); ?>;

  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [
        'BCG', 'Hepatitis A', 'Pentavalent 1', 'Pentavalent 2', 'Pentavalent 3', 
        'Oral Polio 1', 'Oral Polio 2', 'Oral Polio 3', 'IPV 1', 'IPV 2', 
        'PCV 1', 'PCV 2', 'PCV 3', 'MMR 1', 'MMR 2', 
        'MCV 1', 'MCV 2'
      ],
      datasets: [{
        label: 'Immunization Counts',
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