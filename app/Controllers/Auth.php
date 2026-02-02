<?php
namespace App\Controllers;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
?>
