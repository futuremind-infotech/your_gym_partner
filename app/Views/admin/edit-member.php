<?php
if (!session()->get('isLoggedIn')) {
    return redirect()->to('/');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Member - Perfect Gym Admin</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <link rel="stylesheet" href="<?= base_url('css/bootstrap.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('css/matrix-style.css') ?>" />
    <link href="<?= base_url('font-awesome/css/all.css') ?>" rel="stylesheet" />
    <style>
        .error { border-color: #e74c3c !important; }
        .text-danger { color: #e74c3c; }
        .help-block { color: #e74c3c; font-size: 12px; }
    </style>
</head>
<body>

<div id="header">
    <h1><a href="<?= site_url('admin') ?>">Perfect Gym Admin</a></h1>
</div>

<?php $page='members-update'; include 'includes/topheader.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb">
            <a href="<?= site_url('admin') ?>"><i class="fas fa-home"></i> Home</a> 
            <a href="<?= site_url('admin/members') ?>">Members</a>
            <span class="current">Edit Member #<?= esc($member_id ?? 'New') ?></span>
        </div>
        <h1>Edit Member <i class="fas fa-user-edit"></i></h1>
    </div>

    <div class="container-fluid">
        <hr>
        
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-block">
                <strong>✅ <?= session()->getFlashdata('success') ?></strong>
                <a href="<?= site_url('admin/members') ?>" class="btn btn-primary">View All Members</a>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-block">
                <strong>❌ <?= session()->getFlashdata('error') ?></strong>
            </div>
        <?php endif; ?>

        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
                        <span class="icon"><i class="fas fa-user-edit"></i></span>
                        <h5>Edit Member Details</h5>
                    </div>
                    <div class="widget-content padding">
                        
                        <?php if (isset($member) && $member): ?>
                            <!-- ✅ FORM WORKS - Points to CORRECT controller method -->
                        <!-- ✅ CORRECT -->
<form class="form-horizontal" method="post" action="<?= site_url('admin/edit-member') ?>">
                                <input type="hidden" name="user_id" value="<?= esc($member['user_id']) ?>">
                                
                                <div class="control-group <?= isset(session('errors')['fullname']) ? 'error' : '' ?>">
                                    <label class="control-label">Full Name <span class="text-danger">*</span></label>
                                    <div class="controls">
                                        <input type="text" name="fullname" class="span8 form-control" 
                                               value="<?= esc($member['fullname']) ?>" required>
                                        <?php if (isset(session('errors')['fullname'])): ?>
                                            <span class="help-block"><?= session('errors')['fullname'] ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="control-group <?= isset(session('errors')['username']) ? 'error' : '' ?>">
                                    <label class="control-label">Username <span class="text-danger">*</span></label>
                                    <div class="controls">
                                        <input type="text" name="username" class="span8 form-control" 
                                               value="<?= esc($member['username']) ?>" required>
                                        <?php if (isset(session('errors')['username'])): ?>
                                            <span class="help-block"><?= session('errors')['username'] ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Gender <span class="text-danger">*</span></label>
                                    <div class="controls">
                                        <select name="gender" class="span8 form-control" required>
                                            <option value="">Select Gender</option>
                                            <option value="Male" <?= $member['gender']=='Male' ? 'selected' : '' ?>>Male</option>
                                            <option value="Female" <?= $member['gender']=='Female' ? 'selected' : '' ?>>Female</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Contact</label>
                                    <div class="controls">
                                        <input type="tel" name="contact" class="span8 form-control" 
                                               value="<?= esc($member['contact']) ?>">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Address</label>
                                    <div class="controls">
                                        <textarea name="address" class="span8 form-control" rows="3"><?= esc($member['address']) ?></textarea>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Amount (₹)</label>
                                    <div class="controls">
                                        <input type="number" name="amount" class="span8 form-control" 
                                               value="<?= number_format($member['amount'], 2) ?>" step="0.01" min="0">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Services</label>
                                    <div class="controls">
                                        <input type="text" name="services" class="span8 form-control" 
                                               value="<?= esc($member['services']) ?>">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Plan (Months)</label>
                                    <div class="controls">
                                        <input type="number" name="plan" class="span8 form-control" 
                                               value="<?= esc($member['plan']) ?>" min="1" max="24">
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button type="submit" class="btn btn-success btn-large">
                                        <i class="fas fa-save"></i> Update Member
                                    </button>
                                    <a href="<?= site_url('admin/members') ?>" class="btn btn-default">Cancel</a>
                                    <a href="<?= site_url('admin/generate_qr/' . $member['user_id']) ?>" class="btn btn-info">
                                        <i class="fas fa-qrcode"></i> Generate QR
                                    </a>
                                </div>
                            </form>
                            
                        <?php elseif (isset($member_id)): ?>
                            <div class="alert alert-danger">
                                <h4><i class="fas fa-exclamation-triangle"></i> Member Not Found!</h4>
                                <p>ID: <?= esc($member_id) ?> does not exist.</p>
                                <a href="<?= site_url('admin/members') ?>" class="btn btn-primary">← Back to Members</a>
                            </div>
                            
                        <?php else: ?>
                            <div class="alert alert-warning">
                                <h4><i class="fas fa-question-circle"></i> No Member Selected!</h4>
                                <p>Please select a member from the members list.</p>
                                <a href="<?= site_url('admin/members') ?>" class="btn btn-primary">← Go to Members</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="footer" class="span12"> <?= date("Y") ?> © Perfect Gym Admin</div>

<script src="<?= base_url('js/jquery.min.js') ?>"></script>
<script src="<?= base_url('js/bootstrap.min.js') ?>"></script>
</body>
</html>
