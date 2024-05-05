<?php
define('ADMIN_DASHBOARD', './admin/dashboard/dashboard.php');
define('SUPERADMIN_DASHBOARD', './superadmin/dashboard/dashboard.php');
define('NURSE_DASHBOARD', './nurse/dashboard/dashboard.php');
define('MIDWIFE_DASHBOARD', './midwife/dashboard/dashboard.php');
define('STAFF_DASHBOARD', './staff/dashboard/dashboard.php');
if (isset($_SESSION["username"]) && isset($_SESSION["role"])) {
    switch ($_SESSION["role"]) {
        case "admin":
            header("Location: " . ADMIN_DASHBOARD);
            exit;
        case "superadmin":
            header("Location: " . SUPERADMIN_DASHBOARD);
            exit;
        case "nurse":
            header("Location: " . NURSE_DASHBOARD);
            exit;
        case "midwife":
            header("Location: " . MIDWIFE_DASHBOARD);
            exit;
        case "staff":
            header("Location: " . STAFF_DASHBOARD);
            exit;
        default:
            echo "Invalid role!";
            exit;
    }
}
?>