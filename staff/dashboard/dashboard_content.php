<?php
include_once ('../../config.php');
$currentDate = date('M-d-Y');
$currentMonth = date('m');
$currentYear = date('Y');

// Define the activities for each day
$activities = [
  // 'Sunday' => 'Rest Day',
  'Monday' => 'Consultation - Doctor <br/> Family Planning - Nurse',
  'Tuesday' => 'Prenatal - Midwife <br/> Family Planning - Nurse ',
  'Wednesday' => 'Consultation - Doctor <br/> Immunization - Nurse <br/> Family Planning - Nurse ',
  'Thursday' => 'Prenatal - Midwife <br/> Family Planning - Nurse ',
  'Friday' => 'Family Planning - Nurse ',
  // 'Saturday' => 'Rest Day',
];

// Get the dates for the current week (Monday to Friday)
$dates = [];
$currentDayOfWeek = date('N', strtotime('Monday')); // Get the day of the week for Monday (1=Monday, 2=Tuesday, ..., 7=Sunday)
for ($i = 0; $i < 5; $i++) {
  $dates[date('M-d-Y', strtotime("+$i days", strtotime("Monday this week")))] = date('l', strtotime("+$i days", strtotime("Monday this week")));
}


// Query to count patients per day
$sql = "SELECT checkup_date, COUNT(id) as patient_count FROM consultations GROUP BY checkup_date";
$result = $conn->query($sql);

if ($result === false) {
  die("Query failed: " . $conn->error);
}

// Fetch data and prepare for the chart
$chart_data = array();
while ($row = $result->fetch_assoc()) {
  $chart_data[] = array(
    'date' => $row['checkup_date'],
    'count' => $row['patient_count']
  );
}

$columns = ['bgc_date', 'hepa_date', 'pentavalent_date1', 'pentavalent_date2', 'pentavalent_date3', 'oral_date1', 'oral_date2', 'oral_date3'];

// Initialize an array to store the counts
$countss = array();

foreach ($columns as $column) {
  // Assuming $conn is your database connection
  $sql = "SELECT COUNT($column) AS count FROM immunization"; // Replace 'your_table' with your actual table name
  $result = $conn->query($sql);

  if ($result === false) {
    die("Query failed: " . $conn->error);
  }

  $row = $result->fetch_assoc();
  $countss[] = $row['count'];
}

// Now $countss contains the counts for each column




// Create an array of table names
$tables = ['fp_information', 'immunization', 'prenatal', 'consultations'];

// Initialize an array to store the counts
$counts = array();

foreach ($tables as $table) {
  $sql = "SELECT COUNT(*) as count FROM $table";
  $result = $conn->query($sql);

  if ($result === false) {
    die("Query failed: " . $conn->error);
  }

  $row = $result->fetch_assoc();
  $counts[] = $row['count'];
}


// // Create an array of column names for immunization table
// $columns = ['bgc_date', 'bgc_remarks', 'hepa_date', 'pentavalent_date1'];

// // Initialize an array to store the counts for each column
// $counts = array();

// // Loop through each column
// foreach ($columns as $column) {
//   // Construct the SQL query to count non-null entries for the current column in the immunization table
//   $sql = "SELECT COUNT(*) as count FROM immunization WHERE $column IS NOT NULL";
//   $result = $conn->query($sql);

//   if ($result === false) {
//     die("Query failed: " . $conn->error);
//   }

//   // Fetch the count and store it in the counts array
//   $row = $result->fetch_assoc();
//   $counts[$column] = $row['count'];
// }


?>

<!-- Button trigger modal -->
<div class="container-fluid">
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#weeklyCalendarModal">
    Weekly Activity Calendar
  </button>
