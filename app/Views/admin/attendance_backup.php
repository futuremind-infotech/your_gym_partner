<?php

$db = \Config\Database::connect();
date_default_timezone_set('Asia/Kathmandu');
$current_date = date('Y-m-d');
$todays_date = $current_date;

$members = $db->table('members')->where('status', 'Active')->get()->getResultArray();
$cnt = 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Attendance - Gym System Admin</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="<?= base_url('css/bootstrap.min.css') ?>" />
<link rel="stylesheet" href="<?= base_url('css/bootstrap-responsive.min.css') ?>" />
<link rel="stylesheet" href="<?= base_url('css/fullcalendar.css') ?>" />
<link rel="stylesheet" href="<?= base_url('css/matrix-style.css') ?>" />
<link rel="stylesheet" href="<?= base_url('css/matrix-media.css') ?>" />
<link href="<?= base_url('font-awesome/css/all.css') ?>" rel="stylesheet" />
<link href="<?= base_url('font-awesome/css/fontawesome.css') ?>" rel="stylesheet" />
<link rel="stylesheet" href="<?= base_url('css/jquery.gritter.css') ?>" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="<?= base_url('admin') ?>">Perfect Gym Admin</a></h1>
</div>
<!--close-Header-part--> 

<!--top-Header-menu-->
<?php include 'includes/topheader.php'?>
<!--close-top-Header-menu-->

<!--sidebar-menu-->
  <?php $page='attendance'; include 'includes/sidebar.php'?>
<!--sidebar-menu-->

<!--main-container-part-->
<div id="content">
    <div id="content-header">
        <div id="breadcrumb">
            <a href="<?= site_url('admin') ?>" title="Go to Home" class="tip-bottom"><i class="fas fa-home"></i> Home</a> 
            <a href="<?= site_url('admin/attendance') ?>" class="current">Manage Attendance</a>
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
                                if(count($members) > 0) {
                                    foreach($members as $row) { 
                                        $attendance = $db->table('attendance')->where('curr_date', $todays_date)->where('user_id', $row['user_id'])->get()->getRowArray();
                                        $row_exist = !empty($attendance);
                                ?>
                                    <tr>
                                        <td><div class='text-center'><?php echo $cnt; ?></div></td>
                                        <td><div class='text-center'><?php echo htmlspecialchars($row['fullname']); ?></div></td>
                                        <td><div class='text-center'><?php echo htmlspecialchars($row['contact']); ?></div></td>
                                        <td><div class='text-center'><?php echo htmlspecialchars($row['services']); ?></div></td>
                                        <td>
                                            <?php if($row_exist) { ?>
                                                <div class='text-center'>
                                                    <span class="label label-inverse">
                                                        <?php 
                                                            $dateObj = DateTime::createFromFormat('Y-m-d', $attendance['curr_date']);
                                                            echo $dateObj->format('M d, Y');
                                                        ?> 
                                                        @ <?php 
                                                            $timeObj = DateTime::createFromFormat('H:i:s', $attendance['curr_time']);
                                                            echo $timeObj->format('h:i A');
                                                        ?>
                                                    </span>
                                                </div>
                                                <div class='text-center'>
                                                    <a href='<?= site_url("admin/delete-attendance?id=" . $row['user_id']) ?>'>
                                                        <button class='btn btn-danger btn-mini'>Check Out <i class='fas fa-clock'></i></button>
                                                    </a>
                                                </div>
                                            <?php } else { ?>
                                                <div class='text-center'>
                                                    <a href='javascript:void(0)' onclick="checkIn(<?php echo $row['user_id']; ?>)">
                                                        <button class='btn btn-info btn-mini'>Check In <i class='fas fa-map-marker-alt'></i></button>
                                                    </a>
                                                </div>
                                            <?php } ?>
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
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


<style>
.table th, .table td { vertical-align: middle; }
.btn-mini { padding: 2px 8px; font-size: 12px; }
</style>

</div><!-- End of content-ID -->

<!--end-main-container-part-->

<!--Footer-part-->
<div class="row-fluid">
  <div id="footer" class="span12"> <?php echo date("Y");?> &copy; Developed By Naseeb Bajracharya</div>
</div>
<!--end-Footer-part-->

<script src="<?= base_url('js/excanvas.min.js') ?>"></script>
<script src="<?= base_url('js/jquery.min.js') ?>"></script> 
<script src="<?= base_url('js/jquery.ui.custom.js') ?>"></script> 
<script src="<?= base_url('js/bootstrap.min.js') ?>"></script> 
<script src="<?= base_url('js/jquery.flot.min.js') ?>"></script> 
<script src="<?= base_url('js/jquery.flot.resize.min.js') ?>"></script> 
<script src="<?= base_url('js/jquery.peity.min.js') ?>"></script> 
<script src="<?= base_url('js/fullcalendar.min.js') ?>"></script> 
<script src="<?= base_url('js/matrix.js') ?>"></script> 
<script src="<?= base_url('js/matrix.dashboard.js') ?>"></script> 
<script src="<?= base_url('js/jquery.gritter.min.js') ?>"></script> 
<script src="<?= base_url('js/matrix.chat.js') ?>"></script> 
<script src="<?= base_url('js/jquery.validate.js') ?>"></script> 
<script src="<?= base_url('js/matrix.form_validation.js') ?>"></script> 
<script src="<?= base_url('js/jquery.wizard.js') ?>"></script> 
<script src="<?= base_url('js/jquery.uniform.js') ?>"></script> 
<script src="<?= base_url('js/select2.min.js') ?>"></script> 
<script src="<?= base_url('js/matrix.popover.js') ?>"></script> 
<script src="<?= base_url('js/jquery.dataTables.min.js') ?>"></script> 
<script src="<?= base_url('js/matrix.tables.js') ?>"></script> 

<script>
function checkIn(userId) {
    // Get the client's actual current time
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    const clientTime = `${hours}:${minutes}:${seconds}`;
    
    // Redirect with the client's actual time
    window.location.href = `<?= site_url('admin/check-attendance') ?>?id=${userId}&time=${clientTime}`;
}
</script> 

</body>
</html>

