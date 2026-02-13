<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: text/html; charset=utf-8');

echo "<!DOCTYPE html>
<html>
<head>
    <title>Email Logs Viewer</title>
    <style>
        body { font-family: monospace; margin: 20px; background: #1e1e1e; color: #d4d4d4; }
        .container { max-width: 1000px; margin: 0 auto; }
        pre { background: #252526; padding: 15px; border-radius: 5px; overflow-x: auto; }
        .file-list { background: #252526; padding: 10px; border-radius: 5px; margin: 20px 0; }
        .file-list a { color: #569cd6; text-decoration: none; display: block; padding: 5px; }
        .file-list a:hover { background: #3e3e42; }
        h1 { color: #4fc1ff; }
        h2 { color: #4ec9b0; margin-top: 20px; }
    </style>
</head>
<body>
<div class='container'>
    <h1>📋 Email & System Logs</h1>";

$logDir = WRITEPATH . 'logs';

if (!is_dir($logDir)) {
    echo "<p>Logs directory not found</p>";
    exit;
}

// Get today's log file
$todayLog = $logDir . '/log-' . date('Y-m-d') . '.log';

echo "<h2>Today's Logs (" . date('Y-m-d') . ")</h2>";

if (file_exists($todayLog)) {
    $content = file_get_contents($todayLog);
    
    // Extract email-related lines
    $lines = explode("\n", $content);
    $emailLines = [];
    
    foreach ($lines as $line) {
        if (stripos($line, 'email') !== false || 
            stripos($line, 'reminder') !== false ||
            stripos($line, 'mail') !== false ||
            stripos($line, 'smtp') !== false) {
            $emailLines[] = $line;
        }
    }
    
    if (!empty($emailLines)) {
        echo "<h3>📧 Email-Related Entries</h3>";
        echo "<pre>";
        foreach ($emailLines as $line) {
            echo htmlspecialchars($line) . "\n";
        }
        echo "</pre>";
    } else {
        echo "<p style='color: #999;'>No email-related log entries found</p>";
    }
    
    echo "<h3>📄 Last 50 Log Lines</h3>";
    echo "<pre>";
    $lastLines = array_slice($lines, -50);
    foreach ($lastLines as $line) {
        if (trim($line)) {
            echo htmlspecialchars($line) . "\n";
        }
    }
    echo "</pre>";
} else {
    echo "<p>No logs for today</p>";
}

echo "<h2>📁 Available Log Files</h2>";
echo "<div class='file-list'>";

$logFiles = glob($logDir . '/*.log');
rsort($logFiles);

foreach ($logFiles as $file) {
    $filename = basename($file);
    $size = filesize($file);
    $modified = date('Y-m-d H:i:s', filemtime($file));
    echo "<a href='?file=" . urlencode($filename) . "'>";
    echo $filename . " (" . round($size / 1024, 2) . " KB, Modified: " . $modified . ")";
    echo "</a>";
}

echo "</div>";

// If a specific file is requested
if (isset($_GET['file'])) {
    $filename = basename($_GET['file']);
    $filepath = $logDir . '/' . $filename;
    
    if (file_exists($filepath) && strpos($filepath, $logDir) === 0) {
        echo "<h2>File: " . htmlspecialchars($filename) . "</h2>";
        echo "<pre>";
        echo htmlspecialchars(file_get_contents($filepath));
        echo "</pre>";
    }
}

echo "</div>
</body>
</html>";
?>
