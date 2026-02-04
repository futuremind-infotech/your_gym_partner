<?php
// ✅ FIXED: Proper CodeIgniter 4 authentication and database
if (!session()->get('isLoggedIn')) {
    return redirect()->to('/');
}

// Get search query if provided
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';
$db = \Config\Database::connect();

// Search members by fullname
if (!empty($searchQuery)) {
    $members = $db->table('members')
        ->like('fullname', $searchQuery)
        ->orderBy('fullname', 'ASC')
        ->get()
        ->getResultArray();
} else {
    $members = $db->table('members')
        ->orderBy('fullname', 'ASC')
        ->get()
        ->getResultArray();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Gym System Admin - Progress Search</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="<?= base_url('css/bootstrap.min.css') ?>" />
<link rel="stylesheet" href="<?= base_url('css/bootstrap-responsive.min.css') ?>" />
<link rel="stylesheet" href="<?= base_url('css/matrix-style.css') ?>" />
<link rel="stylesheet" href="<?= base_url('css/matrix-media.css') ?>" />
<link href="<?= base_url('font-awesome/css/fontawesome.css') ?>" rel="stylesheet" />
<link href="<?= base_url('font-awesome/css/all.css') ?>" rel="stylesheet" />
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="<?= site_url('admin') ?>">Perfect Gym Admin</a></h1>
</div>

<!--top-Header-menu-->
<?php include 'includes/topheader.php'?>

<!--sidebar-menu-->
<?php $page="manage-customer-progress"; include 'includes/sidebar.php'?>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> 
      <a href="<?= site_url('admin') ?>" title="Go to Home" class="tip-bottom"><i class="fas fa-home"></i> Home</a> 
      <a href="<?= site_url('admin/customer-progress') ?>">Progress</a> 
      <a href="#" class="current">Search Results</a> 
    </div>
    <h1 class="text-center">Update Customer's Progress - Search Results <i class="fas fa-signal"></i></h1>
  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">

      <div class='widget-box'>
          <div class='widget-title'> 
            <span class='icon'> <i class='fas fa-search'></i> </span>
            <h5>Search Results</h5>
          </div>
          
          <div class='widget-content nopadding'>
	  
          <?php
          $cnt = 1;
          
          if (empty($members)) {
            echo "
            <div class='error_ex' style='text-align: center; padding: 40px;'>
              <h1 style='color: #d9534f; font-size: 48px;'>No Results</h1>
              <h3>Opps, Results Not Found!!</h3>
              <p>It seems like there's no such record available in our database.</p>
              <a class='btn btn-danger btn-big' href='".site_url('admin/customer-progress')."'>Go Back</a>
            </div>";
          } else {
            echo "
            <table class='table table-bordered table-hover'>
              <thead>
                <tr>
                  <th>#</th>
                  <th>Fullname</th>
                  <th>Choosen Service</th>
                  <th>Plan</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>";
            
            foreach($members as $row) {
              echo "
                <tr>
                  <td><div class='text-center'>".$cnt."</div></td>
                  <td><div class='text-center'>".esc($row['fullname'])."</div></td>
                  <td><div class='text-center'>".esc($row['services'])."</div></td>
                  <td><div class='text-center'>".$row['plan']." Month(s)</div></td>
                  <td><div class='text-center'><a href='".site_url('admin/update-progress?id='.$row['user_id'])."'><button class='btn btn-warning btn-mini'><i class='fas fa-edit'></i> Update Progress</button></a></div></td>
                </tr>";
              $cnt++;
            }
            echo "
              </tbody>
            </table>";
          }
          ?>
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

<script src="../js/excanvas.min.js"></script> 
<script src="../js/jquery.min.js"></script> 
<script src="../js/jquery.ui.custom.js"></script> 
<script src="../js/bootstrap.min.js"></script> 
<script src="../js/jquery.flot.min.js"></script> 
<script src="../js/jquery.flot.resize.min.js"></script> 
<script src="../js/jquery.peity.min.js"></script> 
<script src="../js/fullcalendar.min.js"></script> 
<script src="../js/matrix.js"></script> 
<script src="../js/matrix.dashboard.js"></script> 
<script src="../js/jquery.gritter.min.js"></script> 
<script src="../js/matrix.interface.js"></script> 
<script src="../js/matrix.chat.js"></script> 
<script src="../js/jquery.validate.js"></script> 
<script src="../js/matrix.form_validation.js"></script> 
<script src="../js/jquery.wizard.js"></script> 
<script src="../js/jquery.uniform.js"></script> 
<script src="../js/select2.min.js"></script> 
<script src="../js/matrix.popover.js"></script> 
<script src="../js/jquery.dataTables.min.js"></script> 
<script src="../js/matrix.tables.js"></script> 

</body>
</html>

