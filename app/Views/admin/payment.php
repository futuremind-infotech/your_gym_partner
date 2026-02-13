<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Payments<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h2 class="page-title">Registered Member's Payment</h2>
    <div class="breadcrumb">
        <a href="<?= base_url('admin') ?>">Home</a> / Payments
    </div>
</div>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> <strong>Success!</strong> <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i> <strong>Error!</strong> <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('info')): ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <i class="fas fa-info-circle"></i> <?= session()->getFlashdata('info') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- Debug Info (Development) -->
<?php if (ENVIRONMENT === 'development'): ?>
<div style="background: #f0f0f0; padding: 10px; margin: 10px 0; border-radius: 5px; font-size: 12px; display: none;" id="debugInfo">
    <strong>Debug:</strong> base_url() = <?= htmlspecialchars(base_url()) ?>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-header" style="justify-content: space-between;">
        <h3 class="card-title"><i class="fas fa-hand-holding-usd"></i> Member's Payment Table</h3>
        
        <div style="display: flex; gap: 10px; align-items: center;">
            <a href="<?= site_url('admin/sendBulkReminders') ?>" class="btn btn-warning" title="Send reminders to all members who haven't received one">
                <i class="fas fa-bell"></i> Send Bulk Reminders
            </a>
            <form role="search" method="POST" action="<?= base_url('admin/search-result') ?>" style="display: flex; gap: 10px;">
                <input type="text" placeholder="Search Member..." name="search" required 
                       style="padding: 5px 10px; border: 1px solid var(--gray-200); border-radius: 4px;">
                <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>
    
    <div class="card-body" style="padding: 0;">
        <div class="table-responsive">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Member</th>
                        <th>Last Payment Date</th>
                        <th>Amount</th>
                        <th>Chosen Service</th>
                        <th>Plan</th>
                        <th>Action</th>
                        <th>Remind</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $db = \Config\Database::connect();
                $qry = "SELECT * FROM members";
                $cnt = 1;
                $result = $db->query($qry)->getResultArray();
                
                foreach ($result as $row) { ?>
                    <tr>
                        <td class="text-center"><strong><?= $cnt++ ?></strong></td>
                        <td><?= esc($row['fullname']) ?></td>
                        <td>
                             <?php if($row['paid_date'] == '0'): ?>
                                <span class="badge badge-danger">New Member</span>
                             <?php else: ?>
                                <?= esc($row['paid_date']) ?>
                             <?php endif; ?>
                        </td>
                        <td><strong>₹<?= $row['amount'] ?></strong></td>
                        <td><?= esc($row['services']) ?></td>
                        <td><?= esc($row['plan']) ?> Month/s</td>
                        <td>
                            <a href="<?= site_url('admin/user-payment?id=' . $row['user_id']) ?>" class="btn btn-sm btn-success">
                                <i class="fas fa-money-bill-wave"></i> Make Payment
                            </a>
                        </td>
                        <td>
                             <?php if ($row['reminder'] == 1): ?>
                                <span class="btn btn-sm btn-secondary disabled" style="opacity: 0.6; cursor: not-allowed;">
                                    <i class="fas fa-check"></i> Sent
                                </span>
                             <?php else: ?>
                                <a href="<?= site_url('admin/sendReminder/' . intval($row['user_id'])) ?>" class="btn btn-sm btn-danger">
                                    <i class="fas fa-bell"></i> Alert
                                </a>
                             <?php endif; ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<style>
    #custom-search-form {
        margin:0;
        margin-top: 5px;
        padding: 0;
    }
 
    #custom-search-form .search-query {
        padding-right: 3px;
        padding-right: 4px \9;
        padding-left: 3px;
        padding-left: 4px \9;
        /* IE7-8 doesn't have border-radius, so don't indent the padding */
 
        margin-bottom: 0;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
    }
 
    #custom-search-form button {
        border: 0;
        background: none;
        /** belows styles are working good */
        padding: 2px 5px;
        margin-top: 2px;
        position: relative;
        left: -28px;
        /* IE7-8 doesn't have border-radius, so don't indent the padding */
        margin-bottom: 0;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
    }
 
    .search-query:focus + button {
        z-index: 3;   
    }
</style>


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

