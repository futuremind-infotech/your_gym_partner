<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Update Customer's Progress<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h2 class="page-title">Update Customer's Progress</h2>
    <div class="breadcrumb">
        <a href="<?= base_url('admin') ?>">Home</a> / <a href="<?= base_url('admin/progress-report') ?>">Progress Reports</a> / Update Progress
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-signal"></i> Select Member to Update Progress</h3>
    </div>
    <div class="card-body">
        <?php if (!empty($members) && count($members) > 0): ?>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th>Member Name</th>
                        <th>Service</th>
                        <th>Plan</th>
                        <th>Status</th>
                        <th style="width: 15%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $cnt = 1;
                    foreach($members as $row): 
                    ?>
                    <tr>
                        <td class="text-center"><?= $cnt ?></td>
                        <td><?= esc($row['fullname']) ?></td>
                        <td class="text-center"><?= esc($row['services']) ?></td>
                        <td class="text-center"><?= $row['plan'] ?> Month(s)</td>
                        <td class="text-center">
                            <span class="badge badge-<?= $row['status'] == 'Active' ? 'success' : 'danger' ?>">
                                <?= $row['status'] ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="<?= site_url('admin/update-progress?id=' . $row['user_id']) ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Update
                            </a>
                        </td>
                    </tr>
                    <?php 
                    $cnt++;
                    endforeach; 
                    ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> No members found in the system.
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>

