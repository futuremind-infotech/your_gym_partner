<?php
// Direct database test - NO authentication needed

require_once __DIR__ . '/vendor/autoload.php';

// Load CodeIgniter config
$config = new \Config\Database();
$db = $config->connect();

echo "=== MEMBER DATABASE DIAGNOSTIC ===\n\n";

// Test 1: Count total members
echo "1. Total members in database:\n";
$count = $db->table('members')->countAll();
echo "   Count: $count\n\n";

// Test 2: List all member IDs
echo "2. All member IDs:\n";
$ids = $db->table('members')->select('user_id, fullname')->orderBy('user_id')->get()->getResultArray();
if ($ids) {
    foreach ($ids as $row) {
        echo "   - ID: " . $row['user_id'] . " | Name: " . $row['fullname'] . "\n";
    }
} else {
    echo "   NO MEMBERS FOUND!\n";
}
echo "\n";

// Test 3: Try querying member ID 6
echo "3. Testing query for member ID 6:\n";
$member = $db->table('members')->where('user_id', 6)->limit(1)->get()->getRowArray();
if ($member) {
    echo "   SUCCESS! Member found:\n";
    echo "   - user_id: " . $member['user_id'] . "\n";
    echo "   - fullname: " . $member['fullname'] . "\n";
    echo "   - username: " . $member['username'] . "\n";
} else {
    echo "   FAILED! Member ID 6 not found\n";
}
echo "\n";

// Test 4: Test with intval casting
echo "4. Testing with intval(6):\n";
$member2 = $db->table('members')->where('user_id', intval(6))->limit(1)->get()->getRowArray();
if ($member2) {
    echo "   SUCCESS! Found with intval\n";
} else {
    echo "   FAILED! Not found with intval\n";
}
echo "\n";

// Test 5: Show database connection details
echo "5. Database Connection Info:\n";
echo "   Host: " . $db->hostname . "\n";
echo "   Database: " . $db->database . "\n";
echo "   Driver: " . $db->DBDriver . "\n";

?>
