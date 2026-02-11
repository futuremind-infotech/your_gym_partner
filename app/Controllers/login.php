<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Helpers\PasswordHelper;

class Login extends BaseController
{
    public function process(): object
    {
        $username = $this->request->getPost('user');
        $password = $this->request->getPost('pass');

        if (empty($username) || empty($password)) {
            return redirect()->back()->with('error', 'Username and password required');
        }

        $db = \Config\Database::connect();
        $user = $db->table('admin')
            ->where('username', $username)
            ->limit(1)
            ->get()
            ->getRowArray();

        if ($user && PasswordHelper::verify($password, $user['password'])) {
            session()->set([
                'user_id' => $user['user_id'],
                'username' => $username,
                'isLoggedIn' => true,
            ]);
            return redirect()->to('dashboard');
        }

        return redirect()->back()->with('error', 'Invalid credentials');
    }
}
