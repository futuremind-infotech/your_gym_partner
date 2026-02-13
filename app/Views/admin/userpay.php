<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Payment Receipt<?= $this->endSection() ?>

<?= $this->section('content') ?>

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

<?php if ($success) { ?>
    <!-- SUCCESS RECEIPT -->
    <div class="page-header">
        <h2 class="page-title">Payment Receipt</h2>
        <div class="breadcrumb">
            <a href="<?= base_url('admin') ?>">Home</a> / <a href="<?= base_url('admin/payment') ?>">Payments</a> / Receipt
        </div>
    </div>

    <div class="alert alert-success" style="text-align: center; padding: 20px; margin-bottom: 20px;">
        <h4><i class="fas fa-check-circle"></i> Payment Processed Successfully!</h4>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-receipt"></i> Payment Receipt</h3>
        </div>
        <div class="card-body">
            <div class="receipt-container" style="background: white; padding: 30px; border: 1px solid #ddd;">
                <h3 class="text-center" style="margin-top: 0;">✓ Payment Receipt</h3>
                
                <div style="display: flex; justify-content: space-between; margin: 20px 0; border-bottom: 2px solid #333; padding-bottom: 20px;">
                    <div>
                        <strong>Invoice #GMS_<?php echo rand(100000,10000000);?></strong><br>
                        5021 Wetzel Lane, <br>Williamsburg
                    </div>
                    <div style="text-align: right;">
                        <strong>Payment Date:</strong> <?php echo date("F j, Y");?>
                    </div>
                </div>

                <div style="text-align: center; margin: 20px 0; border-bottom: 1px solid #ddd; padding-bottom: 20px;">
                    <p style="margin: 0;"><strong>Member: <?php echo $fullname; ?></strong></p>
                    <p style="margin: 5px 0;">Paid On: <?php echo date("F j, Y - g:i a");?></p>
                </div>

                <table style="width: 100%; margin: 20px 0; border-collapse: collapse;">
                    <tbody>
                        <tr>
                            <td style="padding: 10px 0; border-bottom: 1px solid #eee;"><strong>Service Taken</strong></td>
                            <td style="padding: 10px 0; border-bottom: 1px solid #eee; text-align: right;"><strong>Valid Upto</strong></td>
                        </tr>
                        <tr>
                            <td style="padding: 10px 0; border-bottom: 1px solid #eee;"><?php echo $services; ?></td>
                            <td style="padding: 10px 0; border-bottom: 1px solid #eee; text-align: right;"><?php echo $plan?> Month(s)</td>
                        </tr>
                        <tr>
                            <td style="padding: 10px 0; border-bottom: 1px solid #eee;"><?php echo 'Charge Per Month'; ?></td>
                            <td style="padding: 10px 0; border-bottom: 1px solid #eee; text-align: right;"><?php echo '₹'. number_format($amount, 2);?></td>
                        </tr>
                        <tr style="border-top: 2px solid #333; border-bottom: 2px solid #333; font-weight: bold;">
                            <td style="padding: 15px 0;">Total Amount Paid</td>
                            <td style="padding: 15px 0; text-align: right;">₹<?php echo number_format($amountpayable, 2); ?></td>
                        </tr>
                    </tbody>
                </table>

                <div style="text-align: center; padding: 20px; color: #666; font-size: 14px;">
                    We sincerely appreciate your promptness regarding all payments.
                </div>
            </div>
        </div>
    </div>

    <!-- ACTION BUTTONS -->
    <div style="margin-top: 20px; text-align: center;">
        <button class="btn btn-primary" onclick="window.print()">
            <i class="fas fa-print"></i> Print Receipt
        </button>
        <a href="<?= base_url('admin/payment') ?>" class="btn btn-info">
            <i class="fas fa-arrow-left"></i> Back to Payments
        </a>
    </div>
    
<?php } elseif ($status == 'Expired') { ?>
    <!-- EXPIRED ACCOUNT WARNING -->
    <div class="page-header">
        <h2 class="page-title">Payment Status</h2>
    </div>

    <div class="alert alert-warning" style="padding: 20px; text-align: center;">
        <h4><i class="fas fa-exclamation-circle"></i> Account Status: EXPIRED</h4>
        <p>The member's account has been marked as EXPIRED.</p>
        <p>The selected member's account will no longer be activated until the next payment.</p>
        <a href="<?= base_url('admin/payment') ?>" class="btn btn-danger">
            <i class="fas fa-arrow-left"></i> Go Back to Payments
        </a>
    </div>
    
<?php } else { ?>
    <!-- ERROR MESSAGE -->
    <div class="page-header">
        <h2 class="page-title">Payment Error</h2>
    </div>

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
<?php } ?>

<style>
    .print-container { background: white; }
    .text-center { text-align: center; }
    .receipt-container { background: white; }
    
    @media print {
        * { visibility: hidden; }
        .print-container, .print-container * { visibility: visible; }
        .print-container { position: absolute; left: 0; top: 0; right: 0; }
        .action-buttons { display: none !important; }
        .btn { display: none !important; }
    }
</style>

<?= $this->endSection() ?>