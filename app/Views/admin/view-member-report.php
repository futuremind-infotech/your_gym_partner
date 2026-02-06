<?php
if (!session()->get('isLoggedIn')) {
    return redirect()->to(site_url('admin'));
}

if (!isset($member)) {
    return redirect()->to(site_url('admin/members-report'));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Gym System Admin - Member Report</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="<?= base_url('css/bootstrap.min.css') ?>" />
<link rel="stylesheet" href="<?= base_url('css/bootstrap-responsive.min.css') ?>" />
<link rel="stylesheet" href="<?= base_url('css/fullcalendar.css') ?>" />
<link rel="stylesheet" href="<?= base_url('css/matrix-style.css') ?>" />
<link rel="stylesheet" href="<?= base_url('css/matrix-media.css') ?>" />
<link href="<?= base_url('font-awesome/css/fontawesome.css') ?>" rel="stylesheet" />
<link href="<?= base_url('font-awesome/css/all.css') ?>" rel="stylesheet" />
<link rel="stylesheet" href="<?= base_url('css/jquery.gritter.css') ?>" />
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
<?php $page='member-repo'; include 'includes/sidebar.php'?>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
      <a href="<?= site_url('admin') ?>" title="Go to Home" class="tip-bottom"><i class="fas fa-home"></i> Home</a>
      <a href="<?= site_url('admin/members-report') ?>" class="current">Member Reports</a>
    </div>
    <h1 class="text-center">Member's Report <i class="fas fa-file"></i></h1>
  </div>
  <div class="container-fluid print-container">
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
                      <td>Email: support@perfectgym.com</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="span8">
                <table class="table table-bordered table-invoice-full">
                  <thead>
                    <tr>
                      <th class="head0">Membership ID</th>
                      <th class="head1">Services Taken</th>
                      <th class="head0 right">My Plans (Upto)</th>
                      <th class="head1 right">Address</th>
                      <th class="head0 right">Charge</th>
                      <th class="head0 right">Attendance Count</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><div class="text-center">PGC-SS-<?= $member['user_id'] ?></div></td>
                      <td><div class="text-center"><?= esc($member['services']) ?></div></td>
                      <td><div class="text-center"><?php if($member['plan'] == 0) { echo 'NONE';} else {echo $member['plan'].' Month/s';} ?></div></td>
                      <td><div class="text-center"><?= esc($member['address']) ?></div></td>
                      <td><div class="text-center">₹<?= number_format($member['amount'], 2) ?></div></td>
                      <td><div class="text-center"><?= $member['attendance_count'] ?> Day/s</div></td>
                    </tr>
                  </tbody>
                </table>
                <table class="table table-bordered table-invoice-full">
                  <tbody>
                    <tr>
                      <td class="msg-invoice" width="55%"> <div class="text-center"><h4>Last Payment Done: ₹<?= number_format($member['amount'], 2) ?>/-</h4>
                        <em><a href="#" class="tip-bottom" title="Registration Date" style="font-size:15px;">Member Since: <?= $member['dor'] ?> </a></em> </td>
                        </div>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="row-fluid">
                <div class="pull-left">
                <h4>Member <?= esc($member['fullname']) ?>,<br/> <br/> Membership is currently <strong><?= esc($member['status']) ?></strong>! <br/></h4><p>Thank you for choosing our services.<br/>- on the behalf of whole team</p>
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

  <div class="text-center">
    <button class="btn btn-danger" onclick="window.print()"><i class="fas fa-print"></i> Print</button>
  </div>

</div>

<!--Footer-part-->
<div class="row-fluid">
  <div id="footer" class="span12"> <?= date("Y");?> &copy; Developed By Naseeb Bajracharya</a> </div>
</div>

<style>
#footer {
  color: white;
}
</style>

<!-- Scripts -->
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

