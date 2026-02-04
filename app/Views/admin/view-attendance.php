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
                  <th>Attendance Count</th> 
                </tr>
              </thead>
              <tbody>
           <?php 
           $cnt = 1;
           if(count($members) > 0) {
               foreach($members as $row) { ?>
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
               echo "<tr><td colspan='4' class='text-center'>No active members found.</td></tr>";
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

