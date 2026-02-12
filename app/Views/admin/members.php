<?php
// CodeIgniter 4 session check
if (!session()->get('isLoggedIn')) {
    return redirect()->to('/'); 
}
?>

<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Registered Members<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h2 class="page-title">Registered Members List</h2>
    <div class="breadcrumb">
        <a href="<?= site_url('admin') ?>">Home</a> / Registered Members
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<?php
// ALL DATABASE QUERIES AT TOP - NO ERRORS!
$db = \Config\Database::connect();
$countQry = "SELECT COUNT(*) as total FROM members";
$countResult = $db->query($countQry);
$totalMembers = $countResult->getRow()->total ?? 0;

$qry = "SELECT * FROM members ORDER BY dor DESC";
$result = $db->query($qry);
$members = $result->getResultArray();
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-users"></i> Member Table
            <span class="badge badge-success" style="margin-left: 10px;"><?= $totalMembers ?> Members</span>
        </h3>
        <a href="<?= site_url('admin/member-entry') ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Add New Member
        </a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fullname</th>
                        <th>Username</th>
                        <th>Gender</th>
                        <th>Contact</th>
                        <th>D.O.R</th>
                        <th>Address</th>
                        <th>Amount</th>
                        <th>Service</th>
                        <th>Plan</th>
                        <th>Attendance</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($members && count($members) > 0): ?>
                        <?php $cnt = 1; foreach ($members as $row): ?>
                        <tr>
                            <td class="text-center"><strong><?= $cnt++ ?></strong></td>
                            <td><?= esc($row['fullname']) ?></td>
                            <td><span class="badge badge-info">@<?= esc($row['username']) ?></span></td>
                            <td>
                                <span class="badge badge-<?= $row['gender']=='Male' ? 'primary' : 'danger' ?>">
                                    <?= esc($row['gender']) ?>
                                </span>
                            </td>
                            <td><?= esc($row['contact']) ?></td>
                            <td><?= date('M d, Y', strtotime($row['dor'])) ?></td>
                            <td><?= substr(esc($row['address']), 0, 20) ?>...</td>
                            <td><strong>₹<?= number_format($row['amount'], 2) ?></strong></td>
                            <td><span class="badge badge-success"><?= esc($row['services']) ?></span></td>
                            <td><?= esc($row['plan']) ?> Month<?= $row['plan'] > 1 ? 's' : '' ?></td>
                            <td>
                                <span class="badge badge-<?= $row['attendance_count'] > 10 ? 'success' : 'warning' ?>">
                                    <?= $row['attendance_count'] ?> visits
                                </span>
                            </td>
                            
                            <!-- ACTIONS -->
                            <td class="text-center">
                                <div class="table-actions">
                                    <a href="<?= site_url('admin/edit-member?id=' . $row['user_id']) ?>" 
                                       class="btn btn-sm btn-icon" style="background: var(--warning); color: #fff;" title="Edit Member">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <a href="<?= site_url('admin/remove-member?id=' . $row['user_id']) ?>" 
                                       class="btn btn-sm btn-icon" style="background: var(--danger); color: #fff;"
                                       onclick="return confirm('Delete <?= esc($row['fullname']) ?>? This cannot be undone!')"
                                       title="Delete Member">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    
                                    <a href="<?= site_url('admin/generate-qr/' . $row['user_id']) ?>" 
                                       class="btn btn-sm btn-icon" style="background: var(--success); color: #fff;" target="_blank" title="Generate QR Code">
                                        <i class="fas fa-qrcode"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="12" class="text-center">
                                <div class="alert alert-info">
                                    <h4><i class="fas fa-users"></i> No Members Yet</h4>
                                    <p>Add your first member to get started — use the "Add New Member" button above.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- FLOATING QR SCANNER BUTTON -->
<div style="position:fixed; bottom:30px; right:30px; z-index:9999;">
  <a href="<?= site_url('admin/qr-scanner') ?>" class="btn btn-success" style="border-radius:50%; width:60px; height:60px; box-shadow: var(--shadow-lg); display:flex; align-items:center; justify-content:center;">
    <i class="fas fa-qrcode fa-2x"></i>
  </a>
</div>

<?= $this->endSection() ?>
