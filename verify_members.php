<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: text/html; charset=utf-8');

require 'vendor/autoload.php';

$db = \Config\Database::connect();

echo "<!DOCTYPE html>
<html>
<head>
    <title>Member Data Verification</title>
    <style>
        body { font-family: Arial; margin: 20px; background: #f5f5f5; }
        table { border-collapse: collapse; width: 100%; background: white; }
        table td, table th { border: 1px solid #ddd; padding: 10px; text-align: left; }
        table th { background: #1f4e78; color: white; }
        table tr:nth-child(odd) { background: #fafafa; }
        .error { color: red; }
        .success { color: green; }
        .container { max-width: 1000px; margin: 0 auto; }
    </style>
</head>
<body>
<div class='container'>
    <h1>👥 Member Data Verification</h1>";

$members = $db->query("SELECT user_id, fullname, email, reminder FROM members ORDER BY user_id DESC")->getResultArray();

if (empty($members)) {
    echo "<p class='error'>❌ No members found in database</p>";
} else {
    echo "<h2>Members (" . count($members) . " total)</h2>";
    echo "<table>";
    echo "<tr>";
    echo "<th>User ID</th>";
    echo "<th>Full Name</th>";
    echo "<th>Email</th>";
    echo "<th>Reminder Sent</th>";
    echo "<th>Action Link</th>";
    echo "</tr>";
    
    foreach ($members as $member) {
        $hasBadId = empty($member['user_id']) || $member['user_id'] <= 0;
        $hasBadEmail = empty($member['email']);
        $canSend = !$hasBadId && !$hasBadEmail && $member['reminder'] == 0;
        
        echo "<tr>";
        echo "<td" . ($hasBadId ? " class='error'" : "") . ">" . ($hasBadId ? "❌ " : "") . htmlspecialchars($member['user_id']) . "</td>";
        echo "<td>" . htmlspecialchars($member['fullname']) . "</td>";
        echo "<td" . ($hasBadEmail ? " class='error'" : "") . ">" . ($hasBadEmail ? "❌ MISSING" : htmlspecialchars($member['email'])) . "</td>";
        echo "<td>" . ($member['reminder'] == 1 ? "✓ Yes" : "No") . "</td>";
        echo "<td>";
        
        if ($hasBadId) {
            echo "<span class='error'>Invalid ID</span>";
        } else if ($hasBadEmail) {
            echo "<span class='error'>No Email</span>";
        } else if ($member['reminder'] == 1) {
            echo "<span class='success'>Already Sent</span>";
        } else {
            $link = site_url('admin/sendReminder?id=' . intval($member['user_id']));
            echo "<a href='" . htmlspecialchars($link) . "' style='color: #0066cc;'>Send Reminder →</a>";
        }
        
        echo "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
}

echo "</div>
</body>
</html>";
?>
