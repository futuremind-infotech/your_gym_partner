<?php
// ✅ FIXED: Get member ID from query parameters
$member_id = isset($_GET['id']) ? intval($_GET['id']) : null;

if (!$member_id) {
    return redirect()->to('admin/payment');
}

// Get member data from database
$db = \Config\Database::connect();
$member = $db->query("SELECT * FROM members WHERE user_id = ?", [$member_id])->getRowArray();

if (!$member) {
    return redirect()->to('admin/payment');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Member Payment - Gym System Admin</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="<?= base_url('css/bootstrap.min.css') ?>" />
<link rel="stylesheet" href="<?= base_url('css/bootstrap-responsive.min.css') ?>" />
<link rel="stylesheet" href="<?= base_url('css/fullcalendar.css') ?>" />
<link rel="stylesheet" href="<?= base_url('css/matrix-style.css') ?>" />
<link rel="stylesheet" href="<?= base_url('css/matrix-media.css') ?>" />
<link href="<?= base_url('font-awesome/css/fontawesome.css') ?>" rel="stylesheet" />
<link href="<?= base_url('font-awesome/css/all.css') ?>" rel="stylesheet" />
<link rel="stylesheet" href="<?= base_url('css/jquery.gritter.css') ?>" />
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="<?= base_url('admin') ?>">Perfect Gym Admin</a></h1>
</div>
<!--close-Header-part--> 

<!--top-Header-menu-->
<?php include APPPATH . 'Views/admin/includes/topheader.php'?>
<!--close-top-Header-menu-->

<!--sidebar-menu-->
<?php $page='payment'; include APPPATH . 'Views/admin/includes/sidebar.php'?>
<!--sidebar-menu-->

<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
      <a href="<?= base_url('admin') ?>" title="Go to Home" class="tip-bottom"><i class="fas fa-home"></i> Home</a>
      <a href="<?= base_url('admin/payment') ?>">Payments</a>
      <a href="#" class="current">Invoice</a>
    </div>
    <h1>Payment Form</h1>
  </div>
  
  <div class="container-fluid" style="margin-top:-38px;">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="fas fa-money"></i> </span>
            <h5>Member's Payment Form</h5>
          </div>
          <div class="widget-content">
            <div class="row-fluid">
              <div class="span5">
                <table class="">
                  <tbody>
                  <tr>
                      <td><img src="<?= base_url('img/gym-logo.png') ?>" alt="Gym Logo" width="175"></td>
                    </tr>
                    <tr>
                      <td><h4>Perfect GYM Club</h4></td>
                    </tr>
                    <tr>
                      <td>5021  Wetzel Lane, Williamsburg</td>
                    </tr>
                    
                    <tr>
                      <td>Tel: 231-267-6011</td>
                    </tr>
                    <tr>
                      <td >Email: support@perfectgym.com</td>
                    </tr>
                  </tbody>
                </table>
              </div>
			  
			  
              <div class="span7">
                <form action=\"<?= site_url('admin/userpay') ?>\" method=\"POST\">
                  <table class="table table-bordered">
                    <tbody>
                      <tr>
                        <td style="width: 30%; font-weight: bold;">Member's Fullname:</td>
                        <input type="hidden" name="fullname" value="<?php echo htmlspecialchars($member['fullname']); ?>">
                        <td style="width: 70%;"><?php echo htmlspecialchars($member['fullname']); ?></td>
                      </tr>
                      <tr>
                        <td style="width: 30%; font-weight: bold;">Service:</td>
                        <input type="hidden" name="services" value="<?php echo htmlspecialchars($member['services']); ?>">
                        <td style="width: 70%;"><?php echo htmlspecialchars($member['services']); ?></td>
                      </tr>
                      <tr>
                        <td style="width: 30%; font-weight: bold;">Amount Per Month:</td>
                        <td style="width: 70%;">
                          <input id="amount" type="number" name="amount" class="form-control" style="width: 100%; padding: 5px;" value="<?php 
                            if($member['services'] == 'Fitness') { 
                              echo '55';
                            } elseif ($member['services'] == 'Sauna') { 
                              echo '35';
                            } else {
                              echo '40';
                            } 
                          ?>" onchange="calculateTotal()" />
                        </td>
                      </tr>
                      <tr>
                        <input type="hidden" name="paid_date" value="<?php echo htmlspecialchars($member['paid_date']); ?>">
                        <td style="width: 30%; font-weight: bold;">Plan:</td>
                        <td style="width: 70%;">
                          <select name="plan" required="required" id="plan" class="form-control" style="width: 100%; padding: 5px;" onchange="calculateTotal()">
                            <option value="1" selected="selected">One Month</option>
                            <option value="3">Three Month</option>
                            <option value="6">Six Month</option>
                            <option value="12">One Year</option>
                            <option value="0">None-Expired</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 30%; font-weight: bold;">Member's Status:</td>
                        <td style="width: 70%;">
                          <select name="status" required="required" id="status" class="form-control" style="width: 100%; padding: 5px;">
                            <option value="Active" selected="selected">Active</option>
                            <option value="Expired">Expired</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2" style="text-align: center; padding: 20px;">
                          <input type="hidden" name="id" value="<?php echo intval($member['user_id']);?>">
                          <button class="btn btn-success btn-large" type="SUBMIT">Make Payment</button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </form>
              </div>
            </div><!-- row-fluid ends here -->
			
      
          </div><!-- widget-content ends here -->
		  
		  
        </div><!-- widget-box ends here -->
      </div><!-- span12 ends here -->
    </div> <!-- row-fluid ends here -->
  </div> <!-- container-fluid ends here -->
</div> <!-- div id content ends here -->



<!--end-main-container-part-->

<!--Footer-part-->

<div class="row-fluid">
  <div id="footer" class="span12"> <?php echo date("Y");?> &copy; </a> </div>
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

// Calculate total amount based on amount and plan
function calculateTotal() {
  var amount = document.getElementById('amount').value || 0;
  var plan = document.getElementById('plan').value || 1;
  var total = amount * plan;
  console.log('Amount: ' + amount + ', Plan: ' + plan + ', Total: ' + total);
  // You can display total in a div or update a field if needed
}
</script>
</body>
</html>

