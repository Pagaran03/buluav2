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
        <select name="" id="sel">
          <option value="All">Method Usage Count</option>
          <option value="zonals">Zone Report</option>
          <!-- <option value="MostlyAvailedMethod">Mostly Availed Method</option> -->
        </select>
        <select name="" id="znsel" hidden>
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

        <div class="row" id="famplanoptions" hidden>
          <ul style="list-style: none;" id="clitype">
            <li><label for="" style="margin-top: 20px;">Client Type:</label></li>
            <li><input class="form-check-input" type="checkbox" id="newacceptor">New Acceptor</li>
            <li><input class="form-check-input" type="checkbox" id="changemethod">Changing Method</li>
            <li><input class="form-check-input" type="checkbox" id="changeclinic">Change Clinic</li>
            <li><input class="form-check-input" type="checkbox" id="dropout">Dropout/Restart</li>
          </ul>

          <ul style="list-style: none;" id="rstm">
            <li><label for="" style="margin-top: 20px;">Risk for sexually transmitted disease:</label></li>
            <li><input class="form-check-input" type="checkbox" id="rstm1">Abnormal Discharge from genital area</li>
            <li><input class="form-check-input" type="checkbox" id="rstm2">Sore Ulcers</li>
            <li><input class="form-check-input" type="checkbox" id="rstm3">Pain or burning sensation in genital area</li>
            <li><input class="form-check-input" type="checkbox" id="rstm4">History of treatment for sexually transmitted disease</li>
            <li><input class="form-check-input" type="checkbox" id="rstm5">HIV/AIDS/Pelvic Inflammatory Disease</li>
          </ul>

          <ul style="list-style: none;" id="vawc">
            <li><label for="" style="margin-top: 20px;">Risk for violence against women:</label></li>
            <li><input class="form-check-input" type="checkbox" id="vawc1">Create an unpleasant relationship with partner</li>
            <li><input class="form-check-input" type="checkbox" id="vawc2">Partner does not approve</li>
            <li><input class="form-check-input" type="checkbox" id="vawc3">History of domestic Violence or VAW</li>
          </ul>
        </div>

        <canvas id="famplan"></canvas>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    var sel = document.getElementById("sel");
    var znsel = document.getElementById("znsel");
    var allChart, zonalsChart;

    function updateAllChart(url) {
      fetch(url)
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(data => {
          console.log(data);

          if (allChart) {
            allChart.destroy();
          }

          var labels = Object.keys(data);
          var counts = Object.values(data);

          var ctx = document.getElementById("famplan").getContext('2d');
          allChart = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: labels,
              datasets: [{
                label: 'Client Type Counts',
                data: counts,
                backgroundColor: "rgba(153,255,51,1)"
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
        })
        .catch(error => {
          console.error('There was a problem with the fetch operation:', error);
        });
    }

    function updateZonalsChart(url) {
      if (allChart) {
        allChart.destroy();
      }

      fetch(url)
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(data => {
          console.log(data);

          if (zonalsChart) {
            zonalsChart.destroy();
          }

          var ctx = document.getElementById("famplan").getContext('2d');
          var datasets = [];
          var colors = ["rgba(255, 99, 132, 0.2)", "rgba(54, 162, 235, 0.2)", "rgba(75, 192, 192, 0.2)", "rgba(153, 102, 255, 0.2)"];
          var borderColors = ["rgba(255, 99, 132, 1)", "rgba(54, 162, 235, 1)", "rgba(75, 192, 192, 1)", "rgba(153, 102, 255, 1)"];

          var zoneName = document.getElementById("znsel").value;
          var clientTypes = Object.keys(data);

          clientTypes.forEach((clientType, index) => {
            datasets.push({
              label: clientType,
              data: [data[clientType]],
              backgroundColor: colors[index % colors.length],
              borderColor: borderColors[index % borderColors.length],
              borderWidth: 1
            });
          });

          zonalsChart = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: [zoneName],
              datasets: datasets
            },
            options: {
              scales: {
                y: {
                  beginAtZero: true
                }
              }
            }
          });
        })
        .catch(error => {
          console.error('There was a problem with the fetch operation:', error);
        });
    }

    function buildUrl() {
      var selectedValue = sel.value;
      var url = 'modal/famplan_query.php?selectOptionFamplan=' + selectedValue;

      if (selectedValue === "zonals") {
        var zone = znsel.value;
        url += '&zone=' + zone;

        var checkboxes = document.querySelectorAll("#famplanoptions input[type='checkbox']");
        checkboxes.forEach(function(checkbox) {
          if (checkbox.checked) {
            url += '&' + checkbox.id + '=true';
          }
        });
      }

      return url;
    }

    function handleChange() {
      if (sel.value === "All") {
        updateAllChart('modal/famplan_query.php?selectOptionFamplan=All');
        znsel.setAttribute("hidden", "hidden");
        document.getElementById("famplanoptions").setAttribute("hidden", "hidden");
      } else if (sel.value === "zonals") {
        updateZonalsChart(buildUrl());
        znsel.removeAttribute("hidden");
        document.getElementById("famplanoptions").removeAttribute("hidden");
      }
    }

    sel.addEventListener("change", handleChange);
    znsel.addEventListener("change", function() {
      if (sel.value === "zonals") {
        updateZonalsChart(buildUrl());
      }
    });

    var checkboxes = document.querySelectorAll("#famplanoptions input[type='checkbox']");
    checkboxes.forEach(function(checkbox) {
      checkbox.addEventListener("change", function() {
        if (sel.value === "zonals") {
          updateZonalsChart(buildUrl());
        }
      });
    });

    // Initial chart rendering based on the default selection
    handleChange();
  });
</script>