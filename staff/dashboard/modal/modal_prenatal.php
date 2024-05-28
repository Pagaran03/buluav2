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