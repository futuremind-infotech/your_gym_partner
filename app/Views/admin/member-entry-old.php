<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Add Member<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h2 class="page-title">Member Entry Form</h2>
    <div class="breadcrumb">
        <a href="<?= base_url('admin') ?>">Home</a> / Manage Members / Add Member
    </div>
</div>

<!-- VALIDATION ERROR MESSAGES -->
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i> <strong>Error!</strong> <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<?php if (isset($validation) && $validation): ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle"></i> <strong>Validation Errors:</strong>
        <ul style="margin: 0; padding-left: 20px;">
            <?php foreach ($validation->getErrors() as $field => $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<!-- SUCCESS MESSAGE -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> <strong>Success!</strong> <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<form action="<?= site_url('admin/add-member') ?>" method="POST">
    <?= csrf_field() ?>
    
    <div class="grid-container" style="grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));">
        
        <!-- Personal Info -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-user"></i> Personal Information</h3>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <label class="form-label">Full Name</label>
                    <input type="text" class="form-control" name="fullname" placeholder="Enter Full Name" style="width:100%; padding: 8px; border: 1px solid var(--gray-300); border-radius: 4px;" required>
                </div>
                
                <div class="mb-4">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" placeholder="Choose a Username" style="width:100%; padding: 8px; border: 1px solid var(--gray-300); border-radius: 4px;" required>
                </div>
                
                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="**********" style="width:100%; padding: 8px; border: 1px solid var(--gray-300); border-radius: 4px;" required>
                    <small style="color: var(--secondary); display:block; margin-top:5px;">Note: The given information will create an account for this particular member</small>
                </div>
                
                <div class="mb-4">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-control" style="width:100%; padding: 8px; border: 1px solid var(--gray-300); border-radius: 4px;" required>
                        <option value="Male" selected="selected">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="form-label">Date of Registration (D.O.R)</label>
                    <input type="date" name="dor" class="form-control" style="width:100%; padding: 8px; border: 1px solid var(--gray-300); border-radius: 4px;" required>
                </div>
            </div>
        </div>

        <!-- Contact & Services -->
        <div style="display:flex; flex-direction:column; gap: 1.5rem;">
            
            <!-- Contact Details -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-address-book"></i> Contact Details</h3>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label class="form-label">Contact Number</label>
                        <input type="number" name="contact" placeholder="9876543210" class="form-control" style="width:100%; padding: 8px; border: 1px solid var(--gray-300); border-radius: 4px;" required>
                        <small style="color: var(--secondary);">(999) 999-9999</small>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" placeholder="email@example.com" class="form-control" style="width:100%; padding: 8px; border: 1px solid var(--gray-300); border-radius: 4px;" required>
                    </div>
                    
                    <div class="mb-4">
                         <label class="form-label">Address</label>
                         <input type="text" name="address" placeholder="Residential Address" class="form-control" style="width:100%; padding: 8px; border: 1px solid var(--gray-300); border-radius: 4px;" required>
                    </div>
                </div>
            </div>

            <!-- Service & Plan -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-dumbbell"></i> Service Details</h3>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label class="form-label">Services</label>
                        <input type="text" name="services" placeholder="e.g. Fitness, Sauna, Cardio" class="form-control" style="width:100%; padding: 8px; border: 1px solid var(--gray-300); border-radius: 4px;" required>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Plan Duration</label>
                        <select name="plan" class="form-control" style="width:100%; padding: 8px; border: 1px solid var(--gray-300); border-radius: 4px;" required>
                          <option value="1" selected="selected">One Month</option>
                          <option value="3">Three Month</option>
                          <option value="6">Six Month</option>
                          <option value="12">One Year</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Total Amount</label>
                        <div style="display: flex; align-items: center;">
                            <span style="padding: 8px 12px; background: var(--gray-200); border: 1px solid var(--gray-300); border-right: none; border-radius: 4px 0 0 4px;">₹</span>
                            <input type="number" name="amount" placeholder="5000" class="form-control" style="flex:1; padding: 8px; border: 1px solid var(--gray-300); border-left:none; border-radius: 0 4px 4px 0;" required>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    
    <div style="text-align: center; margin-top: 2rem; margin-bottom: 2rem;">
        <button type="submit" class="btn btn-primary" style="padding: 10px 30px; font-size: 1rem;">
            <i class="fas fa-check"></i> Submit Member Details
        </button>
    </div>
    
</form>

<?= $this->endSection() ?>

<title>Gym System Admin - Add Member</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="<?= base_url('css/bootstrap.min.css') ?>" />
<link rel="stylesheet" href="<?= base_url('css/bootstrap-responsive.min.css') ?>" />
<link rel="stylesheet" href="<?= base_url('css/matrix-style.css') ?>" />
<link rel="stylesheet" href="<?= base_url('css/matrix-media.css') ?>" />
<link href="<?= base_url('font-awesome/css/fontawesome.css') ?>" rel="stylesheet" />
<link href="<?= base_url('font-awesome/css/all.css') ?>" rel="stylesheet" />
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="<?= site_url('admin') ?>">Perfect Gym Admin</a></h1>
</div>
<!--close-Header-part--> 

<!--top-Header-menu-->
<?php include 'includes/topheader.php'?>
<!--close-top-Header-menu-->

<!--sidebar-menu-->
<?php $page='members-entry'; include 'includes/sidebar.php'?>
<!--sidebar-menu-->
<div id="content">
<div id="content-header">
  <div id="breadcrumb"> <a href="index.php" title="Go to Home" class="tip-bottom"><i class="fas fa-home"></i> Home</a> <a href="#" class="tip-bottom">Manamge Members</a> <a href="#" class="current">Add Members</a> </div>
  <h1>Member Entry Form</h1>
</div>
<div class="container-fluid">
  <hr>
  
  <!-- VALIDATION ERROR MESSAGES -->
  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <h4>Error!</h4>
      <strong><?= session()->getFlashdata('error') ?></strong>
    </div>
  <?php endif; ?>
  
  <?php if (isset($validation) && $validation): ?>
    <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <h4>Validation Errors:</h4>
      <ul>
        <?php foreach ($validation->getErrors() as $field => $error): ?>
          <li><strong><?= ucfirst($field) ?>:</strong> <?= $error ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>
  
  <!-- SUCCESS MESSAGE -->
  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <h4>Success!</h4>
      <strong><?= session()->getFlashdata('success') ?></strong>
    </div>
  <?php endif; ?>
  
  <div class="row-fluid">
    <div class="span6">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="fas fa-user"></i> </span>
          <h5>Personal-info</h5>
        </div>
        <div class="widget-content nopadding">
          <form action="<?= site_url('admin/add-member') ?>" method="POST" class="form-horizontal">
            <?= csrf_field() ?>
            <div class="control-group">
              <label class="control-label">Full Name :</label>
              <div class="controls">
                <input type="text" class="span11" name="fullname" placeholder="Fullname" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Username :</label>
              <div class="controls">
                <input type="text" class="span11" name="username" placeholder="Username" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Password :</label>
              <div class="controls">
                <input type="password"  class="span11" name="password" placeholder="**********"  />
                <span class="help-block">Note: The given information will create an account for this particular member</span>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Gender :</label>
              <div class="controls">
              <select name="gender" required="required" id="select">
                  <option value="Male" selected="selected">Male</option>
                  <option value="Female">Female</option>
                  <option value="Other">Other</option>
                </select>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">D.O.R :</label>
              <div class="controls">
                <input type="date" name="dor" class="span11" />
                <span class="help-block">Date of registration</span>
              </div>
            </div>
        </div>
        
        <div class="widget-title"> <span class="icon"> <i class="fas fa-calendar"></i> </span>
          <h5>Plans</h5>
        </div>
        <div class="widget-content nopadding">
          <div class="form-horizontal">
            <div class="control-group">
              <label for="normal" class="control-label">Plans: </label>
              <div class="controls">
                <select name="plan" required="required" id="select">
                  <option value="1" selected="selected">One Month</option>
                  <option value="3">Three Month</option>
                  <option value="6">Six Month</option>
                  <option value="12">One Year</option>
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
	  
	
    </div>

    
    
    <div class="span6">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="fas fa-phone"></i> </span>
          <h5>Contact Details</h5>
        </div>
        <div class="widget-content nopadding">
          <div class="form-horizontal">
            <div class="control-group">
              <label for="normal" class="control-label">Contact Number</label>
              <div class="controls">
                <input type="number" id="mask-phone" name="contact" placeholder="9876543210" class="span8 mask text">
                <span class="help-block blue span8">(999) 999-9999</span> 
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Email Address :</label>
              <div class="controls">
                <input type="email" class="span11" name="email" placeholder="Email@example.com" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Address :</label>
              <div class="controls">
                <input type="text" class="span11" name="address" placeholder="Address" />
              </div>
            </div>
          </div>
        </div>
        
        <div class="widget-title"> <span class="icon"> <i class="fas fa-dumbbell"></i> </span>
          <h5>Service Details</h5>
        </div>
        <div class="widget-content nopadding">
          <div class="form-horizontal">
            <div class="control-group">
              <label class="control-label">Services</label>
              <div class="controls">
                <input type="text" class="span8" name="services" placeholder="Enter service (e.g. Fitness, Sauna, Cardio)" />
                <span class="help-block">Admin may enter any service name here.</span>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label">Total Amount</label>
              <div class="controls">
                <div class="input-append">
                  <span class="add-on">₹</span> 
                  <input type="number" placeholder="50" name="amount" class="span11">
                  </div>
              </div>
            </div>
            
          
            
            <div class="form-actions text-center">
              <button type="submit" class="btn btn-success">Submit Member Details</button>
            </div>
            </form>

          </div>



        </div>

        </div>
      </div>

	</div>
  </div>
  
  
</div></div>


<!--end-main-container-part-->

<!--Footer-part-->

<div class="row-fluid">
  <div id="footer" class="span12"> <?php echo date("Y");?> &copy; Developed By Naseeb Bajracharya</a> </div>
</div>

<style>
#footer {
  color: white;
}
</style>

