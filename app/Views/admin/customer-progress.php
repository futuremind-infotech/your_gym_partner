<?php
// CodeIgniter 4 session check
if (!session()->get('isLoggedIn')) {
    return redirect()->to('/');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Gym System Admin - Customer Progress</title>
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
<!--sidebar-menu-->

<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
      <a href="<?= site_url('admin') ?>" title="Go to Home" class="tip-bottom"><i class="fas fa-home"></i> Home</a>
      <a href="#" class="current">Customer Progress</a>
    </div>
    <h1 class="text-center">Update Customer's Progress <i class="fas fa-signal"></i></h1>
  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">

      <div class='widget-box'>
          <div class='widget-title'>
            <span class='icon'><i class='fas fa-th'></i></span>
            <h5>Select Member to Update Progress</h5>
          </div>
          
          <div class='widget-content nopadding'>
	  
	  <?php
      $db = \Config\Database::connect();
      $members = $db->table('members')->orderBy('fullname', 'ASC')->get()->getResultArray();
      
      echo"<table class='table table-bordered table-hover'>
              <thead>
                <tr>
                  <th>#</th>
                  <th>Fullname</th>
                  <th>Choosen Service</th>
                  <th>Plan</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>";
              
      if ($members && count($members) > 0) {
        $cnt = 1;
        foreach($members as $row) {
            echo"<tbody> 
               
                <td><div class='text-center'>".$cnt."</div></td>
                <td><div class='text-center'>".esc($row['fullname'])."</div></td>
                <td><div class='text-center'>".esc($row['services'])."</div></td>
                <td><div class='text-center'>".$row['plan']." Month/s</div></td>
                <td><div class='text-center'><span class='badge badge-".($row['status']=='Active' ? 'success' : 'danger')."'>".$row['status']."</span></div></td>
                <td><div class='text-center'><a href='".site_url('admin/update-progress?id='.$row['user_id'])."'><button class='btn btn-warning btn'><i class='fas fa-edit'></i> Update Progress</button></a></div></td>
                
              </tbody>";
          $cnt++;
        }
      } else {
        echo "<tr><td colspan='6' class='text-center'>No members found</td></tr>";
      }
      ?>

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

<style>
    #custom-search-form {
        margin:0;
        margin-top: 5px;
        padding: 0;
    }
 
    #custom-search-form .search-query {
        padding-right: 3px;
        padding-right: 4px \9;
        padding-left: 3px;
        padding-left: 4px \9;
        /* IE7-8 doesn't have border-radius, so don't indent the padding */
 
        margin-bottom: 0;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
    }
 
    #custom-search-form button {
        border: 0;
        background: none;
        /** belows styles are working good */
        padding: 2px 5px;
        margin-top: 2px;
        position: relative;
        left: -28px;
        /* IE7-8 doesn't have border-radius, so don't indent the padding */
        margin-bottom: 0;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
    }
 
    .search-query:focus + button {
        z-index: 3;   
    }
</style>


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

</body>
</html>