</div>
<hr class="my-4">
<!-- Modal -->
<div class="modal fade" id="weeklyCalendarModal" tabindex="-1" aria-labelledby="weeklyCalendarModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="weeklyCalendarModalLabel">Weekly Activity Calendar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="calendar">
          <div class="timeline">
            <div class="spacer"></div>
            <div class="time-marker">8 AM</div>
            <div class="time-marker">9 AM</div>
            <div class="time-marker">10 AM</div>
            <div class="time-marker">11 AM</div>
            <div class="time-marker">12 PM</div>
            <div class="time-marker">1 PM</div>
            <div class="time-marker">2 PM</div>
            <div class="time-marker">3 PM</div>
            <div class="time-marker">4 PM</div>
            <div class="time-marker">5 PM</div>
          </div>
          <div class="days">
            <div class="day mon">
              <div class="date">
                <!-- <p class="date-num">9</p> -->
                <p class="date-day">Mon</p>
              </div>
              <div class="events">
                <div class="event start-2 end-5 ent-law">
                  <p class="title">Consultation - Doctor <br> Family Planning - Nurse</p>
                  <p class="time">8 AM - 5 PM</p>
                </div>
                <div class="event start-8 end-9 ent-law">
                  <p class="title">Consultation - Doctor <br> Family Planning - Nurse</p>
                  <p class="time">8 AM - 5 PM</p>
                </div>
                <div class="event start-6 end-12 lunch">
                  <p class="title">Lunch Break - 12PM</p>
                  <!-- <p class="time">8 AM - 5 PM</p> -->
                </div>
              </div>
            </div>
            <div class="day tues">
              <div class="date">
                <!-- <p class="date-num">12</p> -->
                <p class="date-day">Tues</p>
              </div>
              <div class="events">
                <div class="event start-2 end-5 securities">
                  <p class="title">Prenatal - Midwife <br> Family Planning - Nurse</p>
                  <p class="time">8 AM - 5 PM</p>
                </div>
                <div class="event start-8 end-9 securities">
                  <p class="title">Prenatal - Midwife <br> Family Planning - Nurse</p>
                  <p class="time">8 AM - 5 PM</p>
                </div>
                <div class="event start-6 end-12 lunch">
                  <p class="title">Lunch Break - 12PM</p>
                  <!-- <p class="time">8 AM - 5 PM</p> -->
                </div>
              </div>
            </div>
            <div class="day wed">
              <div class="date">
                <!-- <p class="date-num">11</p> -->
                <p class="date-day">Wed</p>
              </div>
              <div class="events">
                <div class="event start-2 end-5 ent-law">
                  <p class="title">Consultation - Doctor <br> Family Planning - Nurse <br> Immunization - Nurse</p>
                  <p class="time">8 AM - 5 PM</p>
                </div>
                <div class="event start-8 end-9 ent-law">
                  <p class="title">Consultation - Doctor <br> Family Planning - Nurse <br> Immunization - Nurse</p>
                  <p class="time">8 AM - 5 PM</p>
                </div>
                <div class="event start-6 end-12 lunch">
                  <p class="title">Lunch Break - 12PM</p>
                  <!-- <p class="time">8 AM - 5 PM</p> -->
                </div>
              </div>
            </div>
            <div class="day thurs">
              <div class="date">
                <!-- <p class="date-num">12</p> -->
                <p class="date-day">Thurs</p>
              </div>
              <div class="events">
                <div class="event start-2 end-5 securities">
                  <p class="title">Prenatal - Midwife <br> Family Planning - Nurse</p>
                  <p class="time">8 AM - 5 PM</p>
                </div>
                <div class="event start-8 end-9 securities">
                  <p class="title">Prenatal - Midwife <br> Family Planning - Nurse</p>
                  <p class="time">8 AM - 5 PM</p>
                </div>
                <div class="event start-6 end-12 lunch">
                  <p class="title">Lunch Break - 12PM</p>
                  <!-- <p class="time">8 AM - 5 PM</p> -->
                </div>
              </div>
            </div>
            <div class="day fri">
              <div class="date">
                <!-- <p class="date-num">13</p> -->
                <p class="date-day">Fri</p>
              </div>
              <div class="events">
                <div class="event start-2 end-5 ent-law">
                  <p class="title">Family Planning - Nurse</p>
                  <p class="time">8 AM - 5 PM</p>
                </div>
                <div class="event start-8 end-9 ent-law">
                  <p class="title">Family Planning - Nurse</p>
                  <p class="time">8 AM - 5 PM</p>
                </div>
                <div class="event start-6 end-12 lunch">
                  <p class="title">Lunch Break - 12PM</p>
                  <!-- <p class="time">8 AM - 5 PM</p> -->
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



