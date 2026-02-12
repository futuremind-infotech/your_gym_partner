<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Remove Members<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h2 class="page-title">Member List - Removal</h2>
    <div class="breadcrumb">
        <a href="<?= base_url('admin') ?>">Home</a> / Members / Remove Member
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<?php
$db = \Config\Database::connect();
$qry = "SELECT * FROM members ORDER BY dor DESC";
$result = $db->query($qry);
$members = $result->getResultArray();
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-users"></i> Members List</h3>
        <a href="<?= site_url('admin/members') ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-arrow-left"></i> Back to Members
        </a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fullname</th>
                        <th>Username</th>
                        <th>Contact Number</th>
                        <th>D.O.R</th>
                        <th>Address</th>
                        <th>Amount</th>
                        <th>Service</th>
                        <th>Plan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($members && count($members) > 0): ?>
                    <?php $cnt = 1; foreach ($members as $row): ?>
                    <tr>
                        <td class="text-center"><strong><?= $cnt++ ?></strong></td>
                        <td><?= esc($row['fullname']) ?></td>
                        <td><span class="badge badge-info">@<?= esc($row['username']) ?></span></td>
                        <td><?= esc($row['contact']) ?></td>
                        <td><?= date('M d, Y', strtotime($row['dor'])) ?></td>
                        <td><?= esc($row['address']) ?></td>
                        <td><strong>₹<?= number_format($row['amount'], 2) ?></strong></td>
                        <td><?= esc($row['services']) ?></td>
                        <td><?= esc($row['plan']) ?> Month<?= $row['plan'] > 1 ? 's' : '' ?></td>
                        <td class="text-center">
                            <a href="<?= site_url('admin/remove-member?id=' . $row['user_id']) ?>" 
                               class="btn btn-sm btn-icon" style="background: var(--danger); color: #fff;" 
                               title="Remove Member"
                               onclick="return confirm('Are you sure you want to delete <?= esc($row['fullname']) ?>? This action cannot be undone!');">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10" class="text-center">
                            <div class="alert alert-info">
                                <h4><i class="fas fa-users"></i> No Members Found</h4>
                                <p>There are currently no members in the system.</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

