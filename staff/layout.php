<?php
session_start();
if (isset($_SESSION['role']) && $_SESSION['role'] !== "staff") {
  header("Location: ../../{$_SESSION['role']}/dashboard/dashboard.php");
  exit;
}

if (!isset($_SESSION['role'])) {
  header("location: ../../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Brgy Health Center</title>



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

</head>
<style>
  .error {
    color: red;
  }
</style>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">



    <!-- Navbar -->
    <nav class="main-header  navbar-expand navbar-white navbar-light " style="padding: 5px !important;z-index: 1">
      <!-- Left navbar links -->


      <div class="row mx-0">
        <div class="col-sm-1">
          <a class="nav-link " data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"
              style="color: gray"></i></a>
        </div>

        <div class="col-sm-5">
          <h4 style="font-weight: bold" class="mt-1">
            <h4 style="font-weight: bold;">
              <?= $pageTitle ?>
            </h4>
          </h4>
        </div>

        <div class="col-sm-3">
          <div class="input-group input-group-sm">



          </div>
        </div>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-light-primary elevation-4">
      <!-- Brand Logo -->
      <a href="" class="brand-link">
        <center>

          <img src="../../assets\images\buluaLogo.png" alt="" style="height:150px; width:150px;">
        </center>
        <span class="brand-text font-weight-light"></span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="../../assets/images/profile.png" class="img-circle elevation-2" alt="User Image">
          </div>
          <?php
          include_once ('../../config.php');

          // Check if user is logged in
          if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];

            // Query to fetch user's name from admins table
            $sel = "SELECT * FROM staffs WHERE user_id = $user_id";
            $query = mysqli_query($conn, $sel);

            if ($query) {
              $result = mysqli_fetch_assoc($query);

              if ($result) {
                ?>
                <div class="info">
                  <a href="#" class="d-block">
                    <?php echo $result['first_name'] . ' ' . $result['last_name']; ?><br />Staff
                  </a>
                </div>
                <?php
              } else {
                echo "No users found";
              }
            } else {
              echo "Query failed: " . mysqli_error($conn);
            }
          }
          ?>


        </div>



        <!-- Sidebar Menu -->
        <nav class="mt-2" style="height:700px;">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            <li class="nav-item">
              <a href="../dashboard/dashboard.php" class="nav-link">
                <i class="fas fa-tachometer-alt "></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="../patient/patient.php" class="nav-link">
                <i class="fa fa-users fa-lg" aria-hidden="true"></i>
                <p>
                  Patient List
                </p>
              </a>
            </li>

            <li class="nav-item ">

            <li class="nav-item <?php
            if (
              strpos($_SERVER['REQUEST_URI'], '/brgyv2/staff//consultation/consultation.php') !== false ||
              strpos($_SERVER['REQUEST_URI'], '/brgyv2/staff/family/family.php') !== false ||
              strpos($_SERVER['REQUEST_URI'], '/brgyv2/staff/prenatal/prenatal.php') !== false ||
              strpos($_SERVER['REQUEST_URI'], '/brgyv2/staff/immunization/immunization.php') !== false

            ) {
              echo 'menu-open';
            }
            ?>">
              <a href="" class="nav-link">
                <i class="fa fa-cog fa-lg" aria-hidden="false"></i>
                <p>
                  Services
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="../consultation/consultation.php" class="nav-link <?php if ($_SERVER['REQUEST_URI'] === '/brgyv2/staff/consultation/consultation.php')
                    echo 'active'; ?>">
                    <i class="fas fa-file-prescription fa-lg"></i>
                    <p>Consultation</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="../family/family.php" class="nav-link <?php if ($_SERVER['REQUEST_URI'] === '/brgyv2/staff/family/family.php')
                    echo 'active'; ?>">
                    <i class="fas fa-file-medical fa-lg "></i>
                    <p>Family Planning</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="../prenatal/prenatal.php" class="nav-link <?php if ($_SERVER['REQUEST_URI'] === '/brgyv2/staff/prenatal/prenatal.php')
                    echo 'active'; ?>">
                    <i class="fas fa-file-medical-alt fa-lg"></i>
                    <p>Prenatal</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="../immunization/immunization.php" class="nav-link <?php if ($_SERVER['REQUEST_URI'] === '/brgyv2/staff/immunization/immunization.php')
                    echo 'active'; ?>">
                    <i class="fas fa-user-edit fa-lg nav-icon"></i>
                    <p>Immunization</p>
                  </a>
                </li>
                <!-- <li class="nav-item">
                  <a href="../midwife/midwife.php" class="nav-link <?php if ($_SERVER['REQUEST_URI'] === '/brgyv2/admin/midwife/midwife.php')
                    echo 'active'; ?>">
                    <i class="fas fa-user-edit fa-lg nav-icon"></i>
                    <p>Midwife</p>
                  </a>
                </li> -->
              </ul>
            </li>
            <!-- <li class="nav-item">
              <a href="../consultation/consultation.php" class="nav-link">
                <i class="fas fa-file-prescription fa-lg "></i>
                <p>
                  Consultation
                </p>
              </a>
            </li> -->


            <!-- 
            <li class="nav-item">
              <a href="../family/family.php" class="nav-link">
                <i class="fas fa-file-medical fa-lg "></i>
                <p>
                  Family Planning
                </p>
              </a>
            </li> -->


            <!-- 
            <li class="nav-item">
              <a href="../prenatal/prenatal.php" class="nav-link">
                <i class="fas fa-file-medical-alt fa-lg "></i>
                <p>
                  Prenatal
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="../immunization/immunization.php" class="nav-link">
                <i class="fas fa-file-medical-alt fa-lg "></i>
                <p>
                  Immunization
                </p>
              </a>
            </li> -->


            <li class="nav-item">
              <a href="../status/status.php" class="nav-link">
                <i class="fas fa-vial fa-lg "></i>
                <p>
                  Status
                </p>
              </a>
            </li>



            <li class=" nav-item" data-toggle="modal" data-target="#reportsModal">
              <a href="#" class=" nav-link">
                <i class="fa fa-book fa-lg" aria-hidden="true"></i>
                <p>
                  Generate Report
                </p>
              </a>
            </li>



            <li class="nav-item">
              <a href="../action/logout.php" class="nav-link">
                <i class="nav-icon fas fa-sign-out-alt "></i>
                <p>
                  Logout
                </p>
              </a>
            </li>


          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <?php include $contentTemplate; ?>
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->
  <!-- GENERATE REPORTS Modal -->
  <div class="modal fade" id="reportsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    style="z-index: 1050;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">GENERATE REPORTS</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="fromDate">From Date:</label>
            <input type="date" class="form-control" id="fromDate" placeholder="Select From Date">
          </div>
          <div class="form-group">
            <label for="toDate">To Date:</label>
            <input type="date" class="form-control" id="toDate" placeholder="Select To Date">
          </div>
          <div class="form-group">
            <label for="reportType">Report Type:</label>
            <select class="form-control" id="reportType">
              <option value="none" selected disabled>-Select Report Type-</option>
              <option value="Patients">Patient List</option>
              <option value="Consultation">Consultations</option>
              <option value="Immunization">Immunization</option>
              <option value="FamPlan">Family Planning</option>
              <option value="Prenatal">Prenatal</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" onclick="generateReport()">Generate Report</button>
        </div>
      </div>
    </div>
  </div>

  <!-- SCRIPT FOR GENERATING REPORTS -->
  <script>
    function generateReport() {
      var fromDate = document.getElementById("fromDate").value;
      var toDate = document.getElementById("toDate").value;
      var reportType = document.getElementById("reportType").value;

      switch (reportType) {
        case "Patients":
          var url = "../report/generate-patient.php?fromDate=" + fromDate + "&toDate=" + toDate;
          window.open(url, '_blank');
          break;
        case "Consultation":
          var url = "../report/generate-consultation.php?fromDate=" + fromDate + "&toDate=" + toDate;
          window.open(url, '_blank');
          break;
        case "Immunization":
          var url = "../report/generate-immunization.php?fromDate=" + fromDate + "&toDate=" + toDate;
          window.open(url, '_blank');
          break;
        case "FamPlan":
          var url = "../report/generate_famplan.php?fromDate=" + fromDate + "&toDate=" + toDate;
          window.open(url, '_blank');
          break;
        case "Prenatal":
          var url = "../report/generate-prenatal.php?fromDate=" + fromDate + "&toDate=" + toDate;
          window.open(url, '_blank');
          break;
      }

    }
  </script>


  <!-- jQuery -->
  <script src="../../assets/plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="../../assets/plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="../../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->


  <script src="../../assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../../assets/dist/js/adminlte.js"></script>



  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <!-- <script src="../../assets/dist/js/pages/dashboard.js"></script> -->
  <script type="text/javascript" charset="utf8"
    src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>


  <!-- Bootstrap 4 JS with Popper.js -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

  <!-- Bootstrap-datepicker CSS -->
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

  <!-- Bootstrap-datepicker JS -->
  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
</body>

</html>