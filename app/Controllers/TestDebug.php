<?php
namespace App\Controllers;

use App\Controllers\BaseController;

class TestDebug extends BaseController
{
    public function members()
    {
        if (! session()->get('isLoggedIn')) {
            return 'NOT LOGGED IN';
        }
        
        $db = \Config\Database::connect();
        
        // Test 1: Count members
        $count = $db->table('members')->countAll();
        
        // Test 2: Get all member IDs
        $ids = $db->table('members')->select('user_id,fullname')->limit(5)->get()->getResultArray();
        
        // Test 3: Try to get member with ID 6
        $member6 = $db->table('members')->where('user_id', 6)->get()->getRowArray();
        
        return json_encode([
            'total_count' => $count,
            'first_5_members' => $ids,
            'member_id_6' => $member6
        ], JSON_PRETTY_PRINT);
    }
}
?>
