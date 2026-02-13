<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Progress Search Results<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
// Get search query from POST
$searchQuery = '';
if ($this->request->getMethod() === 'post') {
    $searchQuery = trim($this->request->getPost('search') ?? '');
}

$db = \Config\Database::connect();
$members = [];

// Search members by fullname
if (!empty($searchQuery)) {
    $members = $db->table('members')
        ->like('fullname', $searchQuery)
        ->orderBy('fullname', 'ASC')
        ->get()
        ->getResultArray();
}
?>

<div class="page-header">
    <h2 class="page-title">Update Customer's Progress</h2>
    <div class="breadcrumb">
        <a href="<?= base_url('admin') ?>">Home</a> / <a href="<?= base_url('admin/customer-progress') ?>">Progress</a> / Search Results
    </div>
</div>

<?php if (empty($searchQuery)): ?>
    <div class="alert alert-info">
        <p>Please enter a search term to find members.</p>
    </div>
<?php elseif (empty($members)): ?>
    <div class="alert alert-warning" style="text-align: center; padding: 40px;">
        <h3 style="color: #d9534f;">No Results Found</h3>
        <p>It seems there's no such record available in our database.</p>
        <a class="btn btn-danger" href="<?= base_url('admin/customer-progress') ?>">Go Back</a>
    </div>
<?php else: ?>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-search"></i> Search Results</h3>
        </div>
        
        <div class="card-body" style="padding: 0;">
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Fullname</th>
                            <th>Chosen Service</th>
                            <th>Plan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $cnt = 1;
                    foreach ($members as $row):
                    ?>
                        <tr>
                            <td class="text-center"><strong><?= $cnt++ ?></strong></td>
                            <td><?= esc($row['fullname']) ?></td>
                            <td><?= esc($row['services']) ?></td>
                            <td><?= esc($row['plan']) ?> Month(s)</td>
                            <td>
                                <a href="<?= site_url('admin/update-progress?id=' . $row['user_id']) ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Update Progress
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>