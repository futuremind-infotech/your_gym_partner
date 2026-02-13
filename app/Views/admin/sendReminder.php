<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Send Payment Reminder<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
// Use data passed from controller
$hasReminder = isset($member) && $member['reminder'] == 1;
$hasEmail = isset($member) && !empty($member['email']);
?>

<div class="page-header">
    <h2 class="page-title">Send Payment Reminder</h2>
    <div class="breadcrumb">
        <a href="<?= base_url('admin') ?>">Home</a> / <a href="<?= base_url('admin/payment') ?>">Payments</a> / Send Reminder
    </div>
</div>

<?php if (!isset($member) || !$member): ?>
    <div class="card">
        <div class="card-body">
            <div class="alert alert-danger">
                <h4><i class="fas fa-exclamation-circle"></i> Invalid Member</h4>
                <p>No valid member ID was provided. Please select a member from the payment list.</p>
                <a href="<?= base_url('admin/payment') ?>" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Back to Payments
                </a>
            </div>
        </div>
    </div>
<?php else: ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-bell"></i> Payment Reminder Email</h3>
    </div>
    
    <div class="card-body">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <?php if ($hasReminder): ?>
            <div class="alert alert-warning">
                <h4><i class="fas fa-check-circle"></i> Reminder Already Sent</h4>
                <p>A payment reminder has already been sent to <strong><?= esc($member['fullname']) ?></strong>.</p>
                <a href="<?= base_url('admin/payment') ?>" class="btn btn-info">
                    <i class="fas fa-arrow-left"></i> Back to Payments
                </a>
            </div>
        <?php else: ?>
            <div style="padding: 20px; background: #f8f9fa; border-radius: 8px;">
                <h4>Member Information</h4>
                <table class="modern-table">
                    <tbody>
                        <tr>
                            <td style="width: 30%; font-weight: bold;">Member Name:</td>
                            <td><?= esc($member['fullname']) ?></td>
                        </tr>
                        <tr>
                            <td style="width: 30%; font-weight: bold;">Contact Number:</td>
                            <td><?= esc($member['contact'] ?? 'N/A') ?></td>
                        </tr>
                        <tr>
                            <td style="width: 30%; font-weight: bold;">Service:</td>
                            <td><?= esc($member['services']) ?></td>
                        </tr>
                        <tr>
                            <td style="width: 30%; font-weight: bold;">Last Payment Date:</td>
                            <td><?= esc($member['paid_date']) ?></td>
                        </tr>
                        <tr>
                            <td style="width: 30%; font-weight: bold;">Amount Due:</td>
                            <td><strong style="color: #dc3545;">₹<?= esc($member['amount']) ?></strong></td>
                        </tr>
                    </tbody>
                </table>

                <?php if (!$hasEmail): ?>
                    <div style="margin-top: 30px; padding: 20px; background: #fff3cd; border-left: 4px solid #FFC107; border-radius: 6px;">
                        <h5><i class="fas fa-exclamation-triangle"></i> Email Address Required</h5>
                        <p>No email address is available for this member. Please add the email address to send the payment reminder.</p>
                        
                        <form action="<?= site_url('admin/sendReminder') ?>" method="POST" style="margin-top: 15px;">
                            <?= csrf_field() ?>
                            <input type="hidden" name="member_id" value="<?= intval($member['user_id']) ?>">
                            <input type="hidden" name="action" value="update_email">
                            
                            <div style="display: flex; gap: 10px; align-items: flex-end; flex-wrap: wrap;">
                                <div style="flex: 1; min-width: 250px;">
                                    <label for="email" style="display: block; margin-bottom: 5px; font-weight: bold;">Email Address:</label>
                                    <input type="email" id="email" name="email" class="form-control" placeholder="e.g., member@example.com" required>
                                </div>
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save"></i> Add Email
                                </button>
                            </div>
                        </form>
                    </div>
                <?php else: ?>
                    <div style="margin-top: 30px; padding: 20px; background: #d4edda; border-left: 4px solid #28a745; border-radius: 6px;">
                        <h5><i class="fas fa-check-circle"></i> Email Address Available</h5>
                        <p><strong>Email:</strong> <?= esc($member['email']) ?></p>
                        <p style="font-size: 12px; margin: 10px 0 0 0;">
                            <a href="#" onclick="document.getElementById('emailForm').style.display = 'block'; return false;" style="color: #007bff; text-decoration: underline;">Update email address</a>
                        </p>
                        
                        <form id="emailForm" action="<?= site_url('admin/sendReminder') ?>" method="POST" style="margin-top: 15px; display: none; padding-top: 15px; border-top: 1px solid rgba(0,0,0,0.1);">
                            <?= csrf_field() ?>
                            <input type="hidden" name="member_id" value="<?= intval($member['user_id']) ?>">
                            <input type="hidden" name="action" value="update_email">
                            
                            <div style="display: flex; gap: 10px; align-items: flex-end; flex-wrap: wrap;">
                                <div style="flex: 1; min-width: 250px;">
                                    <label for="newemail" style="display: block; margin-bottom: 5px; font-weight: bold;">New Email Address:</label>
                                    <input type="email" id="newemail" name="email" class="form-control" placeholder="Enter new email address" value="<?= esc($member['email']) ?>" required>
                                </div>
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save"></i> Update
                                </button>
                                <button type="button" class="btn btn-secondary" onclick="document.getElementById('emailForm').style.display = 'none';">Cancel</button>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>

                <?php if ($hasEmail): ?>
                <div style="margin-top: 30px; padding: 20px; background: white; border-radius: 6px; border-left: 4px solid #FFC107;">
                    <h5>Email Message Preview:</h5>
                    <p>Dear <strong><?= esc($member['fullname']) ?></strong>,</p>
                    <p>This is a friendly reminder that your gym membership payment is due. Please complete your payment at your earliest convenience to avoid any interruption to your membership.</p>
                    <p><strong>Payment Details:</strong></p>
                    <ul>
                        <li>Service: <?= esc($member['services']) ?></li>
                        <li>Amount Due: ₹<?= esc($member['amount']) ?></li>
                        <li>Last Payment Date: <?= esc($member['paid_date']) ?></li>
                    </ul>
                    <p>If you have already made the payment, please disregard this message. Thank you for your business!</p>
                    <p>Best regards,<br>Your Gym Partner Administration</p>
                </div>

                <div style="margin-top: 30px;">
                    <p style="color: #666; font-size: 14px;">
                        <i class="fas fa-info-circle"></i> Please wait while we send the reminder email...
                    </p>
                    <form action="<?= site_url('admin/sendReminder/' . intval($member['user_id'])) ?>" method="POST" id="sendReminderForm">
                        <?= csrf_field() ?>
                        <input type="hidden" name="member_id" value="<?= intval($member['user_id']) ?>">
                        <input type="hidden" name="action" value="send_reminder">
                        
                        <button type="submit" class="btn btn-warning" id="sendBtn">
                            <i class="fas fa-envelope"></i> Send Reminder Email
                        </button>
                        <a href="<?= base_url('admin/payment') ?>" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </form>
                </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
console.log('📝 sendReminder form script loaded');

document.addEventListener('DOMContentLoaded', function() {
    console.log('📄 DOM content loaded');
    
    const form = document.getElementById('sendReminderForm');
    const btn = document.getElementById('sendBtn');
    
    console.log('Form found:', !!form);
    console.log('Button found:', !!btn);
    
    if (form && btn) {
        btn.addEventListener('click', function(e) {
            console.log('🖱️ Send button clicked!');
            
            // Confirm with user
            if (!confirm('Are you sure you want to send the payment reminder email to <?= esc($member['email']) ?>?')) {
                console.log('❌ User cancelled the action');
                e.preventDefault();
                return false;
            }
            
            console.log('✓ User confirmed - submitting form');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending Email... Please Wait';
            console.log('📤 Form will now submit');
        });
        
        form.addEventListener('submit', function(e) {
            console.log('📨 Form submit event fired');
            console.log('Form action:', form.action);
            console.log('Form method:', form.method);
        });
    } else {
        console.error('❌ Form or button element not found!');
    }
});
</script>

<?php endif; ?>

<?= $this->endSection() ?>
