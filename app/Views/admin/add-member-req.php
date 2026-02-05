<?php
// CodeIgniter 4 SESSION CHECK (Controller handles this)
if (!session()->get('isLoggedIn')) {
    return redirect()->to('/');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add New Member - Perfect Gym Admin</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <!-- CodeIgniter 4 BASE_URL -->
    <link rel="stylesheet" href="<?= base_url('css/bootstrap.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('css/bootstrap-responsive.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('css/matrix-style.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('css/matrix-media.css') ?>" />
    <link href="<?= base_url('font-awesome/css/fontawesome.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('font-awesome/css/all.css') ?>" rel="stylesheet" />
</head>
<body>

<!-- Header -->
<div id="header">
    <h1><a href="<?= site_url('admin') ?>">Perfect Gym Admin</a></h1>
</div>

<!-- Top Header & Sidebar -->
<?php $page='members-entry'; include 'includes/topheader.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<!-- MAIN CONTENT -->
<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> 
            <a href="<?= site_url('admin') ?>"><i class="fas fa-home"></i> Home</a> 
            <a href="<?= site_url('admin/members') ?>">Manage Members</a> 
            <span class="current">Add New Member</span>
        </div>
        <h1>Add New Member <i class="fas fa-user-plus"></i></h1>
    </div>

    <div class="container-fluid">
        <hr>

        <!-- Success/Error Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>✅ Success!</strong> <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>❌ Error!</strong> <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
                        <span class="icon"><i class="fas fa-user-plus"></i></span>
                        <h5>Add New Member</h5>
                    </div>
                    <div class="widget-content padding">
                        
                        <form class="form-horizontal" method="post" action="<?= site_url('admin/add-member') ?>">
                            <?= csrf_field() ?>
                            
                            <div class="control-group <?= session('errors.fullname') ? 'error' : '' ?>">
                                <label class="control-label">Full Name <span class="text-danger">*</span></label>
                                <div class="controls">
                                    <input type="text" name="fullname" class="span8 form-control" 
                                           value="<?= old('fullname') ?>" 
                                           placeholder="Enter full name" required>
                                    <?php if (session('errors.fullname')): ?>
                                        <span class="help-block text-danger"><?= session('errors.fullname') ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="control-group <?= session('errors.username') ? 'error' : '' ?>">
                                <label class="control-label">Username <span class="text-danger">*</span></label>
                                <div class="controls">
                                    <input type="text" name="username" class="span8 form-control" 
                                           value="<?= old('username') ?>" 
                                           placeholder="Enter username" required>
                                    <?php if (session('errors.username')): ?>
                                        <span class="help-block text-danger"><?= session('errors.username') ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="control-group <?= session('errors.password') ? 'error' : '' ?>">
                                <label class="control-label">Password <span class="text-danger">*</span></label>
                                <div class="controls">
                                    <input type="password" name="password" class="span8 form-control" 
                                           placeholder="Enter password" required>
                                    <?php if (session('errors.password')): ?>
                                        <span class="help-block text-danger"><?= session('errors.password') ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Date of Registration</label>
                                <div class="controls">
                                    <input type="date" name="dor" class="span8 form-control" 
                                           value="<?= date('Y-m-d') ?>">
                                </div>
                            </div>

                            <div class="control-group <?= session('errors.gender') ? 'error' : '' ?>">
                                <label class="control-label">Gender <span class="text-danger">*</span></label>
                                <div class="controls">
                                    <select name="gender" class="span8 form-control" required>
                                        <option value="">Select Gender</option>
                                        <option value="Male" <?= old('gender') == 'Male' ? 'selected' : '' ?>>Male</option>
                                        <option value="Female" <?= old('gender') == 'Female' ? 'selected' : '' ?>>Female</option>
                                    </select>
                                    <?php if (session('errors.gender')): ?>
                                        <span class="help-block text-danger"><?= session('errors.gender') ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="control-group <?= session('errors.services') ? 'error' : '' ?>">
                                <label class="control-label">Services <span class="text-danger">*</span></label>
                                <div class="controls">
                                    <input type="text" name="services" class="span8 form-control" value="<?= old('services') ?>" placeholder="Enter service name (e.g. Fitness)" required>
                                    <?php if (session('errors.services')): ?>
                                        <span class="help-block text-danger"><?= session('errors.services') ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="control-group <?= session('errors.amount') ? 'error' : '' ?>">
                                <label class="control-label">Amount per Month (₹) <span class="text-danger">*</span></label>
                                <div class="controls">
                                    <input type="number" name="amount" class="span8 form-control" 
                                           value="<?= old('amount', 1000) ?>" min="0" step="0.01" required>
                                    <?php if (session('errors.amount')): ?>
                                        <span class="help-block text-danger"><?= session('errors.amount') ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="control-group <?= session('errors.plan') ? 'error' : '' ?>">
                                <label class="control-label">Plan Duration <span class="text-danger">*</span></label>
                                <div class="controls">
                                    <select name="plan" class="span8 form-control" required>
                                        <option value="1" <?= old('plan') == '1' ? 'selected' : '' ?>>1 Month</option>
                                        <option value="3" <?= old('plan') == '3' ? 'selected' : '' ?>>3 Months</option>
                                        <option value="6" <?= old('plan') == '6' ? 'selected' : '' ?>>6 Months</option>
                                        <option value="12" <?= old('plan') == '12' ? 'selected' : '' ?>>12 Months</option>
                                    </select>
                                    <?php if (session('errors.plan')): ?>
                                        <span class="help-block text-danger"><?= session('errors.plan') ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Address</label>
                                <div class="controls">
                                    <textarea name="address" class="span8 form-control" rows="3" 
                                              placeholder="Enter full address"><?= old('address') ?></textarea>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Contact Number</label>
                                <div class="controls">
                                    <input type="tel" name="contact" class="span8 form-control" 
                                           placeholder="Enter phone number" value="<?= old('contact') ?>">
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-success btn-large">
                                    <i class="fas fa-user-plus"></i> Add Member
                                </button>
                                <a href="<?= site_url('admin/members') ?>" class="btn btn-inverse">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<div id="footer" class="span12"> <?= date("Y") ?> &copy; Perfect Gym Admin </div>

<!-- Scripts -->
<script src="<?= base_url('js/jquery.min.js') ?>"></script>
<script src="<?= base_url('js/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('js/matrix.js') ?>"></script>

<script>
// Auto-calculate total amount
$(document).ready(function() {
    $('input[name="amount"], select[name="plan"]').on('change input', function() {
        let amount = parseFloat($('input[name="amount"]').val()) || 0;
        let plan = parseInt($('select[name="plan"]').val()) || 1;
        let total = amount * plan;
        // You can display total preview here if needed
    });
});
</script>

</body>
</html>
