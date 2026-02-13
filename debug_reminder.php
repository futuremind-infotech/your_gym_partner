<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: text/html; charset=utf-8');

require 'vendor/autoload.php';

$db = \Config\Database::connect();

echo "<!DOCTYPE html>
<html>
<head>
    <title>Send Reminder Debug Tool</title>
    <style>
        body { font-family: Arial; margin: 20px; background: #f5f5f5; }
        .box { background: white; padding: 15px; margin: 10px 0; border-radius: 5px; }
        .success { color: green; }
        .error { color: red; }
        table { border-collapse: collapse; width: 100%; margin: 10px 0; }
        table td, table th { border: 1px solid #ddd; padding: 10px; text-align: left; }
        table th { background: #1f4e78; color: white; }
        a { color: #0066cc; text-decoration: none; padding: 5px 10px; background: #e8f0f8; border-radius: 3px; display: inline-block; margin: 5px 5px 5px 0; }
        a:hover { background: #d4e5f5; }
    </style>
</head>
<body>
<h1>🔍 Send Reminder Debug Tool</h1>";

// Get all members with valid IDs
$members = $db->query("SELECT user_id, fullname, email FROM members WHERE user_id > 0 ORDER BY user_id")->getResultArray();

echo "<div class='box'>";
echo "<h2>Members Available (" . count($members) . ")</h2>";

if (empty($members)) {
    echo "<p class='error'>❌ No members found</p>";
} else {
    echo "<p>Click on a member to open the send reminder page:</p>";
    
    foreach ($members as $member) {
        $id = intval($member['user_id']);
        $url = site_url('admin/sendReminder?id=' . $id);
        $email = !empty($member['email']) ? htmlspecialchars($member['email']) : '<span class="error">NO EMAIL</span>';
        
        echo "<div style='margin: 10px 0; padding: 10px; background: #f9f9f9; border-left: 3px solid #1f4e78;'>";
        echo "<strong>ID: $id</strong> | <strong>Name:</strong> " . htmlspecialchars($member['fullname']) . " | <strong>Email:</strong> $email";
        echo "<br>";
        echo "<a href='" . htmlspecialchars($url) . "'>📧 Send Reminder</a>";
        echo "</div>";
    }
}

echo "</div>";

// Test direct parameter passing
echo "<div class='box'>";
echo "<h2>Test Direct URL</h2>";
echo "<p>Test with custom ID:</p>";
echo "<form method='GET' style='margin: 10px 0;'>";
echo "<input type='number' name='test_id' placeholder='Enter member ID' min='1' required>";
echo "<button type='submit'>Test</button>";
echo "</form>";

if (!empty($_GET['test_id'])) {
    $testId = intval($_GET['test_id']);
    echo "<p>Testing ID: <code>$testId</code></p>";
    
    $testMember = $db->query("SELECT * FROM members WHERE user_id = ?", [$testId])->getRowArray();
    
    if ($testMember) {
        echo "<p class='success'>✓ Member found!</p>";
        echo "<pre>";
        print_r($testMember);
        echo "</pre>";
        
        $reminderUrl = site_url('admin/sendReminder?id=' . $testId);
        echo "<p><a href='" . htmlspecialchars($reminderUrl) . "'>→ Go to Send Reminder Page</a></p>";
    } else {
        echo "<p class='error'>✗ Member NOT found with ID: $testId</p>";
    }
}

echo "</div>";

// Check logs
echo "<div class='box'>";
echo "<h2>Recent Logs</h2>";
echo "<p><a href='" . base_url('view_logs.php') . "'>📋 View Full Logs</a></p>";

$logFile = WRITEPATH . 'logs/log-' . date('Y-m-d') . '.log';
if (file_exists($logFile)) {
    $lines = file($logFile);
    $lastLines = array_slice($lines, -20);
    
    echo "<p>Last 20 log entries:</p>";
    echo "<pre style='background: #f0f0f0; padding: 10px; max-height: 300px; overflow-y: auto;'>";
    foreach ($lastLines as $line) {
        echo htmlspecialchars(trim($line)) . "\n";
    }
    echo "</pre>";
} else {
    echo "<p>No logs found for today</p>";
}

echo "</div>";
echo "</body></html>";
?>
