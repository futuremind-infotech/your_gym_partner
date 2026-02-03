<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code - <?= $member['fullname'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <div class="alert alert-success">
                <h2><i class="fas fa-qrcode"></i> Member QR Ready!</h2>
            </div>
            
            <!-- LIVE QR - No file needed! -->
            <img src="<?= $qr_url ?>" class="img-fluid rounded shadow mb-4 p-3 border" 
                 style="max-width: 400px; background: white;" alt="Scan Me">
            
            <div class="card shadow">
                <div class="card-body">
                    <h5><i class="fas fa-user"></i> <?= $member['fullname'] ?></h5>
                    <p><strong>ID:</strong> <?= $member_id ?></p>
                    <p><strong>@</strong><?= $member['username'] ?></p>
                    <p class="small text-muted mb-0">Scans to: <?= substr($qr_data, 0, 50) ?>...</p>
                </div>
            </div>
            
            <div class="mt-4">
                <div class="row">
                    <div class="col">
                        <button onclick="downloadQR()" class="btn btn-success w-100 mb-2">
                            <i class="fas fa-download"></i> Save QR
                        </button>
                    </div>
                    <div class="col">
                        <button onclick="window.print()" class="btn btn-primary w-100 mb-2">
                            <i class="fas fa-print"></i> Print Card
                        </button>
                    </div>
                </div>
                <a href="<?= site_url('admin/members') ?>" class="btn btn-outline-secondary w-100">
                    <i class="fas fa-users"></i> More Members
                </a>
            </div>
        </div>
    </div>
</div>

<script>
// Right-click OR button to download
function downloadQR() {
    const link = document.createElement('a');
    link.href = '<?= $qr_url ?>';
    link.download = 'qr_member_<?= $member_id ?>.png';
    link.click();
}
</script>

<style>
@media print {
    .btn, .card { display: none !important; }
    img { max-width: 100% !important; margin: 20px 0; }
    .alert-success { background: white !important; border: none !important; }
}
</style>
</body>
</html>
