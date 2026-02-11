<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Make Announcement<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h2 class="page-title">Make Announcements</h2>
    <div class="breadcrumb">
        <a href="<?= site_url('admin') ?>">Home</a> / Announcement / Post
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="mb-3 text-right" style="text-align: right;">
            <a href="<?= site_url('admin/manage-announcement') ?>" class="btn btn-danger">
                <i class="fas fa-tasks"></i> Manage Your Announcements
            </a>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-bullhorn"></i> Create New Announcement</h3>
            </div>
            <div class="card-body">
                <form action="<?= site_url('admin/post-announcement') ?>" method="POST">
                    
                    <div class="mb-4">
                        <label class="form-label">Announcement Message</label>
                        <textarea class="form-control" name="message" rows="6" placeholder="Enter text ..." style="width: 100%; border: 1px solid var(--gray-300); border-radius: 4px; padding: 10px;" required></textarea>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Applied Date</label>
                        <input type="date" name="date" class="form-control" style="width: 100%; border: 1px solid var(--gray-300); border-radius: 4px; padding: 10px;" required>
                    </div>
                    
                    <div class="text-center" style="margin-top: 2rem;">
                        <button type="submit" class="btn btn-primary" style="padding: 10px 30px; font-size: 1rem;">
                            <i class="fas fa-paper-plane"></i> Publish Now
                        </button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
