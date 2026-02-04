<?php
// ✅ FIXED: Removed session checking (handled by controller)
// Get the member ID from query parameters
$member_id = isset($_GET['id']) ? intval($_GET['id']) : null;

if (!$member_id) {
    return redirect()->to('admin/payment');
}

// Get member data from database
$db = \Config\Database::connect();
$member = $db->query("SELECT * FROM members WHERE user_id = ?", [$member_id])->getRowArray();

if (!$member) {
    return redirect()->to('admin/payment');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Member Payment - Gym System Admin</title>
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
    .payment-form-container {
        background: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
    }
    
    .form-group input,
    .form-group select {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }
    
    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }
    
    .member-info {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 6px;
        margin-bottom: 25px;
    }
    
    .member-info p {
        margin: 8px 0;
        color: #666;
    }
    
    .member-info strong {
        color: #333;
    }
    
    .amount-preview {
        background: #e8f4f8;
        padding: 15px;
        border-left: 4px solid #2563eb;
        border-radius: 4px;
        margin: 20px 0;
    }
    
    .amount-preview h4 {
        margin: 0 0 10px 0;
        color: #2563eb;
    }
    
    .button-group {
        display: flex;
        gap: 10px;
        margin-top: 30px;
    }
    
    .btn {
        padding: 12px 24px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-success {
        background: #10b981;
        color: white;
        flex: 1;
    }
    
    .btn-success:hover {
        background: #059669;
    }
    
    .btn-cancel {
        background: #e5e7eb;
        color: #374151;
        flex: 1;
    }
    
    .btn-cancel:hover {
        background: #d1d5db;
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
      <a href="<?= base_url('admin/payment') ?>">Payments</a>
      <a href="#" class="current">Invoice</a>
    </div>
    <h1>Payment Form</h1>
  </div>
  
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title">
            <span class="icon"> <i class="fas fa-money"></i> </span>
            <h5>Member Payment Details</h5>
          </div>
          <div class="widget-content">
            
            <!-- Member Info Section -->
            <div class="member-info">
              <p><strong>Member Name:</strong> <?php echo htmlspecialchars($member['fullname']); ?></p>
              <p><strong>Service:</strong> <?php echo htmlspecialchars($member['services']); ?></p>
              <p><strong>Current Status:</strong> <span class="label label-<?php echo $member['status'] == 'Active' ? 'success' : 'warning'; ?>"><?php echo htmlspecialchars($member['status']); ?></span></p>
              <p><strong>Last Payment Date:</strong> <?php echo $member['paid_date'] == 0 ? 'New Member' : htmlspecialchars($member['paid_date']); ?></p>
            </div>

            <!-- Payment Form -->
            <form action="<?= base_url('admin/userpay') ?>" method="POST" class="payment-form-container">
              
              <div class="form-group">
                <label for="amount">Amount Per Month (₹)</label>
                <input type="number" id="amount" name="amount" class="form-control" 
                  value="<?php 
                    if($member['services'] == 'Fitness') { 
                      echo '55';
                    } elseif ($member['services'] == 'Sauna') { 
                      echo '35';
                    } else {
                      echo '40';
                    } 
                  ?>" onchange="calculateTotal()" required>
              </div>

              <div class="form-group">
                <label for="plan">Membership Plan</label>
                <select name="plan" id="plan" class="form-control" onchange="calculateTotal()" required>
                  <option value="1">One Month</option>
                  <option value="3">Three Months</option>
                  <option value="6">Six Months</option>
                  <option value="12">One Year</option>
                  <option value="0">None-Expired</option>
                </select>
              </div>

              <div class="form-group">
                <label for="status">Member Status</label>
                <select name="status" id="status" class="form-control" required>
                  <option value="Active">Active</option>
                  <option value="Expired">Expired</option>
                </select>
              </div>

              <!-- Amount Preview -->
              <div class="amount-preview">
                <h4>Total Payment: <span id="total-amount">₹0</span></h4>
                <small>Based on selected plan</small>
              </div>

              <!-- Hidden Fields -->
              <input type="hidden" name="fullname" value="<?php echo htmlspecialchars($member['fullname']); ?>">
              <input type="hidden" name="services" value="<?php echo htmlspecialchars($member['services']); ?>">
              <input type="hidden" name="paid_date" value="<?php echo htmlspecialchars($member['paid_date']); ?>">
              <input type="hidden" name="id" value="<?php echo intval($member['user_id']); ?>">

              <!-- Button Group -->
              <div class="button-group">
                <button type="submit" class="btn btn-success" onclick="return confirm('Confirm payment for <?php echo htmlspecialchars($member['fullname']); ?>?')">
                  <i class="fas fa-check"></i> Make Payment
                </button>
                <a href="<?= base_url('admin/payment') ?>" class="btn btn-cancel">
                  <i class="fas fa-times"></i> Cancel
                </a>
              </div>

            </form>

          </div><!-- widget-content ends here -->
        </div><!-- widget-box ends here -->
      </div><!-- span12 ends here -->
    </div> <!-- row-fluid ends here -->
  </div> <!-- container-fluid ends here -->
</div> <!-- div id content ends here -->

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

<script>
function calculateTotal() {
  const amount = parseFloat(document.getElementById('amount').value) || 0;
  const plan = parseInt(document.getElementById('plan').value) || 0;
  const total = amount * plan;
  
  const totalSpan = document.getElementById('total-amount');
  totalSpan.textContent = '₹' + total.toLocaleString('en-IN');
}

// Calculate on page load
document.addEventListener('DOMContentLoaded', calculateTotal);
</script>

</body>
</html>
