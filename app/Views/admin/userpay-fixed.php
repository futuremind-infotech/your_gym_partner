<?php
// ✅ FIXED: Proper CodeIgniter view for payment processing
// Data passed from Admin controller::userpay()
$success = isset($success) ? $success : false;
$fullname = isset($fullname) ? $fullname : '';
$services = isset($services) ? $services : '';
$amount = isset($amount) ? 0 : $amount;
$plan = isset($plan) ? 0 : $plan;
$status = isset($status) ? $status : '';
$amountpayable = isset($amountpayable) ? $amountpayable : 0;
$paid_date = isset($paid_date) ? $paid_date : date('Y-m-d');
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
    .print-container {
        background: white;
        padding: 30px;
        border-radius: 8px;
        margin: 20px auto;
        max-width: 700px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .receipt-header {
        text-align: center;
        margin-bottom: 30px;
        border-bottom: 2px solid #2563eb;
        padding-bottom: 20px;
    }
    
    .receipt-header h2 {
        color: #2563eb;
        margin: 0;
    }
    
    .receipt-details {
        margin: 25px 0;
        font-size: 14px;
        line-height: 1.8;
    }
    
    .receipt-details label {
        font-weight: 600;
        color: #333;
        display: inline-block;
        width: 150px;
    }
    
    .receipt-details .value {
        color: #666;
    }
    
    .receipt-table {
        width: 100%;
        margin: 25px 0;
        border-collapse: collapse;
    }
    
    .receipt-table th {
        background: #f0f0f0;
        padding: 12px;
        text-align: left;
        font-weight: 600;
        border-bottom: 2px solid #ddd;
    }
    
    .receipt-table td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
    }
    
    .receipt-table .total-row {
        background: #eef4ff;
        font-weight: 700;
        border-top: 2px solid #2563eb;
    }
    
    .receipt-footer {
        text-align: center;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #ddd;
        color: #666;
        font-size: 13px;
    }
    
    .error-box {
        background: #fee;
        border: 1px solid #fcc;
        border-radius: 4px;
        padding: 20px;
        color: #c00;
        text-align: center;
        margin: 20px;
    }
    
    .success-box {
        background: #efe;
        border: 1px solid #cfc;
        border-radius: 4px;
        padding: 20px;
        color: #060;
        text-align: center;
        margin: 20px;
    }
    
    .button-group {
        text-align: center;
        margin-top: 25px;
    }
    
    .button-group button,
    .button-group a {
        padding: 12px 24px;
        margin: 0 5px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-print {
        background: #2563eb;
        color: white;
    }
    
    .btn-print:hover {
        background: #1e40af;
    }
    
    .btn-back {
        background: #e5e7eb;
        color: #374151;
        text-decoration: none;
        display: inline-block;
    }
    
    .btn-back:hover {
        background: #d1d5db;
    }
    
    @media print {
        body * {
            visibility: hidden;
        }
        
        .print-container, .print-container * {
            visibility: visible;
        }
        
        .print-container {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            box-shadow: none;
            margin: 0;
            padding: 0;
        }
        
        .button-group {
            display: none;
        }
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
    
    <?php if ($success && $status == 'Active') { ?>
        <!-- SUCCESS: Active Status -->
        <div class="success-box">
            <h4><i class="fas fa-check-circle"></i> Payment Processed Successfully!</h4>
            <p>Payment has been recorded for <?php echo htmlspecialchars($fullname); ?></p>
        </div>
        
        <!-- RECEIPT -->
        <div class="print-container">
            <div class="receipt-header">
                <h2>PAYMENT RECEIPT</h2>
                <p>Invoice #GMS_<?php echo rand(100000,10000000); ?></p>
            </div>
            
            <div class="receipt-details">
                <p>
                    <label>Gym Name:</label>
                    <span class="value">Perfect GYM Club</span>
                </p>
                <p>
                    <label>Address:</label>
                    <span class="value">5021 Wetzel Lane, Williamsburg</span>
                </p>
                <p>
                    <label>Phone:</label>
                    <span class="value">231-267-6011</span>
                </p>
            </div>
            
            <hr>
            
            <div class="receipt-details">
                <p>
                    <label>Member Name:</label>
                    <span class="value"><?php echo htmlspecialchars($fullname); ?></span>
                </p>
                <p>
                    <label>Payment Date:</label>
                    <span class="value"><?php echo date("F j, Y - g:i a", strtotime($paid_date)); ?></span>
                </p>
            </div>
            
            <table class="receipt-table">
                <thead>
                    <tr>
                        <th>Service</th>
                        <th>Valid Duration</th>
                        <th>Rate/Month</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo htmlspecialchars($services); ?></td>
                        <td><?php echo $plan; ?> Month(s)</td>
                        <td>₹<?php echo number_format($amount, 2); ?></td>
                        <td>₹<?php echo number_format($amountpayable, 2); ?></td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="3" style="text-align: right;">TOTAL AMOUNT PAID:</td>
                        <td>₹<?php echo number_format($amountpayable, 2); ?></td>
                    </tr>
                </tbody>
            </table>
            
            <div class="receipt-footer">
                <p>Thank you for your payment!</p>
                <p>We sincerely appreciate your promptness regarding all payments.</p>
                <p style="margin-top: 15px; font-size: 11px;">Developed by Naseeb Bajracharya</p>
            </div>
        </div>
        
        <!-- ACTION BUTTONS -->
        <div class="button-group">
            <button type="button" class="btn-print" onclick="window.print()">
                <i class="fas fa-print"></i> Print Receipt
            </button>
            <a href="<?= base_url('admin/payment') ?>" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back to Payments
            </a>
        </div>
        
    <?php } else if ($success && $status == 'Expired') { ?>
        <!-- WARNING: Account Expired -->
        <div class="error-box">
            <h4><i class="fas fa-exclamation-circle"></i> Account Status: EXPIRED</h4>
            <p>The member's account has been marked as expired.</p>
            <p>They will need to renew their membership with a new payment.</p>
            <div class="button-group" style="margin-top: 20px;">
                <a href="<?= base_url('admin/payment') ?>" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Back to Payments
                </a>
            </div>
        </div>
        
    <?php } else { ?>
        <!-- ERROR: No data or processing failed -->
        <div class="error-box">
            <h4><i class="fas fa-times-circle"></i> Unable to Process Payment</h4>
            <p>The payment could not be processed. Please try again.</p>
            <div class="button-group" style="margin-top: 20px;">
                <a href="<?= base_url('admin/payment') ?>" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Back to Payments
                </a>
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