<div class="container-fluid">

  <div class="row">
    <!--  -->
    <div class="col-sm-7">
      <div class="row">

        <!-- ./col -->
        <div class="col-lg-4 col-md-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <?php
              $sql = "SELECT COUNT(*) AS totalConsultations FROM patients";

              $result = $conn->query($sql);

              if ($result === false) {
                die("Query failed: " . $conn->error);
              }

              if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $totalConsultations = $row['totalConsultations'];

                // Display the total consultations count within an <h3> element
                echo "<h3>$totalConsultations</h3>";
              } else {
                // If no consultations were found for the current month, display 0
                echo "<h3>0</h3>";
              }

              // Close the database connection
              
              ?>
              <p>Total Patient</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="../patient/patient.php" class="small-box-footer">More info <i
                class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <!-- ./col -->
        <div class="col-lg-4 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <?php
              $sql = "SELECT COUNT(*) AS totalConsultations FROM prenatal_subjective";

              $result = $conn->query($sql);

              if ($result === false) {
                die("Query failed: " . $conn->error);
              }

              if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $totalConsultations = $row['totalConsultations'];

                // Display the total consultations count within an <h3> element
                echo "<h3>$totalConsultations</h3>";
              } else {
                // If no consultations were found for the current month, display 0
                echo "<h3>0</h3>";
              }

              // Close the database connection
              
              ?>

              <p>Total Prenatal</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="../prenatal/prenatal.php" class="small-box-footer">More info <i
                class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-6">
          <!-- small box -->
          <div class="small-box bg-gray">
            <div class="inner">
              <?php
              $sql = "SELECT COUNT(*) AS totalConsultations FROM immunization ";

              $result = $conn->query($sql);

              if ($result === false) {
                die("Query failed: " . $conn->error);
              }

              if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $totalConsultations = $row['totalConsultations'];

                // Display the total consultations count within an <h3> element
                echo "<h3>$totalConsultations</h3>";
              } else {
                // If no consultations were found for the current month, display 0
                echo "<h3>0</h3>";
              }

              // Close the database connection
              
              ?>
              <p>Total Immunization </p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer" data-toggle="modal" data-target="#immunizationModal">More info <i
                class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>
      <!--  -->
      <!-- Modal -->
      <div class="modal fade" id="immunizationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Immunization Details</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <canvas id="kindOfCheckupss"></canvas>
              <script>
                document.addEventListener('DOMContentLoaded', function () {
                  // Ensure that the PHP variables are correctly encoded into JavaScript
                  var columnNames = <?php echo json_encode($columns); ?>;
                  var data = <?php echo json_encode(array_values($countss)); ?>;
                  var ctx = document.getElementById('kindOfCheckupss').getContext('2d');

                  // Creating the pie chart using Chart.js
                  var chart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                      labels: columnNames,
                      datasets: [{
                        data: data,
                        backgroundColor: [
                          'rgba(255, 99, 132, 0.6)',
                          'rgba(54, 162, 235, 0.6)',
                          'rgba(255, 206, 86, 0.6)',
                          'rgba(75, 192, 192, 0.6)',
                          'rgba(76, 132, 112, 0.6)',
                          '	rgb(153, 255, 153, 0.6)',
                          'rgb(153, 255, 255, 0.6)',
                          'rgb(255, 153, 153, 0.6)',
                        ],
                      }],
                    },
                  });
                });
              </script>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

      <!--  -->

      <div class="row">
        <div class="col-lg-4 col-6">
          <!-- small box -->
          <div class="small-box bg-orange">
            <div class="inner">
              <?php
              $sql = "SELECT COUNT(*) AS totalConsultations
