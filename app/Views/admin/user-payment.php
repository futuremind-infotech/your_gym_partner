<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Member Payment<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
// Get member ID from query parameters
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

<div class="page-header">
    <h2 class="page-title">Member Payment Form</h2>
    <div class="breadcrumb">
        <a href="<?= base_url('admin') ?>">Home</a> / <a href="<?= base_url('admin/payment') ?>">Payments</a> / Form
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div style="display: flex; gap: 30px;">
            <div class="gym-info" style="flex: 1;">
                <img src="<?= base_url('img/gym-logo.png') ?>" alt="Gym Logo" width="175">
                <h4>Perfect GYM Club</h4>
                <p>5021 Wetzel Lane, Williamsburg</p>
                <p>Tel: 231-267-6011</p>
                <p>Email: support@perfectgym.com</p>
            </div>

                <form action="<?= site_url('admin/userpay') ?>" method="POST">
                    <?= csrf_field() ?>
                    <!-- Hidden fields for form data -->
                    <input type="hidden" name="fullname" value="<?php echo htmlspecialchars($member['fullname']); ?>">
                    <input type="hidden" name="services" value="<?php echo htmlspecialchars($member['services']); ?>">
                    <input type="hidden" name="paid_date" value="<?php echo htmlspecialchars($member['paid_date']); ?>">
                    <input type="hidden" name="id" value="<?php echo intval($member['user_id']);?>">
                    
                    <table class="table table-bordered modern-table">
                        <tbody>
                            <tr>
                                <td style="width: 30%; font-weight: bold;">Member's Fullname:</td>
                                <td style="width: 70%;"><?php echo htmlspecialchars($member['fullname']); ?></td>
                            </tr>
                            <tr>
                                <td style="width: 30%; font-weight: bold;">Service:</td>
                                <td style="width: 70%;"><?php echo htmlspecialchars($member['services']); ?></td>
                            </tr>
                            <tr>
                                <td style="width: 30%; font-weight: bold;">Amount Per Month:</td>
                                <td style="width: 70%;">
                                    <input id="amount" type="number" name="amount" class="form-control" style="width: 100%; padding: 8px;" value="<?php 
                                        if($member['services'] == 'Fitness') { 
                                            echo '55';
                                        } elseif ($member['services'] == 'Sauna') { 
                                            echo '35';
                                        } else { 
                                            echo '40';
                                        } 
                                    ?>" onchange="calculateTotal()" />
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 30%; font-weight: bold;">Plan:</td>
                                <td style="width: 70%;">
                                    <select name="plan" required="required" id="plan" class="form-control" style="width: 100%; padding: 8px;" onchange="calculateTotal()">
                                        <option value="1" selected="selected">One Month</option>
                                        <option value="3">Three Month</option>
                                        <option value="6">Six Month</option>
                                        <option value="12">One Year</option>
                                        <option value="0">None-Expired</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 30%; font-weight: bold;">Member's Status:</td>
                                <td style="width: 70%;">
                                    <select name="status" required="required" id="status" class="form-control" style="width: 100%; padding: 8px;">
                                        <option value="Active" selected="selected">Active</option>
                                        <option value="Expired">Expired</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 30%; font-weight: bold;">Total Amount:</td>
                                <td style="width: 70%;">
                                    <div id="totalAmount" style="font-size: 16px; font-weight: bold; color: #4CAF50; padding: 10px; background: #f0f9ff; border-radius: 4px;">
                                        ₹<span id="totalValue">55</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: center; padding: 20px;">
                                    <button class="btn btn-warning" type="button" onclick="alertPayment()">
                                        <i class="fas fa-bell"></i> Alert Payment
                                    </button>
                                    <button class="btn btn-success" type="submit">
                                        <i class="fas fa-money-bill-wave"></i> Make Payment
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
  // Initialize calculateTotal on page load
  window.onload = function() {
    calculateTotal();
  };

  // Calculate total amount based on amount and plan
  function calculateTotal() {
    var amount = parseInt(document.getElementById('amount').value) || 55;
    var plan = parseInt(document.getElementById('plan').value) || 1;
    var total = amount * plan;
    document.getElementById('totalValue').textContent = total;
  }

  // Alert payment handler
  function alertPayment() {
    var fullname = '<?php echo htmlspecialchars($member['fullname']); ?>';
    var amount = parseInt(document.getElementById('amount').value) || 55;
    var plan = parseInt(document.getElementById('plan').value) || 1;
    var total = amount * plan;
    
    alert('Payment Alert for ' + fullname + '\n\nAmount per month: ₹' + amount + 
          '\nPlan: ' + plan + ' month(s)' + 
          '\nTotal Amount: ₹' + total + 
          '\n\nPlease arrange the payment.');
  }
</script>

<?= $this->endSection() ?>