<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Progress Report<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
if (!isset($member)) {
    return redirect()->to(site_url('admin/customer-progress'));
}
?>

<div class="page-header">
    <h2 class="page-title">Progress Report</h2>
    <div class="breadcrumb">
        <a href="<?= base_url('admin') ?>">Home</a> / <a href="<?= base_url('admin/customer-progress') ?>">Progress Reports</a> / <?= esc($member['fullname']) ?>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-tasks"></i> Member Progress Details</h3>
        <button class="btn btn-sm btn-primary" onclick="window.print()" style="float:right;">
            <i class="fas fa-print"></i> Print Report
        </button>
    </div>
    <div class="card-body">
        <div style="padding: 20px; background: #f8f9fa; border-radius: 6px;">
            <table class="modern-table">
                <tbody>
                    <tr>
                        <td style="width: 30%; font-weight: bold;">Member ID:</td>
                        <td>PGC-SS-<?= esc($member['user_id']) ?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Member Name:</td>
                        <td><?= esc($member['fullname']) ?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Services Taken:</td>
                        <td><?= esc($member['services']) ?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Plan Duration:</td>
                        <td><?= esc($member['plan'] ?? 'N/A') ?> Month(s)</td>
                    </tr>
                    <tr style="background:#e8f4f8;">
                        <td style="font-weight: bold;">Initial Weight:</td>
                        <td><strong><?= $member['ini_weight'] ?? 'N/A' ?> KG</strong></td>
                    </tr>
                    <tr style="background:#e8f4f8;">
                        <td style="font-weight: bold;">Current Weight:</td>
                        <td><strong><?= $member['curr_weight'] ?? 'N/A' ?> KG</strong></td>
                    </tr>
                    <tr style="background:#ccf2ff;">
                        <td style="font-weight: bold;">Weight Difference:</td>
                        <td><strong><?= number_format(($member['curr_weight'] ?? 0) - ($member['ini_weight'] ?? 0), 2) ?> KG</strong></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Initial Body Type:</td>
                        <td><?= $member['ini_bodytype'] ?? 'N/A' ?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Current Body Type:</td>
                        <td><?= $member['curr_bodytype'] ?? 'N/A' ?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Progress Date:</td>
                        <td><?= esc($member['progress_date'] ?? 'N/A') ?></td>
                    </tr>
                </tbody>
            </table>

            <div class="alert alert-info" style="margin-top: 20px;">
                <i class="fas fa-info-circle"></i> <strong><?= esc($member['fullname']) ?>'s</strong> body structure has progressed from <strong><?= $member['ini_bodytype'] ?? 'N/A' ?></strong> to <strong><?= $member['curr_bodytype'] ?? 'N/A' ?></strong> with a total weight difference of <strong><?= number_format(($member['curr_weight'] ?? 0) - ($member['ini_weight'] ?? 0), 2) ?> KG</strong>.
            </div>

            <div style="margin-top: 30px;">
                <a href="<?= base_url('admin/customer-progress') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Progress Reports
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

