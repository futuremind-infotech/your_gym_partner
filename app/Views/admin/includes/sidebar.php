<div id="sidebar"><a href="#" class="visible-phone"><i class="fas fa-home"></i> Dashboard</a>
  <ul>
    <li class="<?php if($page=='dashboard'){ echo 'active'; }?>"><a href="<?= base_url('admin') ?>"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a> </li>
    <li class="submenu"> <a href="#"><i class="fas fa-users"></i> <span>Manage Members</span> <span class="label label-important"><?php include APPPATH . 'Views/admin/dashboard-usercount.php';?> </span></a>
      <ul>
        <li class="<?php if($page=='members'){ echo 'active'; }?>"><a href="<?= base_url('admin/members') ?>"><i class="fas fa-arrow-right"></i> List All Members</a></li>
        <li class="<?php if($page=='members-entry'){ echo 'active'; }?>"><a href="<?= base_url('admin/member-entry') ?>"><i class="fas fa-arrow-right"></i> Member Entry Form</a></li>
        <li class="<?php if($page=='members-remove'){ echo 'active'; }?>"><a href="<?= base_url('admin/remove-member') ?>"><i class="fas fa-arrow-right"></i> Remove Member</a></li>
        <li class="<?php if($page=='members-update'){ echo 'active'; }?>"><a href="<?= base_url('admin/edit-member') ?>"><i class="fas fa-arrow-right"></i> Update Member Details</a></li>
      </ul>
    </li>

    <li class="submenu"> <a href="#"><i class="fas fa-dumbbell"></i> <span>Gym Equipment</span> <span class="label label-important"><?php include APPPATH . 'Views/admin/dashboard-equipcount.php';?> </span></a>
    <ul>
        <li class="<?php if($page=='list-equip'){ echo 'active'; }?>"><a href="<?= base_url('admin/equipment') ?>"><i class="fas fa-arrow-right"></i> List Gym Equipment</a></li>
        <li class="<?php if($page=='add-equip'){ echo 'active'; }?>"><a href="<?= base_url('admin/equipment-entry') ?>"><i class="fas fa-arrow-right"></i> Add Equipment</a></li>
        <li class="<?php if($page=='remove-equip'){ echo 'active'; }?>"><a href="<?= base_url('admin/remove-equipment') ?>"><i class="fas fa-arrow-right"></i> Remove Equipment</a></li>
        <li class="<?php if($page=='update-equip'){ echo 'active'; }?>"><a href="<?= base_url('admin/edit-equipment') ?>"><i class="fas fa-arrow-right"></i> Update Equipment Details</a></li>
      </ul>
    </li>
    <li class="<?php if($page=='attendance'){ echo 'submenu active'; } else { echo 'submenu';}?>"> <a href="#"><i class="fas fa-calendar-alt"></i> <span>Attendance</span></a>
      <ul>
        <li class="<?php if($page=='attendance'){ echo 'active'; }?>"><a href="<?= base_url('admin/attendance') ?>"><i class="fas fa-arrow-right"></i> Check In/Out</a></li>
          <li class="<?php if($page=='view-attendance'){ echo 'active'; }?>"><a href="<?= base_url('admin/view-attendance') ?>"><i class="fas fa-arrow-right"></i> View</a></li>
        </ul>
      </li>

    
    <li class="<?php if($page=='manage-customer-progress'){ echo 'active'; }?>"><a href="<?= base_url('admin/customer-progress') ?>"><i class="fas fa-tasks"></i> <span>Manage Customer Progress</span></a></li>
    <li class="<?php if($page=='member-status'){ echo 'active'; }?>"><a href="<?= base_url('admin/member-status') ?>"><i class="fas fa-eye"></i> <span>Member's Status</span></a></li>
    <li class="<?php if($page=='payment'){ echo 'active'; }?>"><a href="<?= base_url('admin/payment') ?>"><i class="fas fa-hand-holding-usd"></i> <span>Payments</span></a></li>
    <li class="<?php if($page=='announcement'){ echo 'active'; }?>"><a href="<?= base_url('admin/announcement') ?>"><i class="fas fa-bullhorn"></i> <span>Announcement</span></a></li>
    <li class="<?php if($page=='staff-management'){ echo 'active'; }?>"><a href="<?= base_url('admin/staffs') ?>"><i class="fas fa-briefcase"></i> <span>Staff Management</span></a></li>
    <li class="submenu"> <a href="#"><i class="fas fa-file"></i> <span>Reports</span></a>
    <ul>
        <li class="<?php if($page=='chart'){ echo 'active'; }?>"><a href="<?= base_url('admin/reports') ?>"><i class="fas fa-arrow-right"></i> Chart Representation</a></li>
        <li class="<?php if($page=='member-repo'){ echo 'active'; }?>"><a href="<?= base_url('admin/members-report') ?>"><i class="fas fa-arrow-right"></i> Members Report</a></li>
        <li class="<?php if($page=='c-p-r'){ echo 'active'; }?>"><a href="<?= base_url('admin/progress-report') ?>"><i class="fas fa-arrow-right"></i> Customer Progress Report</a></li>
      </ul>
    </li>

     
   
    <!-- Visit codeastro.com for more projects -->
  </ul>
</div>

