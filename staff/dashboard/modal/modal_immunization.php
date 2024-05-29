<!-- Modal for displaying immunization report -->
<div class="modal fade" id="immunizationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Immunization Report</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Dropdown to select sorting option -->
        <span>Sort Demographic Data by:</span>
        <select id="selectOption">
          <option value="Date">Date</option>
          <option value="Gender">Gender</option>
          <option value="MAV">Most availed Vaccine</option>
          <option value="LAV">Least availed Vaccine</option>
        </select>
        <!-- Date range inputs -->
        <label for="frmDate" id="lbl1">From:</label>
        <input type="date" id="frmDate" name="frmDate">
        <label for="toDate" id="lbl2">To:</label>
        <input type="date" id="toDate" name="toDate">

        <!-- ZONE PICKER -->
        <label for="zonalSelect" id="zid"> | Select Zone: </label>
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
          <option value="Zone 11">Zone 11</option>
          <option value="Zone 12">Zone 12</option>
        </select>

        <!-- Canvas for Chart.js chart -->
        <canvas id="myCharts" width="400" height="200"></canvas>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById("myCharts").getContext('2d');
    var myCharts;

    // Function to fetch data based on selected option and date range using AJAX
    function fetchData(selectOption, frmDate, toDate) {
      // Construct URL for AJAX request to immu_query.php
      var url = 'modal/immu_query.php?selectOption=' + encodeURIComponent(selectOption) +
        '&frmDate=' + encodeURIComponent(frmDate) +
        '&toDate=' + encodeURIComponent(toDate);

      // Make AJAX request
      fetch(url)
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(data => {
          // Check if the response contains an error
          if (data.error) {
            throw new Error(data.error);
          }

          // Update chart data
          if (myCharts) {
            myCharts.data.datasets[0].data = data;
            myCharts.update();
          }
        })
        .catch(error => {
          console.error('Error fetching data:', error);
        });
    }

    // Function to update chart based on selected option
    function updateChart() {
      var selectOption = document.getElementById("selectOption").value;

      if (myCharts) {
        myCharts.destroy(); // Destroy existing chart if it exists
      }

      if (selectOption === "Date") {
        document.getElementById("frmDate").removeAttribute("hidden");
        document.getElementById("toDate").removeAttribute("hidden");
        document.getElementById("lbl1").removeAttribute("hidden");
        document.getElementById("lbl2").removeAttribute("hidden");
        document.getElementById("zonalSelect").setAttribute("hidden", "hidden");
        document.getElementById("zid").setAttribute("hidden", "hidden");

        var frmDate = document.getElementById("frmDate").value;
        var toDate = document.getElementById("toDate").value;

        // Call function to fetch data
        fetchData(selectOption, frmDate, toDate);

        // Initialize chart with empty data (data will be updated after AJAX call)
        myCharts = new Chart(ctx, {
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
              data: [],
              backgroundColor: "rgba(153,255,51,1)"
            }]
          }
        });
      } else if (selectOption === "Gender") {
        document.getElementById("frmDate").setAttribute("hidden", "hidden");
        document.getElementById("toDate").setAttribute("hidden", "hidden");
        document.getElementById("lbl1").setAttribute("hidden", "hidden");
        document.getElementById("lbl2").setAttribute("hidden", "hidden");
        document.getElementById("zonalSelect").setAttribute("hidden", "hidden");
        document.getElementById("zid").setAttribute("hidden", "hidden");

        // Call function to fetch data
        fetchData(selectOption);

        // Initialize chart with empty data (data will be updated after AJAX call)
        myCharts = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: ["Male", "Female"],
            datasets: [{
              label: 'Immunization Counts',
              data: [], // Data will be filled after fetchData call
              backgroundColor: ["rgba(54, 162, 235, 1)", "rgba(255, 99, 132, 1)"], // Separate colors for Male and Female
              borderColor: ["rgba(54, 162, 235, 1)", "rgba(255, 99, 132, 1)"], // Border colors for better visualization
              borderWidth: 1
            }]
          },
          options: {
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });
      } else if (selectOption === "MAV" || selectOption === "LAV") {
        document.getElementById("frmDate").setAttribute("hidden", "hidden");
        document.getElementById("toDate").setAttribute("hidden", "hidden");
        document.getElementById("lbl1").setAttribute("hidden", "hidden");
        document.getElementById("lbl2").setAttribute("hidden", "hidden");
        document.getElementById("zonalSelect").removeAttribute("hidden");
        document.getElementById("zid").removeAttribute("hidden");
      }
    }

    // Call updateChart initially and on selectOption change
    updateChart(); // Initial call

    document.getElementById("selectOption").addEventListener("change", updateChart);

    // Add event listeners for frmDate and toDate inputs to update chart on change
    document.getElementById("frmDate").addEventListener("change", updateChart);
    document.getElementById("toDate").addEventListener("change", updateChart);
  });
</script>
