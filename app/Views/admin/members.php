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
             <th>QR Code</th>
             <th>Actions</th>
           </tr>
         </thead>
         <tbody>
           <?php if ($members && count($members) > 0): ?>
             <?php $cnt = 1; foreach ($members as $row): ?>
               <tr>
                 <td class='text-center'><strong><?= $cnt++ ?></strong></td>
                 <td class='text-center'><?= esc($row['fullname']) ?></td>
                 <td class='text-center'><span class="badge badge-info">@<?= esc($row['username']) ?></span></td>
                 <td class='text-center'>
                   <span class="badge badge-<?= $row['gender']=='Male' ? 'primary' : 'danger' ?>">
                     <?= esc($row['gender']) ?>
                   </span>
                 </td>
                 <td class='text-center'><?= esc($row['contact']) ?></td>
                 <td class='text-center'><?= date('M d, Y', strtotime($row['dor'])) ?></td>
                 <td class='text-center'><?= substr(esc($row['address']), 0, 20) ?>...</td>
                 <td class='text-center'><strong>$<?= number_format($row['amount'], 2) ?></strong></td>
                 <td class='text-center'><span class="badge badge-success"><?= esc($row['services']) ?></span></td>
                 <td class='text-center'><?= esc($row['plan']) ?> Month<?= $row['plan'] > 1 ? 's' : '' ?></td>
                 
                 <!-- ✅ FIXED QR COLUMN - NO 403 ERRORS! -->
                 <td class="text-center">
                   <a href="<?= site_url('admin/generate_qr/' . $row['user_id']) ?>" 
                      class="btn btn-xs btn-success" target="_blank"
                      title="Generate QR Card">
                     <i class="fas fa-qrcode"></i> QR
                   </a>
                 </td>
                 
                 <td class="text-center">
                   <a href="<?= site_url('admin/editMember?id=' . $row['user_id']) ?>" class="btn btn-xs btn-warning"><i class="fas fa-edit"></i></a>
                   <a href="<?= site_url('admin/removeMember?id=' . $row['user_id']) ?>" class="btn btn-xs btn-danger" onclick="return confirm('Delete?')"><i class="fas fa-trash"></i></a>
                 </td>
               </tr>
             <?php endforeach; ?>
           <?php else: ?>
             <tr>
               <td colspan="12" class="text-center">
                 <div class="alert alert-info">
                   <h4>No Members <i class="fas fa-users"></i></h4>
                   <a href="<?= site_url('admin/memberEntry') ?>" class="btn btn-primary">Add First Member</a>
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
  <a href="<?= site_url('admin/qr_scanner') ?>" class="btn btn-success" style="border-radius:50%;width:55px;height:55px;">
    <i class="fas fa-qrcode fa-lg"></i>
  </a>
</div>

<!--Footer-->
<div id="footer" class="span12"> <?= date("Y") ?> &copy; Perfect Gym - QR Ready! </div>

<style>
#footer { color:white; background:#333; padding:15px; text-align:center; margin-top:30px; }
.table th { background:#34495e; color:white; }
.btn-xs { padding:3px 8px; font-size:11px; }
.table td { vertical-align: middle; }
</style>

<script src="<?= base_url('js/jquery.min.js') ?>"></script>
<script src="<?= base_url('js/bootstrap.min.js') ?>"></script>
</body>
</html>
