<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Add Staff Member<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h2 class="page-title">Add Staff Member</h2>
    <div class="breadcrumb">
        <a href="<?= base_url('admin') ?>">Home</a> / <a href="<?= base_url('admin/staffs') ?>">Staff Members</a> / Add New Staff
    </div>
</div>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<form action="<?= site_url('admin/add-staff') ?>" method="POST">
    <div class="grid-container" style="grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 2rem;">
        
        <!-- Personal Information -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-user-circle"></i> Personal Information</h3>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <label class="form-label" for="fullname">Full Name <span class="text-danger">*</span></label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="fullname" 
                        name="fullname" 
                        value="<?= old('fullname') ?>"
                        placeholder="Enter full name"
                        required
                    />
                    <?php if (isset($validation) && $validation->hasError('fullname')): ?>
                        <small class="text-danger"><?= $validation->getError('fullname') ?></small>
                    <?php endif; ?>
                </div>

                <div class="mb-4">
                    <label class="form-label" for="email">Email Address <span class="text-danger">*</span></label>
                    <input 
                        type="email" 
                        class="form-control" 
                        id="email" 
                        name="email" 
                        value="<?= old('email') ?>"
                        placeholder="Enter email address"
                        required
                    />
                    <?php if (isset($validation) && $validation->hasError('email')): ?>
                        <small class="text-danger"><?= $validation->getError('email') ?></small>
                    <?php endif; ?>
                </div>

                <div class="mb-4">
                    <label class="form-label" for="gender">Gender <span class="text-danger">*</span></label>
                    <select class="form-control" id="gender" name="gender" required>
                        <option value="">-- Select Gender --</option>
                        <option value="Male" <?= old('gender') === 'Male' ? 'selected' : '' ?>>Male</option>
                        <option value="Female" <?= old('gender') === 'Female' ? 'selected' : '' ?>>Female</option>
                    </select>
                    <?php if (isset($validation) && $validation->hasError('gender')): ?>
                        <small class="text-danger"><?= $validation->getError('gender') ?></small>
                    <?php endif; ?>
                </div>

                <div class="mb-4">
                    <label class="form-label" for="contact">Contact Number <span class="text-danger">*</span></label>
                    <input 
                        type="tel" 
                        class="form-control" 
                        id="contact" 
                        name="contact" 
                        value="<?= old('contact') ?>"
                        placeholder="Enter contact number"
                        pattern="[0-9]{10}"
                        required
                    />
                    <?php if (isset($validation) && $validation->hasError('contact')): ?>
                        <small class="text-danger"><?= $validation->getError('contact') ?></small>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Professional Information -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-briefcase"></i> Professional Information</h3>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <label class="form-label" for="designation">Designation <span class="text-danger">*</span></label>
                    <select class="form-control" id="designation" name="designation" required>
                        <option value="">-- Select Designation --</option>
                        <option value="Cashier" <?= old('designation') === 'Cashier' ? 'selected' : '' ?>>Cashier</option>
                        <option value="Trainer" <?= old('designation') === 'Trainer' ? 'selected' : '' ?>>Trainer</option>
                        <option value="GYM Assistant" <?= old('designation') === 'GYM Assistant' ? 'selected' : '' ?>>GYM Assistant</option>
                        <option value="Front Desk Staff" <?= old('designation') === 'Front Desk Staff' ? 'selected' : '' ?>>Front Desk Staff</option>
                        <option value="Manager" <?= old('designation') === 'Manager' ? 'selected' : '' ?>>Manager</option>
                    </select>
                    <?php if (isset($validation) && $validation->hasError('designation')): ?>
                        <small class="text-danger"><?= $validation->getError('designation') ?></small>
                    <?php endif; ?>
                </div>

                <div class="mb-4">
                    <label class="form-label" for="address">Address <span class="text-danger">*</span></label>
                    <textarea 
                        class="form-control" 
                        id="address" 
                        name="address" 
                        rows="3"
                        placeholder="Enter address"
                        required
                    ><?= old('address') ?></textarea>
                    <?php if (isset($validation) && $validation->hasError('address')): ?>
                        <small class="text-danger"><?= $validation->getError('address') ?></small>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Account Information -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-lock"></i> Account Information</h3>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <label class="form-label" for="username">Username <span class="text-danger">*</span></label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="username" 
                        name="username" 
                        value="<?= old('username') ?>"
                        placeholder="Choose a username"
                        minlength="3"
                        required
                    />
                    <?php if (isset($validation) && $validation->hasError('username')): ?>
                        <small class="text-danger"><?= $validation->getError('username') ?></small>
                    <?php endif; ?>
                </div>

                <div class="mb-4">
                    <label class="form-label" for="password">Password <span class="text-danger">*</span></label>
                    <input 
                        type="password" 
                        class="form-control" 
                        id="password" 
                        name="password" 
                        placeholder="Enter a strong password"
                        minlength="6"
                        required
                    />
                    <?php if (isset($validation) && $validation->hasError('password')): ?>
                        <small class="text-danger"><?= $validation->getError('password') ?></small>
                    <?php endif; ?>
                </div>

                <div class="mb-4">
                    <label class="form-label" for="password_confirm">Confirm Password <span class="text-danger">*</span></label>
                    <input 
                        type="password" 
                        class="form-control" 
                        id="password_confirm" 
                        name="password_confirm" 
                        placeholder="Confirm password"
                        minlength="6"
                        required
                    />
                    <?php if (isset($validation) && $validation->hasError('password_confirm')): ?>
                        <small class="text-danger"><?= $validation->getError('password_confirm') ?></small>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-actions" style="margin-top: 2rem;">
        <a href="<?= site_url('admin/staffs') ?>" class="btn btn-secondary">
            <i class="fas fa-times"></i> Cancel
        </a>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Add Staff Member
        </button>
    </div>
</form>

<?= $this->endSection() ?>

