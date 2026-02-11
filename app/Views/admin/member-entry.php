<?= $this->extend('admin/layout') ?>

<?= $this->section('header_title') ?>Add New Member<?= $this->endSection() ?>

<?= $this->section('title') ?>Add Member - Admin Panel<?= $this->endSection() ?>

<?= $this->section('content') ?>

<style>
    .form-card {
        animation: slideUp 0.4s ease;
    }
    
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .form-section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid var(--primary);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
</style>

<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Add New Member</h1>
        <p class="page-subtitle">Register a new member and create their account</p>
    </div>
    <a href="<?= base_url('admin/members') ?>" class="btn btn-outline">
        <i class="fas fa-arrow-left"></i> Back to Members
    </a>
</div>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <div class="d-flex align-items-center gap-2">
            <i class="fas fa-check-circle alert-icon"></i>
            <div>
                <strong>Success!</strong> <?= session()->getFlashdata('success') ?>
            </div>
            <button class="alert-close">&times;</button>
        </div>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <div class="d-flex align-items-center gap-2">
            <i class="fas fa-exclamation-circle alert-icon"></i>
            <div>
                <strong>Error!</strong> <?= session()->getFlashdata('error') ?>
            </div>
            <button class="alert-close">&times;</button>
        </div>
    </div>
<?php endif; ?>

