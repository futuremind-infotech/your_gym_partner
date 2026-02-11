<?php

$db = \Config\Database::connect();
$members = $db->table('members')->where('status', 'Active')->get()->getResultArray();
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
<link href="<?= base_url('font-awesome/css/fontawesome.css') ?>" rel="stylesheet" />
<link href="<?= base_url('font-awesome/css/all.css') ?>" rel="stylesheet" />
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
<?php $page="view-attendance"; include 'includes/sidebar.php'?>
<!--sidebar-menu-->

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.php" title="Go to Home" class="tip-bottom"><i class="fas fa-home"></i> Home</a> <a href="attendance.php" class="current">Manage Attendance</a> </div>
    <h1 class="text-center">Attendance List <i class="fas fa-calendar"></i></h1>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">

      <div class='widget-box'>
          <div class="widget-title"><h5>Filter by Date</h5></div>
          <div class="widget-content padding">
            <form method="get" class="form-inline" style="margin-bottom:10px;">
              <label for="date">Date:</label>
              <input type="date" id="date" name="date" value="<?= isset($_GET['date']) ? htmlspecialchars($_GET['date']) : date('Y-m-d') ?>" class="form-control" />
              <button type="submit" class="btn btn-primary">Show</button>
              <a href="<?= site_url('admin/view-attendance') ?>" class="btn btn-default">Today</a>
            </form>
          </div>
          <div class='widget-title'> <span class='icon'> <i class='fas fa-th'></i> </span>
            <h5>Attendance Table</h5>
          </div>
          <div class='widget-content nopadding'> 

        
          <table class='table table-bordered'>
              <thead>
                <tr>
                  <th>#</th>
                  <th>Fullname</th>
                  <th>Plan</th>
                  <th>Today Check-in</th>
                  <th>Today Checkout</th>
                  <th>Attendance Count</th>
                </tr>
              </thead>
              <tbody>
           <?php 
           $cnt = 1;
           $selected_date = isset($_GET['date']) && !empty($_GET['date']) ? $_GET['date'] : date('Y-m-d');
           if(count($members) > 0) {
               foreach($members as $row) { 
                   // fetch selected date's attendance for this member
                   $att = $db->table('attendance')->where('curr_date', $selected_date)->where('user_id', $row['user_id'])->get()->getRowArray();
                   $checkin = $att['curr_time'] ?? '-';
                   $checkout = !empty($att['checkout_time']) ? $att['checkout_time'] : '-';
               ?>
                <tr>
                    <td><div class='text-center'><?php echo $cnt; ?></div></td>
                    <td><div class='text-center'><?php echo htmlspecialchars($row['fullname']); ?></div></td>
                    <td><div class='text-center'><?php 
                        if($row['plan'] == 1) { 
                            echo $row['plan']. ' Month';
                        } else if($row['plan'] == '0') { 
                            echo 'Expired';
                        } else { 
                            echo $row['plan']. ' Months'; 
                        } 
                    ?></div></td>
                    <td><div class='text-center'><?php 
                        if($checkin !== '-') {
                            echo "<span class='label label-info'>" . htmlspecialchars($checkin) . "</span>";
                        } else {
                            echo "<span class='label label-default'>-</span>";
                        }
                    ?></div></td>
                    <td><div class='text-center'><?php 
                      if($checkout !== '-') {
                        echo "<span class='label label-success'>" . htmlspecialchars($checkout) . "</span>";
                      } else {
                        // show a button so admin can perform checkout directly
                        echo "<div style='display:inline-block;margin-bottom:4px;'><span class='label label-warning'>Not Checked Out</span></div>";
                        echo "<div style='margin-top:4px;'><a href='" . site_url("admin/check-attendance?id=" . $row['user_id']) . "'><button class='btn btn-danger btn-sm'>Check Out</button></a></div>";
                      }
                    ?></div></td>
                    <td><div class='text-center'><?php 
                        if($row['attendance_count'] == 1) { 
                            echo $row['attendance_count']. ' Day';
                        } else if($row['attendance_count'] == '0') { 
                            echo 'None';
                        } else { 
                            echo $row['attendance_count']. ' Days'; 
                        } 
                    ?></div></td>
                </tr>
           <?php 
                   $cnt++; 
               }
           } else {
               echo "<tr><td colspan='6' class='text-center'>No active members found.</td></tr>";
           }
           ?>
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

</body>
</html>

