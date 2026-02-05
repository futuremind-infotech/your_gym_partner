<?php

//CodeIgniter 4 session check - moved to controller
if (!session()->get('isLoggedIn')) {
    echo 'Unauthorized access';
    exit;
}
?>
<!-- Visit codeastro.com for more projects -->
<!DOCTYPE html>
<html lang="en">
<head>
<title>Gym System Admin</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="<?= base_url('css/bootstrap.min.css') ?>" />
<link rel="stylesheet" href="<?= base_url('css/bootstrap-responsive.min.css') ?>" />
<link rel="stylesheet" href="<?= base_url('css/uniform.css') ?>" />
<link rel="stylesheet" href="<?= base_url('css/select2.css') ?>" />
<link rel="stylesheet" href="<?= base_url('css/matrix-style.css') ?>" />
<link rel="stylesheet" href="<?= base_url('css/matrix-media.css') ?>" />
<link href="<?= base_url('font-awesome/css/font-awesome.css') ?>" rel="stylesheet" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="dashboard.html">Perfect Gym Admin</a></h1>
</div>
<!--close-Header-part--> 


<!--top-Header-menu-->
<?php include '../includes/header.php'?>

<!--close-top-Header-menu-->
<!--start-top-serch-->
<!-- <div id="search">
  <input type="hidden" placeholder="Search here..."/>
  <button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
</div> -->
<!--close-top-serch-->
<!--sidebar-menu-->
<?php $page="attendance"; include '../includes/sidebar.php'?>
<!--sidebar-menu-->

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="attendance.php" class="current">Manage Attendance</a> </div>
    <h1 class="text-center">Attendance List <i class="icon icon-calendar"></i></h1>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">

      <div class='widget-box'>
          <div class='widget-title'> <span class='icon'> <i class='icon-th'></i> </span>
            <h5>Attendance Table</h5>
          </div>
          <div class='widget-content nopadding'>
	  
	  <table class='table table-bordered'>
              <thead>
                <tr>
                  <th>#</th>
                  <th>Fullname</th>
                  <th>Contact Number</th>
                  <th>Choosen Service</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              <?php
              date_default_timezone_set('Asia/Kathmandu');
              $db = \Config\Database::connect();
              $current_date = date('Y-m-d h:i A');
              $exp_date_time = explode(' ', $current_date);
              $todays_date = $exp_date_time['0'];
              
              // Get all active members
              $members = $db->table('members')->where('status', 'Active')->get()->getResultArray();
              $cnt = 1;
              
              foreach($members as $row){ ?>
                <tr>
                <td><div class='text-center'><?php echo $cnt; ?></div></td>
                <td><div class='text-center'><?php echo $row['fullname']; ?></div></td>
                <td><div class='text-center'><?php echo $row['contact']; ?></div></td>
                <td><div class='text-center'><?php echo $row['services']; ?></div></td>

                <!-- <span>count</span><br>CHECK IN</td> -->
                <input type="hidden" name="user_id" value="<?php echo $row['user_id'];?>">

            <?php
                // Get attendance record for this user today
                $attendance = $db->table('attendance')
                    ->where('curr_date', $todays_date)
                    ->where('user_id', $row['user_id'])
                    ->get()
                    ->getRowArray();
                
                $curr_date = $attendance['curr_date'] ?? '';
                $curr_time = $attendance['curr_time'] ?? '-';
                $checkout_time = !empty($attendance['checkout_time']) ? $attendance['checkout_time'] : '-';
                
                error_log("Attendance - User: {$row['user_id']}, CheckIn: '$curr_time', CheckOut: '$checkout_time'");
                
                $has_checkin = ($curr_date == $todays_date && !empty($attendance));
                $has_checkout = $has_checkin && $checkout_time !== '-';
  
    ?>
                <td><div class='text-center'>
                <?php if($has_checkin): ?>
                  <div><strong>Check-in:</strong> <span class="label label-info"><?php echo $curr_time;?></span></div>
                  <div><strong>Checkout:</strong> <span class="label <?php echo ($has_checkout ? 'label-success' : 'label-warning'); ?>"><?php echo $checkout_time; ?></span></div>
                  <?php if(!$has_checkout): ?>
                  <div style='margin-top:5px;'><a href='<?php echo site_url("staff/check-attendance?id=" . $row['user_id']); ?>'><button class='btn btn-danger'>Check Out <i class='icon icon-time'></i></button> </a></div>
                  <?php else: ?>
                  <div style='margin-top:5px;'><span class="label label-success">✓ Checked Out</span></div>
                  <?php endif; ?>
                <?php else: ?>
                  <div><a href='<?php echo site_url("staff/check-attendance?id=" . $row['user_id']); ?>'><button class='btn btn-info'>Check In <i class='icon icon-map-marker'></i></button> </a></div>
                <?php endif; ?>
              </tr>
              <?php $cnt++; ?>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<!--end-main-container-part-->

<!--Footer-part-->

<div class="row-fluid">
  <div id="footer" class="span12"> <?php echo date("Y");?> &copy; Developed By Naseeb Bajracharya</a> </div>
</div>

<style>
#footer {
  color: white;
}
</style>

<!--end-Footer-part-->

<script src="<?= base_url('js/jquery.min.js') ?>"></script> 
<script src="<?= base_url('js/jquery.ui.custom.js') ?>"></script> 
<script src="<?= base_url('js/bootstrap.min.js') ?>"></script>  
<script src="<?= base_url('js/matrix.js') ?>"></script> 
<script src="<?= base_url('js/jquery.validate.js') ?>"></script> 
<script src="<?= base_url('js/jquery.uniform.js') ?>"></script> 
<script src="<?= base_url('js/select2.min.js') ?>"></script> 
<script src="<?= base_url('js/jquery.dataTables.min.js') ?>"></script> 
<script src="<?= base_url('js/matrix.tables.js') ?>"></script> 

</script>
</body>
</html>

