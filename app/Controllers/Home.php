<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function loginPage()
    {
        return view('admin-login/login');
    }
}

