<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Update Member Progress<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
if (!isset($member)) {
    return redirect()->to(site_url('admin/customer-progress'));
}
?>

<div class="page-header">
    <h2 class="page-title">Update Member's Progress</h2>
    <div class="breadcrumb">
        <a href="<?= base_url('admin') ?>">Home</a> / <a href="<?= base_url('admin/customer-progress') ?>">Progress Reports</a> / Update Progress
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-signal"></i> Update Progress for <?= esc($member['fullname']) ?></h3>
    </div>
    <div class="card-body">
        <form action="<?= site_url('admin/updateProgress') ?>" method="POST" style="max-width: 600px;">
            <div class="form-group">
                <label for="fullname"><strong>Member Name:</strong></label>
                <input type="text" class="form-control" id="fullname" value="<?= esc($member['fullname']) ?>" readonly />
            </div>

            <div class="form-group">
                <label for="service"><strong>Service Taken:</strong></label>
                <input type="text" class="form-control" id="service" value="<?= esc($member['services']) ?>" readonly />
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ini_weight"><strong>Initial Weight (KG):</strong></label>
                        <input type="number" class="form-control" id="ini_weight" name="ini_weight" value="<?= $member['ini_weight'] ?? '' ?>" step="0.01" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="curr_weight"><strong>Current Weight (KG):</strong></label>
                        <input type="number" class="form-control" id="curr_weight" name="curr_weight" value="<?= $member['curr_weight'] ?? '' ?>" step="0.01" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ini_bodytype"><strong>Initial Body Type:</strong></label>
                        <input type="text" class="form-control" id="ini_bodytype" name="ini_bodytype" value="<?= $member['ini_bodytype'] ?? '' ?>" placeholder="e.g., Slim, Average, Athletic, etc." />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="curr_bodytype"><strong>Current Body Type:</strong></label>
                        <input type="text" class="form-control" id="curr_bodytype" name="curr_bodytype" value="<?= $member['curr_bodytype'] ?? '' ?>" placeholder="e.g., Slim, Average, Athletic, etc." />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <input type="hidden" name="id" value="<?= $member['user_id'] ?>" />
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                <a href="<?= site_url('admin/customer-progress') ?>" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

