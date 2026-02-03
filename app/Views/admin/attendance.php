<?php

// Check if user is logged in
if(!isset($_SESSION['user_id'])){
    header('location:../index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Gym System Admin - Attendance</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="../css/uniform.css" />
    <link rel="stylesheet" href="../css/select2.css" />
    <link rel="stylesheet" href="../css/matrix-style.css" />
    <link rel="stylesheet" href="../css/matrix-media.css" />
    <link href="../font-awesome/css/fontawesome.css" rel="stylesheet" />
    <link href="../font-awesome/css/all.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
</head>
<body>
<!--Header-part-->
<div id="header">
    <h1><a href="dashboard.html">Perfect Gym Admin</a></h1>
</div>

<!--top-Header-menu-->
<?php include 'includes/topheader.php';?>

<!--sidebar-menu-->
<?php $page="attendance"; include 'includes/sidebar.php';?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb">
            <a href="index.php" title="Go to Home" class="tip-bottom"><i class="fas fa-home"></i> Home</a> 
            <a href="attendance.php" class="current">Manage Attendance</a>
        </div>
        <h1 class="text-center">Attendance List <i class="fas fa-calendar"></i></h1>
    </div>
    
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class='widget-box'>
                    <div class='widget-title'>
                        <span class='icon'><i class='fas fa-th'></i></span>
                        <h5>Attendance Table</h5>
                    </div>
                    <div class='widget-content nopadding'>
                        <table class='table table-bordered table-hover'>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Fullname</th>
                                    <th>Contact Number</th>
                                    <th>Chosen Service</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                include "dbcon.php";
                                date_default_timezone_set('Asia/Kathmandu');
                                $current_date = date('Y-m-d h:i A');
                                $exp_date_time = explode(' ', $current_date);
                                $todays_date = $exp_date_time[0];
                                
                                $qry = "SELECT * FROM members WHERE status = 'Active'";
                                $result = mysqli_query($conn, $qry);
                                $cnt = 1;
                                
                                if($result && mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_array($result)) { 
                                ?>
                                    <tr>
                                        <td><div class='text-center'><?php echo $cnt; ?></div></td>
                                        <td><div class='text-center'><?php echo htmlspecialchars($row['fullname']); ?></div></td>
                                        <td><div class='text-center'><?php echo htmlspecialchars($row['contact']); ?></div></td>
                                        <td><div class='text-center'><?php echo htmlspecialchars($row['services']); ?></div></td>
                                        <td>
                                            <?php
                                            // ✅ FIXED: Null-safe attendance check
                                            $attendance_qry = "SELECT * FROM attendance WHERE curr_date = ? AND user_id = ?";
                                            $stmt = mysqli_prepare($conn, $attendance_qry);
                                            mysqli_stmt_bind_param($stmt, "si", $todays_date, $row['user_id']);
                                            mysqli_stmt_execute($stmt);
                                            $attendance_result = mysqli_stmt_get_result($stmt);
                                            $row_exist = mysqli_fetch_array($attendance_result, MYSQLI_ASSOC);
                                            
                                            if($row_exist && $row_exist['curr_date'] == $todays_date) {
                                                // Member already checked in today
                                            ?>
                                                <div class='text-center'>
                                                    <span class="label label-inverse">
                                                        <?php echo htmlspecialchars($row_exist['curr_date']); ?> 
                                                        <?php echo htmlspecialchars($row_exist['curr_time']); ?>
                                                    </span>
                                                </div>
                                                <div class='text-center'>
                                                    <a href='/your_gym_partner/public/index.php/delete-attendance?id=<?php echo $row['user_id']; ?>'>
                                                        <button class='btn btn-danger btn-mini'>Check Out <i class='fas fa-clock'></i></button>
                                                    </a>
                                                </div>
                                            <?php 
                                            } else {
                                                // Member not checked in today
                                            ?>
                                                <div class='text-center'>
                                                    <a href='/your_gym_partner/public/index.php/check-attendance?id=<?php echo $row['user_id']; ?>'>
                                                        <button class='btn btn-info btn-mini'>Check In <i class='fas fa-map-marker-alt'></i></button>
                                                    </a>
                                                </div>
                                            <?php 
                                            }
                                            mysqli_stmt_close($stmt);
                                            ?>
                                        </td>
                                    </tr>
                                <?php 
                                        $cnt++;
                                    }
                                } else {
                                ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No active members found.</td>
                                    </tr>
                                <?php 
                                }
                                mysqli_close($conn);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Footer-part-->
<div class="row-fluid">
    <div id="footer" class="span12">
        <?php echo date("Y"); ?> &copy; Developed By Naseeb Bajracharya
    </div>
</div>

<style>
#footer { color: white; }
.table th, .table td { vertical-align: middle; }
.btn-mini { padding: 2px 8px; font-size: 12px; }
</style>

<!-- Scripts -->
<script src="../js/jquery.min.js"></script>
<script src="../js/jquery.ui.custom.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/matrix.js"></script>
<script src="../js/jquery.validate.js"></script>
<script src="../js/jquery.uniform.js"></script>
<script src="../js/select2.min.js"></script>
<script src="../js/jquery.dataTables.min.js"></script>
<script src="../js/matrix.tables.js"></script>
</body>
</html>

