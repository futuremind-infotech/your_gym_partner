<?php
/**
 * TEST SCRIPT - Add a member directly to database
 * This script bypasses the web form to quickly test member addition
 */

require_once 'app/Config/Database.php';

$db = \Config\Database::connect();

// Test member data
$testData = [
    'fullname' => 'John Doe',
    'username' => 'johndoe',
    'password' => md5('password123'),
    'dor' => date('Y-m-d'),
    'gender' => 'Male',
    'services' => 'Fitness',
    'amount' => 55,
    'p_year' => date('Y'),
    'paid_date' => date('Y-m-d'),
    'plan' => 1,
    'address' => '123 Main Street',
    'contact' => '9876543210',
    'attendance_count' => 0,
    'last_attendance' => null
];

try {
    $result = $db->table('members')->insert($testData);
    $insertedId = $db->insertID();
    
    echo json_encode([
        'status' => 'success',
        'message' => 'Member added successfully!',
        'member_id' => $insertedId,
        'member_data' => $testData
    ], JSON_PRETTY_PRINT);
    
} catch (\Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to add member',
        'error' => $e->getMessage()
    ], JSON_PRETTY_PRINT);
}
?>
