<?php
if (! session()->get('isLoggedIn')) {
    header('Location: ' . site_url('/'));
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Member - Perfect Gym Admin</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?= base_url('css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/matrix-style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('font-awesome/css/all.css') ?>">

    <style>
        .error { border-color: #e74c3c !important; }
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
            <span class="current">Edit Member</span>
        </div>
        <h1>Edit Member <i class="fas fa-user-edit"></i></h1>
    </div>

    <div class="container-fluid">
        <hr>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($member)): ?>
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title">
                            <span class="icon"><i class="fas fa-user-edit"></i></span>
                            <h5>Edit Member Details</h5>
                        </div>

                        <div class="widget-content padding">

                            <!-- ✅ FIXED ROUTE -->
                            <form class="form-horizontal" method="post"
                                  action="<?= site_url('admin/edit-member-req') ?>">

                                <?= csrf_field() ?>

                                <input type="hidden" name="user_id" value="<?= esc($member['user_id']) ?>">

                                <div class="control-group">
                                    <label class="control-label">Full Name</label>
                                    <div class="controls">
                                        <input type="text" name="fullname" class="span8"
                                               value="<?= esc($member['fullname']) ?>" required>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Username</label>
                                    <div class="controls">
                                        <input type="text" name="username" class="span8"
                                               value="<?= esc($member['username']) ?>" required>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Gender</label>
                                    <div class="controls">
                                        <select name="gender" class="span8">
                                            <option value="Male" <?= $member['gender']=='Male'?'selected':'' ?>>Male</option>
                                            <option value="Female" <?= $member['gender']=='Female'?'selected':'' ?>>Female</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Contact</label>
                                    <div class="controls">
                                        <input type="text" name="contact" class="span8"
                                               value="<?= esc($member['contact']) ?>">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Address</label>
                                    <div class="controls">
                                        <textarea name="address" class="span8"><?= esc($member['address']) ?></textarea>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Amount</label>
                                    <div class="controls">
                                        <input type="number" name="amount" class="span8"
                                               value="<?= esc($member['amount']) ?>">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Plan (Months)</label>
                                    <div class="controls">
                                        <input type="number" name="plan" class="span8"
                                               value="<?= esc($member['plan']) ?>">
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save"></i> Update Member
                                    </button>
                                    <a href="<?= site_url('admin/members') ?>" class="btn btn-default">Cancel</a>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

        <?php else: ?>
            <div class="alert alert-danger">Member not found.</div>
        <?php endif; ?>
    </div>
</div>

<div id="footer" class="span12">
    <?= date('Y') ?> © Perfect Gym Admin
</div>

<script src="<?= base_url('js/jquery.min.js') ?>"></script>
<script src="<?= base_url('js/bootstrap.min.js') ?>"></script>
</body>
</html>