<?php if (isset($validation) && $validation): ?>
    <div class="alert alert-danger">
        <div style="margin-bottom: 0.5rem; font-weight: 600;">
            <i class="fas fa-exclamation-triangle"></i> Please fix the following errors:
        </div>
        <ul style="margin: 0; padding-left: 1.5rem;">
            <?php foreach ($validation->getErrors() as $field => $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
        <button class="alert-close" style="position: absolute; right: 1rem; top: 1rem;">&times;</button>
    </div>
<?php endif; ?>

<!-- Main Form -->
<form action="<?= site_url('admin/add-member') ?>" method="POST" onsubmit="return validateForm()">
    <?= csrf_field() ?>
    
    <div class="grid-container" style="grid-template-columns: repeat(auto-fit, minmax(450px, 1fr)); gap: 2rem;">
        
        <!-- Personal Information Card -->
        <div class="card form-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user-circle"></i> Personal Information
                </h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="fullname" class="form-label">
                        <i class="fas fa-user"></i> Full Name <span style="color: var(--danger);">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="fullname"
                        name="fullname" 
                        class="form-control" 
                        placeholder="Enter full name"
                        required>
                    <small class="form-text">First name and last name</small>
                </div>

                <div class="form-group">
                    <label for="gender" class="form-label">
                        <i class="fas fa-venus-mars"></i> Gender <span style="color: var(--danger);">*</span>
                    </label>
                    <select id="gender" name="gender" class="form-select" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="dor" class="form-label">
                        <i class="fas fa-calendar"></i> Date of Registration <span style="color: var(--danger);">*</span>
                    </label>
                    <input 
                        type="date" 
                        id="dor"
                        name="dor" 
                        class="form-control"
                        required>
                </div>
            </div>
        </div>

        <!-- Account Information Card -->
        <div class="card form-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-lock"></i> Account Information
                </h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="username" class="form-label">
                        <i class="fas fa-at"></i> Username <span style="color: var(--danger);">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="username"
                        name="username" 
                        class="form-control" 
                        placeholder="Choose a unique username"
                        required>
                    <small class="form-text">Must be unique and 3+ characters</small>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">
                        <i class="fas fa-key"></i> Password <span style="color: var(--danger);">*</span>
                    </label>
                    <input 
                        type="password" 
                        id="password"
                        name="password" 
                        class="form-control" 
                        placeholder="Enter a secure password"
                        required>
                    <small class="form-text">Minimum 6 characters recommended</small>
                </div>

                <div style="background: rgba(99, 102, 241, 0.1); border-radius: var(--radius); padding: 1rem; margin-top: 1rem;">
                    <p style="margin: 0; font-size: 0.85rem; color: var(--gray-700);">
                        <i class="fas fa-info-circle" style="color: var(--primary);"></i>
                        <strong>Note:</strong> These credentials will allow the member to login to their account
                    </p>
                </div>
            </div>
        </div>

        <!-- Contact Information Card -->
        <div class="card form-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-address-book"></i> Contact Information
                </h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="contact" class="form-label">
                        <i class="fas fa-phone"></i> Contact Number <span style="color: var(--danger);">*</span>
                    </label>
                    <input 
                        type="tel" 
                        id="contact"
                        name="contact" 
                        class="form-control" 
                        placeholder="10-digit phone number"
                        pattern="[0-9]{10}"
                        required>
                    <small class="form-text">10-digit mobile number</small>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope"></i> Email Address <span style="color: var(--danger);">*</span>
                    </label>
                    <input 
                        type="email" 
                         id="email"
                        name="email" 
                        class="form-control" 
                        placeholder="example@email.com"
                        required>
                </div>

                <div class="form-group">
                    <label for="address" class="form-label">
                        <i class="fas fa-map-marker-alt"></i> Address <span style="color: var(--danger);">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="address"
                        name="address" 
                        class="form-control" 
                        placeholder="Residential address"
                        required>
                </div>
            </div>
        </div>

        <!-- Service & Plan Card -->
        <div class="card form-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-dumbbell"></i> Service & Plan
                </h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="services" class="form-label">
                        <i class="fas fa-list"></i> Service Type <span style="color: var(--danger);">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="services"
                        name="services" 
                        class="form-control" 
                        placeholder="e.g., Fitness, Yoga, Personal Training"
                        required>
                    <small class="form-text">Type of service member will subscribe</small>
                </div>

                <div class="form-group">
                    <label for="plan" class="form-label">
                        <i class="fas fa-hourglass-half"></i> Plan Duration <span style="color: var(--danger);">*</span>
                    </label>
                    <select id="plan" name="plan" class="form-select" required onchange="updateAmount()">
                        <option value="">Select Plan</option>
                        <option value="1">1 Month</option>
                        <option value="3">3 Months</option>
                        <option value="6">6 Months</option>
                        <option value="12">1 Year</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="amount" class="form-label">
                        <i class="fas fa-indian-rupee-sign"></i> Monthly Amount <span style="color: var(--danger);">*</span>
                    </label>
                    <div style="display: flex; gap: 0;">
                        <span style="background: var(--gray-200); padding: 0.7rem 0.85rem; border-radius: var(--radius) 0 0 var(--radius); border: 1px solid var(--gray-300); border-right: none; font-weight: 600; color: var(--gray-700);">₹</span>
                        <input 
                            type="number" 
                            id="amount"
                            name="amount" 
                            class="form-control" 
                            placeholder="Enter amount"
                            style="border-radius: 0 var(--radius) var(--radius) 0; border-left: none;"
                            min="0"
                            step="0.01"
                            required>
                    </div>
                    <small class="form-text">Amount per month</small>
                </div>

                <div style="background: rgba(99, 102, 241, 0.1); border-radius: var(--radius); padding: 1rem; margin-top: 1rem;">
                    <p style="margin: 0; font-size: 0.85rem; color: var(--gray-700);">
                        <strong>Total Cost:</strong> <span style="font-weight: 700; color: var(--primary);">₹<span id="totalCost">0</span></span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Actions -->
    <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 2rem; margin-bottom: 2rem;">
        <button type="submit" class="btn btn-primary btn-lg">
            <i class="fas fa-plus-circle"></i> Add Member
        </button>
        <a href="<?= base_url('admin/members') ?>" class="btn btn-secondary btn-lg">
            <i class="fas fa-times-circle"></i> Cancel
        </a>
    </div>
</form>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Update total cost based on monthly amount and plan duration
function updateAmount() {
    const amount = document.getElementById('amount').value || 0;
    const plan = document.getElementById('plan').value || 0;
    const totalCost = parseInt(amount) * parseInt(plan);
    document.getElementById('totalCost').textContent = totalCost;
}

// Update on amount change as well
document.getElementById('amount').addEventListener('input', updateAmount);

// Form validation
function validateForm() {
    const fullname = document.getElementById('fullname').value.trim();
    const username = document.getElementById('username').value.trim();
    const password = document.getElementById('password').value;
    const contact = document.getElementById('contact').value.trim();
    
    if (fullname.length < 2) {
        alert('Please enter a valid full name');
        return false;
    }
    
    if (username.length < 3) {
        alert('Username must be at least 3 characters');
        return false;
    }
    
    if (password.length < 6) {
        alert('Password must be at least 6 characters');
        return false;
    }
    
    if (contact.length !== 10 || isNaN(contact)) {
        alert('Please enter a valid 10-digit phone number');
        return false;
    }
    
    return true;
}

// Initialize total cost on page load
window.addEventListener('load', updateAmount);
</script>
<?= $this->endSection() ?>
