<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: text/html; charset=utf-8');

require 'vendor/autoload.php';

$db = \Config\Database::connect();

echo "<!DOCTYPE html>
<html>
<head>
    <title>Send Reminder - New URL Structure Test</title>
    <style>
        body { font-family: Arial; margin: 20px; background: #f5f5f5; }
        .container { max-width: 900px; margin: 0 auto; background: white; padding: 20px; border-radius: 5px; }
        h1 { color: #1f4e78; }
        .member-link { background: #d4edda; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #28a745; }
        .member-link a { color: #0056b3; text-decoration: none; font-size: 16px; font-weight: bold; }
        .member-link a:hover { text-decoration: underline; }
        .info { background: #e7f3ff; padding: 10px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #2196F3; }
        code { background: #f0f0f0; padding: 2px 5px; border-radius: 3px; }
    </style>
</head>
<body>
<div class='container'>
    <h1>✅ New Alert Button Links (URL Segment Format)</h1>
    
    <div class='info'>
        <strong>New Format:</strong> <code>/admin/sendReminder/{member_id}</code><br>
        Instead of: <code>/admin/sendReminder?id={member_id}</code>
    </div>";

$members = $db->query("SELECT user_id, fullname, email FROM members ORDER BY user_id DESC LIMIT 10")->getResultArray();

if (empty($members)) {
    echo "<p style='color: red;'>❌ No members found</p>";
} else {
    echo "<p><strong>Click any member link to test the new send reminder page:</strong></p>";
    
    foreach ($members as $member) {
        $id = intval($member['user_id']);
        $url = site_url('admin/sendReminder/' . $id);
        $email = !empty($member['email']) ? htmlspecialchars($member['email']) : '<span style="color:red;">NO EMAIL</span>';
        
        echo "<div class='member-link'>";
        echo "<a href='" . htmlspecialchars($url) . "'>";
        echo "📧 " . htmlspecialchars($member['fullname']) . " (ID: " . $id . ") - " . $email;
        echo "</a>";
        echo "</div>";
    }
}

echo "</div>
</body>
</html>";
?>
