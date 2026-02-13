<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: text/html; charset=utf-8');

require 'vendor/autoload.php';

$db = \Config\Database::connect();

echo "<!DOCTYPE html>
<html>
<head>
    <title>Database Check</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        table { border-collapse: collapse; width: 100%; }
        table td, table th { border: 1px solid #ddd; padding: 10px; }
        table th { background: #1f4e78; color: white; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
<h1>Database Member Check</h1>";

// Check if members table exists
$tables = $db->query("SHOW TABLES LIKE 'members'")->getResultArray();

if (empty($tables)) {
    echo "<p class='error'>❌ Members table not found!</p>";
} else {
    echo "<p class='success'>✓ Members table exists</p>";
    
    // Get all members
    $members = $db->query("SELECT user_id, fullname, email, reminder FROM members")->getResultArray();
    
    echo "<p><strong>Total members: " . count($members) . "</strong></p>";
    
    if (empty($members)) {
        echo "<p class='error'>❌ No members in database!</p>";
    } else {
        echo "<table>";
        echo "<tr>";
        echo "<th>user_id</th>";
        echo "<th>Type</th>";
        echo "<th>Full Name</th>";
        echo "<th>Email</th>";
        echo "<th>Reminder</th>";
        echo "</tr>";
        
        foreach ($members as $member) {
            $idType = gettype($member['user_id']);
            $idValue = var_export($member['user_id'], true);
            $isValid = !empty($member['user_id']) && intval($member['user_id']) > 0;
            
            echo "<tr>";
            echo "<td>" . htmlspecialchars($idValue) . "</td>";
            echo "<td>" . $idType . "</td>";
            echo "<td>" . htmlspecialchars($member['fullname']) . "</td>";
            echo "<td>" . htmlspecialchars($member['email'] ?? 'N/A') . "</td>";
            echo "<td>" . $member['reminder'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
}

// Check config
echo "<h2>CodeIgniter Configuration</h2>";
echo "<p><strong>base_url():</strong> " . htmlspecialchars(base_url()) . "</p>";
echo "<p><strong>site_url():</strong> " . htmlspecialchars(site_url()) . "</p>";
echo "<p><strong>site_url('admin/sendReminder'):</strong> " . htmlspecialchars(site_url('admin/sendReminder')) . "</p>";
echo "<p><strong>site_url('admin/sendReminder?id=1'):</strong> " . htmlspecialchars(site_url('admin/sendReminder?id=1')) . "</p>";

echo "</body></html>";
?>
