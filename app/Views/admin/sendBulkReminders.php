<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Send Payment Reminders<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h2 class="page-title">Send Payment Reminders to Members</h2>
    <div class="breadcrumb">
        <a href="<?= base_url('admin') ?>">Home</a> / <a href="<?= base_url('admin/payment') ?>">Payments</a> / Send Bulk Reminders
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-bell"></i> Bulk Payment Reminder</h3>
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
        
        <?php if ($count == 0): ?>
            <div class="alert alert-info">
                <h4><i class="fas fa-info-circle"></i> No Pending Reminders</h4>
                <p>All members have already received payment reminders or have no email address on file.</p>
                <a href="<?= base_url('admin/payment') ?>" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Back to Payments
                </a>
            </div>
        <?php else: ?>
            <div style="padding: 20px; background: #e7f3ff; border-left: 4px solid #2196F3; border-radius: 5px; margin-bottom: 20px;">
                <h4><i class="fas fa-info-circle"></i> Bulk Reminder Information</h4>
                <p>You are about to send payment reminder emails to <strong><?= $count ?> member(s)</strong> who:</p>
                <ul>
                    <li>Have not received a reminder yet</li>
                    <li>Have a valid email address on file</li>
                </ul>
                <p style="margin-top: 15px; font-size: 14px; color: #555;">
                    <strong>Note:</strong> Each member will receive a personalized email with their specific payment details.
                </p>
            </div>

            <div style="padding: 20px; background: #f9f9f9; border-radius: 5px; margin-bottom: 20px;">
                <h4><i class="fas fa-users"></i> Members to Receive Reminders</h4>
                <div style="max-height: 300px; overflow-y: auto;">
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <th>Member Name</th>
                                <th>Email</th>
                                <th>Amount Due</th>
                                <th>Service</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pendingMembers as $member): ?>
                                <tr>
                                    <td><?= esc($member['fullname']) ?></td>
                                    <td><code><?= esc($member['email']) ?></code></td>
                                    <td><strong>₹<?= esc($member['amount']) ?></strong></td>
                                    <td><?= esc($member['services']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div style="padding: 20px; background: #fff3cd; border-left: 4px solid #ffc107; border-radius: 5px; margin-bottom: 20px;">
                <h5><i class="fas fa-warning"></i> Important</h5>
                <p>Please ensure that your SMTP email configuration is properly set up before proceeding. Emails will be sent immediately after clicking "Send Reminders".</p>
            </div>

            <form action="<?= site_url('admin/sendBulkReminders') ?>" method="POST" id="bulkReminderForm">
                <?= csrf_field() ?>
                
                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-success btn-lg" id="sendBtn" onclick="return confirm('Are you sure you want to send payment reminders to <?= $count ?> member(s)?');">
                        <i class="fas fa-paper-plane"></i> Send Reminders to <?= $count ?> Member(s)
                    </button>
                    <a href="<?= base_url('admin/payment') ?>" class="btn btn-secondary btn-lg">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('bulkReminderForm');
    const btn = document.getElementById('sendBtn');
    
    if (form) {
        form.addEventListener('submit', function() {
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending Reminders...';
        });
    }
});
</script>

<?= $this->endSection() ?>
