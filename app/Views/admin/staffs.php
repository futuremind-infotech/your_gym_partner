<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Staff Members<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h2 class="page-title">Staff Management</h2>
    <div class="breadcrumb">
        <a href="<?= base_url('admin') ?>">Home</a> / Staff Members
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-briefcase"></i> Staff List</h3>
        <a href="<?= site_url('admin/staffs-entry') ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Add Staff Member
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
                        <th>Designation</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $db = \Config\Database::connect();
                $query = $db->query("SELECT * FROM staffs");
                $staffs = $query->getResultArray();
                $cnt = 1;
                
                foreach($staffs as $row):
                ?>
                    <tr>
                        <td class="text-center"><strong><?= $cnt++ ?></strong></td>
                        <td><?= esc($row['fullname']) ?></td>
                        <td><span class="badge badge-info">@<?= esc($row['username']) ?></span></td>
                        <td><?= esc($row['gender']) ?></td>
                        <td><span class="badge badge-warning"><?= esc($row['designation']) ?></span></td>
                        <td><?= esc($row['email']) ?></td>
                        <td><?= esc($row['address']) ?></td>
                        <td><?= esc($row['contact']) ?></td>
                        <td>
                            <div class="table-actions">
                                <a href="<?= site_url('admin/edit-staff-form?id=' . $row['user_id']) ?>" 
                                   class="btn btn-sm btn-icon" style="background: var(--warning); color: #fff;" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= site_url('admin/remove-staff?id=' . $row['user_id']) ?>" 
                                   class="btn btn-sm btn-icon" style="background: var(--danger); color: #fff;" 
                                   title="Remove" onclick="return confirm('Are you sure you want to remove this staff member?');">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                
                <?php if(empty($staffs)): ?>
                    <tr>
                        <td colspan="9" class="text-center">No staff members found.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

