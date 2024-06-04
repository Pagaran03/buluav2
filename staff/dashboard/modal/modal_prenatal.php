<!-- Modal -->
<div class="modal fade" id="prenatalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Prenatal Report Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Select for options -->
        <span>Sort Demographic Data by:</span>
        <select id="selectOptionFamplan">
          <option value="All">All</option>
          <option value="Zonal">Zonal Report</option>
        </select>

        <!-- Date range inputs -->
        <label id="lbl1">From Date: <input type="date" id="frmDatefp"></label>
        <label id="lbl2">To Date: <input type="date" id="toDatefp"></label>

        <!-- Zone select for MAV -->
        <label for="zonalSelectPrenatal" id="zonalSelectLabel">Zone: |</label>
        <select id="zonalSelectPrenatal" hidden>
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

        <ul id="more_filter" style="list-style: none;">
          <li><b>DOES THE CLIENT HAVE ANY OF THE FOLLOWING:</b></li>
          <li><input class="form-check-input" type="checkbox" id="forceps" style="margin-right: 10px;">Forceps Delivery</li>
          <li><input class="form-check-input" type="checkbox" id="smoking" style="margin-right: 10px;">Smoking</li>
          <li><input class="form-check-input" type="checkbox" id="alcohol" style="margin-right: 10px;">Allergy to alcohol intake</li>
          <li><input class="form-check-input" type="checkbox" id="cesarean" style="margin-right: 10px;">Previous Cesarean Section</li>
          <li><input class="form-check-input" type="checkbox" id="3-miscarriages" style="margin-right: 10px;">3 Consecutive Miscarriages</li>
          <li><input class="form-check-input" type="checkbox" id="ectopic" style="margin-right: 10px;">Ectopic</li>
          <li><input class="form-check-input" type="checkbox" id="postpartum-bleed" style="margin-right: 10px;">Postpartum Bleeding</li>
          <li><input class="form-check-input" type="checkbox" id="babyweightgreaterthan4" style="margin-right: 10px;">Baby Weight > 4kgs</li>
          <li><input class="form-check-input" type="checkbox" id="asthma" style="margin-right: 10px;">Asthma</li>
          <li><input class="form-check-input" type="checkbox" id="goiter" style="margin-right: 10px;">Goiter</li>
          <li><input class="form-check-input" type="checkbox" id="premacontract" style="margin-right: 10px;">Premature Contractions</li>
          <li><input class="form-check-input" type="checkbox" id="diabetismellitus" style="margin-right: 10px;">Diabetes Mellitus</li>
          <li><input class="form-check-input" type="checkbox" id="heart_disease" style="margin-right: 10px;">Heart Disease</li>
          <li><input class="form-check-input" type="checkbox" id="obese" style="margin-right: 10px;">Obesity</li>
        </ul>
        <!-- Canvas for chart -->
        <canvas id="prenatal"></canvas>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById("prenatal").getContext('2d');
    var myChartfp;

    var forceps = document.getElementById("forceps");

    function fetchData(selectOption, frmDatefp, toDatefp, zone, forcepsChecked, smokingChecked, alcoholChecked, cesareanChecked, miscarriagesChecked, ectopicChecked, postpartumBleedChecked, babyWeightChecked, asthmaChecked, goiterChecked, premacontractChecked, diabetismellitusChecked, heartDiseaseChecked, obeseChecked) {
      var url = 'modal/prenatal_query.php?selectOption=' + encodeURIComponent(selectOption) +
        '&frmDatefp=' + encodeURIComponent(frmDatefp) +
        '&toDatefp=' + encodeURIComponent(toDatefp) +
        '&zone=' + encodeURIComponent(zone) +
        '&forceps=' + (forcepsChecked ? '1' : '0') +
        '&smoking=' + (smokingChecked ? '1' : '0') +
        '&alcohol=' + (alcoholChecked ? '1' : '0') +
        '&cesarean=' + (cesareanChecked ? '1' : '0') +
        '&3-miscarriages=' + (miscarriagesChecked ? '1' : '0') +
        '&ectopic=' + (ectopicChecked ? '1' : '0') +
        '&postpartum-bleed=' + (postpartumBleedChecked ? '1' : '0') +
        '&babyweightgreaterthan4=' + (babyWeightChecked ? '1' : '0') +
        '&asthma=' + (asthmaChecked ? '1' : '0') +
        '&goiter=' + (goiterChecked ? '1' : '0') +
        '&premacontract=' + (premacontractChecked ? '1' : '0') +
        '&diabetismellitus=' + (diabetismellitusChecked ? '1' : '0') +
        '&heart_disease=' + (heartDiseaseChecked ? '1' : '0') +
        '&obese=' + (obeseChecked ? '1' : '0');

      fetch(url)
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(jsonData => {
          if (myChartfp) {
            myChartfp.destroy();
          }
          if (selectOption === "All") {
            const zoneCount = Object.keys(jsonData.zoneCounts);
            myChartfp = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: zoneCount,
                datasets: [{
                    label: 'Abortion',
                    data: zoneCount.map(zone => jsonData.zoneCounts[zone]['abortion']),
                    backgroundColor: "rgba(69, 219, 355, 0.8)"
                  },
                  {
                    label: 'Stillbirth',
                    data: zoneCount.map(zone => jsonData.zoneCounts[zone]['stillbirth']),
                    backgroundColor: "rgba(69, 55, 255, 0.66)"
                  },
                  {
                    label: 'Alive',
                    data: zoneCount.map(zone => jsonData.zoneCounts[zone]['alive']),
                    backgroundColor: "rgba(255, 69, 69, 0.8)"
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
          }
          if (selectOption === "Zonal") {
            const datasets = [];

            if (forcepsChecked) {
              const forcepCounts = jsonData.forcepCounts;
              console.log(forcepCounts);
              datasets.push({
                label: 'Forceps',
                data: [forcepCounts],
                backgroundColor: "rgba(123, 104, 238, 0.8)"
              });
            }

            if (smokingChecked) {
              const smokingCounts = jsonData.smokingCounts;
              datasets.push({
                label: 'Smoking',
                data: [smokingCounts],
                backgroundColor: "rgba(255, 99, 132, 0.8)"
              });
            }

            if (alcoholChecked) {
              const alcoholCounts = jsonData.alcoholCounts;
              datasets.push({
                label: 'Alcohol',
                data: [alcoholCounts],
                backgroundColor: "rgba(255, 159, 64, 0.8)"
              });
            }

            if (cesareanChecked) {
              const cesareanCounts = jsonData.cesareanCounts;
              datasets.push({
                label: 'Cesarean',
                data: [cesareanCounts],
                backgroundColor: "rgba(54, 162, 235, 0.8)"
              });
            }

            if (miscarriagesChecked) {
              const miscarriagesCounts = jsonData.miscarriagesCounts;
              datasets.push({
                label: '3 Miscarriages',
                data: [miscarriagesCounts],
                backgroundColor: "rgba(255, 206, 86, 0.8)"
              });
            }

            if (ectopicChecked) {
              const ectopicCounts = jsonData.ectopicCounts;
              datasets.push({
                label: 'Ectopic',
                data: [ectopicCounts],
                backgroundColor: "rgba(75, 192, 192, 0.8)"
              });
            }

            if (postpartumBleedChecked) {
              const postpartumBleedCounts = jsonData.postpartumBleedCounts;
              datasets.push({
                label: 'Postpartum Bleed',
                data: [postpartumBleedCounts],
                backgroundColor: "rgba(153, 102, 255, 0.8)"
              });
            }

            if (babyWeightChecked) {
              const babyWeightCounts = jsonData.babyWeightCounts;
              datasets.push({
                label: 'Baby Weight > 4kg',
                data: [babyWeightCounts],
                backgroundColor: "rgba(255, 159, 64, 0.8)"
              });
            }

            if (asthmaChecked) {
              const asthmaCounts = jsonData.asthmaCounts;
              datasets.push({
                label: 'Asthma',
                data: [asthmaCounts],
                backgroundColor: "rgba(255, 99, 132, 0.8)"
              });
            }

            if (goiterChecked) {
              const goiterCounts = jsonData.goiterCounts;
              datasets.push({
                label: 'Goiter',
                data: [goiterCounts],
                backgroundColor: "rgba(54, 162, 235, 0.8)"
              });
            }

            if (premacontractChecked) {
              const premacontractCounts = jsonData.premacontractCounts;
              datasets.push({
                label: 'Premature Contraction',
                data: [premacontractCounts],
                backgroundColor: "rgba(75, 192, 192, 0.8)"
              });
            }

            if (diabetismellitusChecked) {
              const diabetismellitusCounts = jsonData.diabetismellitusCounts;
              datasets.push({
                label: 'Diabetes Mellitus',
                data: [diabetismellitusCounts],
                backgroundColor: "rgba(153, 102, 255, 0.8)"
              });
            }

            if (heartDiseaseChecked) {
              const heartDiseaseCounts = jsonData.heartDiseaseCounts;
              datasets.push({
                label: 'Heart Disease',
                data: [heartDiseaseCounts],
                backgroundColor: "rgba(255, 206, 86, 0.8)"
              });
            }

            if (obeseChecked) {
              const obeseCounts = jsonData.obeseCounts;
              datasets.push({
                label: 'Obese',
                data: [obeseCounts],
                backgroundColor: "rgba(255, 159, 64, 0.8)"
              });
            }

            myChartfp = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: [zone], // Only show the selected zone
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
      var zone = document.getElementById("zonalSelectPrenatal").value;
      var forcepsChecked = document.getElementById("forceps").checked;
      var smokingChecked = document.getElementById("smoking").checked;
      var alcoholChecked = document.getElementById("alcohol").checked;
      var cesareanChecked = document.getElementById("cesarean").checked;
      var miscarriagesChecked = document.getElementById("3-miscarriages").checked;
      var ectopicChecked = document.getElementById("ectopic").checked;
      var postpartumBleedChecked = document.getElementById("postpartum-bleed").checked;
      var babyWeightChecked = document.getElementById("babyweightgreaterthan4").checked;
      var asthmaChecked = document.getElementById("asthma").checked;
      var goiterChecked = document.getElementById("goiter").checked;
      var premacontractChecked = document.getElementById("premacontract").checked;
      var diabetismellitusChecked = document.getElementById("diabetismellitus").checked;
      var heartDiseaseChecked = document.getElementById("heart_disease").checked;
      var obeseChecked = document.getElementById("obese").checked;

      if (selectOption === "All") {
        document.getElementById("zonalSelectPrenatal").setAttribute("hidden", "hidden");
        document.getElementById("zonalSelectLabel").setAttribute("hidden", "hidden");
        document.getElementById("frmDatefp").setAttribute("hidden", "hidden");
        document.getElementById("toDatefp").setAttribute("hidden", "hidden");
        document.getElementById("lbl1").setAttribute("hidden", "hidden");
        document.getElementById("lbl2").setAttribute("hidden", "hidden");
        document.getElementById("more_filter").setAttribute("hidden", "hidden");
      }
      if (selectOption === "Zonal") {
        document.getElementById("zonalSelectPrenatal").removeAttribute("hidden");
        document.getElementById("frmDatefp").removeAttribute("hidden");
        document.getElementById("toDatefp").removeAttribute("hidden");
        document.getElementById("lbl1").removeAttribute("hidden");
        document.getElementById("lbl2").removeAttribute("hidden");
        document.getElementById("zonalSelectLabel").removeAttribute("hidden");
        document.getElementById("more_filter").removeAttribute("hidden");
      }

      fetchData(selectOption, frmDatefp, toDatefp, zone, forcepsChecked, smokingChecked, alcoholChecked, cesareanChecked, miscarriagesChecked, ectopicChecked, postpartumBleedChecked, babyWeightChecked, asthmaChecked, goiterChecked, premacontractChecked, diabetismellitusChecked, heartDiseaseChecked, obeseChecked);
    }

    updateChart(); // Initial call

    // Event listeners for select option change
    document.getElementById("selectOptionFamplan").addEventListener("change", function() {
      updateChart();
    });

    // Event listeners for date range change
    document.getElementById("frmDatefp").addEventListener("change", function() {
      updateChart();
    });
    document.getElementById("toDatefp").addEventListener("change", function() {
      updateChart();
    });
    document.getElementById("zonalSelectPrenatal").addEventListener("change", function() {
      updateChart();
    });
    document.getElementById("forceps").addEventListener("change", function() {
      updateChart();
    });
    document.getElementById("smoking").addEventListener("change", function() {
      updateChart();
    });
    document.getElementById("alcohol").addEventListener("change", function() {
      updateChart();
    });
    document.getElementById("cesarean").addEventListener("change", function() {
      updateChart();
    });
    document.getElementById("3-miscarriages").addEventListener("change", function() {
      updateChart();
    });
    document.getElementById("ectopic").addEventListener("change", function() {
      updateChart();
    });
    document.getElementById("postpartum-bleed").addEventListener("change", function() {
      updateChart();
    });
    document.getElementById("babyweightgreaterthan4").addEventListener("change", function() {
      updateChart();
    });
    document.getElementById("asthma").addEventListener("change", function() {
      updateChart();
    });
    document.getElementById("goiter").addEventListener("change", function() {
      updateChart();
    });
    document.getElementById("premacontract").addEventListener("change", function() {
      updateChart();
    });
    document.getElementById("diabetismellitus").addEventListener("change", function() {
      updateChart();
    });
    document.getElementById("heart_disease").addEventListener("change", function() {
      updateChart();
    });
    document.getElementById("obese").addEventListener("change", function() {
      updateChart();
    });


  });
</script>