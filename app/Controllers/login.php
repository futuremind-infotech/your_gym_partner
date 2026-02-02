<?php
namespace App\Controllers;

use App\Controllers\BaseController;

class Login extends BaseController
{
    public function process()
    {
        $username = $this->request->getPost('user');
        $password = md5($this->request->getPost('pass'));
        
        // Replace with your dbcon.php connection details
        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM admin WHERE password=? AND username=?", [$password, $username]);
        $user = $query->getRowArray();
        
        if ($user) {
            session()->set([
                'user_id' => $user['user_id'],
                'username' => $username,
                'isLoggedIn' => true
            ]);
            return redirect()->to('dashboard');
        }
        
        return redirect()->back()->with('error', 'Invalid credentials');
    }
}
