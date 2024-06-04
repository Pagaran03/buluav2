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
        <label for="">Sort Demographic Data by: </label>

        <select name="" id="consultSelect">
          <option value="All">
            All
          </option>
          <option value="ZonalReport">Zonal Report</option>
        </select>

        <label for="consultation_zonalSelects" id="czid" hidden> | Select Zone: </label>
        <select name="" id="consultation_zonalSelects" name="zones" hidden>
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

        <label for="consultation_dates" id="csdate" hidden> | Select Starting Date: </label>
        <input type="date" name="" id="cFromDate" hidden>
        <label for="consultation_dates" id="cedate" hidden> | Select End Date: </label>
        <input type="date" name="" id="cEndDate" hidden>

        <div class="row" style="margin-top: 15px;">

          <ul id="skinCondition" style="list-style: none;" hidden>
            <label for="">Skin Condition:</label>
            <li><input type="checkbox" class="form-check-input" name="normal" id="normal">Normal</li>
            <li><input type="checkbox" class="form-check-input" name="pale" id="pale">Pale</li>
            <li><input type="checkbox" class="form-check-input" name="yellowish" id="yellowish">Yellowish</li>
            <li><input type="checkbox" class="form-check-input" name="hematoma" id="hematoma">Hematoma</li>
          </ul>

          <ul id="conjunctivaOptions" style="list-style: none;" hidden>
            <label for="">Conjunctiva:</label>
            <li><input type="checkbox" class="form-check-input" name="cnormal" id="cnormal">Normal</li>
            <li><input type="checkbox" class="form-check-input" name="cpale" id="cpale">Pale</li>
            <li><input type="checkbox" class="form-check-input" name="cyellowish" id="cyellowish">Yellowish</li>
          </ul>

          <ul id="extremitiesOptions" style="list-style: none;" hidden>
            <label for="">Extremities:</label>
            <li><input type="checkbox" class="form-check-input" name="exnormal" id="exnormal">Normal</li>
            <li><input type="checkbox" class="form-check-input" name="edema" id="edema">Edema</li>
            <li><input type="checkbox" class="form-check-input" name="varicosities" id="varicosities">Varicosities</li>
          </ul>

          <ul id="neckOptions" style="list-style: none;" hidden>
            <label for="">Neck:</label>
            <li><input type="checkbox" class="form-check-input" name="neck_normal" id="neck_normal">Normal</li>
            <li><input type="checkbox" class="form-check-input" name="enlarge_lymph" id="enlarge_lymph">Enlarge Lymph Nodes</li>
          </ul>

        </div>

        <canvas id="consultCanvas"></canvas>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var consultation_ctx = document.getElementById("consultCanvas").getContext('2d');
    var consultSelect = document.getElementById("consultSelect");
    var consultationCharts;

    initializeChart();

    function getCheckboxValues() {
      return {
        normalChecked: document.getElementById("normal").checked,
        paleChecked: document.getElementById("pale").checked,
        yellowishChecked: document.getElementById("yellowish").checked,
        hematomaChecked: document.getElementById("hematoma").checked,
        cnormalChecked: document.getElementById("cnormal").checked,
        cpaleChecked: document.getElementById("cpale").checked,
        cyellowishChecked: document.getElementById("cyellowish").checked,
        exnormalChecked: document.getElementById("exnormal").checked,
        edemaChecked: document.getElementById("edema").checked,
        varicositiesChecked: document.getElementById("varicosities").checked,
        neck_normalChecked: document.getElementById("neck_normal").checked,
        enlarge_lymphChecked: document.getElementById("enlarge_lymph").checked,
        zone: document.getElementById("consultation_zonalSelects").value
      };
    }

    consultSelect.addEventListener("change", function() {
      var selectedValue = consultSelect.value;
      if (selectedValue === "All") {
        hideOptions();
        initializeChart();
      } else if (selectedValue === "ZonalReport") {
        showOptions();
        updateDataAndChart();
      }
    });

    // Add event listener for zone selection change
    document.getElementById("consultation_zonalSelects").addEventListener("change", updateDataAndChart);

    function hideOptions() {
      document.getElementById("consultation_zonalSelects").setAttribute("hidden", "hidden");
      document.getElementById("czid").setAttribute("hidden", "hidden");
      document.getElementById("skinCondition").setAttribute("hidden", "hidden");
      document.getElementById("conjunctivaOptions").setAttribute("hidden", "hidden");
      document.getElementById("extremitiesOptions").setAttribute("hidden", "hidden");
      document.getElementById("neckOptions").setAttribute("hidden", "hidden");
      document.getElementById("csdate").setAttribute("hidden", "hidden");
      document.getElementById("cFromDate").setAttribute("hidden", "hidden");
      document.getElementById("cedate").setAttribute("hidden", "hidden");
      document.getElementById("cEndDate").setAttribute("hidden", "hidden");
    }

    function showOptions() {
      document.getElementById("consultation_zonalSelects").removeAttribute("hidden");
      document.getElementById("czid").removeAttribute("hidden");
      document.getElementById("skinCondition").removeAttribute("hidden");
      document.getElementById("conjunctivaOptions").removeAttribute("hidden");
      document.getElementById("extremitiesOptions").removeAttribute("hidden");
      document.getElementById("neckOptions").removeAttribute("hidden");
      document.getElementById("csdate").removeAttribute("hidden");
      document.getElementById("cFromDate").removeAttribute("hidden");
      document.getElementById("cedate").removeAttribute("hidden");
      document.getElementById("cEndDate").removeAttribute("hidden");
    }

    function initializeChart() {
      var selectedValue = consultSelect.value;
      if (selectedValue === "All") {
        fetch('modal/consultation_query.php?consultSelect=All')
          .then(response => response.json())
          .then(data => {
            if (consultationCharts) {
              consultationCharts.destroy();
            }
            consultationCharts = new Chart(consultation_ctx, {
              type: 'bar',
              data: {
                labels: data.zones.map(zone => 'Zone ' + zone),
                datasets: [{
                    label: 'Consultation Counts',
                    data: data.consultations,
                    backgroundColor: 'rgba(153, 255, 51, 0.5)',
                    borderColor: 'rgba(153, 255, 51, 1)',
                    borderWidth: 1
                  },
                  {
                    label: 'Family Planning Consultation Counts',
                    data: data.fp_consultation,
                    backgroundColor: 'rgba(153, 255, 51, 0.5)',
                    borderColor: 'rgba(153, 255, 51, 1)',
                    borderWidth: 1
                  },
                  {
                    label: 'Prenatal Consultation Counts',
                    data: data.prenatal_consultation,
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                  },
                  {
                    label: 'Immunization Counts',
                    data: data.immunization,
                    backgroundColor: 'rgba(255, 206, 86, 0.5)',
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1
                  }
                ]
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
          .catch(error => console.error('Error fetching data:', error));
      } else if (selectedValue === "ZonalReport") {
        updateDataAndChart();
      }
    }

    function updateDataAndChart() {
      var checkboxValues = getCheckboxValues();
      fetchData(
        consultSelect.value,
        '', '',
        checkboxValues.zone,
        checkboxValues.normalChecked,
        checkboxValues.paleChecked,
        checkboxValues.yellowishChecked,
        checkboxValues.hematomaChecked,
        checkboxValues.cnormalChecked,
        checkboxValues.cpaleChecked,
        checkboxValues.cyellowishChecked,
        checkboxValues.exnormalChecked,
        checkboxValues.edemaChecked,
        checkboxValues.varicositiesChecked,
        checkboxValues.neck_normalChecked,
        checkboxValues.enlarge_lymphChecked
      );
    }

    document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
      checkbox.addEventListener('change', updateDataAndChart);
    });

    function fetchData(selectOption, frmDatefp, toDatefp, zone, normalChecked, paleChecked, yellowishChecked, hematomaChecked, cnormalChecked, cpaleChecked, cyellowishChecked, exnormalChecked, edemaChecked, varicositiesChecked, neck_normalChecked, enlarge_lymphChecked) {
      var url = 'modal/consultation_query.php?selectOption=' + encodeURIComponent(selectOption) +
        '&frmDatefp=' + encodeURIComponent(frmDatefp) +
        '&toDatefp=' + encodeURIComponent(toDatefp) +
        '&zone=' + encodeURIComponent(zone) +
        '&normalChecked=' + encodeURIComponent(normalChecked) +
        '&paleChecked=' + encodeURIComponent(paleChecked) +
        '&yellowishChecked=' + encodeURIComponent(yellowishChecked) +
        '&hematomaChecked=' + encodeURIComponent(hematomaChecked) +
        '&cnormalChecked=' + encodeURIComponent(cnormalChecked) +
        '&cpaleChecked=' + encodeURIComponent(cpaleChecked) +
        '&cyellowishChecked=' + encodeURIComponent(cyellowishChecked) +
        '&exnormalChecked=' + encodeURIComponent(exnormalChecked) +
        '&edemaChecked=' + encodeURIComponent(edemaChecked) +
        '&varicositiesChecked=' + encodeURIComponent(varicositiesChecked) +
        '&neck_normalChecked=' + encodeURIComponent(neck_normalChecked) +
        '&enlarge_lymphChecked=' + encodeURIComponent(enlarge_lymphChecked);

      fetch(url)
        .then(response => response.json())
        .then(data => {
          const datasets = [];

          if (normalChecked) {
            datasets.push({
              label: 'Normal Skin',
              data: [data.normalSkinCount],
              backgroundColor: "rgba(255, 159, 64, 0.8)"
            });
          }
          if (paleChecked) {
            datasets.push({
              label: 'Pale Skin',
              data: [data.paleSkinCount],
              backgroundColor: "rgba(255, 206, 86, 0.8)"
            });
          }

          if (yellowishChecked) {
            datasets.push({
              label: 'Yellowish Skin',
              data: [data.yellowishSkinCount],
              backgroundColor: "rgba(75, 192, 192, 0.8)"
            });
          }
          if (hematomaChecked) {
            datasets.push({
              label: 'Hematoma',
              data: [data.hematomaCount],
              backgroundColor: "rgba(153, 102, 255, 0.8)"
            });
          }
          if (cnormalChecked) {
            datasets.push({
              label: 'Conjunctiva Normal Skin',
              data: [data.cnormalCount],
              backgroundColor: "rgbA(137, 219, 255,0.8)"
            });
          }
          if (cpaleChecked) {
            datasets.push({
              label: 'Conjunctiva Pale Skin',
              data: [data.cpaleCount],
              backgroundColor: "rgba(226, 147, 196, 0.8)"
            });
          }
          if (cyellowishChecked) {
            datasets.push({
              label: 'Conjunctiva Yellowish Skin',
              data: [data.cpacyellowishCountleCount],
              backgroundColor: "rgba(223, 224, 137, 0.8)"
            });
          }
          if (exnormalChecked) {
            datasets.push({
              label: 'Extremities Normal Skin',
              data: [data.exnormalCount],
              backgroundColor: "rgba(224, 137, 144, 0.8)"
            });
          }
          if (edemaChecked) {
            datasets.push({
              label: 'Extremities Edema Skin',
              data: [data.edemaCount],
              backgroundColor: "rgba(222, 78, 120, 0.8)"
            });
          }
          if (varicositiesChecked) {
            datasets.push({
              label: 'Extremities Varicosities Skin',
              data: [data.varicositiesCount],
              backgroundColor: "rgba(94, 54, 240, 0.8)"
            });
          }
          if (neck_normalChecked) {
            datasets.push({
              label: 'Normal Neck',
              data: [data.neck_normalCount],
              backgroundColor: "rgba(91, 74, 152, 0.77)"
            });
          }
          if (enlarge_lymphChecked) {
            datasets.push({
              label: 'Normal Neck',
              data: [data.enlarge_lymphCount],
              backgroundColor: "rgba(232, 150, 89, 0.77)"
            });
          }

          if (consultationCharts) {
            consultationCharts.destroy();
          }

          consultationCharts = new Chart(consultation_ctx, {
            type: 'bar',
            data: {
              labels: [zone],
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
        .catch(error => console.error('Error fetching data:', error));
    }
  });
</script>