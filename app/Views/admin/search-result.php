<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Payment Search Results<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
// Get search query from POST
$search = '';
if ($this->request->getMethod() === 'post') {
    $search = $this->request->getPost('search') ?? '';
}

$db = \Config\Database::connect();
$members = [];

if (!empty($search)) {
    $members = $db->table('members')
        ->like('fullname', $search)
        ->orLike('username', $search)
        ->orderBy('fullname', 'ASC')
        ->get()
        ->getResultArray();
}
?>

<div class="page-header">
    <h2 class="page-title">Registered Member's Payment</h2>
    <div class="breadcrumb">
        <a href="<?= base_url('admin') ?>">Home</a> / <a href="<?= base_url('admin/payment') ?>">Payments</a> / Search Results
    </div>
</div>

<?php if (empty($search)): ?>
    <div class="alert alert-info">
        <p>Please enter a search term to find members.</p>
    </div>
<?php elseif (empty($members)): ?>
    <div class="alert alert-warning" style="text-align: center; padding: 40px;">
        <h3 style="color: #d9534f;">No Results Found</h3>
        <p>It seems there's no such record available in our database.</p>
        <a class="btn btn-danger" href="<?= base_url('admin/payment') ?>">Go Back to Payments</a>
    </div>
<?php else: ?>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-search"></i> Member's Payment Table</h3>
        </div>
        
        <div class="card-body" style="padding: 0;">
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Fullname</th>
                            <th>Last Payment Date</th>
                            <th>Amount</th>
                            <th>Chosen Service</th>
                            <th>Plan</th>
                            <th>Action</th>
                            <th>Remind</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $cnt = 1;
                    foreach ($members as $row):
                    ?>
                        <tr>
                            <td class="text-center"><strong><?= $cnt++ ?></strong></td>
                            <td><?= esc($row['fullname']) ?></td>
                            <td>
                                <?php if($row['paid_date'] == '0'): ?>
                                    <span class="badge badge-danger">New Member</span>
                                <?php else: ?>
                                    <?= esc($row['paid_date']) ?>
                                <?php endif; ?>
                            </td>
                            <td><strong>₹<?= $row['amount'] ?></strong></td>
                            <td><?= esc($row['services']) ?></td>
                            <td><?= esc($row['plan']) ?> Month/s</td>
                            <td>
                                <a href="<?= site_url('admin/user-payment?id=' . $row['user_id']) ?>" class="btn btn-sm btn-success">
                                    <i class="fas fa-money-bill-wave"></i> Make Payment
                                </a>
                            </td>
                            <td>
                                <a href="<?= site_url('admin/sendReminder?id=' . $row['user_id']) ?>" 
                                   class="btn btn-sm btn-danger <?= ($row['reminder'] == 1 ? 'disabled' : '') ?>"
                                   <?= ($row['reminder'] == 1 ? 'style="opacity:0.5;pointer-events:none;"' : '') ?>>
                                    <i class="fas fa-bell"></i> Alert
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>

