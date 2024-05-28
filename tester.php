<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chart.js Bar Chart Demo</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js"
  integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet"
  href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="../../assets/plugins/fontawesome-free/css/all.min.css">
<!-- Ionicons -->

<link rel="stylesheet" href="../../assets/dist/css/adminlte.min.css">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="../../assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

<!-- DataTables JavaScript -->
<script type="text/javascript" charset="utf8"
  src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js" integrity="sha512-CYcfNLE7yFH8fWcKfEDVR3h0sz14gDkQsS/JNcvJfDGAHvY9GHmDfn+bzt/8uD8udnHMBzvnnCZ3OEF0jcy8aQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
<style>
.container {
  width: 500PX;
  margin: 15px auto;
}
</style>
<div class="container">
  <h2>Chart.js — Bar Chart Demo</h2>
  <div>
    <canvas id="myChart" width="400" height="400"></canvas>
    
    <script>
      var ctx = document.getElementById("myChart").getContext('2d');
      var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ["M", "T", "W", "T", "F", "S", "S"],
          datasets: [{
            label: 'apples',
            data: [12, 19, 3, 17, 28, 24, 7],
            backgroundColor: "rgba(153,255,51,1)"
          }, {
            label: 'oranges',
            data: [30, 29, 5, 5, 20, 3, 10],
            backgroundColor: "rgba(255,153,0,1)"
          }]
        }
      });
    </script>
  </div>
</div>
</body>
</html>
