<?php
// CodeIgniter 4 session check
if (!session()->get('isLoggedIn')) {
    return redirect()->to('/');
}

// Get member ID from query string
$member_id = isset($_GET['id']) ? intval($_GET['id']) : null;

if (!$member_id) {
    return redirect()->to('admin/customer-progress');
}

// Get member data from database
$db = \Config\Database::connect();
$member = $db->query("SELECT * FROM members WHERE user_id = ?", [$member_id])->getRowArray();

if (!$member) {
    return redirect()->to('admin/customer-progress');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Gym System Admin - Update Progress</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="<?= base_url('css/bootstrap.min.css') ?>" />
<link rel="stylesheet" href="<?= base_url('css/bootstrap-responsive.min.css') ?>" />
<link rel="stylesheet" href="<?= base_url('css/matrix-style.css') ?>" />
<link rel="stylesheet" href="<?= base_url('css/matrix-media.css') ?>" />
<link href="<?= base_url('font-awesome/css/fontawesome.css') ?>" rel="stylesheet" />
<link href="<?= base_url('font-awesome/css/all.css') ?>" rel="stylesheet" />
</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="<?= site_url('admin') ?>">Perfect Gym Admin</a></h1>
</div>

<!--top-Header-menu-->
<?php include 'includes/topheader.php'?>

<!--sidebar-menu-->
<?php $page='manage-customer-progress'; include 'includes/sidebar.php'?>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
      <a href="<?= site_url('admin') ?>" title="Go to Home" class="tip-bottom"><i class="fas fa-home"></i> Home</a>
      <a href="<?= site_url('admin/customer-progress') ?>">Customer Progress</a>
      <a href="#" class="current">Update Progress</a>
    </div>
    <h1 class="text-center">Update Customer's Progress <i class="fas fa-signal"></i></h1>
  </div>
  
  
  <div class="container-fluid" style="margin-top:-38px;">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="fas fa-signal"></i> </span>
            <h5>Progress </h5>
          </div>
          <div class="widget-content">
            <div class="row-fluid">
              
			  <div class="span2"></div>
			  
              <div class="span8">
                <table class="table table-bordered table-invoice">
				
                  <tbody>
				  <form action="<?= site_url('admin/updateProgress') ?>" method="POST">
                    <tr>
                      <td class="width30">Member's Fullname:</td>
                      <td class="width70"><strong><?= esc($member['fullname']) ?></strong></td>
                    </tr>
                    <tr>
                      <td>Service Taken:</td>
                      <td><strong><?= esc($member['services']) ?></strong></td>
                    </tr>
                    <tr>
                      <td>Initial Weight: (KG)</td>
                      <td><input id="weight" type="number" name="ini_weight" value='<?= $member['ini_weight'] ?? '' ?>' /></td>
                    </tr>

                    <tr>
                      <td>Current Weight: (KG)</td>
                      <td><input id="weight" type="number" name="curr_weight" value='<?= $member['curr_weight'] ?? '' ?>' /></td>
                    </tr>
					
                    <tr>
                      <td>Initial Body Type:</td>
                      <td><input id="ini_bodytype" type="text" name="ini_bodytype" value='<?= $member['ini_bodytype'] ?? '' ?>' /></td>
                    </tr>
				  
					  <tr>
                      <td>Current Body Type:</td>
                      <td><input id="curr_bodytype" type="text" name="curr_bodytype" value='<?= $member['curr_bodytype'] ?? '' ?>' /></td>
                    </tr>
                    </tbody>
                  
                </table>
              </div>
			  
			  
            </div> <!-- row-fluid ends here -->
			
			
            <div class="row-fluid">
              <div class="span12">
                
				
			
                <div class="text-center">
                  <!-- user's ID is hidden here -->
             <input type="hidden" name="id" value="<?= $member['user_id'] ?>">
                  <button class="btn btn-primary btn-large" type="SUBMIT" href="">Save Changes</button> 
				</div>
				  
				  </form>
              </div><!-- span12 ends here -->
            </div><!-- row-fluid ends here -->
          </div><!-- widget-content ends here -->
		  
        </div><!-- widget-box ends here -->
      </div><!-- span12 ends here -->
    </div> <!-- row-fluid ends here -->
  </div> <!-- container-fluid ends here -->
</div> <!-- div id content ends here -->

<!--Footer-part-->
<div id="footer" class="span12" style="color:white; background:#333; padding:15px; text-align:center; margin-top:30px;">
  <?= date("Y") ?> &copy; Perfect Gym - Progress Update
</div>

<script src="<?= base_url('js/jquery.min.js') ?>"></script>
<script src="<?= base_url('js/bootstrap.min.js') ?>"></script> 
<script src="<?= base_url('js/jquery.flot.min.js') ?>"></script> 
<script src="<?= base_url('js/jquery.flot.resize.min.js') ?>"></script> 
<script src="<?= base_url('js/jquery.peity.min.js') ?>"></script> 
<script src="<?= base_url('js/fullcalendar.min.js') ?>"></script> 
<script src="<?= base_url('js/matrix.js') ?>"></script> 
<script src="<?= base_url('js/matrix.dashboard.js') ?>"></script> 
<script src="<?= base_url('js/jquery.gritter.min.js') ?>"></script> 
<script src="<?= base_url('js/matrix.interface.js') ?>"></script> 
<script src="<?= base_url('js/matrix.chat.js') ?>"></script> 
<script src="<?= base_url('js/jquery.validate.js') ?>"></script> 
<script src="../js/matrix.form_validation.js"></script> 
<script src="../js/jquery.wizard.js"></script> 
<script src="../js/jquery.uniform.js"></script> 
<script src="../js/select2.min.js"></script> 
<script src="../js/matrix.popover.js"></script> 
<script src="../js/jquery.dataTables.min.js"></script> 
<script src="../js/matrix.tables.js"></script> 


</body>
</html>