<!--end-Footer-part-->

<script src="<?= base_url('js/excanvas.min.js') ?>"></script> 
<script src="<?= base_url('js/jquery.min.js') ?>"></script> 
<script src="<?= base_url('js/jquery.ui.custom.js') ?>"></script> 
<script src="<?= base_url('js/bootstrap.min.js') ?>"></script> 
<script src="<?= base_url('js/jquery.flot.min.js') ?>"></script> 
<script src="<?= base_url('js/jquery.flot.resize.min.js') ?>"></script> 
<script src="<?= base_url('js/jquery.peity.min.js') ?>"></script> 
<script src="<?= base_url('js/fullcalendar.min.js') ?>"></script> 
<script src="<?= base_url('js/matrix.js') ?>"></script> 
<script src="<?= base_url('js/matrix.dashboard.js') ?>"></script> 
<script src="<?= base_url('js/jquery.gritter.min.js') ?>"></script> 
<script src="<?= base_url('js/matrix.interface.js') ?>"></script> 
<script src="<?= base_url('js/matrix.chat.js') ?>"></script> 
<script src="<?= base_url('js/jquery.validate.js') ?>"></script> 
<script src="<?= base_url('js/matrix.form_validation.js') ?>"></script> 
<script src="<?= base_url('js/jquery.wizard.js') ?>"></script> 
<script src="<?= base_url('js/jquery.uniform.js') ?>"></script> 
<script src="<?= base_url('js/select2.min.js') ?>"></script> 
<script src="<?= base_url('js/matrix.popover.js') ?>"></script> 
<script src="<?= base_url('js/jquery.dataTables.min.js') ?>"></script> 
<script src="<?= base_url('js/matrix.tables.js') ?>"></script> 

<script type="text/javascript">
  // This function is called from the pop-up menus to transfer to
  // a different page. Ignore if the value returned is a null string:
  function goPage (newURL) {

      // if url is empty, skip the menu dividers and reset the menu selection to default
      if (newURL != "") {
      
          // if url is "-", it is this page -- reset the menu:
          if (newURL == "-" ) {
              resetMenu();            
          } 
          // else, send page to designated URL            
          else {  
            document.location.href = newURL;
          }
      }
  }

// resets the menu selection upon entry to this page:
function resetMenu() {
   document.gomenu.selector.selectedIndex = 2;
}
</script>
</body>
</html>

