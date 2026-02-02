<!DOCTYPE html>
<html lang="en">
<head>
    <title>Gym System Admin</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <!-- FIXED PATHS for public/assets/ structure -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap-responsive.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/matrix-style.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/matrix-login.css') ?>" />
    <link href="<?= base_url('assets/font-awesome/css/fontawesome.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('assets/font-awesome/css/all.css') ?>" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
</head>

<body>
    <div id="loginbox">             
        <form id="loginform" method="POST" class="form-vertical" action="<?= base_url('login/process') ?>">
            <div class="control-group normal_text"> 
                <h3><img src="<?= base_url('assets/img/icontest3.png') ?>" alt="Logo" /></h3>
            </div>
            <div class="control-group">
                <div class="controls">
                    <div class="main_input_box">
                        <span class="add-on bg_lg"><i class="fas fa-user-circle"></i></span>
                        <input type="text" name="user" placeholder="Username" required/>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <div class="main_input_box">
                        <span class="add-on bg_ly"><i class="fas fa-lock"></i></span>
                        <input type="password" name="pass" placeholder="Password" required />
                    </div>
                </div>
            </div>
            <div class="form-actions center">
                <button type="submit" class="btn btn-block btn-large btn-info" name="login" value="Admin Login">
                    Admin Login
                </button>
            </div>
        </form>

        <?php if (session()->getFlashdata('error')): ?>
        <div class='alert alert-danger'>
            <?= session()->getFlashdata('error') ?>
        </div>
        <?php endif; ?>

        <div class="pull-left">
            <a href="<?= base_url('customer') ?>"><h6>Customer Login</h6></a>
        </div>
        <div class="pull-right">
            <a href="<?= base_url('staff') ?>"><h6>Staff Login</h6></a>
        </div>
    </div>

    <!-- FIXED JS PATHS -->
    <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>  
    <script src="<?= base_url('assets/js/matrix.login.js') ?>"></script> 
    <script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script> 
    <script src="<?= base_url('assets/js/matrix.js') ?>"></script>
</body>
</html>
