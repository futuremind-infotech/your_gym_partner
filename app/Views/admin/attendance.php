<?php
if (!session()->get('isLoggedIn')) {
    return redirect()->to(site_url('admin'));
}

$db = \Config\Database::connect();
date_default_timezone_set('Asia/Kathmandu');
$current_date = date('Y-m-d h:i A');
$exp_date_time = explode(' ', $current_date);
$todays_date = $exp_date_time[0];

$members = $db->table('members')->where('status', 'Active')->get()->getResultArray();
$cnt = 1;
?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb">
            <a href="<?= site_url('admin') ?>" title="Go to Home" class="tip-bottom"><i class="fas fa-home"></i> Home</a> 
            <a href="<?= site_url('admin/attendance') ?>" class="current">Manage Attendance</a>
        </div>
        <h1 class="text-center">Attendance List <i class="fas fa-calendar"></i></h1>
    </div>
    
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class='widget-box'>
                    <div class='widget-title'>
                        <span class='icon'><i class='fas fa-th'></i></span>
                        <h5>Attendance Table</h5>
                    </div>
                    <div class='widget-content nopadding'>
                        <table class='table table-bordered table-hover'>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Fullname</th>
                                    <th>Contact Number</th>
                                    <th>Chosen Service</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if(count($members) > 0) {
                                    foreach($members as $row) { 
                                        $attendance = $db->table('attendance')->where('curr_date', $todays_date)->where('user_id', $row['user_id'])->get()->getRowArray();
                                        $row_exist = !empty($attendance);
                                ?>
                                    <tr>
                                        <td><div class='text-center'><?php echo $cnt; ?></div></td>
                                        <td><div class='text-center'><?php echo htmlspecialchars($row['fullname']); ?></div></td>
                                        <td><div class='text-center'><?php echo htmlspecialchars($row['contact']); ?></div></td>
                                        <td><div class='text-center'><?php echo htmlspecialchars($row['services']); ?></div></td>
                                        <td>
                                            <?php if($row_exist) { ?>
                                                <div class='text-center'>
                                                    <span class="label label-inverse">
                                                        <?php echo htmlspecialchars($attendance['curr_date']); ?> 
                                                        <?php echo htmlspecialchars($attendance['curr_time']); ?>
                                                    </span>
                                                </div>
                                                <div class='text-center'>
                                                    <a href='<?= site_url("admin/delete-attendance?id=" . $row['user_id']) ?>'>
                                                        <button class='btn btn-danger btn-mini'>Check Out <i class='fas fa-clock'></i></button>
                                                    </a>
                                                </div>
                                            <?php } else { ?>
                                                <div class='text-center'>
                                                    <a href='<?= site_url("admin/check-attendance?id=" . $row['user_id']) ?>'>
                                                        <button class='btn btn-info btn-mini'>Check In <i class='fas fa-map-marker-alt'></i></button>
                                                    </a>
                                                </div>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php 
                                        $cnt++;
                                    }
                                } else {
                                ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No active members found.</td>
                                    </tr>
                                <?php 
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<style>
.table th, .table td { vertical-align: middle; }
.btn-mini { padding: 2px 8px; font-size: 12px; }
</style>

