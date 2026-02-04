<?php
namespace App\Controllers;

use App\Controllers\BaseController;

class QuickTest extends BaseController
{
    public function addMember()
    {
        // Test member data
        $testData = [
            'fullname' => 'John Doe',
            'username' => 'johndoe' . rand(1000, 9999),
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
            
        ];
        
        try {
            $db = \Config\Database::connect();
            $result = $db->table('members')->insert($testData);
            $insertedId = $db->insertID();
            
            return json_encode([
                'status' => 'success',
                'message' => 'Member added successfully!',
                'member_id' => $insertedId,
                'username' => $testData['username']
            ], JSON_PRETTY_PRINT);
            
        } catch (\Exception $e) {
            return json_encode([
                'status' => 'error',
                'message' => 'Failed to add member',
                'error' => $e->getMessage()
            ], JSON_PRETTY_PRINT);
        }
    }
    
    public function viewMembers()
    {
        try {
            $db = \Config\Database::connect();
            $members = $db->table('members')->select('user_id, fullname, username, services')->limit(10)->get()->getResultArray();
            
            return json_encode([
                'status' => 'success',
                'total_members' => count($members),
                'members' => $members
            ], JSON_PRETTY_PRINT);
            
        } catch (\Exception $e) {
            return json_encode([
                'status' => 'error',
                'message' => 'Failed to fetch members',
                'error' => $e->getMessage()
            ], JSON_PRETTY_PRINT);
        }
    }
}
?>
