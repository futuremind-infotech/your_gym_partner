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
<title>Gym System Admin - Progress Report</title>
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
<?php $page='c-p-r'; include 'includes/sidebar.php'?>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
      <a href="<?= site_url('admin') ?>" title="Go to Home" class="tip-bottom"><i class="fas fa-home"></i> Home</a>
      <a href="<?= site_url('admin/customer-progress') ?>">Progress Reports</a>
      <a href="#" class="current">View Report</a>
    </div>
    <h1 class="text-center">Progress Report <i class="fas fa-tasks"></i></h1>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
          <div class="widget-box">
      
     <div class="widget-content">
            <div class="row-fluid">
              <div class="span4">
                <table class="">
                  <tbody>
                  <tr>
                      <td><h4>Perfect GYM Club</h4></td>
                    </tr>
                    <tr>
                      <td>5021  Wetzel Lane, Williamsburg</td>
                    </tr>
                    
                    <tr>
                      <td>Tel: 231-267-6011</td>
                    </tr>
                    <tr>
                      <td >Email: support@perfectgym.com</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              
              <div class="span8">
                <table class="table table-bordered table-invoice-full">
                  <thead>
                    <tr>
                      <th class="head0">Membership ID</th>
                      <th class="head1 right">Initial Weight</th>
                      <th class="head0 right">Current Weight</th>
                      <th class="head1">Services Taken</th>
                      <th class="head0 right">Plans (Upto)</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><div class="text-center">PGC-SS-<?= $member['user_id'] ?></div></td>
                      <td><div class="text-center"><?= $member['ini_weight'] ?? 'N/A' ?> KG</div></td>
                      <td><div class="text-center"><?= $member['curr_weight'] ?? 'N/A' ?> KG</div></td>
                      <td><div class="text-center"><?= esc($member['services']) ?></div></td>
                      <td><div class="text-center"><?= $member['plan'] ?> Month/s</div></td>
                    </tr>
                  </tbody>
                </table>
                <table class="table table-bordered table-invoice-full">
                  <tbody>
                    <tr>
                      <td class="msg-invoice" width="55%"> <div class="text-center"><h5><?= esc($member['fullname']) ?>'s Body Structure stated as from <?= $member['ini_bodytype'] ?? 'N/A' ?> to <?= $member['curr_bodytype'] ?? 'N/A' ?>. <br /> With Total Weight Differences of <?= ($member['curr_weight'] ?? 0) - ($member['ini_weight'] ?? 0) ?> KG <br /> As per records of <?= $member['progress_date'] ?></h5>
                        
                        </div>
                    </tr>
                  </tbody>
                </table>
              </div> <!-- end of span 12 -->
              
            </div>

            <div class="row-fluid">
                <div class="pull-left">
                <br>
                
                <h4>GYM Member: <?= esc($member['fullname']) ?> <br> <em style="color:green">Progress Report Generated</em><i class="fa fa-spinner fa-spin" style="font-size:24px"></i><br/> <br/>  <br/></h4><p>Thank you for choosing our services.<br/>- on the behalf of whole team</p>
                </div>
                <div class="pull-right">
                  <h4><span>Approved By:</h4>
                  <img src="<?= base_url('img/report/stamp-sample.png') ?>" width="124px;" alt=""><p class="text-center">Note:AutoGenerated</p> </div>
                  
            </div>
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
<script src="<?= base_url('js/matrix.interface.js') ?>"></script> 
<script src="<?= base_url('js/matrix.chat.js') ?>"></script> 
<script src="<?= base_url('js/jquery.validate.js') ?>"></script> 
<script src="<?= base_url('js/matrix.form_validation.js') ?>"></script> 
<script src="<?= base_url('js/jquery.wizard.js') ?>"></script> 
<script src="<?= base_url('js/jquery.uniform.js') ?>"></script> 
<script src="<?= base_url('js/select2.min.js') ?>"></script> 
<script src="<?= base_url('js/matrix.popover.js') ?>"></script> 
<script src="<?= base_url('js/jquery.dataTables.min.js') ?>"></script> 
<script src="<?= base_url('js/matrix.tables.js') ?>"></script> 

<script type="text/javascript">
  // This function is called from the pop-up menus to transfer to
  // a different page. Ignore if the value returned is a null string:
  function goPage (newURL) {

      // if url is empty, skip the menu dividers and reset the menu selection to default
      if (newURL != "") {
      
          // if url is "-", it is this page -- reset the menu:
          if (newURL == "-" ) {
              resetMenu();            
          } 
          // else, send page to designated URL            
          else {  
            document.location.href = newURL;
          }
      }
  }

// resets the menu selection upon entry to this page:
function resetMenu() {
   document.gomenu.selector.selectedIndex = 2;
}
</script>
</body>
</html>