FROM fp_information
JOIN patients ON fp_information.patient_id = patients.id
JOIN nurses ON fp_information.nurse_id = nurses.id";

              $result = $conn->query($sql);

              if ($result === false) {
                die("Query failed: " . $conn->error);
              }

              if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $totalConsultations = $row['totalConsultations'];

                // Display the total consultations count within an <h3> element
                echo "<h3>$totalConsultations</h3>";
              } else {
                // If no consultations were found for today's date, display 0
                echo "<h3>0</h3>";
              }

              // Close the database connection
              
              ?>

              <p>Total Family Planning</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="../family/family.php" class="small-box-footer">More info <i
                class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>


        <div class="col-lg-4 col-6">
          <!-- small box -->
          <div class="small-box bg-primary">
            <div class="inner">
              <?php
              $sql = "SELECT COUNT(*) AS totalConsultations FROM consultations ";

              $result = $conn->query($sql);

              if ($result === false) {
                die("Query failed: " . $conn->error);
              }

              if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $totalConsultations = $row['totalConsultations'];

                // Display the total consultations count within an <h3> element
                echo "<h3>$totalConsultations</h3>";
              } else {
                // If no consultations were found for today's date, display 0
                echo "<h3>0</h3>";
              }

              // Close the database connection
              
              ?>

              <p>Total Consultation</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="../consultation/consultation.php" class="small-box-footer">More info <i
                class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>
      <!--  -->


      <div class="row">
        <div class="col-md-7">
          <h1>Patients Per Day</h1>
          <canvas id="patientChart" width="400" height="300"></canvas>
        </div>
        <div class="col-md-5">
          <h1>Checkup Category</h1>
          <canvas id="kindOfCheckups" width="300" height="200"></canvas>
        </div>
      </div>

      <script>
        var tableNames = <?php echo json_encode($tables); ?>;
        var data = <?php echo json_encode($counts); ?>;
        var ctx = document.getElementById('kindOfCheckups').getContext('2d');

        var chart = new Chart(ctx, {
          type: 'pie',
          data: {
            labels: tableNames,
            datasets: [{
              data: data,
              backgroundColor: [
                'rgba(255, 99, 132, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.6)',
              ],
            }],
          },
        });
      </script>

      <script>
        var data = <?php echo json_encode($chart_data); ?>;
        var dates = data.map(item => item.date);
        var counts = data.map(item => item.count);

        var ctx = document.getElementById('patientChart').getContext('2d');
        var chart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: dates,
            datasets: [{
              label: 'Patients per Day',
              data: counts,
              borderColor: 'blue',
              fill: false,
            }],
          },
          options: {
            scales: {
              x: [{
                ticks: {
                  maxTicksLimit: 10,
                },
              }],
            },
          },
        });
      </script>
    </div>
    <div class="col-sm-5 bg-gradient-blue" style="text-align: left; padding:20px;border-radius:10px;">

      <div
        style="max-width: 600px; margin: 0 auto; background-color: #f8f8f8; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); height: 600px; overflow-y: auto;">
        <h2 style="text-align: center; color: #333;">Announcements</h2>

        <?php
        $sql = "SELECT * FROM announcements ";
        $result = $conn->query($sql);

        if ($result === false) {
          die("Query failed: " . $conn->error);
        }

        while ($row = $result->fetch_assoc()) {
          echo '<div style="border: 1px solid #ddd; margin-bottom: 20px; padding: 15px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
        <h3 style="color: #333;">' . htmlspecialchars($row['title']) . '</h3>
        <p style="color: #666;">' . htmlspecialchars($row['description']) . '</p>
        <p style="color: #666;">Date: ' . htmlspecialchars($row['date']) . '</p>
        <p style="color: #666;">Time: ' . htmlspecialchars($row['time']) . '</p>
    </div>';
        }
        ?>

        <hr style="border-color: #ddd;">
      </div>
    </div>

  </div>
  <!--  -->

</div>


<link rel="stylesheet" href="../../assets/css/calendar.css">

<!-- Include this script in your HTML file -->
<script>
  // Set the timeout duration (in milliseconds)
  var inactivityTimeout = 360000; // 10 seconds

  // Track user activity
  var activityTimer;

  function resetTimer() {
    clearTimeout(activityTimer);
    activityTimer = setTimeout(logout, inactivityTimeout);
  }

  function logout() {
    // Redirect to logout PHP script
    window.location.href = '../action/logout.php';
  }

  // Add event listeners to reset the timer on user activity
  document.addEventListener('mousemove', resetTimer);
  document.addEventListener('keypress', resetTimer);

  // Initialize the timer on page load
  resetTimer();
</script>
<!-- <script>
  // Get current day of the week
  var currentDayOfWeek = new Date().getDay(); // 0 = Sunday, 1 = Monday, ..., 6 = Saturday

  // Highlight the row corresponding to the current day
  var table = document.getElementById("calendar");
  var rows = table.getElementsByTagName("tr");
  for (var i = 0; i < rows.length; i++) {
    var cells = rows[i].getElementsByTagName("td");
    if (cells.length > 0) {
      var day = cells[1].innerText.trim();
      if (day === "<?php echo date('l'); ?>") {
        rows[i].classList.add("highlight");
      }
    }
  }
</script> -->
<!-- <div class="row">
          <div class="col-sm-12">
            <table class="table" id="calendar">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Day</th>
                  <th>Activity</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($dates as $date => $day): ?>
                  <tr>
                    <td><?php echo $date; ?></td>
                    <td><?php echo $day; ?></td>
                    <td><?php echo isset($activities[$day]) ? $activities[$day] : 'No Activity'; ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div> -->