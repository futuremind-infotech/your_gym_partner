<?php
if(!isset($_SESSION['user_id'])){
    redirect()->to('/')->send();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Staff Management</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?= base_url('css/bootstrap.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('css/matrix-style.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('css/matrix-media.css') ?>" />
    <link href="<?= base_url('font-awesome/css/fontawesome.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('font-awesome/css/all.css') ?>" rel="stylesheet" />
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
</head>
<body>
<div id="header">
    <h1><a href="<?= site_url('admin') ?>">Perfect Gym Admin</a></h1>
</div>
<?php include 'includes/topheader.php'?>
<?php $page='staff-management'; include 'includes/sidebar.php'?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb">
            <a href="<?= site_url('admin') ?>" class="tip-bottom"><i class="fas fa-home"></i> Home</a>
            <a href="#" class="current">Staff List</a>
        </div>
        <h1>Staff Management</h1>
    </div>

    <div class="container-fluid">
        <hr>
        
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
                        <span class="icon"><i class="fas fa-users"></i></span>
                        <h5>Staff List</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Designation</th>
                                    <th>Gender</th>
                                    <th>Contact</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $cnt = 1; ?>
                                <?php foreach($staffs as $staff): ?>
                                <tr>
                                    <td><?= $cnt++ ?></td>
                                    <td><?= $staff['fullname'] ?></td>
                                    <td><?= $staff['username'] ?></td>
                                    <td><?= $staff['email'] ?></td>
                                    <td><?= $staff['designation'] ?></td>
                                    <td><?= $staff['gender'] ?></td>
                                    <td><?= $staff['contact'] ?></td>
                                    <td>
                                        <a href="<?= site_url('admin/edit-staff-form?id=' . $staff['user_id']) ?>" class="btn btn-small btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="<?= site_url('admin/remove-staff?id=' . $staff['user_id']) ?>" class="btn btn-small btn-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div class="form-actions">
                            <a href="<?= site_url('admin/staffs-entry') ?>" class="btn btn-success">
                                <i class="fas fa-plus"></i> Add Staff
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('js/jquery.min.js') ?>"></script>
<script src="<?= base_url('js/jquery.ui.custom.js') ?>"></script>
<script src="<?= base_url('js/bootstrap.min.js') ?>"></script>
</body>
</html>
