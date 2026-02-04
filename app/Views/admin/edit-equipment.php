<?php
if(!isset($_SESSION['user_id'])){
    redirect()->to('/')->send();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Equipment</title>
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
<?php $page='update-equip'; include 'includes/sidebar.php'?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb">
            <a href="<?= site_url('admin') ?>" class="tip-bottom"><i class="fas fa-home"></i> Home</a>
            <a href="<?= site_url('admin/equipment') ?>">Equipment</a>
            <a href="#" class="current">Edit Equipment</a>
        </div>
        <h1>Edit Equipment</h1>
    </div>

    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span6">
                <div class="widget-box">
                    <div class="widget-title">
                        <span class="icon"><i class="fas fa-edit"></i></span>
                        <h5>Equipment Information</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <?php if(isset($equipment) && $equipment): ?>
                            <form action="<?= site_url('admin/edit-equipment-req') ?>" method="POST" class="form-horizontal">
                                <?= csrf_field() ?>
                                <input type="hidden" name="equip_id" value="<?= $equipment['id'] ?>" />
                                
                                <div class="control-group">
                                    <label class="control-label">Equipment Name:</label>
                                    <div class="controls">
                                        <input type="text" class="span11" name="ename" value="<?= $equipment['name'] ?>" required />
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Description:</label>
                                    <div class="controls">
                                        <input type="text" class="span11" name="description" value="<?= $equipment['description'] ?>" required />
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Quantity:</label>
                                    <div class="controls">
                                        <input type="number" class="span5" name="quantity" value="<?= $equipment['quantity'] ?>" required />
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Unit Amount ($):</label>
                                    <div class="controls">
                                        <input type="number" step="0.01" class="span5" name="amount" value="<?= $equipment['amount'] / $equipment['quantity'] ?>" required />
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Vendor:</label>
                                    <div class="controls">
                                        <input type="text" class="span11" name="vendor" value="<?= $equipment['vendor'] ?>" required />
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Address:</label>
                                    <div class="controls">
                                        <input type="text" class="span11" name="address" value="<?= $equipment['address'] ?? '' ?>" />
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Contact:</label>
                                    <div class="controls">
                                        <input type="text" class="span11" name="contact" value="<?= $equipment['contact'] ?? '' ?>" />
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save"></i> Update Equipment
                                    </button>
                                    <a href="<?= site_url('admin/equipment') ?>" class="btn btn-default">
                                        <i class="fas fa-times"></i> Cancel
                                    </a>
                                </div>
                            </form>
                        <?php else: ?>
                            <div class="alert alert-danger">
                                Equipment not found!
                            </div>
                        <?php endif; ?>
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

