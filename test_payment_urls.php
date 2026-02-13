<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: text/html; charset=utf-8');

require 'vendor/autoload.php';

$db = \Config\Database::connect();

echo "<!DOCTYPE html>
<html>
<head>
    <title>Payment Page URL Generator</title>
    <style>
        body { font-family: Arial; margin: 20px; background: #f5f5f5; }
        .container { max-width: 1000px; margin: 0 auto; background: white; padding: 20px; border-radius: 5px; }
        h1 { color: #1f4e78; }
        .member-box { background: #f9f9f9; padding: 15px; margin: 10px 0; border-left: 4px solid #1f4e78; border-radius: 3px; }
        .url-test { background: #fff3cd; padding: 10px; margin: 10px 0; border-radius: 3px; font-family: monospace; }
        a { color: #0066cc; text-decoration: none; }
        a:hover { text-decoration: underline; }
        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        table td, table th { border: 1px solid #ddd; padding: 8px; text-align: left; }
        table th { background: #1f4e78; color: white; }
        .error { color: #d9534f; }
        .success { color: #5cb85c; }
    </style>
</head>
<body>
<div class='container'>
    <h1>🔍 Payment Page URL Diagnostic</h1>";

$members = $db->query("SELECT user_id, fullname, email, reminder FROM members ORDER BY user_id DESC LIMIT 5")->getResultArray();

echo "<h2>Generated URLs for First 5 Members:</h2>";

if (empty($members)) {
    echo "<p class='error'>❌ No members found in database</p>";
} else {
    echo "<table>";
    echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>URL</th><th>Test Link</th></tr>";
    
    foreach ($members as $member) {
        $id = intval($member['user_id']);
        $url = base_url('admin/sendReminder?id=' . $id);
        
        echo "<tr>";
        echo "<td>" . $id . "</td>";
        echo "<td>" . htmlspecialchars($member['fullname']) . "</td>";
        echo "<td>" . htmlspecialchars($member['email'] ?? 'None') . "</td>";
        echo "<td><code style='background: #f0f0f0; padding: 5px;'>" . htmlspecialchars($url) . "</code></td>";
        echo "<td><a href='" . htmlspecialchars($url) . "' target='_blank'>→ Open</a></td>";
        echo "</tr>";
    }
    
    echo "</table>";
}

echo "<h2>Manual URL Test:</h2>";
echo "<p>Try clicking these manually constructed URLs:</p>";

$testIds = [1, 2, 3];
foreach ($testIds as $id) {
    $testUrl = base_url('admin/sendReminder?id=' . $id);
    $member = $db->query("SELECT fullname FROM members WHERE user_id = ?", [$id])->getRowArray();
    
    if ($member) {
        echo "<p><a href='" . htmlspecialchars($testUrl) . "' target='_blank'>ID $id - " . htmlspecialchars($member['fullname']) . "</a></p>";
    } else {
        echo "<p><span class='error'>ID $id - Not found</span></p>";
    }
}

echo "<h2>URL Configuration:</h2>";
echo "<ul>";
echo "<li><strong>base_url():</strong> " . htmlspecialchars(base_url()) . "</li>";
echo "<li><strong>Environment:</strong> " . ENVIRONMENT . "</li>";
echo "<li><strong>PHP Version:</strong> " . phpversion() . "</li>";
echo "</ul>";

echo "<h2>What to Do:</h2>";
echo "<ol>";
echo "<li>Click one of the test links above</li>";
echo "<li>If you see the send reminder form, email system should be working</li>";
echo "<li>If you see 'Invalid member ID: Missing', then the ID isn't being passed</li>";
echo "<li>Check the browser's address bar to see the actual URL</li>";
echo "</ol>";

echo "</div>
</body>
</html>";
?>
