<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Send Payment Reminder<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$member_id = $this->request->getGet('id');
$db = \Config\Database::connect();

if (!$member_id) {
    return redirect()->to('admin/payment');
}

$member = $db->query("SELECT * FROM members WHERE user_id = ?", [$member_id])->getRowArray();

if (!$member) {
    return redirect()->to('admin/payment');
}

// Check if reminder has already been sent
$hasReminder = $member['reminder'] == 1;
?>

<div class="page-header">
    <h2 class="page-title">Send Payment Reminder</h2>
    <div class="breadcrumb">
        <a href="<?= base_url('admin') ?>">Home</a> / <a href="<?= base_url('admin/payment') ?>">Payments</a> / Send Reminder
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-bell"></i> Payment Reminder</h3>
    </div>
    
    <div class="card-body">
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
                <h4>Reminder Details</h4>
                <table class="modern-table">
                    <tbody>
                        <tr>
                            <td style="width: 30%; font-weight: bold;">Member Name:</td>
                            <td><?= esc($member['fullname']) ?></td>
                        </tr>
                        <tr>
                            <td style="width: 30%; font-weight: bold;">Email/Contact:</td>
                            <td><?= esc($member['email'] ?? 'N/A') ?></td>
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
                            <td><strong>₹<?= esc($member['amount']) ?></strong></td>
                        </tr>
                    </tbody>
                </table>

                <div style="margin-top: 30px; padding: 20px; background: white; border-radius: 6px; border-left: 4px solid #FFC107;">
                    <h5>Reminder Message:</h5>
                    <p>Dear <strong><?= esc($member['fullname']) ?></strong>,</p>
                    <p>This is a friendly reminder that your gym membership payment is due. Please complete your payment at your earliest convenience to avoid any interruption to your membership.</p>
                    <p><strong>Payment Amount:</strong> ₹<?= esc($member['amount']) ?></p>
                    <p><strong>Service:</strong> <?= esc($member['services']) ?></p>
                    <p>If you have already made the payment, please disregard this message. Thank you for your business!</p>
                    <p>Best regards,<br>Perfect Gym Administration</p>
                </div>

                <div style="margin-top: 30px;">
                    <form action="<?= site_url('admin/sendReminder') ?>" method="POST">
                        <?= csrf_field() ?>
                        <input type="hidden" name="member_id" value="<?= intval($member['user_id']) ?>">
                        
                        <button type="submit" class="btn btn-warning" onclick="return confirm('Are you sure you want to send this reminder?');">
                            <i class="fas fa-bell"></i> Send Reminder
                        </button>
                        <a href="<?= base_url('admin/payment') ?>" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
