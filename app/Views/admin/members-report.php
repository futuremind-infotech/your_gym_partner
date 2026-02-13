<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Members Report<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php 
$db = \Config\Database::connect();
$result = $db->table('members')->get()->getResultArray();
$cnt = 1;
?>

<div class="page-header">
    <h2 class="page-title">Members Report</h2>
    <div class="breadcrumb">
        <a href="<?= base_url('admin') ?>">Home</a> / <a href="<?= base_url('admin/members-report') ?>">Members Report</a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-file"></i> Members Report</h3>
    </div>
    
    <div class="card-body" style="padding: 0;">
        <div class="table-responsive">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fullname</th>
                        <th>Chosen Service</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($result as $row): ?>
                        <tr>
                            <td class="text-center"><strong><?= $cnt ?></strong></td>
                            <td><?= esc($row['fullname']) ?></td>
                            <td><?= esc($row['services']) ?></td>
                            <td>
                                <a href="<?= site_url('admin/view-member-report?id=' . $row['user_id']) ?>" class="btn btn-sm btn-info">
                                    <i class="fas fa-file"></i> View Report
                                </a>
                            </td>
                        </tr>
                        <?php $cnt++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

