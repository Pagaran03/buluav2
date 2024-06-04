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
        <!-- Select for options -->
        <span>Sort Demographic Data by:</span>
        <select id="selectOptionFamplan">
          <option value="Date">Date</option>
          <option value="Gender">Gender</option>
          <option value="MAFP">Commonly Used Method</option>
          <option value="Zonal">Zonal Report</option>
        </select>

        <!-- Date range inputs -->
        <label id="lbl1">From Date: <input type="date" id="frmDatefp"></label>
        <label id="lbl2">To Date: <input type="date" id="toDatefp"></label>

        <!-- Zone select for MAV -->
        <label for="zonalSelectFamplan" id="zonalSelectLabel">Zone: |</label>
        <select id="zonalSelectFamplan" hidden>
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

        <!-- Canvas for chart -->
        <canvas id="fam"></canvas>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById("fam").getContext('2d');
    var myChartfp;

    function fetchData(selectOption, frmDatefp, toDatefp, zone) {
      var url = 'modal/famplan_query.php?selectOption=' + encodeURIComponent(selectOption) +
        '&frmDatefp=' + encodeURIComponent(frmDatefp) +
        '&toDatefp=' + encodeURIComponent(toDatefp) +
        '&zone=' + encodeURIComponent(zone);

      fetch(url)
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.text(); // Get the response as text
        })
        .then(text => {
          // Split the response text by the delimiter between JSON objects (assuming '\n' as a delimiter here)
          const jsonObjects = text.split('\n').filter(Boolean); // Filter out any empty strings
          const data = jsonObjects.map(jsonStr => {
            try {
              return JSON.parse(jsonStr);
            } catch (error) {
              console.error('Error parsing JSON:', jsonStr);
              throw error;
            }
          });

          if (myChartfp) {
            myChartfp.destroy();
          }

          if (selectOption === "Date") {
            var methods = Object.keys(data[0].methods);
            var counts = Object.values(data[0].methods);
            myChartfp = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: methods,
                datasets: [{
                  label: 'Method Counts',
                  data: counts,
                  backgroundColor: 'rgba(75, 192, 192, 0.7)',
                  borderColor: 'rgba(75, 192, 192, 1)',
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
          } else if (selectOption === "Gender") {
            var methods = Object.keys(data[0].male);
            var maleCounts = Object.values(data[0].male);
            var femaleCounts = Object.values(data[0].female);

            myChartfp = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: methods,
                datasets: [{
                  label: 'Male',
                  data: maleCounts,
                  backgroundColor: "rgba(54, 162, 235, 0.7)",
                  borderColor: "rgba(54, 162, 235, 1)",
                  borderWidth: 1
                }, {
                  label: 'Female',
                  data: femaleCounts,
                  backgroundColor: "rgba(255, 99, 132, 0.7)",
                  borderColor: "rgba(255, 99, 132, 1)",
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
          } else if (selectOption === "MAFP") {
            var methods = Object.keys(data[0].count);
            var counts = Object.values(data[0].count);

            myChartfp = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: methods,
                datasets: [{
                  label: 'Method Counts',
                  data: counts,
                  backgroundColor: 'rgba(75, 192, 192, 0.7)',
                  borderColor: 'rgba(75, 192, 192, 1)',
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
          }
        })
        .catch(error => {
          console.error('Error fetching data:', error);
        });
    }

    function updateChart() {
      var selectOption = document.getElementById("selectOptionFamplan").value;
      var frmDatefp = document.getElementById("frmDatefp").value;
      var toDatefp = document.getElementById("toDatefp").value;
      var zone = document.getElementById("zonalSelectFamplan").value;

      if (selectOption === "Date") {
        document.getElementById("zonalSelectFamplan").setAttribute("hidden", "hidden");
        document.getElementById("zonalSelectLabel").setAttribute("hidden", "hidden");
      }
      if (selectOption === "Gender") {
        document.getElementById("zonalSelectFamplan").removeAttribute("hidden");
        document.getElementById("frmDatefp").removeAttribute("hidden");
        document.getElementById("toDatefp").removeAttribute("hidden");
        document.getElementById("lbl1").removeAttribute("hidden");
        document.getElementById("lbl2").removeAttribute("hidden");
        document.getElementById("zonalSelectLabel").removeAttribute("hidden");
      }

      if (selectOption === "MAFP") {
        document.getElementById("zonalSelectFamplan").removeAttribute("hidden");
        document.getElementById("zonalSelectLabel").removeAttribute("hidden");
      }

      fetchData(selectOption, frmDatefp, toDatefp, zone);
    }

    updateChart(); // Initial call

    document.getElementById("selectOptionFamplan").addEventListener("change", updateChart);
    document.getElementById("frmDatefp").addEventListener("change", updateChart);
    document.getElementById("toDatefp").addEventListener("change", updateChart);
    document.getElementById("zonalSelectFamplan").addEventListener("change", updateChart);
  });
</script>