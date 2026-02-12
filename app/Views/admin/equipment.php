<?php
if(!isset($_SESSION['user_id'])){
    redirect()->to('/')->send();
}
?>
<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Equipment List<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h2 class="page-title">Equipment Management</h2>
    <div class="breadcrumb">
        <a href="<?= site_url('admin') ?>">Home</a> / Equipment List
    </div>
</div>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-cogs"></i> Equipment List</h3>
        <a href="<?= site_url('admin/equipment-entry') ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Add Equipment
        </a>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Amount ()</th>
                        <th>Vendor</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $cnt = 1; ?>
                    <?php foreach($equipment as $equip): ?>
                    <tr>
                        <td><strong><?= $cnt++ ?></strong></td>
                        <td><?= esc($equip['name']) ?></td>
                        <td><?= esc($equip['description']) ?></td>
                        <td><span class="badge badge-info"><?= $equip['quantity'] ?></span></td>
                        <td><strong><?= number_format($equip['amount'], 2) ?></strong></td>
                        <td><?= esc($equip['vendor']) ?></td>
                        <td><?= date('M d, Y', strtotime($equip['date'])) ?></td>
                        <td>
                            <div class="table-actions">
                                <a href="<?= site_url('admin/edit-equipment?id=' . $equip['id']) ?>" 
                                   class="btn btn-sm btn-icon" style="background: var(--warning); color: #fff;" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= site_url('admin/remove-equipment?id=' . $equip['id']) ?>" 
                                   class="btn btn-sm btn-icon" style="background: var(--danger); color: #fff;" 
                                   title="Delete" onclick="return confirm('Are you sure you want to delete this equipment?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if(empty($equipment)): ?>
                        <tr>
                            <td colspan="8" class="text-center">No equipment found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>


