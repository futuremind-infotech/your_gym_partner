<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Error - Gym Partner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <div class="alert alert-danger">
                <h2><i class="fas fa-exclamation-triangle"></i> QR Generation Error</h2>
                <p><?= isset($error) ? esc($error) : 'Invalid member or service unavailable' ?></p>
            </div>
            <a href="<?= site_url('admin/members') ?>" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Back to Members
            </a>
        </div>
    </div>
</div>
</body>
</html>
