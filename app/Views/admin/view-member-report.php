<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Member Report<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
if (!isset($member)) {
    return redirect()->to(site_url('admin/members-report'));
}
?>

<div class="page-header">
    <h2 class="page-title">Member's Report</h2>
    <div class="breadcrumb">
        <a href="<?= base_url('admin') ?>">Home</a> / <a href="<?= base_url('admin/members-report') ?>">Members Report</a> / <?= esc($member['fullname']) ?>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-file"></i> Member Details</h3>
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
                        <td><?= esc($member['user_id']) ?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Fullname:</td>
                        <td><?= esc($member['fullname']) ?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Email:</td>
                        <td><?= esc($member['email'] ?? 'N/A') ?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Phone:</td>
                        <td><?= esc($member['phone'] ?? 'N/A') ?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Chosen Service:</td>
                        <td><?= esc($member['services']) ?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Plan:</td>
                        <td><?= esc($member['plan']) ?> Month(s)</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Member Status:</td>
                        <td><span class="badge badge-<?= $member['status'] == 'Active' ? 'success' : 'danger' ?>"><?= esc($member['status']) ?></span></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Joining Date:</td>
                        <td><?= esc($member['joining_date'] ?? 'N/A') ?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Last Payment Date:</td>
                        <td><?= esc($member['paid_date']) ?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Total Amount Paid:</td>
                        <td><strong>₹<?= number_format($member['amount'], 2) ?></strong></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Attendance Count:</td>
                        <td><?= esc($member['attendance_count'] ?? 0) ?></td>
                    </tr>
                </tbody>
            </table>

            <div style="margin-top: 30px;">
                <a href="<?= base_url('admin/members-report') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Members Report
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

