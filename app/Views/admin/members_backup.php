<?php
// CodeIgniter 4 session check
if (!session()->get('isLoggedIn')) {
    return redirect()->to('/'); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Gym System Admin - Members</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="<?= base_url('css/bootstrap.min.css') ?>" />
<link rel="stylesheet" href="<?= base_url('css/bootstrap-responsive.min.css') ?>" />
<link rel="stylesheet" href="<?= base_url('css/matrix-style.css') ?>" />
<link rel="stylesheet" href="<?= base_url('css/matrix-media.css') ?>" />
<link href="<?= base_url('font-awesome/css/fontawesome.css') ?>" rel="stylesheet" />
<link href="<?= base_url('font-awesome/css/all.css') ?>" rel="stylesheet" />
<style>
#footer { color:white; background:#333; padding:15px; text-align:center; margin-top:30px; }
.table th { background:#34495e; color:white; }
.btn-xs { padding:3px 8px; font-size:11px; }
.table td { vertical-align: middle; }
.btn-group-xs .btn { margin-right: 3px; }
.alert { margin: 20px 0; }
</style>
</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="<?= site_url('admin') ?>">Perfect Gym Admin</a></h1>
</div>

<!--top-Header-menu-->
<?php include 'includes/topheader.php';?>

<!--sidebar-menu-->
<?php $page="members"; include 'includes/sidebar.php';?>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> 
      <a href="<?= site_url('admin') ?>"><i class="fas fa-home"></i> Home</a> 
      <a href="#" class="current">Registered Members</a> 
    </div>
    <h1>Registered Members List <i class="fas fa-group"></i></h1>
  </div>
  
  <div class="container-fluid">
    <hr>

    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success alert-block">
        <strong>✅ <?= session()->getFlashdata('success') ?></strong>
      </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger alert-block">
        <strong>❌ <?= session()->getFlashdata('error') ?></strong>
      </div>
    <?php endif; ?>

    <?php
    // ALL DATABASE QUERIES AT TOP - NO ERRORS!
    $db = \Config\Database::connect();
    $countQry = "SELECT COUNT(*) as total FROM members";
    $countResult = $db->query($countQry);
    $totalMembers = $countResult->getRow()->total ?? 0;
    
    $qry = "SELECT * FROM members ORDER BY dor DESC";
    $result = $db->query($qry);
    $members = $result->getResultArray();
    ?>

    <div class='widget-box'>
      <div class='widget-title'> 
        <span class='icon'><i class='fas fa-th'></i></span>
        <h5>Member table <span class="badge badge-success"><?= $totalMembers ?> Members</span></h5>
        <div class="buttons">
          <a href="<?= site_url('admin/member-entry') ?>" class="btn btn-primary btn-small">
            <i class="fas fa-plus"></i> Add New Member
          </a>
        </div>
      </div>
      <div class='widget-content nopadding'>
        
        <table class='table table-bordered table-hover'>
         <thead>
           <tr>
             <th>#</th>
             <th>Fullname</th>
             <th>Username</th>
             <th>Gender</th>
             <th>Contact</th>
             <th>D.O.R</th>
             <th>Address</th>
             <th>Amount</th>
             <th>Service</th>
             <th>Plan</th>
             <th>Attendance</th>
             <th>Actions</th>
           </tr>
         </thead>
         <tbody>
           <?php if ($members && count($members) > 0): ?>
             <?php $cnt = 1; foreach ($members as $row): ?>
               <tr>
                 <td class='text-center'><strong><?= $cnt++ ?></strong></td>
                 <td><?= esc($row['fullname']) ?></td>
                 <td><span class="badge badge-info">@<?= esc($row['username']) ?></span></td>
                 <td>
                   <span class="badge badge-<?= $row['gender']=='Male' ? 'primary' : 'danger' ?>">
                     <?= esc($row['gender']) ?>
                   </span>
                 </td>
                 <td><?= esc($row['contact']) ?></td>
                 <td><?= date('M d, Y', strtotime($row['dor'])) ?></td>
                 <td><?= substr(esc($row['address']), 0, 20) ?>...</td>
                 <td><strong>₹<?= number_format($row['amount'], 2) ?></strong></td>
                 <td><span class="badge badge-success"><?= esc($row['services']) ?></span></td>
                 <td><?= esc($row['plan']) ?> Month<?= $row['plan'] > 1 ? 's' : '' ?></td>
                 <td>
                   <span class="badge badge-<?= $row['attendance_count'] > 10 ? 'success' : 'warning' ?>">
                     <?= $row['attendance_count'] ?> visits
                   </span>
                 </td>
                 
                 <!-- ✅ PERFECT ACTION BUTTONS -->
                 <td class="text-center">
                   <div class="btn-group btn-group-xs" role="group">
                     
                     <!-- EDIT BUTTON -->
                     <a href="<?= site_url('admin/edit-member?id=' . $row['user_id']) ?>" 
                        class="btn btn-warning" title="Edit Member">
                       <i class="fas fa-edit"></i>
                     </a>
                     
                     <!-- DELETE BUTTON -->
                     <a href="<?= site_url('admin/remove-member?id=' . $row['user_id']) ?>" 
                        class="btn btn-danger" 
                        onclick="return confirm('Delete <?= esc($row['fullname']) ?>? This cannot be undone!')"
                        title="Delete Member">
                       <i class="fas fa-trash"></i>
                     </a>
                     
                     <!-- QR BUTTON -->
                     <a href="<?= site_url('admin/generate-qr/' . $row['user_id']) ?>" 
                        class="btn btn-success" target="_blank" title="Generate QR Code">
                       <i class="fas fa-qrcode"></i>
                     </a>
                     
                   </div>
                 </td>
               </tr>
             <?php endforeach; ?>
           <?php else: ?>
             <tr>
               <td colspan="12" class="text-center">
                 <div class="alert alert-info">
                   <h4><i class="fas fa-users"></i> No Members Yet</h4>
                   <p>Add your first member to get started — use the "Add New Member" button above.</p>
                 </div>
               </td>
             </tr>
           <?php endif; ?>
         </tbody>
       </table>
     </div>
    </div>

  </div>
</div>

<!-- FLOATING QR SCANNER BUTTON -->
<div style="position:fixed;top:20px;right:20px;z-index:9999;">
  <a href="<?= site_url('admin/qr-scanner') ?>" class="btn btn-success" style="border-radius:50%;width:60px;height:60px;box-shadow:0 4px 8px rgba(0,0,0,0.3);">
    <i class="fas fa-qrcode fa-2x"></i>
  </a>
</div>

<!--Footer-->
<div id="footer" class="span12"> <?= date("Y") ?> &copy; Perfect Gym - QR Ready! </div>

<script src="<?= base_url('js/jquery.min.js') ?>"></script>
<script src="<?= base_url('js/bootstrap.min.js') ?>"></script>

<script>
// Flash messages auto-hide
$(document).ready(function() {
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
});
</script>

</body>
</html>
