<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Manage Announcements<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h2 class="page-title">Manage Announcements</h2>
    <div class="breadcrumb">
        <a href="<?= base_url('admin') ?>">Home</a> / Announcement / Manage
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-bullhorn"></i> Announcement List</h3>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Message</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $db = \Config\Database::connect();
                $query = $db->query("SELECT * FROM announcements");
                $announcements = $query->getResultArray();
                $cnt = 1;
                
                foreach($announcements as $row):
                ?>
                    <tr>
                        <td class="text-center"><strong><?= $cnt++ ?></strong></td>
                        <td><?= date('M d, Y', strtotime($row['date'])) ?></td>
                        <td><?= esc($row['message']) ?></td>
                        <td class="text-center">
                            <a href="<?= site_url('admin/remove-announcement?id=' . $row['id']) ?>" 
                               class="btn btn-sm btn-icon" style="background: var(--danger); color: #fff;" 
                               title="Remove" onclick="return confirm('Are you sure you want to remove this announcement?');">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                
                <?php if(empty($announcements)): ?>
                    <tr>
                        <td colspan="4" class="text-center">No announcements found.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

