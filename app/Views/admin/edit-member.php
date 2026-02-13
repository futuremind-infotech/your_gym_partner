<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Edit Member<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h2 class="page-title">Edit Member Details</h2>
    <div class="breadcrumb">
        <a href="<?= site_url('admin') ?>">Home</a> / <a href="<?= site_url('admin/members') ?>">Members</a> / Edit Member
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> <strong>Success!</strong> <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i> <strong>Error!</strong> <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<?php if (!isset($member) || empty($member)): ?>
    <div class="alert alert-danger">
        <h4 class="alert-heading"><i class="fas fa-exclamation-triangle"></i> Member Not Found</h4>
        <p>The member you are trying to edit does not exist or has been deleted.</p>
        <hr>
        <a href="<?= site_url('admin/members') ?>" class="btn btn-primary">Back to Members List</a>
    </div>
<?php else: ?>

<form action="<?= site_url('admin/edit-member-req') ?>" method="POST">
    <?= csrf_field() ?>
    <input type="hidden" name="user_id" value="<?= esc($member['user_id']) ?>">
    
    <div class="grid-container" style="grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));">
        
        <!-- Personal Info -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-user-edit"></i> Personal Information</h3>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <label class="form-label">Full Name</label>
                    <input type="text" class="form-control" name="fullname" value="<?= esc($member['fullname']) ?>" required>
                </div>
                
                <div class="mb-4">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" value="<?= esc($member['username']) ?>" required>
                </div>
                
                <div class="mb-4">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-control">
                        <option value="Male" <?= $member['gender']=='Male'?'selected':'' ?>>Male</option>
                        <option value="Female" <?= $member['gender']=='Female'?'selected':'' ?>>Female</option>
                        <option value="Other" <?= $member['gender']=='Other'?'selected':'' ?>>Other</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Contact & Subscription -->
        <div style="display:flex; flex-direction:column; gap: 1.5rem;">
            
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-address-book"></i> Contact Details</h3>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" value="<?= esc($member['email'] ?? '') ?>" placeholder="member@example.com">
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Contact Number</label>
                        <input type="text" name="contact" class="form-control" value="<?= esc($member['contact']) ?>">
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="2"><?= esc($member['address']) ?></textarea>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-dumbbell"></i> Subscription Details</h3>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label class="form-label">Services</label>
                        <input type="text" name="services" class="form-control" value="<?= esc($member['services']) ?>">
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Total Amount</label>
                        <div style="display: flex; align-items: center;">
                            <span style="padding: 8px 12px; background: var(--gray-200); border: 1px solid var(--gray-300); border-right: none; border-radius: 4px 0 0 4px;">₹</span>
                            <input type="number" name="amount" class="form-control" style="flex:1; border-left:none; border-radius: 0 4px 4px 0;" value="<?= esc($member['amount']) ?>">
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Plan Duration (Months)</label>
                        <input type="number" name="plan" class="form-control" value="<?= esc($member['plan']) ?>">
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    
    <div style="text-align: center; margin-top: 2rem; margin-bottom: 2rem; display: flex; gap: 10px; justify-content: center;">
        <button type="submit" class="btn btn-success" style="padding: 10px 30px; font-size: 1rem;">
            <i class="fas fa-save"></i> Update Member
        </button>
        <a href="<?= site_url('admin/members') ?>" class="btn btn-secondary" style="background: var(--gray-500); color: white; padding: 10px 30px; font-size: 1rem;">
            Cancel
        </a>
    </div>
    
</form>

<?php endif; ?>

<?= $this->endSection() ?>
