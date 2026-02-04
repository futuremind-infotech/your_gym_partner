<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Scanner - Gym Attendance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .scanner-container { max-width: 500px; margin: 0 auto; }
        #reader { width: 100%; height: 400px; border-radius: 20px; }
        .scan-result { display: none; padding: 30px; border-radius: 20px; margin-top: 20px; }
        .success { background: linear-gradient(135deg, #56ab2f, #a8e6cf); }
        .error { background: linear-gradient(135deg, #ff416c, #ff4b2b); }
        .floating-stats { position: fixed; top: 20px; right: 20px; background: rgba(255,255,255,0.95); padding: 15px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
        #debug { position: fixed; bottom: 20px; left: 20px; background: rgba(0,0,0,0.9); color: lime; padding: 15px; border-radius: 10px; font-size: 14px; max-width: 350px; font-family: monospace; }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="scanner-container">
            <div class="text-center mb-5">
                <div class="floating-stats">
                    <h6><i class="fas fa-clock text-success"></i> <span id="time"></span></h6>
                    <h6><i class="fas fa-calendar text-primary"></i> <span id="date"></span></h6>
                    <h6><i class="fas fa-check text-success"></i> Scans: <span id="scan-count">0</span></h6>
                </div>
                <h1 class="text-white mb-4"><i class="fas fa-qrcode fa-2x"></i> QR Scanner</h1>
                <p class="text-white-50 lead">Point at member QR → Attendance AUTO!</p>
            </div>

            <div class="card shadow-lg" style="border-radius: 25px;">
                <div class="card-body p-4">
                    <div id="reader-container"><div id="reader"></div></div>

                    <div id="success" class="scan-result success text-center text-white">
                        <i class="fas fa-check-circle fa-4x mb-3"></i>
                        <h2>✅ Attendance Marked!</h2>
                        <h4 id="success-msg"></h4>
                        <p id="success-details" class="lead mb-4"></p>
                        <button onclick="startScanner()" class="btn btn-light btn-lg px-5">
                            <i class="fas fa-camera"></i> Next Member
                        </button>
                    </div>

                    <div id="error" class="scan-result error text-center text-white" style="display:none;">
                        <i class="fas fa-exclamation-triangle fa-4x mb-3"></i>
                        <h2 id="error-title"></h2>
                        <p id="error-msg" class="lead mb-4"></p>
                        <button onclick="startScanner()" class="btn btn-light btn-lg px-5">
                            <i class="fas fa-redo"></i> Try Again
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="debug">🔍 Ready to scan...</div>

    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <script>
    let scanner;
    let scanCount = 0;

    // Live clock
    setInterval(() => {
        const now = new Date();
        document.getElementById('time').textContent = now.toLocaleTimeString('en-IN');
        document.getElementById('date').textContent = now.toLocaleDateString('en-IN');
    }, 1000);

    function updateDebug(msg) {
        document.getElementById('debug').textContent = msg;
        console.log(msg);
    }

    function startScanner() {
        updateDebug('📷 Starting camera...');
        document.getElementById('success').style.display = 'none';
        document.getElementById('error').style.display = 'none';
        
        document.getElementById('reader-container').innerHTML = '<div id="reader"></div>';
        scanner = new Html5Qrcode("reader");
        
        scanner.start(
            { facingMode: "environment" },
            { fps: 10, qrbox: 300 },
            onScanSuccess,
            () => {}
        ).catch(() => updateDebug('❌ Camera access denied'));
        updateDebug('✅ Point QR at camera');
    }

    // 🔥 PERFECT QR PARSING - WORKS ANYWHERE!
    function onScanSuccess(decodedText) {
        console.log('📱 QR SCANNED:', decodedText);
        scanner.stop();
        updateDebug('🔍 Extracting member ID...');
        
        // Extract user_id from ANY format
        let user_id = null;
        const match = decodedText.match(/user_id[=:]\s*(\d+)/i);
        if (match) {
            user_id = match[1];
        }
        
        updateDebug(`🎯 Found ID: ${user_id || 'NONE'}`);
        
        if (user_id && !isNaN(user_id)) {
            markAttendance(user_id);
        } else {
            showError('❌ Invalid QR', `No member ID in QR: "${decodedText.substring(0,30)}..."`);
        }
    }

    // 🔥 DIRECT ATTENDANCE - NO NETWORK REQUIRED!
    function markAttendance(user_id) {
        updateDebug(`📤 Marking ID ${user_id}...`);
        
        fetch('<?= site_url("admin/mark-qr-attendance") ?>', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `user_id=${user_id}`
        })
        .then(res => res.json())
        .then(data => {
            scanCount++;
            document.getElementById('scan-count').textContent = scanCount;
            
            if (data.success) {
                showSuccess(data.message, `ID: ${user_id} | ${data.time}`);
                updateDebug('✅ Attendance saved!');
            } else {
                showError('⚠️ Already Present', data.message);
            }
        })
        .catch(err => {
            showError('🌐 Connection Error', 'Check internet & server');
            updateDebug('❌ Network failed');
        });
    }

    function showSuccess(msg, details) {
        document.getElementById('success-msg').textContent = msg;
        document.getElementById('success-details').textContent = details;
        document.getElementById('success').style.display = 'block';
    }

    function showError(title, msg) {
        document.getElementById('error-title').textContent = title;
        document.getElementById('error-msg').textContent = msg;
        document.getElementById('error').style.display = 'block';
    }

    // Auto start
    window.onload = () => setTimeout(startScanner, 1000);
    </script>
</body>
</html>
