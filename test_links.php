<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: text/html; charset=utf-8');

require 'vendor/autoload.php';

$db = \Config\Database::connect();

echo "<!DOCTYPE html>
<html>
<head>
    <title>Payment Page Link Debug</title>
    <style>
        body { font-family: monospace; margin: 20px; background: #1e1e1e; color: #d4d4d4; }
        .container { max-width: 1000px; }
        pre { background: #252526; padding: 15px; border-radius: 5px; overflow-x: auto; }
        .success { color: #4ec9b0; }
        .error { color: #f48771; }
        h2 { color: #4fc1ff; }
    </style>
</head>
<body>
<div class='container'>
    <h1>🔗 Payment Page Link Debug</h1>";

$members = $db->query("SELECT user_id, fullname, email, reminder FROM members LIMIT 3")->getResultArray();

echo "<h2>Generated HTML Links:</h2>";
echo "<pre>";

foreach ($members as $row) {
    $url = site_url('admin/sendReminder?id=' . intval($row['user_id']));
    
    echo "Member: " . htmlspecialchars($row['fullname']) . "\n";
    echo "  user_id value: " . var_export($row['user_id'], true) . "\n";
    echo "  Generated URL: " . htmlspecialchars($url) . "\n";
    
    $html = "<a href='" . site_url('admin/sendReminder?id=' . intval($row['user_id'])) . "' class='btn btn-sm btn-danger'>";
    echo "  HTML: " . htmlspecialchars($html) . "\n";
    echo "\n";
}

echo "</pre>";

echo "<h2>Test Links (Click These):</h2>";
foreach ($members as $row) {
    $url = site_url('admin/sendReminder?id=' . intval($row['user_id']));
    echo "<p>";
    echo "<strong>" . htmlspecialchars($row['fullname']) . "</strong> (ID: " . intval($row['user_id']) . ") | ";
    echo "<a href='" . htmlspecialchars($url) . "'><span class='success'>→ Send Reminder</span></a>";
    echo "</p>";
}

echo "<h2>Direct URL Test:</h2>";
echo "<p>Try accessing directly with a specific ID:</p>";
foreach ($members as $row) {
    $id = intval($row['user_id']);
    $url = base_url('admin/sendReminder?id=' . $id);
    echo "<p><a href='" . htmlspecialchars($url) . "'>" . htmlspecialchars($row['fullname']) . " (ID: $id)</a></p>";
}

echo "</div>
</body>
</html>";
?>
