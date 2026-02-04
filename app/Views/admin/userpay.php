<?php
// ✅ FIXED: Proper CodeIgniter view for payment processing
// Data passed from Admin controller::userpay()
$success = isset($success) ? $success : false;
$fullname = isset($fullname) ? htmlspecialchars($fullname) : '';
$services = isset($services) ? htmlspecialchars($services) : '';
$amount = isset($amount) ? intval($amount) : 0;
$plan = isset($plan) ? intval($plan) : 0;
$status = isset($status) ? $status : '';
$amountpayable = isset($amountpayable) ? $amountpayable : 0;
$paid_date = isset($paid_date) ? $paid_date : date('Y-m-d');
$error = isset($error) ? $error : '';
?>
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Payment Receipt - Gym System Admin</title>
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
<style>
  table.invoice-items {
    margin: 15px 0;
    width: 100%;
  }
  
  table.invoice-items td {
    padding: 10px 0;
    border-bottom: 1px solid #eee;
  }
  
  table.invoice-items tr.total td {
    border-top: 2px solid #333;
    border-bottom: 2px solid #333;
    font-weight: 700;
    padding: 15px 0;
  }
  
  .alignright { text-align: right; }
  .text-center { text-align: center; }
  .print-container { background: white; padding: 20px; }
  
  @media print {
    body * { visibility: hidden; }
    .print-container, .print-container * { visibility: visible; }
    .print-container { position: absolute; left: 0; top: 0; right: 0; }
    .action-buttons { display: none !important; }
  }
</style>
</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="<?= base_url('admin') ?>">Perfect Gym Admin</a></h1>
</div>
<!--close-Header-part--> 

<!--top-Header-menu-->
<?php include APPPATH . 'Views/admin/includes/topheader.php'?>
<!--close-top-Header-menu-->

<!--sidebar-menu-->
<?php $page='payment'; include APPPATH . 'Views/admin/includes/sidebar.php'?>
<!--sidebar-menu-->

<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
      <a href="<?= base_url('admin') ?>" title="Go to Home" class="tip-bottom"><i class="fas fa-home"></i> Home</a>
      <a href="<?= base_url('admin/payment') ?>" class="tip-bottom">Payment</a>
      <a href="#" class="current">Receipt</a>
    </div>
    <h1>Payment Receipt</h1>
  </div>

  <div class="container-fluid">
    
    <?php if ($success) { ?>
        <!-- SUCCESS RECEIPT -->
        <div class="row-fluid">
          <div class="span12">
            <div class="alert alert-success" style="text-align: center; padding: 15px;">
              <h4><i class="fas fa-check-circle"></i> Payment Processed Successfully!</h4>
            </div>
          </div>
        </div>

        <div class="row-fluid">
          <div class="span12">
            <div class="widget-box">
              <div class="widget-title">
                <span class="icon"> <i class="fas fa-receipt"></i> </span>
                <h5>Payment Receipt</h5>
              </div>
              <div class="widget-content print-container">
                <table width="100%">
                  <tbody>
                    <tr>
                      <td>
                        <h3 class="text-center">✓ Payment Receipt</h3>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <table class="invoice" width="100%">
                          <tbody>
                            <tr>
                              <td><div style="float:left">Invoice #GMS_<?php echo rand(100000,10000000);?> <br> 5021 Wetzel Lane, <br>Williamsburg </div><div style="float:right"> Payment Date: <?php echo date("F j, Y");?></div></td>
                            </tr>
                            <tr>
                              <td class="text-center" style="font-size:14px;"><b>Member: <?php echo $fullname; ?></b> <br>
                                Paid On: <?php echo date("F j, Y - g:i a");?>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <table class="invoice-items" cellpadding="0" cellspacing="0">
                                  <tbody>
                                    <tr>
                                      <td><b>Service Taken</b></td>
                                      <td class="alignright"><b>Valid Upto</b></td>
                                    </tr>
                                    <tr>
                                      <td><?php echo $services; ?></td>
                                      <td class="alignright"><?php echo $plan?> Month(s)</td>
                                    </tr>
                                    <tr>
                                      <td><?php echo 'Charge Per Month'; ?></td>
                                      <td class="alignright"><?php echo '₹'. number_format($amount, 2);?></td>
                                    </tr>
                                    <tr class="total">
                                      <td class="alignright" width="80%">Total Amount Paid</td>
                                      <td class="alignright">₹<?php echo number_format($amountpayable, 2); ?></td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                            <tr>
                              <td class="text-center" style="padding: 20px; color: #666;">
                                We sincerely appreciate your promptness regarding all payments.
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        
        <!-- ACTION BUTTONS -->
        <div class="row-fluid action-buttons" style="margin-top: 20px;">
          <div class="span12 text-center">
            <button class="btn btn-primary" onclick="window.print()">
              <i class="fas fa-print"></i> Print Receipt
            </button>
            <a href="<?= base_url('admin/payment') ?>" class="btn btn-info">
              <i class="fas fa-arrow-left"></i> Back to Payments
            </a>
          </div>
        </div>
        
        <?php } elseif ($status == 'Expired') { ?>
        <!-- EXPIRED ACCOUNT WARNING -->
        <div class="row-fluid">
          <div class="span12">
            <div class="alert alert-warning" style="padding: 20px; text-align: center;">
              <h4><i class="fas fa-exclamation-circle"></i> Account Status: EXPIRED</h4>
              <p>The member's account has been marked as EXPIRED.</p>
              <p>The selected member's account will no longer be activated until the next payment.</p>
              <a href="<?= base_url('admin/payment') ?>" class="btn btn-danger">
                <i class="fas fa-arrow-left"></i> Go Back to Payments
              </a>
            </div>
          </div>
        </div>
        
        <?php } else { ?>
        <!-- ERROR MESSAGE -->
        <div class="row-fluid">
          <div class="span12">
            <div class="alert alert-danger" style="padding: 20px; text-align: center;">
              <h3><i class="fas fa-times-circle"></i> Something went wrong!</h3>
              <p>The payment could not be processed. Please try again.</p>
              <?php if (!empty($error)) { ?>
                <p style="color: red; font-weight: bold; margin-top: 15px;">Debug Info: <?= htmlspecialchars($error) ?></p>
              <?php } ?>
              <a href="<?= base_url('admin/payment') ?>" class="btn btn-danger">
                <i class="fas fa-arrow-left"></i> Go Back to Payments
              </a>
            </div>
          </div>
        </div>
    <?php } ?>
    
  </div>
</div>

<!--end-main-container-part-->

<!--Footer-part-->
<div class="row-fluid">
  <div id="footer" class="span12"> <?php echo date("Y");?> &copy; Developed By Naseeb Bajracharya </div>
</div>

<style>
#footer {
  color: white;
  text-align: center;
  padding: 20px;
}
</style>
<!--end-Footer-part-->

<script src="<?= base_url('js/jquery.min.js') ?>"></script> 
<script src="<?= base_url('js/bootstrap.min.js') ?>"></script> 

</body>
</html>

